<?php
function category($db) {
   switch($_GET['subType']) {
      case 'get':
         $sql  = "SELECT SQL_CALC_FOUND_ROWS * FROM category";
         $data = $db->getAll($sql);
         $res = $data;
         break;
   }

   return $res;
}