<?php
require_once APPPATH . '/models/Quiz.php';

/**
 * Description of convertbb6
 *
 * @author jdelano
 */
class convertbb6 extends CI_Controller
{
    public function __construct() 
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
    
    /**
     * Index page for this controller 
     * 
     * Displays the initial view, where the user can upload a Blackboard 6 zip
     * file.
     */
    public function index()
    {
        $this->load->view('convertbb6/index');
    }
    
    public function review()
    {
        if (is_uploaded_file($_FILES['uploadFile']['tmp_name']))
        {
            $fileData = file_get_contents($_FILES['uploadFile']['tmp_name']);
            $quiz = MoodleImporter\Quiz::GetQuizFromBB6XML($fileData);
            $_SESSION['quiz'] = $quiz;
            $Data = array();
            $Data['quiz'] = $quiz;
            $this->load->view('converthtml/review', $Data);
        }
        else
        {
            $this->index();
        }
    }
}

?>
