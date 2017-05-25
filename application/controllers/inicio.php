<?php
 
if (!defined('BASEPATH')) exit('No direct script access allowed');
 

class Inicio extends CI_Controller {
 
    function __construct() {
        parent::__construct();
        $this->load->model('graficosModel', 'model', TRUE);
    }
 	
    public function index() {
    	$this->template->set('title', 'Dashboard');
        $results = $this->model->get_chart_data();
        $data['chart_data'] = $results['chart_data'];
        $data['min_year'] = $results['min_year'];
        $data['max_year'] = $results['max_year'];
        $this->template->load('layout', 'select_charts.phtml', $data);
    }
 
}
 
/* End of file ChartController.php */
/* Location: ./application/controllers/ChartController.php */