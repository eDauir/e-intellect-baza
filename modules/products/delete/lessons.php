<?php
function delLessons($db) {
    if(isset($_GET['authToken']) && isset($_GET['lessonsId']) && isset($_GET['productId']) && isset($_GET['mentorId'])) {
        $authToken = convertStr($_GET['authToken']);
        $lessonsId = convertStr($_GET['lessonsId']);
        $productId = convertStr($_GET['productId']);
        $mentorId = convertStr($_GET['mentorId']);

        $sql = "SELECT id FROM users WHERE id = '$mentorId' AND editor = 1 LIMIT 1";
        $data = $db->getOne($sql);

        if($data != 0) {
            $sql = "SELECT sectionId FROM lessons WHERE id = '$lessonsId' AND productId = $productId";
            $sectionId = $db->getOne($sql);

            $sql = "DELETE FROM lessons WHERE id = $lessonsId AND productId = $productId";
            $insertQuery = $db->query($sql);

            $sql = "SELECT id FROM lessons WHERE sectionId = '$sectionId'";
            $countPosts = $db->getAll($sql);
            $count = count($countPosts);

            if($count == 0) {
                $sql = "DELETE FROM sections WHERE id = $sectionId";
                $insertQuery = $db->query($sql);
            }

            return true;
        }

        return false;
    }

    return false;
}
