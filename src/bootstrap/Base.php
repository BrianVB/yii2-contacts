<?php
namespace yiicontacts\bootstrap;

use yiiutils\Helper;

/**
 * Base does bootstrapping for the Contact package by any applications using it
 */
class Base implements \yii\base\BootstrapInterface
{
    /**
     * Register events and do any other work to bootstrap the user module
     * @return void
     */
    public function bootstrap($app)
    {
        // --- Add a dynamic relation for the executedTermsSignature to the
        // --- model registry for the DocGenerated class
        Helper::applyDefaultComponentConfig(
            $app, 
            'modelRegistry', 
            'registry.'.\bvb\user\common\models\User::class.'.relations',
            [
                'contact' => function(){
                    return $this->hasOne(\yiicontacts\models\Contact::class, ['user_id' => 'id']);
                }
            ]
        );

        // --- Add a dynamic relation for the contact to the model registry for
        // --- the \yiilocation\models\Address class
        Helper::applyDefaultComponentConfig(
            $app, 
            'modelRegistry', 
            'registry.'.\yiilocation\models\Address::class.'.relations',
            [
                'contact' => function(){
                    return $this->hasOne(\yiicontacts\models\Contact::class, ['id' => 'contact_id']);
                }
            ]
        );
    }
}