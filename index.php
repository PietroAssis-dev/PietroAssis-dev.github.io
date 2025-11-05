<?php
require "config.php";
if (!isset($_SESSION))
    session_start();
include(HEADER_TEMPLATE);
?>
<link rel="stylesheet" href="<?php echo BASEURL; ?>/assets/css/styleindex.css">

<main>
    <div class="grid">
        <div class="text">
            <div class="welcome-container">
                <span class="welcome">Bem-vindo ao</span><br>
                <span class="span-hono">HONO</span>         
                <span class="span-where">Onde sua história<br>vira arte na pele..</span>
                <span class="info-text">
                    No lugar em que cada traço carrega um significado. Transformamos suas ideias
                    em tatuagens feitas com segurança, precisão e amor pela arte.
                </span>
                <span class="spell">Especialista em Fine line e Blackwork</span>
                
                    <span class="agen">Agende já o seu horário</span>
                    <a class="btn-agen" href="<?php echo BASEURL; ?>/orçamento/index.php">AQUI</a>
               
            </div>
        </div>

        <div>
            <img class="img-kamile" src="<?php echo BASEURL; ?>/assets/img/foto-kamile.png" alt="honoink">
        </div>
    </div>
</main>
<hr>
<article>
    <div class="tracos">
        <div class="grid-tracos">
            <div class="left-tracos">
                <p class="txt-tracos">TRAÇOS</p>
                <div class="container-imagens">
                    <img src="<?php echo BASEURL; ?>/assets/img/tattoo 1.jpg" alt="Tattoo 1">
                    <img src="<?php echo BASEURL; ?>/assets/img/tattoo 2.jpg" alt="Tattoo 2">
                    <img src="<?php echo BASEURL; ?>/assets/img/tattoo 4.jpg" alt="Tattoo 4">
                    <img src="<?php echo BASEURL; ?>/assets/img/tattoo 3.jpg" alt="Tattoo 3">
                </div>
            </div>

            <div class="right-tracos-container">
                <div class="right-tracos">
                    <p class="tracos2">TRAÇOS</p>
                    <div class="txt-tracos-info">
                        <span class="info-text-traco">Fineline</span>
                        <p class="tracos-p">Traços finos e precisos, que destacam detalhes delicados e sutis. Elegante,
                            leve e minimalista.</p>
                    </div>
                </div>
                <div class="right-tracos">
                    <div class="txt-tracos-info">
                        <span class="info-text-traco">Blackwork</span>
                        <p class="tracos-p">O estilo de tatuagem blackwork é caracterizado pelo uso exclusivo de tinta
                            preta para criar designs impactantes e visualmente marcantes.</p>
                    </div>
                </div>
                <div class="right-tracos">
                    <div class="txt-tracos-info">
                        <span class="info-text-traco">Semi-realista</span>
                        <p class="tracos-p">O estilo combina o realismo com a liberdade expressiva da ilustração,
                            criando designs que são detalhados, mas com um toque estilizado e único.</p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
</article>

<div class="grid-galeria">
    <div class="ultimas-tattoos">Últimas Tatuagens</div>
    <div class="carousel" mask role="list" style="--items:6;">
        <article style="--i:0">
            <img src="<?php echo BASEURL; ?>/assets/img/tattoo 1.jpg" alt="Tattoo 1">

            <h2 class="cards-roda-info">Cara com borboleta</h2>

        </article>

        <article style="--i:1">
            <img src="<?php echo BASEURL; ?>/assets/img/tattoo 2.jpg" alt="Tattoo 1">
            <h2 class="cards-roda-info">Copo</h2>

        </article>

        <article style="--i:2">
            <img src="<?php echo BASEURL; ?>/assets/img/tattoo 3.jpg" alt="Tattoo 1">
            <h2 class="cards-roda-info">Aguia americana</h2>

        </article>

        <article style="--i:3">
            <img src="<?php echo BASEURL; ?>/assets/img/tattoo 4.jpg" alt="Tattoo 1">
            <h2 class="cards-roda-info">Flores</h2>

        </article>

        <article style="--i:4">
            <img src="<?php echo BASEURL; ?>/assets/img/cards/rosas tattoo.jpg" alt="Tattoo 1">
            <h2 class="cards-roda-info">Rosa</h2>

        </article>

        <article style="--i:5">
            <img src="<?php echo BASEURL; ?>/assets/img/cards/leque tattoo.jpg" alt="Tattoo 1">
            <h2 class="cards-roda-info">Leque</h2>

        </article>
    </div>
    <a class="btn-gal" href="galeria/index.php">VER GALERIA</a>

</div>

<div style="margin-top:300px;"></div>

<?php include(FOOTER_TEMPLATE); ?>