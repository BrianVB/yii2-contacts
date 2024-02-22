<?php
namespace yiicontacts\frontend\assets;

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
    public $sourcePath = '@yiicontacts/frontend/assets/public/js';

    /**
     * {@inheritdoc}
     */
    public $destinationPath = 'yiicontactsfront';

    /**
     * {@inheritdoc}
     */
    public $js = [
        [
            'apps/Save.js',
            'type' => 'module',
        ]
    ];

    /**
     * {@inheritdoc}
     */
    public function prepareAppData($options)
    {
        $this->registerVueAppData($options);
    }
}
