# Back up all databases in mysql using php codeigniter
 This php script lets you backup all the databases of phpmyadmin at once
 To use this cript
 1. You need to make database connectivity on by providing host server, user and password li below
 $active_group = 'default';
 $query_builder = TRUE;
 
 $db['default'] = array(
 	'dsn'	=> '',
 	'hostname' => 'localhost',
 	'username' => 'root',
 	'password' => '',
 	'database' => '',
 	'dbdriver' => 'mysqli',
 	'dbprefix' => '',
 	'pconnect' => FALSE,
 	'db_debug' => (ENVIRONMENT !== 'production'),
 	'cache_on' => FALSE,
 	'cachedir' => '',
 	'char_set' => 'utf8',
 	'dbcollat' => 'utf8_general_ci',
 	'swap_pre' => '',
 	'encrypt' => FALSE,
 	'compress' => FALSE,
 	'stricton' => FALSE,
 	'failover' => array(),
 	'save_queries' => TRUE
 );
 2. in autoload file load database libraries, email and session though database library is one most wanted
 in my this project i have alread done you can just check config file.
 3. in your controller function do like below
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

you can comment from if condition and uncomment
 //			echo $db;
 //			echo '<br/>';
 
 you will be able to see all the databases in your mysql engine or phpmyadmin

