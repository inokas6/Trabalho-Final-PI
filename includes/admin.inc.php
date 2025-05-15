<?php

    if(checkPath("admin") && !isVarSet($_SESSION['user']) && !checkPath("trata-login.php")){
        header('Location: login.php');
    }




    function checkPath($name){

        $arr_path = explode("/",$_SERVER['PHP_SELF']);

        foreach($arr_path as $path){

            if($path == $name){
                return true;
            }

        }
        return false;

    }