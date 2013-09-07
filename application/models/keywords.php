<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Keywords extends MY_Model{

	protected $table = "keywords";
	protected $primary_key = "id";
	protected $fields = array("*");

	function __construct(){
		parent::__construct();
	}
	
	function getProductKeyWords($productID){
		
		$this->db->select('keywords.word');
		$this->db->from('matching');
		$this->db->join('keywords','matching.word = keywords.id');
		$this->db->where('matching.publication',$productID);
		$query = $this->db->get();
		if($data = $query->result_array()):
			return $data;
		endif;
		return FALSE;
		
	}
	
	function getKeywordsByChar($char){
		
		$this->db->select($this->_fields());
		$this->db->order_by('word');
		$this->db->like('word',$char,'after');
		$query = $this->db->get($this->table);
		if($data = $query->result_array()):
			return $data;
		endif;
		return NULL;
	}
}