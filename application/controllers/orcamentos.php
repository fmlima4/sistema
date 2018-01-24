<?php

class Orcamentos extends CI_Controller {

	function __construct() {
		parent::__construct();
		/* Carrega o modelo */
		$this->load->model('orcamentosModel', 'model', TRUE);
	}
		
	function index()
	{
		$this->template->set('title', 'Lista de Orçamentos');
		$config = array(
			"base_url" => base_url('orcamentos/p'),
			"per_page" => 9,
			"num_links" => 3,
			"uri_segment" => 3,
			"total_rows" => $this->model->countAll(),
			"full_tag_open" => "<ul class='pagination'>",
			"full_tag_close" => "</ul>",
			"first_link" => FALSE,
			"last_link" => FALSE,
			"first_tag_open" => "<li>",
			"first_tag_close" => "</li>",
			"prev_link" => "Anterior",
			"prev_tag_open" => "<li class='prev'>",
			"prev_tag_close" => "</li>",
			"next_link" => "Próxima",
			"next_tag_open" => "<li class='next'>",
			"next_tag_close" => "</li>",
			"last_tag_open" => "<li>",
			"last_tag_close" => "</li>",
			"cur_tag_open" => "<li class='active'><a href='#'>",
			"cur_tag_close" => "</a></li>",
			"num_tag_open" => "<li>",
			"num_tag_close" => "</li>"
			);

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();

		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3):0;
		$data['orcamentos'] = $this->model->listar('ocod','asc', $config['per_page'],$offset);
		$data['total'] = $this->model->soma();

		$this->template->load('layout', 'orcamentos_lista.phtml', $data);
	}


	function inserir() {

		//$nomeCliente = $this->model->nomeCliente($ccod);
				
		$this->template->set('title', 'Inserir Orçamento para:  '/*. $nomeCliente*/);
		/* Carrega a biblioteca do CodeIgniter responsável pela validação dos formulários */
		$this->load->library('form_validation');
			
		/* Define as tags onde a mensagem de erro será exibida na página */
		$this->form_validation->set_error_delimiters('<span>', '</span>');
	
		/* Define as regras para validação */
		
		$this->form_validation->set_rules('nomeC', 'Cliente', 'required');
		$this->form_validation->set_rules('nomeP', 'Produto', 'required');
		$this->form_validation->set_rules('orcdate', 'Data', 'required');
		$this->form_validation->set_rules('situacao', 'Situação', 'required');
		$this->form_validation->set_rules('valor', 'Valor', 'required');
	
		/* Executa a validação e caso houver erro chama a função index do controlador */
		if ($this->form_validation->run() === FALSE) {

			$this->template->load('layout', 'orcamentos_inserir.phtml');
			
			/* Senão, caso sucesso: */
		} else {		
			/* Recebe os dados do formulário (visão) */
			
			$data['cliente'] = $this->input->post('nomeC');
			$data['produto'] = $this->input->post('nomeP');
			$data['orcdate'] = $this->input->post('orcdate');
			$data['situacao'] = 'teste';
			$data['valor'] = $this->input->post('valor');			
			$data['numero'] = $this->input->post('numero');	
			$data['autor'] = $this->input->post('autor');
			
			/* Chama a função inserir do modelo */
			if ($this->model->inserir($data)) {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-success'> Orçamento inserido com sucesso</div>");
				redirect('orcamentos');
			} else {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-danger'> Erro ao inserir Orçamento</div>");
			}
		}
	}
		
	function editar($ocod) {
			
		/* Aqui vamos definir o título da página de edição */
		$this->template->set('title', 'Editar Orçamentos');
		/* Busca os dados da pessoa que será editada */
		$data['dados_orcamentos'] = $this->model->editar($ocod);
	 
	 	/* Carrega a página de edição com os dados da pessoa */
		$this->template->load('layout', 'orcamentos_edit.phtml', $data);		
	}

	function atualizar() {
 
		/* Carrega a biblioteca do CodeIgniter responsável pela validação dos formulários */
		$this->load->library('form_validation');
	 
		/* Define as tags onde a mensagem de erro será exibida na página */
		$this->form_validation->set_error_delimiters('<span>', '</span>');
	 
		/* Aqui estou definindo as regras de validação do formulário, assim como 
		   na função inserir do controlador, porém estou mudando a forma de escrita */
		$this->form_validation->set_rules('clienteNome', 'Cliente', 'required');
		$this->form_validation->set_rules('produtoNome', 'Produto', 'required');
		$this->form_validation->set_rules('orcdate', 'Data', 'required');
		$this->form_validation->set_rules('situacao', 'Situação', 'required');
		$this->form_validation->set_rules('valor', 'Valor', 'required');
		$this->form_validation->set_rules('numero', 'Numero', 'required');
			
		/* Executa a validação e caso houver erro chama a função editar do controlador novamente */
		if ($this->form_validation->run() === FALSE) {
	            $this->editar($this->input->post('ocod'));
		} else 
			/* Senão obtém os dados do formulário */
			$data['ocod'] = $this->input->post('ocod');
			$data['cliente'] = $this->input->post('cliente');
			$data['produto'] = $this->input->post('produto');
			$data['orcdate'] = $this->input->post('orcdate');
			$data['situacao'] = $this->input->post('situacao');
			$data['valor'] = $this->input->post('valor');
			$data['numero'] = $this->input->post('numero');	
	 		
			/* Executa a função atualizar do modelo passando como parâmetro os dados obtidos do formulário */
			if ($this->model->atualizar($data)) {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-success'> Orçamento editado com sucesso</div>");
				redirect('orcamentos');
			} else {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-danger'> Erro ao editar Orçamento</div>");
			}
		}
	
	function deletar($ocod) {
	 					
		/* Executa a função deletar do modelo passando como parâmetro o id da pessoa */
		if ($this->model->deletar($ocod)) {
		
				$this->session->set_flashdata('mensagem', "<div class='alert alert-warning'> Orçamento deletado com sucesso</div>");
				redirect('orcamentos');
			} else {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-danger'> Erro ao deletar Orçamento</div>");
			}
	}

	function history($ccod) {

		$this->template->set('title', 'Lista de Orçamentos');

		/* Aqui vamos definir o título da página de edição */
		$data['orcamentos'] = $this->model->history($ccod);
	 
	 	/* Carrega a página de edição com os dados da pessoa */
		$this->template->load('layout', 'orcamentos_history.phtml', $data);
	}

    public function pesquisar1() {

		$this->template->set('title', 'Resultado');

		$data['pagination'] = "";

		$data['orcamentos'] = $this->model->search2();
		
		$this->template->load('layout', 'orcamentos_lista.phtml', $data);
	}


}

?>
