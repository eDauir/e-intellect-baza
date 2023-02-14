<?php

function updateCategory ($db) {
    if(isset($_GET['nameCat']) && isset($_GET['updateId'])) {
        $nameCat = convertStr($_GET['nameCat']);
        $id = convertStr($_GET['updateId']);

        $sql =  "UPDATE category SET name = '$nameCat' WHERE id = '$id'";
        
        $updateQuery = $db->query($sql);
    
        return true;
    }
}

