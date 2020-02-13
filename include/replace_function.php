<?php

function replaceHTMLCharacters($string) {
    //Replace <
    //$string = str_replace("<", "&lt", $string);

    //Replace >
    //$string = str_replace(">", "&gt", $string);
    
    //Replace "
    $string = str_replace(chr(34), "``", $string);
    
    //Replace '
    $string = str_replace("'", "`", $string);

    return $string;
}
