<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Authors extends MY_Model{

	protected $table = "authors";
	protected $primary_key = "id";
	protected $fields = array("*");
//	protected $order_by = "ru_name,en_name";

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
	
}