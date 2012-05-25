<?php
namespace MoodleImporter;
include_once 'Item.php';

/**
 * This class represents a Multiple Choice item that can be associated with a Quiz
 * object.
 * @package MoodleXMLImporter
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
    public $AnswerNumbering = "ABCD";
    
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
        $shuffleAnswersValue = ($this->ShuffleAnswers == false || $this->ShuffleAnswers == 0) ? 0 : 1;
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
            <defaultgrade>$this->PointValue</defaultgrade>
        </question>
MC_XML;
        
        $xmlElement = new \SimpleXMLElement($xmlValue);
        
        foreach ($this->Options as $option)
        {
            sxml_append($xmlElement, $option->ToXMLElement());
        }
        
        return $xmlElement;
    }
    
    /**
     * If the $IsEnabled parameter is set to true, this method applies the Team
     * based learning scoring rubric to this object. Specifically, single 
     * selection is disabled, and all incorrect answer choices are set to negative
     * penalty percentages, based on the total number of options in the item. 
     * 
     * If the $IsEnabled parameter is set to false, a normal scoring template is
     * applied. Specifically, single selection is enabled, and all incorrect
     * options are reset to a value of 0.
     * 
     * @param bool $IsEnabled 
     * @return void
     */
    public function ApplyTBLTemplate($IsEnabled)
    {
        // Set SingleSelection to the oppositie of what $IsEnabled is
        $this->SingleSelection = !$IsEnabled;
        
        $numOptions = count($this->Options);
        
        // Go through all the associated Options and reset their values to 
        // reflect the TBL template.
        foreach ($this->Options as $option)
        {
            if ($IsEnabled && $option->Value != 100)
            {
                $option->Value = -(100 / ($numOptions - 1));
            }
            else if (!$IsEnabled && $option->Value != 100)
            {
                $option->Value = 0;
            }
        }
    }
    
        /**
     * Converts the item represented by this object to a corresponding HTML
     * representation that can be used for display on a web page.
     * @return string 
     * @todo Implement ToHTML()
     */
    public function ToHTML()
    {
        $htmlValue = "<p>$this->Name</p><p>$this->Text</p><ol type=\"A\">";
        
        foreach ($this->Options as $option)
        {
            $htmlValue .= $option->ToHTML();
        }
        
        $htmlValue .= '</ol>';
        return $htmlValue;
    }

}

?>
