<?php
function filter($db, $start, $orderBy, $orderType, $priceFrom, $priceTo, $roomFrom, $roomTo, $squareFrom, $squareTo, $yearFrom, $yearTo) {
        $per_page = 10;

        include 'sql.php';

        $data = $db->getAll($sql, $start, $per_page);
        $rows = $db->getOne("SELECT FOUND_ROWS()");

        $num_pages = ceil($rows / $per_page);

        $sql = "SELECT COUNT(products.id) as idCount FROM products WHERE active = 1";

        if(!empty($_GET['searchKey'])) {
                $searchKey = convertStr($_GET['searchKey']);
            
                $sql = "SELECT COUNT(products.id) as idCount FROM products WHERE active = 1 AND products.name LIKE '%$searchKey%'";
        }

        $count = $db->getOne($sql);

        $arrayToJson = array();
        $arrayToJson['count'] = $num_pages;
        $arrayToJson['total'] = $count;
        $arrayToJson['products'] = $data;

        return $arrayToJson;
}