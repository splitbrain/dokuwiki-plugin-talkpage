<?php
/**
 * DokuWiki Plugin talkpage (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Andreas Gohr <andi@splitbrain.org>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once DOKU_PLUGIN.'syntax.php';

class syntax_plugin_talkpage extends DokuWiki_Syntax_Plugin {
    public function getType() {
        return 'FIXME: container|baseonly|formatting|substition|protected|disabled|paragraphs';
    }

    public function getPType() {
        return 'FIXME: normal|block|stack';
    }

    public function getSort() {
        return FIXME;
    }


    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('<FIXME>',$mode,'plugin_talkpage');
//        $this->Lexer->addEntryPattern('<FIXME>',$mode,'plugin_talkpage');
    }

//    public function postConnect() {
//        $this->Lexer->addExitPattern('</FIXME>','plugin_talkpage');
//    }

    public function handle($match, $state, $pos, &$handler){
        $data = array();

        return $data;
    }

    public function render($mode, &$renderer, $data) {
        if($mode != 'xhtml') return false;

        return true;
    }
}

// vim:ts=4:sw=4:et:
