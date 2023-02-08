<?php
function orders($db) {
    switch ($_GET['subType']) {
    case 'getMy':
        include "modules/orders/getMy.php";
        $res = getMy($db);
        break;
    case 'myClients':
        include "modules/orders/myClients.php";
        $res = myClients($db);
        break;
    }
    return $res;
}