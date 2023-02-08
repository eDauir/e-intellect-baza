<?php
function books($db) {
    switch ($_GET['subType']) {
    case 'get':
        include "modules/books/get.php";
        $res = get($db);
        break;
    case 'getMy':
        include "modules/books/getMy.php";
        $res = getMy($db);
        break;
    case 'add':
        include "modules/books/add.php";
        $res = add($db);
        break;
    }
    return $res;
}