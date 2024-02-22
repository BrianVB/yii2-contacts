<?php
namespace yiicontacts\frontend\actions;

use yiicontacts\models\Contact;
use Yii;

/**
 * Save is the action to save contact information. It can be used to add contact
 * info for a user, or to update a user's existing contact information
 */
class Add extends \yiivue\actions\Create
{
    /**
     * {@inheritdoc}
     */
    public $assetBundle = \yiicontacts\frontend\assets\Save::class;

    /**
     * {@inheritdoc}
     */
    public $block = \yiicontacts\frontend\blocks\Save::class;

    /**
     * Displays a form for a user to add their contact information or update
     * their existing contact information
     * @return string
     */
    public function prepareBlockParams($params = [])
    {
        return parent::prepareBlockParams(array_merge($params, ['mode' => \yiicontacts\frontend\helpers\Helper::SAVE_MODE_CREATE]));
    }
}