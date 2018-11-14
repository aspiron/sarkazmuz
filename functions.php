<?php

function startWith($word, $sentence, $raz = '_'){
    $pattern = "#^$word{$raz}#";
    if(preg_match($pattern, $sentence)!=0)
        return trim(mb_substr($sentence, mb_strlen($word)+1));
    return false;
}
function startCommand ($word, $sentence, $raz = ' '){
    return startWith('/'.$word, $sentence, $raz);
}
function clearHtml ($text){
    return str_replace(['<','>'],['&lt','&gt'],$text);
}
function remove_emoji($text){
      $text = explode(" ", $text);
return $text[2];
    
}

function catCommand ($word, $sentence, $raz = ' '){
    return startWith($word, $sentence, $raz);
}
