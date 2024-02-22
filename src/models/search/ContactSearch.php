<?php

namespace yiicontacts\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yiicontacts\models\Contact;

/**
 * ContactSearch represents the model behind the search form about `yiicontacts\models\Contact`.
 */
class ContactSearch extends Contact
{
    /**
     * Attempt at way to make this searchable
     * https://www.yiiframework.com/doc/guide/2.0/en/output-data-widgets#working-with-model-relations
     * {@inheritdoc}
     */
    public function attributes()
    {
        $attributes = parent::attributes();
        if(Yii::$app->siteOption->get(\yiicontacts\helpers\SiteOption::REQUIRE_ADDRESS)){
            // --- add related fields to searchable attributes
            $attributes = array_merge($attributes, ['defaultAddress.state_id','defaultAddress.country_id']);
        }
        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            [['id', 'user_id'], 'integer'],
            [['given_name', 'middle_name', 'family_name', 'create_time', 'update_time'], 'safe'],
        ];

        if(Yii::$app->siteOption->get(\yiicontacts\helpers\SiteOption::REQUIRE_ADDRESS)){
            $rules[] = [['defaultAddress.state_id', 'defaultAddress.country_id'], 'integer'];
        }

        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'defaultAddress.state.name' => 'State',
            'defaultAddress.country.name' => 'Country',
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Contact::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => [
                'id' => SORT_DESC
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'contact.user_id' => $this->user_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'given_name', $this->given_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'family_name', $this->family_name]);

        if(Yii::$app->siteOption->get(\yiicontacts\helpers\SiteOption::REQUIRE_ADDRESS)){
            $query->joinWith(['defaultAddress', 'defaultAddress.state', 'defaultAddress.country']);
            $query->andFilterWhere(['defaultAddress.state_id' => $this->getAttribute('defaultAddress.state_id')])
                ->andFilterWhere(['defaultAddress.country_id' => $this->getAttribute('defaultAddress.country_id')]);
            $dataProvider->getSort()->attributes['defaultAddress.state_id'] = [
                'asc' => ['state.name' => SORT_ASC],
                'desc' => ['state.name' => SORT_DESC],
            ];
            $dataProvider->getSort()->attributes['defaultAddress.country_id'] = [
                'asc' => ['country.name' => SORT_ASC],
                'desc' => ['country.name' => SORT_DESC],
            ];
        }

        return $dataProvider;
    }
}
