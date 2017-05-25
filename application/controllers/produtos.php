<?php

class Produtos extends CI_Controller {

	function __construct() {
		parent::__construct();
		/* Carrega o modelo */
		$this->load->model('produtosModel', 'model', TRUE);
	}

		
	function index()
	{
		$this->template->set('title', 'Lista de Produtos');
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

		$data['produtos'] = $this->model->listar('pcod','asc', $config['per_page'],$offset);
		$this->template->load('layout', 'produtos_lista.phtml', $data);
	}


	function inserir() {
		
		
		$this->template->set('title', 'Inserir Produto');
		/* Carrega a biblioteca do CodeIgniter responsável pela validação dos formulários */
		$this->load->library('form_validation');
	
		/* Define as tags onde a mensagem de erro será exibida na página */
		$this->form_validation->set_error_delimiters('<span>', '</span>');
	
		/* Define as regras para validação */
		$this->form_validation->set_rules('pnome', 'Nome', 'required|max_length[40]');
		$this->form_validation->set_rules('descricao', 'Descricao', 'required|max_length[100]');
	
		/* Executa a validação e caso houver erro chama a função index do controlador */
		if ($this->form_validation->run() === FALSE) {
			$this->template->load('layout', 'produtos_inserir.phtml');
			/* Senão, caso sucesso: */
		} else {
			/* Recebe os dados do formulário (visão) */
			$data['pnome'] = ucwords($this->input->post('pnome'));
			$data['descricao'] = ucwords($this->input->post('descricao'));
						
			/* Chama a função inserir do modelo */
			if ($this->model->inserir($data)) {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-success'> Produto inserido com sucesso</div>");
				redirect('produtos');
			} else {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-danger'> Erro ao inserir Produto</div>");
			}
		}
	}
	
	
	function editar($pcod)  {
			
		/* Aqui vamos definir o título da página de edição */
		$this->template->set('title', 'Editar Produto');
	 
		/* Busca os dados da pessoa que será editada */
		$data['dados_produto'] = $this->model->editar($pcod);
	 
	 	/* Carrega a página de edição com os dados da pessoa */
		$this->template->load('layout', 'produtos_edit.phtml', $data);

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
				'field' => 'pnome',
				'label' => 'Nome',
				'rules' => 'trim|required|max_length[40]'
			),
			array(
				'field' => 'descricao',
				'label' => 'Descricao',
				'rules' => 'trim|required|max_length[40]'
			),
		);

	
		$this->form_validation->set_rules($validations);
	
		/* Executa a validação e caso houver erro chama a função editar do controlador novamente */
		if ($this->form_validation->run() === FALSE) {
	            $this->editar($this->input->post('pcod'));
		} else 
			/* Senão obtém os dados do formulário */
			$data['pcod'] = $this->input->post('pcod');
			$data['pnome'] = ucwords($this->input->post('pnome'));
			$data['descricao'] = ucwords($this->input->post('descricao'));
			

	 
			/* Executa a função atualizar do modelo passando como parâmetro os dados obtidos do formulário */
			if ($this->model->atualizar($data)) {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-success'> Produto Editado com sucesso</div>");
				redirect('produtos');
			} else {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-danger'> Erro ao editar Produto</div>");
			}
		}
	
	function deletar($pcod) {
	 					
		/* Executa a função deletar do modelo passando como parâmetro o id da pessoa */
		if ($this->model->deletar($pcod)) {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-warning'> Produto deletado com sucesso</div>");
				redirect('produtos');
			} else {
				$this->session->set_flashdata('mensagem', "<div class='alert alert-danger'> Erro ao deletar Produto</div>");
			}
	}

    public function pesquisar() {

		$this->template->set('title', 'Resultado');
		
		$data['pagination'] = "";

		$this->load->library('PHPExcel');
		$arquivo = './planilhas/relatorio.xlsx';
		$planilha = $this->phpexcel;

		$planilha->setActiveSheetIndex(0)->setCellValue('A1','Codigo');
		$planilha->setActiveSheetIndex(0)->setCellValue('B1','Nome');
		$planilha->setActiveSheetIndex(0)->setCellValue('C1','Descrição');

		$data['produtos'] = $this->model->search();

		$contator = 1;

		foreach($data['produtos'] as $linha) {
			$contator++;
			$planilha->setActiveSheetIndex(0)->setCellValue('A'.$contator, $linha->pnome);
			$planilha->setActiveSheetIndex(0)->setCellValue('B'.$contator, $linha->descricao);
			$planilha->setActiveSheetIndex(0)->setCellValue('C'.$contator, $linha->pcod);
		}

		$planilha->getActiveSheet()->setTitle('planilha 1'.$contator);

		$objgravar = PHPExcel_IOFactory::createWriter($planilha, 'Excel2007');
		$objgravar->save($arquivo);
		
		$this->template->load('layout', 'produtos_lista.phtml', $data);

		//$this->session->set_flashdata('mensagem', "<div class='alert alert-warning'> exportação salva com sucesso</div>");
		//redirect('produtos');
	}

	function get_produto(){
	    if (isset($_GET['term'])){
	      $q = strtolower($_GET['term']);
	      $this->model->get_produto($q);
	    }
	}

	function  get_excel(){
		//$this->load->library('PHPExcel');
		$contator = 1;
		$arquivo = './planilhas/relatorio.xlsx';
		$planilha = $this->phpexcel;

		$planilha->setActiveSheetIndex(0)->setCellValue('A1','Codigo');
		$planilha->setActiveSheetIndex(0)->setCellValue('B1','Nome');
		$planilha->setActiveSheetIndex(0)->setCellValue('C1','Descrição');

		$data['produtos'] = $this->model->listar();
		//echo json_encode($data['produtos']);
		//die('eieeiie');
		

		foreach($data['produtos'] as $linha) {
			$contator++;
			$planilha->setActiveSheetIndex(0)->setCellValue('A'.$contator, $linha->pnome);
			$planilha->setActiveSheetIndex(0)->setCellValue('B'.$contator, $linha->descricao);
			$planilha->setActiveSheetIndex(0)->setCellValue('C'.$contator, $linha->pcod);
		}

		$planilha->getActiveSheet()->setTitle('planilha 1');

		$objgravar = PHPExcel_IOFactory::createWriter($planilha, 'Excel2007');
		$objgravar->save($arquivo);

		$this->session->set_flashdata('mensagem', "<div class='alert alert-warning'> exportação salva com sucesso</div>");
				redirect('produtos');

	}

}


?>
