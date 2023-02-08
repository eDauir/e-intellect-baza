<?php
function productStat($db) {
        // USLOVIE 

        if(!empty($_GET['periodOffer']) && !empty($_GET['periodMentor']) && !empty($_GET['periodCourse']) && !empty($_GET['periodClient']) && !empty($_GET['periodTarif']) && !empty($_GET['periodPartner']) && !empty($_GET['periodNews']) && !empty($_GET['periodFinance']) && !empty($_GET['periodMentorBonus']) && !empty($_GET['periodPartnerBonus'])) {

                $arrayToJson['allOrderSum'] = getAllOrderSum($db) ?? '0';
                $arrayToJson['allOfferCount'] = getOfferCount($db, getPeriod($_GET['periodOffer'])) ?? '0';
                $arrayToJson['mentor'] = getMentorStat($db, getPeriod($_GET['periodMentor']));
                $arrayToJson['partner'] = getPartnerStat($db, getPeriod($_GET['periodPartner']));
                $arrayToJson['course'] = getCourseStat($db, getPeriod($_GET['periodCourse']));
                $arrayToJson['news'] = getNewsStat($db, getPeriod($_GET['periodNews']));
                $arrayToJson['client'] = getClientStat($db, getPeriod($_GET['periodClient']));
                $arrayToJson['finance'] = getFinanceStat($db, getPeriod($_GET['periodFinance']));
                $arrayToJson['mentorBonus'] = getBonusMentor($db, getPeriod($_GET['periodMentorBonus']));
                $arrayToJson['partnerBonsus'] = getBonusPartner($db, getPeriod($_GET['periodPartnerBonus']));
                $arrayToJson['totalProfit'] = getTotalProfit($db);
                $arrayToJson['tarif'] = getTarifStat($db, getPeriod($_GET['periodTarif']));
        
                return $arrayToJson;

        }

        return false;
}

function getPeriod($period) {
        switch ($period) {
                case 30:
                    return date('Y-m-d', strtotime('- 1 months'));
                case 365:
                    return date('Y-m-d', strtotime('- 1 year'));
                default:
                    return '0001-01-01';
        }
}

function getTarifStat($db) {
        $sql = "SELECT name, price, id FROM rates";
        $data = $db->getAll($sql);
        $res = array();

        foreach($data as $item) {
                $rateId = $item['id'];

                $sql = "SELECT COUNT(id) FROM buyRates WHERE rateId = $rateId";
                $countSales = $db->getOne($sql);

                $item['sales'] = $countSales;
                $res[] = $item;
        }

        return $res;
}

function getTotalProfit($db) {
        $profitSum = [];
        $rusMonthNames = [
                'Январь',
                'Февраль',
                'Март',
                'Апрель',
                'Май',
                'Июнь',
                'Июль',
                'Август',
                'Сентябрь',
                'Октябрь',
                'Ноябрь',
                'Декабрь',
            ];

        for($i = 0; $i < 12; $i++) {
            $sql = "SELECT COUNT(id) FROM orders WHERE date > DATE(NOW() - INTERVAL $i + 1 MONTH) AND date < DATE(NOW() - INTERVAL $i MONTH)";

            $calculate = $i + 1;
            $profitSum[$rusMonthNames[intval(date("m",  strtotime("-$calculate month")))] ?? 'Январь'] = $db->getOne($sql);
        } 

        return $profitSum;
}

function getClientStat($db, $period) {
        $res = array();

        $sql = "SELECT COUNT(id) FROM users WHERE date BETWEEN '$period' AND now()";
        $res['count'] = $db->getOne($sql);

        $sql = "SELECT COUNT(id) FROM users WHERE date BETWEEN '$period' AND now() AND activeStatus = 1";
        $res['active'] = $db->getOne($sql);
        
        return $res;
}

