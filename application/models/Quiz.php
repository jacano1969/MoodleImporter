<?php

namespace MoodleImporter;

/**
 * Represents a Moodle quiz
 * @package MoodleXMLImporter
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
     * This is a factory method used to create a Quiz object based on the contents
     * of the $htmlQuiz parameter. The $htmlQuiz parameter should conform to the 
     * import specifications located here:
     * @tutorial Quiz.cls
     * @param string $htmlQuiz
     * @return Quiz
     */
    public static function GetQuizFromHTML($htmlQuiz)
    {
        // First get rid of all unneeded whitespace not inside any tags
        $quizString = preg_replace('~\s*(<([^>]*)>[^<]*</\2>|<[^>]*>)\s*~','$1',$htmlQuiz);
        
        // Then split the incoming string based on the <h2> tags that flag the 
        // start of a question
        $quizArray = explode('<h2>', $quizString);

        // Explode has the side effect of creating a 0 entry for the <h2> tag
        // itself, so we delete it from the array and re-normalize the indexes
        unset($quizArray[0]);
        $quizArray = array_values($quizArray);
        
        $quiz = new Quiz;

        // Explode also removes the <h2> tag from each element, so we need to
        // append it back in for each element, so that we can use regex properly
        for ($i = 0; $i < count($quizArray); $i++)
        {
            $quizArray[$i] = '<h2>' . $quizArray[$i];
    
            // Find the content between <h2> and </h2>
            $regexp = '/<h2>(.*)<\/h2>/Ui'; 
            preg_match($regexp, $quizArray[$i], $questionName);

            // Get the question text, which is all text between the closing
            // </h2> tag and the last <ol> or <ul> tag.
            $regexp = '/<\/h2>([.\S\s]*)<[ou]l>[.\S\s]*$/i';
            preg_match($regexp, $quizArray[$i], $questionText);
            
            
            // @todo Get matching options to work, which will be inside dt tags
            // Get the answer options, which should be contained in <ol> or <ul>
            // tags, but we have to get the last set of <ol> or <ul> tags,
            // because the question text itself could contain them.
            $regexp = '/[.\S\s]*((<[ou]l>)[.\S\s]*)$/i';
            preg_match($regexp, $quizArray[$i], $questionAnswer);
            
            var_dump($questionAnswer[1]);

        }
        
        
        /** 
         * @todo What if Essay question contains a bulleted or numbered list?
         * 
         */
                
        
        
        return $quiz;
    }
    
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
