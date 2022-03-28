<?php
if (isset($_SESSION['usuario']['nome']) && !empty($_SESSION['usuario']['nome'])) {
?>
    <header>
        <div class="menu-header">
            <div class="logo">
                <a href="<?= URL ?>"><img height="55px" src="<?= DIST ?>/img/logo.png" alt=""></a>
            </div>
            <div class="nome-empresa">
                <span>LOBE CONSULTORIA</span>
            </div>

            <div class="demais-informacoes">
                <div class="usuario-logado">
                    <a href="<?= URL ?>conta/sair"><span><?= ucfirst($_SESSION['usuario']['nome'] . "  "); ?></span>Sair</a>
                </div>

            </div>
        </div>
    </header>

    <div class="menu-lateral">
        <nav>
            <ul>
                <a href="<?= URL ?>controle/<?= $_SESSION['usuario']['home'] ?>">
                    <li><img src="<?= DIST ?>/img/cadastro.png"></li>
                </a>
                <a href="<?= URL ?>controle/index">
                    <li><img src="<?= DIST ?>/img/tabela.png"></li>
                </a>
                <!-- <a href="<?= URL ?>formPreco/regras">
                    <li><img src="<?= DIST ?>/img/home.png"></li>
                </a>
                <a href="<?= URL ?>formPreco/configuracoes">
                    <li><img src="<?= DIST ?>/img/home.png"></li>
                </a> -->
            </ul>
        </nav>
    </div>
<?php
}
?>