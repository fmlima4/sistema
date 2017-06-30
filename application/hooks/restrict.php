<?php

function restrict() {
    
    //Instância do CodeIgniter
    $ci = & get_instance();
    //Método atual
    $method = $ci->router->fetch_class().'/'.$ci->router->fetch_method();
    //Métodos protegidos
    $protegidos = ['equipe/index','equipe/inserir','equipe/editar', 'equipe/atualizar','equipe/deletar','equipe/pesquisar','equipe/exports','clientes/deletar'];
    
    //Array gerado pelo seu algotitmo de "login" e gravado na SESSION
    $usuario_logado = $ci->session->userdata('usuario_logado');
    if (in_array($method, $protegidos)) {//Verificando se o método é protegido
        if ($usuario_logado['cargo']!='admin') {//Verificando se o usuário está logado
            $ci->session->set_flashdata('alert', 'Voçe nao possui privilegios');//Aqui vc tb pode criar um aviso pro usuário saber o motivo do comportamento da aplicação
?>

            <script>
                alert('você nao possui autorização');
            </script>

<?php
            $var = "<script>javascript:history.back(-2)</script>";
            echo $var;
        } 
    }
}
?>