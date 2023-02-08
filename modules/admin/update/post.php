<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');

if(!empty($_POST['id']) && !empty($_POST['name']) && isset($_POST['price']) && !empty($_POST['about']) && !empty($_POST['categoryId']) && isset($_POST['active']) && !empty($_POST['authToken'])) {

        include '../../../db/safemysql.class.php';
        include '../../../functions/shortFunctions.php';

        $db = new safeMysql();
                
        $id = convertStr(ucfirst($_POST['id']));
        $name = convertStr($_POST['name']);
        $price = convertStr($_POST['price']);
        $about = convertStr($_POST['about']);
        $categoryId = convertStr($_POST['categoryId']);
        $active = convertStr($_POST['active']);
        $authToken = convertStr($_POST['authToken']);

        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM users WHERE accessToken = '$authToken' AND editor = 2";

        $data = $db->getAll($sql);
        $count = count($data);

        if($count > 0) {

                if($_POST['introChanged'] == 1) {
                        $videoName = mb_strtolower(random_str(32));
                        $link = '/digway/videos/' . $videoName . '.mp4';

                        $fp = file_put_contents($_SERVER['DOCUMENT_ROOT'] . $link, base64_decode($_POST['intro'], true));

                        $linkId = 'https://e-intellect.kz' . $link;

                        $sql = "UPDATE products SET intro = '$linkId' WHERE id = '$productId'";
                        $updateQuery = $db->query($sql);
                }

                if($_POST['imgChanged'] == 1) {
                        $postImg = $_POST['image'];
                        $image = convertImgToBase($postImg);

                        $sql = "UPDATE images SET link = '$image' WHERE productId = '$id'";
                        $updateQuery = $db->query($sql);
                }

                $sql = "UPDATE products SET name = '$name', about = '$about', price = '$price', categoryId = '$categoryId', active = '$active' WHERE id = '$id'";
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