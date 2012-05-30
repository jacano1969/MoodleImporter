<?php

namespace MoodleImporter;


require_once APPPATH . '/models/Item.php';
require_once APPPATH . '/models/EssayItem.php';
require_once APPPATH . '/models/MatchingItem.php';
require_once APPPATH . '/models/MatchingOption.php';
require_once APPPATH . '/models/MultipleChoiceItem.php';
require_once APPPATH . '/models/MultipleChoiceOption.php';
require_once APPPATH . '/models/TrueFalseItem.php';
require_once APPPATH . '/models/XMLUtilities.php';
require_once APPPATH . '/models/ISupportTBL.php';

/**
 * Represents a Moodle quiz
 * 
 * @package MoodleXMLImporter
 * @author John D. Delano
 */
class Quiz  {
    
    /**
     * Category
     * 
     * The category of the quiz, as it should appear in Moodle under the course
     * in which the quiz is imported.
     * @var string
     */
    public $Category;  
    
    /**
     * ApplyTBLTemplate
     * 
     * Specifies whether or not to apply the Team-Based Learning template.
     * @var bool
     */
    public $ApplyTBLTemplate;
    
    /**
     * Items
     * 
     * Collection of Item objects associated with this quiz.
     * @uses Item
     * @var array
     */
    public $Items = array();
    
    
    /**
     * GetQuizFromHTML
     * 
     * This is a factory method used to create a Quiz object based on the contents
     * of the $htmlQuiz parameter. The $htmlQuiz parameter should conform to the 
     * import specifications located here:
     * @tutorial Quiz.cls
     * @param string $htmlQuiz
     * @return Quiz
     */
    public static function GetQuizFromHTML($htmlQuiz)
    {
        $essayQuestion = false;
        
        // First get rid of all unneeded whitespace not inside any tags
        $quizString = preg_replace('~\s*(<([^>]*)>[^<]*</\2>|<[^>]*>)\s*~','$1',$htmlQuiz);
        
        // Then split the incoming string based on the <h2> tags that flag the 
        // start of a question
        $quizArray = explode('<h2>', $quizString);

        // Explode has the side effect of creating a 0 entry for the initial 
        // <h2> tag itself, so we delete it from the array and re-normalize the 
        // indexes
        unset($quizArray[0]);
        $quizArray = array_values($quizArray);
        
        $quiz = new Quiz;

        // Now loop through all the items in the array and add them to the quiz
        for ($itemNumber = 0; $itemNumber < count($quizArray); $itemNumber++)
        {
            // Explode removes the <h2> tag from each item, so we find the 
            // content between the start of the string '^' and </h2>
            $regexp = '/^([.\S\s]*)<\/h2>/Ui'; 
            $questionName = null;
            preg_match($regexp, $quizArray[$itemNumber], $questionName);
            if ($questionName == null) break;
            
            // Get the question text, which is all text between the closing
            // </h2> tag and the last <ol> or <ul> tag.
            $regexp = '/<\/h2>([.\S\s]*)<[oud]l>[.\S\s]*(?<!(<br \/>))$/i';
            $questionText = null;
            preg_match($regexp, $quizArray[$itemNumber], $questionText);
            if (sizeof($questionText) == 0) 
            {
                $regexp = '/<\/h2>([.\S\s]*)<br[\s]?\/>/Ui';
                $questionText = null;
                preg_match($regexp, $quizArray[$itemNumber], $questionText);
                $essayQuestion = true;
            }
            
            if ($questionName[1] == 'N/A')
            {
                // If the question name is set to N/A, set the questionName to the
                // first five words of the question's text
                $questionName[1] = implode(" ", array_splice(preg_split( "/\s+/", preg_replace('/<[\/]?[^>]+>/i', " ", $questionText[1])), 0, 5));
            }
            
            if ($essayQuestion)
            {
                $item = new EssayItem();
                $item->ID = sprintf("%03d", $itemNumber + 1);
                $item->Name = $item->GetPrefix() . ' ' . $item->ID . ' - ' . $questionName[1];
                $item->Text = $questionText[1];
                $item->PointValue = 1;
                $quiz->Items[] = $item;
            }
            else
            {
                // Get the answer options, which should be contained in <dl>, <ol> or <ul>
                // tags, but we have to get the last set of <dl>, <ol> or <ul> tags,
                // because the question text itself could contain them.
                $regexp = '/[.\S\s]*((<[oud]l>)[.\S\s]*)<\/[oud]l>$/i';
                $questionAnswer = null;
                preg_match($regexp, $quizArray[$itemNumber], $questionAnswer);
                if ($questionAnswer == null) break;

                // Now separate out all the answer options, which will appear between
                // <li> and </li> tags.
                $regexp = '/<li>([.\S\s]*)<\/li>/Ui';
                $options = null;
                preg_match_all($regexp, $questionAnswer[1], $options);
                if (sizeof($options[1]) == 0)
                {
                    $regexp = '/<dt>([.\S\s]*)<\/dt><dd>([.\S\s]*)<\/dd>/Ui';
                    $options = null;
                    preg_match_all($regexp, $questionAnswer[1], $options);
                    $item = new MatchingItem();
                    $item->ID = sprintf("%03d", $itemNumber + 1);
                    $item->Name = $item->GetPrefix() . ' ' . $item->ID . ' - ' . $questionName[1];
                    $item->Text = $questionText[1];
                    $item->PointValue = 1;

                    for ($j = 0; $j < count($options[1]); $j++)
                    {
                        $item->Options[] = new MatchingOption($options[1][$j], $options[2][$j]);
                    }

                    $quiz->Items[] = $item;
                }
                else
                {
                    // preg_match_all creates a multidimensional array where the first 
                    // dimension contains the globally matched string in index 0 and
                    // an array of matched options in index 1. Since we don't care about
                    // the globally matched string, we delete it.
                    $options = $options[1];
                    // If there is only one answer, it could be a true/false item
                    if (count($options) == 1)
                    {
                        if (stristr($options[0], 't') || stristr($options[0], 'f'))
                        {
                            $item = new TrueFalseItem();
                            $item->ID = sprintf("%03d", $itemNumber + 1);
                            $item->CorrectAnswer = !stristr($options[0], 'f');
                            $item->Name = $item->GetPrefix() . ' ' . $item->ID . ' - ' . $questionName[1];
                            //$item->Name = sprintf("TF %03d - %s", $itemNumber + 1, $questionName[1]); 
                            $item->Text = $questionText[1];
                            $item->PointValue = 1;
                            $quiz->Items[] = $item;
                        }
                    }
                    else  // Otherwise, it must be multiple choice.
                    {
                        $item = new MultipleChoiceItem;
                        $item->ID = sprintf("%03d", $itemNumber + 1);
                        $item->Name = $item->GetPrefix() . ' ' . $item->ID . ' - ' . $questionName[1];
                        $item->Text = $questionText[1];
                        $item->PointValue = 1;

                        // If the questionAnswer options contain an <ol> (ordered list),
                        // then we do not want to shuffle answers; otherwise, we do.
                        $item->ShuffleAnswers = !stristr($questionAnswer[1], '<ol>');

                        // Loop through all the answer options and add them as 
                        // MultipleChoiceOption objects to the list of Items in the quiz
                        foreach ($options as $option)
                        {
                            $mcOption = new MultipleChoiceOption;

                            // See if this option is the correct one. Correct answers
                            // should appear between <strong> and </strong>.
                            $regexp = '/<strong>([.\S\s]*)<\/strong>/Ui'; 
                            $numberFound = preg_match($regexp, $option, $filteredAnswer);

                            // See if we found a correct answer:
                            if ($numberFound > 0)
                            {
                                // Option is correct, so grab the filtered option
                                // retrieved from preg_match
                                $mcOption->Text = $filteredAnswer[1];
                                $mcOption->Value = 100;
                            }
                            else
                            {
                                // Option is incorrect, so grab the unfiltered option
                                $mcOption->Text = $option;
                                $mcOption->Value = 0;
                            }
                            $item->Options[] = $mcOption;
                        }
                        // Add the newly created item to the quiz's list of Items
                        $quiz->Items[] = $item;
                    }
                }
            }
        }
        return $quiz;
    }
    
