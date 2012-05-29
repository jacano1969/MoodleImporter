<?php
namespace MoodleImporter;
include_once 'Item.php';

/**
 * This class represents an Essay item that can be associated with a Quiz
 * object.
 * @package MoodleXMLImporter
 * @author John D. Delano
 */
class EssayItem extends Item
{
    /**
     * GetPrefix
     * 
     * Returns the two-letter prefix for this item type.
     * @return string 
     */
    public function GetPrefix()
    {
        return "ES";
    }

    
    /**
     * ToXMLElement
     * 
     * Converts this Essay item into a SimpleXMLElement object corresponding 
     * to the "question" tag in the Moodle XML export file. Overrides the same
     * method name in the Item class.
     * @return \SimpleXMLElement 
     */
    public function ToXMLElement()
    {
       $xmlElement = parent::ToXMLElement();
       $xmlElement->addAttribute('type', "essay");
       return $xmlElement;
    }
    
    /**
     * ToHTML
     * 
     * Converts the item represented by this object to a corresponding HTML
     * representation that can be used for display on a web page. Overrides the 
     * same method name in the Item class.
     * @return string 
     */
    public function ToHTML()
    {
        return parent::ToHTML();
    }


    
}

?>
