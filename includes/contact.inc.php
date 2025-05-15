<?php

include 'header.inc.php';

echo '<body>';




include 'nav.inc.php';

$result = my_query('SELECT * FROM contacte_nos WHERE ling="' . $_SESSION['ling'].'"');
$result = $result[0];

echo '<body>';

echo '<div class="container-fluid bg-light py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1">'.$result['titulo'].'</h1>
            <p>
                '.$result['texto'].'
            </p>
        </div>
    </div>

    <!-- Start Contact -->
    <div class="container py-5">
        <div class="row py-5">
            <form class="col-md-9 m-auto" method="post" role="form">
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputname">'.$result['input_nome'].'</label>
                        <input type="text" class="form-control mt-1" id="name" name="name" placeholder="'.$result['input_nome'].'">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputemail">'.$result['input_email'].'</label>
                        <input type="email" class="form-control mt-1" id="email" name="email" placeholder="'.$result['input_email'].'">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputsubject">'.$result['input_tema'].'</label>
                    <input type="text" class="form-control mt-1" id="subject" name="subject" placeholder="'.$result['input_tema'].'">
                </div>
                <div class="mb-3">
                    <label for="inputmessage">'.$result['input_conteudo'].'</label>
                    <textarea class="form-control mt-1" id="message" name="message" placeholder="'.$result['input_conteudo'].'" rows="8"></textarea>
                </div>
                <div class="row">
                    <div class="col text-end mt-2">
                        <button type="submit" class="btn btn-success btn-lg px-3">'.$result['botao'].'</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Contact -->';

    include 'footer.inc.php';
echo '</body>';
include 'scripts.inc.php';

echo '</html>';