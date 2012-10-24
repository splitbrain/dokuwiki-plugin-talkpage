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
        return 'substition';
    }

    public function getPType() {
        return 'normal';
    }

    public function getSort() {
        return 444;
    }


    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('~~TALKPAGE~~',$mode,'plugin_talkpage');
    }

    public function handle($match, $state, $pos, &$handler){
        $data = array();

        return $data;
    }

    public function render($mode, &$renderer, $data) {
        global $INFO;
        if($mode != 'xhtml') return false;

        $renderer->info['cache'] = false;

        $talkns = cleanID($this->getConf('talkns'));

        if(substr($INFO['id'],0,strlen($talkns)+1) === "$talkns:"){
            // we're on the talk page
            $goto = substr($INFO['id'],strlen($talkns)+1);
            $text = 'back';
        }else{
            // we want to the talk page
            $goto = $talkns .':'.$INFO['id'];
            if(page_exists($talkpage)){
                $text = 'talk';
            }else{
                $text = 'add';
            }
        }

        $renderer->doc .= '<a href="'.wl($goto).'" class="talkpage talkpage-'.$text.'">'.$this->getLang($text).'</a>';

        return true;
    }
}

// vim:ts=4:sw=4:et:
