<?php

function gerarCreateSQL($path, $arquivo){
 
    $nomeTabela = str_replace('_layout.txt', '', $arquivo); 
    $sql = "CREATE TABLE IF NOT EXISTS $nomeTabela (";

    $txt_layout = fopen($path.'/'.$arquivo,'r');
    $linha = 1;
    while ($conteudo = fgets($txt_layout)) {
        if( $linha > 1 ){
            
            // exemplo da linha do txt
            // CO_OCUPACAO,6,1,6,CHAR

            $coluna = explode(',', $conteudo);

            if( trim($coluna[4]) == "VARCHAR2" ){
                $nomeColuna = "VARCHAR($coluna[1])";

            }else if( trim($coluna[4]) == "NUMBER" ){
                $nomeColuna = "INT($coluna[1])"; 
        
            }else{
                $nomeColuna = trim($coluna[4])."($coluna[1])";
            }
            
            if( $linha > 2 ) $sql .= ",";
            $sql .= " $coluna[0] $nomeColuna DEFAULT NULL";
        
        }
        $linha++;
    }

    $sql .= ") ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";

    fclose($txt_layout);

    return $sql;
}

function gerarCreateSQLConteudo($path, $arquivo){
    
    $arquivoLayout = str_replace('.txt', '_layout.txt', $arquivo); 
    $dbTabelaNome = str_replace('.txt', '', $arquivo); 

    //echo "file: ".$arquivo."<br>";
    //echo "file layout: ".$arquivoLayout."<br>";

    if( !file_exists($path."/".$arquivoLayout) ) return false;
    if( !file_exists($path."/".$arquivo) ) return false;

    //MONTANDO A ESTRUTURA NECESSARIA PARA LER O ARQUIVO
    $txt_layout = fopen($path.'/'.$arquivoLayout,'r');
    $linha = 1;
    $colunas = []; 
    $colunasLayout = []; 

    while ($conteudo = fgets($txt_layout)) {
        if( $linha > 1 ){
            $pecas = explode(",", $conteudo);

            $colunasLayout['coluna'] = $pecas[0];
            $colunasLayout['tamanho'] = $pecas[1];
            $colunasLayout['inicio'] = $pecas[2];
            $colunasLayout['fim'] = $pecas[3];
            $colunasLayout['tipo'] = $pecas[4];

            array_push($colunas, $colunasLayout);
        }
        $linha ++;
    }

    /*
    echo "Tamanho eh ".count($colunas)."<br>";
    echo "coluna 01 - Nome ".$colunas[0]['coluna']."<br>";
    echo "coluna 01 - Inicio ".$colunas[0]['inicio']."<br>";
    echo "coluna 01 - Inicio ".$colunas[0]['fim']."<br>";

    print_r( $colunas );
    exit("foiiii????");*/

    $sql = "DELETE FROM $dbTabelaNome; INSERT INTO $dbTabelaNome ( ";
    $sqlColunas = "";
    $sqlValues  = "";

    $txt_conteudo = fopen($path.'/'.$arquivo,'r');
    $linha = 1;
    while ($conteudo = fgets($txt_conteudo)) {
        
        // echo "linha ".$linha." - ".$conteudo."<br>";
        $h = 0;

        $linhaColuna = "";
        $linhaValue = "";
        $value = "";
        foreach ($colunas as $posicao) {

            if( $linha==1 ) $linhaColuna .= $posicao['coluna'].",";
            $inicio = $posicao['inicio'] -1;
            
            if( $posicao['tipo'] == "NUMBER" ){
                $value  = substr($conteudo, $inicio, $posicao['tamanho']).",";    
            }else{
                $value  = "'".trim(substr($conteudo, $inicio, $posicao['tamanho']))."'".",";
            }

            $linhaValue .= $value;

            //DEBUG
            /*
            if( $linha==1 ){
                echo "coluna: ".$posicao['coluna']."<br>";
                echo "inicio: ".$posicao['inicio']."<br>";
                echo "fim: ".$posicao['fim']."<br>";
                echo "tamanho: ".$posicao['tamanho']."<br>";
                echo "fim: ".$posicao['tipo'];
                echo "<b>Value: ".$value."</b>";
                echo "<hr>";
            }*/

            //exemplo:
            /*
            0201010569
            1720
            0000000
            0006000
            0000000
            202310
            */

            //$colunaName = $posicao['coluna'];
            //$colunaValue = substr($conteudo, $posicao['inicio'], $posicao['fim']);

            /*
            
            INSERT INTO `CargaTemp` (`id`, `clienteid`, `clienterefexterna`, `clientenome`, `unidadeid`, `unidadenome`, `unidademunicipio`, `unidadeuf`, `paciente`, `pacienteidade`, `pacientesexo`, `pacientecarteirinha`, `pacientedatainternacao`, `pacientecid`, `guiainternacao`)
            VALUES
	        (23453, 123, 72, 'UNIMED ARACATUBA COOP TRABALHO MEDICO', 165, 'HOSPITAL UNIMED ARACATUBA', 'ARACATUBA', 'SP', 'ALINE BORGES DOS SANTOS', 36, 2, '970.0019002315298', '2023-09-04 00:00:00', 'O82.1 ', '202303552363');
            
            */

            $h ++;
        }

        if($linha==1) $sqlColunas .= $linhaColuna;
        $sqlValues .= "(".$linhaValue."), ";

        //if($linha == 5) break;

        $linha++;
    }
    fclose($txt_conteudo);

    $sql = $sql . $sqlColunas . ") VALUES ". $sqlValues . ";";
    $sql = str_replace(',)', ')', $sql); 
    $sql = str_replace('), ;', ');', $sql); 

    return $sql;
}

