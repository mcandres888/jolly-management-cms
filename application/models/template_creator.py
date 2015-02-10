
# JOB
#className = "Job"
#tablename = "jobs"
#vars = ["id", "position", "location", "salary", "requirement",
#       "email", "priority" ]

#className = "Branch"
#tablename = "branches"
#vars = ["id", "branch_name", "coordinator", "address", "iframe_src",
#       "landline", "mobile" ]

#className = "Employee"
#tablename = "employees"
#vars = ["id", "employee_name", "job_title", "description"]

#className = "Service"
#tablename = "services"
#vars = ["id", "description"]

#className = "Specialization"
#tablename = "specializations"
#vars = ["id", "description"]

#className = "Client"
#tablename = "clients"
#vars = ["id", "caption", "image_url"]

className = "Message"
tablename = "messages"
vars = ["id", "email", "full_name", "message", 
				"phone_number", "mobile_number","fax_number" ]





#open file
filename = "%s.php" % className.lower()
FILE = open(filename,'w')

FILE.write("<?php\n\n\nclass %s extends CI_Model { \n" % className)
FILE.write("\tvar $caller;\n")
FILE.write("\tvar $table_name = '%s';\n\n" % tablename)

for var in vars:
    FILE.write("\tvar $%s ;\n" % var)


FILE.write("\n\tfunction __construct()\n\t{\n")

FILE.write("\t\t// Call the Model constructor\n")
FILE.write("\t\tparent::__construct();\n")
FILE.write("\t\t$this->caller =& get_instance();\n\t}\n\n")


FILE.write("\tfunction get_table_view_data () {\n")
FILE.write("\t\t$view_data = array();\n")
FILE.write("\t\t$view_data['title'] = '%ss';\n" % className)
FILE.write("\t\t$view_data['desc'] = '%ss';\n" % className)
FILE.write("\t\t$view_data['headers'] = $this->get_table_headers();\n")
FILE.write("\t\t$view_data['desc_headers'] = $this->get_table_desc_headers();\n")
FILE.write("\t\t$view_data['table_data'] = $this->get_all_data();\n")
FILE.write("\t\t$view_data['create_data'] = site_url() . '/main/create_%s' ;\n" % tablename)
FILE.write("\t\t$view_data['delete_data'] = site_url() . '/main/delete_%s' ;\n" % tablename)
FILE.write("\t\t$view_data['edit_data'] = site_url() . '/main/edit_%s' ;\n" % tablename)
FILE.write("\t\treturn $view_data;\n")

FILE.write("\t}\n")




FILE.write("\tfunction get_create_view_data () {\n")
FILE.write("\t\t$view_data = array();\n")
FILE.write("\t\t$view_data['title'] = 'Create %s';\n" % className)
FILE.write("\t\t$view_data['desc'] = 'Create %s';\n" % className)
FILE.write("\t\t$view_data['headers'] = $this->get_table_headers();\n")
FILE.write("\t\t$view_data['form_data'] = $this->get_form_data();\n")
FILE.write("\t\t$view_data['submit_data'] = site_url() . '/main/add_%s' ;\n" % tablename)
FILE.write("\t\treturn $view_data;\n")

FILE.write("\t}\n")



FILE.write("\tfunction get_edit_view_data ( $id ) {\n")
FILE.write("\t\t$view_data = array();\n")
FILE.write("\t\t$this->id  = $id ;\n")
FILE.write("\t\t$this->get();\n")
FILE.write("\t\t$view_data['title'] = 'Edit %s';\n" % className)
FILE.write("\t\t$view_data['desc'] = 'Edit %s';\n" % className)
FILE.write("\t\t$view_data['headers'] = $this->get_table_headers();\n")
FILE.write("\t\t$view_data['form_data'] = $this->get_form_data();\n")
FILE.write("\t\t$view_data['edit_data'] = $this->get_data();\n")
FILE.write("\t\t$view_data['submit_data'] = site_url() . '/main/update_%s/' . $id ;\n" % tablename)
FILE.write("\t\treturn $view_data;\n")

FILE.write("\t}\n")

FILE.write("\tfunction get_data () {\n")
FILE.write("\t\t$data = array(\n")

for var in vars:
    if (var == 'id'):
        continue
    FILE.write("\t\t\t'%s' => $this->%s,\n" % (var,var))

FILE.write("\t\t);\n")
FILE.write("\t\treturn $data;\n")
FILE.write("\t}\n")


FILE.write("\tfunction add() {\n")
FILE.write("\t\t//database insert\n")
FILE.write("\t\t$this->caller->db->insert($this->table_name, $this->get_data());\n")
FILE.write("\t\t// get the id from the last insert\n")
FILE.write("\t\t$this->id  = $this->caller->db->insert_id();\n")
FILE.write("\t\treturn $this->id;\n")
FILE.write("\t}\n\n")

FILE.write("\t\t \n")

FILE.write("\tfunction update() {\n")
FILE.write("\t\t$this->caller->db->where('id', $this->id); \n")
FILE.write("\t\t// database update \n")
FILE.write("\t\t$this->caller->db->update($this->table_name, $this->get_data()); \n")
FILE.write("\t}\n\n")


FILE.write("\tfunction delete() {\n")
FILE.write("\t\t$query = $this->db->query(\"DELETE FROM $this->table_name WHERE id='$this->id'\"); \n")
FILE.write("\t}\n\n")

FILE.write("\t\t \n")
FILE.write("\tfunction get() {\n")
FILE.write("\t\t$query = $this->caller->db->query(\"SELECT * FROM $this->table_name WHERE id='$this->id' LIMIT 1\"); \n")

FILE.write("\t\tforeach ($query->result() as $row) { \n")
for var in vars:
    FILE.write("\t\t\t$this->%s = $row->%s; \n" % (var, var))

