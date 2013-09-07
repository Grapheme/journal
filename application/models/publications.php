<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Publications extends MY_Model{

	protected $table = "publications";
	protected $primary_key = "id";
	protected $fields = array("*");
	protected $order_by = "id";

	function __construct(){
		parent::__construct();
	}
	
	function countPublicationOnIssues($issuesIDs){
		$this->db->select('COUNT(*) AS publications, issue')->from($this->table)->where_in('issue',$issuesIDs)->group_by('issue');
		$query = $this->db->get();
		if($data = $query->result_array()):
			return $data;
		endif;
		return NULL;
	}
	
	function getPublicationByKeyWord($wordID){
		
		$this->db->select('issues.id AS issue,issues.year,issues.month,issues.number,issues.ru_title AS issue_ru_title,issues.en_title AS issue_en_title,publications.*');
		$this->db->from('publications');
		$this->db->join('issues','issues.id = publications.issue');
		$this->db->join('matching','publications.id = matching.publication');
		$this->db->where('matching.word',$wordID);
		$query = $this->db->get();
		if($data = $query->result_array()):
			return $data;
		endif;
		return NULL;
	}
	
	function getPublicationByString($string){
		
		$this->db->select('issues.id AS issue,issues.year,issues.month,issues.number,issues.ru_title AS issue_ru_title,issues.en_title AS issue_en_title,publications.*');
		$this->db->from('publications');
		$this->db->join('issues','issues.id = publications.issue');
		if($string !== FALSE):
			$this->db->like('publications.ru_title',$string);
			$this->db->or_like('publications.en_title',$string);
			$this->db->or_like('publications.ru_annotation',$string);
			$this->db->or_like('publications.en_annotation',$string);
		endif;
		$query = $this->db->get();
		if($data = $query->result_array()):
			return $data;
		endif;
		return NULL;
	}

	function getPublicationByIssue($parameters){
		
		$this->db->select('issues.id AS issue,issues.year,issues.month,issues.number,issues.ru_title AS issue_ru_title,issues.en_title AS issue_en_title,publications.*');
		$this->db->from('publications');
		$this->db->join('issues','issues.id = publications.issue');
		if($parameters['year'] !== FALSE):
			$this->db->where('issues.year',$parameters['year']);
		endif;
		if($parameters['number'] !== FALSE):
			$this->db->where('issues.number',$parameters['number']);
		endif;
		if($parameters['text'] !== FALSE):
			$this->db->where('(publications.ru_title LIKE \'%'.$parameters['text'].'%\' OR publications.en_title LIKE \'%'.$parameters['text'].'%\' OR publications.ru_annotation LIKE \'%'.$parameters['text'].'%\' OR publications.en_annotation LIKE \'%'.$parameters['text'].'%\')',NULL);
		endif;
		$query = $this->db->get();
		if($data = $query->result_array()):
			return $data;
		endif;
		return NULL;
	}
}