<?php

namespace MoodleImporter;

/**
 * The base class of all Item objects. This class is abstract, so it cannot be
 * instantiated. To add new question types, create a new, concrete class
 * based on this Item class, and implement the ToXMLElement method.
 * @package MoodleXMLImporter
 * @abstract
 * @author John D. Delano
 */
abstract class Item {
    // Properties
    
    /**
     * Specifies the name of the item, which is shown in the list of Questions 
     * in Moodle, when viewing the question bank. This is not the same as the
     * question text, and it is typically NOT shown to the student. 
     * @var string 
     */
    public $Name;
    
    /**
     * Specifies the actual text of the question that should be displayed to 
     * the student. This property is wrapped in a CDATA tag to allow the use
     * of HTML code.
     * @var string 
     */
    public $Text;
    
    /**
     * Specifies the default value to assign to this item. Note that this value
     * may be overriden by the Quiz object.
     * @var int 
     */
    public $PointValue;
    
    // Methods
    /**
     * Converts the Item object to a SimpleXMLElement object.
     * @return \SimpleXMLElement 
     * @abstract
     */
    public abstract function ToXMLElement();
      
}

?>
