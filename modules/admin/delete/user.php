<?php
function user($db) {
        
        if(!empty($_GET['id'])) {
            $id = convertStr($_GET['id']);

            $sql = "SELECT SQL_CALC_FOUND_ROWS avatar FROM users_profile WHERE user_id = $id";

            $data = $db->getOne($sql);
            $imageFile = explode("/", $data);
            $projectPathName = "digway";
            $root = $_SERVER['DOCUMENT_ROOT'];

            if(end($imageFile) != 'noAva.png')
                unlink($root . '/'.$projectPathName.'/images/' . end($imageFile));

            $sql = "SELECT id FROM products WHERE userId = '$id'";
            $data = $db->getAll($sql);


            $sql = "DELETE FROM users_profile WHERE user_id = '$id'";
            $deleteQuery = $db->query($sql);

            $sql = "DELETE FROM likes WHERE userId = '$id'";
            $deleteQuery = $db->query($sql);

            $sql = "DELETE FROM mail_active WHERE user_id = '$id'";
            $deleteQuery = $db->query($sql);

            $sql = "DELETE FROM mail_active WHERE user_id = '$id'";
            $deleteQuery = $db->query($sql);

            $sql = "DELETE FROM users WHERE id = '$id'";
            $deleteQuery = $db->query($sql);


            
            if (count($data) > 0) {
                include "post.php";
                // return $products;
                foreach ($data as $item) {
                    $productId = $item['id'];
                    post($db , $productId);
                    // return $productId;
                }
            }



            return true;
        }

        return false;
}