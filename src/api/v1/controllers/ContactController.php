<?php
namespace yiicontacts\api\v1\controllers;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * ContactController has endpoints for CRUD operations on Contact models and 
 * their related records in the `contact` table
 */
class ContactController extends \yii\rest\ActiveController
{
    /**
     * {@inheritdoc}
     */
    public $modelClass = \yiicontacts\models\Contact::class;

    /**
     * Sets up RBAC for each action
     * {@inheritdoc}
     */
    public function actions()
    {
        $actions = parent::actions();

        unset($actions['index']);
        unset($actions['delete']);
        unset($actions['view']);

        $actions['create']['checkAccess'] = function($actionId){
            if(!Yii::$app->user->can(\yiicontacts\rbac\CreateContactPermission::PERMISSION_NAME)){
                throw new ForbiddenHttpException('Creating contact not authorized');
            }
        };
        $actions['update']['checkAccess'] = function($actionId, $model){
            if(!Yii::$app->user->can(
                \yiicontacts\rbac\UpdateContactPermission::PERMISSION_NAME,
                ['user_id' => $model->created_by]
            )){
                throw new ForbiddenHttpException('Updating contact not authorized');
            }
        };

        return $actions;
    }
}