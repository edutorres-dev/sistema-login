<?php

/*
* Arquivo: config.php
* 
* Descrição:
* Responsável por estabelecer conexão com o banco de dados e fornecer funções utilitárias essenciais.
* 
* Funcionalidades principais:
* 1. Gerenciamento de conexão com o banco de dados (local/produção)
* 2. Tratamento e sanitização de dados de entrada
* 3. Sistema de autenticação por token
* 4. Configurações globais do sistema
* 
* Segurança:
* - Dados de conexão protegidos
* - Sanitização de inputs (XSS/SQL injection prevention)
* - Gerenciamento de sessão seguro
* - Tratamento de erros de conexão
* 
* Configurações de ambiente:
* - Modo local (desenvolvimento)
* - Modo produção (servidor real)
* - Troca fácil entre ambientes
* 
* Dependências:
* - PDO para conexão com MySQL
* - Sessões PHP para autenticação
* 
* Observações importantes:
* - Alterar credenciais para produção
* - Não expor informações sensíveis

* @author Eduardo Torres do Ós
* 

*/


// INICIALIZA SESSÃO
session_start();

// SEU SITE
$site = ""; 

// MODOS DE CONEXÃO
$modo = "producao";

// LOCAL
if ($modo == "local") {
    $servidor = "";
    $usuario = "";
    $senha = "";
    $banco = "";
}

// PRODUÇÃO
if($modo == "producao"){
    $servidor = "";
    $usuario = "";
    $senha = "";
    $banco = "";
}

// ABERTURA DE CONEXÃO
try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Banco conectado com sucesso!";
} catch (PDOException $erro) {
    echo "Falha ao se conectar com o banco! " . $erro->getMessage();
}


// TRATAMENTO DE ENTRADAS
function trataPost($dados){
    $dados=trim($dados);
    $dados=stripcslashes($dados);
    $dados=htmlspecialchars($dados);
    return $dados;
}

// TRATAMENTO ESPECIFICO PARA NUMERO DE CELULAR
function trataNumero($dados){
    $dado=trim($dados);
    return preg_replace('/[^0-9]/', '', $dado);


}

// FUNCAO PARA AUTORIZAR TOKEN DO USUARIO
function auth($tokenSessao){

    // TEVE QUE REDECLARAR COMO GLOBAL PARA PEGAR A CONEXAO COM O BANCO
    global $pdo;

    // VERIFICA SE O USUARIO TEM O TOKEN
    $sql = $pdo -> prepare(" SELECT * FROM usuarios WHERE token=? LIMIT 1 ");
    $sql->execute(array($tokenSessao));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);

    //SE O USUARIO NAO TEM O TOKEN
     if(!$usuario){
        return false;
    }else{
        return $usuario;
    }

}



?>