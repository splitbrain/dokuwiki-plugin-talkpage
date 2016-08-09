<?php
/**
 * Talkpge Plugin: places talkpage icon in pagetools
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Blake Martin
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

/**
 * Add the template as a page dependency for the caching system
 */
class action_plugin_talkpage extends DokuWiki_Action_Plugin {

    function register(Doku_Event_Handler $controller) {
        $controller->register_hook('TEMPLATE_PAGETOOLS_DISPLAY', 'BEFORE', $this, 'addbutton');
    }

    /**
     * @param Doku_Event $event
     * @param $param
     * @return bool
     */
    public function addbutton(Doku_Event $event, $param) {
        if(!$this->getConf('showbutton')) return false;
        if(!$event->data['view'] == 'main') return false;

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
}
