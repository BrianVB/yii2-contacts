<?php

namespace yiicontacts\controllers;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * ContactController is for all of the CRUD actions related to Conttact models
 * and their related records in the db
 */
class ContactController extends \yiivue\controllers\ActiveController
{
    /**
     * Redirects not logged in users to the login screen
     */
    use \bvb\user\common\controllers\traits\RequireLoggedInTrait;

    /**
     * {@inheritdoc}
     */
    public $modelConfig = ['class' => \yiicontacts\models\Contact::class];

    /**
     * {@inheritdoc}
     */
    public $searchModelConfig = ['class' => \yiicontacts\models\search\ContactSearch::class];

    /**
     * {@inheritdoc}
     */
    public $formBlock = ['class' => \yiicontacts\blocks\Save::class];

    /**
     * {@inheritdoc}
     */
    public $formAssetBundle = ['class' => \yiicontacts\assets\Save::class];

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        $actions = parent::actions();

        // --- Add the export
        $actions['export'] = [
            'class' => \bvb\crud\actions\Export::class,
            'modelClass' =>  $this->modelConfig['class'],
            'searchModelClass' =>  $this->searchModelConfig['class'],
            'authItem' => \yiicontacts\rbac\ViewContactPermission::PERMISSION_NAME,
            'on '.\bvb\crud\actions\Export::EVENT_AFTER_GET_COLUMNS => [self::class, 'handleAfterGetColumns']
        ];

        return ArrayHelper::merge($actions, [
            'index' => [
                'authItem' => \yiicontacts\rbac\ViewContactPermission::PERMISSION_NAME,
                'block' => \yiicontacts\blocks\ContactIndex::class,
            ],
            'create' => ['authItem' => \yiicontacts\rbac\CreateContactPermission::PERMISSION_NAME],
            'update' => ['authItem' => \yiicontacts\rbac\UpdateContactPermission::PERMISSION_NAME],
            'delete' => ['authItem' => \yiicontacts\rbac\DeleteContactPermission::PERMISSION_NAME],
            'search-users' => [
                'class' => \bvb\user\common\actions\Search::class,
                'limit' => 25,
                'checkAccess' => function(){
                    if(!Yii::$app->user->can(\yiicontacts\rbac\ViewContactPermission::PERMISSION_NAME)){
                        throw new ForbiddenHttpException('Searching for users not authorized');
                    }
                }
            ]
        ]);
    }

    /**
     * Adjust columns to be more than what's in the grid
     * @param \yii\base\Event $event
     * @return void
     */
    static function handleAfterGetColumns($event)
    {
        // --- Make user_id column into the email and ad address columns
        // --- if we're using it
        $columns = $event->sender->getColumns();
        for($i=0; $i < count($columns); $i++){
            if (in_array($columns[$i], [
                'default_address_id',
                'defaultAddress.state_id',
                'defaultAddress.country_id',
            ])) {
                unset($columns[$i]);
                continue;
            }

            // --- Change user id to user.email for export display
            if($columns[$i] == 'user_id'){
                $columns[$i] = 'user.email';
            }


            if(
                // --- If using addresses
                Yii::$app->siteOption->get(\yiicontacts\helpers\SiteOption::REQUIRE_ADDRESS) &&
                // --- And if the col is state_id
                $columns[$i] == 'suffix'
            ){
                $columns[] = 'defaultAddress.address1';
                $columns[] = 'defaultAddress.address2';
                $columns[] = 'defaultAddress.city';
                $columns[] = 'defaultAddress.state.name';
                $columns[] = 'defaultAddress.postal_code';
                $columns[] = 'defaultAddress.country.name';
            }
        }

        $event->sender->setColumns($columns);
    }
}
