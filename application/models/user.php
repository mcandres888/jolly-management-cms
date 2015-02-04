<?php


class User extends CI_Model {
	
    
    var $caller ;
    var $table_name = 'users';
    	
    var $id;
    var $username;
    var $password;
    var $email;
    var $type;
    var $firstname;
    var $middlename;
    var $lastname;
    var $sex;
    var $image_url;

   
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
				$this->caller =& get_instance();
    }
  
	function get_data () {
	
  	$data = array(
			'username' => $this->username,
			'password' => $this->password,
			'type' => $this->type,
			'email' => $this->email,
			'firstname' => $this->firstname,
			'middlename' => $this->middlename,
			'lastname' => $this->lastname,
			'sex' => $this->sex,
			'image_url' => $this->image_url,
    );
		
		return $data;

	}
   
	function add ( ) 
 	{
         // database insert
		$this->caller->db->insert($this->table_name, $this->get_data());
 
		// get the id from the last insert
		$this->id  = $this->caller->db->insert_id();
		return $this->id;		 
 	}
    
   function update ( ) 
    {
			
		$this->caller->db->where('id', $this->id);
		// database update
		$this->caller->db->update($this->table_name, $this->get_data());    	
		
    }
    
     function delete ( ) 
    {
    	$query = $this->db->query("DELETE FROM $this->table_name WHERE id='$this->id'");
    }
        

    function get ( ) 
    {
    	$query = $this->caller->db->query("SELECT * FROM $this->table_name WHERE id='$this->id' LIMIT 1");
    	foreach ($query->result() as $row) {
				$this->id = $row->id;
				$this->password = $row->password;
    		$this->username = $row->username;
    		$this->type = $row->type;
    		$this->email = $row->email;
    		$this->firstname = $row->firstname;
    		$this->middlename = $row->middlename;
    		$this->lastname = $row->lastname;
    		$this->sex = $row->sex;
    		$this->image_url = $row->image_url;
			}
    	
    }

		function isPasswordOk ( $username, $password ) {

    	$query = $this->caller->db->query("SELECT * FROM $this->table_name WHERE username='$username' AND password='$password' LIMIT 1");
    	$result = $query->result();
			return count($result);
		}

		function getUserInfo ( $username, $password ) {

    	$query = $this->caller->db->query("SELECT * FROM $this->table_name WHERE username='$username' AND password='$password' LIMIT 1");
    	foreach ($query->result() as $row) {
					return $row;
			}
		}

    
	function add_thru_post ( $type ) {


			$config['upload_path'] = './images/';
			$config['allowed_types'] = 'gif|jpg|png';

			$this->caller->load->library('upload', $config);

			if ( ! $this->caller->upload->do_upload('image_url'))
			{
				$error = array('error' => $this->caller->upload->display_errors());
			}
			else
			{
				$data =  $this->caller->upload->data();
				$this->image_url = $data['file_name'];
			}

		
		// get the information first and update the model
		$this->firstname = $this->caller->input->post('firstname');
		$this->middlename = $this->caller->input->post('middlename');
		$this->lastname = $this->caller->input->post('lastname');
		$this->sex = $this->caller->input->post('sex');
		$this->email = $this->caller->input->post('email');
		$this->username = $this->caller->input->post('username');
		$this->password = $this->caller->input->post('password');
		$this->type = $type;






		// then add the instance of that model
		$id = $this->add();
		return $id;

	}

		
	function update_thru_post ($type) {

			$config['upload_path'] = './images/';
			$config['allowed_types'] = 'gif|jpg|png';

			$this->caller->load->library('upload', $config);

			if ( ! $this->caller->upload->do_upload('image_url'))
			{
				$error = array('error' => $this->caller->upload->display_errors());
			}
			else
			{
				$data =  $this->caller->upload->data();
				$this->image_url = $data['file_name'];
			}


		// get the information first and update the model
		$this->id = $this->caller->input->get('id');
		$this->firstname = $this->caller->input->post('firstname');
		$this->middlename = $this->caller->input->post('middlename');
		$this->lastname = $this->caller->input->post('lastname');
		$this->sex = $this->caller->input->post('sex');
		$this->email = $this->caller->input->post('email');

		$this->username = $this->caller->input->post('username');
		$this->password = $this->caller->input->post('password');

		$this->type = $type;
		$this->update();
	 

	}

	
	function delete_thru_post () {

		// get the information first and update the model
		$this->id = $this->caller->input->post('id');

		$this->delete();
	 

	}

	
	function getTeachers () 
	{
	
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rows = isset($_POST['rows']) ? $_POST['rows'] : 10;
	
		$offset = ($page - 1) * $rows;

		$query = $this->caller->db->query("SELECT * FROM $this->table_name WHERE type='teacher'");
		$total = $this->caller->db->affected_rows();
		
		// Return JSON data
		$data = array();
		$result['total'] = $total;
		$data['rows'] = array();
		
		foreach ($query->result() as $row)
		{	
			$data['rows'][] = $row;
		}
		
		echo json_encode($data);

	}



}

?>
