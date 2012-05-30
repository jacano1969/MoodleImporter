<?php

namespace MoodleImporter;
if (!defined('APPPATH'))
{
    define('APPPATH', dirname(__FILE__) . '/../../../application');
}

require_once APPPATH . '/models/Quiz.php';

/**
 * Test class for MultipleChoiceOption.
 * Generated by PHPUnit on 2012-05-20 at 08:13:31.
 */
class MultipleChoiceOptionTest extends \PHPUnit_Framework_TestCase {

   
    /**
     * @covers MoodleImporter\MultipleChoiceOption::ToXMLElement
     */
    public function testToXMLElement() 
    {
        $multipleChoiceOption = new MultipleChoiceOption;
        $multipleChoiceOption->Text = "Alabama";
        $multipleChoiceOption->Value = 100;
        $expected = <<<OPTION_XML
        <answer fraction="100">
            <text><![CDATA[Alabama]]></text>
        </answer>
OPTION_XML;
        $this->assertTrue(xml_is_equal($multipleChoiceOption->ToXMLElement(), new \SimpleXMLElement($expected), true));
    }

    /**
     * @covers MoodleImporter\MultipleChoiceOption::ToHTML() 
     */
    public function testToHTML()
    {
        $multipleChoiceOption = new MultipleChoiceOption;
        $multipleChoiceOption->Text = "Alabama";
        $multipleChoiceOption->Value = 100;
        $expected = <<<OPTION_XML
        <li><strong>Alabama</strong></li>
OPTION_XML;
        $this->assertXmlStringEqualsXmlString($expected, $multipleChoiceOption->ToHTML());
        
    }
    
    public function testConstruct()
    {
        $mtOption = new MultipleChoiceOption("Option", 100);
        $this->assertEquals("Option", $mtOption->Text);
        $this->assertEquals(100, $mtOption->Value);
    }

}

?>
