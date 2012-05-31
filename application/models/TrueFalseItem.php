<?php
namespace MoodleImporter;
include_once 'Item.php';

/**
 * TrueFalseItem
 * 
 * This class represents a True/False item that can be associated with a Quiz
 * object.
 * 
 * @package MoodleXMLImporter
 * @author John D. Delano
 */
class TrueFalseItem extends Item {
    
    /**
     * CorrectAnswer
     * 
     * Represents the correct answer for this true/false item. Value should be
     * either true or false.
     * @var bool
     */
    public $CorrectAnswer = false;
    
    /**
     * GetPrefix
     * 
     * Returns the two-letter prefix for this item type.
     * @return string 
     */
    public function GetPrefix()
    {
        return "TF";
    }
    
    /**
     * ToXMLElement
     * 
     * Converts this True/False item into a SimpleXMLElement object corresponding 
     * to the "question" tag in the Moodle XML export file.
     * @return \SimpleXMLElement 
     */
    public function ToXMLElement()
    {
        // Setup correct percentage values, depending on the correct answer
        $trueFraction = $this->CorrectAnswer ? 100 : 0;
        $falseFraction = $this->CorrectAnswer ? 0 : 100;
        $trueFeedback = $this->CorrectAnswer ? $this->CorrectFeedback : $this->IncorrectFeedback;
        $falseFeedback = $this->CorrectAnswer ? $this->IncorrectFeedback : $this->CorrectFeedback;
        
        $xmlElement = parent::ToXMLElement();
        $xmlElement->addAttribute("type", "truefalse");
        
        // Adding feedback elements to True/False questions is a bit more complicated
        // because Moodle only allows you to specify feedback for the true and
        // the false options. That means that we have to figure out which option
        // to apply which feedback. 
        $true = new \SimpleXMLElement("<answer fraction=\"$trueFraction\"><text>true</text></answer>");
        if ($trueFeedback != "")
        {
            $trueFeedbackText = <<<FEEDBACK
            <feedback>
                <text>
                    <![CDATA[$trueFeedback]]>
                </text>
            </feedback>
FEEDBACK;
            $trueFeedbackElement = new \SimpleXMLElement($trueFeedbackText);
            sxml_append($true, $trueFeedbackElement);
        }
        
        
        $false = new \SimpleXMLElement("<answer fraction=\"$falseFraction\"><text>false</text></answer>");
        if ($falseFeedback != "")
        {
            $falseFeedbackText = <<<FEEDBACK
            <feedback>
                <text>
                    <![CDATA[$falseFeedback]]>
                </text>
            </feedback>
FEEDBACK;
            $falseFeedbackElement = new \SimpleXMLElement($falseFeedbackText);
            sxml_append($false, $falseFeedbackElement);
        }

        sxml_append($xmlElement, $true);
        sxml_append($xmlElement, $false);
        return $xmlElement;
    }
    
    /**
     * ToHTML
     * 
     * Converts the item represented by this object to a corresponding HTML
     * representation that can be used for display on a web page.
     * 
     * @return string 
     */
    public function ToHTML()
    {
        $correctAnswer = $this->CorrectAnswer ? "TRUE" : "FALSE";
        $htmlValue = parent::ToHTML();
        $htmlValue .= "<p><strong>$correctAnswer</strong></p>";
        
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
        $correctOption = $bb6XML->xpath('resprocessing//respcondition[@title=\'correct\']//varequal');
        $this->CorrectAnswer = strtolower((string)$correctOption[0]) == 'true' ? true : false;
    }
}

?>
