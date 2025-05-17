<?php
    include  'includes/config.inc.php';
    include  'includes/header.inc.php';
    include 'includes/nav.inc.php';
?>


    <!-- Start Notícias Section -->
    <section class="container py-5">
        <div class="row">
            <!-- Notícia 1 -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="assets/img/noticia1.jpg" class="card-img-top" alt="Notícia 1">
                    <div class="card-body">
                        <h5 class="card-title">Benefícios dos Produtos Orgânicos</h5>
                        <p class="card-text">Descubra por que os produtos orgânicos são melhores para sua saúde e para o meio ambiente.</p>
                        <a href="#" class="btn btn-primary">Ler mais</a>
                    </div>
                </div>
            </div>

            <!-- Notícia 2 -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="assets/img/noticia2.jpg" class="card-img-top" alt="Notícia 2">
                    <div class="card-body">
                        <h5 class="card-title">Dicas de Alimentação Saudável</h5>
                        <p class="card-text">Aprenda como manter uma alimentação equilibrada e nutritiva no seu dia a dia.</p>
                        <a href="#" class="btn btn-primary">Ler mais</a>
                    </div>
                </div>
            </div>

            <!-- Notícia 3 -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="assets/img/noticia3.jpg" class="card-img-top" alt="Notícia 3">
                    <div class="card-body">
                        <h5 class="card-title">Novos Produtos na Loja</h5>
                        <p class="card-text">Conheça os novos produtos orgânicos que acabaram de chegar em nossa loja.</p>
                        <a href="#" class="btn btn-primary">Ler mais</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paginação -->
        <nav aria-label="Navegação de notícias">
            <ul class="pagination justify-content-center mt-4">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Anterior</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Próximo</a>
                </li>
            </ul>
        </nav>
    </section>
    <!-- End Notícias Section -->

<?php
    include  'includes/footer.inc.php';
?> 