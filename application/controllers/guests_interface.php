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
	
	public function pages($page_url = NULL,$params = NULL){
		
		if(is_null($page_url)):
			$page_url = uri_string();
		endif;
		$this->load->model(array('pages','page_resources'));
		$pagevar = array(
			'page_content' => $this->pages->getWhere(NULL,array('page_url'=>$page_url)),
			'images' => $this->page_resources->getWhere(NULL,array('page_url'=>$page_url),TRUE),
		);
		if(!is_null($params)):
			foreach($params as $key => $value):
				$pagevar[$key] = $value;
			endforeach;
		endif;
		if(empty($pagevar['page_content'])):
			show_404();
		endif;
		$this->load->view("guests_interface/pages/template",$pagevar);
	}
	
	public function index(){
		
		$this->load->model('issues');
		$issue_number = FALSE;
		if($issue = $this->issues->getWhere()):
			$issue_number = $issue['number'].'/'.substr($issue['year'],2,2);
		endif;
		$this->pages('home',array('issue_number'=>$issue_number));
	}
	
	public function issues(){
		
		$year = date('Y');
		if($this->input->get('year') !== FALSE && is_numeric($this->input->get('year'))):
			$year = $this->input->get('year');
		endif;
		$this->load->model(array('pages','page_resources','issues'));
		$pagevar = array(
			'page_content' => $this->pages->getWhere(NULL,array('page_url'=>uri_string())),
			'images' => $this->page_resources->getWhere(NULL,array('page_url'=>uri_string()),TRUE),
			'issues' => $this->issues->getWhere(NULL,array('year'=>$year),TRUE)
		);
		if(!empty($pagevar['issues'])):
			$pagevar['issues'] = $this->getCountPublication($pagevar['issues']);
			$pagevar['issues'] = array_reverse($pagevar['issues']);
		endif;
		$this->load->view("guests_interface/pages/issues",$pagevar);
	}
	
	public function issue(){
		
		$this->load->model(array('issues','publications'));
		$pagevar = array(
			'page_content' => $this->issues->getWhere($this->uri->segment(4)),
			'publications' => $this->publications->getWhere(NULL,array('issue'=>$this->uri->segment(4)),TRUE)
		);
		
//		print_r($pagevar['publications']);exit;
		
		/*if(!empty($pagevar['page_content'])):
			$pagevar['page_content'] = $this->getCountPublication($pagevar['issues']);
			$pagevar['page_content'] = array_reverse($pagevar['issues']);
		endif;*/
		$this->load->helper(array('date','text'));
		$this->load->view("guests_interface/pages/issue",$pagevar);
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
	
	private function getCountPublication($issues){
		
		if($issuesIDs = $this->getDBRecordsIDs($issues)):
			$this->load->model('publications');
			$publications = $this->publications->countPublicationOnIssues($issuesIDs);
			for($i=0;$i<count($issues);$i++):
				$issues[$i]['publication'] = 0;
				for($p=0;$p<count($publications);$p++):
					if($issues[$i]['id'] == $publications[$p]['issue']):
						$issues[$i]['publication'] = $publications[$p]['publications'];
					endif;
				endfor;
			endfor;
		endif;
		return $issues;
	}
}