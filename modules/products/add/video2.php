<?php 
header("Access-Control-Allow-Origin: *");

if(!empty($_REQUEST['authToken']) && !empty($_REQUEST['mentorId'])  && !empty($_REQUEST['name']) && !empty($_REQUEST['sectionId']) && !empty($_REQUEST['productId']) && !empty($_REQUEST['duration']) && !empty($_FILES['file'])) {

    include "../../../db/safemysql.class.php";
    include "../../../functions/shortFunctions.php";

    $db = new safeMysql();

    $authToken = convertStr($_REQUEST['authToken']);
    $name = convertStr($_REQUEST['name']);
    $sectionId = convertStr($_REQUEST['sectionId']);
    $productId = convertStr($_REQUEST['productId']);
    $duration = convertStr($_REQUEST['duration']);
    $mentorId = convertStr($_REQUEST['mentorId']);

    $sql = "SELECT SQL_CALC_FOUND_ROWS id FROM products WHERE id = '$productId' AND userId = '$mentorId'";
    $data = $db->getAll($sql);
    $count = count($data);

    if($count > 0) {
        // $targetfolder = "/digway/videos/";
        // $targetfolder = $targetfolder . basename( $_FILES['file']['name']) ;

        $videoName = mb_strtolower(random_str(32));
        $link = '/digway/videos/' . $videoName . '.mp4';
        
        $moveUpload = move_uploaded_file($_FILES['file']['tmp_name'], '../../../../videos/' . $videoName . '.mp4');

        if($moveUpload) {
            $sql = "INSERT INTO lessons (name, productId, sectionId, elemType) VALUES ('$name', '$productId', '$sectionId', 1)";
            $insertQuery = $db->query($sql);
            $lessonsId = $db->insertId();

            $sql = "INSERT INTO videos (lessonsId, duration, link) VALUES ('$lessonsId', '$duration', ?s)";
            $insertQuery = $db->query($sql, 'https://e-intellect.kz' . $link);

            if($insertQuery) {
                $sql = "UPDATE products SET active = 1 WHERE id = '$productId'";
                $updateQuery = $db->query($sql);

                $result = true;
            } 
            else {
                $result = 'db insert error';
            }
        }
        else {
            $result = 'dont uploaded';
        }
    } 
    else {
        $result = 'invalid mentorId';
    }
} 
else {
    $result = 'invalid rows';
}

   
echo json_encode($result);
?>
