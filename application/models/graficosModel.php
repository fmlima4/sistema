<?php
 
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Description of ChartModel
 *
 * @author http://roytuts.com
 */
class graficosModel extends CI_Model {
 
    private $performance = 'performance';
 
    function __construct() {
        
    }
 
    function get_chart_data() {
        $query = $this->db->get($this->performance);
        $results['chart_data'] = $query->result();
        $this->db->select_min('performance_year');
        $this->db->limit(1);
        $query = $this->db->get($this->performance);
        $results['min_year'] = $query->row()->performance_year;
        $this->db->select_max('performance_year');
        $this->db->limit(1);
        $query = $this->db->get($this->performance);
        $results['max_year'] = $query->row()->performance_year;
        return $results;
    }
 
}
 
/* End of file chartmodel.php */
/* Location: ./application/models/chartmodel.php */