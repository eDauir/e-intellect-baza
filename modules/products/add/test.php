<?php
function addTest($db) {

	if(!empty($_GET['authToken']) && !empty($_GET['productId']) && !empty($_GET['mentorId']) && !empty($_GET['sectionId']) && !empty($_GET['name']) && !empty($_GET['jsonValue'])) {

			$authToken = convertStr($_GET['authToken']);
            $productId = convertStr($_GET['productId']);
            $sectionId = convertStr($_GET['sectionId']);
			$name = convertStr($_GET['name']);
            $mentorId = convertStr($_GET['mentorId']);

			$sqlUser = "SELECT id FROM users WHERE id = '$mentorId' AND editor = 1";
		    $dataUser = $db->getOne($sqlUser);

		    if(!empty($dataUser)) { 
  
                $sql = "INSERT INTO lessons (name, productId, sectionId, elemType) VALUES ('$name', '$productId', '$sectionId', 0)";
                $insertQuery = $db->query($sql);
                $lessonsId = $db->insertId();

			   if($insertQuery) {

                    $sql = "INSERT INTO tests (lessonsId) VALUES ('$lessonsId')";
                    $insertQuery = $db->query($sql);
                    $testId = $db->insertId();

                    if($insertQuery) {

                        $json = $_GET['jsonValue'];

                        $jsonDecode = json_decode($json,true);
                        foreach($jsonDecode as $elem) {
                            $question = $elem['question'];

                            $sql = "INSERT INTO test_question (title, testId) VALUES ('$question', '$testId')";
                            $insertQuery = $db->query($sql);
                            $questionId = $db->insertId();

                            for($i = 0; $i < 4; $i++) {
                                $isTrue = 0;
                                
                                switch ($i)
                                {
                                    case 0:
                                        $title = $elem['ques1'];
                                        break;
                                    case 1:
                                        $title =  $elem['quest2'];
                                        break;
                                    case 2:
                                        $title =  $elem['quest3'];
                                        break;
                                    case 3:
                                        $title = $elem['quest4'];
                                        break;
                                }

                                if($i == $elem['value'])
                                    $isTrue = 1;
                                $sql = "INSERT INTO test_answer (questionId, title, isTrue) VALUES ('$questionId', '$title', '$isTrue')";
                                $insertQuery = $db->query($sql);
                            }
                                
                        }

                        $sql = "UPDATE products SET active = 1 WHERE id = '$productId'";
                        $updateQuery = $db->query($sql);

                        return true;

                    }
                
               }

               return false;
		}

	}

    return false;
}