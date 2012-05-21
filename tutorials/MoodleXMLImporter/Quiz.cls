<refentry id="{@id}">
<refnamediv>
  <refname>Quiz Class</refname>
</refnamediv>
 <refsect1 id="{@id intro}">
  <title>HTML Test Import Specification</title>
  <para>
    <orderedlist>
    <listitem>The order in which questions are provided to the system will be preserved in the “Review Question” view and in the output XML file.</listitem>
    <listitem>Each question in the content to be imported (whether copied and pasted or uploaded in a document) will conform to the following specifications:</listitem>
    <listitem>Each question will begin with: <![CDATA[<h2>Question name OR N/A</h2>]]></listitem>
    <listitem>The question text will immediately follow the closing h2 tag.</listitem>
    <listitem>The question text may contain any legitimate HTML tag, including, but not limited to, tables, paragraphs, and unordered and ordered lists.</listitem>
    <listitem>Essay questions must end with an empty _____ tag</listitem>
    <listitem>Multiple-choice and true/false questions must end with either an "ol" or "ul" tag.</listitem>
    <listitem>Multiple-choice questions that end with an "ol" tag will disable shuffling of its answer choices</listitem>
    <listitem>Multiple-choice questions that end with an "ul" tag will enable shuffling of its answer choices</listitem>
    <listitem>Each possible answer choice to a multiple-choice question must appear within "li" tags inside the "ol" or "ul" set of tags.</listitem>
    <listitem>Correct answers for multiple-choice questions will be embedded within a <![CDATA[<strong></strong>]]> set of tags.</listitem>
    <listitem>Matching questions must end with a "dl" tag, with each term and its correct definition appearing in "dt" and "dd" tags, respectively.</listitem>
    <listitem>True/false questions must enclose either a T (or true) or an F (or false) within an "li" set of tags to indicate the correct answer. </listitem>
    <listitem>Only the correct answer is specified for true/false questions.</listitem>
    <listitem>Questions will be given a name that is consistent with the following naming convention:
        TTnnn – [question name]
    Where, TT is the question type (MC = Multiple choice, TF = true/false, ES = Essay, MT = Matching), nnn is the question number formatted to three digits (e.g., 001 for question #1), and [question name] is the contents of the h2 tag OR the first five words of question text, if the h2 tag contains “N/A”.</listitem>
    <listitem>4.	Questions will be numbered sequentially from the beginning of the file to the end, in the order in which the questions are submitted.</listitem>
    </orderedlist> 
</para>
 </refsect1>

</refentry>