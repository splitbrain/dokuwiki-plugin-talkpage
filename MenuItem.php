<?php

namespace dokuwiki\plugin\talkpage;

use dokuwiki\Menu\Item\AbstractItem;

/** @inheritdoc */
class MenuItem extends AbstractItem
{

    protected $type = 'show';

    /** @inheritdoc */
    public function __construct()
    {
        parent::__construct();

        /** @var \syntax_plugin_talkpage $syntax */
        $syntax = plugin_load('syntax', 'talkpage');

        $info = $syntax->getLink();
        $this->id = $info['goto'];
        $this->nofollow = isset($info['attr']['rel']);
        $this->label = $info['text'];
        $this->svg = __DIR__ . '/svg/' . $info['type'] . '.svg';
    }

}
