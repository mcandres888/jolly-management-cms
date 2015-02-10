<?php


class Message extends CI_Model { 
	var $caller;
	var $table_name = 'messages';

	var $id ;
	var $email ;
	var $full_name ;
	var $message ;
	var $phone_number ;
	var $mobile_number ;
	var $fax_number ;

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->caller =& get_instance();
	}

	function get_table_view_data () {
		$view_data = array();
		$view_data['title'] = 'Messages';
		$view_data['desc'] = 'Messages';
		$view_data['headers'] = $this->get_table_headers();
		$view_data['desc_headers'] = $this->get_table_desc_headers();
		$view_data['table_data'] = $this->get_all_data();
		$view_data['create_data'] = site_url() . '/main/create_messages' ;
		$view_data['delete_data'] = site_url() . '/main/delete_messages' ;
		$view_data['edit_data'] = site_url() . '/main/edit_messages' ;
		return $view_data;
	}
	function get_create_view_data () {
		$view_data = array();
		$view_data['title'] = 'Create Message';
		$view_data['desc'] = 'Create Message';
		$view_data['headers'] = $this->get_table_headers();
		$view_data['form_data'] = $this->get_form_data();
		$view_data['submit_data'] = site_url() . '/main/add_messages' ;
		return $view_data;
	}
	function get_edit_view_data ( $id ) {
		$view_data = array();
		$this->id  = $id ;
		$this->get();
		$view_data['title'] = 'Edit Message';
		$view_data['desc'] = 'Edit Message';
		$view_data['headers'] = $this->get_table_headers();
		$view_data['form_data'] = $this->get_form_data();
		$view_data['edit_data'] = $this->get_data();
		$view_data['submit_data'] = site_url() . '/main/update_messages/' . $id ;
		return $view_data;
	}
	function get_data () {
		$data = array(
			'email' => $this->email,
			'full_name' => $this->full_name,
			'message' => $this->message,
			'phone_number' => $this->phone_number,
			'mobile_number' => $this->mobile_number,
			'fax_number' => $this->fax_number,
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
			$this->email = $row->email; 
			$this->full_name = $row->full_name; 
			$this->message = $row->message; 
			$this->phone_number = $row->phone_number; 
			$this->mobile_number = $row->mobile_number; 
			$this->fax_number = $row->fax_number; 
		}

	}

	function add_thru_post() {
		// get the information first and update the model 
		$this->email = $this->caller->input->post('email'); 
		$this->full_name = $this->caller->input->post('full_name'); 
		$this->message = $this->caller->input->post('message'); 
		$this->phone_number = $this->caller->input->post('phone_number'); 
		$this->mobile_number = $this->caller->input->post('mobile_number'); 
		$this->fax_number = $this->caller->input->post('fax_number'); 
		// then add the instance of that model 
		$id = $this->add(); 
		return $id; 
	}

	function update_thru_post( $id ) {
		// get the information first and update the model 
		$this->id = $id; 
		$this->email = $this->caller->input->post('email'); 
		$this->full_name = $this->caller->input->post('full_name'); 
		$this->message = $this->caller->input->post('message'); 
		$this->phone_number = $this->caller->input->post('phone_number'); 
		$this->mobile_number = $this->caller->input->post('mobile_number'); 
		$this->fax_number = $this->caller->input->post('fax_number'); 
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
			'Email', 
			'Full_Name', 
			'Message', 
			'Phone_Number', 
			'Mobile_Number', 
			'Fax_Number', 
		); 
		return $data; 
	}

		 
	function get_table_headers() {
		$data = array( 
			'email', 
			'full_name', 
			'message', 
			'phone_number', 
			'mobile_number', 
			'fax_number', 
		); 
		return $data; 
	}

		 
	function get_form_data() {
		$data = array( 
			array('title' => 'email', 'name'=> 'email', 'desc'=>'', 'type'=>'text'), 
			array('title' => 'full_name', 'name'=> 'full_name', 'desc'=>'', 'type'=>'text'), 
			array('title' => 'message', 'name'=> 'message', 'desc'=>'', 'type'=>'text'), 
			array('title' => 'phone_number', 'name'=> 'phone_number', 'desc'=>'', 'type'=>'text'), 
			array('title' => 'mobile_number', 'name'=> 'mobile_number', 'desc'=>'', 'type'=>'text'), 
			array('title' => 'fax_number', 'name'=> 'fax_number', 'desc'=>'', 'type'=>'text'), 
		) ;
		return $data; 
	}

	####### PASTE THIS ON MAIN CONTROLLER ########

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

?>