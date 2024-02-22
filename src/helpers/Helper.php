<?php
namespace yiicontacts\helpers;

use yiiutils\Helper as UtilityHelper;

/**
 * Helper has basic funcitons to help configure and use the Contact package
 * in applications
 */
class Helper
{
    /**
     * Registeres the contact module along with the API module
     * @param string $moduleClass The classname for the module. Defaults to the
     * frontend version since that one will be more restricted security-wise
     */
    static function registerModule(
        \yii\base\Application $app, 
        string $moduleClass = \yiicontacts\frontend\Module::class
    ): void {
        // --- Apply module configuration
        UtilityHelper::applyDefaultModuleConfig($app, 'contacts', '', [
            'class' => $moduleClass,
            'modules' => [
                'api' => [
                    'class' => \yiicontacts\api\Module::class,
                    'modules' => [
                        'v1' => [
                            'class' => \yiicontacts\api\v1\Module::class
                        ]
                    ]
                ]
            ]
        ]);

        // --- Add REST rules for api module
        UtilityHelper::applyDefaultComponentConfig($app, 'urlManager', 'rules', [[
            'class' => \yii\rest\UrlRule::class,
            'controller' => [
                'contacts/api/v1/contact'
            ]
        ]]);
    }
}