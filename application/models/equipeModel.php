<?php

class equipeModel extends CI_Model {

	var $table = "users";


	function __construct() {
		parent::__construct();
	}

	function inserir($data) {
		return $this->db->insert('users', $data);
	}

	function listar($sort = 'id', $order = 'asc', $limit =null, $offset = null) {

		$this->db->order_by($sort, $order);

		if($limit){
			$this->db->limit($limit,$offset);
		}


		$query = $this->db->get('users');
		return $query->result();
	}

	function countAll(){
		return $this->db->count_all($this->table);
	}

	function editar($id) {
	    $this->db->where('id', $id);
	    $query = $this->db->get('users');
	    return $query->result();
	}
	 
	function atualizar($data) {
	    $this->db->where('id', $data['id']);
	    $this->db->set($data);
	    return $this->db->update('users');
	}
	 
	function deletar($id) {
	    $this->db->where('id', $id);
	    return $this->db->delete('users');
	}

	public function search(){
		$termo = $this->input->post('search');
		$this->db->select();
		$this->db->like('username', $termo);
		$query = $this->db->get('users');
		return $query->result();

	}


}

?>