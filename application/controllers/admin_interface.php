<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
		if(!$this->loginstatus || $this->account['group'] > ADMIN_GROUP_VALUE):
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
			'authors' => array(),
			'pages' => NULL
		);
		if($this->input->get('search') === FALSE || $this->input->get('search') == ''):
			$pagevar['authors'] = $this->authors->limit(PER_PAGE_DEFAULT,$this->uri->segment(4),'ru_name,en_name');
			$pagevar['pages'] = $this->pagination('admin-panel/authors',4,$this->authors->countAllResults(),PER_PAGE_DEFAULT);
		else:
			if($authors = $this->getAuthorsByIDs($this->input->get('search'))):
				$authorsIDs = $this->getDBRecordsIDs($authors);
				$pagevar['authors'] = $this->authors->getWhereIN(array('field'=>'id','where_in'=>$authorsIDs,'many_records'=>TRUE,'order_by'=>'ru_name,en_name'));
			endif;
		endif;
		$this->load->view("admin_interface/authors/list",$pagevar);
	}
	
	public function insertAuthor(){
		
		$this->load->model('institutions');
		$pagevar = array(
			'institutions' => $this->institutions->getAll()
		);
		$this->load->view("admin_interface/authors/add",$pagevar);
	}
	
	public function editAuthor(){
		
		$this->load->model(array('authors','institutions'));
		$pagevar = array(
			'author' => $this->authors->getWhere($this->input->get('id')),
			'institutions' => $this->institutions->getAll()
		);
		$this->load->view("admin_interface/authors/edit",$pagevar);
	}
	/******************************************* Institution ******************************************************/
	public function institutionsList(){
		
		$this->load->model('institutions');
		$pagevar = array(
			'institutions' => $this->institutions->getAll(),
		);
		$this->load->view("admin_interface/institutions/list",$pagevar);
	}
	
	public function insertInstitution(){
		
		$this->load->view("admin_interface/institutions/add");
	}
	
	public function editInstitution(){
		
		$this->load->model('institutions');
		$pagevar = array(
			'institution' => $this->institutions->getWhere($this->input->get('id'))
		
		);
		$this->load->view("admin_interface/institutions/edit",$pagevar);
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
	/******************************************** publications ********************************************************/
	public function publicationsList(){
		
		$this->load->model(array('publications','issues'));
		$issue = 0;
		if($issues = $this->issues->getAll('year DESC,month DESC,number DESC')):
			$issue = $issues[0]['id'];
		endif;
		if($this->input->get('issue') !== FALSE && is_numeric($this->input->get('issue'))):
			$issue = $this->input->get('issue');
		endif;
		if($this->input->get('issue') === FALSE || !is_numeric($this->input->get('issue'))):
			redirect(uri_string().'?issue='.$issue);
		endif;
		$pagevar = array(
			'publications' => $this->publications->getWhere(NULL,array('issue'=>$issue),TRUE),
			'issues' => $issues
		);
		$this->load->view("admin_interface/publications/list",$pagevar);
	}
	
	public function insertPublications(){
		
		$this->load->view("admin_interface/publications/add");
	}
	
	public function editPublications(){
		
		$this->load->model('publications');
		$pagevar = array(
			'publication' => $this->publications->getWhere($this->input->get('id')),
			'authors' => array()
		);
		$pagevar['authors'] = $this->getAuthorsByIDs($pagevar['publication']['authors']);
		$pagevar['publication']['keywords'] = $this->getProductKeyWords($pagevar['publication']['id']);
		$this->load->view("admin_interface/publications/edit",$pagevar);
	}
	
	public function resourcesPublications(){
		
		$this->load->model(array('publications','publications_resources'));
		$pagevar = array(
			'publication' => $this->publications->getWhere($this->input->get('id')),
			'resources' => array()
		);
		if($resources = $this->publications_resources->getWhere(NULL,array('issue'=>$this->input->get('issue'),'publication'=>$this->input->get('publication')),TRUE)):
			for($i=0;$i<count($resources);$i++):
				$pagevar['resources'][$i]['id'] = $resources[$i]['id'];
				$pagevar['resources'][$i]['publication'] = $resources[$i]['publication'];
				$pagevar['resources'][$i]['issue'] = $resources[$i]['issue'];
				$pagevar['resources'][$i]['number'] = $resources[$i]['number'];
				$pagevar['resources'][$i]['caption'] = $resources[$i]['caption'];
				$pagevar['resources'][$i]['resource'] = json_decode($resources[$i]['resource'],TRUE);
			endfor;
		endif;
		$this->load->helper('string');
		$this->load->view("admin_interface/publications/resources",$pagevar);
	}
	/********************************************* comments *********************************************************/
	public function commentsList(){
		
		$this->load->helper(array('date','text'));
		$this->load->model(array('publications_comments','issues','publications'));
		if($issues = $this->issues->getAll('year DESC,month DESC,number DESC')):
			$issueID = $issues[0]['id'];
		endif;
		if($this->input->get('issue') !== FALSE && is_numeric($this->input->get('issue'))):
			$issueID = $this->input->get('issue');
		endif;
		$pagevar = array(
			'comments' => $this->publications_comments->getLimitList(PER_PAGE_DEFAULT,$this->uri->segment(4),$issueID),
			'pages' => $this->pagination('admin-panel/comments',4,$this->publications_comments->countAllResults(array('issue'=>$issueID)),PER_PAGE_DEFAULT),
			'issues' => $issues,
			'publications' => $this->publications->getPublicationList($issueID),
		);
		$this->session->set_userdata('backpath',site_url(uri_string()));
		$this->load->view("admin_interface/comments/list",$pagevar);
	}

	public function editComments(){
		
		if($this->input->get('id') === FALSE || is_numeric($this->input->get('id')) === FALSE):
			redirect(ADMIN_START_PAGE);
		endif;
		$this->load->model('publications_comments');
		$pagevar = array(
			'content' => $this->publications_comments->getWhere($this->input->get('id')),
		);
		$this->load->view("admin_interface/comments/edit",$pagevar);
	}
	/*************************************************************************************************************/
}