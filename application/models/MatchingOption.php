<?php

namespace MoodleImporter;
/**
 * MatchingOption
 * 
 * This class represents one option for a MatchingItem.
 * @package MoodleXMLImporter
 * @author John D. Delano
 */
class MatchingOption implements IExporter  {
    
    /**
     * Text
     * 
     * Contains the text of the answer choice.
     * @var string 
     */
    public $Text = "";
    
 
    /**
     * Value
     * 
     * Represents the percent value associated with this particular item.
     * Normally, this value is either 100 or 0, but the values may differ, when
     * the Team-Based Learning template is applied.
     * @var string 
     */
    public $Value = "";
    

    /**
     * __construct
     * 
     * Constructor for the MatchingOption class that allows the specification
     * of the text and value during instantiation. If no values are provided,
     * for either, then an empty string is assigned to the respective property.
     * 
     * @param string $text
     * @param string $value 
     */
    public function __construct($text = "", $value = "")
    {
        $this->Text = $text;
        $this->Value = $value;
    }
    
    
    /**
     * ToXMLElement
     * 
     * Converts this MultipleChoiceOption into a SimpleXMLElement object corresponding 
     * to the "answer" tag in the Moodle XML export file.
     * @return \SimpleXMLElement 
     */ 
    public function ToXMLElement()
    {
        $xmlValue = <<<OPTION_XML
        <subquestion>
            <text>
                <![CDATA[$this->Text]]>
            </text>
            <answer>
                <![CDATA[$this->Value]]>
            </answer>
        </subquestion>

OPTION_XML;
        return new \SimpleXMLElement($xmlValue);
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
        $htmlValue = <<<MCOPTION_HTML
        <dt>$this->Text</dt><dd>$this->Value</dd>
MCOPTION_HTML;
        return $htmlValue;

    }

}

?>
