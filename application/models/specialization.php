<?php


class Specialization extends CI_Model { 
	var $caller;
	var $table_name = 'specializations';

	var $id ;
	var $description ;

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->caller =& get_instance();
	}

	function get_table_view_data () {
		$view_data = array();
		$view_data['title'] = 'Specializations';
		$view_data['desc'] = 'Specializations';
		$view_data['headers'] = $this->get_table_headers();
		$view_data['desc_headers'] = $this->get_table_desc_headers();
		$view_data['table_data'] = $this->get_all_data();
		$view_data['create_data'] = site_url() . '/main/create_specializations' ;
		$view_data['delete_data'] = site_url() . '/main/delete_specializations' ;
		$view_data['edit_data'] = site_url() . '/main/edit_specializations' ;
		return $view_data;
	}
	function get_create_view_data () {
		$view_data = array();
		$view_data['title'] = 'Create Specialization';
		$view_data['desc'] = 'Create Specialization';
		$view_data['headers'] = $this->get_table_headers();
		$view_data['form_data'] = $this->get_form_data();
		$view_data['submit_data'] = site_url() . '/main/add_specializations' ;
		return $view_data;
	}
	function get_edit_view_data ( $id ) {
		$view_data = array();
		$this->id  = $id ;
		$this->get();
		$view_data['title'] = 'Edit Specialization';
		$view_data['desc'] = 'Edit Specialization';
		$view_data['headers'] = $this->get_table_headers();
		$view_data['form_data'] = $this->get_form_data();
		$view_data['edit_data'] = $this->get_data();
		$view_data['submit_data'] = site_url() . '/main/update_specializations/' . $id ;
		return $view_data;
	}
	function get_data () {
		$data = array(
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
			$this->description = $row->description; 
		}

	}

	function add_thru_post() {
		// get the information first and update the model 
		$this->description = $this->caller->input->post('description'); 
		// then add the instance of that model 
		$id = $this->add(); 
		return $id; 
	}

	function update_thru_post( $id ) {
		// get the information first and update the model 
		$this->id = $id; 
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
			'Description', 
		); 
		return $data; 
	}

		 
	function get_table_headers() {
		$data = array( 
			'description', 
		); 
		return $data; 
	}

		 
	function get_form_data() {
		$data = array( 
			array('title' => 'description', 'name'=> 'description', 'desc'=>'', 'type'=>'text'), 
		) ;
		return $data; 
	}

	####### PASTE THIS ON MAIN CONTROLLER ########

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

}

?>