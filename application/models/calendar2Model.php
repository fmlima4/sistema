<?php

class calendar2Model extends CI_Model {

	var $table = "eventos";

	function __construct() {
		parent::__construct();
	}

	public function get_events(){
		$this->db->select('idevento id, inicio start, fim end,descricaoEvento text, user autor,importancia impor ,cnome title,ccod codigoCliente');
		$this->db->from('eventos');
		$this->db->join('clientes','clientes.ccod = eventos.nomeEvento');
		$this->db->where('user', $_SESSION['usuario_logado']['username']);
		return $this->db->get()->result();

	}	

	function get_late_events($sort = 'idevento', $order = 'asc', $limit =null, $offset = null) {
		$this->db->order_by($sort, $order);

		if($limit){
			$this->db->limit($limit,$offset);
		}

		$this->db->select('idevento, cnome, inicio, fim, descricaoEvento, user, importancia');
	 	$this->db->from('eventos');
		$this->db->join('clientes','clientes.ccod = eventos.nomeEvento');
		$this->db->where('inicio <', date('Y-m-d'));
		if( $_SESSION['usuario_logado']['cargo']==!'admin'){
			$this->db->where('user', $_SESSION['usuario_logado']['username']);
		}
		$query = $this->db->get(); 
	    return $query->result();
	}

	function countAll(){
		return $this->db->count_all($this->table);
	}

	function countAllLate(){
		return $this->db->count_all($this->table);
	}

	function inserir($data) {
		return $this->db->insert('eventos', $data);
	}

	function updateEvents($param) {
		$campos = array(
				'inicio' => $param['inicio'],
				'fim' => $param['fim']
			);

		$this->db->where('idevento', $param['id']);
		$this->db->update('eventos', $campos);

		if($this->db->affected_rows() == 1){
			return 1;
		} else{
			return 0;
			}		
		}
	function updateEvents2($data) {
	    $this->db->where('idevento', $data['idevento']);
	    $this->db->set($data);
	    return $this->db->update('eventos');
	}
		
	function deleteEvents($idevento){
		$this->db->where('idevento', $idevento);
		$this->db->delete('eventos');
		if($this->db->affected_rows() == 1){
			return 1;
		} else{
			return 0;
			}		
	}

	public function search(){
		$termo = $this->input->post('search');

		$this->db->select('idevento, cnome, inicio, fim, descricaoEvento, user, importancia');
	 	$this->db->from('eventos');
		$this->db->join('clientes','clientes.ccod = eventos.nomeEvento');
		$this->db->where('inicio <', date('Y-m-d'));
		$this->db->like('user', $termo);
		$query = $this->db->get(); 
	    return $query->result();

	}
}


