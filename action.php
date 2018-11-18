<?php
/**
 * Talkpage Plugin: places talkpage icon in pagetools
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Blake Martin
 * @author     Andreas Gohr <andi@splitbrain.org>
 */

/**
 * Add the template as a page dependency for the caching system
 */
class action_plugin_talkpage extends DokuWiki_Action_Plugin
{
    /** @inheritdoc */
    function register(Doku_Event_Handler $controller)
    {
        $controller->register_hook('TEMPLATE_PAGETOOLS_DISPLAY', 'BEFORE', $this, 'addLegacyButton');
        $controller->register_hook('MENU_ITEMS_ASSEMBLY', 'AFTER', $this, 'addMenuButton');
    }

    /**
     * Add talk page to the old menu
     *
     * @param Doku_Event $event
     * @return bool
     */
    public function addLegacyButton(Doku_Event $event)
    {
        if (!$this->getConf('showbutton')) return false;
        if (!$event->data['view'] == 'main') return false;

        /** @var syntax_plugin_talkpage $helper */
        $helper = plugin_load('syntax', 'talkpage');
        $data = $helper->getLink();
        $data['attr']['class'] .= ' action';

        $link = '<li><a ' . buildAttributes($data['attr']) . '><span>' . $data['text'] . '</span></a></li>';

        // insert at second position
        $event->data['items'] = array_slice($event->data['items'], 0, 1, true) +
            array('talkpage' => $link) +
            array_slice($event->data['items'], 1, null, true);

        return true;
    }

    /**
     * Add Talkpage to the new menu system
     *
     * @param Doku_Event $event
     * @return bool
     */
    public function addMenuButton(Doku_Event $event)
    {
        if (!$this->getConf('showbutton')) return false;
        if ($event->data['view'] !== 'page') return false;
        array_splice($event->data['items'], 1, 0, [new \dokuwiki\plugin\talkpage\MenuItem()]);
        return true;
    }
}
