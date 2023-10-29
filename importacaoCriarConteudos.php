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

//LISTA DE LAYOUTS DISPONIVEIS
$diretorio = dir($path);
$layouts = array();
while($arquivoLayout = $diretorio -> read()){
    if( substr($arquivoLayout, -11) == "_layout.txt" ){
        $arquivoLayout = str_replace('_layout.txt', '.txt', $arquivoLayout); 
        $layouts[] = $arquivoLayout;
    }
}

echo "<h4 class='mt-5'>Executando a importação de TXT para SQL</h4>";
echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";
echo "<ul class='mt-2'>";

$diretorio = dir($path);
$listaLayouts = array();
while($arquivo = $diretorio -> read()){
    if( substr($arquivo, -4) == ".txt" && substr($arquivo, -11) != "_layout.txt" ){
        
        if (!in_array($arquivo, $layouts)) {
            echo "<li class='text-danger'>".$arquivo." <span class='badge badge-danger'>Falha na importação. Não tem layout.</span></li>";
        }else{

            $listaLayouts[] = $arquivo;
            echo "<li>".$arquivo."</li>";
        }
        
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
        $sql .= gerarCreateSQLConteudo($path, $layout);
    }

    $nomeFile = $path."/createContent_".date("Ymd-His").".sql";
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
        <br>Não existe nenhum arquivo do tipo Conteudo para criar as Tabelas... Vc tem certeza que baixou o arquivo completo?.
    </div>

    <?php
}

include "footer.php";
