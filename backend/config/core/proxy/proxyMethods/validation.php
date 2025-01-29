<?php
function stringToBool($value) {
    if ($value === "true") {
        return true;
    } elseif ($value === "false") {
        return false;
    }elseif ($value === false){
        return false;
    }else if ($value === true){
        return true;
    }
        return null;
}
function boolToString($value){
    if($value === true){
        return 'true';
    }elseif ($value === false){
        return 'false';
    }
}