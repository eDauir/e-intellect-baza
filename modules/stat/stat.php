<?php
function statics($db) {
    switch ($_GET['subType']) {
    case 'get':
        include "modules/stat/get.php";
        $res = get($db);
        break;
    }
    return $res;
}