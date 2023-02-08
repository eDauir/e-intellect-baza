<?php
function units($db) {
    switch ($_GET['subType']) {
    case 'get':
        include "modules/units/get.php";
        $res = get($db);
        break;
    case 'dist':
        include "modules/units/dist.php";
        $res = dist($db);
        break;
    }
    return $res;
}