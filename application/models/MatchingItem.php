<?php
namespace MoodleImporter;
include_once 'Item.php';

/**
 * This class represents a Matching item that can be associated with a Quiz
 * object.
 *
 * @author John D. Delano
 */
class MatchingItem extends Item
{
    /**
     * Contains a list of options for the matching set. This is an associative
     * array that contains each term as the key and the term's associated
     * definition as the key's value.
     * @var array($term => $definition) 
     */
    public $Options = array();
    
    /**
     * Converts the Matching item represented by this object to the corresponding
     * XML element that can be used for export to Moodle.
     * @return \SimpleXMLElement 
     */
    public function ToXMLElement()
    {
        $xmlValue = <<<MATCHING_XML
       <question type="matching">
        <name>
         <text>$this->Name</text>
        </name> 
        <defaultgrade>
            $this->PointValue
        </defaultgrade>
MATCHING_XML;
        foreach ($this->Options as $term => $definition)
        {
            $xmlValue .= <<<MATCHING_XML
            <subquestion>
                <text>
                    $term
                </text>
                <answer>
                    $definition
                </answer>
            </subquestion>
            
MATCHING_XML;
        }
        
        $xmlValue .= <<<MATCHING_XML
        </question>
MATCHING_XML;
        
       return new \SimpleXMLElement($xmlValue); 
    }
}

?>
