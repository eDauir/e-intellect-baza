<?php
function get($db) {
    if(isset($_GET['authToken'])) {
        $authToken = convertStr($_GET['authToken']);

        $sql = "SELECT mentorId FROM linkPartnerMentor WHERE partnerId = (SELECT id FROM users WHERE accessToken = '$authToken')";
        $mentorList = $db->getAll($sql);

        $countCourse = 0;

        foreach($mentorList as $mentor) {
            $countCourse++;
            $mentorId = $mentor['id'];
            $sql = "SELECT id FROM products WHERE userId = '$mentorId'";
            $data[] = $db->getAll($sql);
        }

        $countRating = 0;
        $excellent = 0;
        $good = 0;
        $average = 0;
        $poor = 0;
        $terrible = 0;

        $customer = 0;
        $money = 0;

        $month1 = 0;
        $month2 = 0;
        $month3 = 0;
        $month4 = 0;
        $month5 = 0;
        $month6 = 0;

        foreach($data as $product) {
            $productId = $product['id'];
            $sql = "SELECT COUNT(id) as ratingCount, AVG(rating) as ratingAvg FROM comments WHERE productId = '$productId'";
            $count = $db->getAll($sql);
            $countRating += $count[0]['ratingCount'];

            $sql = "SELECT COUNT(id) as ratingCount FROM comments WHERE productId = '$productId' AND rating = 5";
            $ratRow = $db->getOne($sql);
            $excellent +=  $ratRow;

            $sql = "SELECT COUNT(id) as ratingCount FROM comments WHERE productId = '$productId' AND rating = 4";
            $ratRow = $db->getOne($sql);
            $good += $ratRow;

            $sql = "SELECT COUNT(id) as ratingCount FROM comments WHERE productId = '$productId' AND rating = 3";
            $ratRow = $db->getOne($sql);
            $average += $ratRow;
            
            $sql = "SELECT COUNT(id) as ratingCount FROM comments WHERE productId = '$productId' AND rating = 2";
            $ratRow = $db->getOne($sql);
            $poor += $ratRow;

            $sql = "SELECT COUNT(id) as ratingCount FROM comments WHERE productId = '$productId' AND rating = 1";
            $ratRow = $db->getOne($sql);
            $terrible += $ratRow;

            $sql = "SELECT COUNT(id) as countOrders FROM orders WHERE productId = '$productId'";
            $ratRow = $db->getOne($sql);
            $customer += $ratRow;

            $sql = "SELECT SUM(products.price) as priceSum FROM orders INNER JOIN products ON products.id = orders.productId WHERE orders.productId = '$productId'";
            $ratRow = $db->getOne($sql);
            $money += $ratRow;

            $sql = "SELECT COUNT(id) as countOrders FROM orders WHERE productId = '$productId' AND date > DATE(NOW() - INTERVAL 1 MONTH) AND date < now()";
            $ratRow = $db->getOne($sql);
            $month1 += $ratRow;

            $sql = "SELECT COUNT(id) as countOrders FROM orders WHERE productId = '$productId' AND date > DATE(NOW() - INTERVAL 2 MONTH) AND date < DATE(NOW() - INTERVAL 1 MONTH)";
            $ratRow = $db->getOne($sql);
            $month2 += $ratRow;

            $sql = "SELECT COUNT(id) as countOrders FROM orders WHERE productId = '$productId' AND date > DATE(NOW() - INTERVAL 3 MONTH) AND date < DATE(NOW() - INTERVAL 2 MONTH)";
            $ratRow = $db->getOne($sql);
            $month3 += $ratRow;

            $sql = "SELECT COUNT(id) as countOrders FROM orders WHERE productId = '$productId' AND date > DATE(NOW() - INTERVAL 4 MONTH) AND date < DATE(NOW() - INTERVAL 3 MONTH)";
            $ratRow = $db->getOne($sql);
            $month4 += $ratRow;

            $sql = "SELECT COUNT(id) as countOrders FROM orders WHERE productId = '$productId' AND date > DATE(NOW() - INTERVAL 5 MONTH) AND date < DATE(NOW() - INTERVAL 4 MONTH)";
            $ratRow = $db->getOne($sql);
            $month5 += $ratRow;

            $sql = "SELECT COUNT(id) as countOrders FROM orders WHERE productId = '$productId' AND date > DATE(NOW() - INTERVAL 6 MONTH) AND date < DATE(NOW() - INTERVAL 5 MONTH)";
            $ratRow = $db->getOne($sql);
            $month6 += $ratRow;

        }

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

        $res = array();

        $reviews = array();

        $reviews['countRating'] = $countRating;
        $reviews['avgRating'] = $count[0]['ratingAvg'];
        $reviews['excellent'] = $excellent;
        $reviews['good'] = $good;
        $reviews['average'] = $average;
        $reviews['poor'] = $poor;
        $reviews['terrible'] = $terrible;

        $dt = strtotime("now");

        $sales = array();

        $vrem['value'] = $month1;
        $vrem['name'] = $rusMonthNames[intval(date("m",  strtotime("-1 month", $dt)))];

        $sales[] = $vrem;

        $vrem['value'] = $month2;
        $vrem['name'] = $rusMonthNames[intval(date('m',  strtotime("-2 month", $dt)))];

        $sales[] = $vrem;

        $vrem['value'] = $month3;
        $vrem['name'] = $rusMonthNames[intval(date("m",  strtotime("-3 month", $dt)))];

        $sales[] = $vrem;

        $vrem['value'] = $month4;
        $vrem['name'] = $rusMonthNames[intval(date("m",  strtotime("-4 month", $dt)))];

        $sales[] = $vrem;

        $vrem['value'] = $month5;
        $vrem['name'] = $rusMonthNames[intval(date("m",  strtotime("-5 month", $dt)))];

        $sales[] = $vrem;

        $vrem['value'] = $month6;
        $vrem['name'] = $rusMonthNames[intval(date("m",  strtotime("-6 month", $dt)))];

        $sales[] = $vrem;

        $res['reviews'] = $reviews;
        $res['sales'] = $sales;
        $res['customer'] = $customer;
        $res['money'] = $money / 2;
        $res['mentor'] = count($mentorList);
        $res['course'] = $countCourse;

        return $res;
    }
}