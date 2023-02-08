<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');

if(!empty($_POST['id']) && !empty($_POST['title']) && isset($_POST['text']) && !empty($_POST['time']) && !empty($_POST['category']) && isset($_POST['status']) && !empty($_POST['authToken'])) {

        include '../../../db/safemysql.class.php';
        include '../../../functions/shortFunctions.php';

        $db = new safeMysql();
                
        $id = convertStr(ucfirst($_POST['id']));
        $title = convertStr($_POST['title']);
        $text = convertStr($_POST['text']);
        $time = convertStr($_POST['time']);
        $category = convertStr($_POST['category']);
        $status = convertStr($_POST['status']);
        $authToken = convertStr($_POST['authToken']);

        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM users WHERE accessToken = '$authToken' AND editor = 2";

        $data = $db->getAll($sql);
        $count = count($data);

        if($count > 0) {

                if($_POST['imgChanged'] == 1) {
                        $postImg = $_POST['image'];
                        $image = convertImgToBase($postImg);

                        $sql = "UPDATE news SET img = '$image' WHERE id = '$id'";
                        $updateQuery = $db->query($sql);
                }

                $sql = "UPDATE news SET title = '$title', text = '$text', time = '$time', category = '$category', status = '$status' WHERE id = '$id'";
                $updateQuery = $db->query($sql);

                if($updateQuery) 
                        echo 'true';
                else
                        echo 'error';

        } else {
                echo 'No admin';
        }

} else {
        echo 'fields empty';
}
?>