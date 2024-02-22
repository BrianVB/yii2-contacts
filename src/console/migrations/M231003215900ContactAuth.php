<?php
namespace yiicontacts\console\migrations;

use Yii;
use yiicontacts\rbac\CreateContactPermission;
use yiicontacts\rbac\DeleteContactPermission;
use yiicontacts\rbac\ListContactsPermission;
use yiicontacts\rbac\ContactAdminRole;
use yiicontacts\rbac\ContactReaderRole;
use yiicontacts\rbac\ContactWriterRole;
use yiicontacts\rbac\UpdateContactPermission;
use yiicontacts\rbac\UpdateOwnContactPermission;
use yiicontacts\rbac\ViewContactPermission;
use yiicontacts\rbac\ViewOwnContactPermission;
use bvb\user\common\rbac\AdminRole;
use bvb\user\common\rbac\LoggedInUserRole;

/**
 * Class M231003215900ContactAuth creates the RBAC roles and permissions for
 * doing CRUD operations and managing `contact` records
 */
class M231003215900ContactAuth extends \yii\db\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // --- Get auth manager and super admin role
        $auth = Yii::$app->authManager;
        $adminRole = new AdminRole;
        $loggedInUserRole = new LoggedInUserRole;

        /*****************
         * ADMIN
         *****************/
        // --- Add Contact admin
        $contactAdminRole = new ContactAdminRole;
        $auth->add($contactAdminRole);

        // --- Add Contact admin role as child of super admin role
        $auth->addChild($adminRole, $contactAdminRole);

        /*******
         * DELETE PERMISSION
         *******/
        // --- Make a permission for deleting `contact` records
        $deleteContactPermission = new DeleteContactPermission;
        $auth->add($deleteContactPermission);

        // --- Assign permission to Contact admin
        $auth->addChild($contactAdminRole, $deleteContactPermission);

        /*****************
         * WRITER
         *****************/
        $writerRole = new ContactWriterRole;
        $auth->add($writerRole);

        // --- Make writer child of admin so admin gets write permissions
        $auth->addChild($contactAdminRole, $writerRole);

        /*******
         * CREATE PERMISSION
         *******/
        // --- Make a permission for creating `contact` records
        $createContactPermission = new CreateContactPermission;
        $auth->add($createContactPermission);

        // --- Assign create permission to writer role
        $auth->addChild($writerRole, $createContactPermission);

        /*******
         * UPDATE PERMISSION
         *******/
        // --- Make a permission for updating `contact` records
        $updateContactPermission = new UpdateContactPermission;
        $auth->add($updateContactPermission);

        // --- Assign permission to writer role
        $auth->addChild($writerRole, $updateContactPermission);

        // --- Create permission for updating own `contact` records
        $updateOwnContactPermission = new UpdateOwnContactPermission;
        $auth->add($updateOwnContactPermission);

        // --- Make update a child of updateOwn to give a path so we can use
        // --- update it will pass through to updateOwn
        $auth->addChild($updateOwnContactPermission, $updateContactPermission);

        // --- Allow the logged in user to update their own `contact` records
        $auth->addChild($loggedInUserRole, $updateOwnContactPermission);


        /*****************
         * READER
         *****************/
        $readerRole = new ContactReaderRole;
        $auth->add($readerRole);

        // --- Make reader child of writer so writer gets read permissions
        $auth->addChild($writerRole, $readerRole);

        /*******
         * VIEW PERMISSION
         *******/
        // --- Make a permission for viewing
        $viewContactPermission = new ViewContactPermission;
        $auth->add($viewContactPermission);

        // --- Assign view permission to readers
        $auth->addChild($readerRole, $viewContactPermission);

        // --- Create permission for viewing own
        $viewOwnContactPermission = new ViewOwnContactPermission;
        $auth->add($viewOwnContactPermission);

        // --- Make view permission a child of viewOwn to give a path so we can
        // --- use view it will pass through to viewOwn
        $auth->addChild($viewOwnContactPermission, $viewContactPermission);

        // --- Allow the logged in user to view their own
        $auth->addChild($loggedInUserRole, $viewOwnContactPermission);

        /*******
         * LIST PERMISSION
         *******/
        // --- Make permission for listing
        $listContactsPermission = new ListContactsPermission;
        $auth->add($listContactsPermission);

        // --- Add to reader
        $auth->addChild($readerRole, $listContactsPermission);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        /*******
         * LIST PERMISSION
         *******/
        $listContactsPermission = new ListContactsPermission;
        $auth->remove($listContactsPermission);

        /*******
         * VIEW PERMISSION
         *******/
        $viewOwnContactPermission = new ViewOwnContactPermission;
        $auth->remove($viewOwnContactPermission);

        $viewContactPermission = new ViewContactPermission;
        $auth->remove($viewContactPermission);

        /*****************
         * READER
         *****************/
        $readerRole = new ContactReaderRole;
        $auth->remove($readerRole);

        /*******
         * UPDATE PERMISSION
         *******/
        $updateOwnContactPermission = new UpdateOwnContactPermission;
        $auth->remove($updateOwnContactPermission);

        $updateContactPermission = new UpdateContactPermission;
        $auth->remove($updateContactPermission);

        /*******
         * CREATE PERMISSION
         *******/
        $createContactPermission = new CreateContactPermission;
        $auth->remove($createContactPermission);

        /*****************
         * WRITER
         *****************/
        $writerRole = new ContactWriterRole;
        $auth->remove($writerRole);

        /*******
         * DELETE PERMISSION
         *******/
        $deleteContactPermission = new DeleteContactPermission;
        $auth->remove($deleteContactPermission);

        /*****************
         * ADMIN
         *****************/
        $contactAdminRole = new ContactAdminRole;
        $adminRole = new AdminRole;
        $auth->removeChild($adminRole, $contactAdminRole);
        $auth->remove($contactAdminRole);
    }
}
