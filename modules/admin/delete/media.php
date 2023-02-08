<?php
function media($db) {

        if(!empty($_GET['mType']) && !empty($_GET['fileName'])) {
                $media = $_GET['mType'] == 'videos' ? 'videos' : 'images';
                $fileName = convertStr($_GET['fileName']);
                $fileNameArr = explode("/", $fileName);
                $root = $_SERVER['DOCUMENT_ROOT'];
                $projectPathName = "digway";
        
                $imgToDel = end($fileNameArr);

		if($media == 'videos' && !empty($_GET['postId']) && !empty($_GET['authToken'])) {
				$postId = $_GET['postId'];
				$authToken = $_GET['authToken'];
                    $sql = "UPDATE products SET isVideo = 0 WHERE id = '$postId'";
                    $updateQuery = $db->query($sql);
                }

        
                $res = unlink($root . '/'.$projectPathName.'/'.$media.'/' . $imgToDel);
        
                $sql = "DELETE FROM $media WHERE link = '$fileName'";
                $deleteQuery = $db->query($sql);
        
                return $res;
        }

        return false;
}