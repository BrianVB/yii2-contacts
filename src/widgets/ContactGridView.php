<?php
namespace yiicontacts\widgets;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yiilocation\models\Address;
use yiilocation\models\Country;
use yiilocation\models\State;

/**
 * Implements the default columns for the contact grid view
 */
class ContactGridView extends \bvb\adminkit\grid\GridView
{
    /**
     * {@inheritdoc}
     */
    static function getDefaultColumns()
    {
        $columns = [
            'serial' => ['class' => 'yii\grid\SerialColumn'],
            'user' => [
                'class' => \bvb\user\backend\grid\SearchUsersColumn::class,
                'attribute' => 'user_id',
                'searchUrl' => Url::to(['search-users'])
            ],
            'givenName' => 'given_name',
            'familyName' => 'family_name',
        ];

        $requireAddress = Yii::$app->siteOption->get(\yiicontacts\helpers\SiteOption::REQUIRE_ADDRESS);
        if($requireAddress){
            $addressTable = Address::tablename();
            $countryTable = Country::tablename();
            $stateTable = State::tablename();
            $stateProvinces = ArrayHelper::map(
                (new Query)
                    ->select([$stateTable.'.id', $stateTable.'.name'])
                    ->from($stateTable)
                    ->innerJoin($addressTable, '`'.$addressTable.'`.`state_id`=`'.$stateTable.'`.`id`')
                    ->orderBy($stateTable.'.name')
                    ->all(),
                'id',
                'name'
            );

            $columns['memberState'] = [
                'label' => 'State / Province',
                'attribute' => 'defaultAddress.state_id',
                'visible' => $requireAddress,
                'value' => function($model){
                    return ($model->defaultAddress) ?
                        $model->defaultAddress->state->name : 
                        null;
                },
                'position' => 45,
                'filter' => $stateProvinces
            ];

            $countries = ArrayHelper::map(
                (new Query)
                    ->select([$countryTable.'.id', $countryTable.'.name'])
                    ->from($countryTable)
                    ->innerJoin($addressTable, '`'.$addressTable.'`.`country_id`=`'.$countryTable.'`.`id`')
                    ->orderBy($countryTable.'.name')
                    ->all(),
                'id',
                'name'
            );

            $columns['memberCountry'] = [
                'label' => 'Country',
                'attribute' => 'defaultAddress.country_id',
                'visible' => $requireAddress,
                'value' => function($model){
                    return ($model->defaultAddress) ?
                        $model->defaultAddress->country->name : 
                        null;
                },
                'position' => 45,
                'filter' => $countries
            ];
        }

        return array_merge($columns, [
            'createTime' => 'create_time',
            'dropdownColumn' => [
                'class' => \bvb\adminkit\grid\DropdownColumn::class,
                'itemsOrder' => ['update', 'delete'],
            ]
        ]);
    }
}