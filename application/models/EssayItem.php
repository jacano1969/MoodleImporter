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
       // Essay questions do not have answers that get output to Moodle XML
       $xmlValue = <<<ESSAY_XML
       <question type="essay">
            <name>
                <text>$this->Name</text>
            </name>
            <questiontext format="html">
                <text><![CDATA[$this->Text]]></text>
            </questiontext>
            <defaultgrade>$this->PointValue</defaultgrade>
       </question>
ESSAY_XML;
       return new \SimpleXMLElement($xmlValue);
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
        $htmlValue = <<<ESSAY_HTML
        <p>Name: $this->Name</p>
        <p>Question Text: $this->Text</p>
ESSAY_HTML;
        return $htmlValue;
    }


    
}

?>
