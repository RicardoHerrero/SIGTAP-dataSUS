<?php
session_start();
define("PAGE", "detalhes-db");

include "funcoes.php";
include "header.php";


$path = "./tabelas/".$_GET['download'];

echo "<h4 class='mb-3'>Analisando a Pasta Selecionada: <span class='font-weight-light'>".$_GET['download']."</span></h4>";

if( !isset( $_GET['download'] ) || $_GET['download'] == "" ){
    ?>
    
    <div class="alert alert-danger" role="alert">
        <b>Atenção, Nenhum arquivo foi selecionado.</b>
        <br>Clique em voltar e selecione o arquivo para iniciar.
    </div>

    <?php
}else{

    //COUNT FILE LAYOUTS
    $diretorio = dir($path);
    $countFileLayouts = array();
    $arquivo = "";
    while($arquivo = $diretorio -> read()){
        if( substr($arquivo, -11) == "_layout.txt" ){
            $countFileLayouts[] = $arquivo;
        }
    }
    $diretorio -> close();

    //COUNT FILE LAYOUTS
    $diretorio = dir($path);
    $countFileSQLEstrutura = array();
    $arquivo = "";
    while($arquivo = $diretorio -> read()){
        if( substr($arquivo, -4) == ".sql" && substr($arquivo, 0, 13) == "createTables_" ){
            $countFileSQLEstrutura[] = $arquivo;
        }
    }
    $diretorio -> close();


    //COUNT FILE CONTEUDO
    $diretorio = dir($path);
    $countFileConteudo = array();
    $arquivo = "";
    while($arquivo = $diretorio -> read()){
        if( substr($arquivo, -4) == ".txt" && substr($arquivo, -11) != "_layout.txt" ){
            $countFileConteudo[] = $arquivo;
        }
    }
    $diretorio -> close();


    //COUNT FILE LAYOUTS
    $diretorio = dir($path);
    $countFileSQLConteudo = array();
    $arquivo = "";
    while($arquivo = $diretorio -> read()){
        if( substr($arquivo, -4) == ".sql" && substr($arquivo, 0, 14) == "createContent_" ){
            $countFileSQLConteudo[] = $arquivo;
        }
    }
    $diretorio -> close();

    //COUNT FILE LAYOUTS CSV
    $diretorio = dir($path);
    $countFileSQLConteudoCSV = array();
    $arquivo = "";
    while($arquivo = $diretorio -> read()){
        if( substr($arquivo, 0, 4) == "CSV_" ){
            $countFileSQLConteudoCSV[] = $arquivo;
        }
    }
    $diretorio -> close();
}

?>

<p>Lista de Arquivos do diretório <strong class="text-muted"><?=$path?></strong></p>

