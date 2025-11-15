<?php

/*
* Arquivo: confirmacao.php
* 
* Descrição:
* Processa a confirmação de cadastro de usuários através de um código único enviado por e-mail.
* Atualiza o status do usuário no banco de dados para "confirmado" quando o código é válido.
* 
* Funcionalidades principais:
* 1. Validação do código de confirmação recebido via URL
* 2. Verificação da existência do usuário no banco de dados
* 3. Atualização do status do usuário para "confirmado"
* 4. Redirecionamento com feedback para o usuário
* 
* Fluxo de operação:
* 1. Recebe código de confirmação via parâmetro GET
* 2. Valida e trata o código recebido
* 3. Busca usuário correspondente no banco de dados
* 4. Se encontrado, atualiza status para "confirmado"
* 5. Redireciona para login com mensagem de sucesso
* 6. Se código inválido, exibe mensagem de erro
* 
* Segurança:
* - Sanitização do código de confirmação
* - Uso de prepared statements para prevenir SQL injection
* - Verificação da existência do usuário antes de atualizar
* - Redirecionamento seguro após confirmação
* 
* Dependências:
* - Arquivo config.php com configurações do banco e conexão PDO
* - Função trataPost() para sanitização de inputs
* 
* 
* Observações importantes:
* - O código de confirmação é gerado durante o cadastro (sha1(uniqid()))
* - O código tem validade indeterminada (não expira)
* - Cada código é único por usuário
* - O status inicial do usuário é "novo"
* 
* @author Eduardo Torres Do Ó
* 
*/


/****************************************************************
 * CONFIGURAÇÕES INICIAIS
****************************************************************/

// PUXA AS INFORMACÕES DO BANCO
require("assets/config/config.php");

/****************************************************************
 * PROCESSAMENTO DE CONFIRMAÇÃO DE CADASTRO
****************************************************************/

// SE TEM O CODIGO DE CONFIRMAÇÃO, PEGA ELE VIA GET
if(isset($_GET["cod_confirm"]) && !empty($_GET["cod_confirm"])){

    // TRATA ESSE CODIGO EVITANDO SQL INJECTION
    $cod= trataPost($_GET["cod_confirm"]);

    //VERIFICA SE O USUARIO TEM ESSE CODIGO
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE codigo_confirmacao=? LIMIT 1");
    $sql->execute(array($cod));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);

    // SE EXISTIR ALGUM USUARIO COM O CODIGO
    if($usuario){

        //ATUALIZA O STATUS DO USUÁRIO PARA CONFIRMADO NO SISTEMA
        $status = "confirmado";
        $sql= $pdo->prepare("UPDATE usuarios SET status=? WHERE codigo_confirmacao=? ");

        // SE CONSEGIU ATUALIZAR O STATUS DO USUÁRIO
        if($sql->execute(array($status,$cod))){

            // REDIRECIONA O USUARIO PARA O LOGIN
            header("location: index.php?result=ok");

        }

        // SE O USUAIRO NÃO ESTIVER COM O CODIGO
    }else{ 

        // MOSTRA A MENSAGEM DE ERRO AO USUÁRIO
       echo "<h1>Código de confirmação inválido!</h1>";

    }

}



?>