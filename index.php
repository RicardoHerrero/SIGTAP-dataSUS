<?php
session_start();
define("PAGE", "inicio");

include "header.php";
?>

<h1>Iniciando a busca por Download de Competências</h1>
<p class="lead">Para iniciar, faça o download da competência desejada e descompacte o arquivo na pasta tabelas deste projeto.</p>
<a class="btn btn-primary mb-5" href="importacaoEtapaBancoDados.php" role="button"><i class="fa-solid fa-check"></i> Já fiz o Download. Vamos iniciar.</a>

<?php
include "footer.php";