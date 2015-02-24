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
			//$this->load->view('main');
      $this->jobs();
   		}

	}

	function loadMain ()
    {

		//$this->load->view('main');
      $this->jobs();

	}

	public function template()
	{
		$this->load->view('template');
	}


	public function jobs()
	{
  	$this->load->model('job');
   	$job = new job();
		$this->load->view('table', $job->get_table_view_data());
	}


	public function create_jobs()
	{

  	$this->load->model('job');
   	$job = new job();
		$this->load->view('form', $job->get_create_view_data());
	}

	public function edit_jobs( $id )
	{
  	$this->load->model('job');
   	$job = new job();
		$this->load->view('edit_form', $job->get_edit_view_data($id));
	}

	public function delete_jobs( $id )
	{
  	$this->load->model('job');
   	$job = new job();
		$job->id = $id;
		$job->delete();
		$this->jobs();
	}

	public function add_jobs()
	{
  	$this->load->model('job');
   	$job = new job();
		$job->add_thru_post();
		$this->jobs();
	}

	public function update_jobs( $id )
	{
  	$this->load->model('job');
   	$job = new job();
		$job->update_thru_post( $id );
		$this->jobs();
	}





	public function form()
	{
		$this->load->view('form');
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



  ####### BRANCH ########

  function branches () {
    $this->load->model('Branch');
    $Branch = new Branch();
    $this->load->view('table', $Branch->get_table_view_data());
  }
  function create_branches () {
    $this->load->model('Branch');
    $Branch = new Branch();
    $this->load->view('form', $Branch->get_create_view_data());
  }
  function edit_branches ($id) {
    $this->load->model('Branch');
    $Branch = new Branch();
    $this->load->view('edit_form', $Branch->get_edit_view_data($id));
  }

  function delete_branches ($id) {
    $this->load->model('Branch');
    $Branch = new Branch();
    $Branch->id  = $id;
    $Branch->delete();
    $this->branches();
  }
  function add_branches () {
    $this->load->model('Branch');
    $Branch = new Branch();
    $Branch->add_thru_post();
    $this->branches();
  }
  function update_branches ($id) {
    $this->load->model('Branch');
    $Branch = new Branch();
    $Branch->update_thru_post($id);
    $this->branches();
  }
  ####### END ########



 ####### Employees ########

  function employees () {
    $this->load->model('Employee');
    $Employee = new Employee();
    $this->load->view('table', $Employee->get_table_view_data());
  }
  function create_employees () {
    $this->load->model('Employee');
    $Employee = new Employee();
    $this->load->view('form', $Employee->get_create_view_data());
  }
  function edit_employees ($id) {
    $this->load->model('Employee');
    $Employee = new Employee();
    $this->load->view('edit_form', $Employee->get_edit_view_data($id));
  }



  function delete_employees ($id) {
    $this->load->model('Employee');
    $Employee = new Employee();
    $Employee->id  = $id;
    $Employee->delete();
    $this->employees();
  }
  function add_employees () {
    $this->load->model('Employee');
    $Employee = new Employee();
    $Employee->add_thru_post();
    $this->employees();
  }
  function update_employees ($id) {
    $this->load->model('Employee');
    $Employee = new Employee();
    $Employee->update_thru_post($id);
    $this->employees();
  }
  ####### END ########


  ####### SERVICES ########

  function services () {
    $this->load->model('Service');
    $Service = new Service();
    $this->load->view('table', $Service->get_table_view_data());
  }
  function create_services () {
    $this->load->model('Service');
    $Service = new Service();
    $this->load->view('form', $Service->get_create_view_data());
  }
  function edit_services ($id) {
    $this->load->model('Service');
    $Service = new Service();
    $this->load->view('edit_form', $Service->get_edit_view_data($id));
  }


  function delete_services ($id) {
    $this->load->model('Service');
    $Service = new Service();
    $Service->id  = $id;
    $Service->delete();
    $this->services();
  }
  function add_services () {
    $this->load->model('Service');
    $Service = new Service();
    $Service->add_thru_post();
    $this->services();
  }
  function update_services ($id) {
    $this->load->model('Service');
    $Service = new Service();
    $Service->update_thru_post($id);
    $this->services();
  }
  ####### END ########


  ####### Specialization ########

  function specializations () {
    $this->load->model('Specialization');
    $Specialization = new Specialization();
    $this->load->view('table', $Specialization->get_table_view_data());
  }
  function create_specializations () {
    $this->load->model('Specialization');
    $Specialization = new Specialization();
    $this->load->view('form', $Specialization->get_create_view_data());
  }
  function edit_specializations ($id) {
    $this->load->model('Specialization');
    $Specialization = new Specialization();
    $this->load->view('edit_form', $Specialization->get_edit_view_data($id));
  }


  function delete_specializations ($id) {
    $this->load->model('Specialization');
    $Specialization = new Specialization();
    $Specialization->id  = $id;
    $Specialization->delete();
    $this->specializations();
  }
  function add_specializations () {
    $this->load->model('Specialization');
    $Specialization = new Specialization();
    $Specialization->add_thru_post();
    $this->specializations();
  }
  function update_specializations ($id) {
    $this->load->model('Specialization');
    $Specialization = new Specialization();
    $Specialization->update_thru_post($id);
    $this->specializations();
  }
  ####### END ########



  ####### CLIENTS ########

  function clients () {
    $this->load->model('Client');
    $Client = new Client();
    $this->load->view('table', $Client->get_table_view_data());
  }
  function create_clients () {
    $this->load->model('Client');
    $Client = new Client();
    $this->load->view('form', $Client->get_create_view_data());
  }
  function edit_clients ($id) {
    $this->load->model('Client');
    $Client = new Client();
    $this->load->view('edit_form', $Client->get_edit_view_data($id));
  }


  function delete_clients ($id) {
    $this->load->model('Client');
    $Client = new Client();
    $Client->id  = $id;
    $Client->delete();
    $this->clients();
  }
  function add_clients () {
    $this->load->model('Client');
    $Client = new Client();
    $Client->add_thru_post();
    $this->clients();
  }
  function update_clients ($id) {
    $this->load->model('Client');
    $Client = new Client();
    $Client->update_thru_post($id);
    $this->clients();
  }
  ####### END ########


  ####### MESSAGE ########

  function messages () {
    $this->load->model('Message');
    $Message = new Message();
    $this->load->view('table', $Message->get_table_view_data());
  }
  function create_messages () {
    $this->load->model('Message');
    $Message = new Message();
    $this->load->view('form', $Message->get_create_view_data());
  }
  function edit_messages ($id) {
    $this->load->model('Message');
    $Message = new Message();
    $this->load->view('edit_form', $Message->get_edit_view_data($id));
  }

  function delete_messages ($id) {
    $this->load->model('Message');
    $Message = new Message();
    $Message->id  = $id;
    $Message->delete();
    $this->messages();
  }
  function add_messages () {
    $this->load->model('Message');
    $Message = new Message();
    $Message->add_thru_post();
    $this->messages();
  }
  function update_messages ($id) {
    $this->load->model('Message');
    $Message = new Message();
    $Message->update_thru_post($id);
    $this->messages();
  }
  ####### END ########







}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
