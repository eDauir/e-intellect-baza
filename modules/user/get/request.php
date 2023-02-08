<?php
function request($db) {
    if(isset($_GET['authToken'])) {
        $authToken = convertStr($_GET['authToken']);

        $sql = "SELECT linkPartnerMentor.*, users_profile.name, users_profile.surname FROM linkPartnerMentor LEFT JOIN users_profile ON users_profile.user_id = linkPartnerMentor.tutorId WHERE linkPartnerMentor.mentorId = (SELECT id FROM users WHERE accessToken = '$authToken') AND linkPartnerMentor.accepted = 0";

        $data = $db->getAll($sql);

        return $data;
    }
}