<?php
    
class Setting extends CI_Controller {
    
    public function __contruct() {
        parent::__contruct();
    }
        
    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $this->load->view("view_setting");
        }   
            
    }   
        
    public function exportDB(){
        // Load the DB utility class
        $this->load->dbutil();

        // Backup your entire database and assign it to a variable
        $prefs = array(
                'tables'      => array('staff', 'student', 'class', 'education', 'gender', 'gender_message', 'history', 'history_message', 'history_type', 'payment', 'payment_type', 'language', 'label', 'label_message', 'permission', 'menu', 'menu_type'),  // Array of tables to backup.
                'ignore'      => array(),           // List of tables to omit from the backup
                'format'      => 'txt',             // gzip, zip, txt
                'filename'    => 'l-fis.sql',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );

        $backup =& $this->dbutil->backup($prefs); 

        // Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file('/assets/dist/l-fis.sql', $backup); 

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('l-fis.sql', $backup);
    }
}
    
?>