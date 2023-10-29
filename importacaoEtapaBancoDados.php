
<?php
session_start();
define("PAGE", "find-db");

include "header.php";
?>

<h4 class="d-flex justify-content-between align-items-center mb-3">
    <span>Listagem de Downloads disponíveis para Geração da Carga SQL</span>
</h4>

<p class="font-weight-light">Dica: Caso não esteja visualizando a carga que deseja, tenha certeza de ter salvo o download na pasta <b>tabelas</b> deste projeto.</p>

<?php
$filename = './tabelas';
if (!is_writable($filename)) {
    ?>
    
    <div class="alert alert-danger" role="alert">
        <b>Atenção, necessário permissão de escrita para downloads.</b>
        <br>Aplicar em: <?=$filename?>
    </div>

<?php
} else {
    
    $diretorio = dir($filename);

    echo "Lista de Downloads no diretório '<strong>".$filename."</strong>':<br />";
    while($arquivo = $diretorio -> read()){
        if( strlen($arquivo) > 15 ){
            echo "<div class='alert alert-info mt-2' role='alert'>
                <a href='detalhesBases.php?download=".$arquivo."'>".$arquivo."</a>
            </div>";
        }
    }
    $diretorio -> close();

}

include "footer.php";