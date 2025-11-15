<?php

/*
* Arquivo: restrita.php
* 
* Descrição:
* Área restrita do sistema após autenticação de acesso ao cliente
* 
* Funcionalidades:
* Autenticação e controle de acesso via token de sessão
* 
* Fluxo principal:
* Verifica autenticação do usuário

* Segurança:
* - Verificação de token de sessão e nivel de acesso 
* 
* Dependências:
* - Bootstrap 5 para interface e modais
* - Arquivo config.php com configurações do banco
* 
* @author Eduardo Torres do Ó
* 
*/ 


// PUXA AS INFORMAÇÕES DO BANCO
require("assets/config/config.php");

// VERIFICANDO AUTENTICACAO
$usuario = auth($_SESSION["TOKEN"]);

// SE O USUARIO NÃO TEM AUTENTICACAO
if(!$usuario){
    // REDIRECIONA PARA LOGIN
    header("location: login.php");

}

// SE ESTIVER AUTENTICADO E FOR MASTER
if($usuario && $usuario['nivel_acesso'] === 'master') {
    // REDIRECIONA PARA RESTRITA2
    header("Location: restrita2.php");
    exit; 
}


?>

<!DOCTYPE html>
<html lang="Ppt-br">
<head>
    <!-- META-TAGS PARA CONFIGURAÇÕES DO SITE (COMPATIBILIDADE ,FORMATAÇÃO DO ESCOPO , ETC) -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuário</title>

    <!-- REFERENCIA DO BOSTSTRAP -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
 

</head>
<body>
    <h1>Bem-vindo a pagina do usuário ! </h1>
    <br>
    <button onclick="window.location.href='logout.php'" class=" btn btn-danger btn-md ms-1 ">
        Sair do sistema
    </button>
    
</body>
</html>

