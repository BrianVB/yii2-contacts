<?php
namespace yiicontacts\frontend\helpers;

use Yii;

/**
 * Event has functions that are to be used as event handlers for frontend
 * applications using the contact package
 */
class Event
{
    /**
     * Add a link to contact information to the frontend user menu
     * @param \yii\base\Event $event
     * @return void
     */
    static function handleBeforeAccountMenuInit(\yii\base\Event $event): void
    {
        $event->sender->items['contactInfo'] = [
            'label' => 'Contact Info',
            'url' => Yii::$app->user->identity->contact ? ['/contacts/contact/update'] : ['/contacts/contact/create'],
            'position' => 50
        ];
    }
}