<?php
namespace yiicontacts\blocks;

/**
 * ContactIndex displays the grid view for managing records
 */
class ContactIndex extends \bvb\crud\blocks\Index
{
    /**
     * {@inheritdoc}
     */
    static $defaultSubBlocks = [
        'gridView' => ['class' => \yiicontacts\widgets\ContactGridView::class]
    ];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->getView()->contentHeaderWidgets['exportLink'] = [
            'content' => \bvb\crud\actions\Export::getDefaultExportLink(),
            'position' => 0
        ];
        parent::init();
    }
}