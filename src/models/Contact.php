<?php
namespace yiicontacts\models;

use Yii;
use yiilocation\models\Address;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $given_name
 * @property string $middle_name
 * @property string $family_name
 * @property integer $primary
 * @property integer $active
 * @property integer $visibility
 * @property string $create_time
 * @property string $update_time
 *
 * @property User $user
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * Add blameable behavior
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'blameable' => [
                'class' => \yii\behaviors\BlameableBehavior::class,
                'defaultValue' => \bvb\user\common\helpers\UserHelper::SYSTEM_USER_ID
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['given_name', 'family_name'], 'required'],
            [['given_name', 'middle_name'], 'string', 'max' => 50],
            [['title', 'suffix'], 'string', 'max' => 25],
            [['family_name'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->user->identityClass, 'targetAttribute' => ['user_id' => 'id']],
            [['default_address_id'], 'exist', 'skipOnError' => true, 'targetClass' => \yiilocation\models\Address::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'given_name' => 'The name given to you by the parents when a child is born',
            'middle_name' => 'Another name given by the parents to a child',
            'family_name' => 'The name of the family lineage',
            'suffix' => 'Optional suffix for after the family name',
            'title' => 'Optional title to be addressed by',
            'user_id' => 'The user account associated with this contact',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::class, ['contact_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultAddress()
    {
        return $this->hasOne(Address::class, ['contact_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }
}
