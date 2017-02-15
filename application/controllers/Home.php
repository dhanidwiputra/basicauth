<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Home_Model');
    }

	public function index()
	{
		//if user hit cancel button
		if (!isset($_SERVER['PHP_AUTH_USER']) && !isset($_SERVER['PHP_AUTH_PW'])) 
		{
			header("WWW-Authenticate: Basic realm=\"Please enter your username and password to proceed further\"");
			header("HTTP/1.0 401 Unauthorized");
			print "Oops! It require login to proceed further. Please enter your login detail\n";
			exit;
		} 
		else 
		{

			$preferred_username = $_SERVER['PHP_AUTH_USER'];
			$password = $_SERVER['PHP_AUTH_PW'];

			//validated check with database
			$validated = $this->Home_Model->check_login($preferred_username,$password);

			//if user validated
			if ($validated) 
			{
				
				$user_data = $this->Home_Model->get_json($preferred_username);
				echo $user_data;
				exit;

			} 
			else 
			{
				header("WWW-Authenticate: Basic realm=\"Please enter your username and password to proceed further\"");
				header("HTTP/1.0 401 Unauthorized");
				print "Oops! It require login to proceed further. Please enter your login detail\n";
				exit;
			}
		}
	}

}