    /**
     * GetQuizFromBB6XML
     * 
     * This is a factory method designed to create a new quiz object based on
     * the contents of the supplied Blackboard 6.0+ XML file.
     * @param string $bb6XML
     * @return \MoodleImporter\Quiz 
     */
    public static function GetQuizFromBB6XML($bb6XML)
    {
        $quizElement = new \SimpleXMLElement($bb6XML);
        $quiz = new Quiz();
        
        // Get the quiz category -- same as the question pool in BB6
        $categoryElement = $quizElement->xpath('/questestinterop/assessment');
        $quiz->Category = (string)$categoryElement[0]['title'];

        // Get array of items in the quiz
        $items = $quizElement->xpath('//item');
        
        // Now process all the items in the quiz
        for ($index = 0; $index < count($items); $index++)
        {
            // First, get the question type of this item
            $questionType = $items[$index]->xpath('itemmetadata/bbmd_questiontype');
            $questionType = (string)$questionType[0];

            $item = null;
            switch($questionType)
            {
                case "Matching" : 
                    $item = new MatchingItem();
                    break;
                case "Multiple Choice" :                 
                    $item = new MultipleChoiceItem();
                    break; 
                case "Essay" : 
                    $item = new EssayItem();
                    break;
                case "Multiple Answer" : 
                    $item = new MultipleChoiceItem();
                    $item->SingleSelection = false;
                    break;
                case "True/False" : 
                    $item = new TrueFalseItem();
                    break;
                case "Fill in the Blank" : // @todo implement fill in question import
                    $item = new EssayItem();
                    break;
                case "Short Response" : // @todo implement short response question import
                    $item = new EssayItem();
                    break;
                default:  // ERROR: Could not find a valid question type, so break and fall through to next item.
                    break;
            }
            if ($item != null) 
            {
                // Delegate the processing of each quiz item to the respective
                // child class.
                $item->ImportBB6XML($items[$index], sprintf("%03d", $index + 1));
                $quiz->Items[] = $item;
            }
        }
        return $quiz;
    }
    
