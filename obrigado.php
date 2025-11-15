<!-- /**
* Arquivo: obrigado.php 
* 
* Descrição:
* Exibe mensagem de sucesso após cadastro e instruções para validação por e-mail.
*
* Funcionalidades :
* 1. Exibe animação de confirmação visual
* 2. Apresenta mensagem de orientação ao usuário
* 3. Oferece links para acesso do e-mail(Outlook / Gmail)
* 4. Interface amigável e intuitiva
*
* Bibliotecas :
* - Bootstrap 5 para estruturação
* - DotLottie Player para animações
* - CSS customizado para estilização
*
* Fluxo :
* 1. Acesso após submissão do formulário de cadastro
* 2. Visualização da confirmação animada
* 3. Leitura das instruções
* 4. Acesso ao e-mail (via links rápidos)
*
* @author Eduardo Torres do Ó

*/ -->

<!DOCTYPE html>
<html lang="pt">
<head>

    <!-- META-TAGS PARA CONFIGURAÇÕES DO SITE (COMPATIBILIDADE ,FORMATAÇÃO DO ESCOPO , ETC) -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmação de Cadastro</title>
    
    <!-- REFERENCIA DO BOTSTRAP CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    

    <!--REFERÊNCIA CSS -->
    <link rel="stylesheet" href="assets/css/form.css">
    

    <style>

        .animation-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
       
    </style>

</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="container text-center" >
        <!-- ANIMAÇÃO -->
        <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.5/dist/dotlottie-wc.js" type="module"></script>
        <dotlottie-wc 
            src="https://lottie.host/8904d738-a1c0-42ed-b90a-c67f2a47c7ab/Cta3XG3DEG.lottie"
            style="width: 300px; height: 270px; display: block; margin: 0 auto;"
            autoplay
            loop>
        </dotlottie-wc>
        <!-- MENSAGEM -->
        <h1 class="fw-bold">Muito obrigado por se cadastrar!</h1>
        <p style="font-size: 19px;">Enviamos um e-mail para o endereço cadastrado. Por favor, confirme seu email.</p>
        <p  style="font-size: 19px;">Caso não encontre, confira sua caixa de spam!</p>

        <!-- BOTÕES -->
        <br><a  class="btn-aut" style=" padding: 15px; border-radius: 5px; text-decoration: none;" href="https://mail.google.com"> Ir para o Gmail</a>
        <a class="btn-aut" style=" padding: 15px; border-radius: 5px; text-decoration: none; " href="https://login.live.com/login.srf?wa=wsignin1.0&rpsnv=168&ct=1735245085&rver=7.5.2211.0&wp=MBI_SSL&wreply=https%3a%2f%2foutlook.live.com%2fowa%2f%3fnlp%3d1%26cobrandid%3dab0455a0-8d03-46b9-b18b-df2f57b9e44c%26culture%3dpt-br%26country%3dbr%26RpsCsrfState%3d0f3d39b4-d5d2-a6fd-e032-0a8cc59e4f9e&id=292841&aadredir=1&CBCXT=out&lw=1&fl=dob%2cflname%2cwld&cobrandid=ab0455a0-8d03-46b9-b18b-df2f57b9e44c"> Ir para o Outlook</a>
        <br><br><br><br><br><br>
        
       
    

    <!-- REFERNECIA BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
