<?php
namespace MoodleImporter;
include_once 'Item.php';

/**
 * This class represents a True/False item that can be associated with a Quiz
 * object.
 * @package MoodleXMLImporter
 * @author John D. Delano
 */
class TrueFalseItem extends Item {
    
    public $CorrectAnswer = false;
    
    /**
     * Converts this True/False item into a SimpleXMLElement object corresponding 
     * to the "question" tag in the Moodle XML export file.
     * @return \SimpleXMLElement 
     */
    public function ToXMLElement()
    {
        // Setup correct percentage values, depending on the correct answer
        $trueFraction = $this->CorrectAnswer ? 100 : 0;
        $falseFraction = $this->CorrectAnswer ? 0 : 100;
        
        $xmlValue = <<<ESSAY_XML
        <question type="truefalse">
                <name>
                    <text><![CDATA[$this->Name]]></text>
                </name>
                <questiontext format="html">
                    <text>$this->Text</text>
                </questiontext>
                <defaultgrade>
                    $this->PointValue
                </defaultgrade>
                <answer fraction="$trueFraction">
                    <text>true</text>
                </answer>
                <answer fraction="$falseFraction">
                    <text>false</text>
                </answer>
        </question>
ESSAY_XML;
        return new \SimpleXMLElement($xmlValue);
    }
}

?>
