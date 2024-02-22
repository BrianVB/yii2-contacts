<?php
namespace yiicontacts\rbac;

/**
 * UpdateContactPermission allows users with this permission to to update
 * `contact` records
 */
class UpdateContactPermission extends \yii\rbac\Permission
{
    /**
     * @var string Constant for the name of the permission
     */
    const PERMISSION_NAME = 'updateContact';

    /**
     * {@inheritdoc}
     */
    public $name = self::PERMISSION_NAME;

    /**
     * {@inheritdoc}
     */
    public $description = 'Allows a user to update `contact` records';
}