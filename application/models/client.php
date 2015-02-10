<?php


class Client extends CI_Model { 
	var $caller;
	var $table_name = 'clients';

	var $id ;
	var $caption ;
	var $image_url ;

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->caller =& get_instance();
	}

	function get_table_view_data () {
		$view_data = array();
		$view_data['title'] = 'Clients';
		$view_data['desc'] = 'Clients';
		$view_data['headers'] = $this->get_table_headers();
		$view_data['desc_headers'] = $this->get_table_desc_headers();
		$view_data['table_data'] = $this->get_all_data();
		$view_data['create_data'] = site_url() . '/main/create_clients' ;
		$view_data['delete_data'] = site_url() . '/main/delete_clients' ;
		$view_data['edit_data'] = site_url() . '/main/edit_clients' ;
		return $view_data;
	}
	function get_create_view_data () {
		$view_data = array();
		$view_data['title'] = 'Create Client';
		$view_data['desc'] = 'Create Client';
		$view_data['headers'] = $this->get_table_headers();
		$view_data['form_data'] = $this->get_form_data();
		$view_data['submit_data'] = site_url() . '/main/add_clients' ;
		return $view_data;
	}
	function get_edit_view_data ( $id ) {
		$view_data = array();
		$this->id  = $id ;
		$this->get();
		$view_data['title'] = 'Edit Client';
		$view_data['desc'] = 'Edit Client';
		$view_data['headers'] = $this->get_table_headers();
		$view_data['form_data'] = $this->get_form_data();
		$view_data['edit_data'] = $this->get_data();
		$view_data['submit_data'] = site_url() . '/main/update_clients/' . $id ;
		return $view_data;
	}
	function get_data () {
		$data = array(
			'caption' => $this->caption,
			'image_url' => $this->image_url,
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
			$this->caption = $row->caption; 
			$this->image_url = $row->image_url; 
		}

	}

	function add_thru_post() {
		// get the information first and update the model 
		$this->caption = $this->caller->input->post('caption'); 
		$this->image_url = $this->caller->input->post('image_url'); 
		// then add the instance of that model 
		$id = $this->add(); 
		return $id; 
	}

	function update_thru_post( $id ) {
		// get the information first and update the model 
		$this->id = $id; 
		$this->caption = $this->caller->input->post('caption'); 
		$this->image_url = $this->caller->input->post('image_url'); 
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
			'Caption', 
			'Image_Url', 
		); 
		return $data; 
	}

		 
	function get_table_headers() {
		$data = array( 
			'caption', 
			'image_url', 
		); 
		return $data; 
	}

		 
	function get_form_data() {
		$data = array( 
			array('title' => 'caption', 'name'=> 'caption', 'desc'=>'', 'type'=>'text'), 
			array('title' => 'image_url', 'name'=> 'image_url', 'desc'=>'', 'type'=>'text'), 
		) ;
		return $data; 
	}

	####### PASTE THIS ON MAIN CONTROLLER ########

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

}

?>
