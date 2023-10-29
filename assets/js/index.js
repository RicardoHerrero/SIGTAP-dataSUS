$(document).ready(function () {
    
    $('#informarMysql').click(function(){
        $('#objetivosDetalhes').hide()
        $('#informarMysql').hide()
        $('#formularioConexao').show()
        /*
        $.ajax({
            type: 'POST',
            url : "../src/auditorias-ajax.php",
            dataType: 'html',
            data : {
                acao : 'PerfilPaciente',
                operadoras : $('#operadoras').val()
            },
            success: function (result) {
                $("#ClientesUnidades").html(result);
            },
            error: function (result) {
                console.log(result);
            }
        });*/
    });

    $("#formularioConexao").submit(function(){
        if( $('#conexaoHost').val().trim() !== "" 
            && $('#conexaoUsuario').val().trim() !== "" 
            && $('#conexaoSenha').val().trim() !== "" 
            && $('#conexaoAceite').is(':checked')
        ){            
            
        }else{
            alert("Preencha os dados da conexão!");
        }
    });
});
