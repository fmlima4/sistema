<?php

class temple extends CI_Controller{
	 function __construct(){
	 	parent::__construct();
	 }
	 
	 function call_admin_template($data = null){
	 	// call de the admin template view
	 	
	 	$this->load->view('template/admin_template_v', $data);
	 }

	function call_login_template($data = null){
	 	// call de the admin template view
	 	
	 	$this->load->view('template/login_template_v', $data);
	 }

}