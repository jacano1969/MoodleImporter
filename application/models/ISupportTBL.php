<?php

namespace MoodleImporter;

/**
 *
 * @author jdelano
 */
interface ISupportTBL {
    
    /**
     * ApplyTBLTemplate
     * 
     * Overridden in the child class, if it supports the Team-Based Learning
     * template.
     * @return bool 
     */
    public function ApplyTBLTemplate($IsEnabled);
    
}

?>
