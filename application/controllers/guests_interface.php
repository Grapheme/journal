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
			$issue_link = site_url('issue/'.$issue['year'].'/'.$issue['number'].'/'.$issue['id']);
			$issue_number = $issue['number'].'/'.substr($issue['year'],2,2);
		endif;
		$this->pages('home',array('issue_number'=>$issue_number,'issue_link'=>$issue_link));
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
		for($i=0;$i<count($pagevar['publications']);$i++):
			$pagevar['publications'][$i]['authors'] = $this->getAuthorsByIDs($pagevar['publications'][$i]['authors']);
		endfor;
		$this->load->helper(array('date','text'));
		$this->load->view("guests_interface/pages/issue",$pagevar);
	}
	
	public function publication(){
		
		$this->load->model(array('issues','publications','publications_resources'));
		$pagevar = array(
			'page_content' => $this->publications->getWhere($this->uri->segment(6)),
			'issue' => $this->issues->getWhere($this->uri->segment(4)),
			'publication_resources' => array(),
			'keywords' => array(),
			'authors' => array(),
		);
		if(empty($pagevar)):
			show_404();
		endif;
		if($keywords = $this->getProductKeyWords($pagevar['page_content']['id'])):
			$pagevar['keywords'] = explode(',',$keywords);
		endif;
		if($resources = $this->publications_resources->getWhere(NULL,array('publication'=>$this->uri->segment(6),'issue'=>$this->uri->segment(4)),TRUE)):
			for($i=0;$i<count($resources);$i++):
				$pagevar['publication_resources'][$i]['id'] = $resources[$i]['id'];
				$pagevar['publication_resources'][$i]['publication'] = $resources[$i]['publication'];
				$pagevar['publication_resources'][$i]['issue'] = $resources[$i]['issue'];
				$pagevar['publication_resources'][$i]['resource'] = json_decode($resources[$i]['resource'],TRUE);
			endfor;
		endif;
		$pagevar['authors'] = $this->getAuthorsByIDs($pagevar['page_content']['authors']);
		$this->load->helper(array('date','text'));
		$this->load->view("guests_interface/pages/publication",$pagevar);
	}
	
	public function getFileResource(){
		
		$this->load->model('publications_resources');
		if($resource = $this->publications_resources->getWhere($this->input->get('resourse'))):
			if(!is_null($resource['resource']) && !empty($resource['resource'])):
				if($fileData = json_decode($resource['resource'],TRUE)):
					header('Pragma: public');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($fileData['full_path'])).' GMT');
					header('Cache-Control: private',false);
					header('Content-Type: '.$fileData['file_type']);
					header('Content-Disposition: attachment; filename="'.basename($fileData['full_path']).'"');
					header('Content-Transfer-Encoding: binary');
					header('Content-Length: '.filesize($fileData['full_path']));
					header('Connection: close');
					readfile($fileData['full_path']);
					exit();
				endif;
			endif;
		endif;
		show_404();
	}
	
	public function getFilePublication(){
		
		$this->load->model('publications');
		if($publication = $this->publications->getWhere($this->input->get('resourse'))):
			if(!is_null($publication[$this->uri->language_string.'_document']) && !empty($publication[$this->uri->language_string.'_document'])):
				if($filePath = getcwd().'/download/'.$publication[$this->uri->language_string.'_document']):
					if(file_exists($filePath)):
						header('Pragma: public');
						header('Expires: 0');
						header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
						header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($filePath)).' GMT');
						header('Cache-Control: private',false);
						header('Content-Type: '.$filePath);
						header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
						header('Content-Transfer-Encoding: binary');
						header('Content-Length: '.filesize($filePath));
						header('Connection: close');
						readfile($filePath);
						exit();
					endif;
				endif;
			endif;
		endif;
		show_404();
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
		
		$this->load->model(array('authors','institutions'));
		$pagevar = array(
			'page_content' => $this->authors->getWhere($this->uri->segment(3)),
		);
		if(empty($pagevar['page_content'])):
			show_404();
		endif;
		$pagevar['page_content']['institution'] = $this->institutions->getWhere($pagevar['page_content']['institution']);
		$this->load->view("guests_interface/pages/author",$pagevar);
	}
	
	public function keywords(){
		
		$this->load->model(array('pages','page_resources','keywords'));
		$pagevar = array(
			'page_content' => $this->pages->getWhere(NULL,array('page_url'=>uri_string())),
			'images' => $this->page_resources->getWhere(NULL,array('page_url'=>uri_string()),TRUE),
			'keywords' => array()
		);
		$char = 'А';
		if($this->uri->language_string == ENGLAN):
			$char = 'A';
		endif;
		if($keywords = $this->keywords->getKeywordsByChar($char,$this->uri->language_string)):
			$this->load->helper('text');
			$pagevar['keywords'] = $this->load->view('html/keywords-list',array('keywords'=>$keywords),TRUE);
		else:
			$pagevar['keywords'] =lang('not_found_keyword');
		endif;
		$this->load->view("guests_interface/pages/keywords",$pagevar);
	}
	
	public function search(){
		
		$this->load->model(array('pages','page_resources'));
		$pagevar = array(
			'page_content' => $this->pages->getWhere(NULL,array('page_url'=>uri_string())),
			'images' => $this->page_resources->getWhere(NULL,array('page_url'=>uri_string()),TRUE),
			'publications' => array()
		);
		$searchParameters = array(
			'text' => $this->input->get('text'),
			'year' => $this->input->get('year'),
			'number' => $this->input->get('number'),
			'word' => $this->input->get('word'),
		);
		$pagevar['publications'] = $this->searchIssues($searchParameters);
		for($i=0;$i<count($pagevar['publications']);$i++):
			$pagevar['publications'][$i]['authors'] = $this->getAuthorsByIDs($pagevar['publications'][$i]['authors']);
		endfor;
		$this->load->helper(array('text','date'));
		$this->load->view("guests_interface/pages/search",$pagevar);
	}

	private function searchIssues($parameters){
		
		$this->load->model(array('keywords','publications'));
		if(!empty($parameters['word'])):
			if($word = $this->keywords->search('word_hash',$parameters['word'])):
				return $this->publications->getPublicationByKeyWord($word);
			endif;
		elseif(empty($parameters['year']) && empty($parameters['number']) && !empty($parameters['text'])):
			return $this->publications->getPublicationByString($parameters['text']);
		elseif((!empty($parameters['year']) || !empty($parameters['number'])) && !empty($parameters['text'])):
			return $this->publications->getPublicationByIssue($parameters);
		endif;
		return NULL;
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