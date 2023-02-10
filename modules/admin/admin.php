<?php
function admin($db) {
    if($_GET['subType'] == 'getContacts' || $_GET['subType'] == 'getSettings') {
        switch ($_GET['subType']) {
            case 'getContacts':
                include "get/contacts.php";
                $res = contacts($db);
                break;
            case 'getSettings':
                include "get/settings.php";
                $res = settings($db);
                break;
        }

        return $res;
    }

    if(!empty($_GET['authToken'])) {
        $authToken = convertStr($_GET['authToken']);

        $sql = "SELECT SQL_CALC_FOUND_ROWS users_profile.*, users.editor FROM users_profile INNER JOIN users ON users_profile.user_id = users.id WHERE users_profile.user_id = (SELECT id FROM users WHERE accessToken = '$authToken' AND editor = 2)";

        $data = $db->getAll($sql);
        $count = count($data);

        if($count > 0) {
            $resAction = action($db, $data);
            return $resAction;
        } return null;
    } 

    return null;
}

function action($db, $data) {
    switch ($_GET['subType']) {
    	case 'active':
        	include "active.php";
        	$res = active($db);
        	break;
        case 'check':
            $res = $data;
            break;
        case 'getUsers':
            include "get/users.php";
            $res = users($db);
            break;
        case 'getNews':
            include "get/news.php";
            $res = news($db);
            break;
        case 'getFund':
            include "get/fund.php";
            $res = fund($db);
            break;
         case 'getLessons':
            include "get/lessons.php";
            $res = lessons($db);
            break;
        case 'getFaq':
            include "get/faq.php";
            $res = faq($db);
            break;
        case 'getRates':
            include "get/rates.php";
            $res = rates($db);
            break;
        case 'getNotify':
            include "get/notify.php";
            $res = notify($db);
            break;
        case 'getBanner':
            include "get/banner.php";
            $res = banner($db);
            break;
        case 'getModer':
            include "get/moder.php";
            $res = moder($db);
            break;
        case 'getMentor':
            include "get/mentor.php";
            $res = mentor($db);
            break;
        case 'getPartner':
            include "get/partner.php";
            $res = partner($db);
            break;
        case 'getPosts':
            include "get/posts.php";
            $res = posts($db);
            break;
        case 'getProductStat':
            include "get/productStat.php";
            $res = productStat($db);
            break;
        case 'getUserStat':
            include "get/userStat.php";
            $res = userStat($db);
            break;
        case 'getMedia':
            include "get/media.php";
            $res = media($db);
            break;
        case 'getBalance':
            include "get/balance.php";
            $res = balance($db);
            break;
        case 'getBalanceHistory':
            include "get/balanceHistory.php";
            $res = balanceHistory($db);
            break;
        case 'getComments':
            include "get/comments.php";
            $res = comments($db);
            break;
        case 'updateContacts':
            include "update/contacts.php";
            $res = contacts($db);
            break;
        case 'updateSettings':
            include "update/settings.php";
            $res = settings($db);
            break;
        case 'updateUser':
            include "update/user.php";
            $res = user($db);
            break;
        case 'updateUserStatus':
            include "update/user.php";
            $res = changeStatus($db);
            break;
        case 'updateBuyRates':
            include "update/buyRates.php";
            $res = buyRates($db);
            break;
        case 'updateBanMentor':
            include "update/banMentor.php";
            $res = banMentor($db);
            break;
        case 'delAdmin':
            include "update/delAdmin.php";
            $res = delAdmin($db);
            break;
        case 'delNews':
            include "delete/news.php";
            $res = news($db);
            break;
        case 'delComment':
            include "delete/comment.php";
            $res = comments($db);
            break;
        case 'deleteRates':
            include "delete/rates.php";
            $res = rates($db);
            break;
        case 'deleteNotify':
            include "delete/notify.php";
            $res = notify($db);
            break;
        case 'deleteBanner':
            include "delete/banner.php";
            $res = banner($db);
            break;
        case 'deletePost':
            include "delete/post.php";
            $res = post($db);
            break;
        case 'deleteUser':
            include "delete/user.php";
            $res = user($db);
            break;
        case 'deleteMedia':
            include "delete/media.php";
            $res = media($db);
            break;
        case 'deleteFaq':
            include "delete/faq.php";
            $res = faq($db);
            break;
        case 'deleteLessons':
            include "delete/lessons.php";
            $res = lessons($db);
            break;
        case 'getGlobal':
            include "setup/getGlobal.php";
            $res = getGlobal($db);
            break;
        case 'insertNotify':
            include "insert/notify.php";
            $res = notify($db);
            break;
        case 'insertRates':
            include "insert/rates.php";
            $res = rates($db);
            break;
        case 'insertFaq':
            include "insert/faq.php";
            $res = faq($db);
            break;
        case 'getCategory':
            include "get/category.php";
            $res = getCategory($db);
            break;
    }
    return $res;
}