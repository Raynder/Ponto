var criterios = 0;
var split = 0;
var entao = 0;
var campoAlvo;

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