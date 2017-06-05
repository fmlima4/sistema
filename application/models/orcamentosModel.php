<?php

class orcamentosModel extends CI_Model {
	
	var $table = "orcamentos";
	
	function __construct() {
		parent::__construct();
	}

	function inserir($data) {
		return $this->db->insert('orcamentos', $data);
	}

	function listar($sort = 'ocod', $order = 'asc',$limit =null, $offset = null) {
		$this->db->order_by($sort, $order);

		if($limit){
			$this->db->limit($limit,$offset);
		}

		$this->db->select('orcdat, situacao, ocod, valor, cnome, pnome,numero,rnome');
	 	$this->db->from('orcamentos');
		$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
		$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
		$this->db->join('representantes', 'representantes.rcod = clientes.representante');
		$query = $this->db->get(); 
	    return $query->result();
	}

	function soma(){
		$this->db->select('valor');
		$this->db->from('orcamentos');
		$query = $this->db->get();
	   	return $query->result();
	}

	function countAll(){
		return $this->db->count_all($this->table);
	}

	function editar($ocod) {
		$this->db->select('cliente, produto, ocod, cnome, pnome, orcdat, situacao, valor,numero');
	    $this->db->where('ocod', $ocod);
	    $this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
		$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
	    $query = $this->db->get('orcamentos');
	    return $query->result();
	}
	 
	function atualizar($data) {
	$this->db->where('ocod', $data['ocod']);
	    $this->db->set($data);
	    return $this->db->update('orcamentos');
	}
	 
	function deletar($ocod) {
	    $this->db->where('ocod', $ocod);
	    return $this->db->delete('orcamentos');
	}

	function history($ccod) {

		$this->db->select('orcdat, situacao, ocod, cnome, pnome');
		$this->db->where('cliente', $ccod);
	 	$this->db->from('orcamentos');
		$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
		$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
		$query = $this->db->get(); 
	    return $query->result();
	}
	
