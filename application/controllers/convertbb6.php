<?php
require_once APPPATH . '/models/Quiz.php';

/**
 * convertbb6
 * 
 * Controller class that provides the actions necessary to automate Use Case #1 -
 * the importing of Blackboard 6.0+ files and conversion to Moodle XML format.
 *
 * @package MoodleXMLImporter
 * @author John D. Delano
 */
class convertbb6 extends CI_Controller
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
     * SupportedImageTypes
     * 
     * Array containing the image types that are supported by Blackboard and
     * Moodle XML.
     * 
     * @var array 
     */
    private $SupportedImageTypes = array('png', 'jpg', 'gif');
    
    
    /**
     * index 
     * 
     * Displays the initial view, where the user can upload a Blackboard 6 zip
     * file.
     */
    public function index()
    {
        $this->load->view('convertbb6/index');
    }
    
    /**
     * review
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
        $quiz = null;
        // See if we got a file and if it uploaded okay.
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_FILES['uploadFile'])) && ($_FILES['uploadFile']['error'] === UPLOAD_ERR_OK))
        {
            // See if the user uploaded a zip file...
            if (finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES['uploadFile']['tmp_name']) == "application/zip")
            {
                $zipFiles = $this->LoadZipIntoArray(zip_open($_FILES['uploadFile']['tmp_name']));
                $quizFiles = $this->GetBB6QuizFiles(MoodleImporter\clean_xml($zipFiles['imsmanifest.xml']));
                foreach ($quizFiles as $quizFile)
                {
                    try
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
                    catch (Exception $exception)
                    {
                        echo 'ERROR: Could not import quiz file named: '.(string)$quizFile['identifier'].'.dat<br />';
                    }
                }
            }
            else // ... or if the user uploaded just the dat file.
            {
                try
                {
                    $fileData = file_get_contents($_FILES['uploadFile']['tmp_name']);
                    $quiz = MoodleImporter\Quiz::GetQuizFromBB6XML($fileData);
                }
                catch (Exception $exception)
                {
                    echo 'ERROR: Could not import quiz file.<br />';
                }
            }
        }
        else 
        {
            //.... not in a POST environment, or file didn't upload
            echo 'ERROR: Could not import the file provided, or no file was received. Please try again<br />';
        }

        if ($quiz != null)
        {
            $_SESSION['quiz'] = $quiz;
            $Data = array();
            $Data['quiz'] = $quiz;
            $this->load->view('converthtml/review', $Data);
        }
    }
    
    /**
     * LoadZipIntoArray
     * 
     * Helper function to convert the contents of a zip file into an array.
     * 
     * @param string $zip
     * @return array 
     */
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
    
    /**
     * GetBB6QuizFiles
     * 
     * Helper function that retrieves the list of Blackboard quiz files from the
     * manifest file.
     * 
     * @param string $manifestXML
     * @return array 
     */
    private function GetBB6QuizFiles($manifestXML)
    {
        $manifestElement = new SimpleXMLElement($manifestXML);
        if ($manifestElement)
        {
            $quizFiles = $manifestElement->xpath('/manifest//resource[@type=\'assessment/x-bb-qti-test\' or @type=\'assessment/x-bb-qti-pool\']');
        }
        return $quizFiles;
    }
    
    /**
     * CreateImageSrc
     * 
     * Helper function to create the contents of the src tag, given the byte stream
     * of an image file and it's file type. The image is base64 encoded and returned
     * 
     * @param file $imageFile
     * @param string $type
     * @return string 
     */
    private function CreateImageSrc($imageFile, $type)
    {
        $imageData = base64_encode($imageFile);
        $tag = "data:image/$type;base64,$imageData";
        return $tag;
    }
}

?>
