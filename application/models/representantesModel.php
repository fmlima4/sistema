<?php

class representantesModel extends CI_Model {

	var $table = "representantes";

	function __construct() {
		parent::__construct();
	}

	function inserir($data) {
		return $this->db->insert('representantes', $data);
	}

	function listar($sort = 'rcod', $order = 'asc', $limit =null, $offset = null) {
		$this->db->order_by($sort, $order);

		if($limit){
			$this->db->limit($limit,$offset);
		}

		$query = $this->db->get('representantes');
		return $query->result();
	}

	function countAll(){
		return $this->db->count_all($this->table);
	}

	function editar($rcod) {
	    $this->db->where('rcod', $rcod);
	    $query = $this->db->get('representantes');
	    return $query->result();
	}
	 
	function atualizar($data) {
	    $this->db->where('rcod', $data['rcod']);
	    $this->db->set($data);
	    return $this->db->update('representantes');
	}
	 
	function deletar($rcod) {
    $this->db->where('rcod', $rcod);    

    $db_debug = $this->db->db_debug; //salve a configuração
    $this->db->db_debug = FALSE; //desabilita o debug para consultas

    if ( !$this->db->delete('representantes') )
    {
        $error = $this->db->error();

        $this->session->set_flashdata('mensagemErro', "<div class='alert alert-warning'> Representante nao pode ser deletado pois existe um cliente referenciado !!</div>");

        $this->db->db_debug = $db_debug; //restaure a configuração de debug

    }

    if($this->db->affected_rows() == 1){
		return 1;
		} else{
		return 0;
		}
    
	}

	public function search(){
		
		$termo = $this->input->post('search');
		
		$this->db->select('rcod,rnome, email, fone');
		$this->db->from('representantes');
		$this->db->like('rnome', $termo);
		$query = $this->db->get();
		return $query->result();
	}

  	function get_representante($q){
		$this->db->select('rnome,rcod'); 
	    $this->db->like('rnome', $q);
	    $query = $this->db->get('representantes');
	    if($query->num_rows() > 0){
	      foreach ($query->result_array() as $row){
	        $new_row['label']=htmlentities(stripslashes($row['rnome']));
	        $new_row['value']=htmlentities(stripslashes($row['rcod']));
	        $row_set[] = $new_row; //build an array
	      }
	      echo json_encode($row_set); //format the array into json data
	    }
	}


}

?>