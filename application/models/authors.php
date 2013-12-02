<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Authors extends MY_Model{

	protected $table = "authors";
	protected $primary_key = "id";
	protected $fields = array("*");

	function __construct(){
		parent::__construct();
	}
	
	function getAuthorsByChar($char,$lang = RUSLAN){

		$this->db->select($this->_fields());
		$this->db->order_by($lang.'_name');
		$this->db->like($lang.'_name',$char,'after');
		$query = $this->db->get($this->table);
		if($data = $query->result_array()):
			return $data;
		endif;
		return NULL;
	}
	function searchAuthorsByChar($char,$lang = RUSLAN){
		
		$this->db->select('id,'.$lang.'_name AS name');
		$this->db->order_by($lang.'_name');
		$this->db->like($lang.'_name',$char,'after');
		$query = $this->db->get($this->table);
		if($data = $query->result_array()):
			return $data;
		endif;
		return NULL;
	}
	function getAuthorsByIDs($IDs){

		$this->db->select('id,ru_name AS name,ru_name,en_name');
		$this->db->where_in('id',$IDs);
		$query = $this->db->get($this->table);
		if($data = $query->result_array()):
			return $data;
		endif;
		return NULL;
	}
	function authorsFullInfo($IDs){

		$this->db->select('authors.ru_name,authors.en_name,authors.email,institutions.ru_title,institutions.en_title');
		$this->db->from('authors');
		$this->db->join('institutions','authors.institution = institutions.id');
		$this->db->where_in('authors.id',$IDs);
		$query = $this->db->get();
		if($data = $query->result_array()):
			return $data;
		endif;
		return NULL;
	}
}