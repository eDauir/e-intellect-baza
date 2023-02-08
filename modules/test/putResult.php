<?php
function putResult($db) {
    if(!empty($_GET['authToken']) && !empty($_GET['testId']) && !empty($_GET['score'])) {
        $authToken = convertStr($_GET['authToken']);
        $testId = convertStr($_GET['testId']);
        $score = convertStr($_GET['score']);

        $sql = "SELECT id FROM users WHERE accessToken = '$authToken'";
        $data = $db->getOne($sql);

        if($data != 0) {
            $sql = "INSERT INTO test_result (userId, testId, score) VALUES ('$data', '$testId', '$score')";
            $insertQuery = $db->query($sql);

            return true;
        }
    }

    return false;
}