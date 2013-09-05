<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Issues extends MY_Model{

	protected $table = "issues";
	protected $primary_key = "id";
	protected $fields = array("*");
	protected $order_by = "number DESC, month DESC, year DESC";

	function __construct(){
		parent::__construct();
	}
	
}