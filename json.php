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

    $query = 'SELECT T.idTwit,loginUser,nomUser,SUBSTRING(messageTwit,1,20) AS messageTwit,dateTwit
            FROM users U 
            JOIN reltwitusers R ON R.idUser = U.idUser 
            JOIN twit T ON T.idTwit = R.idTwit
            LEFT OUTER JOIN favori F ON F.idTwit = R.idTwit
            WHERE idUser = "'.$_SESSION['id'].'"
            ORDER BY dateTwit DESC
            LIMIT :nb1, :nb2';
    $data = $db->prepare($query);
    $data->bindValue('nb1',$_SESSION['nb'],PDO::PARAM_INT);
    $data->bindValue('nb2',8,PDO::PARAM_INT);
    $data->execute();
    $result2 = $data->fetchAll(PDO::FETCH_ASSOC);
    $toto[] = $result2;

    $query = 'SELECT * FROM favori WHERE idUser = "'.$_SESSION['id'].'" AND idTwit = "'.$result[$i]['idTwit'].'"';
    $data = $db->prepare($query);
    $data->execute();
    $result3 = $data->fetchAll(PDO::FETCH_ASSOC);
    $toto[] = $result3;

    echo json_encode($toto);
?>