function gerarCreateSQLConteudoCSV($path, $pathZIP, $arquivo){

    $arquivoLayout = str_replace('.txt', '_layout.txt', $arquivo); 
    $arquivoCsv = str_replace('.txt', '.csv', $arquivo); 

    if( !file_exists($path."/".$arquivoLayout) ) return false;
    if( !file_exists($path."/".$arquivo) ) return false;

    $txt_layout = fopen($path.'/'.$arquivoLayout,'r');
    $linha = 1;
    $colunas = []; 

    while ($conteudo = fgets($txt_layout)) {
        if( $linha > 1 ){
            $pecas = explode(",", $conteudo);

            $colunasLayout['coluna'] = $pecas[0];
            $colunasLayout['tamanho'] = $pecas[1];
            $colunasLayout['inicio'] = $pecas[2];
            $colunasLayout['fim'] = $pecas[3];
            $colunasLayout['tipo'] = $pecas[4];

            array_push($colunas, $colunasLayout);
        }
        $linha ++;
    }

    $txt_conteudo = fopen($path.'/'.$arquivo,'r');
    $linha = 1;

    //criando o arquivo

    $pathFolder = $path."/".$pathZIP;
    if (!file_exists($pathFolder)) mkdir($pathFolder);
    if (!$fileCSV_Temp = fopen($pathFolder."/".$arquivoCsv,"w")) return false;

    while ($conteudo = fgets($txt_conteudo)) {

        $linhaColuna = "";
        $value = "";

        foreach ($colunas as $posicao) {

            if( $linha==1 ) $linhaColuna .= $posicao['coluna'].",";
            $inicio = $posicao['inicio'] -1;
            $value  .= trim(substr($conteudo, $inicio, $posicao['tamanho'])).",";    
        }

        /*
        GRANDO A LINHA*/
        if( $linha==1 ) fwrite($fileCSV_Temp,$linhaColuna."\n");
        fwrite($fileCSV_Temp,$value."\n");

        $linha ++;
    }

    fclose($fileCSV_Temp);
    return true;
}

function criarArquivo( $nomeFile, $conteudo ){

    $newFile = fopen($nomeFile, "w");
    if( !file_exists($nomeFile) ) return false;
    fwrite($newFile, $conteudo);
    fclose($newFile);

    return true;
}