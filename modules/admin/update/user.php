<?php
function user($db) {
        
        if(isset($_GET['name']) && isset($_GET['surname']) && isset($_GET['otchestvo']) && isset($_GET['id']) && isset($_GET['telephone']) && isset($_GET['editor']) && isset($_GET['geo']) && isset($_GET['birthday']) && isset($_GET['pol']) && isset($_GET['job']) && isset($_GET['about']) && isset($_GET['mail'])) {

                $name = convertStr($_GET['name']);
                $surname = convertStr($_GET['surname']);
                $otchestvo = convertStr($_GET['otchestvo']);
                $id = convertStr($_GET['id']);
                $telephone = convertStr($_GET['telephone']);
                $editor = convertStr($_GET['editor']);
                $geo = convertStr($_GET['geo']);
                $birthday = convertStr($_GET['birthday']);
                $pol = convertStr($_GET['pol']);
                $job = convertStr($_GET['job']);
                $about = convertStr($_GET['about']);
                $mail = convertStr($_GET['mail']);

                if(empty($birthday)) {
                        $sql = "UPDATE users_profile SET name = '$name', surname = '$surname', otchestvo = '$otchestvo', telephone = '$telephone', geo = '$geo', pol = '$pol', job = '$job', about = '$about' WHERE user_id = '$id'";
                }
                else $sql = "UPDATE users_profile SET name = '$name', surname = '$surname', otchestvo = '$otchestvo', telephone = '$telephone', geo = '$geo', birthday = '$birthday', pol = '$pol', job = '$job', about = '$about' WHERE user_id = '$id'";

                $updateQuery = $db->query($sql);

                $sql = "UPDATE users SET editor = '$editor', mail = '$mail' WHERE id = '$id'";
                $updateQuery = $db->query($sql);

                return true;
        }

        return false;
}