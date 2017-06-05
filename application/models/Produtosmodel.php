<?php

class produtosModel extends CI_Model {

	var $table = "produtos";

	function __construct() {
		parent::__construct();
	}

	function inserir($data) {
		return $this->db->insert('produtos', $data);
	}

	function listar($sort = 'pcod', $order = 'asc', $limit =null, $offset = null) {
		$this->db->order_by($sort, $order);

		if($limit){
			$this->db->limit($limit,$offset);
		}

		$query = $this->db->get('produtos');
		return $query->result();
	}

	function countAll(){
		return $this->db->count_all($this->table);
	}

	function editar($pcod) {
	    $this->db->where('pcod', $pcod);
	    $query = $this->db->get('produtos');
	    return $query->result();
	}
	 
	function atualizar($data) {
	    $this->db->where('pcod', $data['pcod']);
	    $this->db->set($data);
	    return $this->db->update('produtos');
	}
	 
	function deletar($pcod) {
    $this->db->where('pcod', $pcod);    

    $db_debug = $this->db->db_debug; //salve a configuração
    $this->db->db_debug = FALSE; //desabilita o debug para consultas

    if ( !$this->db->delete('produtos') )
    {
        $error = $this->db->error();

        $this->session->set_flashdata('mensagemErro', "<div class='alert alert-warning'> Produto cagado</div>");

        $this->db->db_debug = $db_debug; //restaure a configuração de debug

        return 1;
    }

    return $this->db->affected_rows();
    
	}

	public function search(){
		$termo = $this->input->post('search');
		$this->db->select();
		$this->db->like('pnome', $termo);
		$query = $this->db->get('produtos');
		return $query->result();

	}

	function get_bird($q){
	    $this->db->select('*');
	    $this->db->like('pnome', $q);
	    $query = $this->db->get('produtos');
	    if($query->num_rows() > 0){
	      foreach ($query->result_array() as $row){
	        $new_row['label']=htmlentities(stripslashes($row['pnome']));
	        $new_row['value']=htmlentities(stripslashes($row['pnome']));
	        $row_set[] = $new_row; //build an array
	      }
	      echo json_encode($row_set); //format the array into json data
   		}
  	}

  	function get_produto($q){
		$this->db->select('pnome,pcod'); 
	    $this->db->like('pnome', $q);
	    $query = $this->db->get('produtos');
	    if($query->num_rows() > 0){
	      foreach ($query->result_array() as $row){
	        $new_row['label']=htmlentities(stripslashes($row['pnome']));
	        $new_row['value']=htmlentities(stripslashes($row['pcod']));
	        $row_set[] = $new_row; //build an array
	      }
	      echo json_encode($row_set); //format the array into json data
	    }
	}


}

?>