<?php
namespace yiicontacts\rbac;

/**
 * ContactWriterRole gives access to write `contact` records
 */
class ContactWriterRole extends \yii\rbac\Role
{
    /**
     * @var string Constant for the name of the role
     */
    const ROLE_NAME = 'contactWriter';

    /**
     * {@inheritdoc}
     */
    public $name = self::ROLE_NAME;

    /**
     * {@inheritdoc}
     */
    public $description = 'Has write permissions on `contact` records'; 
}