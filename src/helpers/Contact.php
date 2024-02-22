<?php
namespace yiicontacts\helpers;

/**
 * Contact contains functions related to Contact models and their related
 * records
 */
class Contact
{
    /**
     * @var array Possible values for the `title` field on the `member` table
     */
    static $titles = [
        'Mr',
        'Ms',
        'Mrs',
    ];

    /**
     * @var array Possible values for the `suffix`
     */
    static $suffixes = [
        'Jr',
        'Sr',
        'II',
        'III',
        'IV'
    ];

    /**
     * Gets the full name of the member
     * @param array|yiicontacts\models\Contact $contact
     * @param boolean $includeTitle Whether to include the contact's title
     * @param boolean $includeSuffix Whether to include the contact's suffix
     * @return string
     */
    static function getFullName($contact, $includeTitle = false, $includeSuffix = false)
    {
        $parts = [];
        if($includeTitle){
            $parts[] = $contact['title'];
        }
        $parts[] = self::getFullGivenName($contact);
        $parts[] = $contact['family_name'];
        if($includeSuffix){
            $parts[] = $contact['suffix'];
        }
        return implode(' ', $parts);
    }

    /**
     * Gets the full given name of the member taking in account the given name
     * and possible middle name
     * @param array|yiicontacts\models\Contact $contact
     * @return string
     */
    static function getFullGivenName($contact)
    {
        $parts = [$contact['given_name']];
        if(!empty($contact['middle_name'])){
            $parts[] = $contact['middle_name'];
        }
        return implode(' ', $parts);
    }
}