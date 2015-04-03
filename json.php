<?php
//session_start();
//session_destroy();
session_start();
    $meow = 'Meow_kitty_cat';
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
    $query = 'SELECT loginUser,nomUser,SUBSTRING(messageTwit,1,20) AS messageTwit,dateTwit
            FROM users U 
            JOIN reltwitusers R ON R.idUser = U.idUser 
            JOIN twit T ON T.idTwit = R.idTwit
            ORDER BY dateTwit DESC';
    $data = $db->prepare($query);
    $data->execute();
    $result = $data->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);

    
?>