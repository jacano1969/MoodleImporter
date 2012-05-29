<?php
namespace MoodleImporter;

/**
 *
 * @author jdelano
 */
interface IExporter 
{
    /**
     * ToXMLElement
     * 
     * Converts the Item object to a SimpleXMLElement object.
     * @return \SimpleXMLElement 
     */
    public function ToXMLElement();
    
    /**
     * ToHTML
     * 
     * Converts the Item object to be displayed in HTML format.
     * @return string
     */
    public function ToHTML();
    
}

?>
