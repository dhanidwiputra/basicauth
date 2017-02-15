<?php if(! defined('BASEPATH')) exit('Akses langsung tidak diperbolehkan'); 

class Simple_login {
	// SET SUPER GLOBAL
	var $CI = NULL;
	public function __construct() {
		$this->CI =& get_instance();
	}
	// Fungsi login
	public function login($username, $password) 
	{
		//hash password to sha256
		$hashPass = hash('sha256', $password);
		$username = strtolower(trim($username));
		//query binding
		$sql = "SELECT * FROM oa_login WHERE email = ? AND password = ?";
		$query = $this->CI->db->query($sql, array(trim($username), $hashPass));

		//jika ada row di db kondisi true
		if($query->num_rows() == 1) 
		{
			//get data untuk session user data
			$get_userdata = "SELECT * FROM oa_login WHERE preferred_username = ?";
			$row = $this->CI->db->query($get_userdata, array(trim($username)));
			$admin 	= $row->row();
			$id 	= $admin->id;
			$is_activated = $admin->is_activated;

			if($is_activated=="1")
			{
				$this->CI->session->set_userdata('username', $username);
				$this->CI->session->set_userdata('id_login', uniqid(rand()));
				$this->CI->session->set_userdata('id', $id);
				//redirect(base_url('dashboard'));

				$get_json = "SELECT a.userid,a.email,a.display_name,a.preferred_username FROM oa_login a WHERE a.preferred_username = ? GROUP BY a.email";
				$rows = $this->CI->db->query($get_json, array(trim($username)));
				$datas = $rows->row();
				$display_name = $datas->display_name;
				$preferred_username = $datas->preferred_username;
				$email = $datas->email;
				$userid = $datas->userid;

				
				//$uuid = $this->CI->uuid->v4();


				$auth_data = array('userid' => $userid, 'email' => $email, 'display_name' => $display_name, 'preferred_username' => $preferred_username);
				$json_auth = json_encode($auth_data);
				die($json_auth);
			}
			else
			{
				$this->CI->session->set_flashdata('sukses','Warning: please activate your email!');
				redirect(base_url('login'));
			}

		}
		else
		{
			//$this->CI->session->set_flashdata('sukses','Warning: wrong username/password!');
			redirect(base_url('home'));
		}
		return false;
	}
	// Proteksi halaman
	public function cek_login() 
	{
		if($this->CI->session->userdata('username') == '') 
		{
			$this->CI->session->set_flashdata('sukses','Warning: please login first.');
			redirect(base_url('login'));
		}
	}
	// Fungsi logout
	public function logout() 
	{
		$this->CI->session->unset_userdata('username');
		$this->CI->session->unset_userdata('id_login');
		$this->CI->session->unset_userdata('id');
		$this->CI->session->unset_userdata('ID_PUB');
		$this->CI->session->unset_userdata('ACTIVE_WEBSITE');
		$this->CI->session->unset_userdata('PROV');
		$this->CI->session->unset_userdata('is_compare');
		$this->CI->session->unset_userdata('date');
		$this->CI->session->unset_userdata('date2');
		$this->CI->session->unset_userdata('state_root');
		$this->CI->session->unset_userdata('state_leaf');
		$this->CI->session->set_flashdata('sukses','Info: logout success.');
		redirect(base_url('login'));
	}

	
}