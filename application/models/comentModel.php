<?php

class comentModel extends CI_Model {

	var $table = "comentarios";

	function __construct() {
			parent::__construct();
		}

	function inserir_coment($data) {
			return $this->db->insert('comentarios', $data);
		}

	function edit_coment($comcod) {
		$this->db->where('comcod', $comcod);
	    $query = $this->db->get('comentarios');
	    return $query->result();
	}
	 
	function atualizar_coment($data) {
	    $this->db->where('comcod', $data['comcod']);
	    $this->db->set($data);
	    return $this->db->update('comentarios');
	}

	function delet_coment($comcod) {
	    $this->db->where('comcod', $comcod);
	    return $this->db->delete('comentarios');
	}

	function listar($sort = 'comcod', $order = 'asc', $limit =null, $offset = null) {
		$this->db->order_by($sort, $order);

		if($limit){

			$this->db->limit($limit,$offset);
		}

		$this->db->select('dat, cliente, texto, comcod, cnome, username');
	    $this->db->from('comentarios');
	    $this->db->join('clientes', 'clientes.ccod = comentarios.cliente');
		$this->db->join('users', 'users.id = comentarios.autor');
		$query = $this->db->get(); // testar aqui a sintaxe
	    return $query->result();
	}

	function countAll(){
		return $this->db->count_all($this->table);
	}

	public function search1(){

		$termo1 = $this->input->post('search1');
		$termo2 = $this->input->post('search2');
		$termo3 = $this->input->post('search3');

		if (empty($termo1 and $termo2 and $termo3)){
			$this->db->select('comcod,dat, cnome, texto, username');
			$this->db->from('comentarios');
	    	$this->db->join('clientes', 'clientes.ccod = comentarios.cliente');
			$this->db->join('users', 'users.id = comentarios.autor');
			$query = $this->db->get(); 
			
		}

		if(empty($termo2) and empty($termo3)  and !empty($termo1)){
			$this->db->select('comcod,dat, cnome, texto, username');
			$this->db->from('comentarios');
	    	$this->db->join('clientes', 'clientes.ccod = comentarios.cliente');
			$this->db->join('users', 'users.id = comentarios.autor');
			$this->db->like('cnome', $termo1);
			$query = $this->db->get(); 
	  		return $query->result();
		}

		if(empty($termo1) and empty($termo3) and !empty($termo2)){
		
			$this->db->select('comcod,dat, cnome, texto, username');
			$this->db->from('comentarios');
	    	$this->db->join('clientes', 'clientes.ccod = comentarios.cliente');
			$this->db->join('users', 'users.id = comentarios.autor');
			$this->db->like('texto', $termo2);
			$query = $this->db->get(); 
	  		return $query->result();
		}

		if(empty($termo1) and empty($termo2) and !empty($termo3)){
			
			$this->db->select('comcod,dat, cnome, texto, username');
			$this->db->from('comentarios');
	    	$this->db->join('clientes', 'clientes.ccod = comentarios.cliente');
			$this->db->join('users', 'users.id = comentarios.autor');
			$this->db->like('username', $termo3);
			$query = $this->db->get(); 
	  		return $query->result();
		}

		if (!empty($termo1 and $termo2 and $termo3)){
			
			$this->db->select('comcod,dat, cnome, texto, username');
			$this->db->from('comentarios');
	    	$this->db->join('clientes', 'clientes.ccod = comentarios.cliente');
			$this->db->join('users', 'users.id = comentarios.autor');
			$this->db->like('cnome', $termo1);
			$this->db->like('texto', $termo2);
			$this->db->like('username', $termo3);
			$query = $this->db->get(); 
	  		return $query->result();
		}

		if (!empty($termo1 and $termo2) and empty($termo3)){
			
			$this->db->select('comcod,dat, cnome, texto, username');
			$this->db->from('comentarios');
	    	$this->db->join('clientes', 'clientes.ccod = comentarios.cliente');
			$this->db->join('users', 'users.id = comentarios.autor');
			$this->db->like('cnome', $termo1);
			$this->db->like('texto', $termo2);
			$query = $this->db->get(); 
	  		return $query->result();
		}

		if (!empty($termo1 and $termo3) and empty($termo2)){
			
			$this->db->select('comcod,dat, cnome, texto, username');
			$this->db->from('comentarios');
	    	$this->db->join('clientes', 'clientes.ccod = comentarios.cliente');
			$this->db->join('users', 'users.id = comentarios.autor');
			$this->db->like('cnome', $termo1);
			$this->db->like('username', $termo3);
			$query = $this->db->get(); 
	  		return $query->result();
		}

		if (!empty($termo2 and $termo3) and empty($termo1)){
			
			$this->db->select('comcod,dat, cnome, texto, username');
			$this->db->from('comentarios');
	    	$this->db->join('clientes', 'clientes.ccod = comentarios.cliente');
			$this->db->join('users', 'users.id = comentarios.autor');
			$this->db->like('texto', $termo2);
			$this->db->like('username', $termo3);
			$query = $this->db->get(); 
	  		return $query->result();
		}
		//return $query->result();
		}

	function get_cliente($q){
		$this->db->select('cnome,ccod'); 
		$this->db->from('comentarios');
	    $this->db->join('clientes', 'clientes.ccod = comentarios.cliente');  
	    $this->db->like('cnome', $q);
	    $this->db->group_by('cnome');
	    $query = $this->db->get();
	    if($query->num_rows() > 0){
	      foreach ($query->result_array() as $row){
	        $new_row['label']=htmlentities(stripslashes($row['cnome']));
	        $new_row['value']=htmlentities(stripslashes($row['ccod']));
	        $row_set[] = $new_row; //build an array
	      }
	      echo json_encode($row_set); //format the array into json data
	    }
	}

}

?>