<?php

namespace MoodleImporter;
if (!defined('APPPATH'))
{
    define('APPPATH', dirname(__FILE__) . '/../../../application');
}

require_once APPPATH . '/models/Quiz.php';

/**
 * Test class for Quiz.
 * Generated by PHPUnit on 2012-05-18 at 22:10:42.
 */
class QuizTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers MoodleImporter\Quiz::ToXMLString
     */
    public function testToXMLString() {
        $quiz = new Quiz;
        $quiz->Category = "Quiz #1";
        $output = <<<'QUIZ_TEST'
        <quiz>
            <question type="category">
                <category>
                    <text>$course$/Quiz #1</text>
                </category>
            </question>
        </quiz>
QUIZ_TEST;
        
        $this->assertTrue(xml_is_equal(new \SimpleXMLElement($output), new \SimpleXMLElement($quiz->ToXMLString())));
    }
    
    /**
     * @covers MoodleImporter\Quiz::ToXMLString 
     */
    public function testToXMLStringEssayItem() {
        $essayItem = new EssayItem;
        $essayItem->Name = "ES 001 - What is";
        $essayItem->Text = "What is";
        $essayItem->PointValue = 2;
        $quiz = new Quiz;
        $quiz->Category = "Quiz #1";
        $quiz->Items[] = $essayItem;
        $output = <<<'QUIZ_TEST'
        <quiz>
            <question type="category">
                <category>
                    <text>$course$/Quiz #1</text>
                </category>
            </question>
            <question type="essay">
                <name>
                    <text>ES 001 - What is</text>
                </name>
                <questiontext format="html">
                    <text><![CDATA[What is]]></text>
                </questiontext>
                <defaultgrade>2</defaultgrade>
            </question>
        </quiz>
QUIZ_TEST;
        
        $this->assertTrue(xml_is_equal(new \SimpleXMLElement($output), new \SimpleXMLElement($quiz->ToXMLString())));
    }
    
    public function testGetQuizFromHTMLSimpleTrueFalse()
    {
        $inputHTML = <<<HTML_QUIZ
        <h2>TF false Question</h2>
        What is the answer to the following?
        <ul>
            <li>false</li>
        </ul>
HTML_QUIZ;
        $quiz = Quiz::GetQuizFromHTML($inputHTML);
        $this->assertEquals(1, count($quiz->Items));
        $this->assertEquals(false, $quiz->Items[0]->CorrectAnswer);
        $this->assertEquals("TF 001 - TF false Question", $quiz->Items[0]->Name);
        $this->assertEquals("What is the answer to the following?", $quiz->Items[0]->Text);
    }
        
    public function testGetQuizFromHTMLComplexTrueFalse()
    {
        $inputHTML = <<<HTML_QUIZ
        <h2>TF w/list in text</h2>
        What is the answer to the following sub-questions?
        <ul>
            <li>Question 1</li>
            <li>Question 2</li>
        </ul>
        <ul>
            <li>truth</li>
        </ul>
HTML_QUIZ;
        
        $quiz = Quiz::GetQuizFromHTML($inputHTML);
        $this->assertEquals(1, count($quiz->Items));
        $this->assertEquals(true, $quiz->Items[0]->CorrectAnswer);
        $this->assertEquals("TF 001 - TF w/list in text", $quiz->Items[0]->Name);
        $this->assertEquals("What is the answer to the following sub-questions?<ul><li>Question 1</li><li>Question 2</li></ul>", $quiz->Items[0]->Text);
    }
    
    public function testGetQuizFromHTMLComplexTrueFalseNA()
    {
        $inputHTML = <<<HTML_QUIZ
        <h2>N/A</h2>
        What is the answer to the following sub-questions?
        <ul>
            <li>Question 1</li>
            <li>Question 2</li>
        </ul>
        <ul>
            <li>truth</li>
        </ul>
HTML_QUIZ;
        
        $quiz = Quiz::GetQuizFromHTML($inputHTML);
        $this->assertEquals(1, count($quiz->Items));
        $this->assertEquals(true, $quiz->Items[0]->CorrectAnswer);
        $this->assertEquals("TF 001 - What is the answer to", $quiz->Items[0]->Name);
        $this->assertEquals("What is the answer to the following sub-questions?<ul><li>Question 1</li><li>Question 2</li></ul>", $quiz->Items[0]->Text);
    }

    public function testGetQuizFromHTMLSimpleMC()
    {
        $inputHTML = <<<HTML_QUIZ
        <h2>MC w/list in text</h2>
        What is the answer to the following questions?
        <ol>
            <li>option 1</li>
            <li><strong>option 2</strong></li>
            <li>option 3</li>
            <li>option 4</li>
        </ol>
        
HTML_QUIZ;
        
        $quiz = Quiz::GetQuizFromHTML($inputHTML);
        $this->assertEquals(1, count($quiz->Items));
        $this->assertEquals("MC 001 - MC w/list in text", $quiz->Items[0]->Name);
        $this->assertEquals("What is the answer to the following questions?", $quiz->Items[0]->Text);
        $this->assertEquals(4, count($quiz->Items[0]->Options));
        $this->assertEquals(0, $quiz->Items[0]->Options[0]->Value);
        $this->assertEquals(100, $quiz->Items[0]->Options[1]->Value);
        $this->assertEquals(0, $quiz->Items[0]->Options[2]->Value);
        $this->assertEquals(0, $quiz->Items[0]->Options[3]->Value);
        $this->assertEquals(false, $quiz->Items[0]->ShuffleAnswers);
    }
    
    public function testGetQuizFromHTMLSimpleMCShuffle()
    {
        $inputHTML = <<<HTML_QUIZ
        <h2>MC w/list in text</h2>
        What is the answer to the following questions?
        <ul>
            <li>option 1</li>
            <li><strong>option 2</strong></li>
            <li>option 3</li>
            <li>option 4</li>
        </ul>
        
HTML_QUIZ;
        
        $quiz = Quiz::GetQuizFromHTML($inputHTML);
        $this->assertEquals(1, count($quiz->Items));
        $this->assertEquals("MC 001 - MC w/list in text", $quiz->Items[0]->Name);
        $this->assertEquals("What is the answer to the following questions?", $quiz->Items[0]->Text);
        $this->assertEquals(4, count($quiz->Items[0]->Options));
        $this->assertEquals(0, $quiz->Items[0]->Options[0]->Value);
        $this->assertEquals(100, $quiz->Items[0]->Options[1]->Value);
        $this->assertEquals(0, $quiz->Items[0]->Options[2]->Value);
        $this->assertEquals(0, $quiz->Items[0]->Options[3]->Value);
        $this->assertEquals(true, $quiz->Items[0]->ShuffleAnswers);
    }

    public function testGetQuizFromHTMLComplexMC()
    {
        $inputHTML = <<<HTML_QUIZ
        <h2>MC w/list in text</h2>
        What is the answer to the following questions?
        <ul>
            <li>question 1</li>
            <li>question 2</li>
        </ul>
        <ol>
            <li>option 1</li>
            <li><strong>option 2</strong></li>
            <li>option 3</li>
            <li>option 4</li>
        </ol>
        
HTML_QUIZ;
        
        $quiz = Quiz::GetQuizFromHTML($inputHTML);
        $this->assertEquals(1, count($quiz->Items));
        $this->assertEquals("MC 001 - MC w/list in text", $quiz->Items[0]->Name);
        $this->assertEquals("What is the answer to the following questions?<ul><li>question 1</li><li>question 2</li></ul>", $quiz->Items[0]->Text);
        $this->assertEquals(4, count($quiz->Items[0]->Options));
        $this->assertEquals(0, $quiz->Items[0]->Options[0]->Value);
        $this->assertEquals(100, $quiz->Items[0]->Options[1]->Value);
        $this->assertEquals(0, $quiz->Items[0]->Options[2]->Value);
        $this->assertEquals(0, $quiz->Items[0]->Options[3]->Value);
    }

    public function testGetQuizFromHTMLComplexMCNA()
    {
        $inputHTML = <<<HTML_QUIZ
        <h2>N/A</h2>
        What is?
        <ul>
            <li>question 1</li>
            <li>question 2</li>
        </ul>
        <ol>
            <li>option 1</li>
            <li><strong>option 2</strong></li>
            <li>option 3</li>
            <li>option 4</li>
        </ol>
        
HTML_QUIZ;
        
        $quiz = Quiz::GetQuizFromHTML($inputHTML);
        $this->assertEquals(1, count($quiz->Items));
        $this->assertEquals("MC 001 - What is? question 1 question", $quiz->Items[0]->Name);
        $this->assertEquals("What is?<ul><li>question 1</li><li>question 2</li></ul>", $quiz->Items[0]->Text);
        $this->assertEquals(4, count($quiz->Items[0]->Options));
        $this->assertEquals(0, $quiz->Items[0]->Options[0]->Value);
        $this->assertEquals(100, $quiz->Items[0]->Options[1]->Value);
        $this->assertEquals(0, $quiz->Items[0]->Options[2]->Value);
        $this->assertEquals(0, $quiz->Items[0]->Options[3]->Value);
    }

    public function testGetQuizFromHTMLMatchingItem()
    {
        $inputHTML = <<<HTML_QUIZ
        <h2>made up</h2>
        <p>Match the following:</p>
        <dl>
            <dt>Alabama</dt><dd>State starting with an A</dd>
            <dt>Colorado</dt><dd>State starting with a C</dd>
            <dt>Michigan</dt><dd>State starting with a M</dd>
            <dt>Ohio</dt><dd>State starting with an O</dd>
            <dt>New York</dt><dd>State starting with a N</dd>
            <dt>Wisconsin</dt><dd>State starting with a W</dd>
        </dl>
HTML_QUIZ;
        
        $quiz = Quiz::GetQuizFromHTML($inputHTML);
        $this->assertEquals(1, count($quiz->Items));
        $this->assertEquals('State starting with an A', $quiz->Items[0]->Options['Alabama']);
    }
    
    public function testGetQuizFromHTMLMultipleItems()
    {
        $inputHTML = <<<HTML_QUIZ
        <h2>TF w/list in text</h2>
        What is the answer to the following sub-questions?
        <ul>
            <li>Question 1</li>
            <li>Question 2</li>
        </ul>
        <ul>
            <li>truth</li>
        </ul>
        <h2>TF false Question</h2>
        What is the answer to the following sub-questions?
        <ul>
            <li>false</li>
        </ul>
        <h2>MC w/list in text</h2>
        What is the answer to the following sub-questions?
        <ol>
            <li>question 1</li>
            <li>question 2</li>
        </ol>
        <ol>
            <li>option 1</li>
            <li><strong>option 2</strong></li>
            <li>option 3</li>
            <li>option 4</li>
        </ol>
        
HTML_QUIZ;
        
        $quiz = Quiz::GetQuizFromHTML($inputHTML);
        $this->assertEquals(3, count($quiz->Items));

        }
}

?>
