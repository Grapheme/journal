<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Templates extends MY_Model{

	protected $table = "templates";
	protected $primary_key = "id";
	protected $fields = array("*");

	function __construct(){
		parent::__construct();
	}
}