<?php


class Branch extends CI_Model { 
	var $caller;
	var $table_name = 'branches';

	var $id ;
	var $branch_name ;
	var $coordinator ;
	var $address ;
	var $iframe_src ;
	var $landline ;
	var $mobile ;

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->caller =& get_instance();
	}

	function get_table_view_data () {
		$view_data = array();
		$view_data['title'] = 'Branches';
		$view_data['desc'] = 'Branches';
		$view_data['headers'] = $this->get_table_headers();
		$view_data['desc_headers'] = $this->get_table_desc_headers();
		$view_data['table_data'] = $this->get_all_data();
		$view_data['create_data'] = site_url() . '/main/create_branches' ;
		$view_data['delete_data'] = site_url() . '/main/delete_branches' ;
		$view_data['edit_data'] = site_url() . '/main/edit_branches' ;
		return $view_data;
	}
	function get_create_view_data () {
		$view_data = array();
		$view_data['title'] = 'Create Branch';
		$view_data['desc'] = 'Create Branch';
		$view_data['headers'] = $this->get_table_headers();
		$view_data['form_data'] = $this->get_form_data();
		$view_data['submit_data'] = site_url() . '/main/add_branches' ;
		return $view_data;
	}
	function get_edit_view_data ( $id ) {
		$view_data = array();
		$this->id  = $id ;
		$this->get();
		$view_data['title'] = 'Edit Branch';
		$view_data['desc'] = 'Edit Branch';
		$view_data['headers'] = $this->get_table_headers();
		$view_data['form_data'] = $this->get_form_data();
		$view_data['edit_data'] = $this->get_data();
		$view_data['submit_data'] = site_url() . '/main/update_branches/' . $id ;
		return $view_data;
	}
	function get_data () {
		$data = array(
			'branch_name' => $this->branch_name,
			'coordinator' => $this->coordinator,
			'address' => $this->address,
			'iframe_src' => $this->iframe_src,
			'landline' => $this->landline,
			'mobile' => $this->mobile,
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
			$this->branch_name = $row->branch_name; 
			$this->coordinator = $row->coordinator; 
			$this->address = $row->address; 
			$this->iframe_src = $row->iframe_src; 
			$this->landline = $row->landline; 
			$this->mobile = $row->mobile; 
		}

	}

	function add_thru_post() {
		// get the information first and update the model 
		$this->branch_name = $this->caller->input->post('branch_name'); 
		$this->coordinator = $this->caller->input->post('coordinator'); 
		$this->address = $this->caller->input->post('address'); 
		$this->iframe_src = $this->caller->input->post('iframe_src'); 
		$this->landline = $this->caller->input->post('landline'); 
		$this->mobile = $this->caller->input->post('mobile'); 
		// then add the instance of that model 
		$id = $this->add(); 
		return $id; 
	}

	function update_thru_post( $id ) {
		// get the information first and update the model 
		$this->id = $id; 
		$this->branch_name = $this->caller->input->post('branch_name'); 
		$this->coordinator = $this->caller->input->post('coordinator'); 
		$this->address = $this->caller->input->post('address'); 
		$this->iframe_src = $this->caller->input->post('iframe_src'); 
		$this->landline = $this->caller->input->post('landline'); 
		$this->mobile = $this->caller->input->post('mobile'); 
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
			'Branch Name', 
			'Coordinator', 
			'Address', 
			'Google Map Data', 
			'Landline', 
			'Mobile', 
		); 
		return $data; 
	}

		 

		 
	function get_table_headers() {
		$data = array( 
			'branch_name', 
			'coordinator', 
			'address', 
			'iframe_src', 
			'landline', 
			'mobile', 
		); 
		return $data; 
	}

		 
	function get_form_data() {
		$data = array( 
			array('title' => 'Branch Name', 'name'=> 'branch_name', 'desc'=>'', 'type'=>'text'), 
			array('title' => 'Coordinator', 'name'=> 'coordinator', 'desc'=>'', 'type'=>'text'), 
			array('title' => 'Address', 'name'=> 'address', 'desc'=>'', 'type'=>'text'), 
			array('title' => 'Google Map Data', 'name'=> 'iframe_src', 'desc'=>'', 'type'=>'text'), 
			array('title' => 'Landline', 'name'=> 'landline', 'desc'=>'', 'type'=>'text'), 
			array('title' => 'Mobile', 'name'=> 'mobile', 'desc'=>'', 'type'=>'text'), 
		) ;
		return $data; 
	}

	####### PASTE THIS ON MAIN CONTROLLER ########

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
		$this->load->view('edit_form', $Branch->get_edit_view_data());
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

}

?>
