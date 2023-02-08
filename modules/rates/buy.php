<?php
function buy($db) {

    if(!empty($_GET['authToken']) && !empty($_GET['rateId']) && !empty($_GET['payboxLink']) && !empty($_GET['paymentId']) && !empty($_GET['orderId'])) {
        $authToken = convertStr($_GET['authToken']);
        $rateId = convertStr($_GET['rateId']);
        $payboxLink = convertStr($_GET['payboxLink']);
        $paymentId = convertStr($_GET['paymentId']);
        $orderId = convertStr($_GET['orderId']);

        $sql = "SELECT id FROM users WHERE accessToken = '$authToken' LIMIT 1";
        $data = $db->getOne($sql);

        if($data != 0) {

            if($_GET['subType'] == 'buy') {

                $sql = "SELECT * FROM buyRates WHERE userId = (SELECT id FROM users WHERE accessToken = '$authToken') AND active = 0";
                $check2 = $db->getAll($sql);
                $count2 = count($check2);

                if($count2 > 0) {

                    $sql = "DELETE FROM buyRates WHERE userId = (SELECT id FROM users WHERE accessToken = '$authToken') AND active = 0";
				    $db->query($sql);

                }

                $sql = "INSERT INTO buyRates (userId, rateId, paymentId, orderId, payboxLink) VALUES ('$data', '$rateId', '$paymentId', '$orderId', '$payboxLink')";
                $insertQuery = $db->query($sql);

                return true;

            }
            elseif($_GET['subType'] == 'reBuy') {

                $sql = "UPDATE buyRates SET rateId = '$rateId', activeDate = null, payboxLink = '$payboxLink', paymentId = '$paymentId', orderId = '$orderId', active = 0 WHERE userId = (SELECT id FROM users WHERE accessToken = '$authToken')";
                
                $updateQuery = $db->query($sql);

                return true;
                
            }

            return false;
            
        }

        return false;
    }

    return false;
}