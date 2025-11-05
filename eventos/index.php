<?php
require_once '../config.php';
include(HEADER_TEMPLATE);
$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
$stmt = $pdo->query("SELECT * FROM cards_eventos ORDER BY id ASC");
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="<?php echo BASEURL; ?>/assets/css/stylesevento.css">
<style>
    .container-img {
        display: flex;
        width: 100%;
        height: 80vh;
        background-image: url('<?php echo BASEURL; ?>/assets/img/evento-foto.png');
        background-size: cover;
        background-position: center;
        color: #fff;
        font-size: 100px;
        font-weight: bold;
        text-align: center;
        justify-content: center;
        align-items: center;
    }

    @media screen and (max-width:950px) {
        .container-img {
            display: none;
        }
    }
    
</style>

<div class="container-img"> Eventos </div>

<div class="info-inicial">
    <div class="info-text">
        <h1 class="info-titulo">O que são os <br class="br-responsive">eventos?</h1>
        <p class="info-paragraph">Os eventos de Flash Tattoo são dias especiais
            em que a tatuadora oferece um catálogo
            pronto de tatuagens autorais, desenvolvidas
            especialmente para serem aplicadas no
            mesmo dia. São artes exclusivas, com traços
            e estilos que representam o trabalho da
            artista, prontas para serem escolhidas e
            tatuadas ali na hora.</p>
    </div>

    <div class="info-img">
        <img class="info-img1" src="<?php echo BASEURL; ?>/assets/img/kamile-evento.png" alt="eventos">
        <div class="row">
            <img class="info-img2" src="<?php echo BASEURL; ?>/assets/img/evento-img2.png" alt="eventos">
            <img class="info-img3" src="<?php echo BASEURL; ?>/assets/img/evento-img3.png" alt="eventos">

        </div>
        <img class="info-img4" src="<?php echo BASEURL; ?>/assets/img/evento-img-deitada.jpeg" alt="eventos">
    </div>

</div>

<div class="container-dia">
    <div class="dia">
        <div class="info-dia">
            <img class="foto-dia" src=" <?php echo BASEURL; ?>/assets/img/evento-dia.png" alt="eventos">
        </div>
        <div class="info-text-dia">
            <h1>Como funciona no
                dia do evento?</h1>
            <p>Flash tattoos são desenhos prontos e pré-definidos,
                geralmente de tamanho pequeno a médio. Elas são
                populares em eventos, pois permitem que os
                clientes escolham diretamente de um catálogo,
                economizando tempo no processo de criação e
                execução da arte.</p>
        </div>

    </div>

</div>


</div>

<h1 class="opcoes-servico" style="text-align: center; font-size: 100px; font-weight:bold; margin-top:300px;">Opções do Serviço</h1>
<div class="opcoes">
    <div class="left">
        <h1>Tatuagens Avulsas </h1>
        <ul class="list-info">
            <li class="list-item"> Há um pequeno custo inicial para a
                presença da tatuadora no evento<br>
                (valor varia dependendo do local).
            </li>
            <li class="list-item"> As pessoas interessadas escolhem o desenho
                e realizam o pagamento diretamente no local.
            </li>
            <li class="list-item"> Essa opção é perfeita para eventos<br>com
                público variado, permitindo que<br>cada pessoa
                fique responsável pelo<br>próprio pagamento.
            </li>
        </ul>
    </div>
    <hr class="hr">
    <div class="right">
        <h1>Pacotes Fechados</h1>
        <ul class="list-info">
            <li class="list-item"> O contratante paga um valor fixo
                previamente combinado, que inclui a
                realização de um número específico de
                tatuagens durante o evento.
            </li>
            <li class="list-item"> Essa opção é ideal para quem deseja
                oferecer uma experiência exclusiva aos
                convidados, sem que eles precisem se
                preocupar com o pagamento.
            </li>
        </ul>
    </div>

</div>


<h1 class="h1-plain"> Nossos Planos</h1>

<div class="cards-eventos">
    <?php foreach ($cards as $i => $card): ?>
        <div class="card-evento">
            <?php
            // Detecta o caminho correto da imagem
            $imgPath = $card['imagem'];
            if (str_starts_with($imgPath, 'uploads/')) {
                // imagem enviada pelo admin
                $imgSrc = BASEURL . '/' . htmlspecialchars($imgPath);
            } else {
                // imagem padrão (do sistema)
                $imgSrc = BASEURL . '/assets/img/' . htmlspecialchars($imgPath);
            }
            ?>

            <img class="card-img-top"
                src="<?php echo $imgSrc; ?>"
                alt="<?php echo htmlspecialchars($card['titulo']); ?>"
                onerror="this.src='<?php echo BASEURL; ?>/assets/img/default.jpg';">

            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($card['titulo']); ?></h5>
                <p class="subtitulo"><?php echo htmlspecialchars($card['subtitulo']); ?></p>
                <div class="card-list">
                    <div class="card-item">
                        <p class="card-text"><?php echo htmlspecialchars($card['texto1']); ?></p>
                    </div>
                    <div class="card-item">
                        <p class="card-text"><?php echo htmlspecialchars($card['texto2']); ?></p>
                    </div>
                    <div class="card-item">
                        <p class="card-text"><?php echo htmlspecialchars($card['texto3']); ?></p>
                    </div>
                    <div class="card-item">
                        <p class="card-text"><?php echo htmlspecialchars($card['texto4']); ?></p>
                    </div>
                </div>
            </div>

            <a class="btn-ver" href="https://api.whatsapp.com/send/?phone=5519997032404&text=Oii%2C+tudo+bem%3F+Gostaria+de+fazer+um+orçamento%21&type=phone_number&app_absent=0" target="_blank">FAZER ORÇAMENTO</a>
        </div>
    <?php endforeach; ?>
</div>


<div style="margin-bottom: 40px;"></div>

<h1 class="ask"> Dúvidas Frequentes</h1>

</section>
<div style="margin-bottom: 100px;"></div>
<div class="faq-container">
    <div class="faq-item">
        <button class="faq-question">
            O QUE SÃO OS EVENTOS?
            <img class="arrow" src="<?php echo BASEURL; ?>/assets/img/icones/arrow.svg" alt="icon-whatsapp">
        </button>
        <div class="faq-answer">
            <p>Os eventos são ações especiais promovidas pelo estúdio, em que os clientes podem realizar tatuagens de pequeno e médio porte com valores diferenciados e horários organizados.</p>
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">
            COMO FUNCIONAM OS EVENTOS?
            <img class="arrow" src="<?php echo BASEURL; ?>/assets/img/icones/arrow.svg" alt="icon-whatsapp">
        </button>
        <div class="faq-answer">
            <p>Cada evento possui um tema, duração e quantidade limitada de tatuagens. Os interessados escolhem os desenhos disponíveis e participam por ordem de chegada, garantindo agilidade e organização.</p>
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">
            COMO FAÇO O ORÇAMENTO DE UM EVENTO?
            <img class="arrow" src="<?php echo BASEURL; ?>/assets/img/icones/arrow.svg" alt="icon-whatsapp">
        </button>
        <div class="faq-answer">
            <p>Você pode solicitar um orçamento acessando a página de orçamentos no menu principal ou clicando no botão “Mais informações” de cada pacote. Lá você encontrará todos os detalhes necessários.</p>
        </div>
    </div>
</div>


<div style="margin-bottom:50px;"></div>
<?php include(FOOTER_TEMPLATE); ?>

<script>
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        item.querySelector('.faq-question').addEventListener('click', () => {
            item.classList.toggle('active');
        });
    });
</script>