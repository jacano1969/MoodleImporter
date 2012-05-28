<?php

/**
 * Description of HomeController
 *
 * @package MoodleXMLImporter
 * @author jdelano
 */
class home extends CI_Controller {

    /**
    * Index Page for this controller.
    *
    */
    public function index()
    {
            $this->load->helper('url');
            $this->load->view('index');
    }
}

?>
