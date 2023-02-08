<?php
function rates($db) {
        
        if(!empty($_GET['name']) && !empty($_GET['price']) && !empty($_GET['about']) && !empty($_GET['day']) ) {
            $name= convertStr($_GET['name']);
            $price = convertStr($_GET['price']);
            $about = convertStr($_GET['about']);
            $day = convertStr($_GET['day']);

            $sql = "INSERT INTO rates (name, price, about, day) VALUES ('$name', '$price', '$about', '$day')";
            $insertQuery = $db->query($sql);

            return true;
        }

        return false;
}