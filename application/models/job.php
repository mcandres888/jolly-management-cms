<?php


class Job extends CI_Model { 
	var $caller;
	var $table_name = 'jobs';

	var $id ;
	var $position ;
	var $location ;
	var $salary ;
	var $requirement ;
	var $email ;
	var $priority = 0;

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->caller =& get_instance();
	}

	function get_table_view_data () {

		$view_data = array();
		$view_data['title'] = "Jobs";
    $view_data['desc'] = "Job Oppurtunities";
    $view_data['headers'] = $this->get_table_headers();
    $view_data['desc_headers'] = $this->get_table_desc_headers();
    $view_data['table_data'] = $this->get_all_data();
    $view_data['create_data'] = site_url() . "/main/create_jobs" ;
    $view_data['delete_data'] = site_url() . "/main/delete_jobs" ;
    $view_data['edit_data'] = site_url() . "/main/edit_jobs" ;
		return $view_data;

	}

	function get_create_view_data () {

		$view_data = array();
    $view_data['title'] = "Create Jobs";
    $view_data['desc'] = "Create Job Oppurtunities";
    $view_data['headers'] = $this->get_table_headers();
    $view_data['form_data'] = $this->get_form_data();
    $view_data['submit_data'] = site_url() . "/main/add_jobs" ;
		return $view_data;

	}

	function get_edit_view_data ( $id ) {

		$view_data = array();
    $this->id = $id;
    $this->get();
    $view_data['title'] = "Edit Job";
    $view_data['desc'] = "Edit Job Oppurtunities";
    $view_data['headers'] = $this->get_table_headers();
    $view_data['form_data'] = $this->get_form_data();
    $view_data['edit_data'] = $this->get_data();
    $view_data['submit_data'] = site_url() . "/main/update_jobs/" . $id ;
		return $view_data;

	}





  function get_form_data () {
		$data = array(
			array("title" => "Position", "name" => "position" , "desc" => "" , "type" =>"text"),
			array("title" => "Location", "name" => "location" , "desc" => "" , "type" =>"text"),
			array("title" => "Salary"  , "name" => "salary" , "desc" => "", "type" =>"text" ),
			array("title" => "Requirements", "name" => "requirement" , "desc" => "" , "type" =>"textarea"),
			array("title" => "Email", "name" => "email" , "desc" => "", "type" =>"text" ),
			array("title" => "Priority", "name" => "priority" , "desc" => "Enter a number. Higher number means it will be on the top list.", "type" =>"number" ),
		);
		return $data;

	}





  function get_table_desc_headers () {
		$data = array(
			'Job Position',
			'Job Location',
			'Salary',
			'Requirement',
			'Email',
			'Priority',
		);
		return $data;

	}


  function get_table_headers () {
		$data = array(
			'position',
			'location',
			'salary',
			'requirement',
			'email',
			'priority',
		);
		return $data;

	}

	function get_data () {
		$data = array(
			'position' => $this->position,
			'location' => $this->location,
			'salary' => $this->salary,
			'requirement' => $this->requirement,
			'email' => $this->email,
			'priority' => $this->priority,
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
			$this->position = $row->position; 
			$this->location = $row->location; 
			$this->salary = $row->salary; 
			$this->requirement = $row->requirement; 
			$this->email = $row->email; 
			$this->priority = $row->priority; 
		}

	}

	function add_thru_post() {
		// get the information first and update the model 
		$this->position = $this->caller->input->post('position'); 
		$this->location = $this->caller->input->post('location'); 
		$this->salary = $this->caller->input->post('salary'); 
		$this->requirement = preg_replace("/\n/", "<br/>", $this->caller->input->post('requirement')); 
		$this->email = $this->caller->input->post('email'); 
		$this->priority = $this->caller->input->post('priority'); 
		// then add the instance of that model 
		$id = $this->add(); 
		return $id; 
	}

	function update_thru_post( $id ) {
		// get the information first and update the model 
		$this->id = $id;
		$this->position = $this->caller->input->post('position'); 
		$this->location = $this->caller->input->post('location'); 
		$this->salary = $this->caller->input->post('salary'); 
		$this->requirement = preg_replace("/\n/", "<br/>", $this->caller->input->post('requirement')); 
		$this->email = $this->caller->input->post('email'); 
		$this->priority = $this->caller->input->post('priority'); 
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

    foreach ($query->result() as $row)
    {
      $data['rows'][] = $row;
    }

		return $data;
	}
  

}

?>
