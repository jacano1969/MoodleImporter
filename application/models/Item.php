<?php
namespace MoodleImporter;
require_once 'IExporter.php';

/**
 * Item
 * 
 * The base class of all Item objects. This class is abstract, so it cannot be
 * instantiated. To add new question types, create a new, concrete class
 * based on this Item class, and implement the ToXMLElement method.
 * 
 * @package MoodleXMLImporter
 * @abstract
 * @author John D. Delano
 */
abstract class Item implements IExporter {

    // PROPERTIES
    
    /**
     * ID
     * 
     * Unique ID value of this Item that is used to distinguish this item
     * from other items within the same quiz. This not exported in the Moodle XML.
     * @var int 
     */
    public $ID = 1;
    
    /**
     * Title
     * 
     * The title assigned to this item, which shows up as part of the Item's name.
     * @var string 
     */
    public $Title = "";
    
    /**
     * Text
     * 
     * Specifies the actual text of the question that should be displayed to 
     * the student. This property is wrapped in a CDATA tag to allow the use
     * of HTML code.
     * @var string 
     */
    public $Text = "";
    
    /**
     * PointValue
     * 
     * Specifies the default value to assign to this item. Note that this value
     * may be overriden by the Quiz object.
     * @var int 
     */
    public $PointValue = 1;
    
    /**
     * CorrectFeedback 
     * 
     * Specifies the text to display to the student, after they get this item
     * correct.
     * 
     * @var string
     */
    public $CorrectFeedback = "";
    
    /**
     * IncorrectFeedback
     * 
     * Specifies the text to display to the student, after they get this item
     * incorrect.
     * 
     * @var string 
     */
    public $IncorrectFeedback = "";
    
    
    // METHODS

    /**
     * GetName
     * 
     * Specifies the name of the item, which is shown in the list of Questions 
     * in Moodle, when viewing the question bank. This is not the same as the
     * question text, and it is typically NOT shown to the student. 
     * 
     * Format of the name is: "TF 001 - First five words of item"
     * 
     * @var string 
     */
    public function GetName()
    {
        // The name of the item depends on whether the title contains the text
        // "N/A" or is blank. If either of those are the case, then the Name
        // should include the first five words of the item's text; otherwise
        // the Title of the item is used as part of the name.
        if (!$this->Title || $this->Title == "N/A" || $this->Title == "")
        {
            // Get the first five words of the question's text to use later for the
            // question's name.
            $text = implode(" ", array_splice(preg_split( "/\s+/", preg_replace('/<[\/]?[^>]+>/i', " ", $this->Text)), 0, 5));
        }
        else
        {
            $text = $this->Title;
        }
        // Format of the name is: "TF 001 - First five words of item"
        return $this->GetPrefix() . ' ' . sprintf("%03d", $this->ID) . ' - ' . $text;
    }
    

    /**
     * GetPrefix
     * 
     * Returns the two-letter prefix used for naming this item.
     * @return string
     * @abstract
     */
    public abstract function GetPrefix();

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
     * @param int $itemID
     * @return void
     */
    public function ImportBB6XML(\SimpleXMLElement $bb6XML, $itemID)
    {
        $this->ID = $itemID;

        // The following xpath query looks for the question's text in the mattext
        // or mat_formattedtext child nodes that are not under the FILE_BLOCK or
        // LINK_BLOCK flow nodes, but that is under the QUESTION_BLOCK flow node.
        $text = $bb6XML->xpath('presentation//flow[@class=\'QUESTION_BLOCK\']//material[not(ancestor::flow[@class=\'FILE_BLOCK\'] or ancestor::flow[@class=\'LINK_BLOCK\'])]//*[mattext or mat_formattedtext]/*');
        $this->Text = trim((string)$text[0]);
        //$title = $bb6XML->xpath('item');
        $this->Title = (string)$bb6XML['title'];
        
        // Now get the feedback under the itemfeedback tag where attribute ident
        // equals either correct or incorrect.
        $correctFeedback = $bb6XML->xpath('itemfeedback[@ident=\'correct\']//material[not(ancestor::flow[@class=\'FILE_BLOCK\'] or ancestor::flow[@class=\'LINK_BLOCK\'])]//*[mattext or mat_formattedtext]/*');
        $this->CorrectFeedback = (string)$correctFeedback[0];
        $incorrectFeedback = $bb6XML->xpath('itemfeedback[@ident=\'incorrect\']//material[not(ancestor::flow[@class=\'FILE_BLOCK\'] or ancestor::flow[@class=\'LINK_BLOCK\'])]//*[mattext or mat_formattedtext]/*');
        $this->IncorrectFeedback = (string)$incorrectFeedback[0];
    }
    
    /**
     * ToXMLElement
     * 
     * Converts the Item object to a SimpleXMLElement object.
     * @return \SimpleXMLElement 
     */
    public function ToXMLElement()
    {
        $name = htmlspecialchars($this->GetName());
        $xml = <<<ITEM_XML
        <question>
            <name>
                <text>{$name}</text>
            </name>
            <questiontext format="html">
                <text><![CDATA[$this->Text]]></text>
            </questiontext>
            <defaultgrade>$this->PointValue</defaultgrade>
        </question>
ITEM_XML;
       return new \SimpleXMLElement($xml);
    }
    
    /**
     * ToHTML
     * 
     * Converts the Item object to be displayed in HTML format.
     * @return string
     */
    public function ToHTML()
    {
        $htmlValue = <<<HTML
        <p>Name: {$this->GetName()}</p>
        <p>Question Text: $this->Text</p>
HTML;
        
        return $htmlValue;

    }
}

?>
