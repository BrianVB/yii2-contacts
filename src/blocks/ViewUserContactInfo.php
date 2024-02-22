<?php
namespace yiicontacts\blocks;

use bvb\yiiwidget\form\FauxField;
use yiicontacts\helpers\Address;
use yiicontacts\helpers\Contact;
use Yii;
use yii\helpers\Html;

/**
 * ViewUserContactInfo displays the contact information for the user in a content box
 */
class ViewUserContactInfo extends \bvb\adminkit\blocks\ContentBox
{
    /**
     * {@inheritdoc}
     */
    public $heading = 'Contact Info';

    /**
     * {@inheritdoc}
     */
    static $defaultInherit = ['model' => 'model'];

    /**
     * @var \bvb\user\common\models\User
     */
    public $model;

    /**
     * {@inheritdoc}
     */
    static $defaultContainers = [
        'column' => [
            'class' => ['col' => 'col-md-6'],
            'position' => -1
        ]
    ];

    /**
     * Adds dropdown config for editing the user if the user has permissions
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if(
            Yii::$app->user->can(\membership\common\rbac\UpdateMemberPermission::PERMISSION_NAME) &&
            $this->model->contact
        ){
            $this->dropdownConfig = [
                'items' => [
                    ['label' => 'Edit Contact Info', 'url' => ['/contacts/contact/update', 'id' => $this->model->contact->id]]
                ]
            ];
        }
    }

    /**
     * Renders some faux inputs for viewing user details
     */
    public function run()
    {
        if(!$this->model->contact){
            return '<i>User has not input any contact info.</i>';
        }

        $return = FauxField::widget([
            'label' => 'Name',
            'value' => Contact::getFullName($this->model->contact, false)
        ]);

        if(Yii::$app->siteOption->get(\yiicontacts\helpers\SiteOption::REQUIRE_ADDRESS)){
            $return .= FauxField::widget([
                'label' => 'Address',
                'inputType' => 'wysiwyg',
                'value' => Address::format($this->model->contact->addresses[0], true)
            ]);
        }

        return $return;
    }
}
