<?
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

include "functions/shortFunctions.php";
include "functions/chooseModule.php";

function returnQuery($res) {
	echo json_encode($res);
}

function acceptQuery($getType) {
	include 'db/safemysql.class.php';
    $db = new safeMysql();

    $res = chooseQuery($getType, $db);

	returnQuery($res);
}

function checkQuery() {
	if(isset($_GET['type'])) return convertStr($_GET['type']);
	else return false;
}


$getType = checkQuery();

if($getType != false) {
	acceptQuery($getType);	
}