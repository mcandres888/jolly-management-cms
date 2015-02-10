<?php


class Employee extends CI_Model { 
	var $caller;
	var $table_name = 'employees';

	var $id ;
	var $employee_name ;
	var $job_title ;
	var $description ;

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->caller =& get_instance();
	}

	function get_table_view_data () {
		$view_data = array();
		$view_data['title'] = 'Employees';
		$view_data['desc'] = 'Employees';
		$view_data['headers'] = $this->get_table_headers();
		$view_data['desc_headers'] = $this->get_table_desc_headers();
		$view_data['table_data'] = $this->get_all_data();
		$view_data['create_data'] = site_url() . '/main/create_employees' ;
		$view_data['delete_data'] = site_url() . '/main/delete_employees' ;
		$view_data['edit_data'] = site_url() . '/main/edit_employees' ;
		return $view_data;
	}
	function get_create_view_data () {
		$view_data = array();
		$view_data['title'] = 'Create Employee';
		$view_data['desc'] = 'Create Employee';
		$view_data['headers'] = $this->get_table_headers();
		$view_data['form_data'] = $this->get_form_data();
		$view_data['submit_data'] = site_url() . '/main/add_employees' ;
		return $view_data;
	}
	function get_edit_view_data ( $id ) {
		$view_data = array();
		$this->id  = $id ;
		$this->get();
		$view_data['title'] = 'Edit Employee';
		$view_data['desc'] = 'Edit Employee';
		$view_data['headers'] = $this->get_table_headers();
		$view_data['form_data'] = $this->get_form_data();
		$view_data['edit_data'] = $this->get_data();
		$view_data['submit_data'] = site_url() . '/main/update_employees/' . $id ;
		return $view_data;
	}
	function get_data () {
		$data = array(
			'employee_name' => $this->employee_name,
			'job_title' => $this->job_title,
			'description' => $this->description,
		);
		return $data;
	}
	function add() {
		//database insert
		$this->caller->db->insert($this->table_name, $this->get_data());
		// get the id from the last insert
		$this->id  = $this->caller->db->insert_id();
		return $this->id;
	}

		 
	function update() {
		$this->caller->db->where('id', $this->id); 
		// database update 
		$this->caller->db->update($this->table_name, $this->get_data()); 
	}

	function delete() {
		$query = $this->db->query("DELETE FROM $this->table_name WHERE id='$this->id'"); 
	}

		 
	function get() {
		$query = $this->caller->db->query("SELECT * FROM $this->table_name WHERE id='$this->id' LIMIT 1"); 
		foreach ($query->result() as $row) { 
			$this->id = $row->id; 
			$this->employee_name = $row->employee_name; 
			$this->job_title = $row->job_title; 
			$this->description = $row->description; 
		}

	}

	function add_thru_post() {
		// get the information first and update the model 
		$this->employee_name = $this->caller->input->post('employee_name'); 
		$this->job_title = $this->caller->input->post('job_title'); 
		$this->description = $this->caller->input->post('description'); 
		// then add the instance of that model 
		$id = $this->add(); 
		return $id; 
	}

	function update_thru_post( $id ) {
		// get the information first and update the model 
		$this->id = $id; 
		$this->employee_name = $this->caller->input->post('employee_name'); 
		$this->job_title = $this->caller->input->post('job_title'); 
		$this->description = $this->caller->input->post('description'); 
		// then add the instance of that model 
		$this->update(); 
	}

	function delete_thru_post() {
		// get the information first and update the model 
		$this->id = $this->caller->input->post('id');
		$this->delete(); 
	}

		 
	function get_all_data() {
		$data = array(); 
		$query = $this->caller->db->query("SELECT * FROM $this->table_name"); 
		$total = $this->caller->db->affected_rows(); 
		$result['total'] = $total; 
		$data['rows'] = array(); 
		foreach ($query->result() as $row) { 
			$data['rows'][] = $row; 
		} 
		return $data; 
	}

		 
	function get_table_desc_headers() {
		$data = array( 
			'Employee_Name', 
			'Job_Title', 
			'Description', 
		); 
		return $data; 
	}

		 
	function get_table_headers() {
		$data = array( 
			'employee_name', 
			'job_title', 
			'description', 
		); 
		return $data; 
	}

		 
	function get_form_data() {
		$data = array( 
			array('title' => 'Employee Name', 'name'=> 'employee_name', 'desc'=>'', 'type'=>'text'), 
			array('title' => 'Job Title', 'name'=> 'job_title', 'desc'=>'', 'type'=>'text'), 
			array('title' => 'Description', 'name'=> 'description', 'desc'=>'', 'type'=>'text'), 
		) ;
		return $data; 
	}

	####### PASTE THIS ON MAIN CONTROLLER ########

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
		$this->load->view('edit_form', $Employee->get_edit_view_data());
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

}

?>
