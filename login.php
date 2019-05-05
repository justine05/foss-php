<?php

    require_once "config.php"    
    $username = $_POST["username"];
    $password = $_POST["password"];
    $dbpass = mysqli_query($db,"SELECT password FROM users WHERE username = '$username' ");
    $p = mysqli_fetch_array($dbpass)["password"];
    echo $p;

    if($p === ""){
        echo "Username does not exists";
    }
    else {
        if($p === $password){
            echo "Success";
        } 
    }

?>