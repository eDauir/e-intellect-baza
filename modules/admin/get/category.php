<?php

function getCategory ($db) {
    $per_page = 20;
    $start = getStart();
    $searchKey = getSearchKey();

    if($searchKey == null) 
        $sql = "SELECT SQL_CALC_FOUND_ROWS  category.*   FROM category  ";
    else 
        $sql = "SELECT SQL_CALC_FOUND_ROWS  category.*   FROM category  WHERE name LIKE '%$searchKey%' ";

    $category = $db->getAll($sql);







    $arrOrders = [];


    foreach($category as $item) {
        $categoryId = $item['id'];

        $sql = "SELECT products.categoryId , COUNT( orders.id) as workers , COUNT(DISTINCT products.id) as productsCount  FROM products  LEFT JOIN orders ON products.id = orders.productId WHERE  products.categoryId = '$categoryId' ";
        $orders = $db->getAll($sql);


        


        foreach($orders as $order) {
            if($categoryId == $order['categoryId']) {
                // print_r($order);
                array_push($arrOrders , $order);   
            }
        }
    }



    for ($x=0; $x<count($category); $x++) {
        $categoryDataId = $category[$x]['id'];

        for($y=0 ; $y < count($arrOrders) ; $y++ ) {
            $orderId = $arrOrders[$y]['categoryId'];

            if($orderId == $categoryDataId) {
                $category[$x]['workers'] = intval($arrOrders[$y]['workers']);
                $category[$x]['productsCount'] = intval($arrOrders[$y]['productsCount']);
                break;
            }else {
                $category[$x]['workers'] = 0;
                $category[$x]['productsCount'] = 0;
            }
        }
    }



    $rows = $db->getOne("SELECT FOUND_ROWS()");
    $num_pages = ceil($rows / $per_page);
    $arrayToJson = array();
    $arrayToJson['count'] = $num_pages;
    $arrayToJson['category'] = $category;




    return $arrayToJson;
}





function getStart() {
    $cur_page = 1;
    $per_page = 20;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;

    return $start;
}

function getSearchKey() {
    if(!empty($_GET['searchKey']))
        return convertStr($_GET['searchKey']);

    return null;
}

