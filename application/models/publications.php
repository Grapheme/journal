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
		$data = $query->result_array();
		if($data):
			return $data;
		endif;
		return NULL;
	}
}