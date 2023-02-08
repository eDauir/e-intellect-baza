<?php
function send($db) {
    if(isset($_GET['authToken']) && isset($_GET['mentorId']) && isset($_GET['job']) && isset($_GET['about']) && isset($_GET['tutorId'])) {
        $authToken = convertStr($_GET['authToken']);
        $mentorId = convertStr($_GET['mentorId']);
        $job = convertStr($_GET['job']);
        $about = convertStr($_GET['about']);
        $tutorId = convertStr($_GET['tutorId']);

        $_GET['id'] = $mentorId;
        include "modules/partner/request/checkId.php";
        $res = checkId($db);

        if(!empty($res) && $res != false) {
            $sql = "SELECT COUNT(id) as id FROM users WHERE id = '$tutorId' AND editor = 1";
            $data = $db->getAll($sql);

            if(!empty($data) && $data > 0) {
                $sql = "SELECT id FROM users WHERE accessToken = '$authToken' AND editor = 3";
                $data = $db->getOne($sql);
    
                if($data != 0) {
                    $sql = "INSERT INTO linkPartnerMentor (partnerId, mentorId, job, about, tutorId, accepted) VALUES ('$data', '$mentorId', '$job', '$about', '$tutorId', 1)";
                    $insertQuery = $db->query($sql);
                    
                    $sql = "UPDATE users_profile SET job = '$job', about = '$about' WHERE user_id = '$mentorId'";
                    $updateQuery = $db->query($sql);

                    $sql = "UPDATE users SET editor = 1 WHERE id = '$mentorId'";
                    $updateQuery = $db->query($sql);

                    return true;
                }
            } 
        }
    }

    return false;
}