<?php 

function insertCategory ($db) {
    if(isset($_GET['nameCat'])) {
        $nameCat = convertStr($_GET['nameCat']);
        $sql =  "INSERT INTO category (name) VALUES ('$nameCat')";
        $insetQuery = $db->query($sql);
        return true;
    }
};