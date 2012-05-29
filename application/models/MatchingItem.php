<?php
namespace MoodleImporter;
include_once 'Item.php';

/**
 * This class represents a Matching item that can be associated with a Quiz
 * object.
 * @package MoodleXMLImporter
 * @author John D. Delano
 */
class MatchingItem extends Item
{
    /**
     * Contains a list of options for the matching set. This is an associative
     * array that contains each term as the key and the term's associated
     * definition as the key's value.
     * @var array
     */
    public $Options = array();
    
    /**
     * GetPrefix
     * 
     * Returns the two-letter prefix for this item type.
     * @return string 
     */
    public function GetPrefix()
    {
        return "MT";
    }

    /**
     * ToXMLElement
     * 
     * Converts the Matching item represented by this object to the corresponding
     * XML element that can be used for export to Moodle.
     * @return \SimpleXMLElement 
     */
    public function ToXMLElement()
    {
        $xmlElement = parent::ToXMLElement();
        $xmlElement->addAttribute('type', "matching");

        // Now add each of the options
        foreach ($this->Options as $term => $definition)
        {
            $optionXML = <<<OPTION_XML
            <subquestion>
                <text>
                    <![CDATA[$term]]>
                </text>
                <answer>
                    <![CDATA[$definition]]>
                </answer>
            </subquestion>
OPTION_XML;
            sxml_append($xmlElement, new \SimpleXMLElement($optionXML));
        }

        return $xmlElement; 
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
        $htmlValue = parent::ToHTML();
        $htmlValue .= "<dl>";
        foreach ($this->Options as $term => $definition)
        {
            $htmlValue .= "<dt>$term</dt><dd>$definition</dd>";
        }
        $htmlValue .= '</dl>';
        
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
        $optionList = $bb6XML->xpath('presentation//flow[@class=\'RESPONSE_BLOCK\']//material[not(ancestor::flow[@class=\'FILE_BLOCK\'] or ancestor::flow[@class=\'LINK_BLOCK\'])]//child::*[mattext or mat_formattedtext]/*');
        $answerList = $bb6XML->xpath('presentation//flow[@class=\'RIGHT_MATCH_BLOCK\']//material[not(ancestor::flow[@class=\'FILE_BLOCK\'] or ancestor::flow[@class=\'LINK_BLOCK\'])]//child::*[mattext or mat_formattedtext]/*');
        $optionArray = array();
        for ($index = 0; $index < count($optionList); $index++)
        {
            $optionText = (string)$optionList[$index];
            $answerText = (string)$answerList[$index];
            $this->Options[] = array($optionText => $answerText);
        }
    }

}

?>
