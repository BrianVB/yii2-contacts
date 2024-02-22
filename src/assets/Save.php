<?php
namespace yiicontacts\assets;

use Yii;

/**
 * Asset for the saving a user's contact info. Works both for creating or
 * updating a user's existing details
 */
class Save extends \yiivue\assets\VueAppAssetBundle
{
    /**
     * {@inheritdoc}
     */
    public $sourcePath = '@yiicontacts/assets/public/js';

    /**
     * {@inheritdoc}
     */
    public $destinationPath = 'yiicontacts';

    /**
     * {@inheritdoc}
     */
    public $js = [
        [
            'apps/Save.js',
            'type' => 'module',
        ]
    ];

    public $depends = [
        'formCss' => \yiiform\assets\CssAsset::class,
        'formJs' => \yiiform\assets\VueSuiteAsset::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function prepareAppData($options)
    {
        // --- Use model attributes in Vue app data
        $contact = $options['model'];

        // --- Pass in user in format needed for the SelectDropdown to be
        // --- pre-populated with data if it exists
        $userSelection = null;
        if(!empty($contact->user_id)){
            $userSelection = [
                'value' => $contact->user_id,
                'label' => $contact->user ? $contact->user->email : ''
            ];
        }
        $this->registerVueAppData([
            'contact' => $contact->attributes,
            'userSelection' => $userSelection
        ]);
    }
}
