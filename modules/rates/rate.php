<?php
function rate($db) {
    switch ($_GET['subType']) {
    case 'get':
        include "modules/rates/get.php";
        $res = get($db);
        break;
    case 'getMy':
        include "modules/rates/myRate.php";
        $res = myRates($db);
        break;
    case 'buy':
        include "modules/rates/buy.php";
        $res = buy($db);
        break;
    case 'reBuy':
        include "modules/rates/buy.php";
        $res = buy($db);
        break;
    }
    return $res;
}