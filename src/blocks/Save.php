<?php
namespace yiicontacts\blocks;

use yiivue\helpers\Adminkit;

/**
 * FormEntry is a block used for viewing, creating, and updating form entries.
 */
class Save extends \yiiblock\widgets\Processor
{
    /**
     * {@inheritdoc}
     */
    static $defaultContainers = [
        'row' => ['class' => ['row' => 'row']]
    ];

    /**
     * {@inheritdoc}
     */
    static $defaultSubBlocks = [
        'leftCol' => [
            'class' => \yiiblock\widgets\Processor::class,
            'containers' => [
                'col' => ['class' => ['col' => 'col-md-6']]
            ],
            'subBlocks' => [
                [
                    'class' => \bvb\adminkit\blocks\ContentBox::class,
                    'heading' => 'Personal Info',
                    'subBlocks' => [
                        'contactForm' => [ 'class' => ContactForm::class]
                    ]
                ]
            ]
        ],
        'rightCol' => [
            'class' => \yiiblock\widgets\Processor::class,
            'containers' => [
                'col' => ['class' => ['col' => 'col-md-6']]
            ],
            'subBlocks' => [
                [
                    'class' => \bvb\adminkit\blocks\ContentBox::class,
                    'heading' => 'Default Address',
                    'subBlocks' => [
                        'addressForm' => [ 'class' => AddressForm::class]
                    ]
                ]
            ]
        ]
    ];
}
