<?php
namespace yiicontacts\console\migrations;

use yii\db\Query;

/**
 * Handles the creation of table `{{%contact}}`. Since the creation of this
 * this package stems from the original brianvb/yii2-membership package, before
 * it installs the table it will check to see if the existing `member` table
 * exists and if it does it will rename it instead.
 */
class M231003032039CreateContactTable extends \yii\db\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(
            $this->hasMemberTableMigration() &&
            $this->hasMemberTable()
        ){
            $this->migrateFromMember();
        } else {
            $this->initializeContactSchemaParts();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if($this->hasMemberTableMigration()){
            $this->migrateBackToMember();
        } else {
            $this->dropContactSchemaParts();
        }
    }

    /**
     * Get whether there is an existing member table in the database
     * @return boolean
     */
    protected function hasMemberTable()
    {
        $memberTableSchema = $this->getDb()->getSchema()->getTableSchema('member');
        return $memberTableSchema !== null;
    }

    /**
     * Check whether there is a migration in the database for the membership
     * package's member table creation
     * @return boolean
     */
    protected function hasMemberTableMigration()
    {
        $memberTableMigrationApplyTime = (new Query)->select(['apply_time'])
            ->from('migration')
            ->where(['version' => 'membership\console\migrations\deprecated\M211001170005CreateMemberTable'])
            ->scalar();
        return !empty($memberTableMigrationApplyTime);
    }

    /**
     * Creates the `contact` table
     * @return void
     */
    protected function initializeContactSchemaParts()
    {
        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'given_name' => $this->string(50)->notNull(),
            'middle_name' => $this->string(50)->null(),
            'family_name' => $this->string(100)->notNull(),
            'locked' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addContactForeignKey();
    }

    /**
     * Drops the contact schema parts. 
     * @return void
     */
    protected function dropContactSchemaParts()
    {
        $this->dropContactForeignKey();

        $this->dropTable('{{%contact}}');
    }

    /**
     * Renames the `member` table to `contact`
     * @return void
     */
    protected function migrateFromMember()
    {
        $this->renameTable('member', 'contact');

        $this->dropColumn('{{%contact}}', 'primary');
        $this->dropColumn('{{%contact}}', 'active');
        $this->dropColumn('{{%contact}}', 'affirmed');
        $this->dropColumn('{{%contact}}', 'visibility');
        $this->dropColumn('{{%contact}}', 'locked');

        // --- Drop indexes that had 'member' in name
        $this->dropForeignKey(
            '{{%fk-member-user_id}}',
            '{{%contact}}'
        );
        $this->dropIndex(
            '{{%idx-member-user_id}}',
            '{{%contact}}'
        );

        $this->addContactForeignKey();
    }

    /**
     * Reverts the `contact` table back to the `member` table that was originally
     * created by the membership package
     * @return void
     */
    protected function migrateBackToMember()
    {
        $this->dropContactForeignKeys();

        $this->renameTable('contact', 'member');

        $this->createIndex(
            '{{%idx-member-user_id}}',
            '{{%member}}',
            'user_id'
        );
        $this->addForeignKey(
            '{{%fk-member-user_id}}',
            '{{%member}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'SET NULL'
        );
    }

    /**
     * Adds index and foreign key from contact table to user
     * @return void
     */
    protected function addContactForeignKey()
    {
        $this->createIndex(
            '{{%idx-contact-user_id}}',
            '{{%contact}}',
            'user_id'
        );
        $this->addForeignKey(
            '{{%fk-contact-user_id}}',
            '{{%contact}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'SET NULL'
        );
    }

    /**
     * Drops foreign keys for contact
     * @return void
     */
    public function dropContactForeignKeys()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-contact-user_id}}',
            '{{%contact}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-contact-user_id}}',
            '{{%contact}}'
        );
    }
}
