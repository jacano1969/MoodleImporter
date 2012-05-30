<?php
namespace MoodleImporter;

/**
 * ISupportTBL
 * 
 * Interface defines whether or not an object (usually an Item) supports a 
 * team-based learning scoring methodology.
 * 
 * @package MoodleXMLImporter
 * @author John D. Delano
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
