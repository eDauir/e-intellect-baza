<?php
function dist($db) {

    header('Access-Control-Allow-Origin: *');

    if($_GET['token'] != 'JXDB3BceILHfgh1mP9JC8WGmXMXEwRBp')
        return false;

    $sql = "SELECT * FROM units";
    $data = $db->getAll($sql);

    if(empty($data))
        return false;

    $sql = "SELECT SUM(amount) as sum FROM units";
    $unitSum = $db->getOne($sql);

    if($unitSum > 1000)
        return false;

    $sql = "SELECT SUM(amount) as sum FROM billionaireFund WHERE type = 1";
    $sumPlus = $db->getOne($sql);

    $sql = "SELECT SUM(amount) as sum FROM billionaireFund WHERE type = 0";
    $sumMinus = $db->getOne($sql);

    $sum = $sumPlus - $sumMinus;

    if($sum < 1000)
        return false;

    foreach($data as $elem) {
        $userId = $elem['userId'];
        $procent = ($elem['amount'] * 100 / 1000 ) / 100;

        $sql = "UPDATE balance SET amount = amount + $sum * $procent WHERE userId = '$userId'";
		$db->query($sql);

        $sql = "INSERT INTO balance_history (userId, type, amount) VALUES ('$userId', 8, $sum * $procent)";
		$db->query($sql);

        $sql = "INSERT INTO billionaireFund (type, amount) VALUES (0, $sum * $procent)";
		$db->query($sql);
    }

    return true;
}