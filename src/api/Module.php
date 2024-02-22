<?php
namespace yiicontacts\api;

/**
 * Module provides base routing, sets up versioned submodules, and forces provides
 * certain protections for requests along with formatting
 */
class Module extends \yii\base\Module
{
    use \yiiutils\TraitApiModule;

    /**
     * @var boolean Whether using for frontend applications. For frontend
     * applications, this module uses different actions based on the user
     * only using it to update their own records
     */
    public $frontend = true;
}