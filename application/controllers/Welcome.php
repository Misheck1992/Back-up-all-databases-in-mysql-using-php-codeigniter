<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->dbutil();
	}

	public function index()
	{
		$dbs = $this->dbutil->list_databases();

		foreach ($dbs as $db)
		{
			$myutil = $this->load->dbutil($db, TRUE);
//			echo $db;
//			echo '<br/>';
			if($db !=='information_schema'){
//							echo $db;
//			echo '<br/>';
				$this->load->database();
				$this->db->db_select($db);
				$prefs = array(
					'format'      => 'zip',
					'filename'    => 'bk'
				);


				$backup = $this->dbutil->backup($prefs);

				$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
				$save = FCPATH.'/'.$db_name;

				$this->load->helper('file');
				write_file($save, $backup);
			}



		}
		$this->load->view('welcome_message');
	}
}
