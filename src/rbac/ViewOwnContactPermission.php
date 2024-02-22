<?php
namespace yiicontacts\rbac;

/**
 * ViewOwnContactPermission allows users to view `contact` records
 * they have created
 */
class ViewOwnContactPermission extends \yii\rbac\Permission
{
    /**
     * @var string Constant for the name of the permission
     */
    const PERMISSION_NAME = 'viewOwnContact';

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
    public $description = 'Allows a user to view their own `contact` records';
}