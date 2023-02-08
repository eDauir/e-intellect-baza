<?php
function test($db) {
    switch ($_GET['subType']) {
    case 'get':
        include "modules/test/get.php";
        $res = get($db);
        break;
    case 'getResult':
        include "modules/test/getResult.php";
        $res = get($db);
        break;
    case 'putResult':
        include "modules/test/putResult.php";
        $res = putResult($db);
        break;
    }
    return $res;
}