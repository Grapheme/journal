<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends MY_Model{

	protected $table = "accounts";
	protected $primary_key = "id";
	protected $fields = array("id","login","password","signdate","active");

	function __construct(){
		
		parent::__construct();
	}
	
	function authentication($login = NULL,$password = NULL){
		
		if(!is_null($login) || !is_null($password)):
			$this->db->select($this->_fields());
			$this->db->where('login',$login);
			$this->db->where('password',md5($password));
			$query = $this->db->get($this->table,1);
			$data = $query->result_array();
			if($data):
				return $data[0];
			endif;
		endif;
		return FALSE;
	}
}