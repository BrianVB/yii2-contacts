<?php
namespace yiicontacts\rbac;

/**
 * Allows a user to list `contact` records
 */
class ListContactsPermission extends \yii\rbac\Permission
{
    /**
     * @var string Constant for the name of the permission
     */
    const PERMISSION_NAME = 'listContacts';

    /**
     * {@inheritdoc}
     */
    public $name = self::PERMISSION_NAME;

    /**
     * {@inheritdoc}
     */
    public $description = 'Allows a user to list `contact` records';
}