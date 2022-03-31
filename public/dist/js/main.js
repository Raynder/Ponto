var criterios = 0;
var split = 0;
var entao = 0;
var campoAlvo;
var url = "http://192.168.1.37/Ponto/";

function selecAll(parametro) {
    return document.querySelectorAll(parametro)
}

function selec(parametro) {
    return document.querySelector(parametro)
}

function ifNull(input) {
    if (input == '' || input == null || input == undefined || input == 'undefined') {
        return true;
    }
}

function selecValues(alvo) {
    let inputs = selecAll(alvo);
    let dados = {};
    let vazio = false;

    // percorrer os inputs e verificar se estão vazios
    inputs.forEach((input) => {
        if (ifNull(input.value)) {
            alerta('Preencha todos os campos!', 'error');
            vazio = true;
        }
        else {
            if (input.type == 'checkbox' && input.checked == true) {
                dados[input.name] = 1;
            } else if (input.type == 'checkbox' && input.checked == false) {
                dados[input.name] = 0;
            }
            else {
                dados[input.name] = input.value;
            }
        }
    });

    if (vazio) {
        return false;
    }
    return dados;
}

//Funções do index
function entrar(table) {
    let dados = selecValues('.conteudo-registro>.painel>.corpo>form>.inp');

    if (dados) {
        $.ajax({
            url: url + 'conta/entrar',
            type: 'POST',
            data: {
                dados: dados,
                table: table
            },
            success: (response) => {
                resposta = JSON.parse(response.split('resultadoJson')[1]);
                alerta(resposta.mensagem, resposta.status);
                setTimeout(function () {
                    window.location.href = url + resposta.redirecionar;
                }, 1000);
            }
        })
    }

}

function registrar() {
    let dados = selecValues('.conteudo-registro>.painel>.corpo>form>.inp');

    if (dados) {
        $.ajax({
            url: url + 'conta/registrar',
            type: 'POST',
            data: {
                usuario: dados.usuario,
                senha: dados.senha
            },
            success: (response) => {
                resposta = JSON.parse(response.split('resultadoJson')[1]);
                alerta(resposta.mensagem, resposta.status);
                setTimeout(function () {
                    window.location.href = url + resposta.redirecionar;
                }, 1000);
            }
        })
    }

}

//Fim das funções do index