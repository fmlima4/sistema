<?php
class Usuarios_model extends CI_Model{

    public function buscaPorEmailSenha($username, $password){
        $this->db->where('username', $username);
        $this->db->where('password', $password);
      	$usuario = $this->db->get('users')->row_array();
        return $usuario;
    }

}