<?php
function getBanner($db) {
    $sql = "SELECT * FROM banner";
    $data = $db->getAll($sql);

    return $data;
}