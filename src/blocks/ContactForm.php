<?php
namespace yiicontacts\blocks;

/**
 * ContactForm renders the vue component for the contact form
 */
class ContactForm extends \yiiblock\widgets\Processor
{
    /**
     * Renders the HTML for the form to create a form record
     */
    public function run()
    {
        return '<contact-form :contact="contact" 
            :user-selection="userSelection"
            @contact-saved="handleContactSaved"></contact-form>';
    }
}