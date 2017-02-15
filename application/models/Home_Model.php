<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_Model extends CI_Model {

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
    }


	function check_login($pref_username, $password)
	{
		$hashPass = hash('sha256', $password);
		$username = strtolower(trim($pref_username));
		//query binding
		$sql = "SELECT * FROM oa_login WHERE preferred_username = ? AND password = ?";
		$query = $this->db->query($sql, array($username, $hashPass));

		if ($query->num_rows() == 1) 
		{
			return 1;
		}
		else
		{
			return 0;
		}
		
	}

	function get_json($pref_username)
	{	
		$username = strtolower(trim($pref_username));
		$get_json = "SELECT a.userid,a.email,a.display_name,a.preferred_username FROM oa_login a WHERE a.preferred_username = ? GROUP BY a.email";
		$rows = $this->db->query($get_json, array($username));
		$datas = $rows->row();

		$display_name = $datas->display_name;
		$preferred_username = $datas->preferred_username;
		$email = $datas->email;
		$userid = $datas->userid;

		$auth_data = array('userid' => $userid, 'email' => $email, 'display_name' => $display_name, 'preferred_username' => $preferred_username);
		$json_auth = json_encode($auth_data);

		return $json_auth;
		
		



	}

}
