<?php
namespace MoodleImporter;

/**
 * IExporter
 * 
 * Interface that defines the methods supported by objects that can export
 * their contents to a SimpleXMLElement and to HTML.
 * 
 * @author John D. Delano
 * @package MoodleXMLImporter
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
