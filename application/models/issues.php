<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Issues extends MY_Model{

	protected $table = "issues";
	protected $primary_key = "id";
	protected $fields = array("*");
	protected $order_by = "number DESC, year DESC";

	function __construct(){
		parent::__construct();
	}
	
	function getLast(){
		
		$this->db->select($this->_fields());
		$this->db->order_by('year DESC, number DESC');
		$this->db->limit('1');
		$query = $this->db->get($this->table);
		if($data = $query->result_array()):
			return $data[0];
		endif;
		return NULL;
	}
	
}