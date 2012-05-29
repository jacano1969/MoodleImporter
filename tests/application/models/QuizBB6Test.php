<?php

namespace MoodleImporter;
if (!defined('APPPATH'))
{
    define('APPPATH', dirname(__FILE__) . '/../../../application');
}

require_once APPPATH . '/models/Quiz.php';
require_once 'bb6xml.php';
/**
 * Description of QuizTestBB6
 *
 * @author jdelano
 */
class QuizBB6Test extends \PHPUnit_Framework_TestCase {

    public function testGetQuizFromBB6XML()
    {
        $quiz = Quiz::GetQuizFromBB6XML(\BB6XML::GetBB6TFMCDat());
        $this->assertEquals(2, count($quiz->Items));
        $this->assertEquals('testcategory', $quiz->Category);
    }
  
    public function testReplaceTextInQuiz()
    {
        $quiz = Quiz::GetQuizFromBB6XML(\BB6XML::GetBB6TFMCDat());
        $quiz->ReplaceTextInQuiz('Which of the following is not a key element', 'Which of the following is a key element');
        $this->assertEquals('Which of the following is a key element of an E-R model?', $quiz->Items[1]->Text);
    }

}

?>
