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
    
    private $SupportedImageTypes = array('png', 'jpg', 'gif');
    
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
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_FILES['uploadFile'])) && ($_FILES['uploadFile']['error'] === UPLOAD_ERR_OK))
        {
            // See if the user uploaded a zip file...
            if (finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES['uploadFile']['tmp_name']) == "application/zip")
            {
                $zipFiles = $this->LoadZipIntoArray(zip_open($_FILES['uploadFile']['tmp_name']));
                $quizFiles = $this->GetBB6QuizFiles(MoodleImporter\clean_xml($zipFiles['imsmanifest.xml']));
                foreach ($quizFiles as $quizFile)
                {
                    // Blackboard does weird things to the XML files, so we have
                    // clean them up before we can import them.
                    $quizData = MoodleImporter\clean_xml($zipFiles[(string)$quizFile['identifier'].'.dat']);
                    
                    // Since blackboard import files can have multiple xml files 
                    // in them containing tests, we need to merge in the second
                    // and following quizzes.
                    if ($quiz == null)
                    {
                        $quiz = MoodleImporter\Quiz::GetQuizFromBB6XML($quizData);
                    }
                    else
                    {
                        $quiz->Merge(MoodleImporter\Quiz::GetQuizFromBB6XML($quizData));
                    }

                    // Now we have the quiz, so we have to import the 
                    // image data into where each file is referenced
                    // Start by iterating through all the known image 
                    // types png/gif/jpg that have been uploaded in the zip file
                    foreach ($zipFiles as $zipName => $zipFile)
                    {
                        if (in_array(substr($zipName, -3), $this->SupportedImageTypes))
                        {
                            $quiz->ReplaceTextInQuiz($zipName, $this->CreateImageSrc($zipFile, substr($zipName, -3)));
                        }
                    }
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
            //.... not in a POST environment, or file didn't upload
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
            // @todo Need to add error checking and validation to quiz conversion process
            $this->index();
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
                    if (substr($name, 0, 8) != "__MACOSX")
                    {
                        $zipFiles[$name] = $buf;
                    }
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
    
    private function CreateImageSrc($imageFile, $type)
    {
        $imageData = base64_encode($imageFile);
        $tag = "data:image/$type;base64,$imageData";
        return $tag;
    }
}

?>
