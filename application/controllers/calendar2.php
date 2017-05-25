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

	public function updateEvents(){
		$param['id'] = $this->input->post('id');
		$param['inicio'] = $this->input->post('inicio');
		$param['fim'] = $this->input->post('fim');
		$r =  $this->model->updateEvents($param);
		echo json_encode($r);
	}

	public function deleteEvents(){
		$id = $this->input->post('id');
		$r = $this->model->deleteEvents($id);
		echo json_encode($r);
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
			$data['importancia'] = $this->input->post('descricaoEvento');	
			
			
			/* Chama a função inserir do modelo */
			if ($this->model->inserir($data)) {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-success'> Lembrete salvo com sucesso</div>");
				redirect('clientes');
			} else {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-danger'> Erro ao salvar Lembrete </div>");
			}

		}
	}

	
}
