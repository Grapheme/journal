<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Publications_comments extends MY_Model{

	protected $table = "publications_comments";
	protected $primary_key = "id";
	protected $fields = array("*");
	protected $order_by = "id";

	function __construct(){
		parent::__construct();
	}
	
}