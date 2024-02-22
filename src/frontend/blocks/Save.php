<?php
namespace yiicontacts\frontend\blocks;

/**
 * Save is a block used for saving contact information.
 */
class Save extends \yiiblock\widgets\Processor
{
    /**
     * {@inheritdoc}
     */
    static $defaultSubBlocks = [
        'contactForm' => [ 'class' => ContactForm::class]
    ];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
