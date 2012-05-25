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
     * Unique ID value of this Item that is used to distinguish this item
     * from other items within the same quiz. This not exported in the Moodle XML.
     * @var string 
     */
    public $ID = "001";
    
    /**
     * Specifies the name of the item, which is shown in the list of Questions 
     * in Moodle, when viewing the question bank. This is not the same as the
     * question text, and it is typically NOT shown to the student. 
     * @var string 
     */
    public $Name = "";
    
    /**
     * Specifies the actual text of the question that should be displayed to 
     * the student. This property is wrapped in a CDATA tag to allow the use
     * of HTML code.
     * @var string 
     */
    public $Text = "";
    
    /**
     * Specifies the default value to assign to this item. Note that this value
     * may be overriden by the Quiz object.
     * @var int 
     */
    public $PointValue = 1;
    
    // Methods
    /**
     * Converts the Item object to a SimpleXMLElement object.
     * @return \SimpleXMLElement 
     * @abstract
     */
    public abstract function ToXMLElement();
    
    /**
     * Converts the Item object to be displayed in HTML format.
     * @return string
     * @abstract 
     */
    public abstract function ToHTML();
      
}

?>
