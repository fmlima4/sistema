<?php

class Representantes extends CI_Controller {

	function __construct() {
		parent::__construct();
		/* Carrega o modelo */
		$this->load->model('representantesModel', 'model', TRUE);
	}

		
	function index()
	{
		$this->template->set('title', 'Lista de representantes');
		$config = array(
			"base_url" => base_url('representantes/p'),
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

		$data['representantes'] = $this->model->listar('rcod','asc', $config['per_page'],$offset);
		$this->template->load('layout', 'representantes_lista.phtml', $data);
	}

	function inserir() {
		
		
		$this->template->set('title', 'Inserir representantes');
		/* Carrega a biblioteca do CodeIgniter responsável pela validação dos formulários */
		$this->load->library('form_validation');
	
		/* Define as tags onde a mensagem de erro será exibida na página */
		$this->form_validation->set_error_delimiters('<span>', '</span>');
	
		/* Define as regras para validação */
		$this->form_validation->set_rules('rnome', 'Nome', 'required|max_length[40]');
		$this->form_validation->set_rules('email', 'email', 'required|max_length[100]');
		$this->form_validation->set_rules('fone', 'fone', 'required|max_length[100]');

	
		/* Executa a validação e caso houver erro chama a função index do controlador */
		if ($this->form_validation->run() === FALSE) {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-warning'> preencha todos os campos antes de salvar </div>");
				redirect('representantes');
			/* Senão, caso sucesso: */
		} else {
			/* Recebe os dados do formulário (visão) */
			$data['rnome'] = ucwords($this->input->post('rnome'));
			$data['email'] = $this->input->post('email');
			$data['fone'] = $this->input->post('fone');
						
			/* Chama a função inserir do modelo */
			if ($this->model->inserir($data)) {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-success'> Representante inserido com sucesso</div>");
				redirect('representantes');
			} else {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-danger'> Erro ao inserir representante </div>");
			}
		}
	}
	
	
	function editar($rcod)  {
			
		/* Aqui vamos definir o título da página de edição */
		$this->template->set('title', 'Editar Representante');
	 
		/* Busca os dados da pessoa que será editada */
		$data['dados_representante'] = $this->model->editar($rcod);
	 
	 	/* Carrega a página de edição com os dados da pessoa */
		$this->template->load('layout', 'representantes_edit.phtml', $data);

	}

	function atualizar() {
 
		/* Carrega a biblioteca do CodeIgniter responsável pela validação dos formulários */
		$this->load->library('form_validation');
	 
		/* Define as tags onde a mensagem de erro será exibida na página */
		$this->form_validation->set_error_delimiters('<span>', '</span>');
	 
		/* Aqui estou definindo as regras de validação do formulário, assim como 
		   na função inserir do controlador, porém estou mudando a forma de escrita */
		$validations = array(
			array(
				'field' => 'rnome',
				'label' => 'Nome',
				'rules' => 'trim|required|max_length[40]'
			),
			array(
				'field' => 'email',
				'label' => 'email',
				'rules' => 'trim|required|max_length[40]'
			),
			array(
				'field' => 'fone',
				'label' => 'fone',
				'rules' => 'trim|required|max_length[40]'
			),
		);

	
		$this->form_validation->set_rules($validations);
	
		/* Executa a validação e caso houver erro chama a função editar do controlador novamente */
		if ($this->form_validation->run() === FALSE) {
	            $this->editar($this->input->post('rcod'));
		} else 
			/* Senão obtém os dados do formulário */
			$data['rcod'] = $this->input->post('rcod');
			$data['rnome'] = ucwords($this->input->post('rnome'));
			$data['email'] = $this->input->post('email');
			$data['fone'] = $this->input->post('fone');
			
	 
			/* Executa a função atualizar do modelo passando como parâmetro os dados obtidos do formulário */
			if ($this->model->atualizar($data)) {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-success'> Representantes Editado com sucesso</div>");
				redirect('representantes');
			} else {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-danger'> Erro ao editar Representante</div>");
			}
		}

	function deletar($rcod) {
	 					
		/* Executa a função deletar do modelo passando como parâmetro o id da pessoa */
		$confirmacao = $this->model->deletar($rcod);
		if ($confirmacao == 1) {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-warning'> Representante deletado com sucesso</div>");
				redirect('representantes');
			} else {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-danger'> Erro ao deletar Representante </div>");
				redirect('representantes');
			}
	}
	
    public function pesquisar() {

		$this->template->set('title', 'Resultado');
		
		$data['pagination'] = "";

		$data['representantes'] = $this->model->search();
		
		$this->template->load('layout', 'representantes_lista.phtml', $data);
	}

	function get_representante(){
	    if (isset($_GET['term'])){
	      $q = strtolower($_GET['term']);
	      $this->model->get_representante($q);
	    }
	}

}


?>
