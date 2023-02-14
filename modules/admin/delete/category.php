<?php


function deleteCategory ($db) {
    if(isset($_GET['categoryId'])) {
        $categoryId = convertStr($_GET['categoryId']);

        $sql = "SELECT id FROM products WHERE categoryId = '$categoryId'";

        $products = $db->getAll($sql);

        if( count( $products) == 0) {
            
        }else {
            include "post.php";
            // return $products;
            foreach ($products as $item) {
                $productId = $item['id'];
                post($db , $productId);
                // return $productId;
            }
        }


        $sql = "DELETE FROM category WHERE id = '$categoryId'";
        $deleteQuery = $db->query($sql);

        return true;

    }
}

