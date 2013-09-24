<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Publications_comments extends MY_Model{

	protected $table = "publications_comments";
	protected $primary_key = "id";
	protected $fields = array("*");
	protected $order_by = "date DESC,id DESC";

	function __construct(){
		parent::__construct();
	}
	
	function getPublicationComments($publicationID){
		
		$this->db->select('accounts.id,accounts.name,accounts.link,publications_comments.id AS comment_id,publications_comments.comment,publications_comments.parent,publications_comments.date');
		$this->db->from('accounts');
		$this->db->join('publications_comments','accounts.id = publications_comments.account');
		$this->db->where('publications_comments.publication',$publicationID);
		$this->db->order_by($this->order_by);
		$query = $this->db->get();
		if($data = $query->result_array()):
			return $data;
		endif;
		return NULL;
	}
	function getLimitList($limit,$offset = 0,$issueID = FALSE,$publicationID = FALSE){
		
		$this->db->select('accounts.id AS account,accounts.name,publications_comments.*,issues.year,issues.month,issues.ru_title AS issue_title,publications.ru_title AS publication_title');
		$this->db->from('publications_comments');
		$this->db->join('accounts','accounts.id = publications_comments.account');
		$this->db->join('issues','issues.id = publications_comments.issue');
		$this->db->join('publications','publications.id = publications_comments.publication');
		$this->db->limit($limit,$offset);
		if(!empty($publicationID)):
			$this->db->where('publications_comments.publication',$publicationID);
		endif;
		if(!empty($issueID)):
			$this->db->where('publications_comments.issue',$issueID);
		endif;
		$this->db->order_by($this->order_by);
		$query = $this->db->get();
		if($data = $query->result_array()):
			return $data;
		endif;
		return NULL;
	}
	
}