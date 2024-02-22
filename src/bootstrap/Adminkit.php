<?php
namespace yiicontacts\bootstrap;

use bvb\adminkit\helpers\Event;
use yiicontacts\helpers\Adminkit as AdminkitHelper;
use yiicontacts\helpers\Helper;
use yii\base\Event as YiiEvent;

/**
 * Adminkit does bootstrapping for the Contact package for applications using
 * the Adminkit theme
 */
class Adminkit implements \yii\base\BootstrapInterface
{
    /**
     * Register events and do any other work to bootstrap the user module
     * @return void
     */
    public function bootstrap($app)
    {
        // --- Register the module along with the API and its URL rules
        Helper::registerModule($app, \yiicontacts\Module::class);

        // --- Add sidebar item
        Event::registerSidenavItem('contacts', [
            'label' => 'Contacts',
            'fontAwesomeIconClass' => 'fas fa-users',
            'url' => ['/contacts/contact/index'],
            'position' => 800
        ]);

        // --- Register these event handlers
        $handlers = [
            [
                'class' => \bvb\user\backend\blocks\ViewUser::class,
                'event' => \yiiblock\helpers\Helper::EVENT_BEFORE_PROCESS_SUBBLOCKS,
                'handler' => [AdminkitHelper::class, 'handleViewUser']
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