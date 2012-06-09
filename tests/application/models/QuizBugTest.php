<?php

namespace MoodleImporter;
if (!defined('APPPATH'))
{
    define('APPPATH', dirname(__FILE__) . '/../../../application');
}

require_once APPPATH . '/models/Quiz.php';

/**
 * Description of QuizBug1Test
 *
 * @author jdelano
 */
class QuizBugTest extends \PHPUnit_Framework_TestCase
{
   public function testGetQuizFromHTMLBugFix()
    {
        $html = <<<HTML
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Untitled Document</title>
        </head>

        <body>

        <h2>3-1</h2>
        <p>Which of the following topics cannot be resolved through research:</p>
        <ol>
        <li>Teaching students phonics improves reading performance</li>
        <li><strong>Sex education is morally wrong</strong></li>
        <li>Self-efficacy is related to school success</li>
        <li>Teaching students elaboration strategies can improve their memory performance</li>
        </ol>

        <h2>3-2</h2>
        <p>Along with learning about whether your research problem has been studied, a literature review can also help with:</p>
        <ol>
        <li>Designing your study</li>
        <li>Learning about methodological problems in studying phenomenon</li>
        <li>Revising your research problem</li>
        <li><strong>All of the above</strong></li>
        </ol>

        <h2>3-3</h2>
        <p>ERIC, SocIndex, and PsycINFO, refer to</p>
        <ol>
        <li>Professional organizations</li>
        <li><strong>Electronic databases</strong></li>
        <li>Listing of researchers</li>
        <li>Journals</li>
        </ol>

        <h2>3-4</h2>
        <p>A good qualitative problem statement:</p>
        <ol>
        <li>Defines the independent and dependent variables</li>
        <li><strong>Conveys a sense of emerging design</strong></li>
        <li>Specifies a research hypothesis</li>
        <li>Specifies the relationship between variables that the researcher expects to find</li>
        </ol>

        <h2>3-5</h2>
        <p>A good quantitative problem statement:</p>
        <ol>
        <li>Is very general about what relationships are predicted</li>
        <li>Conveys a sense of emerging design</li>
        <li>Defines a global questions only</li>
        <li><strong>Specifies the relationship that the study expects to find</strong></li>
        </ol>

        <h2>3-6</h2> 
        <p>In a quantitative study, hypotheses represent:</p>
        <ol>
        <li><strong>A best guess about the predicted relations between variables</strong></li>
        <li>A definition of the independent variables</li>
        <li>A definition of the dependent variables</li>
        <li>None of the above</li>
        </ol>

        <h2>3-7</h2>
        <p>Generally, in a qualitative study, hypotheses:</p>
        <ol>
        <li>Are stated before the study is done</li>
        <li><strong>Are derived as data are collected and analyzed</strong></li>
        <li>Are never derived from the data</li>
        <li>Are not part of qualitative research </li>
        </ol>

        <h2>3-8</h2>
        <p>A critical consumer of educational research:</p>
        <ol>
        <li>Feels comfortable drawing conclusions based on one study</li>
        <li>Takes whatever researchers say as the truth</li>
        <li>Depends only on quantitative studies</li>
        <li><strong>Looks for the replication of research phenomena in several studies</strong></li>
        </ol>

        <h2>3-9</h2>
        <p>A meta-analysis is:</p>
        <ol>
        <li><strong>A quantitative review of the literature</strong></li>
        <li>A qualitative study</li>
        <li>Part of the research plan</li>
        <li>A narrative review of the literature</li>
        </ol>

        <h2>3-10</h2>
        <p>The &ldquo;tool&rdquo; function of theory is to:</p>
        <ol>
        <li>Summarize existing knowledge</li>
        <li>Summarize existing hypothesis</li>
        <li><strong>Suggest new relationships and make new predictions</strong></li>
        <li>Suggest new theories</li>
        </ol>

        <h2>3-11</h2>
        <p>The primary reason for doing a literature review for a quantitative study is to:</p>
        <ol>
        <li>Determine which statistical test to use</li>
        <li>Find the proper phrasing of the research hypothesis</li>
        <li><strong>Gain an understanding of the current state of knowledge in the area</strong></li>
        <li>Determine who the research participants should be</li>
        </ol>

        <h2>3-12</h2>
        <p>The literature review in a qualitative research study can be used to:</p>
        <ol>
        <li>Explain the theoretical basis of a research study</li>
        <li>Assist in formulating the research question</li>
        <li>Stimulate new insights and concepts</li>
        <li><strong>All of the above are correct depending on the type of study being conducted</strong></li>
        </ol>

        <h2>3-13</h2>
        <p>If you were doing a literature search you could logon the World Wide Web and conduct your search using one of the available search engines. Using this procedure to do your literature search has the disadvantage of:</p>
        <ol>
        <li>Not providing any relevant information</li>
        <li>Being too slow</li>
        <li>Not providing enough information</li>
        <li><strong>Providing too much information with questionable credibility</strong></li>
        </ol>

        <h2>3-14</h2>
        <p>A qualitative research problem focuses on</p>
        <ol>
        <li>Explaining events</li>
        <li>Predicting events</li>
        <li><strong>Exploring some process or event</strong></li>
        <li>Describing some process or event</li>
        </ol>

        <h2>3-15</h2>
        <p>The statement of purpose in a research study should:</p>
        <ol>
        <li>Identify the design of the study</li>
        <li><strong>Identify the intent or objective of the study</strong></li>
        <li>Specify the type of people to be used in the study</li>
        <li>Describe the study</li>
        </ol>

        <h2>3-16</h2>
        <p> A qualitative research question:</p>
        <ol>
        <li>Asks a questions about some process, or phenomenon to be explored</li>
        <li>Is generally an open-ended question</li>
        <li><strong>Both a and b are correct</strong></li>
        <li>None of the above</li>
        </ol>

        <h2>3-17</h2>
        <p>A research hypothesis is:</p>
        <ol>
        <li>A prediction of the relation that exists among the variables</li>
        <li>A tentative solution to the research problem</li>
        <li>Is typically derived from theory or the literature review</li>
        <li><strong>All of the above</strong></li>
        </ol>

        <h2>3-18</h2>
        <p>Hypotheses must:</p>
        <ol>
        <li>be proven by the research study</li>
        <li><strong>be capable of being confirmed or refuted</strong></li>
        <li>come from a proven theory</li>
        <li>not contradict proven theories</li>
        </ol>

        <h2>3-19</h2>
        <p>According to the text, the flowchart of the development of a research idea goes in which of the following orders:</p>
        <ol> 
        <li><strong>Research topic, research problem, research purpose, specific research question, and, for quantitative research, research hypothesis.</strong></li>
        <li>Research topic, research purpose, specific research question, research hypothesis, and, for quantitative research, research problem</li>
        <li>Research topic, research hypothesis, research purpose, specific research question, and, for quantitative research, research problem</li>
        <li>Research topic, research problem, research purpose, research hypothesis, and, for quantitative research, specific research question.</li>
        </ol>

        <h2>3-20</h2>
        <p>Which of the following is a source of research ideas?</p>
        <ol>
        <li>Everyday life</li>
        <li>Past research</li>
        <li>Theory</li>
        <li><strong>All of the above</strong></li>
        </ol>

        <h2>DUMMY</h2>
        <p>A question this is not. - Yoda</p>
        <ol>
        <li>Everyday life</li>
        <li>Past research</li>
        <li>Theory</li>
        <li><strong>All of the above</strong></li>
        </ol>

        </body>
        </html>
HTML;
        $quiz = Quiz::GetQuizFromHTML($html);
        $this->assertEquals(21, count($quiz->Items));
    }
    
   public function testGetQuizFromHTMLBugFix2()
    {
        $html = <<<HTML
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Untitled Document</title>
        </head>

        <body>

        <h2>3-1</h2>
        <p>Which of the following topics <em>cannot</em> be resolved through research:</p>
        <ol>
        <li>Teaching students phonics improves reading performance</li>
        <li><strong>Sex education is morally wrong</strong></li>
        <li>Self-efficacy is related to school success</li>
        <li>Teaching students elaboration strategies can improve their memory performance</li>
        </ol>
HTML;
        
        $quiz = Quiz::GetQuizFromHTML($html);
        $this->assertEquals('<p>Which of the following topics <em>cannot</em> be resolved through research:</p>', $quiz->Items[0]->Text);

    }
    
    
    
}

?>
