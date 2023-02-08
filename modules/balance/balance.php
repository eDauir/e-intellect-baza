<?php
function balance($db) {
    switch ($_GET['subType']) {
    case 'get':
        include "modules/balance/get/get.php";
        $res = get($db);
        break;
    case 'transfer': 
        include "modules/balance/transfer/transfer.php";
        $res = transfer($db);
        break;
    case 'checkId': 
        include "modules/balance/transfer/checkId.php";
        $res = checkId($db);
        break;
    }
    return $res;
}