<?php if (! defined('BASEPATH')) exit('No direct script access allowed'); // linha de proteção ao controller
 
class Login extends CI_Controller{ // criação da classe Login
  
 public function index()
    {
        $this->load->view('welcome_message');
        $usuario = array('username'=>'not_autorized');
        $this->session->set_userdata('usuario_logado', $usuario);
    }

    public function autenticar(){
 
        $this->load->model("usuarios_model");// chama o modelo usuarios_model
        $username = $this->input->post("username");// pega via post o email que venho do formulario
        $password = $this->input->post("password"); // pega via post a senha que venho do formulario
        $usuario = $this->usuarios_model->buscaPorEmailSenha($username,$password); // acessa a função buscaPorEmailSenha do modelo
         
        if($usuario){
            $this->session->set_userdata('usuario_logado', $usuario);
            Redirect('http://localhost/sistema/clientes');
        }else{
             $this->session->set_flashdata('alert', 'Usuario ou senha incorretos');
                }
                
        Redirect('http://localhost/sistema/');
    }

    public function logout(){
    session_destroy(); //pei!!! destruimos a sessão 
    session_unset();
    echo "<script>alert('Você realizou logout!');top.location.href='http://localhost/sistema/';</script>"; 
    }


}