<?php
namespace yiicontacts\rbac;

/**
 * ContactReaderRole gives access to read `contact` records
 */
class ContactReaderRole extends \yii\rbac\Role
{
    /**
     * @var string Constant for the name of the role
     */
    const ROLE_NAME = 'contactReader';

    /**
     * {@inheritdoc}
     */
    public $name = self::ROLE_NAME;

    /**
     * {@inheritdoc}
     */
    public $description = 'Has read permissions on `contact` records'; 
}