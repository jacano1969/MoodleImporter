<?php
require_once APPPATH . '/models/Quiz.php';


/**
 * Description of converthtml
 *
 * @author jdelano
 */
class converthtml extends CI_Controller {

    public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->view('converthtml/index');
    }
    
    public function convert()
    {
        //$this->load->model('Quiz');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('htmlInput', 'HTML Input field', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('converthtml/index');
        }
        else
        {
            $quiz = MoodleImporter\Quiz::GetQuizFromHTML($this->input->post('htmlInput'));
            $Data['quiz'] = $quiz->ToXMLString();
            $this->load->view('converthtml/convert', $Data);
        }
        

    }
}

?>
