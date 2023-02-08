<?php
function active($db) {
    if(isset($_GET['active'])) {
        echo $_GET['active'];
        $msg = convertStr($_GET['msg']);
        $userId = convertStr($_GET['userId']);
        $productId = convertStr($_GET['productId']);

        if($_GET['active'] == 1) {

            $sql = "UPDATE products SET active = 1 WHERE id = '$productId'";

            $updateQuery = $db->query($sql);

            $res = true;
        }
        else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS mail FROM users WHERE id = '$userId'";

            $data = $db->getOne($sql);

            mail($data, 'Ваше объявление не одобрено!', $msg, "From: admin@system.atlanta.company");

           $sql = "DELETE FROM products WHERE id = '$productId'";
           $deleteQuery = $db->query($sql);

            $res = true;
        }
    }
    
    return $res;
}