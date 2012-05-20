<?php

namespace MoodleImporter;

/**
 * Represents a Moodle quiz
 *
 * @author John D. Delano
 */
class Quiz {
    /**
     * The category of the quiz, as it should appear in Moodle under the course
     * in which the quiz is imported.
     * @var string
     */
    public $Category;  
    
    /**
     * Determines whether or not the overriden point value should be applied to
     * all child questions.
     * @var bool 
     */
    public $OverridePointValues;
    
    /**
     * When OverridePointValues is set to true, the value stored in this property
     * will override the point values in all of the child items.
     * @var int
     */
    public $OverridenPointValue;
    
    /**
     * Specifies whether or not to apply the Team-Based Learning template.
     * @var bool
     */
    public $ApplyTBLTemplate;
    
    /**
     * Collection of Item objects associated with this quiz.
     * @uses Item
     * @var array
     */
    public $Items = array();
    
    
    /**
     * Generates the Moodle XML code that can be exported.
     * @return string 
     */
    public function ToXMLString()
    {
        // Prepare a generic quiz template
        $categoryValue = '$course$/'.$this->Category;
        $xmlValue = <<<QUIZ_XML
        <quiz>
            <question type="category">
                <category>
                    <text>$categoryValue</text>
                </category>
            </question>
        </quiz>    
QUIZ_XML;
        $returnValue = new \SimpleXMLElement($xmlValue);

        // Iterate through child items and add their elements as children of the quiz element.
        foreach ($this->Items as $item)
        {
            sxml_append($returnValue, $item->ToXMLElement());
        }  
        
        return $returnValue->asXML();
    }
}

?>
