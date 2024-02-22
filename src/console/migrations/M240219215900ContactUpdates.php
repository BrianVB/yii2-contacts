<?php
namespace yiicontacts\console\migrations;

use Yii;
use yiilocation\models\Address;
use yiilocation\helpers\Migration;

/**
 * Class M240219215900ContactUpdates performs updates to the contact table
 * which are a result of us making this separate from the old `member` table
 * . It adds the `default_address_id` column, modifies the address table to
 * reference a `contact_id` if needed, and adds the `created_by` and `updated_by`
 * columns for vetting data
 */
class M240219215900ContactUpdates extends \yii\db\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contact}}', 'default_address_id', $this->integer()->null()->after('suffix'));

        // creates index for column `vimeo_medidefault_address_ida_id`
        $this->createIndex(
            '{{%idx-contact-default_address_id}}',
            '{{%contact}}',
            'default_address_id'
        );

        // add foreign key for table `{{%address}}`
        $this->addForeignKey(
            '{{%fk-contact-default_address_id}}',
            '{{%contact}}',
            'default_address_id',
            '{{%loc_address}}',
            'id',
            'SET NULL'
        );

        $this->addColumn('{{%contact}}', 'created_by', $this->integer()->notNull()->after('default_address_id'));
        $this->addColumn('{{%contact}}', 'updated_by', $this->integer()->notNull()->after('created_by'));

        // --- Since this could be migrating from the membership package
        // --- first we want to check for the existence of this column
        // --- and its index / fk before trying to create them.
        $addressAttributes = Address::instance()->attributes;
        if(!array_key_exists('contact_id', $addressAttributes)){
            $this->addColumn('{{%loc_address}}', 'contact_id', $this->integer()->notNull()->after('id'));

            $this->createIndex(
                '{{%idx-loc_address-contact_id}}',
                '{{%loc_address}}',
                'contact_id'
            );
            $this->addForeignKey(
                '{{%fk-loc_address-contact_id}}',
                '{{%loc_address}}',
                'contact_id',
                '{{%contact}}',
                'id',
                'CASCADE'
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // --- If the address migration data indicates it was migrated from
        // --- the membership package we don't need to undo the adding
        // --- of the contact data since its own package takes care of that
        $addressMigrationIndictesWasFromMembership = Migration::addressMigrationApplyTimeIndicatesMemberAddress(
            Yii::$app->controller->migrationTable, 
            self::class
        );
        if(!$addressMigrationIndictesWasFromMembership){
            $this->dropForeignKey(
                '{{%fk-loc_address-contact_id}}',
                '{{%loc_address}}'
            );

            $this->dropIndex(
                '{{%idx-loc_address-contact_id}}',
                '{{%loc_address}}'
            );

            $this->dropColumn('{{%loc_address}}', 'contact_id');
        }

        $this->dropColumn('{{%contact}}', 'created_by');
        $this->dropColumn('{{%contact}}', 'updated_by');

        // drops foreign key for table `{{%default_address_id}}`
        $this->dropForeignKey(
            '{{%fk-contact-default_address_id}}',
            '{{%contact}}'
        );

        // drops index for column `default_address_id`
        $this->dropIndex(
            '{{%idx-contact-default_address_id}}',
            '{{%contact}}'
        );

        $this->dropColumn('{{%contact}}', 'default_address_id');
    }
}
    