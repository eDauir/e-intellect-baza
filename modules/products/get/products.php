 <?php
function getStart() {
    $cur_page = 1;
    $per_page = 10;
    if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = convertStr($_GET['page']);
    $start = ($cur_page - 1) * $per_page;
    return $start;
}

function checkGetParam($var, $ifNull) {
    if (!empty($var)) {
        $var = convertStr($var);
        return $var;
    }
    return $ifNull;
}

function getProducts($db) {
    $start = getStart();
    $orderBy = checkGetParam($_GET['orderBy'], 'id');
    $orderType = checkGetParam($_GET['orderType'], 'DESC');
    $priceFrom = checkGetParam($_GET['priceFrom'], 0);
    $priceTo = checkGetParam($_GET['priceTo'], 9999999999);
    $roomFrom = checkGetParam($_GET['roomFrom'], 0);
    $roomTo = checkGetParam($_GET['roomTo'], 99);
    $squareFrom = checkGetParam(intval($_GET['squareFrom']), 0);
    $squareTo = checkGetParam(intval($_GET['squareTo']), 999999999);
    $yearFrom = checkGetParam($_GET['yearFrom'], 0);
    $yearTo = checkGetParam($_GET['yearTo'], 999999999);

    include 'filter/filter.php';
  
    $res = filter($db, $start, $orderBy, $orderType, $priceFrom, $priceTo, $roomFrom, $roomTo, $squareFrom, $squareTo, $yearFrom, $yearTo);
    
    return $res;
}