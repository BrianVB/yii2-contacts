<?php

namespace yiicontacts\helpers;

/**
 * SiteOption has constants and configurations for use with the SiteOption
 * package and its component as used by the Contacts package
 */
class SiteOption
{
    /**
     * Key for the option that controls whether or not to 
     * @var string
     */
    const REQUIRE_ADDRESS = 'contacts/requireAddress';

    /**
     * Option configurations for the Content module
     * @var array 
     */
    static $optionsConfig = [
        self::REQUIRE_ADDRESS => [
            'label' => 'Require contact address',
            'hint' => 'Require contacts to provide their address when entering information.',
            'rules' => [['boolean']]
        ],
    ];
}