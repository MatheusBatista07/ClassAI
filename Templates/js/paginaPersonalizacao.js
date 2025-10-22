document.addEventListener("DOMContentLoaded", function() {
    // Seleciona os campos de input
    const nome = document.querySelector(".userName");
    const sobrenome = document.querySelector(".userLastName");
    const cpf = document.querySelector(".userCPF");
    const btnCadastrar = document.querySelector("#btnCadastrar");

    // --- Início da Formatação Automática do CPF ---

    // Se o campo de CPF existir, adiciona o listener de formatação
    if (cpf) {
        cpf.addEventListener("input", function(event) {
            // Pega o valor atual do campo e remove tudo que não for número
            let valor = cpf.value.replace(/\D/g, "");

            // Limita a quantidade de caracteres para 11 (tamanho do CPF)
            valor = valor.substring(0, 11);

            // Aplica a máscara de formatação
            valor = valor.replace(/(\d{3})(\d)/, "$1.$2"); // Coloca o primeiro ponto
            valor = valor.replace(/(\d{3})(\d)/, "$1.$2"); // Coloca o segundo ponto
            valor = valor.replace(/(\d{3})(\d{1,2})$/, "$1-$2"); // Coloca o traço

            // Atualiza o valor do campo com a máscara
            cpf.value = valor;
        });
    }

    // --- Fim da Formatação Automática do CPF ---

    // Se não achar o botão, não continua com a lógica de validação
    if (!btnCadastrar) return;

    btnCadastrar.addEventListener("click", function(event) {
        event.preventDefault(); // Impede o envio automático do formulário

        // Seleciona as mensagens de erro
        const nomeErro = document.querySelector(".nome-erro");
        const sobrenomeErro = document.querySelector(".sobrenome-erro");
        const cpfErro = document.querySelector(".cpf-erro");

        let valido = true;

        // Limpa mensagens de erro antigas
        [nomeErro, sobrenomeErro, cpfErro].forEach(el => {
            if (el) el.style.display = "none";
        });

        // Valida o campo Nome
        if (nome.value.trim() === "") {
            nomeErro.style.display = "block";
            valido = false;
        }

        // Valida o campo Sobrenome
        if (sobrenome.value.trim() === "") {
            sobrenomeErro.style.display = "block";
            valido = false;
        }

        // Valida o campo CPF
        // A validação agora pode verificar se o CPF tem o formato completo (14 caracteres)
        if (cpf.value.length !== 14) {
            cpfErro.style.display = "block";
            valido = false;
        }

        // Se todos os campos estiverem preenchidos corretamente
        if (valido) {
            console.log("Cadastro validado com sucesso!");
            // Para enviar o formulário, você pode remover a máscara antes
            // const cpfSemMascara = cpf.value.replace(/\D/g, "");
            // console.log("CPF a ser enviado:", cpfSemMascara);
            // document.querySelector("form").submit();
        }
    });
});

// Aguarda o documento HTML ser completamente carregado
document.addEventListener('DOMContentLoaded', function() {

    // Seleciona os elementos do HTML que vamos usar
    const inputFotoPerfil = document.getElementById('foto-perfil');
    const uploadLabel = document.querySelector('.upload-label');
    const uploadIcon = document.querySelector('.upload-label .bi-plus');

    // Adiciona um "ouvinte" que dispara uma ação quando o usuário seleciona um arquivo
    inputFotoPerfil.addEventListener('change', function(event) {
        
        // Pega o primeiro arquivo selecionado (a imagem)
        const file = event.target.files[0];

        // Verifica se um arquivo foi realmente selecionado
        if (file) {
            // Cria um leitor de arquivos
            const reader = new FileReader();

            // Define o que acontece quando o arquivo for lido
            reader.onload = function(e) {
                // Esconde o ícone '+'
                if (uploadIcon) {
                    uploadIcon.style.display = 'none';
                }

                // Aplica a imagem selecionada como fundo do label
                uploadLabel.style.backgroundImage = `url('${e.target.result}')`;
                uploadLabel.style.backgroundSize = 'cover';      // Faz a imagem cobrir todo o espaço
                uploadLabel.style.backgroundPosition = 'center'; // Centraliza a imagem
                uploadLabel.style.backgroundRepeat = 'no-repeat';// Evita que a imagem se repita
                uploadLabel.style.border = '2px solid #E8CEFD'; // Adiciona uma borda sutil
            }

            // Lê o arquivo como uma URL de dados, o que dispara o 'onload' acima
            reader.readAsDataURL(file);
        }
    });
});
