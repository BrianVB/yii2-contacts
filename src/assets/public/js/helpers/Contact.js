/**
 * Contains functions related to Contact models and their related records
 */

/**
 * @var array Possible values for the `title` field on the `member` table
 */
export const TITLES = [
    'Mr',
    'Ms',
    'Mrs',
];

/**
 * @var array Possible values for the `suffix`
 */
export const SUFFIXES = [
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
export function getFullName(contact, includeTitle = false, includeSuffix = false){
    parts = [];
    if(includeTitle){
        parts.push(contact.title);
    }
    parts.push(getFullGivenName(contact));
    parts.push(contact.family_name);
    if(includeSuffix){
        parts.push(contact.suffix);
    }
    return parts.join(' ');
}

/**
 * Gets the full given name of the member taking in account the given name
 * and possible middle name
 * @param array|yiicontacts\models\Contact $contact
 * @return string
 */
export function getFullGivenName(contact){
    $parts = [contact.given_name];
    if(contact.middle_name){
        parts.push(contact.middle_name);
    }
    return parts.join(' ');
}