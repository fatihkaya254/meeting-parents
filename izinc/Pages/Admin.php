<?php 


/**
*@package MeetingParents
*/

require_once dirname(__FILE__, 2).'/Api/SettingsApi.php';
require_once dirname(__FILE__, 2).'/Api/Callbacks/AdminCallBacks.php';
require_once dirname(__FILE__, 2).'/Api/Callbacks/VeliCallBacks.php';
require_once dirname(__FILE__, 2).'/Base/BaseController.php';


/**
*
*/
class Admin extends BaseController
{
	public $settings;
	public $callbacks;
	public $callbackveli;
	public $pages = array();
	public $subpages = array();



	public function register()
	{
		$this->callbacks = new AdminCallbacks();
		$this->callbackveli = new VeliCallbacks();
		$this->settings = new SettingsApi();
		$this->setPages();
		$this->setSubPages();
		$this->settings->addPages( $this->pages)->withSubPage('Panel')->addSubPages( $this->subpages)->register();
	}


	public function setPages(){
		$this->pages = array(
			array(
				'page_title' => 'Meeting Parents',
				'menu_title' => 'Meet Parents',
				'capability' => 'delete_private_pages',
				'menu_slug' => 'meeting_parents',
				'callback' => array( $this->callbacks, 'adminDashboard'),
				'icon_url' => 'dashicons-editor-removeformatting',
				'position' => 110
			)
		);
	}

	public function setSubPages(){
		$this->subpages = array(
			array(
				'parent_slug' => 'meeting_parents',
				'page_title' => 'virtual info',
				'menu_title' => 'Öğrenci Dersleri',
				'capability' => 'delete_private_pages',
				'menu_slug' => 'add_parents',
				'callback' => array( $this->callbackveli, 'addveli'),
			),
			array(
				'parent_slug' => 'meeting_parents',
				'page_title' => 'Group',
				'menu_title' => 'Gruplar',
				'capability' => 'manage_options',
				'menu_slug' => 'branch',
				'callback' => array( $this->callbackveli, 'gruplar'),
			),
			array(
				'parent_slug' => 'meeting_parents',
				'page_title' => 'Teacher',
				'menu_title' => 'Öğretmenler',
				'capability' => 'manage_options',
				'menu_slug' => 'teachers',
				'callback' => array( $this->callbackveli, 'teacher'),
			),
			array(
				'parent_slug' => 'meeting_parents',
				'page_title' => 'Stuinfo',
				'menu_title' => 'Öğrenciler',
				'capability' => 'manage_options',
				'menu_slug' => 'stuinfo',
				'callback' => array( $this->callbackveli, 'stuinfo'),
			),
			array(
				'parent_slug' => 'meeting_parents',
				'page_title' => 'Virtual_Week',
				'menu_title' => 'Virtual Week',
				'capability' => 'manage_options',
				'menu_slug' => 'vw',
				'callback' => array( $this->callbackveli, 'vw'),
			),
			array(
				'parent_slug' => 'meeting_parents',
				'page_title' => 'Question Process',
				'menu_title' => 'Soru Çözümleri',
				'capability' => 'manage_options',
				'menu_slug' => 'qp',
				'callback' => array( $this->callbackveli, 'qp'),
			),
			array(
				'parent_slug' => 'meeting_parents',
				'page_title' => 'Numbers',
				'menu_title' => 'SMS Numaraları',
				'capability' => 'manage_options',
				'menu_slug' => 'numbers',
				'callback' => array( $this->callbackveli, 'numbers'),
			),
			array(
				'parent_slug' => 'meeting_parents',
				'page_title' => 'sendsms',
				'menu_title' => 'SMS Gönder',
				'capability' => 'manage_options',
				'menu_slug' => 'sendsmsm',
				'callback' => array( $this->callbackveli, 'ssms'),
			)
		);
	}
}
