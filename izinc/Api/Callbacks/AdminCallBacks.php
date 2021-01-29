<?php 


/**
*@package MeetingParents
*/
require_once dirname(__FILE__, 3).'/Base/BaseController.php';

class AdminCallbacks extends BaseController
{
	public function adminDashboard()
	{
		return require_once("$this->plugin_path/templates/sync.php");
	}
}