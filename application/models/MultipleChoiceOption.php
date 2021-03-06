<?php
namespace MoodleImporter;

/**
 * MultipleChoiceOption
 * 
 * This class represents one option for a MultipleChoiceItem.
 * 
 * @package MoodleXMLImporter
 * @author John D. Delano
 */
class MultipleChoiceOption implements IExporter  {
    
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
     * @var float 
     */
    public $Value = 0;
    

    /**
     * __construct
     * 
     * Constructor for the MultipleChoiceOption class that allows the specification
     * of the text and value during instantiation. If no values are provided,
     * for either, then an empty string (or 0.0) is assigned to the respective property.
     * 
     * @param string $text
     * @param float $value 
     */
    public function __construct($text = "", $value = 0.0)
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
        <answer fraction="$this->Value" format="html">
            <text><![CDATA[$this->Text]]></text>
        </answer>
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
        $strongOpenTag = $this->Value == 100 ? "<strong>":"";
        $strongCloseTag = $this->Value == 100 ? "</strong>" : "";
        $htmlValue = <<<MCOPTION_HTML
        <li>$strongOpenTag$this->Text$strongCloseTag</li>
MCOPTION_HTML;
        return $htmlValue;

    }

}

?>
