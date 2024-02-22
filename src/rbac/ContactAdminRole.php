<?php
namespace yiicontacts\rbac;

/**
 * ContactAdminRole gives read/write/delete permissions over `contact` records
 */
class ContactAdminRole extends \yii\rbac\Role
{
    /**
     * @var string Constant for the name of the role
     */
    const ROLE_NAME = 'contactAdmin';

    /**
     * {@inheritdoc}
     */
    public $name = self::ROLE_NAME;

    /**
     * {@inheritdoc}
     */
    public $description = 'Has all permissions related to administering `contact` records'; 
}