    /**
     * ToXMLString
     * 
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
            // Apply (or turn off) the team-based learning template for each 
            // item that supports TBL
            if ($item instanceof ISupportTBL)
            {
                $item->ApplyTBLTemplate($this->ApplyTBLTemplate);
            }
            sxml_append($returnValue, $item->ToXMLElement());
        }  
        
        return $returnValue->asXML();
    }
    
    
    /**
     * ReplaceTextInQuiz
     * 
     * Locates the text in $findText and replaces it with $replaceText in all
     * the question text and option text fields.
     * 
     * @param string $findText
     * @param string $replaceText 
     * @return void
     */
    public function ReplaceTextInQuiz($findText, $replaceText)
    {
        foreach ($this->Items as $item)
        {
            $item->Text = str_replace($findText, $replaceText, $item->Text);
            if (property_exists($item, "Options"))
            {
                foreach ($item->Options as $option)
                {
                    if (!is_array($option) && property_exists($option, "Text"))
                    {
                        $option->Text = str_replace($findText, $replaceText, $option->Text);
                    }
                    else
                    {
                        //$option = str_replace($findText, $replaceText, $option);
                    }
                }
            }
        }
    }
    
    
    /**
     * Merge
     * 
     * Merges the items from the specified quiz into $this quiz and returns 
     * $this quiz that contains the merged items.
     * 
     * @param \MoodleImporter\Quiz $quiz
     * @return \MoodleImporter\Quiz 
     */
    public function Merge(Quiz $quiz)
    {
        foreach ($quiz->Items as $item)
        {
            $this->Items[] = $item;
        }
        return $this;
    }
}

?>
