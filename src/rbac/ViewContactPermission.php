<?php
namespace yiicontacts\rbac;

/**
 * ViewContactPermission allows users to update view `contact` records
 */
class ViewContactPermission extends \yii\rbac\Permission
{
    /**
     * @var string Constant for the name of the permission
     */
    const PERMISSION_NAME = 'viewContact';

    /**
     * {@inheritdoc}
     */
    public $name = self::PERMISSION_NAME;

    /**
     * {@inheritdoc}
     */
    public $description = 'Allows a user to view `contact` records';
}