<?php
namespace yiicontacts\helpers;

use Yii;

/**
 * Adminkit has event handler and helper functions for using the contacts 
 * package in Adminkit themed apps
 */
class Adminkit
{
    /**
     * Show user contact info on view user page if user has permissions
     * @param \yii\base\Event $event 
     * @return void
     */
    static function handleViewUser($event)
    {
        if(Yii::$app->user->can(\yiicontacts\rbac\ViewContactPermission::PERMISSION_NAME)){        
            $event->sender->subBlocks['contactInfoColumn'] = [
                'class' => \yiicontacts\blocks\ViewUserContactInfo::class,
                'position' => 30
            ];
        }
    }

}
