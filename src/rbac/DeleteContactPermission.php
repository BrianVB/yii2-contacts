<?php
namespace yiicontacts\rbac;

/**
 * Allows a user to delete `contact` records
 */
class DeleteContactPermission extends \yii\rbac\Permission
{
    /**
     * @var string Constant for the name of the permission
     */
    const PERMISSION_NAME = 'deleteContact';

    /**
     * {@inheritdoc}
     */
    public $name = self::PERMISSION_NAME;

    /**
     * {@inheritdoc}
     */
    public $description = 'Allows a user to delete `contact` records';
}