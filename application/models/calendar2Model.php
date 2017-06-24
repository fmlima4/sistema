<?php

class calendar2Model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function get_events(){
		$this->db->select('idevento id, inicio start, fim end,descricaoEvento text, user autor,importancia impor ,cnome title');
		$this->db->from('eventos');
		$this->db->join('clientes','clientes.ccod = eventos.nomeEvento');
		return $this->db->get()->result();

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
		
	function deleteEvents($id){
		$this->db->where('idevento', $id);
		$this->db->delete('eventos');
		if($this->db->affected_rows() == 1){
			return 1;
		} else{
			return 0;
			}		
		}
}


