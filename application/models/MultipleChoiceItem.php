<?php
namespace MoodleImporter;
require_once 'Item.php';
require_once 'ISupportTBL.php';

/**
 * MultipleChoiceItem
 * 
 * This class represents a Multiple Choice item that can be associated with a Quiz
 * object.
 * 
 * @package MoodleXMLImporter
 * @author John D. Delano
 */
class MultipleChoiceItem extends Item implements ISupportTBL
{
    /**
     * ShuffleAnswers
     * 
     * Determines whether or not the possible answer choices should be allowed
     * to shuffle, when Moodle presents the quiz to the student.
     * @var bool
     */
    public $ShuffleAnswers = false;
    
    /**
     * SingleSelection
     * 
     * Identifies whether or not this item allows students to select more than 
     * one answer. When set to true, Moodle will use radio buttons, but when set
     * to false, Moodle will use checkboxes. Normally, this option is set to 
     * true, but when the Team-based learning template is applied, this is set 
     * to false.
     * @var bool 
     */
    public $SingleSelection = true;
    
    /**
     * AnswerNumbering
     * 
     * Determines the numbering scheme used to display the options for this item.
     * Allowed values are: "none", "abc", "ABCD", or "123"
     * @var string 
     */
    public $AnswerNumbering = "ABCD";
    
    /**
     * Options
     * 
     * Contains an array of MultipleChoiceOption objects.
     * @uses MultipleChoiceOption
     * @var array(MultipleChoiceOption)
     */
    public $Options = array();
    
    
    /**
     * GetPrefix
     *   
     * Returns the two-letter prefix for this item type.
     * @return string 

     * @return string 
     */
    public function GetPrefix()
    {
        return "MC";
    }

    
    /**
     * ToXMLElement
     * 
     * Converts this Multiple Choice item into a SimpleXMLElement object corresponding 
     * to the "question" tag in the Moodle XML export file.
     * @return \SimpleXMLElement 
     */
    public function ToXMLElement()
    {
        // Moodle XML format expects the shuffle answers element to contain 0
        // for false and 1 for true.
        $shuffleAnswersValue = ($this->ShuffleAnswers == false || $this->ShuffleAnswers == 0) ? 0 : 1;
        
        // Moodle XML format expects the single selection element to contain
        // "true" for true and "false" for false.
        $singleValue = $this->SingleSelection ? "true" : "false";
        
        $xmlElement = parent::ToXMLElement();
        $xmlElement->addAttribute("type", "multichoice");
        $xmlElement->addChild("shuffleanswers", $shuffleAnswersValue);
        $xmlElement->addChild("single", $singleValue);
        $xmlElement->addChild("answernumbering", $this->AnswerNumbering);

        // Add feedback elements if there's feedback text available.
        if ($this->CorrectFeedback != "")
        {
            $feedbackElement = <<<FEEDBACK
            <correctfeedback format="html">
                <text>
                    <![CDATA[$this->CorrectFeedback]]>
                </text>
            </correctfeedback>
FEEDBACK;
            sxml_append($xmlElement, new \SimpleXMLElement($feedbackElement));
        }

        if ($this->IncorrectFeedback != "")
        { 
            $feedbackElement = <<<FEEDBACK
            <incorrectfeedback format="html">
                <text>
                    <![CDATA[$this->IncorrectFeedback]]>
                </text>
            </incorrectfeedback>
FEEDBACK;
            sxml_append($xmlElement, new \SimpleXMLElement($feedbackElement));

        }
        // Add option elements as child nodes
        foreach ($this->Options as $option)
        {
            sxml_append($xmlElement, $option->ToXMLElement());
        }
        
        return $xmlElement;
    }
    
    /**
     * ApplyTBLTemplate
     * 
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
        return true;
    }
    
    /**
     * ToHTML
     * 
     * Converts the item represented by this object to a corresponding HTML
     * representation that can be used for display on a web page.
     * @return string 
     */
    public function ToHTML()
    {
        $htmlValue = parent::ToHTML(); //"<p>$this->Name</p><p>$this->Text</p>
        $htmlValue .= "<ol type=\"A\">";
        
        foreach ($this->Options as $option)
        {
            $htmlValue .= $option->ToHTML();
        }
        
        $htmlValue .= '</ol>';
        return $htmlValue;
    }


    /**
     * ImportBB6XML
     * 
     * Converts the given <item> element that is retrieved from a Blackboard 6
     * export file, and retrieves the properties associated with this class. 
     * This method should be overridden in child classes, but should be called
     * first in the child's implementation with parent::ImportBB6XML($bb6XML).
     * The $itemID parameter specifies which number this item is within the quiz
     * array of items.
     * 
     * @param \SimpleXMLElement $bb6XML
     * @param string $itemID 
     * @return void
     */
    public function ImportBB6XML(\SimpleXMLElement $bb6XML, $itemID)
    {
        parent::ImportBB6XML($bb6XML, $itemID);

        // Options are located under the response_label node under the 
        // RESPONSE_BLOCK flow node
        $optionList = $bb6XML->xpath('presentation//flow[@class=\'RESPONSE_BLOCK\']//response_label');

        $correctOption = $bb6XML->xpath('resprocessing//respcondition[@title=\'correct\']//varequal');
        $correctOption = (string)$correctOption[0];
        $optionArray = array();
        foreach ($optionList as $optionElement)
        {
            $optionID = (string)$optionElement['ident'];
            $optionText = $optionElement->xpath('flow_mat//child::*[mattext or mat_formattedtext]/*');
            $option = new MultipleChoiceOption((string)$optionText[0], ($optionID == $correctOption) ? 100 : 0);
            $this->Options[] = $option;
        }
    }
    
}

?>
