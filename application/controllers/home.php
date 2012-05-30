<?php

/**
 * home
 * 
 * Home controller that displays the initial landing page.
 *
 * @package MoodleXMLImporter
 * @author jdelano
 */
class home extends CI_Controller {

    /**
     * index
     * 
     * Index Page for this controller.
    */
    public function index()
    {
            $this->load->helper('url');
            $this->load->view('index');
    }
}

?>
