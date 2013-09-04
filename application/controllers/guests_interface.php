<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Guests_interface extends MY_Controller{
	
	var $offset = 0;
	
	function __construct(){

		parent::__construct();
		if($this->uri->language_string === FALSE):
			$this->config->set_item('base_url',baseURL($this->baseLanguageURL.'/'));
			redirect();
		else:
			$this->config->set_item('base_url',baseURL($this->uri->language_string.'/'));
		endif;
		$this->load->helper('language');
		$this->lang->load('localization/interface',$this->languages[$this->uri->language_string]);
	}
	
	public function pages($page_url = NULL){
		
		if(is_null($page_url)):
			$page_url = uri_string();
		endif;
		
		$this->load->model(array('pages','page_resources'));
		$pagevar = array(
			'page_content' => $this->pages->getWhere(NULL,array('page_url'=>$page_url)),
			'images' => $this->page_resources->getWhere(NULL,array('page_url'=>$page_url),TRUE),
		);
		if(empty($pagevar['page_content'])):
			show_404();
		endif;
		$this->load->view("guests_interface/pages/template",$pagevar);
	}
	
	public function index(){
		
		$this->pages('home');
	}
	
	public function issues(){
		
		$this->load->model(array('pages','page_resources'));
		$pagevar = array(
			'page_content' => $this->pages->getWhere(NULL,array('page_url'=>uri_string())),
			'images' => $this->page_resources->getWhere(NULL,array('page_url'=>uri_string()),TRUE),
			'issues' => array()
		);
		$this->load->view("guests_interface/pages/issues",$pagevar);
	}
	
	public function authors(){
		
		$this->load->model(array('pages','page_resources','authors'));
		$pagevar = array(
			'page_content' => $this->pages->getWhere(NULL,array('page_url'=>uri_string())),
			'images' => $this->page_resources->getWhere(NULL,array('page_url'=>uri_string()),TRUE),
			'authors' => NULL
		);
		$char = 'А';
		if($this->uri->language_string == ENGLAN):
			$char = 'A';
		endif;
		if($authors = $this->authors->getAuthorsByChar($char,$this->uri->language_string)):
			$this->load->helper('text');
			$pagevar['authors'] = $this->load->view('html/authors-list',array('authors'=>$authors,'langName'=>$this->uri->language_string),TRUE);
		else:
			$pagevar['authors'] =lang('not_found_authors');
		endif;
		$this->load->view("guests_interface/pages/authors",$pagevar);
	}
	
	public function author(){
		
		$this->load->model('authors');
		$pagevar = array(
			'page_content' => $this->authors->getWhere($this->uri->segment(3)),
		);
		if(empty($pagevar['page_content'])):
			show_404();
		endif;
		$this->load->view("guests_interface/pages/author",$pagevar);
	}
	
	
	
	
	public function keywords(){
		
		$this->load->model(array('pages','page_resources'));
		$pagevar = array(
			'page_content' => $this->pages->getWhere(NULL,array('page_url'=>uri_string())),
			'images' => $this->page_resources->getWhere(NULL,array('page_url'=>uri_string()),TRUE),
			'authors' => array()
		);
		$this->load->view("guests_interface/pages/keywords",$pagevar);
	}
	
	public function search(){
		
		$this->load->model(array('pages','page_resources'));
		$pagevar = array(
			'page_content' => $this->pages->getWhere(NULL,array('page_url'=>uri_string())),
			'images' => $this->page_resources->getWhere(NULL,array('page_url'=>uri_string()),TRUE),
			'issues' => array()
		);
		$this->load->view("guests_interface/pages/search",$pagevar);
	}

	/********************************************************************************************************************/
	
}