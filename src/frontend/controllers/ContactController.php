<?php
namespace yiicontacts\frontend\controllers;

use yii\helpers\ArrayHelper;

/**
 * ContactController is for creating and saving contacts by frontend users
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
    public $modelConfig = [ 'class' => \yiicontacts\models\Contact::class ];

    /**
     * {@inheritdoc}
     */
    public $formBlock = [ 'class' => \yiicontacts\frontend\blocks\Save::class ];
 
    /**
     * {@inheritdoc}
     */
    public $formAssetBundle = [ 'class' => \yiicontacts\frontend\assets\Save::class ];
    
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        unset(
            $actions['index'],
            $actions['delete']
        );
        return ArrayHelper::merge($actions, [
            'create' => ['class' => \yiicontacts\frontend\actions\Create::class],
            'update' => ['class' => \yiicontacts\frontend\actions\Update::class]
        ]);
    }
}
