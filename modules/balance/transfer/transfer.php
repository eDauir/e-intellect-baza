<?php
function transfer($db) {
    if(!empty($_GET['authToken']) && isset($_GET['amount']) && isset($_GET['id'])) {
        $authToken = convertStr($_GET['authToken']);
        $amount = convertStr($_GET['amount']);
        $id = convertStr($_GET['id']);

        $sql = "SELECT id FROM users WHERE id = '$id'";
        $checkId = $db->getAll($sql);

        if(count($checkId) > 0) {

            if($amount > 0) {
            
                $sql = "SELECT id FROM users WHERE accessToken = '$authToken'";
                $userId = $db->getOne($sql);
    
                $sql = "SELECT amount FROM balance WHERE userId = '$userId'";
                $data = $db->getOne($sql);
    
                if($amount <= $data) {
    
                    $sql = "UPDATE balance SET amount = amount - $amount WHERE userId = '$userId'";
                    $updateQuery = $db->query($sql);
    
                    $sql = "UPDATE balance SET amount = amount + $amount WHERE userId = '$id'";
                    $updateQuery = $db->query($sql);
    
                    $sql = "INSERT INTO balance_history (userId, toUser, amount, type) VALUES ('$userId', '$id', '$amount', 5)";
                    $insertQuery = $db->query($sql);
        
    
                    return true;
                }
    
                return false;
            }

            return false;

        }


        return false;
    }

    return false;
}