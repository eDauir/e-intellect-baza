<?php
function post($db , $productId = false) {
        
        if(!empty($_GET['id']) || $productId != false) {
            $id = '';
            
            if($productId != false) {
                $id = convertStr($productId);
            }else {
                $id = convertStr($_GET['id']);
            }
            $projectPathName = "digway";
            $root = $_SERVER['DOCUMENT_ROOT'];

            $sql = "SELECT SQL_CALC_FOUND_ROWS link FROM images WHERE productId = '$id'";

            $data = $db->getAll($sql);

            $i = 0;
            while ($i < count($data))
            {
                $imageFile = explode("/", $data[$i]['link']);
                $asd = end( $imageFile );
                unlink($root . '/'.$projectPathName.'/images/' . end($imageFile));
                $i++;
            }

            $sql = "DELETE FROM images WHERE productId = '$id'";
            $deleteQuery = $db->query($sql);

            $sql = "DELETE FROM likes WHERE productId = '$id'";
            $deleteQuery = $db->query($sql);

            $sql = "DELETE FROM products WHERE id = '$id'";
            $deleteQuery = $db->query($sql);

            $sql = "DELETE FROM orders WHERE productId = '$id'";
            $deleteQuery = $db->query($sql);

            // $sql = "DELETE FROM lessons WHERE productId = '$id'";
            // $deleteQuery = $db->query($sql);



            return true;
        }

        return false;
}