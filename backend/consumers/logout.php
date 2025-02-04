<?php

header("Content-Type: application/json; charset=UTF-8");
require_once '../config/core/methods/logout.php';

$result = logout();
echo($result);