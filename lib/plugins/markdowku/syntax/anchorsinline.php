<?php
/*
 * Inline links [name](target "title")
 */
 
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
class syntax_plugin_markdowku_anchorsinline extends DokuWiki_Syntax_Plugin {

    function getType()  { return 'substition'; }
    function getPType() { return 'normal'; }
    function getSort()  { return 102; }
    
    function connectTo($mode) {
        $this->nested_brackets_re =
            str_repeat('(?>[^\[\]]+|\[', 6).
            str_repeat('\])*', 6);
        $this->Lexer->addSpecialPattern(
            '\['.$this->nested_brackets_re.'\]\([ \t]*<?.+?>?[ \t]*(?:[\'"].*?[\'"])?\)',
            $mode,
            'plugin_markdowku_anchorsinline'
        );
    }

    function handle($match, $state, $pos, &$handler) {
        if ($state == DOKU_LEXER_SPECIAL) {
            $text = preg_match(
                '/^\[('.$this->nested_brackets_re.')\]\([ \t]*<?(.+?)>?[ \t]*(?:[\'"](.*?)[\'"])?[ \t]*?\)$/',
                $match,
                $matches);
            $target = $matches[2] == '' ? $matches[3] : $matches[2];
            $title = $matches[1];

            $target = preg_replace('/^mailto:/', '', $target);
            $handler->internallink($target.'|'.$title, $state, $pos);
        }
        return true;
    }
    
    function render($mode, &$renderer, $data) {
        return true;
    }
}
//Setup VIM: ex: et ts=4 enc=utf-8 :