	public function search2(){
		$termo1 = $this->input->post('search1');
		$termo2 = $this->input->post('search2');
		$termo3 = $this->input->post('search3');
		$termo4 = $this->input->post('search4');
		$termo5 = $this->input->post('search5');
		$termo6 = $this->input->post('search6');

		
	//filtros por data
		if (!empty($termo5 and $termo6)){
				//todos vazios
			if (empty($termo1 and $termo2 and $termo3 and $termo4 )){
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor ,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->where('orcdat >=', $termo5);
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();

			}

			// busca pelo cliente 1
			if(empty($termo2) and empty($termo3) and empty($termo4) and !empty($termo1)){
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor ,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->like('cnome', $termo1);
				$this->db->where('orcdat >=', $termo5);
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();
				return $query->result();
		
			}

			//busca pelo produto 2
			if(empty($termo1) and empty($termo3) and empty($termo4) and !empty($termo2)){
				//die('oi');
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor ,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->like('pnome', $termo2);
				$this->db->where('orcdat >=', $termo5);
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();
				return $query->result();
		
			}

			//busca pela situação 3
			if(empty($termo2) and empty($termo1) and empty($termo4) and !empty($termo3)){
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor ,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->like('situacao', $termo3);
				$this->db->where('orcdat >=', $termo5);
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();
				return $query->result();
		
			}

			//busca pelo representante 4
			if(empty($termo1) and empty($termo2) and empty($termo3) and !empty($termo4)){
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor ,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->like('rnome', $termo4);
				$this->db->where('orcdat >=', $termo5);
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();
				return $query->result();
		
			}

			// busca pelo cliente e produto 1-2
			if (!empty($termo1 and $termo2) and empty($termo3) and empty($termo4)){
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->like('cnome', $termo1);
				$this->db->like('pnome', $termo2);
				$this->db->where('orcdat >=', $termo5);
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();
				return $query->result();			
			}

			// busca pelo cliente e situção 1-3
			if (!empty($termo1 and $termo3) and empty($termo2) and empty($termo4)){
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->like('cnome', $termo1);
				$this->db->like('situacao', $termo3);
				$this->db->where('orcdat >=', $termo5);
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();
				return $query->result();			
			}

			// busca pelo cliente e representante  1-4
			if (!empty($termo1 and $termo4) and empty($termo2) and empty($termo3)){
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->like('cnome', $termo1);
				$this->db->like('rnome', $termo4);
				$this->db->where('orcdat >=', $termo5);	
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();
				return $query->result();			
			}

			// busca pelo produto e situaação  2-3
			if (!empty($termo2 and $termo3) and empty($termo1) and empty($termo4)){
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->like('pnome', $termo2);
				$this->db->like('situacao', $termo3);
				$this->db->where('orcdat >=', $termo5);
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();
				return $query->result();			
			}

			// busca pelo produto e representante 2-4
			if (!empty($termo2 and $termo4) and empty($termo1) and empty($termo3)){
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->like('pnome', $termo2);
				$this->db->like('rnome', $termo4);
				$this->db->where('orcdat >=', $termo5);
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();
				return $query->result();			
			}

			// busca pela situação e representante 3-4
			if (!empty($termo3 and $termo4) and empty($termo1) and empty($termo2)){
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->like('situacao', $termo3);
				$this->db->like('rnome', $termo4);
				$this->db->where('orcdat >=', $termo5);
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();
				return $query->result();			
			}

			// busca pelo cliente e produto e situação 1-2-3
			if (!empty($termo1 and $termo2 and $termo3) and empty($termo4)){
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->like('cnome', $termo1);
				$this->db->like('pnome', $termo2);
				$this->db->like('situacao', $termo3);
				$this->db->where('orcdat >=', $termo5);
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();
				return $query->result();			
			}

			// busca pelo cliente e situação e representante 1-3-4
			if (!empty($termo1 and $termo3 and $termo4) and empty($termo2)){
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->like('cnome', $termo1);
				$this->db->like('situacao', $termo3);
				$this->db->like('rnome', $termo4);
				$this->db->where('orcdat >=', $termo5);
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();
				return $query->result();			
			}

			// busca pelo produto e situação e representante 2-3-4
			if (!empty($termo2 and $termo3 and $termo4) and empty($termo1)){
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->like('pnome', $termo2);
				$this->db->like('situacao', $termo3);
				$this->db->like('rnome', $termo4);
				$this->db->where('orcdat >=', $termo5);
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();
				return $query->result();			
			}

			// busca pelo produto e cliente e representante 2-1-4
			if (!empty($termo2 and $termo1 and $termo4) and empty($termo3)){
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->like('pnome', $termo2);
				$this->db->like('cnome', $termo1);
				$this->db->like('rnome', $termo4);
				$this->db->where('orcdat >=', $termo5);
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();
				return $query->result();			
			}

			// busca de todos juntos
			if (!empty($termo1 and $termo2 and $termo3 and $termo4)){
				$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
			 	$this->db->from('orcamentos');
				$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
				$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
				$this->db->join('representantes', 'representantes.rcod = clientes.representante');
				$this->db->like('cnome', $termo1);
				$this->db->like('pnome', $termo2);
				$this->db->like('situacao', $termo3);
				$this->db->like('rnome', $termo4);
				$this->db->where('orcdat >=', $termo5);
				$this->db->where('orcdat <=', $termo6);	
				$query = $this->db->get();
				return $query->result();			
			}
				
		}

		//todos vazios
		if (empty($termo1 and $termo2 and $termo3 and $termo4 )){
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor ,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$query = $this->db->get();

		}

		// busca pelo cliente 1
		if(empty($termo2) and empty($termo3) and empty($termo4) and !empty($termo1)){
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor ,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$this->db->like('cnome', $termo1);
			$query = $this->db->get();
			return $query->result();

		}

		//busca pelo produto 2
		if(empty($termo1) and empty($termo3) and empty($termo4) and !empty($termo2)){
			//die('oi');
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor ,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$this->db->like('pnome', $termo2);
			$query = $this->db->get();
			return $query->result();

		}

		//busca pela situação 3
		if(empty($termo2) and empty($termo1) and empty($termo4) and !empty($termo3)){
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor ,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$this->db->like('situacao', $termo3);
			$query = $this->db->get();
			return $query->result();

		}

		//busca pelo representante 4
		if(empty($termo1) and empty($termo2) and empty($termo3) and !empty($termo4)){
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor ,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$this->db->like('rnome', $termo4);
			$query = $this->db->get();
			return $query->result();

		}

		// busca pelo cliente e produto 1-2
		if (!empty($termo1 and $termo2) and empty($termo3) and empty($termo4)){
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$this->db->like('cnome', $termo1);
			$this->db->like('pnome', $termo2);
			$query = $this->db->get();
			return $query->result();			
		}

		// busca pelo cliente e situção 1-3
		if (!empty($termo1 and $termo3) and empty($termo2) and empty($termo4)){
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$this->db->like('cnome', $termo1);
			$this->db->like('situacao', $termo3);
			$query = $this->db->get();
			return $query->result();			
		}

		// busca pelo cliente e representante  1-4
		if (!empty($termo1 and $termo4) and empty($termo2) and empty($termo3)){
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$this->db->like('cnome', $termo1);
			$this->db->like('rnome', $termo4);
			$query = $this->db->get();
			return $query->result();			
		}

		// busca pelo produto e situaação  2-3
		if (!empty($termo2 and $termo3) and empty($termo1) and empty($termo4)){
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$this->db->like('pnome', $termo2);
			$this->db->like('situacao', $termo3);
			$query = $this->db->get();
			return $query->result();			
		}

		// busca pelo produto e representante 2-4
		if (!empty($termo2 and $termo4) and empty($termo1) and empty($termo3)){
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$this->db->like('pnome', $termo2);
			$this->db->like('rnome', $termo4);
			$query = $this->db->get();
			return $query->result();			
		}

		// busca pela situação e representante 3-4
		if (!empty($termo3 and $termo4) and empty($termo1) and empty($termo2)){
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$this->db->like('situacao', $termo3);
			$this->db->like('rnome', $termo4);
			$query = $this->db->get();
			return $query->result();			
		}

		// busca pelo cliente e produto e situação 1-2-3
		if (!empty($termo1 and $termo2 and $termo3) and empty($termo4)){
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$this->db->like('cnome', $termo1);
			$this->db->like('pnome', $termo2);
			$this->db->like('situacao', $termo3);
			$query = $this->db->get();
			return $query->result();			
		}

		// busca pelo cliente e situação e representante 1-3-4
		if (!empty($termo1 and $termo3 and $termo4) and empty($termo2)){
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$this->db->like('cnome', $termo1);
			$this->db->like('situacao', $termo3);
			$this->db->like('rnome', $termo4);
			$query = $this->db->get();
			return $query->result();			
		}

		// busca pelo produto e situação e representante 2-3-4
		if (!empty($termo2 and $termo3 and $termo4) and empty($termo1)){
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$this->db->like('pnome', $termo2);
			$this->db->like('situacao', $termo3);
			$this->db->like('rnome', $termo4);
			$query = $this->db->get();
			return $query->result();			
		}

		// busca pelo produto e cliente e representante 2-1-4
		if (!empty($termo2 and $termo1 and $termo4) and empty($termo3)){
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$this->db->like('pnome', $termo2);
			$this->db->like('cnome', $termo1);
			$this->db->like('rnome', $termo4);
			$query = $this->db->get();
			return $query->result();			
		}

		// busca de todos juntos
		if (!empty($termo1 and $termo2 and $termo3 and $termo4)){
			$this->db->select('ocod, cnome, pnome, orcdat, situacao, valor,numero,rnome');
		 	$this->db->from('orcamentos');
			$this->db->join('clientes', 'clientes.ccod = orcamentos.cliente');
			$this->db->join('produtos', 'produtos.pcod = orcamentos.produto');
			$this->db->join('representantes', 'representantes.rcod = clientes.representante');
			$this->db->like('cnome', $termo1);
			$this->db->like('pnome', $termo2);
			$this->db->like('situacao', $termo3);
			$this->db->like('rnome', $termo4);
			$query = $this->db->get();
			return $query->result();			
		}

		return $query->result();

	}
}

?>