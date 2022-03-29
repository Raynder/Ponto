<div class="conteudo-central">
    <nav class="opcoes-edicao">
        <ul>
            <?php
            // exit(print_r($dados));
            foreach ($dados['listas'] as $itemLista) {
                if ($itemLista == $dados['lista']) {
                    echo "<li  class='ativo'><a href='" . URL . "sistema/" . $itemLista . "'>" . ucfirst($itemLista) . "</a></li>";
                } else {
                    echo ("<li><a href='" . $itemLista . "'>" . ucfirst($itemLista) . "</a></li>");
                }
            }
            ?>
            <!-- <li class="ativo">Campos</li>
            <li class="">Aliquotas</li>
            <li class="">Regras</li> -->
        </ul>
    </nav>

    <!-- tabela -->
    <div class="tabela">

        <div class="caixa-de-pesquisa">
            <input type="text" placeholder="Pesquisar"> <button onclick="trocar()">CADASTRAR</button>
        </div>

        <table cellpadding="4">
            <thead>
                <tr>
                    <?php
                    // print_r($dados);exit();
                    foreach ($dados['colunas'] as $coluna) {
                        if ($coluna[2] == 1 || $coluna[2] == 3) {
                            echo ("<th>" . ucfirst(str_replace('_', ' ', $coluna[0])) . "</th>");
                        }
                    }
                    ?>
                    <th>Açõoes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($dados['linhas']) > 0) {
                    foreach ($dados['linhas'] as $linha) {
                        echo ("<tr>");
                        foreach ($dados['colunas'] as $coluna) {
                            if ($coluna[2] == 1 || $coluna[2] == 3) {
                                echo ("<td style='text-align: center'>" . $linha[$coluna[0]] . "</td>");
                            }
                        }
                        echo ("<td><div class='acoes'><img src='" . DIST . "img/note.png' class='botaofuncao' tabela='" . $dados['lista'] . "' funcao='editar' valor='" . $linha['id'] . "'>
                         <img src='" . DIST . "img/lixo.png' class='botaofuncao' tabela='" . $dados['lista'] . "' funcao='deletar' valor='" . $linha['id'] . "'></div></td>");
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <div style="display: none;" class="tabela">

        <div class="caixa-de-pesquisa">
            <button onclick="trocar()">Listar</button>
        </div>

        <!-- Formulario -->
        <form action="">
            <!-- um for para criar input para cada item da coluna -->
            <?php
            foreach ($dados['colunas'] as $coluna) {
                if ($coluna[1] == 0) {
                    $coluna = $coluna[0];
                    echo ("<input class='inp' type='text' name='" . $coluna . "' placeholder='" . ucfirst(str_replace('_', ' ', $coluna)) . "'>");
                } else {
                    if ($coluna[1] == 1) {
                        #checkbox
                        echo ('<br>'.$coluna[0] . "<input style='width:10px' class='inp' type='checkbox' name='" . $coluna[0] . "'>");
                    } else {
                        echo ("<select class='inp' name='" . $coluna[0] . "'>");
                        echo ("<option value=''>Selecione</option>");
                        foreach ($coluna[1] as $opt) {
                            #verificar se contém :
                            if (strpos($opt, ':') !== false) {
                                $opt = explode(':', $opt);
                                echo ("<option value='" . $opt[0] . "'>" . $opt[1] . "</option>");
                            } else {
                                echo ("<option value='" . $opt . "'>" . $opt . "</option>");
                            }
                        }
                        echo ("</select>");
                    }
                }
            }
            ?>

            <input type="text" class="inp" value="0" name="id" style="display: none;">

            <button id="enviar">Enviar</button>

        </form>
        <style>
            form>.inp {
                margin: 7px 2%;
                width: 25%;
            }

            form>button {
                min-width: 15%;
                margin: 10px;
                background: #1d1552;
                color: white;
            }

            img.botaofuncao {
                width: 20px;
                margin: 0 5px;
            }
        </style>
    </div>

    <div class="divPagination">
        <ul class="pagination">
            <li><a href="#">«</a></li>
            <li><a href="#">1</a></li>
            <li><a class="active" href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">6</a></li>
            <li><a href="#">7</a></li>
            <li><a href="#">»</a></li>
        </ul>
    </div>

    <script>
        function trocar() {
            selecAll('.conteudo-central>.tabela').forEach((table) => {
                if (table.style.display == 'none') {
                    table.style.display = 'block';
                } else {
                    table.style.display = 'none';
                }
            });
        }

        // chamar função assim que o botao enviar for clicado
        window.onload = function() {
            selec('#enviar').addEventListener('click', function(e) {
                e.preventDefault();

                if (dados = selecValues('.conteudo-central>.tabela>form>.inp')) {
                    // enviar os dados para o servidor
                    $.ajax({
                        url: 'cadastrar',
                        type: 'POST',
                        data: {
                            dados: dados,
                            table: '<?php echo $dados['lista'] ?>'
                        },
                        success: function(response) {
                            resposta = JSON.parse(response.split("resultadoJson")[1]);
                            alerta(resposta.mensagem, resposta.status);
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    })
                }
            });

            selecAll('.botaofuncao').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e = e.target
                    funcao = e.getAttribute('funcao');
                    valor = e.getAttribute('valor');
                    tabela = e.getAttribute('tabela');

                    $.ajax({
                        url: funcao,
                        type: 'POST',
                        data: {
                            valor: valor,
                            table: tabela
                        },
                        success: function(response) {
                            dados = JSON.parse(response.split("resultadoJson")[1]);
                            if (dados.mensagem == 'undefined' || dados.mensagem == undefined) {
                                dados = dados[0]
                                //pegar valores e colocar no formulario
                                selecAll('form>.inp').forEach(function(input) {
                                    if(input.value == 'on' && dados[input.name] == 1){
                                        input.checked = true;
                                    }
                                    input.value = dados[input.name];
                                });
                                trocar()
                            } else {
                                alerta(dados.mensagem, dados.status);
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }
                        }
                    })
                });
            });
        }
    </script>

</div>