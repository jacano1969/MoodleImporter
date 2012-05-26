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
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
    
    /**
     * Index page for this controller 
     * 
     * Displays the initial view, where the user can upload an HTML formatted
     * file or copy/paste some HTML text.
     */
    public function index()
    {
        $this->load->view('converthtml/index');
    }

    /**
     * Review page for this controller
     * 
     * If the user uploads a file or copies/pastes the HTML in the textbox,
     * this action processes the file or textbox contents and converts it to a 
     * quiz object, which is then stored in the session. The view then displays
     * the quiz information along with options to adjust some of the quiz/item
     * settings.
     */
    public function review()
    {
        if (is_uploaded_file($_FILES['uploadFile']['tmp_name']))
        {
            $fileData = file_get_contents($_FILES['uploadFile']['tmp_name']);
            $quiz = MoodleImporter\Quiz::GetQuizFromHTML($fileData);
        }
        else
        {
            $quiz = MoodleImporter\Quiz::GetQuizFromHTML($this->input->post('htmlInput'));
        }
        $_SESSION['quiz'] = $quiz;
        $Data = array();
        $Data['quiz'] = $quiz;
        $this->load->view('converthtml/review', $Data);

    }
    
    /**
     * Review item window HTML contents
     * 
     * This action echos the HTML code necessary for displaying a selected
     * item.
     */
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
    }
    
    /**
     * Convert page for this controller
     * 
     * This action processes the changes made on the review screen, and displays
     * a view with a link to the converted file.
     */
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
        $_SESSION['quiz'] = $quiz;
        $Data = array();
        $Data['quiz'] = $_SESSION['quiz'];
        $this->load->view('converthtml/convert', $Data);
    }
    
    /**
     * File download link target
     * 
     * This action creates and streams the Moodle XML file to the user, based
     * on the Quiz object in Session state. 
     */
    public function download()
    {
        $quiz = $_SESSION['quiz'];
        header('Content-Disposition: attachment; filename=quiz_' . $quiz->Category . '.xml');
        header('Content-Type: application/force-download');
        header('Pragma: private');
        header('Cache-control: private, must-revalidate');
        echo $quiz->ToXMLString();
    }
}

?>
