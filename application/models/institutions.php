<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Institutions extends MY_Model{

	protected $table = "institutions";
	protected $primary_key = "id";
	protected $fields = array("*");

	function __construct(){
		parent::__construct();
	}
	
}