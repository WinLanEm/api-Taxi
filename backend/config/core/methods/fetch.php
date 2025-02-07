<?php

function fetchAll($stml){
    $result = $stml->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function fetch($stml){
    $result = $stml->fetch(PDO::FETCH_ASSOC);
    return $result;
}
