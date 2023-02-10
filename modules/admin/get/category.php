<?php

function getCategory ($db) {
    $sql = "SELECT  category.*   FROM category  ";

    $category = $db->getAll($sql);


    $arrOrders = [];


    foreach($category as $item) {
        $categoryId = $item['id'];

        $sql = "SELECT products.categoryId , COUNT( orders.id) as workers , COUNT(DISTINCT products.id) as productsCount  FROM products  LEFT JOIN orders ON products.id = orders.productId WHERE products.categoryId = '$categoryId' ";
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





    return $category;
}
