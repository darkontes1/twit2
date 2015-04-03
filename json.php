<?php
//session_start();
//session_destroy();
session_start();
    $meow = 'Meow_kitty_cat';
    $toto = array();
    if(empty($_SESSION)){  //Préférer utiliser empty plutôt que isset pour les session car un session_start déclare une fonction directement
        $_SESSION['nb'] = 0;
        $_SESSION['connect'] = FALSE;
        $_SESSION['login'] = $meow;
        $_SESSION['id'] = -1;
        $_SESSION['idTwit'] = '';
    }
    try{
    //Syntaxe init PDO => $host;$BDD,$name,$mdp
        $db = new PDO('mysql:host=localhost;dbname=twitr','root','');
    } catch(PDOException $ex){
       echo '<br/>';
       echo 'echec lors de la connexion a MySQL : ('.$ex->getCode().')';
       echo $ex->getMessage();
       exit();
    }

    $query = 'SELECT COUNT(*)
            FROM reltwitusers R';
    $data = $db->prepare($query);
    $data->execute();
    $result = $data->fetchAll(PDO::FETCH_ASSOC);
    $toto[] = $result;

    $query = "SELECT T.idTwit, IF(F.idUser, 1, 0) AS fav, U.nomUser,loginUser,nomUser,SUBSTRING(messageTwit,1,20) AS messageTwit,dateTwit
        FROM twit T 
        JOIN reltwitusers R ON T.idTwit = R.idTwit
        JOIN users U ON U.idUser = R.idUser
        LEFT OUTER JOIN favori F ON T.idTwit = F.idTwit 
        AND F.idUser = {$_SESSION['id']} 
        ORDER BY dateTwit DESC;";
    $data = $db->prepare($query);
    $data->bindValue('nb1',$_SESSION['nb'],PDO::PARAM_INT);
    $data->bindValue('nb2',8,PDO::PARAM_INT);
    $data->execute();
    $result2 = $data->fetchAll(PDO::FETCH_ASSOC);
    $toto[] = $result2;
    //print_r($toto);
    $toto[] = $_SESSION['login'];
    echo json_encode($toto);

?>