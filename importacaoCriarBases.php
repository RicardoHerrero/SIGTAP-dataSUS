<?php
session_start();
define("PAGE", "execute-db");

include "funcoes.php";
include "header.php";

if( !isset( $_GET['download'] ) || $_GET['download'] == "" ){
    ?>
    
    <div class="alert alert-danger" role="alert">
        <b>Atenção, Nenhum arquivo vou selecionado.</b>
        <br>Clique em voltar e selecione o arquivo para iniciar.
    </div>

    <?php
    exit();
}

$path = "./tabelas/".$_GET['download'];
$diretorio = dir($path);
$listaLayouts = array();

echo "<h4 class='mt-5'>Executando a importação de TXT para SQL</h4>";
echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";
echo "<ul class='mt-2'>";
while($arquivo = $diretorio -> read()){
    if( substr($arquivo, -11) == "_layout.txt" ){
        $listaLayouts[] = $arquivo;
        echo "<li>".$arquivo."</li>";
    }
}
echo "</ul>";
$diretorio -> close();

if( count($listaLayouts) > 0 ){
    ?>

    <div class="alert alert-info" role="alert">
        <b><i class="fa-solid fa-magnifying-glass"></i> Foi localizado <?=count($listaLayouts)?> layouts de tabelas </b>
    </div>

    <?php
    //CONVERTENDO O TXT PARA SQL
    echo "<h4 class='mt-4'>Convertendo em SQL</h4>";

    $sql = "";
    foreach ($listaLayouts as $layout) {
        $sql .= gerarCreateSQL($path, $layout);
    }

    $nomeFile = $path."/createTables_".date("Ymd-His").".sql";
    if( criarArquivo($nomeFile, $sql) ){ ?>

        <div class="alert alert-success" role="alert">
            <b><i class="fa-solid fa-circle-check"></i> Arquivo criado com sucesso</b>
            <hr/>
            <a class="btn btn-primary btn-lg" href="<?=$nomeFile?>" role="button"><i class="fa-solid fa-cloud-arrow-down"></i> Download</a>
            <a class="btn btn-success btn-lg" href="detalhesBases.php?download=<?=$_GET['download']?>" role="button"><i class="fa-solid fa-angle-left"></i> Fechar</a>
        </div>
        <a name="footer"></a>

    <?php
    }else{
        echo '<div class="alert alert-danger" role="alert">
                <b><i class="fa-solid fa-bug"></i> Erro para gerar o arquivo!<hr/>
                Dica: Verifique se a pasta <b>'.$path.'</b> tem permissão de escrita</b>
            </div>';
    }

}else{
    ?>
    
    <div class="alert alert-warning" role="alert">
        <b>Estranho...</b>
        <br>Não existe nenhum arquivo do tipo Layout para criar as Tabelas... Vc tem certeza que baixou o arquivo completo?.
    </div>

    <?php
}

include "footer.php";
