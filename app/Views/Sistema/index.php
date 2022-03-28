
    <div class="conteudo-registro">
        <div class="painel">

            <div class="con-tooltip top" id="idc">


            </div>

            <div class="cabecalho">
                <img src="<?=DIST?>img/logo-ponto.png" alt="">
            </div>

            <div class="corpo">
                <nav>
                    <ul>
                        <?php
                        foreach ($dados['menus'] as $menu) {
                            if($menu == $dados['ativo']){
                                echo '<li class="ativo">';
                            }else{
                                echo '<li>';
                            }

                            echo "<a href='".URL."sistema/{$menu}'>{$menu}</a></li>";
                        }
                        ?>
                    </ul>
                </nav>

                <form action="">
                    <input class="inp" type="text" placeholder="USUARIO" name="usuario">
                    <input class="inp" type="text" placeholder="SENHA" name="senha">

                    <input type="button" onclick="<?= $dados['funcao']."('".$dados['ativo']."')" ?>" value="<?= ucFirst($dados['funcao']) ?>" class="botao">
                    <a href="">Recuperar senha</a>
                </form>

            </div>

        </div>
    </div>

<style>
    * {
        padding: 0;
        margin: 0;
    }

    body {
        align-items: center;
    }

    .conteudo-registro {
        position: fixed;
        top: 0;
        bottom: 0;
        right: 0;
        width: 100%;
        background: #1c1450;
    }

    .conteudo-registro>.painel {
        width: 450px;
        height: 450px;
        background: white;
        position: absolute;
        bottom: 0;
        top: 0;
        right: 0;
        left: 0;
        margin: auto;
        border-radius: 10px;
        box-shadow: 0px 0px 14px 2px #726e8b;
    }

    .conteudo-registro>.painel>.cabecalho {
        width: 150px;
    }

    .conteudo-registro>.painel>.corpo>nav>ul {
        display: flex;
        justify-content: space-around;
    }

    .conteudo-registro>.painel>.corpo>nav>ul>li {
        list-style: none;
        padding: 7px;
        margin-top: 10px;
        border-radius: 5px;
        min-width: 23%;
        border: 1px solid #1c1450;
        text-align: center;
    }

    .conteudo-registro>.painel>.corpo>form {
        margin-top: 30px;
        width: 50%;
        margin: auto;
        align-items: center;
        margin-top: 30px;
        text-align: center;
    }

    .conteudo-registro>.painel>.corpo>form>input {
        position: relative;
        width: 100%;
        margin: auto;
        border: none;
        padding: 10px 0;
        margin: 5px 0;
        text-align: center;
        box-shadow: 0px 0px 2px;
    }

    .conteudo-registro>.painel>.corpo>form>input[type="button"] {
        background: #1c1450;
        color: white;
    }


    img {
        width: 100%;
    }

    @media(max-width: 1000px) {
        .conteudo-registro>.painel {
            width: 80%;
            height: 600px;
            padding: 40px 70px;
        }
    }
</style>

<script>
    window.onload = function () {
        document.querySelectorAll('.conteudo-registro>.painel>div').forEach((div) => {
            div.style.margin = 'auto'
        })
    }
</script>

</html>