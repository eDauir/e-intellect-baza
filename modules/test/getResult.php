<?php
function get($db) {
    if(!empty($_GET['authToken'])) {
        $authToken = convertStr($_GET['authToken']);

        $sqlQuest = "SELECT * FROM test_result WHERE userId = (SELECT id FROM users WHERE accessToken = '$authToken')";
        $dataQuest = $db->getAll($sqlQuest);

        return $dataQuest;
    }
}