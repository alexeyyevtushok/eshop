<?php
function display_errors($errors){
    $display = '<ul class="bg-danger">';
    foreach($errors as $error){
        $display .= '<li class="text-white"> '.$error.'</li>';
    }
    $display .= '</ul>';
    return $display;
}

function sanitize($bad_string){
    return htmlentities($bad_string,ENT_QUOTES,"UTF-8");
}