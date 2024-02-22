<?php
namespace yiicontacts\models;

/**
 * This is the model class for table "contact_address".
 *
 * @property integer $id
 * @property integer $contact_id
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property integer $state_id
 * @property string $postal_code
 * @property integer $country_id
 * @property string $create_time
 * @property string $update_time
 *
 * @property Country $country
 * @property Contact $contact
 * @property State $state
 */
class ContactAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact_id', 'address1', 'city', 'state_id', 'country_id'], 'required'],
            [['contact_id', 'state_id', 'country_id'], 'integer'],
            [['address1', 'address2'], 'string', 'max' => 150],
            [['city'], 'string', 'max' => 75],
            [['postal_code'], 'string', 'max' => 25],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => \yiiutils\location\Country::class, 'targetAttribute' => ['country_id' => 'id']],
            [['contact_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contact::class, 'targetAttribute' => ['contact_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => \yiiutils\location\State::class, 'targetAttribute' => ['state_id' => 'id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'address1' => 'Address',
            'address2' => 'Address Line 2',
            'country_id' => 'Country',
            'postal_code' => 'Zip / Postal Code',
            'state_id' => 'State / Province',
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'state_id' => 'The state or province you live in for your selected country. Choose the country first, and the apporpriate states will be populated here.',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(\yiilocation\models\Country::class, ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(Contact::class, ['id' => 'contact_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(\yiilocation\models\State::class, ['id' => 'state_id']);
    }
}
