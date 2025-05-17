<?php

//menu
echo '<nav class="navbar navbar-expand-lg navbar-light shadow">
        <div class="container d-flex justify-content-between align-items-center">

            <a class="navbar-brand text-success logo h1 align-self-center" href="index.php">
                Green Shop
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
                <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">';


    $result = my_query('SELECT * FROM menus WHERE ling = "' . $_SESSION['ling'] . '" ORDER BY ordem');

    foreach($result as $val){
        echo '<li class="nav-item">
                            <a class="nav-link" href="'.$val['pag'].'">'.$val['menu'].'</a>
                        </li>';
    }

    echo '               </ul> </div>
                <select id="ling">';

                if($_SESSION['ling'] === 'pt'){
                    echo '<option value="pt" selected>Português</option>
                    <option value="en" >English</option>';
                }else{
                    echo '<option value="pt" >Português</option>
                    <option value="en" selected>English</option>';
                }

                echo'
                </select>
                <div class="navbar align-self-center d-flex">
                    
                </div>
            </div>

        </div>
    </nav>';