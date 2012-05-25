<?php
require_once APPPATH . '/models/Quiz.php';


/**
 * Description of converthtml
 *
 * @author John D. Delano
 */
class converthtml extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
    }
    
    public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->view('converthtml/index');
    }
    
    public function review()
    {
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('htmlInput', 'HTML Input field', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('converthtml/index');
        }
        else
        {
            $quiz = MoodleImporter\Quiz::GetQuizFromHTML($this->input->post('htmlInput'));
            $_SESSION['quiz'] = $quiz;
            $Data = array();
            $Data['quiz'] = $quiz;
            $this->load->view('converthtml/review', $Data);
        }
    }
    
    public function reviewitem()
    {
        $quiz = $_SESSION['quiz'];
        $quizID = $this->input->post('quizID');
        $foundItem = null;
        foreach ($quiz->Items as $item)
        {
            if ($item->ID == $quizID)
            {
                $foundItem = $item;
                break;
            }
        }
        if ($foundItem != null)
        {
            echo $foundItem->ToHTML();
        }
        else {
            return '';
        }
    }
    
    public function convert()
    {
        $quiz = $_SESSION['quiz'];
        // @todo Get Team-Based learning scoring from form applied.
        $quiz->Category = $this->input->post('category');
        for ($i = 0; $i < count($quiz->Items); $i++)
        {
            if (property_exists($quiz->Items[$i], 'ShuffleAnswers'))
            {
                $quiz->Items[$i]->ShuffleAnswers = $this->input->post($quiz->Items[$i]->ID . 'shuffle') == 'shuffle' ? 1 : 0;
            }
            
            $pointValue = $this->input->post($quiz->Items[$i]->ID . 'points');
            if ($pointValue !== FALSE)
            {
                $quiz->Items[$i]->PointValue = $pointValue;
            }
        }
        $Data = array();
        $Data['quiz'] = $quiz;

        $this->load->view('converthtml/convert', $Data);
    }
}

?>
