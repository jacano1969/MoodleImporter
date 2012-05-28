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
        $quiz = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            if (isset($_FILES['uploadFile'])) 
            {
                if ($_FILES['uploadFile']['error'] === UPLOAD_ERR_OK) 
                {
                    // See if the user uploaded the entire zip file...
                    if (finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES['uploadFile']['tmp_name']) == "application/zip")
                    {
                        $zipFiles = $this->LoadZipIntoArray(zip_open($_FILES['uploadFile']['tmp_name']));
                        $quizFiles = $this->GetBB6QuizFiles($zipFiles['imsmanifest.xml']);
                        foreach ($quizFiles as $quizFile)
                        {
                            $quizData = preg_replace('~\s*(<([^>]*)>[^<]*</\2>|<[^>]*>)\s*~','$1', $zipFiles[(string)$quizFile['identifier'].'.dat']);
                            $quizData = str_replace('\r\n', "", $quizData);
                            $quiz = MoodleImporter\Quiz::GetQuizFromBB6XML($quizData);
                            
                        }
                    }
                    else // ... or if the user uploaded just the dat file.
                    {
                        $fileData = file_get_contents($_FILES['uploadFile']['tmp_name']);
                        $quiz = MoodleImporter\Quiz::GetQuizFromBB6XML($fileData);
                    }
                } 
                else 
                {
                    //... file upload failed, output error message, etc...
                    $this->index();
                }
            }
            else 
            {
                //... no upload at all, not even an attempt
                $this->index();
            } 
        }
        else 
        {
            //.... not in a POST environment, so can't possibly have a file upload ...
            $this->index();
        }

        if ($quiz != null)
        {
            $_SESSION['quiz'] = $quiz;
            $Data = array();
            $Data['quiz'] = $quiz;
            $this->load->view('converthtml/review', $Data);
        }
        else
        {
            echo "Error processing file";
        }
    }
    
    private function LoadZipIntoArray($zip)
    {
        $zipFiles = array();
        if ($zip)
        {
            while ($zip_entry = zip_read($zip))
            {
                if (zip_entry_open($zip, $zip_entry, "r"))
                {
                    $name = zip_entry_name($zip_entry);
                    $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                    $zipFiles[$name] = $buf;
                }
            }
            zip_close($zip);
        }
        return $zipFiles;
    }
    
    private function GetBB6QuizFiles($manifestXML)
    {
        $manifestElement = new SimpleXMLElement($manifestXML);
        if ($manifestElement)
        {
            $quizFiles = $manifestElement->xpath('/manifest//resource[@type=\'assessment/x-bb-qti-test\' or @type=\'assessment/x-bb-qti-pool\']');
        }
        return $quizFiles;
    }
}

?>
