<?php 


/**
*@package MeetingParents
*/


require_once dirname(__FILE__, 3).'/Base/BaseController.php';

class VeliCallbacks extends BaseController
{
	
	public function deletedveliList()
	{
		return require_once("$this->plugin_path/templates/deletedveli.php");
	}

	public function calendar()
	{
		return require_once("$this->plugin_path/templates/calendar.php");
	}
	public function addveli()
	{
		return require_once("$this->plugin_path/templates/virtualinfo.php");
	}
	public function gruplar()
	{
		return require_once("$this->plugin_path/templates/gruplar.php");
	}
	public function teacher()
	{
		return require_once("$this->plugin_path/templates/teacher.php");
	}

	public function stuinfo()
	{
		return require_once("$this->plugin_path/templates/stuinfo.php");
	}
		public function vw()
	{
		return require_once("$this->plugin_path/templates/virtualweekv3.php");
	}
			public function qp()
	{
		return require_once("$this->plugin_path/templates/questionprocess.php");
	}
		public function numbers()
	{
		return require_once("$this->plugin_path/templates/numbers.php");
	}
			public function ssms()
	{
		return require_once("$this->plugin_path/templates/sendsms.php");
	}
}
