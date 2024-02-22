<?php
namespace yiicontacts\rbac;

/**
 * Allows a user to create `contact` records
 */
class CreateContactPermission extends \yii\rbac\Permission
{
    /**
     * @var string Constant for the name of the permission
     */
    const PERMISSION_NAME = 'createContact';

    /**
     * {@inheritdoc}
     */
    public $name = self::PERMISSION_NAME;

    /**
     * {@inheritdoc}
     */
    public $description = 'Allows a user to create `contact` records';
}