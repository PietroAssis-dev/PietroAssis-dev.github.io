<?php
require_once '../config.php';
include(HEADER_TEMPLATE);
?>
<link rel="stylesheet" href="<?php echo BASEURL; ?>/assets/css/stylesobre.css">


<style>
    .container-img {
        display: flex;
        width: 100%;
        height: 80vh;
        background-image: url('<?php echo BASEURL; ?>/assets/img/foto-kamile-sobre.png');
        background-size: cover;
        background-position: center;
        color: #fff;
        font-size: 100px;
        font-weight: bold;
        text-align: center;
        justify-content: center;
        align-items: center;
    }

    @media screen and (max-width:1000px){
        .container-img{
            display: none;
        }
    }
</style>
<div style="margin-bottom: 200px;">
    <article>

        <div class="container-img">Sobre</div>
</div>
<div class="info-tatu">
    <div class="left-tatu">
        <div class="column-flex">
            <img class="img-kamile1" src="<?php echo BASEURL; ?>/assets/img/foto-kamile1.png" alt="honoink">
            <img class="img-kamile2" src="<?php echo BASEURL; ?>/assets/img/foto-kamile2.png" alt="honoink">
        </div>
    </div>

    <div class="right-tatu">
        <img class="img-kamile3" src="<?php echo BASEURL; ?>/assets/img/foto-kamile3.png" alt="honoink">
    </div>
    <div class="right-tattoo-info">
        <div class="cabecalho">
            <h1>Conhecendo a<br>tatuadora</h1>
            <p> Olá, me chamo Kamile Hono, sou tatuadora e formada
                em Design Gráfico pela Belas Artes. Iniciei os
                estudos na área da tatuagem em 2022 e concluindo minha formação no final de 2023.
                <br>
            <p>Embora o curso tenha aprimorado meus conhecimentos artísticos, desde minha infância ja sonhava em me tornar tatuadora. Assim, em julho de 2023, tive minha primeira aula de tatuagem, e em 8 de agosto de 2024, recebi uma surpresa: meu próprio estúdio de tatuagem.</p>

            </p>
        </div>
    </div>
</div>
<div style="margin-top: 267px;">
    <div class="container-estudio">
        <div class="estudio">
            <h1 class="conhecendo">Conhecendo o<br class="none"> Estúdio</h1>
            <p class="paragraph"> HoNo é um estúdio de tatuagem especializado
                em arte corporal, atendendo a uma clientela que
                busca personalização e exclusividade em seus
                designs. Comandado por uma mulher, o estúdio
                se destaca pelo atendimento personalizado,
                priorizando não apenas qualidade artística, mas
                também o compromisso com a segurança e a
                higiene, fundamentais para uma experiência
                confortável e segura para o cliente.</p>
        </div>
        <div class="imgs-estudio">
            <img class="estudio1" src="<?php echo BASEURL; ?>/assets/img/estudio1.png" alt="honoink">
            <img class="estudio2" src="<?php echo BASEURL; ?>/assets/img/estudio2.png" alt="honoink">
            <img class="estudio3" src="<?php echo BASEURL; ?>/assets/img/estudio3.png" alt="honoink">
        </div>

            <img class="estudio4" src="<?php echo BASEURL; ?>/assets/img/estudio3.png" alt="honoink">

    </div>
</div>
<div style="margin-top: 200px;">
<div class="chegar">



</div>
<div style="margin-top: 50px;">

</article>



    <?php include(FOOTER_TEMPLATE); ?>