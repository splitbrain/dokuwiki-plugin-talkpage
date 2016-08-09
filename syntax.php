<?php
/**
 * DokuWiki Plugin talkpage (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Andreas Gohr <andi@splitbrain.org>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

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
        $this->Lexer->addSpecialPattern('~~TALKPAGE~~', $mode, 'plugin_talkpage');
    }

    public function handle($match, $state, $pos, Doku_Handler $handler) {
        $data = array();

        return $data;
    }

    public function render($mode, Doku_Renderer $renderer, $data) {
        if($mode != 'xhtml') return false;
        $renderer->info['cache'] = false;

        $data = $this->getLink();
        $renderer->doc .= '<a ' . buildAttributes($data['attr']) . '>' . $data['text'] . '</a>';
        return true;
    }

    /**
     * @return array text and attributes for the link
     */
    public function getLink() {
        global $INFO;
        $talkns = cleanID($this->getConf('talkns'));

        $attr = array();
        if(substr($INFO['id'], 0, strlen($talkns) + 1) === "$talkns:") {
            // we're on the talk page
            $goto = substr($INFO['id'], strlen($talkns) + 1);
            $text = 'back';
        } else {
            // we want to the talk page
            $goto = $talkns . ':' . $INFO['id'];
            if(page_exists($goto)) {
                $text = 'talk';
            } else {
                $text = 'add';
                $attr['rel'] = 'nofollow';
            }
        }
        $attr['href']  = wl($goto);
        $attr['class'] = 'talkpage talkpag-' . $text;

        return array(
            'text' => $this->getLang($text),
            'attr' => $attr
        );
    }
}

// vim:ts=4:sw=4:et:
