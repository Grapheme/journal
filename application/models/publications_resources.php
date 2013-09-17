<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Publications_resources extends MY_Model{

	protected $table = "publications_resources";
	protected $primary_key = "id";
	protected $fields = array("*");
	protected $order_by = "number";

	function __construct(){
		parent::__construct();
	}
	
}