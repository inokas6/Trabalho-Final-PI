<?php
    include  'includes/config.inc.php';
    include  'includes/header.inc.php';
?>

    <!-- Start Banner Hero -->
    <div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="assets/img/banner_img_01.jpg" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left align-self-center">
                                <h1 class="h1">Notícias e Atualizações</h1>
                                <p>
                                    Fique por dentro das últimas novidades, dicas e informações sobre produtos naturais e orgânicos.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Banner Hero -->

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