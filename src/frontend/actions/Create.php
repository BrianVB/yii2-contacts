<?php
namespace yiicontacts\frontend\actions;

use yiicontacts\models\Contact;
use Yii;

/**
 * Create is the action to create a new contact.
 */
class Create extends \yiivue\actions\Create
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
     * {@inheritdoc}
     */
    public $authItem = \bvb\user\common\rbac\UserUnderTermsRole::ROLE_NAME;

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