<div class="container mt-4">
    <div class="card-deck mb-3 text-center">
        <div class="card mb-4 shadow-sm">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal"><i class="fa-solid fa-database"></i> ESTRUTURA SQL</h4>
          </div>
          <div class="card-body card-estrutura">
            <h1 class="card-title pricing-card-title <?=(count($countFileLayouts)>0)?'':'text-danger'?> "><?=count($countFileLayouts)?> <small class="<?=(count($countFileLayouts)>0)?'text-muted':'text-danger'?>"> TXT de Layouts</small></h1>            
            
            <?php if( count($countFileLayouts) > 0){?>
                <a href="importacaoCriarBases.php?download=<?=$_GET['download']?>#footer" role="button" class="btn btn-lg btn-block btn-outline-success">Exportar TXT para SQL</a>
            
            <?php }else{ ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa-solid fa-bug"></i>Estranho. 
                    <p><b>Não foi localizado nenhum arquivo TXT.</b>
                    <br>Imagino que algo tenha dado errado no Dowload. Tente novamente.</p>
                </div>
            <?php } ?>
            <?php
            //LISTAGEM DOS ARQUIVOS Já GERADOS 
            if( count($countFileSQLEstrutura) > 0 ){ ?>

                <div class="alert alert-info mt-3" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i> Já existe <?=count($countFileSQLEstrutura)?> arquivo(s) exportados!
                    <hr/>
                    <span class="text-muted">Clique abaixo no link para Download.</span>

                    <ol class="mt-3">
                    <?php
                    foreach ($countFileSQLEstrutura as $download) {
                       echo "<li><a href='".$path."/".$download."'>".$download."</a>";
                    }
                    ?>
                    </ol>

                </div>

            <?php
            } ?>
            </div>
        </div>
        <div class="card mb-4 shadow-sm">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal"><i class="fa-solid fa-sheet-plastic"></i> CONTEÚDO SQL</h4>
          </div>
          <div class="card-body card-conteudo">
            <h1 class="card-title pricing-card-title <?=(count($countFileConteudo)>0)?'':'text-danger'?> "><?=count($countFileConteudo)?> <small class="<?=(count($countFileConteudo)>0)?'text-muted':'text-danger'?>"> TXT de Conteúdo</small></h1>            
                
                <?php if( count($countFileConteudo) > 0){?>
                    <a href="importacaoCriarConteudos.php?download=<?=$_GET['download']?>#footer" role="button" class="btn btn-lg btn-block btn-outline-success">Exportar TXT para SQL</a>
                
                <?php }else{ ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fa-solid fa-bug"></i>Estranho. 
                        <p><b>Não foi localizado nenhum arquivo TXT.</b>
                        <br>Imagino que algo tenha dado errado no Dowload. Tente novamente.</p>
                    </div>
                <?php } ?>
                <?php
                //LISTAGEM DOS ARQUIVOS Já GERADOS 
                if( count($countFileSQLConteudo) > 0 ){ ?>

                    <div class="alert alert-info mt-3" role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i> Já existe <?=count($countFileSQLConteudo)?> arquivo(s) exportados!
                        <hr/>
                        <span class="text-muted">Clique abaixo no link para Download.</span>

                        <ol class="mt-3">
                        <?php
                        foreach ($countFileSQLConteudo as $download) {
                        echo "<li><a href='".$path."/".$download."'>".$download."</a>";
                        }
                        ?>
                        </ol>

                    </div>

                <?php
                } ?>
          </div>
        </div>
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal"><i class="fa-solid fa-file-csv"></i> ARQUIVO CSV</h4>
            </div>
            <div class="card-body card-conteudo-csv">
                <h1 class="card-title pricing-card-title <?=(count($countFileConteudo)>0)?'':'text-danger'?> "><?=count($countFileConteudo)?> <small class="<?=(count($countFileConteudo)>0)?'text-muted':'text-danger'?>"> TXT de Conteúdo</small></h1>            
                
                <?php if( count($countFileConteudo) > 0){?>
                    <a href="importacaoCriarConteudosCSV.php?download=<?=$_GET['download']?>#footer" role="button" class="btn btn-lg btn-block btn-outline-success">Exportar TXT para CSV</a>
                
                <?php }else{ ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fa-solid fa-bug"></i>Estranho. 
                        <p><b>Não foi localizado nenhum arquivo TXT.</b>
                        <br>Imagino que algo tenha dado errado no Dowload. Tente novamente.</p>
                    </div>
                <?php } ?>
                <?php
                //LISTAGEM DOS ARQUIVOS Já GERADOS 
                if( count($countFileSQLConteudoCSV) > 0 ){ ?>

                    <div class="alert alert-info mt-3" role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i> Já existe <?=count($countFileSQLConteudoCSV)?> pastas(s) exportadas!
                        <hr/>
                        <span class="text-muted">Clique abaixo no link para Download.</span>

                        <ol class="mt-3">
                        <?php
                        foreach ($countFileSQLConteudoCSV as $download) {
                            echo "<li><a href='".$path."/".$download."'>".$download."</a>";
                        }
                        ?>
                        </ol>
                    </div>

                <?php
                } ?>
            </div>
        </div>
    </div>
</div>


<?php
include "footer.php";
