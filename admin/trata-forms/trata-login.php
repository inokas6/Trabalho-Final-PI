<?php
    include '../../includes/config.inc.php';
    //var_dump($_POST);

//admin:admin
    if($_SERVER['REQUEST_METHOD'] === "POST"){

        $url = '../';

        $result = my_query("SELECT id_user,password FROM users WHERE username='" .$_POST['user']."'");
        $result = $result[0];


        if(password_verify($_POST['password'],$result['password'])){
            
            $_SESSION['user'] = $_POST['user'];
            $_SESSION['id'] = $result['id_user'];
        }else{
            $url .= "login.php?error=1";
        }

        header('Location: '.$url );
    }