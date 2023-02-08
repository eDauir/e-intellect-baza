<?php
function get($db) {
    if(!empty($_GET['id'])) {
        $id = convertStr($_GET['id']);

        $sqlQuest = "SELECT * FROM test_question WHERE testId = '$id'";
        $dataQuest = $db->getAll($sqlQuest);

        $res = array();
        
        foreach ($dataQuest as $value) {
            $questionId = $value['id'];

            $sql = "SELECT * FROM test_answer WHERE questionId = '$questionId'";
            $tick = $db->getAll($sql);

            $value['answer'] = $tick;

            $res[] = $value;
        }

        return $res;
    }
}