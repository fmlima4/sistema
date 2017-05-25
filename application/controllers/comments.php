<?php

class Comments extends CI_Controller {

	function __construct() {
		parent::__construct();
		/* Carrega o modelo */
		$this->load->model('comentModel', 'model', TRUE);
	}

	function index() {

		$this->template->set('title', 'Comentarios');/* Aqui vamos definir o título da página de edição */

		$config = array(
			"base_url" => base_url('comments/p'),
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

		$data['comentarios_cliente'] = $this->model->listar('comcod','asc', $config['per_page'],$offset);

	 	/* Carrega a página de edição com os dados da pessoa */
		$this->template->load('layout', 'clientes_history2.phtml', $data);
	}
	
	function inserir_coment(){

		$this->template->set('title', 'Novo Comentario');

		/* Carrega a biblioteca do CodeIgniter responsável pela validação dos formulários */
		$this->load->library('form_validation');
	
		/* Define as tags onde a mensagem de erro será exibida na página */
		$this->form_validation->set_error_delimiters('<span>', '</span>');
	
		/* Define as regras para validação */
		$this->form_validation->set_rules('dat', 'Data', 'required');
		$this->form_validation->set_rules('nomeC', 'Cliente', 'required');
		$this->form_validation->set_rules('texto', 'Texto', 'required');
		$this->form_validation->set_rules('autor', 'Autor', 'required');
		
	
		/* Executa a validação e caso houver erro chama a função index do controlador */
		if ($this->form_validation->run() === FALSE) {
			$this->template->load('layout', 'inserir_coment.phtml');
		/* Senão, caso sucesso: */
		} else {

			/* Recebe os dados do formulário (visão) */
			$data['dat'] = $this->input->post('dat');
			$data['cliente'] = $this->input->post('nomeC'); 
			$data['texto'] = $this->input->post('texto');
			$data['autor'] = $this->input->post('autor');
			
			
			/* Chama a função inserir do modelo */
			if ($this->model->inserir_coment($data)) {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-success'> Comentario inserido com sucesso</div>");
				redirect('comments');
			} else {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-danger'> Erro ao inserir comentario</div>");
			}
		}
	}
	
	function edit_coment($comcod)  {
			
		/* Aqui vamos definir o título da página de edição */
		$this->template->set('title', 'Editar Comentario');
	 
		/* Busca os dados da pessoa que será editada */
		$data['dados_comentario'] = $this->model->edit_coment($comcod);
	 
	 	/* Carrega a página de edição com os dados da pessoa */
		$this->template->load('layout', 'clientes_coment_edit.phtml', $data);
	}

	function atualizar_coment() {
 
		/* Carrega a biblioteca do CodeIgniter responsável pela validação dos formulários */
		$this->load->library('form_validation');
	 
		/* Define as tags onde a mensagem de erro será exibida na página */
		$this->form_validation->set_error_delimiters('<span>', '</span>');
	 
		/* Aqui estou definindo as regras de validação do formulário, assim como 
		   na função inserir do controlador, porém estou mudando a forma de escrita */
		$this->form_validation->set_rules('dat', 'Data', 'required|max_length[10]');
		$this->form_validation->set_rules('cliente', 'Cliente', 'required|max_length[40]');
		$this->form_validation->set_rules('texto', 'Texto', 'required|max_length[40]');
		$this->form_validation->set_rules('autor', 'Autor', 'required|max_length[40]');
		$this->form_validation->set_rules($validations);
	
		/* Executa a validação e caso houver erro chama a função editar do controlador novamente */
		if ($this->form_validation->run() === FALSE) {
	            $this->edit_coment($this->input->post('comcod'));
		} else 
			/* Senão obtém os dados do formulário */
			$data['comcod'] = $this->input->post('comcod');
			$data['dat'] = $this->input->post('dat');
			$data['cliente'] = $this->input->post('cliente');
			$data['texto'] = $this->input->post('texto');
			$data['autor'] = $this->input->post('autor');
	 
			/* Executa a função atualizar do modelo passando como parâmetro os dados obtidos do formulário */
			if ($this->model->atualizar_coment($data)) {
				redirect('clientes');
			} else {
				log_message('error', 'Erro ao atualizar comentario.');
			}
		}
	
	function deletar_coment($comcod) {
	 
		/* Executa a função deletar do modelo passando como parâmetro o id da pessoa */
		if ($this->model->delet_coment($comcod)) {
			redirect('clientes');
		} else {
			log_message('error', 'Erro ao deletar comentario.');
		}
	}

	public function pesquisar1() {

		$this->template->set('title', 'Resultado');

		$data['pagination'] = "";

		$data['comentarios_cliente'] = $this->model->search1();
		
		$this->template->load('layout', 'clientes_history2.phtml', $data);
	}

	function get_cliente(){
	    if (isset($_GET['term'])){
	      $q = strtolower($_GET['term']);
	      $this->model->get_cliente($q);
	    }
	}

}

?>