<?php
function checkId($db) {
    if(isset($_GET['id'])) {
        $id = convertStr($_GET['id']);
        $checkCurator = convertStr($_GET['checkC']);
        $checkPartner = convertStr($_GET['checkP']);


        if($checkCurator == '1') {
            $sql = "SELECT name, surname FROM users_profile WHERE user_id = (SELECT id FROM users WHERE id = '$id' AND editor = 1)";
            $data = $db->getAll($sql);

            if(empty($data))
                return false;

            return $data;
        }
        elseif($checkPartner == '1') {
            $sql = "SELECT name, surname FROM users_profile WHERE user_id = (SELECT id FROM users WHERE id = '$id' AND editor = 0)";
            $data = $db->getAll($sql);

            if(empty($data))
                return false;

            return $data;
        }
        else {
            $sql = "SELECT id FROM users WHERE id = '$id' AND editor = 0";
            $data = $db->getOne($sql);

            if($data != 0) {

                $sql = "SELECT mentorId FROM linkPartnerMentor WHERE mentorId = '$id'";
                $data = $db->getOne($sql);

                if($data == 0) {
                    $sql = "SELECT name, surname FROM users_profile WHERE user_id = '$id'";
                    $data = $db->getAll($sql);
            
                    return $data;
                }
            }
        }
    }

    return false;
}