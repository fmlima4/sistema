<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar2 extends CI_controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('calendar2Model', 'model', TRUE);
	} 

	public function index(){
		$this->template->set('title', 'Agenda');
		$this->template->load('layout', 'calendar_v.php');
		//$this->load->view('calendar_v.php');
	}

	public function getEvents(){
		$data = $this->model->get_events();
		echo json_encode($data);
	}

	public function get_late_events(){
		$this->template->set('title', 'Tarefas Atrasadas');

		$config = array(
			"base_url" => base_url('lateEvents/p'),
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


		$data['tarefas'] = $this->model->get_late_events('idevento','asc', $config['per_page'],$offset);

		if($_SESSION['usuario_logado']['cargo']=='admin'){
			$this->template->load('layout', 'lateEvents_admin.php', $data);
		} else{
			$this->template->load('layout', 'lateEvents.php', $data);
		}
	}
	

	public function updateEvents(){
		$param['id'] = $this->input->post('id');
		$param['inicio'] = $this->input->post('inicio');
		$param['fim'] = $this->input->post('fim');
		$r =  $this->model->updateEvents($param);
		echo json_encode($r);
	}

	public function updateEvents2(){
		$this->load->library('form_validation');
	 
		/* Define as tags onde a mensagem de erro será exibida na página */
		$this->form_validation->set_error_delimiters('<span>', '</span>');
	 
		/* Aqui estou definindo as regras de validação do formulário, assim como 
		   na função inserir do controlador, porém estou mudando a forma de escrita */
		$this->form_validation->set_rules('titulo', 'Nome', 'required|max_length[40]');
		$this->form_validation->set_rules('responsavel', 'Autor', 'trim|required|max_length[100]');
		//$this->form_validation->set_rules('data', 'Data', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('importanciaEdit', 'importancia', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('descricao', 'Descricao', 'trim|required|max_length[60]');
	
		/* Executa a validação e caso houver erro chama a função editar do controlador novamente */
		if ($this->form_validation->run() === FALSE) {
	            	$this->session->set_flashdata('mensagem', "<div class='alert alert-danger'> preencha todos os campos antes de salvar </div>");
				redirect('clientes');
		} else
			/* Senão obtém os dados do formulário */
			$data['idevento'] = $this->input->post('ecod');
			$data['nomeEvento'] = $this->input->post('codigoCliente');
			$data['inicio'] = $this->input->post('data');
			$data['fim'] = date('Y-m-d', strtotime($this->input->post('data'). ' + 1 day'));
			$data['user'] = $this->input->post('responsavel');	
			$data['importancia'] = $this->input->post('importanciaEdit');	
			$data['descricaoEvento'] = $this->input->post('descricao');
	 	
			/* Executa a função atualizar do modelo passando como parâmetro os dados obtidos do formulário */
			if ($this->model->updateEvents2($data)) {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-success'> Cliente editado com sucesso</div>");
				redirect('calendar2');
			} else {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-danger'> Erro ao editar cliente</div>");
			}
		}
	

	public function deleteEvents(){
		$id = $this->input->post('id');
		$r = $this->model->deleteEvents($id);
		echo json_encode($r);
		redirect('calendar2');
	}

	public function new_event(){
		
		$this->template->set('title', 'Nova tarefa');

		$this->load->library('form_validation');
	
		/* Define as tags onde a mensagem de erro será exibida na página */
		$this->form_validation->set_error_delimiters('<span>', '</span>');
	
		/* Define as regras para validação */
		$this->form_validation->set_rules('nomeEvento', 'Nome', 'required|max_length[40]');
		$this->form_validation->set_rules('inicio', 'Data de inicio', 'trim|required|max_length[60]');
		$this->form_validation->set_rules('importancia', 'Prioridade', 'trim|required|max_length[60]');
		$this->form_validation->set_rules('descricaoEvento', 'descricaoEvento', 'trim|required|max_length[150]');
		
		/* Executa a validação e caso houver erro chama a função index do controlador */
		if ($this->form_validation->run() === FALSE) {
			
			$this->session->set_flashdata('mensagem', "<div class='alert alert-warning'> preencha todos os campos antes de salvar </div>");
				redirect('clientes');
			/* Senão, caso sucesso: */
		} else {

			/* Recebe os dados do formulário (visão) */
			$data['nomeEvento'] = $this->input->post('nomeEvento');
			$data['inicio'] = $this->input->post('inicio');
			$data['fim'] = date('Y-m-d', strtotime($this->input->post('inicio'). ' + 1 day'));
			$data['user'] = $this->input->post('user');	
			$data['importancia'] = $this->input->post('importancia');	
			$data['descricaoEvento'] = $this->input->post('descricaoEvento');	
			
			
			/* Chama a função inserir do modelo */
			if ($this->model->inserir($data)) {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-success'> Lembrete salvo com sucesso</div>");
				redirect('clientes');
			} else {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-danger'> Erro ao salvar Lembrete </div>");
				redirect('clientes');
			}

		}
	}

	function deletar($idevento) {
	 					
		/* Executa a função deletar do modelo passando como parâmetro o id da pessoa */
		$confirmacao = $this->model->deleteEvents($idevento);
		if ($confirmacao == 1) {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-warning'> Cliente deletado com sucesso</div>");
			redirect('clientes');
			} else {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-danger'> Erro ao deletar cliente</div>");
					redirect('clientes');
			}
	}

	public function pesquisar() {

		$this->template->set('title', 'Resultado');

		$data['pagination'] = "";

		$data['tarefas'] = $this->model->search();
		
		$this->template->load('layout', 'lateEvents_admin.php', $data);
	}

	
}
