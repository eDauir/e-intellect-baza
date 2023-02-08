<?php
function products($db) {
    switch ($_GET['subType']) {
    case 'get':
        include "modules/products/get/products.php";
        $res = getProducts($db);
        break;
    case 'getOne':
        include "modules/products/get/one.php";
        $res = one($db);
        break;
    case 'getMy':
        include "modules/products/get/my.php";
        $res = my($db);
        break;
    case 'getList':
        include "modules/products/get/list.php";
        $res = getList($db);
        break;
    case 'getSection':
        include "modules/products/get/section.php";
        $res = getSection($db);
        break;
    case 'delete':
        $checker = checker($db);
        if(!empty($checker) && $checker != false) {
            include "modules/products/delete/delete.php";
            $res = delProduct($db);
        }
        break;
    case 'delLessons':
        $checker = checker($db);
        if(!empty($checker) && $checker != false) {
            include "modules/products/delete/lessons.php";
            $res = delLessons($db);
        }
        break;
    case 'add':
        $checker = checker($db);
        if(!empty($checker) && $checker != false) {
            include "modules/products/add/product.php";
            $res = addProduct($db);
        }
        break;
    case 'addSection':
        $checker = checker($db);
        if(!empty($checker) && $checker != false) {
            include "modules/products/add/section.php";
            $res = addSection($db);
        }
        break;
    case 'addTest':
        $checker = checker($db);
        if(!empty($checker) && $checker != false) {
            include "modules/products/add/test.php";
            $res = addTest($db);
        }
        break;
    case 'updateTest':
        $checker = checker($db);
        if(!empty($checker) && $checker != false) {
            include "modules/products/update/test.php";
            $res = updateTest($db);
        }
        break;
    }
    return $res;
}

function checker($db) {
    $authToken = convertStr($_GET['authToken']);

    $sql = "SELECT id FROM users WHERE accessToken = '$authToken' AND (editor = 2 OR editor = 3)";
    return $db->getOne($sql);
}