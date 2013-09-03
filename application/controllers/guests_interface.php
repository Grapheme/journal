<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Guests_interface extends MY_Controller{
	
	var $offset = 0;
	
	function __construct(){

		parent::__construct();
		$this->load->library('meta_titles');
	}
	
	public function pages(){
		
		$this->load->model(array('pages','page_resources'));
		$pagevar = array(
			'page_content' => $this->pages->getWhere(NULL,array('page_url'=>uri_string())),
			'images' => $this->page_resources->getWhere(NULL,array('page_url'=>uri_string()),TRUE),
		);
		if(empty($pagevar['page_content'])):
			show_404();
		endif;
		$pagevar = $this->getMenu($pagevar);
		$this->load->view("guests_interface/pages/template",$pagevar);
	}
	
	public function index(){
		
		$this->load->model(array('pages','page_resources'));
		$pagevar = array(
			'page_content' => $this->pages->getWhere(NULL,array('page_url'=>'home')),
			'images' => $this->page_resources->getWhere(NULL,array('page_url'=>'home'),TRUE),
		);
		$this->load->view("guests_interface/pages/index",$pagevar);
	}
	
	public function issues(){
		
		$this->load->model(array('pages','page_resources'));
		$pagevar = array(
			'page_content' => $this->pages->getWhere(NULL,array('page_url'=>'home')),
			'images' => $this->page_resources->getWhere(NULL,array('page_url'=>'home'),TRUE),
		);
		$this->load->view("guests_interface/pages/issues",$pagevar);
	}
	
	
	
	/********************************************************************************************************************/
	
	
}