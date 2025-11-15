<?php

/*
* Arquivo: logout.php
* 
* Descrição:
* Responsável por finalizar a sessão do usuário e redirecioná-lo para a página de login.
* 
* Funcionalidades:
* 1. Encerra a sessão ativa do usuário
* 2. Limpa todos os dados da sessão
* 3. Destrói completamente a sessão
* 4. Redireciona para a página de login
* 
* Segurança:
* - Garante que todos os dados da sessão sejam removidos
* - Previne ataques de sessão fixação
* - Implementa encerramento completo da sessão
* - Redirecionamento imediato após logout
* 
* Dependências:
* - Requer sessão ativa para funcionar corretamente
* - Integrado com login.php para redirecionamento
* 
* @author Eduardo Torres do Ó
*/


//INICIALIZA A SESSAO
session_start();

// LIMPA A SESSÃO
session_unset();

// DESTRÓI A SESSAO
session_destroy();

// REDIRECIONA O USUÁRIO PARA LOGIN
header("location: index.php");






?>





