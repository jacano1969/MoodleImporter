<?php
require_once APPPATH . '/models/Quiz.php';


/**
 * converthtml
 * 
 * Controller class that provides the actions necessary to automate Use Case #2 -
 * the importing of HTML files (or HTML text) and conversion to Moodle XML format.
 *
 * @package MoodleXMLImporter
 * @author John D. Delano
 */
class converthtml extends CI_Controller 
{
    /**
     * __construct
     * 
     * Constructor that loads some default libraries that are used by the actions
     * in this controller. 
     */
    public function __construct() 
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
    
    /**
     * index
     * 
     * Displays the initial view, where the user can upload an HTML formatted
     * file or copy/paste some HTML text.
     */
    public function index()
    {
        $this->load->view('converthtml/index');
    }

    /**
     * review
     * 
     * If the user uploads a file or copies/pastes the HTML in the textbox,
     * this action processes the file or textbox contents and converts it to a 
     * quiz object, which is then stored in the session. The view then displays
     * the quiz information along with options to adjust some of the quiz/item
     * settings.
     * 
     * Displays the item review screen that shows the list of questions that are 
     * to be imported (showing the question title, the question 
     * text, an option for whether or not the answers for the question should be 
     * shuffled, and a point value for each question), a single prompt for which 
     * category all of the questions should use, an option to override the point 
     * value of all questions and a prompt for entering the new point value, and 
     * an option to apply a team-based learning scoring system (If feasible within 
     * quoted time frame). Note that the option to shuffle the answers is not 
     * applicable to some question types. Question titles are also selectable by 
     * the user. The view also provides an option to mark and unmark all the 
     * “Shuffle answer” options. 
     */
    public function review()
    {
        
        // See if we got a file and if it uploaded okay.
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_FILES['uploadFile'])) && ($_FILES['uploadFile']['error'] === UPLOAD_ERR_OK))
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
     * reviewitem
     * 
     * Review item window HTML contents. This action echos the HTML code 
     * necessary for displaying a selected item.
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
     * convert
     * 
     * This action processes the changes made on the review screen, and displays
     * a view with a link to the converted file.
     */
    public function convert()
    {
        $quiz = $_SESSION['quiz'];
        // See if the user checked the Team-Based Learning checkbox
        if ($this->input->post('applyTBL'))
        {
            $quiz->ApplyTBLTemplate = true;
        }
        else
        {
            $quiz->ApplyTBLTemplate = false;
        }
        
        // Set the quiz category
        $quiz->Category = $this->input->post('category');
        
        // Update the items, based on shuffle and point value changes.
        for ($i = 0; $i < count($quiz->Items); $i++)
        {
            // Only items that support Team-based learning should apply the TBL
            // scoring option.
            if ($quiz->Items[$i] instanceof MoodleImporter\ISupportTBL)
            {
                $quiz->Items[$i]->ShuffleAnswers = $this->input->post($quiz->Items[$i]->ID . 'shuffle') == 'shuffle' ? 1 : 0;
            }
            
            $pointValue = $this->input->post($quiz->Items[$i]->ID . 'points');
            if ($pointValue !== FALSE)
            {
                $quiz->Items[$i]->PointValue = $pointValue;
            }
        }
        
        // Keep the updated quiz in the session and send it on for retrieval.
        $_SESSION['quiz'] = $quiz;
        $Data = array();
        $Data['quiz'] = $_SESSION['quiz'];
        $this->load->view('converthtml/convert', $Data);
    }
    
    /**
     * download
     * 
     * File download link target. This action creates and streams the Moodle XML 
     * file to the user, based on the Quiz object in Session state. 
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
