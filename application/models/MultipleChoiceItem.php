<?php
namespace MoodleImporter;
include_once 'Item.php';

/**
 * This class represents a Multiple Choice item that can be associated with a Quiz
 * object.
 *
 * @author John D. Delano
 */
class MultipleChoiceItem extends Item
{
    /**
     * Determines whether or not the possible answer choices should be allowed
     * to shuffle, when Moodle presents the quiz to the student.
     * @var bool
     */
    public $ShuffleAnswers = false;
    
    /**
     * Identifies whether or not this item allows students to select more than 
     * one answer. When set to true, Moodle will use radio buttons, but when set
     * to false, Moodle will use checkboxes. Normally, this option is set to 
     * true, but when the Team-based learning template is applied, this is set 
     * to false.
     * @var bool 
     */
    public $SingleSelection = true;
    
    /**
     * Determines the numbering scheme used to display the options for this item.
     * Allowed values are: "none", "abc", "ABCD", or "123"
     * @var string 
     */
    public $AnswerNumbering = "abc";
    
    /**
     * Contains an array of MultipleChoiceOption objects.
     * @uses MultipleChoiceOption
     * @var array(MultipleChoiceOption)
     */
    public $Options = array();
    
    /**
     * Converts this Multiple Choice item into a SimpleXMLElement object corresponding 
     * to the "question" tag in the Moodle XML export file.
     * @return \SimpleXMLElement 
     */
    public function ToXMLElement()
    {
        var_dump($this->SingleSelection);
        $shuffleAnswersValue = $this->ShuffleAnswers ? 1 : 0;
        $singleValue = $this->SingleSelection ? "true" : "false";
        
        $xmlValue = <<<MC_XML
            <question type="multichoice">
            <name>
                <text>$this->Name</text>
            </name>
            <questiontext format="html">
                <text><![CDATA[$this->Text]]></text>
            </questiontext>
            <shuffleanswers>$shuffleAnswersValue</shuffleanswers>
            <single>$singleValue</single>
            <answernumbering>$this->AnswerNumbering</answernumbering>
        </question>
MC_XML;
        
        $xmlElement = new \SimpleXMLElement($xmlValue);
        
        foreach ($this->Options as $option)
        {
            sxml_append($xmlElement, $option->ToXMLElement());
        }
        
        return $xmlElement;
    }
}

?>