function getCourseStat($db, $period) {
        $res = array();

        $sql = "SELECT COUNT(id) FROM products WHERE date BETWEEN '$period' AND now()";
        $res['count'] = $db->getOne($sql);

        $sql = "SELECT COUNT(DISTINCT userId) FROM orders WHERE date BETWEEN '$period' AND now()";
        $res['students'] = $db->getOne($sql);

        $sql = "SELECT COUNT(id) FROM orders WHERE date BETWEEN '$period' AND now()";
        $res['sales'] = $db->getOne($sql);

        $sql = "SELECT COUNT(id) FROM products WHERE active = 1 AND date BETWEEN '$period' AND now()";
        $res['active'] = $db->getOne($sql);
        
        return $res;
}

function getNewsStat($db, $period) {
        $res = array();

        $sql = "SELECT COUNT(id) FROM news WHERE date BETWEEN '$period' AND now()";
        $res['count'] = $db->getOne($sql);

        $sql = "SELECT COUNT(id) FROM news WHERE status = 1 AND date BETWEEN '$period' AND now()";
        $res['active'] = $db->getOne($sql);
        
        return $res;
}

function getMentorStat($db, $period) {
        $res = array();

        $sql = "SELECT COUNT(id) FROM users WHERE editor = 1 OR editor = 4 AND date BETWEEN '$period' AND now()";
        $res['count'] = $db->getOne($sql);

        $sql = "SELECT COUNT(id) FROM users WHERE editor = 1 AND date BETWEEN '$period' AND now() AND id IN (SELECT userId FROM products)";
        $res['active'] = $db->getOne($sql);
        
        return $res;
}

function getPartnerStat($db, $period) {
        $res = array();

        $sql = "SELECT id FROM users WHERE editor = 3 AND date BETWEEN '$period' AND now()";
        $sqlResult = $db->getAll($sql);
        $res['count'] = strval(count($sqlResult));

        $countActive = 0;
        foreach($sqlResult as $elem) {
                $userId = $elem['id'];

                $sql = "SELECT buyRates.*, rates.day as rateDay FROM buyRates LEFT JOIN rates ON rates.id = buyRates.rateId WHERE userId = $userId";
                $buyRates = $db->getAll($sql);
                $oldDate = $buyRates[0]['activeDate'];
                $date1 = date("Y-m-d", strtotime($oldDate.'+ '.$buyRates[0]['rateDay'].' days'));
                $nowDate = date('Y-m-d');
                if ($date1 >= $nowDate) {
                        $countActive++;
                }
        }

        $res['active'] = strval($countActive);
        
        return $res;
}

function getFinanceStat($db, $period) {
        $res = array();

        $res['sells'] = getOfferCount($db, $period);

        $sql = "SELECT COUNT(DISTINCT userId) FROM orders WHERE date BETWEEN '$period' AND now()";
        $res['customers'] = $db->getOne($sql);

        $sql = "SELECT SUM(products.price) FROM orders LEFT JOIN products ON orders.productId = products.id WHERE orders.date BETWEEN '$period' AND now()";
        $res['sum'] = $db->getOne($sql);
        
        return $res;
}

function getBonusMentor($db, $period) {
        $res = array();

        $sql = "SELECT COUNT(id) FROM products WHERE date BETWEEN '$period' AND now()";
        $res['course'] = $db->getOne($sql);

        $sql = "SELECT SUM(amount) FROM balance_history WHERE type = 6 AND date BETWEEN '$period' AND now()";
        $res['sum'] = $db->getOne($sql);
        
        return $res;
}

function getBonusPartner($db, $period) {
        $res = array();

        $sql = "SELECT COUNT(id) FROM products WHERE date BETWEEN '$period' AND now()";
        $res['course'] = $db->getOne($sql);

        $sql = "SELECT SUM(amount) FROM balance_history WHERE type = 3 AND date BETWEEN '$period' AND now()";
        $res['sum'] = $db->getOne($sql);
        
        return $res;
}


function getOfferCount($db, $period) {
        $sql = "SELECT COUNT(id) FROM orders WHERE date BETWEEN '$period' AND now()";
        return $db->getOne($sql);
}

function getAllOrderSum($db) {
        $sql = "SELECT SUM(products.price) FROM orders LEFT JOIN products ON orders.productId = products.id";
        return $db->getOne($sql);
}