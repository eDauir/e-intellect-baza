<?php
function faq($db) {
        
        if(!empty($_GET['question']) && !empty($_GET['answer'])) {
            $question = convertStr($_GET['question']);
            $answer = convertStr($_GET['answer']);

            $sql = "INSERT INTO faq (question, answer) VALUES ('$question', '$answer')";
            $insertQuery = $db->query($sql);

            return true;
        }

        return false;
}