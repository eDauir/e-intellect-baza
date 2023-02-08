<?php
function accept($db) {
    if(isset($_GET['authToken']) && isset($_GET['answer'])) {
        $authToken = convertStr($_GET['authToken']);
        $answer = convertStr($_GET['answer']);

        $sql = "SELECT id FROM users WHERE accessToken = '$authToken' AND editor = 0";
        $userId = $db->getOne($sql);

        if(!empty($userId)) {
            if($answer == 'false') {
                $sql = "DELETE FROM linkPartnerMentor WHERE mentorId = '$userId' AND accepted = 0";
                $deleteQuery = $db->query($sql);
    
                return true;
            }
    
            $sql = "UPDATE linkPartnerMentor SET accepted = 1 WHERE mentorId = '$userId'";
            $updateQuery = $db->query($sql);

            $sql = "SELECT job, about FROM linkPartnerMentor WHERE accepted = 1 AND mentorId = '$userId'";
            $linkInfo = $db->getAll($sql);
            $job = $linkInfo[0]['job'];
            $about = $linkInfo[0]['about'];

            $sql = "UPDATE users_profile SET job = '$job', about = '$about' WHERE user_id = '$userId'";
            $updateQuery = $db->query($sql);

            $sql = "UPDATE users SET editor = 1 WHERE id = '$userId'";
            $updateQuery = $db->query($sql);

            return true;
        }
    }

    return false;
}