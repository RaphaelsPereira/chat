<?php
// Incluir o arquivo de conexão com o banco de dados
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Link para a folha de estilo externa -->
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <!-- Link para a folha de estilo do Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Mukta+Vaani" rel="stylesheet">
    <!-- Código JavaScript para AJAX -->
    <script type="text/javascript">
        function ajax(){
            // Criar um novo objeto XMLHttpRequest
            var req = new XMLHttpRequest();
            // Definir a função de retorno de chamada para lidar com a resposta
            req.onreadystatechange = function(){
                if(req.readyState == 4 && req.status == 200){
                    // Outra solicitação AJAX para atualizar o conteúdo do chat
                    req.onreadystatechange = function(){
                        if(req.readyState == 4 && req.status == 200){ 
                            // Atualizar a div 'chat' com o texto da resposta
                            document.getElementById('chat').innerHTML = req.responseText; 
                        }
                    }
                    // Abrir e enviar a solicitação GET para 'chat.php'
                    req.open('GET', 'chat.php', true); 
                    req.send();
                }
            }
        }
        // Configurar um temporizador para chamar a função 'ajax' a cada 1000 milissegundos (1 segundo)
        setInterval(function(){ajax();}, 1000);
    </script>

    <title>Chat</title>
</head>
<body onload="ajax();">
    <div id="conteudo">
        <div id="caixa-chat">
            <div id="chat">
                <!-- Aqui é onde o conteúdo do chat será exibido -->
            </div>
        </div>
        <!-- Formulário para entrada do usuário -->
        <form method="POST" action="index.php">
            <input type="text" name="nome" placeholder="Preencha seu Nome">
            <textarea name="mensagem" placeholder="Insira uma mensagem"></textarea>
            <input type="submit" name="enviar" value="Enviar">
        </form>

        <?php
        // Verificar se o formulário foi enviado
        if(isset($_POST['enviar'])){
            // Obter a entrada do usuário
            $nome = $_POST['nome'];
            $mensagem = $_POST['mensagem'];
            // Consulta SQL para inserir dados na tabela 'tb_chat'
            $consulta = "INSERT INTO tb_chat (nome, mensagem) VALUES ('$nome', '$mensagem')";
            // Executar a consulta
            $executar = $conexao->query($consulta);
            // Verificar se a consulta foi bem-sucedida
            if($executar){
                // Reproduzir um som de notificação (assumindo que 'beep.mp3' existe no mesmo diretório)
                echo "<embed loop='false' src='MessageAmongUs.mp3' hidden='true' autoplay='true'>";
            }
        }
        ?>
    </div>
</body>
</html>