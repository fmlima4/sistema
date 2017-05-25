<?php

function logged() {
    //Instância do CodeIgniter
    $ci = & get_instance();
    //Método atual
    $method = $ci->router->fetch_class().'/'.$ci->router->fetch_method();
    //Métodos protegidos
    $protegidos = ['clientes/index','produtos/index','orcamentos/index','equipe/index','clientes/inserir', 'clientes/editar','clientes/atualizar','clientes/deletar','clientes/inserir_coment','clientes/edit_coment','clientes/atuaalizar_coment','clientes/deletar_coment','clientes/history','clientes/exports','clientes/pesquisar1','calendar2/index','calendar2/getEvents','calendar2/updateEvents','calendar2/deleteEvents','calendar2/new_event', 'comments/history','comments/inserir_coment','comments/edit_coment','comments/atualizar_coment','comments/deletar_coment','comments/pesquisar_comments','equipe/index','equipe/inserir','equipe/editar', 'equipe/atualizar','equipe/deletar','equipe/pesquisar','equipe/exports','orcamentos/index','orcamentos/inserir','orcamentos/editar','orcamentos/atualizar','orcamentos/deletar','orcamentos/history','orcamentos/exports','orcamentos/pesquisar1','orcamentos/pesquisar2','orcamentos/pesquisar3','produtos/index','produtos/inserir','produtos/editar','produtos/atualizar','produtos/deletar','produtos/exports','produtos/pesquisar'];
    
    //Array gerado pelo seu algotitmo de "login" e gravado na SESSION
    $usuario_logado = $ci->session->userdata('usuario_logado');
    if (in_array($method, $protegidos)) {//Verificando se o método é protegido
        if ($usuario_logado['username']=='not_autorized') {//Verificando se o usuário está logado
            $ci->session->set_flashdata('alert', 'Autentique-se, por favor!');//Aqui vc tb pode criar um aviso pro usuário saber o motivo do comportamento da aplicação
            Redirect('http://localhost/sistema/');//usuário não logado direciona para a pagina de login
        } 
    }
}
?>