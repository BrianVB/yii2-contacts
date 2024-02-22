<?php
namespace yiicontacts\rbac;

/**
 * UpdateContactPermission allows users to update `contact` records 
 * they have created
 */
class UpdateOwnContactPermission extends \yii\rbac\Permission
{
    /**
     * @var string Constant for the name of the permission
     */
    const PERMISSION_NAME = 'updateOwnContact';

    /**
     * {@inheritdoc}
     */
    public $name = self::PERMISSION_NAME;

    /**
     * {@inheritdoc}
     */
    public $ruleName = \bvb\user\common\rbac\ObjectOwnerRule::RULE_NAME;

    /**
     * {@inheritdoc}
     */
    public $description = 'Allows a user to update their own `contact` records';
}