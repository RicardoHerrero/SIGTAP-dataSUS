<!doctype html>
<html lang="pt-br" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>SIGTAP - Camada de Importação dos Dados para Base MySQL</title>

    <!-- Principal CSS do Bootstrap -->
    <link href="https://getbootstrap.com.br/docs/4.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos customizados para esse template -->
    <link href="https://getbootstrap.com.br/docs/4.1/examples/sticky-footer-navbar/sticky-footer-navbar.css" rel="stylesheet">
  
    <link rel="stylesheet" 
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  </head>

  <body class="d-flex flex-column h-100">

    <header>
      <!-- Navbar fixa -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">SIGTAP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
        </div>
      </nav>
    </header>

    <!-- Começa o conteúdo da página -->
    <main role="main" class="flex-shrink-0">
      
      <?php
      if( PAGE == "find-db" ){ ?>

        <section class="jumbotron">
          <div class="container mt-5">
            <h1 class="jumbotron-heading text-center">Buscando competências disponíveis</h1>
            <p class="lead text-muted">Os downloads realizados e salvos dentro da pasta <b>tabelas</b> deste projeto, estão visiveis abaixo. Clique na competência desejada para iniciar.</p>
            <p class="text-center">
              <a href="http://sigtap.datasus.gov.br/tabela-unificada/app/download.jsp" target="_blank"  class="btn btn-primary my-2"><i class="fa-solid fa-cloud-arrow-down"></i> Download da Tabela Unificada</a>
              <a href="index.php" class="btn btn-secondary my-2"><i class="fa-solid fa-angle-left"></i> Voltar para o Inicio deste projeto</a>
            </p>
          </div>
        </section>

      <?php
      }else if( PAGE == "detalhes-db" ){ ?>

        <section class="jumbotron">
          <div class="container mt-5">
            <h1 class="jumbotron-heading text-center">Estamos prontos para iniciar a Exportação</h1>
            <p class="lead text-muted text-center">Vamos percorrer o arquivo descompactado para validar os arquivos.</p>
            <p class="text-center">
              <a href="importacaoEtapaBancoDados.php" class="btn btn-secondary my-2"><i class="fa-solid fa-angle-left"></i> Voltar para lista de downloads disponíveis</a>
            </p>
          </div>
        </section>

      <?php
      }else if( PAGE == "execute-db" ){
        //nao exibir banners
      }else{
      ?>
        <section class="jumbotron">
          <div class="container mt-5">
            <h1 class="jumbotron-heading text-center">Objetivos deste Projeto</h1>
            <p class="lead text-muted">Os dados do <span class="badge badge-warning">SIGTAP</span> são organizados em um conjunto de pouco mais de 80 arquivos, disponibilizados mensalmente pelo próprio DataSUS.</p>
            <div id="objetivosDetalhes" style="<?php echo ( isset($_SESSION["conexao"]) && $_SESSION["conexao"])? "display:none":"" ?>">
              <p class="lead text-muted">Os dados são disponibilizados em formato de texto (.txt) sem qualquer caracter separador que indique as colunas e valores. No entanto há em conjunto com os dados os documentos de layout, para cada uma das tabelas um documento associado.</p>
              <p class="lead text-muted">Desta forma, o objetivo deste projeto, eh a partir do donwload de uma competência, <b>utilizar os arquivos disponibilizados para converter em formatos mais amigáveis</b>, nesta versão eh possível exportar nos formatos:</p>
              <p class="lead text-muted">
                      <ol>
                          <li>.SQL</li>
                          <li>.CSV</li>
                      </ol>
              </p>
            </div>
            <p class="text-center">
              <a href="http://sigtap.datasus.gov.br/tabela-unificada/app/download.jsp" target="_blank"  class="btn btn-primary my-2"><i class="fa-solid fa-magnifying-glass"></i> Download da Tabela Unificada</a>
              <a href="http://sigtap.datasus.gov.br/tabela-unificada/app/sec/inicio.jsp" target="_blank" class="btn btn-secondary my-2"><i class="fa-solid fa-arrow-up-right-from-square"></i> Acessar Data SUS - SIGTAP</a>
            </p>
          </div>
        </section>
      
      <?php }
      ?>
      <div class="container">