<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        if($this->session->userdata('login_state') == FALSE){
            if ($this->input->get('action') == "verify") {
       			$this->login();
            } else {
				$this->load->view('login');
			}
		}else{
			$this->load->view('main');
   		}

	}

	function loadMain ()
    {

		$this->load->view('main');

	}

	public function template()
	{
		$this->load->view('template');
	}

	public function table()
	{
		$this->load->view('table');
	}
	public function login()
	{
     	$this->load->model('user');
       	$user = new user();

       	$username = $this->input->post('username');
       	$password = $this->input->post('password');

       	if ( $user->isPasswordOk($username, $password) ) {

       		$userInfo = $user->getUserInfo($username, $password);
           	$this->session->set_userdata('username', $username);
           	$this->session->set_userdata('usertype', $userInfo->type);
           	$this->session->set_userdata('userid', $userInfo->id);
           	$this->session->set_userdata('login_state', TRUE);
          	$this->loadMain();
       	} else {
       		$view_data['error'] = "Incorrect Email/Password!";
           	$this->load->view('login', $view_data);

       	}



	}

        public function logout()
        {

                $this->session->sess_destroy();
                $this->session->set_userdata('login_state', FALSE);
                $this->session->set_userdata('username', "");
                $this->index();
        }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
