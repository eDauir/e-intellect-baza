<?php
function chooseQuery($getType, $db) {
    switch ($getType) {
    case 'auth':
        include "modules/account/auth/auth.php";
        $res = auth($db);
        break;
    case 'reg':
        include "modules/account/reg/reg.php";
        $res = reg($db);
        break;
    case 'news':
        include "modules/news/getNews.php";
        $res = getNews($db);
        break;
    case 'recovery':
        include "modules/account/recovery/recovery.php";
        $res = recovery($db);
        break;
    case 'profile':
        include "modules/profile/profile.php";
        $res = profile($db);
        break;
    case 'products':
        include "modules/products/products.php";
        $res = products($db);
        break;
    case 'like':
        include "modules/like/like.php";
        $res = like($db);
        break;
    case 'comment':
        include "modules/comment/comment.php";
        $res = comment($db);
        break;
    case 'user':
        include "modules/user/user.php";
        $res = user($db);
        break;
    case 'admin':
        include "modules/admin/admin.php";
        $res = admin($db);
        break;
    case 'banner':
        include "modules/banner/getBanner.php";
        $res = getBanner($db);
        break;
    case 'notify':
        include "modules/notify/getNotify.php";
        $res = getNotify($db);
        break;
    case 'faq':
        include "modules/faq/getFaq.php";
        $res = getFaq($db);
        break;
    case 'category':
        include "modules/category/category.php";
        $res = category($db);
        break;
    case 'progress':
        include "modules/progress/progress.php";
        $res = progress($db);
        break;
    case 'orders':
        include "modules/orders/orders.php";
        $res = orders($db);
        break;
    case 'test':
        include "modules/test/test.php";
        $res = test($db);
        break;
    case 'rate':
        include "modules/rates/rate.php";
        $res = rate($db);
        break;
    case 'stat':
        include "modules/stat/stat.php";
        $res = statics($db);
        break;
    case 'balance':
        include "modules/balance/balance.php";
        $res = balance($db);
        break;
    case 'partner':
        include "modules/partner/partner.php";
        $res = partner($db);
        break;
    case 'units':
        include "modules/units/units.php";
        $res = units($db);
        break;
    case 'books':
        include "modules/books/books.php";
        $res = books($db);
        break;
    }
    return $res;
}