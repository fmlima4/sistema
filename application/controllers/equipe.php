<?php

class Equipe extends CI_Controller {

	function __construct() {
		parent::__construct();
		/* Carrega o modelo */
		$this->load->model('equipeModel', 'model', TRUE);
	}
		
	function index()
	{
		$this->template->set('title', 'Usuarios');

		$config = array(
			"base_url" => base_url('produtos/p'),
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

		$data['usuarios'] = $this->model->listar('id', 'asc', $config['per_page'],$offset );
		$this->template->load('layout', 'equipe_lista.phtml', $data);
	}

	function inserir() {
		
		
		$this->template->set('title', 'Inserir Usuarios');
		/* Carrega a biblioteca do CodeIgniter responsável pela validação dos formulários */
		$this->load->library('form_validation');
	
		/* Define as tags onde a mensagem de erro será exibida na página */
		$this->form_validation->set_error_delimiters('<span>', '</span>');
	
		/* Define as regras para validação */
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[30]');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[10]');
	
		/* Executa a validação e caso houver erro chama a função index do controlador */
		if ($this->form_validation->run() === FALSE) {
			$this->template->load('layout', 'equipe_inserir.phtml');
			/* Senão, caso sucesso: */
		} else {
			/* Recebe os dados do formulário (visão) */
			$data['username'] = $this->input->post('username');
			$data['password'] = $this->input->post('password');
			$data['cargo'] = $this->input->post('cargo');			
						
			/* Chama a função inserir do modelo */
			if ($this->model->inserir($data)) {
				redirect('equipe');
			} else {
				log_message('error', 'Erro ao inserir a pessoa.');
			}
		}
	}
	
	function editar($id)  {
			
		/* Aqui vamos definir o título da página de edição */
		$this->template->set('title', 'Editar Usuario');
	 
		/* Busca os dados da pessoa que será editada */
		$data['dados_usuario'] = $this->model->editar($id);
	 
	 	/* Carrega a página de edição com os dados da pessoa */
		$this->template->load('layout', 'equipe_edit.phtml', $data);

	}


	function atualizar() {
 
		/* Carrega a biblioteca do CodeIgniter responsável pela validação dos formulários */
		$this->load->library('form_validation');
	 
		/* Define as tags onde a mensagem de erro será exibida na página */
		$this->form_validation->set_error_delimiters('<span>', '</span>');
	 
		/* Aqui estou definindo as regras de validação do formulário, assim como 
		   na função inserir do controlador, porém estou mudando a forma de escrita */
		$this->form_validation->set_rules('username', 'Usuario', 'required');
		$this->form_validation->set_rules('cargo', 'Cargo', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		/* Executa a validação e caso houver erro chama a função editar do controlador novamente */
		if ($this->form_validation->run() === FALSE) {
	            $this->editar($this->input->post('id'));
		} else 
			/* Senão obtém os dados do formulário */
			$data['id'] = $this->input->post('id');
			$data['username'] = $this->input->post('username');
			$data['cargo'] = $this->input->post('cargo');
	 		$data['password'] = $this->input->post('password');
			
			/* Executa a função atualizar do modelo passando como parâmetro os dados obtidos do formulário */
			if ($this->model->atualizar($data)) {
				redirect('equipe');
			} else {
				log_message('error', 'Erro ao atualizar a pessoa.');
			}
		}
	
	function deletar($id) {
	 
		/* Executa a função deletar do modelo passando como parâmetro o id da pessoa */
		if ($this->model->deletar($id)) {
			redirect('equipe');
		} else {
			log_message('error', 'Erro ao deletar a pessoa.');
		}
	}

	 public function pesquisar() {

		$this->template->set('title', 'Resultado');

		$data['pagination'] = "";

		$data['usuarios'] = $this->model->search();
		
		$this->template->load('layout', 'equipe_lista.phtml', $data);
	}

}

?>
