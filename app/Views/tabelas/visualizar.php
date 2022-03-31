<div class="conteudo-central">
    <nav class="opcoes-edicao">
        <ul>
            <?php
            foreach ($dados['listas'] as $itemLista) {
                if ($itemLista == $dados['lista']) {
                    echo "<li  class='ativo'><a href='" . URL . "sistema/" . $itemLista . "'>" . ucfirst($itemLista) . "</a></li>";
                } else {
                    echo ("<li><a href='" . $itemLista . "'>" . ucfirst($itemLista) . "</a></li>");
                }
            }
            ?>
        </ul>
    </nav>

    <!-- tabela -->
    <div class="tabela">

        <div class="caixa-de-pesquisa">
            <input type="text" placeholder="Pesquisar">
        </div>

        <table cellpadding="4">
            <thead>
                <tr>
                    <?php
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
                        echo ("<td><div class='acoes'><img src='" . DIST . "img/olho.png' class='botaofuncao' funcao='visualizar' valor='" . $linha['id'] . "'>
                         <img src='" . DIST . "img/note.png' class='botaofuncao' tabela='" . $dados['lista'] . "' funcao='editar' valor='" . $linha['id'] . "'></div></td>");
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

        <div class="tab">
            <table class="tabelaV">
                <thead>
                    <tr style="display: flex;">
                        <th>Data</th>
                        <th>Entrada 1</th>
                        <th>Saida 1</th>
                        <th>Entrada 2</th>
                        <th>Saida 2</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="tr-text">
                    <tr style="display: flex;">
                        <td><input type="text" style="width: 100%;" class="celula"></td>
                        <td><input type="text" style="width: 100%;" class="celula"></td>
                        <td><input type="text" style="width: 100%;" class="celula"></td>
                        <td><input type="text" style="width: 100%;" class="celula"></td>
                        <td><input type="text" style="width: 100%;" class="celula"></td>
                        <td><input type="text" style="width: 100%;" class="celula"></td>
                    </tr>
                </tbody>
            </table>

        </div>



        <button id="enviar">Salvar</button>

        <style>
            .tabelaV>thead>tr>td,
            .tabelaV>thead>tr>th {
                width: 16%;
                /* border-collapse: collapse; */
            }

            form>.inp {
                margin: 7px 2%;
                width: 25%;
            }

            .celula {
                width: 100%;
                text-align: center;
            }

            button {
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

                    $.ajax({
                        url: funcao,
                        type: 'POST',
                        data: {
                            valor: valor,
                        },
                        success: function(response) {
                            try {
                                dados = JSON.parse(response.split("resultadoJson")[1]);
                            } catch (e) {
                                dados = response;
                            }
                            if (dados.mensagem == 'undefined' || dados.mensagem == undefined) {
                                // dados = dados[0]
                                //pegar valores e colocar no formulario
                                // para cada linha em dados
                                html = '';
                                dados.forEach(function(linha) {
                                    html += '<tr style="display: flex;">';
                                    html += '<td><input data-atual="' + linha.data + '" idUser="' + linha.id_usuario + '" linha-atual="data" type="text" style="width: 100%;" class="celula" value="' + linha.data.replaceAll('-', '/') + '"></td>';
                                    html += '<td><input data-atual="' + linha.data + '" idUser="' + linha.id_usuario + '" linha-atual="entrada1" type="text" style="width: 100%;" class="celula" value="' + linha.entrada1.replaceAll(linha.data, '').replaceAll('-', ':').replace('undefined', '').replace('0000:00:00', '') + '"></td>';
                                    html += '<td><input data-atual="' + linha.data + '" idUser="' + linha.id_usuario + '" linha-atual="saida1" type="text" style="width: 100%;" class="celula" value="' + linha.saida1.replaceAll(linha.data, '').replaceAll('-', ':').replace('undefined', '').replace('0000:00:00', '') + '"></td>';
                                    html += '<td><input data-atual="' + linha.data + '" idUser="' + linha.id_usuario + '" linha-atual="entrada2" type="text" style="width: 100%;" class="celula" value="' + linha.entrada2.replaceAll(linha.data, '').replaceAll('-', ':').replace('undefined', '').replace('0000:00:00', '') + '"></td>';
                                    html += '<td><input data-atual="' + linha.data + '" idUser="' + linha.id_usuario + '" linha-atual="saida2" type="text" style="width: 100%;" class="celula" value="' + linha.saida2.replaceAll(linha.data, '').replaceAll('-', ':').replace('undefined', '').replace('0000:00:00', '') + '"></td>';
                                    html += '<td><input data-atual="' + linha.data + '" idUser="' + linha.id_usuario + '" linha-atual="value" type="text" style="width: 100%;" class="celula" disabled="disabled" value="' + linha.saldo.replace('undefined', '') + '"></td>';
                                    html += '</tr>';
                                });

                                document.getElementById('tr-text').innerHTML = html;

                                trocar()
                            } else {
                                alerta(dados.mensagem, dados.status);
                                // setTimeout(function() {
                                //     location.reload();
                                // }, 1000);
                            }
                        }

                    })
                    // adicionar evento change ao aos inputs da tabela 
                    // para atualizar o saldo
                    $('#tr-text').on('change', 'input', function() {
                        Swal.fire({
                            title: 'Deseja alterar esse valor?',
                            showCancelButton: true,
                            confirmButtonText: 'Sim',
                            customClass: {
                                actions: 'my-actions',
                                cancelButton: 'order-1 right-gap',
                                confirmButton: 'order-2',
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // pegar o valor do input
                                valor = $(this).val();
                                dataAtual = $(this).attr('data-atual');
                                linhaAtual = $(this).attr('linha-atual');
                                idUser = $(this).attr('idUser');

                                $.ajax({
                                    url: 'alterarHorarioColaborador',
                                    type: 'POST',
                                    data: {
                                        valor: valor,
                                        linhaAtual: linhaAtual,
                                        dataAtual: dataAtual,
                                        idUser: idUser
                                    },
                                    success: function(response) {
                                        dados = JSON.parse(response.split("resultadoJson")[1]);
                                        alerta(dados.mensagem, dados.status);
                                        setTimeout(function() {
                                            location.reload();
                                        }, 1000);
                                    }

                                })
                            } else {
                                alerta('Operação cancelada', 'warning');
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }
                        })

                    });
                });
            });
        }
    </script>

</div>