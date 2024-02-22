<?php
namespace yiicontacts\frontend;

use yiicontacts\frontend\helpers\Event;
use yii\base\Event as  YiiEvent;
use yiiutils\Helper;

/**
 * Does bootstrapping for when contacts package functionality is needed in the
 * context of frontend applications
 */
class Bootstrap implements \yii\base\BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public function bootstrap($app)
    {
        // --- Apply module configuration
        Helper::applyDefaultModuleConfig($app, 'contacts', '', ['class' => \yiicontacts\frontend\Module::class]);

        // --- Register these event handlers
        $handlers = [
            [
                'class' => \bvb\user\frontend\widgets\AccountMenu::class,
                'event' => \bvb\user\frontend\widgets\AccountMenu::EVENT_INIT,
                'handler' => [\yiicontacts\frontend\helpers\Event::class, 'handleBeforeAccountMenuInit']
            ],
        ];
        foreach($handlers as $handlerData){
            YiiEvent::on(
                $handlerData['class'],
                $handlerData['event'],
                $handlerData['handler']
            );
        }
    }
}