FILE.write("\t\t}\n\n")

FILE.write("\t}\n\n")


FILE.write("\tfunction add_thru_post() {\n")
FILE.write("\t\t// get the information first and update the model \n")
for var in vars:
    if (var == 'id'):
        continue
    FILE.write("\t\t$this->%s = $this->caller->input->post('%s'); \n" % (var, var))

FILE.write("\t\t// then add the instance of that model \n")
FILE.write("\t\t$id = $this->add(); \n")
FILE.write("\t\treturn $id; \n")
FILE.write("\t}\n\n")


FILE.write("\tfunction update_thru_post( $id ) {\n")
FILE.write("\t\t// get the information first and update the model \n")
for var in vars:
    if (var == "id"):
        FILE.write("\t\t$this->id = $%s; \n" % var)
    else :
        FILE.write("\t\t$this->%s = $this->caller->input->post('%s'); \n" % (var, var))

FILE.write("\t\t// then add the instance of that model \n")
FILE.write("\t\t$this->update(); \n")
FILE.write("\t}\n\n")

FILE.write("\tfunction delete_thru_post() {\n")
FILE.write("\t\t// get the information first and update the model \n")
FILE.write("\t\t$this->id = $this->caller->input->post('id');\n")

FILE.write("\t\t$this->delete(); \n")
FILE.write("\t}\n\n")


FILE.write("\t\t \n")
FILE.write("\tfunction get_all_data() {\n")
FILE.write("\t\t$data = array(); \n")
FILE.write("\t\t$query = $this->caller->db->query(\"SELECT * FROM $this->table_name\"); \n")
FILE.write("\t\t$total = $this->caller->db->affected_rows(); \n")
FILE.write("\t\t$result['total'] = $total; \n")
FILE.write("\t\t$data['rows'] = array(); \n")
FILE.write("\t\tforeach ($query->result() as $row) { \n")
FILE.write("\t\t\t$data['rows'][] = $row; \n")
FILE.write("\t\t} \n")

FILE.write("\t\treturn $data; \n")
FILE.write("\t}\n\n")



FILE.write("\t\t \n")
FILE.write("\tfunction get_table_desc_headers() {\n")
FILE.write("\t\t$data = array( \n")
for var in vars:
    if (var == 'id'):
        continue
    FILE.write("\t\t\t'%s', \n" % var.title())
FILE.write("\t\t); \n")

FILE.write("\t\treturn $data; \n")
FILE.write("\t}\n\n")




FILE.write("\t\t \n")
FILE.write("\tfunction get_table_headers() {\n")
FILE.write("\t\t$data = array( \n")
for var in vars:
    if (var == 'id'):
        continue
    FILE.write("\t\t\t'%s', \n" % var)
FILE.write("\t\t); \n")

FILE.write("\t\treturn $data; \n")
FILE.write("\t}\n\n")


FILE.write("\t\t \n")
FILE.write("\tfunction get_form_data() {\n")
FILE.write("\t\t$data = array( \n")
for var in vars:
    if (var == 'id'):
        continue
    FILE.write("\t\t\tarray('title' => '%s', 'name'=> '%s', 'desc'=>'', 'type'=>'text'), \n" % (var, var))
FILE.write("\t\t) ;\n")

FILE.write("\t\treturn $data; \n")
FILE.write("\t}\n\n")



FILE.write("\t####### PASTE THIS ON MAIN CONTROLLER ########\n\n")

FILE.write("\tfunction %s () {\n" % tablename)
FILE.write("\t\t$this->load->model('%s'); \n" % className)
FILE.write("\t\t$%s = new %s(); \n" % (className, className))
FILE.write("\t\t$this->load->view('table', $%s->get_table_view_data());\n" % className)
FILE.write("\t}\n")


FILE.write("\tfunction create_%s () {\n" % tablename)
FILE.write("\t\t$this->load->model('%s'); \n" % className)
FILE.write("\t\t$%s = new %s(); \n" % (className, className))
FILE.write("\t\t$this->load->view('form', $%s->get_create_view_data());\n" % className)
FILE.write("\t}\n")

FILE.write("\tfunction edit_%s ($id) {\n" % tablename)
FILE.write("\t\t$this->load->model('%s'); \n" % className)
FILE.write("\t\t$%s = new %s(); \n" % (className, className))
FILE.write("\t\t$this->load->view('edit_form', $%s->get_edit_view_data($id));\n" % className)
FILE.write("\t}\n")

FILE.write("\tfunction delete_%s ($id) {\n" % tablename)
FILE.write("\t\t$this->load->model('%s'); \n" % className)
FILE.write("\t\t$%s = new %s(); \n" % (className, className))
FILE.write("\t\t$%s->id  = $id; \n" % className)
FILE.write("\t\t$%s->delete(); \n" % className)
FILE.write("\t\t$this->%s();\n" % tablename)
FILE.write("\t}\n")


FILE.write("\tfunction add_%s () {\n" % tablename)
FILE.write("\t\t$this->load->model('%s'); \n" % className)
FILE.write("\t\t$%s = new %s(); \n" % (className, className))
FILE.write("\t\t$%s->add_thru_post(); \n" % className)
FILE.write("\t\t$this->%s();\n" % tablename)
FILE.write("\t}\n")

FILE.write("\tfunction update_%s ($id) {\n" % tablename)
FILE.write("\t\t$this->load->model('%s'); \n" % className)
FILE.write("\t\t$%s = new %s(); \n" % (className, className))
FILE.write("\t\t$%s->update_thru_post($id); \n" % className)
FILE.write("\t\t$this->%s();\n" % tablename)
FILE.write("\t}\n")








FILE.write("\t####### END ########\n\n")


FILE.write("}\n\n")
FILE.write("?>")


FILE.close()






