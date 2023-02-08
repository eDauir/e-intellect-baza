<?php
function buyRates($db) {

        if(isset($_GET['id']) && isset($_GET['rateId']) && isset($_GET['activeDate']) && isset($_GET['active'])) {
                $active = convertStr($_GET['active']);
                $activeDate = convertStr($_GET['activeDate']);
                $rateId = convertStr($_GET['rateId']);
                $id = convertStr($_GET['id']);

                if(empty($activeDate)) {
                        $sql = "UPDATE buyRates SET rateId = '$rateId', activeDate = null, active = '$active' WHERE id = '$id'";
                }
                else {
                $sql = "UPDATE buyRates SET rateId = '$rateId', activeDate = '$activeDate', active = '$active' WHERE id = '$id'";
                }

                $updateQuery = $db->query($sql);

                return true;
        }

        return false;
}