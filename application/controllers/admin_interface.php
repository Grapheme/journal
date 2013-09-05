<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_interface extends MY_Controller{
	
	var $per_page = PER_PAGE_DEFAULT;
	var $offset = 0;
	
	function __construct(){
		
		parent::__construct();
		if(!$this->loginstatus):
			redirect('');
		endif;
		$this->load->helper('form');
	}
	
	/******************************************** cabinet *******************************************************/
	public function controlPanel(){
		
		$pagevar = array();
		$this->load->view("admin_interface/cabinet/control-panel",$pagevar);
	}
	
	public function profile(){
		
		$pagevar = array(
			'languages' => array(),
			'profile' => array(),
		);
		$this->load->view("admin_interface/cabinet/profile",$pagevar);
	}
	/********************************************* menu **********************************************************/

	/********************************************* pages *********************************************************/
	public function pagesList(){
		
		$this->load->model('pages');
		$pagevar = array(
			'pages' => $this->pages->getAll(),
		);
		$this->load->view("admin_interface/pages/list",$pagevar);
	}

	public function editPages(){
		
		if($this->input->get('id') === FALSE || is_numeric($this->input->get('id')) === FALSE):
			redirect(ADMIN_START_PAGE);
		endif;
		$this->load->model(array('pages','page_resources'));
		$pagevar = array(
			'content' => $this->pages->getWhere($this->input->get('id')),
			'images' => array(),
			'pageTitle' => '',
		);
		if($pagevar['content']):
			$pagevar['pageTitle'] = $pagevar['content']['title'];
		endif;
		if($this->input->get('mode') == 'text'):
			$this->load->view("admin_interface/pages/edit",$pagevar);
		elseif($this->input->get('mode') == 'image'):
			$pagevar['images'] = $this->page_resources->getWhere(NULL,array('page_url'=>$pagevar['content']['page_url']),TRUE);
			$this->load->view("admin_interface/pages/images",$pagevar);
		elseif($this->input->get('mode') == 'caption'):
			$pagevar['images'] = $this->page_resources->getWhere(NULL,array('page_url'=>$pagevar['content']['page_url']),TRUE);
			$this->load->view("admin_interface/pages/images-caption",$pagevar);
		else:
			redirect(ADMIN_START_PAGE);
		endif;
	}
	/******************************************** authors ********************************************************/
	public function authorsList(){
		
		$this->load->model('authors');
		$pagevar = array(
			'authors' => $this->authors->getAll(),
		);
		$this->load->view("admin_interface/authors/list",$pagevar);
	}
	
	public function insertAuthor(){
		
		$this->load->view("admin_interface/authors/add");
	}
	
	public function editAuthor(){
		
		$this->load->model('authors');
		$pagevar = array(
			'author' => $this->authors->getWhere($this->input->get('id'))
		
		);
		$this->load->view("admin_interface/authors/edit",$pagevar);
	}
	/******************************************** issues ********************************************************/
	public function issuesList(){
		
		$year = date('Y');
		if($this->input->get('year') !== FALSE && is_numeric($this->input->get('year'))):
			$year = $this->input->get('year');
		endif;
		$this->load->model('issues');
		$pagevar = array(
			'issues' => $this->issues->getWhere(NULL,array('year'=>$year),TRUE)
		);
		$this->load->view("admin_interface/issues/list",$pagevar);
	}
	
	public function insertIssue(){
		
		$this->load->view("admin_interface/issues/add");
	}
	
	public function editIssue(){
		
		$this->load->model('issues');
		$pagevar = array(
			'issue' => $this->issues->getWhere($this->input->get('id'))
		
		);
		$this->load->view("admin_interface/issues/edit",$pagevar);
	}
	/*************************************************************************************************************/
	
}