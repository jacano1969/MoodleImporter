<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BB6XML
 *
 * @author jdelano
 */
class BB6XML {

    public static function GetBB6TFItemData()
    {
        $xmlValue = <<<'ITEM_DATA'
        <item maxattempts="0">
        <itemmetadata>
                <bbmd_asi_object_id>A0F02D342D1149EEB47BFB9A0B853700</bbmd_asi_object_id>
                <bbmd_asitype>Item</bbmd_asitype>
                <bbmd_assessmenttype>Pool</bbmd_assessmenttype>
                <bbmd_sectiontype>Subsection</bbmd_sectiontype>
                <bbmd_questiontype>True/False</bbmd_questiontype>
                <bbmd_is_from_cartridge>false</bbmd_is_from_cartridge>
                <qmd_absolutescore>0.0,1.0</qmd_absolutescore>
                <qmd_absolutescore_min>0.0</qmd_absolutescore_min>
                <qmd_absolutescore_max>1.0</qmd_absolutescore_max>
                <qmd_assessmenttype>Proprietary</qmd_assessmenttype>
                <qmd_itemtype>Logical Identifier</qmd_itemtype>
                <qmd_levelofdifficulty>School</qmd_levelofdifficulty>
                <qmd_maximumscore>0.0</qmd_maximumscore>
                <qmd_numberofitems>0</qmd_numberofitems>
                <qmd_renderingtype>Proprietary</qmd_renderingtype>
                <qmd_responsetype>Single</qmd_responsetype>
                <qmd_scoretype>Absolute</qmd_scoretype>
                <qmd_status>Normal</qmd_status>
                <qmd_timelimit>0</qmd_timelimit>
                <qmd_weighting>0.0</qmd_weighting>
                <qmd_typeofsolution>Complete</qmd_typeofsolution>
        </itemmetadata>
        <presentation>
                <flow class="Block">
                        <flow class="QUESTION_BLOCK">
                                <flow class="FORMATTED_TEXT_BLOCK">
                                        <material>
                                                <mat_extension>
                                                        <mat_formattedtext type="HTML">A data model is a plan for a database design.</mat_formattedtext>
                                                </mat_extension>
                                        </material>
                                </flow>
                                <flow class="FILE_BLOCK">
                                        <material/>
                                </flow>
                                <flow class="LINK_BLOCK">
                                        <material>
                                                <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                        </material>
                                </flow>
                        </flow>
                        <flow class="RESPONSE_BLOCK">
                                <response_lid ident="response" rcardinality="Single" rtiming="No">
                                        <render_choice maxnumber="0" minnumber="0" shuffle="No">
                                                <flow_label class="Block">
                                                        <response_label ident="true" rarea="Ellipse" rrange="Exact" shuffle="Yes">
                                                                <flow_mat class="Block">
                                                                        <material>
                                                                                <mattext charset="us-ascii" texttype="text/plain" xml:space="default">true</mattext>
                                                                        </material>
                                                                </flow_mat>
                                                        </response_label>
                                                        <response_label ident="false" rarea="Ellipse" rrange="Exact" shuffle="Yes">
                                                                <flow_mat class="Block">
                                                                        <material>
                                                                                <mattext charset="us-ascii" texttype="text/plain" xml:space="default">false</mattext>
                                                                        </material>
                                                                </flow_mat>
                                                        </response_label>
                                                </flow_label>
                                        </render_choice>
                                </response_lid>
                        </flow>
                </flow>
        </presentation>
        <resprocessing scoremodel="SumOfScores">
                <outcomes>
                        <decvar defaultval="0.0" maxvalue="1.0" minvalue="0.0" varname="SCORE" vartype="Decimal"/>
                </outcomes>
                <respcondition title="correct">
                        <conditionvar>
                                <varequal case="No" respident="response">true</varequal>
                        </conditionvar>
                        <setvar action="Set" variablename="SCORE">SCORE.max</setvar>
                        <displayfeedback feedbacktype="Response" linkrefid="correct"/>
                </respcondition>
                <respcondition title="incorrect">
                        <conditionvar>
                                <other/>
                        </conditionvar>
                        <setvar action="Set" variablename="SCORE">0.0</setvar>
                        <displayfeedback feedbacktype="Response" linkrefid="incorrect"/>
                </respcondition>
        </resprocessing>
        <itemfeedback ident="correct" view="All">
                <flow_mat class="Block">
                        <flow_mat class="FORMATTED_TEXT_BLOCK">
                                <material>
                                        <mat_extension>
                                                <mat_formattedtext type="HTML">You have chosen wisely.</mat_formattedtext>
                                        </mat_extension>
                                </material>
                        </flow_mat>
                        <flow_mat class="FILE_BLOCK">
                                <material/>
                        </flow_mat>
                        <flow_mat class="LINK_BLOCK">
                                <material>
                                        <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                </material>
                        </flow_mat>
                </flow_mat>
        </itemfeedback>
        <itemfeedback ident="incorrect" view="All">
                <flow_mat class="Block">
                        <flow_mat class="FORMATTED_TEXT_BLOCK">
                                <material>
                                        <mat_extension>
                                                <mat_formattedtext type="HTML">NOPE, try again.</mat_formattedtext>
                                        </mat_extension>
                                </material>
                        </flow_mat>
                        <flow_mat class="FILE_BLOCK">
                                <material/>
                        </flow_mat>
                        <flow_mat class="LINK_BLOCK">
                                <material>
                                        <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                </material>
                        </flow_mat>
                </flow_mat>
        </itemfeedback>
                    </item>
ITEM_DATA;
        return $xmlValue;
    }
    
    public static function GetBB6MCItemData()
    {
        $xml = <<<BB6_XML
        <item maxattempts="0">
                <itemmetadata>
                        <bbmd_asi_object_id>F5463AB1854747E8BC40B3A132A29FC6</bbmd_asi_object_id>
                        <bbmd_asitype>Item</bbmd_asitype>
                        <bbmd_assessmenttype>Pool</bbmd_assessmenttype>
                        <bbmd_sectiontype>Subsection</bbmd_sectiontype>
                        <bbmd_questiontype>Multiple Choice</bbmd_questiontype>
                        <bbmd_is_from_cartridge>false</bbmd_is_from_cartridge>
                        <qmd_absolutescore>0.0,1.0</qmd_absolutescore>
                        <qmd_absolutescore_min>0.0</qmd_absolutescore_min>
                        <qmd_absolutescore_max>1.0</qmd_absolutescore_max>
                        <qmd_assessmenttype>Proprietary</qmd_assessmenttype>
                        <qmd_itemtype>Logical Identifier</qmd_itemtype>
                        <qmd_levelofdifficulty>School</qmd_levelofdifficulty>
                        <qmd_maximumscore>0.0</qmd_maximumscore>
                        <qmd_numberofitems>0</qmd_numberofitems>
                        <qmd_renderingtype>Proprietary</qmd_renderingtype>
                        <qmd_responsetype>Single</qmd_responsetype>
                        <qmd_scoretype>Absolute</qmd_scoretype>
                        <qmd_status>Normal</qmd_status>
                        <qmd_timelimit>0</qmd_timelimit>
                        <qmd_weighting>0.0</qmd_weighting>
                        <qmd_typeofsolution>Complete</qmd_typeofsolution>
                </itemmetadata>
                <presentation>
                        <flow class="Block">
                                <flow class="QUESTION_BLOCK">
                                        <flow class="FORMATTED_TEXT_BLOCK">
                                                <material>
                                                        <mat_extension>
                                                                <mat_formattedtext type="HTML">Which of the following is not a key element of an E-R model?</mat_formattedtext>
                                                        </mat_extension>
                                                </material>
                                        </flow>
                                        <flow class="FILE_BLOCK">
                                                <material/>
                                        </flow>
                                        <flow class="LINK_BLOCK">
                                                <material>
                                                        <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                                </material>
                                        </flow>
                                </flow>
                                <flow class="RESPONSE_BLOCK">
                                        <response_lid ident="response" rcardinality="Single" rtiming="No">
                                                <render_choice maxnumber="0" minnumber="0" shuffle="Yes">
                                                        <flow_label class="Block">
                                                                <response_label ident="60FD12D7221A440FBBE401F3AAAC7898" rarea="Ellipse" rrange="Exact" shuffle="Yes">
                                                                        <flow_mat class="FORMATTED_TEXT_BLOCK">
                                                                                <material>
                                                                                        <mat_extension>
                                                                                                <mat_formattedtext type="HTML">Attributes</mat_formattedtext>
                                                                                        </mat_extension>
                                                                                </material>
                                                                        </flow_mat>
                                                                        <flow_mat class="FILE_BLOCK">
                                                                                <material/>
                                                                        </flow_mat>
                                                                        <flow_mat class="LINK_BLOCK">
                                                                                <material>
                                                                                        <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                                                                </material>
                                                                        </flow_mat>
                                                                </response_label>
                                                        </flow_label>
                                                        <flow_label class="Block">
                                                                <response_label ident="85A03A9594D046B8BA4DDED5A580A687" rarea="Ellipse" rrange="Exact" shuffle="Yes">
                                                                        <flow_mat class="FORMATTED_TEXT_BLOCK">
                                                                                <material>
                                                                                        <mat_extension>
                                                                                                <mat_formattedtext type="HTML">Relationships</mat_formattedtext>
                                                                                        </mat_extension>
                                                                                </material>
                                                                        </flow_mat>
                                                                        <flow_mat class="FILE_BLOCK">
                                                                                <material/>
                                                                        </flow_mat>
                                                                        <flow_mat class="LINK_BLOCK">
                                                                                <material>
                                                                                        <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                                                                </material>
                                                                        </flow_mat>
                                                                </response_label>
                                                        </flow_label>
                                                        <flow_label class="Block">
                                                                <response_label ident="3FEE7F3B62D84E2593BFD0E04A751564" rarea="Ellipse" rrange="Exact" shuffle="Yes">
                                                                        <flow_mat class="FORMATTED_TEXT_BLOCK">
                                                                                <material>
                                                                                        <mat_extension>
                                                                                                <mat_formattedtext type="HTML">Entities</mat_formattedtext>
                                                                                        </mat_extension>
                                                                                </material>
                                                                        </flow_mat>
                                                                        <flow_mat class="FILE_BLOCK">
                                                                                <material/>
                                                                        </flow_mat>
                                                                        <flow_mat class="LINK_BLOCK">
                                                                                <material>
                                                                                        <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                                                                </material>
                                                                        </flow_mat>
                                                                </response_label>
                                                        </flow_label>
                                                        <flow_label class="Block">
                                                                <response_label ident="30899B68515049FB8A144400B786333A" rarea="Ellipse" rrange="Exact" shuffle="Yes">
                                                                        <flow_mat class="FORMATTED_TEXT_BLOCK">
                                                                                <material>
                                                                                        <mat_extension>
                                                                                                <mat_formattedtext type="HTML">Objects</mat_formattedtext>
                                                                                        </mat_extension>
                                                                                </material>
                                                                        </flow_mat>
                                                                        <flow_mat class="FILE_BLOCK">
                                                                                <material/>
                                                                        </flow_mat>
                                                                        <flow_mat class="LINK_BLOCK">
                                                                                <material>
                                                                                        <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                                                                </material>
                                                                        </flow_mat>
                                                                </response_label>
                                                        </flow_label>
                                                        <flow_label class="Block">
                                                                <response_label ident="94FC7B32387D4308A2C25E0F33FE24E1" rarea="Ellipse" rrange="Exact" shuffle="Yes">
                                                                        <flow_mat class="FORMATTED_TEXT_BLOCK">
                                                                                <material>
                                                                                        <mat_extension>
                                                                                                <mat_formattedtext type="HTML">Identifiers</mat_formattedtext>
                                                                                        </mat_extension>
                                                                                </material>
                                                                        </flow_mat>
                                                                        <flow_mat class="FILE_BLOCK">
                                                                                <material/>
                                                                        </flow_mat>
                                                                        <flow_mat class="LINK_BLOCK">
                                                                                <material>
                                                                                        <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                                                                </material>
                                                                        </flow_mat>
                                                                </response_label>
                                                        </flow_label>
                                                </render_choice>
                                        </response_lid>
                                </flow>
                        </flow>
                </presentation>
                <resprocessing scoremodel="SumOfScores">
                        <outcomes>
                                <decvar defaultval="0.0" maxvalue="1.0" minvalue="0.0" varname="SCORE" vartype="Decimal"/>
                        </outcomes>
                        <respcondition title="correct">
                                <conditionvar>
                                        <varequal case="No" respident="response">30899B68515049FB8A144400B786333A</varequal>
                                </conditionvar>
                                <setvar action="Set" variablename="SCORE">SCORE.max</setvar>
                                <displayfeedback feedbacktype="Response" linkrefid="correct"/>
                        </respcondition>
                        <respcondition title="incorrect">
                                <conditionvar>
                                        <other/>
                                </conditionvar>
                                <setvar action="Set" variablename="SCORE">0.0</setvar>
                                <displayfeedback feedbacktype="Response" linkrefid="incorrect"/>
                        </respcondition>
                </resprocessing>
                <itemfeedback ident="correct" view="All">
                        <flow_mat class="Block">
                                <flow_mat class="FORMATTED_TEXT_BLOCK">
                                        <material>
                                                <mat_extension>
                                                        <mat_formattedtext type="HTML">Correct Feedback</mat_formattedtext>
                                                </mat_extension>
                                        </material>
                                </flow_mat>
                                <flow_mat class="FILE_BLOCK">
                                        <material/>
                                </flow_mat>
                                <flow_mat class="LINK_BLOCK">
                                        <material>
                                                <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                        </material>
                                </flow_mat>
                        </flow_mat>
                </itemfeedback>
                <itemfeedback ident="incorrect" view="All">
                        <flow_mat class="Block">
                                <flow_mat class="FORMATTED_TEXT_BLOCK">
                                        <material>
                                                <mat_extension>
                                                        <mat_formattedtext type="HTML">Incorrect Feedback</mat_formattedtext>
                                                </mat_extension>
                                        </material>
                                </flow_mat>
                                <flow_mat class="FILE_BLOCK">
                                        <material/>
                                </flow_mat>
                                <flow_mat class="LINK_BLOCK">
                                        <material>
                                                <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                        </material>
                                </flow_mat>
                        </flow_mat>
                </itemfeedback>
                <itemfeedback ident="60FD12D7221A440FBBE401F3AAAC7898" view="All">
                        <solution feedbackstyle="Complete" view="All">
                                <solutionmaterial>
                                        <flow_mat class="Block">
                                                <flow_mat class="FORMATTED_TEXT_BLOCK">
                                                        <material>
                                                                <mat_extension>
                                                                        <mat_formattedtext type="HTML"></mat_formattedtext>
                                                                </mat_extension>
                                                        </material>
                                                </flow_mat>
                                                <flow_mat class="FILE_BLOCK">
                                                        <material/>
                                                </flow_mat>
                                                <flow_mat class="LINK_BLOCK">
                                                        <material>
                                                                <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                                        </material>
                                                </flow_mat>
                                        </flow_mat>
                                </solutionmaterial>
                        </solution>
                </itemfeedback>
                <itemfeedback ident="85A03A9594D046B8BA4DDED5A580A687" view="All">
                        <solution feedbackstyle="Complete" view="All">
                                <solutionmaterial>
                                        <flow_mat class="Block">
                                                <flow_mat class="FORMATTED_TEXT_BLOCK">
                                                        <material>
                                                                <mat_extension>
                                                                        <mat_formattedtext type="HTML"></mat_formattedtext>
                                                                </mat_extension>
                                                        </material>
                                                </flow_mat>
                                                <flow_mat class="FILE_BLOCK">
                                                        <material/>
                                                </flow_mat>
                                                <flow_mat class="LINK_BLOCK">
                                                        <material>
                                                                <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                                        </material>
                                                </flow_mat>
                                        </flow_mat>
                                </solutionmaterial>
                        </solution>
                </itemfeedback>
                <itemfeedback ident="3FEE7F3B62D84E2593BFD0E04A751564" view="All">
                        <solution feedbackstyle="Complete" view="All">
                                <solutionmaterial>
                                        <flow_mat class="Block">
                                                <flow_mat class="FORMATTED_TEXT_BLOCK">
                                                        <material>
                                                                <mat_extension>
                                                                        <mat_formattedtext type="HTML"></mat_formattedtext>
                                                                </mat_extension>
                                                        </material>
                                                </flow_mat>
                                                <flow_mat class="FILE_BLOCK">
                                                        <material/>
                                                </flow_mat>
                                                <flow_mat class="LINK_BLOCK">
                                                        <material>
                                                                <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                                        </material>
                                                </flow_mat>
                                        </flow_mat>
                                </solutionmaterial>
                        </solution>
                </itemfeedback>
                <itemfeedback ident="30899B68515049FB8A144400B786333A" view="All">
                        <solution feedbackstyle="Complete" view="All">
                                <solutionmaterial>
                                        <flow_mat class="Block">
                                                <flow_mat class="FORMATTED_TEXT_BLOCK">
                                                        <material>
                                                                <mat_extension>
                                                                        <mat_formattedtext type="HTML"></mat_formattedtext>
                                                                </mat_extension>
                                                        </material>
                                                </flow_mat>
                                                <flow_mat class="FILE_BLOCK">
                                                        <material/>
                                                </flow_mat>
                                                <flow_mat class="LINK_BLOCK">
                                                        <material>
                                                                <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                                        </material>
                                                </flow_mat>
                                        </flow_mat>
                                </solutionmaterial>
                        </solution>
                </itemfeedback>
                <itemfeedback ident="94FC7B32387D4308A2C25E0F33FE24E1" view="All">
                        <solution feedbackstyle="Complete" view="All">
                                <solutionmaterial>
                                        <flow_mat class="Block">
                                                <flow_mat class="FORMATTED_TEXT_BLOCK">
                                                        <material>
                                                                <mat_extension>
                                                                        <mat_formattedtext type="HTML"></mat_formattedtext>
                                                                </mat_extension>
                                                        </material>
                                                </flow_mat>
                                                <flow_mat class="FILE_BLOCK">
                                                        <material/>
                                                </flow_mat>
                                                <flow_mat class="LINK_BLOCK">
                                                        <material>
                                                                <mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
                                                        </material>
                                                </flow_mat>
                                        </flow_mat>
                                </solutionmaterial>
                        </solution>
                </itemfeedback>
			</item>
BB6_XML;
        
        return $xml;
    }
    
    public static function GetBB6MTItemData()
    {
        $xml = <<<BB6_XML
<?xml version="1.0"?>
<item
maxattempts="0"
title="This is the question title"
><itemmetadata
><bbmd_asi_object_id
>_9451171_1</bbmd_asi_object_id
><bbmd_asitype
>Item</bbmd_asitype
><bbmd_assessmenttype
>Test</bbmd_assessmenttype
><bbmd_sectiontype
>Subsection</bbmd_sectiontype
><bbmd_questiontype
>Matching</bbmd_questiontype
><bbmd_is_from_cartridge
>false</bbmd_is_from_cartridge
><bbmd_is_disabled
>false</bbmd_is_disabled
><bbmd_negative_points_ind
>N</bbmd_negative_points_ind
><bbmd_canvas_fullcrdt_ind
>false</bbmd_canvas_fullcrdt_ind
><bbmd_all_fullcredit_ind
>false</bbmd_all_fullcredit_ind
><bbmd_numbertype
>letter_upper</bbmd_numbertype
><bbmd_partialcredit
>true</bbmd_partialcredit
><bbmd_orientationtype
>vertical</bbmd_orientationtype
><bbmd_is_extracredit
>false</bbmd_is_extracredit
><qmd_absolutescore_max
>10.0</qmd_absolutescore_max
><qmd_weighting
>0.0</qmd_weighting
><qmd_instructornotes
>These are the instructor notes</qmd_instructornotes
></itemmetadata
><presentation
><flow
class="Block"
><flow
class="QUESTION_BLOCK"
><flow
class="FORMATTED_TEXT_BLOCK"
><material
><mat_extension
><mat_formattedtext
type="HTML"
>This is the question text.</mat_formattedtext
></mat_extension
></material
></flow
></flow
><flow
class="RESPONSE_BLOCK"
><flow
class="Block"
><response_lid
ident="5c05e6671f0e4acfb969a6ec48d5d397"
rcardinality="Single"
rtiming="No"
><render_choice
maxnumber="0"
minnumber="0"
shuffle="Yes"
><flow_label
class="Block"
><response_label
ident="13a62cfd1dab421d9ba8c75852cf052b"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
><response_label
ident="fe359880810641ff8556681f0d6f5b10"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
><response_label
ident="b26f07fd9e4c47529421321bfb3f079e"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
><response_label
ident="4cfe6b931a6e48efa1366c053ac760b4"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
></flow_label
></render_choice
></response_lid
><flow
class="FORMATTED_TEXT_BLOCK"
><material
><mat_extension
><mat_formattedtext
type="HTML"
>  Alabama</mat_formattedtext
></mat_extension
></material
></flow
></flow
><flow
class="Block"
><response_lid
ident="7d9cfd53475f401cb158dbeb901c3ca7"
rcardinality="Single"
rtiming="No"
><render_choice
maxnumber="0"
minnumber="0"
shuffle="Yes"
><flow_label
class="Block"
><response_label
ident="47329e84574b4ead87718d1fcb43a20d"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
><response_label
ident="b72d549ec519469bba3dde4e13ffe90f"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
><response_label
ident="c9571afa608544adbed00842cebdde0c"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
><response_label
ident="cc8cbcc1ba1142fbb9d4ef61df924ffa"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
></flow_label
></render_choice
></response_lid
><flow
class="FORMATTED_TEXT_BLOCK"
><material
><mat_extension
><mat_formattedtext
type="HTML"
>  California</mat_formattedtext
></mat_extension
></material
></flow
></flow
><flow
class="Block"
><response_lid
ident="50f3ab9bfb734705833bcbeba47de8b4"
rcardinality="Single"
rtiming="No"
><render_choice
maxnumber="0"
minnumber="0"
shuffle="Yes"
><flow_label
class="Block"
><response_label
ident="7164b361ba03458d9475ac4c2f3b4b7c"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
><response_label
ident="31cf95cfd90d4141b4098e4e42d7b3d5"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
><response_label
ident="1821fee550874ee592232daaa8f30177"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
><response_label
ident="ed2848c52b0a49ab990fea9f9a1c954a"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
></flow_label
></render_choice
></response_lid
><flow
class="FORMATTED_TEXT_BLOCK"
><material
><mat_extension
><mat_formattedtext
type="HTML"
>  Delaware</mat_formattedtext
></mat_extension
></material
></flow
></flow
><flow
class="Block"
><response_lid
ident="1a8fb3788ba94cbf9c5c643cbabbd49e"
rcardinality="Single"
rtiming="No"
><render_choice
maxnumber="0"
minnumber="0"
shuffle="Yes"
><flow_label
class="Block"
><response_label
ident="c62c52544b5042d793a5f02293124508"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
><response_label
ident="7f703752c6c5419ea56c4592f600836a"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
><response_label
ident="d6cf2ab38db8469884139138f616d6ea"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
><response_label
ident="015cb9bc37bb473bbccdf15fe15069d4"
rarea="Ellipse"
rrange="Exact"
shuffle="Yes"
></response_label
></flow_label
></render_choice
></response_lid
><flow
class="FORMATTED_TEXT_BLOCK"
><material
><mat_extension
><mat_formattedtext
type="HTML"
>  Florida</mat_formattedtext
></mat_extension
></material
></flow
></flow
></flow
><flow
class="RIGHT_MATCH_BLOCK"
><flow
class="Block"
><flow
class="FORMATTED_TEXT_BLOCK"
><material
><mat_extension
><mat_formattedtext
type="HTML"
>  State starting with an A</mat_formattedtext
></mat_extension
></material
></flow
></flow
><flow
class="Block"
><flow
class="FORMATTED_TEXT_BLOCK"
><material
><mat_extension
><mat_formattedtext
type="HTML"
>  State starting with a C</mat_formattedtext
></mat_extension
></material
></flow
></flow
><flow
class="Block"
><flow
class="FORMATTED_TEXT_BLOCK"
><material
><mat_extension
><mat_formattedtext
type="HTML"
>  State starting with a D</mat_formattedtext
></mat_extension
></material
></flow
></flow
><flow
class="Block"
><flow
class="FORMATTED_TEXT_BLOCK"
><material
><mat_extension
><mat_formattedtext
type="HTML"
>  State starting with an F</mat_formattedtext
></mat_extension
></material
></flow
></flow
></flow
></flow
></presentation
><resprocessing
scoremodel="SumOfScores"
><outcomes
><decvar
defaultval="0.0"
maxvalue="10.0"
minvalue="0.0"
varname="SCORE"
vartype="Decimal"
></decvar
></outcomes
><respcondition
><conditionvar
><varequal
case="No"
respident="5c05e6671f0e4acfb969a6ec48d5d397"
>13a62cfd1dab421d9ba8c75852cf052b</varequal
></conditionvar
><setvar
action="Set"
variablename="PartialCreditPercent"
>25.0</setvar
><setvar
action="Set"
variablename="NegativeCreditPercent"
>0.0</setvar
><displayfeedback
feedbacktype="Response"
linkrefid="correct"
></displayfeedback
></respcondition
><respcondition
><conditionvar
><varequal
case="No"
respident="7d9cfd53475f401cb158dbeb901c3ca7"
>b72d549ec519469bba3dde4e13ffe90f</varequal
></conditionvar
><setvar
action="Set"
variablename="PartialCreditPercent"
>25.0</setvar
><setvar
action="Set"
variablename="NegativeCreditPercent"
>0.0</setvar
><displayfeedback
feedbacktype="Response"
linkrefid="correct"
></displayfeedback
></respcondition
><respcondition
><conditionvar
><varequal
case="No"
respident="50f3ab9bfb734705833bcbeba47de8b4"
>1821fee550874ee592232daaa8f30177</varequal
></conditionvar
><setvar
action="Set"
variablename="PartialCreditPercent"
>25.0</setvar
><setvar
action="Set"
variablename="NegativeCreditPercent"
>0.0</setvar
><displayfeedback
feedbacktype="Response"
linkrefid="correct"
></displayfeedback
></respcondition
><respcondition
><conditionvar
><varequal
case="No"
respident="1a8fb3788ba94cbf9c5c643cbabbd49e"
>015cb9bc37bb473bbccdf15fe15069d4</varequal
></conditionvar
><setvar
action="Set"
variablename="PartialCreditPercent"
>25.0</setvar
><setvar
action="Set"
variablename="NegativeCreditPercent"
>0.0</setvar
><displayfeedback
feedbacktype="Response"
linkrefid="correct"
></displayfeedback
></respcondition
><respcondition
title="incorrect"
><conditionvar
><other
></other
></conditionvar
><setvar
action="Set"
variablename="SCORE"
>0.0</setvar
><displayfeedback
feedbacktype="Response"
linkrefid="incorrect"
></displayfeedback
></respcondition
></resprocessing
><itemfeedback
ident="correct"
view="All"
><flow_mat
class="Block"
><flow_mat
class="FORMATTED_TEXT_BLOCK"
><material
><mat_extension
><mat_formattedtext
type="HTML"
>  Good JOB</mat_formattedtext
></mat_extension
></material
></flow_mat
></flow_mat
></itemfeedback
><itemfeedback
ident="incorrect"
view="All"
><flow_mat
class="Block"
><flow_mat
class="FORMATTED_TEXT_BLOCK"
><material
><mat_extension
><mat_formattedtext
type="HTML"
>  Bad JOB</mat_formattedtext
></mat_extension
></material
></flow_mat
></flow_mat
></itemfeedback
></item
>
BB6_XML;
        
        return $xml;
    }
    
    public static function GetBB6ESItemData()
    {
        $xml = <<<BB6_XML
        <?xml version="1.0"?>
<item
maxattempts="0"
title="Essay question title"
><itemmetadata
><bbmd_asi_object_id
>_9451683_1</bbmd_asi_object_id
><bbmd_asitype
>Item</bbmd_asitype
><bbmd_assessmenttype
>Test</bbmd_assessmenttype
><bbmd_sectiontype
>Subsection</bbmd_sectiontype
><bbmd_questiontype
>Essay</bbmd_questiontype
><bbmd_is_from_cartridge
>false</bbmd_is_from_cartridge
><bbmd_is_disabled
>false</bbmd_is_disabled
><bbmd_negative_points_ind
>N</bbmd_negative_points_ind
><bbmd_canvas_fullcrdt_ind
>false</bbmd_canvas_fullcrdt_ind
><bbmd_all_fullcredit_ind
>false</bbmd_all_fullcredit_ind
><bbmd_numbertype
>none</bbmd_numbertype
><bbmd_partialcredit
>false</bbmd_partialcredit
><bbmd_orientationtype
>vertical</bbmd_orientationtype
><bbmd_is_extracredit
>false</bbmd_is_extracredit
><qmd_absolutescore_max
>10.0</qmd_absolutescore_max
><qmd_weighting
>0.0</qmd_weighting
><qmd_instructornotes
>These are instructor notes.</qmd_instructornotes
></itemmetadata
><presentation
><flow
class="Block"
><flow
class="QUESTION_BLOCK"
><flow
class="FORMATTED_TEXT_BLOCK"
><material
><mat_extension
><mat_formattedtext
type="HTML"
>Describe the following things that happened one day.&lt;div&gt;&lt;ul&gt;&lt;li&gt;Went to bed&lt;/li&gt;&lt;li&gt;Woke up&lt;/li&gt;&lt;li&gt;Went to work&lt;/li&gt;&lt;/ul&gt;&lt;/div&gt;</mat_formattedtext
></mat_extension
></material
></flow
></flow
><flow
class="RESPONSE_BLOCK"
><response_str
ident="response"
rcardinality="Single"
rtiming="No"
><render_fib
charset="us-ascii"
columns="127"
encoding="UTF_8"
fibtype="String"
maxchars="0"
maxnumber="0"
minnumber="0"
prompt="Box"
rows="8"
></render_fib
></response_str
></flow
></flow
></presentation
><resprocessing
scoremodel="SumOfScores"
><outcomes
><decvar
defaultval="0.0"
maxvalue="10.0"
minvalue="0.0"
varname="SCORE"
vartype="Decimal"
></decvar
></outcomes
><respcondition
title="correct"
><conditionvar
></conditionvar
><setvar
action="Set"
variablename="SCORE"
>SCORE.max</setvar
><displayfeedback
feedbacktype="Response"
linkrefid="correct"
></displayfeedback
></respcondition
><respcondition
title="incorrect"
><conditionvar
><other
></other
></conditionvar
><setvar
action="Set"
variablename="SCORE"
>0.0</setvar
><displayfeedback
feedbacktype="Response"
linkrefid="incorrect"
></displayfeedback
></respcondition
></resprocessing
><itemfeedback
ident="correct"
view="All"
><flow_mat
class="Block"
><flow_mat
class="FORMATTED_TEXT_BLOCK"
><material
><mat_extension
><mat_formattedtext
type="HTML"
></mat_formattedtext
></mat_extension
></material
></flow_mat
></flow_mat
></itemfeedback
><itemfeedback
ident="incorrect"
view="All"
><flow_mat
class="Block"
><flow_mat
class="FORMATTED_TEXT_BLOCK"
><material
><mat_extension
><mat_formattedtext
type="HTML"
></mat_formattedtext
></mat_extension
></material
></flow_mat
></flow_mat
></itemfeedback
><itemfeedback
ident="solution"
view="All"
><solution
feedbackstyle="Complete"
view="All"
><solutionmaterial
><flow_mat
class="Block"
><material
><mat_extension
><mat_formattedtext
type="HTML"
>  Answers may vary</mat_formattedtext
></mat_extension
></material
></flow_mat
></solutionmaterial
></solution
></itemfeedback
></item
>
BB6_XML;
        
        return $xml;
    }
    
    public static function GetBB6TFMCDat()
    {
        $xml = <<<BB6_XML
<?xml version="1.0" encoding="UTF-8"?>
<questestinterop>
	<assessment title="testcategory">
		<assessmentmetadata>
			<bbmd_asi_object_id>827C956E54E74F2285CFA2E83662D3AA</bbmd_asi_object_id>
			<bbmd_asitype>Assessment</bbmd_asitype>
			<bbmd_assessmenttype>Pool</bbmd_assessmenttype>
			<bbmd_sectiontype>Subsection</bbmd_sectiontype>
			<bbmd_questiontype>Multiple Choice</bbmd_questiontype>
			<bbmd_is_from_cartridge>false</bbmd_is_from_cartridge>
			<qmd_absolutescore>0.0,0.0</qmd_absolutescore>
			<qmd_absolutescore_min>0.0</qmd_absolutescore_min>
			<qmd_absolutescore_max>0.0</qmd_absolutescore_max>
			<qmd_assessmenttype>Proprietary</qmd_assessmenttype>
			<qmd_itemtype>Logical Identifier</qmd_itemtype>
			<qmd_levelofdifficulty>School</qmd_levelofdifficulty>
			<qmd_maximumscore>0.0</qmd_maximumscore>
			<qmd_numberofitems>0</qmd_numberofitems>
			<qmd_renderingtype>Proprietary</qmd_renderingtype>
			<qmd_responsetype>Single</qmd_responsetype>
			<qmd_scoretype>Absolute</qmd_scoretype>
			<qmd_status>Normal</qmd_status>
			<qmd_timelimit>0</qmd_timelimit>
			<qmd_weighting>0.0</qmd_weighting>
			<qmd_typeofsolution>Complete</qmd_typeofsolution>
		</assessmentmetadata>
		<rubric view="All">
			<flow_mat class="Block">
				<material>
					<mat_extension>
						<mat_formattedtext type="HTML"/>
					</mat_extension>
				</material>
			</flow_mat>
		</rubric>
		<presentation_material>
			<flow_mat class="Block">
				<material>
					<mat_extension>
						<mat_formattedtext type="HTML"></mat_formattedtext>
					</mat_extension>
				</material>
			</flow_mat>
		</presentation_material>
		<section>
			<sectionmetadata>
				<bbmd_asi_object_id>F1D4095A49BE4F79AE5199A37F0FBF3F</bbmd_asi_object_id>
				<bbmd_asitype>Section</bbmd_asitype>
				<bbmd_assessmenttype>Pool</bbmd_assessmenttype>
				<bbmd_sectiontype>Subsection</bbmd_sectiontype>
				<bbmd_questiontype>Multiple Choice</bbmd_questiontype>
				<bbmd_is_from_cartridge>false</bbmd_is_from_cartridge>
				<qmd_absolutescore>0.0,0.0</qmd_absolutescore>
				<qmd_absolutescore_min>0.0</qmd_absolutescore_min>
				<qmd_absolutescore_max>0.0</qmd_absolutescore_max>
				<qmd_assessmenttype>Proprietary</qmd_assessmenttype>
				<qmd_itemtype>Logical Identifier</qmd_itemtype>
				<qmd_levelofdifficulty>School</qmd_levelofdifficulty>
				<qmd_maximumscore>0.0</qmd_maximumscore>
				<qmd_numberofitems>0</qmd_numberofitems>
				<qmd_renderingtype>Proprietary</qmd_renderingtype>
				<qmd_responsetype>Single</qmd_responsetype>
				<qmd_scoretype>Absolute</qmd_scoretype>
				<qmd_status>Normal</qmd_status>
				<qmd_timelimit>0</qmd_timelimit>
				<qmd_weighting>0.0</qmd_weighting>
				<qmd_typeofsolution>Complete</qmd_typeofsolution>
			</sectionmetadata>
			<item maxattempts="0">
				<itemmetadata>
					<bbmd_asi_object_id>A0F02D342D1149EEB47BFB9A0B853700</bbmd_asi_object_id>
					<bbmd_asitype>Item</bbmd_asitype>
					<bbmd_assessmenttype>Pool</bbmd_assessmenttype>
					<bbmd_sectiontype>Subsection</bbmd_sectiontype>
					<bbmd_questiontype>True/False</bbmd_questiontype>
					<bbmd_is_from_cartridge>false</bbmd_is_from_cartridge>
					<qmd_absolutescore>0.0,1.0</qmd_absolutescore>
					<qmd_absolutescore_min>0.0</qmd_absolutescore_min>
					<qmd_absolutescore_max>1.0</qmd_absolutescore_max>
					<qmd_assessmenttype>Proprietary</qmd_assessmenttype>
					<qmd_itemtype>Logical Identifier</qmd_itemtype>
					<qmd_levelofdifficulty>School</qmd_levelofdifficulty>
					<qmd_maximumscore>0.0</qmd_maximumscore>
					<qmd_numberofitems>0</qmd_numberofitems>
					<qmd_renderingtype>Proprietary</qmd_renderingtype>
					<qmd_responsetype>Single</qmd_responsetype>
					<qmd_scoretype>Absolute</qmd_scoretype>
					<qmd_status>Normal</qmd_status>
					<qmd_timelimit>0</qmd_timelimit>
					<qmd_weighting>0.0</qmd_weighting>
					<qmd_typeofsolution>Complete</qmd_typeofsolution>
				</itemmetadata>
				<presentation>
					<flow class="Block">
						<flow class="QUESTION_BLOCK">
							<flow class="FORMATTED_TEXT_BLOCK">
								<material>
									<mat_extension>
										<mat_formattedtext type="HTML">A data model is a plan for a database design.</mat_formattedtext>
									</mat_extension>
								</material>
							</flow>
							<flow class="FILE_BLOCK">
								<material/>
							</flow>
							<flow class="LINK_BLOCK">
								<material>
									<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
								</material>
							</flow>
						</flow>
						<flow class="RESPONSE_BLOCK">
							<response_lid ident="response" rcardinality="Single" rtiming="No">
								<render_choice maxnumber="0" minnumber="0" shuffle="No">
									<flow_label class="Block">
										<response_label ident="true" rarea="Ellipse" rrange="Exact" shuffle="Yes">
											<flow_mat class="Block">
												<material>
													<mattext charset="us-ascii" texttype="text/plain" xml:space="default">true</mattext>
												</material>
											</flow_mat>
										</response_label>
										<response_label ident="false" rarea="Ellipse" rrange="Exact" shuffle="Yes">
											<flow_mat class="Block">
												<material>
													<mattext charset="us-ascii" texttype="text/plain" xml:space="default">false</mattext>
												</material>
											</flow_mat>
										</response_label>
									</flow_label>
								</render_choice>
							</response_lid>
						</flow>
					</flow>
				</presentation>
				<resprocessing scoremodel="SumOfScores">
					<outcomes>
						<decvar defaultval="0.0" maxvalue="1.0" minvalue="0.0" varname="SCORE" vartype="Decimal"/>
					</outcomes>
					<respcondition title="correct">
						<conditionvar>
							<varequal case="No" respident="response">true</varequal>
						</conditionvar>
						<setvar action="Set" variablename="SCORE">SCORE.max</setvar>
						<displayfeedback feedbacktype="Response" linkrefid="correct"/>
					</respcondition>
					<respcondition title="incorrect">
						<conditionvar>
							<other/>
						</conditionvar>
						<setvar action="Set" variablename="SCORE">0.0</setvar>
						<displayfeedback feedbacktype="Response" linkrefid="incorrect"/>
					</respcondition>
				</resprocessing>
				<itemfeedback ident="correct" view="All">
					<flow_mat class="Block">
						<flow_mat class="FORMATTED_TEXT_BLOCK">
							<material>
								<mat_extension>
									<mat_formattedtext type="HTML"></mat_formattedtext>
								</mat_extension>
							</material>
						</flow_mat>
						<flow_mat class="FILE_BLOCK">
							<material/>
						</flow_mat>
						<flow_mat class="LINK_BLOCK">
							<material>
								<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
							</material>
						</flow_mat>
					</flow_mat>
				</itemfeedback>
				<itemfeedback ident="incorrect" view="All">
					<flow_mat class="Block">
						<flow_mat class="FORMATTED_TEXT_BLOCK">
							<material>
								<mat_extension>
									<mat_formattedtext type="HTML"></mat_formattedtext>
								</mat_extension>
							</material>
						</flow_mat>
						<flow_mat class="FILE_BLOCK">
							<material/>
						</flow_mat>
						<flow_mat class="LINK_BLOCK">
							<material>
								<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
							</material>
						</flow_mat>
					</flow_mat>
				</itemfeedback>
			</item>
                        <item maxattempts="0">
				<itemmetadata>
					<bbmd_asi_object_id>F5463AB1854747E8BC40B3A132A29FC6</bbmd_asi_object_id>
					<bbmd_asitype>Item</bbmd_asitype>
					<bbmd_assessmenttype>Pool</bbmd_assessmenttype>
					<bbmd_sectiontype>Subsection</bbmd_sectiontype>
					<bbmd_questiontype>Multiple Choice</bbmd_questiontype>
					<bbmd_is_from_cartridge>false</bbmd_is_from_cartridge>
					<qmd_absolutescore>0.0,1.0</qmd_absolutescore>
					<qmd_absolutescore_min>0.0</qmd_absolutescore_min>
					<qmd_absolutescore_max>1.0</qmd_absolutescore_max>
					<qmd_assessmenttype>Proprietary</qmd_assessmenttype>
					<qmd_itemtype>Logical Identifier</qmd_itemtype>
					<qmd_levelofdifficulty>School</qmd_levelofdifficulty>
					<qmd_maximumscore>0.0</qmd_maximumscore>
					<qmd_numberofitems>0</qmd_numberofitems>
					<qmd_renderingtype>Proprietary</qmd_renderingtype>
					<qmd_responsetype>Single</qmd_responsetype>
					<qmd_scoretype>Absolute</qmd_scoretype>
					<qmd_status>Normal</qmd_status>
					<qmd_timelimit>0</qmd_timelimit>
					<qmd_weighting>0.0</qmd_weighting>
					<qmd_typeofsolution>Complete</qmd_typeofsolution>
				</itemmetadata>
				<presentation>
					<flow class="Block">
						<flow class="QUESTION_BLOCK">
							<flow class="FORMATTED_TEXT_BLOCK">
								<material>
									<mat_extension>
										<mat_formattedtext type="HTML">Which of the following is not a key element of an E-R model?</mat_formattedtext>
									</mat_extension>
								</material>
							</flow>
							<flow class="FILE_BLOCK">
								<material/>
							</flow>
							<flow class="LINK_BLOCK">
								<material>
									<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
								</material>
							</flow>
						</flow>
						<flow class="RESPONSE_BLOCK">
							<response_lid ident="response" rcardinality="Single" rtiming="No">
								<render_choice maxnumber="0" minnumber="0" shuffle="Yes">
									<flow_label class="Block">
										<response_label ident="60FD12D7221A440FBBE401F3AAAC7898" rarea="Ellipse" rrange="Exact" shuffle="Yes">
											<flow_mat class="FORMATTED_TEXT_BLOCK">
												<material>
													<mat_extension>
														<mat_formattedtext type="HTML">Attributes</mat_formattedtext>
													</mat_extension>
												</material>
											</flow_mat>
											<flow_mat class="FILE_BLOCK">
												<material/>
											</flow_mat>
											<flow_mat class="LINK_BLOCK">
												<material>
													<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
												</material>
											</flow_mat>
										</response_label>
									</flow_label>
									<flow_label class="Block">
										<response_label ident="85A03A9594D046B8BA4DDED5A580A687" rarea="Ellipse" rrange="Exact" shuffle="Yes">
											<flow_mat class="FORMATTED_TEXT_BLOCK">
												<material>
													<mat_extension>
														<mat_formattedtext type="HTML">Relationships</mat_formattedtext>
													</mat_extension>
												</material>
											</flow_mat>
											<flow_mat class="FILE_BLOCK">
												<material/>
											</flow_mat>
											<flow_mat class="LINK_BLOCK">
												<material>
													<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
												</material>
											</flow_mat>
										</response_label>
									</flow_label>
									<flow_label class="Block">
										<response_label ident="3FEE7F3B62D84E2593BFD0E04A751564" rarea="Ellipse" rrange="Exact" shuffle="Yes">
											<flow_mat class="FORMATTED_TEXT_BLOCK">
												<material>
													<mat_extension>
														<mat_formattedtext type="HTML">Entities</mat_formattedtext>
													</mat_extension>
												</material>
											</flow_mat>
											<flow_mat class="FILE_BLOCK">
												<material/>
											</flow_mat>
											<flow_mat class="LINK_BLOCK">
												<material>
													<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
												</material>
											</flow_mat>
										</response_label>
									</flow_label>
									<flow_label class="Block">
										<response_label ident="30899B68515049FB8A144400B786333A" rarea="Ellipse" rrange="Exact" shuffle="Yes">
											<flow_mat class="FORMATTED_TEXT_BLOCK">
												<material>
													<mat_extension>
														<mat_formattedtext type="HTML">Objects</mat_formattedtext>
													</mat_extension>
												</material>
											</flow_mat>
											<flow_mat class="FILE_BLOCK">
												<material/>
											</flow_mat>
											<flow_mat class="LINK_BLOCK">
												<material>
													<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
												</material>
											</flow_mat>
										</response_label>
									</flow_label>
									<flow_label class="Block">
										<response_label ident="94FC7B32387D4308A2C25E0F33FE24E1" rarea="Ellipse" rrange="Exact" shuffle="Yes">
											<flow_mat class="FORMATTED_TEXT_BLOCK">
												<material>
													<mat_extension>
														<mat_formattedtext type="HTML">Identifiers</mat_formattedtext>
													</mat_extension>
												</material>
											</flow_mat>
											<flow_mat class="FILE_BLOCK">
												<material/>
											</flow_mat>
											<flow_mat class="LINK_BLOCK">
												<material>
													<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
												</material>
											</flow_mat>
										</response_label>
									</flow_label>
								</render_choice>
							</response_lid>
						</flow>
					</flow>
				</presentation>
				<resprocessing scoremodel="SumOfScores">
					<outcomes>
						<decvar defaultval="0.0" maxvalue="1.0" minvalue="0.0" varname="SCORE" vartype="Decimal"/>
					</outcomes>
					<respcondition title="correct">
						<conditionvar>
							<varequal case="No" respident="response">30899B68515049FB8A144400B786333A</varequal>
						</conditionvar>
						<setvar action="Set" variablename="SCORE">SCORE.max</setvar>
						<displayfeedback feedbacktype="Response" linkrefid="correct"/>
					</respcondition>
					<respcondition title="incorrect">
						<conditionvar>
							<other/>
						</conditionvar>
						<setvar action="Set" variablename="SCORE">0.0</setvar>
						<displayfeedback feedbacktype="Response" linkrefid="incorrect"/>
					</respcondition>
				</resprocessing>
				<itemfeedback ident="correct" view="All">
					<flow_mat class="Block">
						<flow_mat class="FORMATTED_TEXT_BLOCK">
							<material>
								<mat_extension>
									<mat_formattedtext type="HTML"></mat_formattedtext>
								</mat_extension>
							</material>
						</flow_mat>
						<flow_mat class="FILE_BLOCK">
							<material/>
						</flow_mat>
						<flow_mat class="LINK_BLOCK">
							<material>
								<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
							</material>
						</flow_mat>
					</flow_mat>
				</itemfeedback>
				<itemfeedback ident="incorrect" view="All">
					<flow_mat class="Block">
						<flow_mat class="FORMATTED_TEXT_BLOCK">
							<material>
								<mat_extension>
									<mat_formattedtext type="HTML"></mat_formattedtext>
								</mat_extension>
							</material>
						</flow_mat>
						<flow_mat class="FILE_BLOCK">
							<material/>
						</flow_mat>
						<flow_mat class="LINK_BLOCK">
							<material>
								<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
							</material>
						</flow_mat>
					</flow_mat>
				</itemfeedback>
				<itemfeedback ident="60FD12D7221A440FBBE401F3AAAC7898" view="All">
					<solution feedbackstyle="Complete" view="All">
						<solutionmaterial>
							<flow_mat class="Block">
								<flow_mat class="FORMATTED_TEXT_BLOCK">
									<material>
										<mat_extension>
											<mat_formattedtext type="HTML"></mat_formattedtext>
										</mat_extension>
									</material>
								</flow_mat>
								<flow_mat class="FILE_BLOCK">
									<material/>
								</flow_mat>
								<flow_mat class="LINK_BLOCK">
									<material>
										<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
									</material>
								</flow_mat>
							</flow_mat>
						</solutionmaterial>
					</solution>
				</itemfeedback>
				<itemfeedback ident="85A03A9594D046B8BA4DDED5A580A687" view="All">
					<solution feedbackstyle="Complete" view="All">
						<solutionmaterial>
							<flow_mat class="Block">
								<flow_mat class="FORMATTED_TEXT_BLOCK">
									<material>
										<mat_extension>
											<mat_formattedtext type="HTML"></mat_formattedtext>
										</mat_extension>
									</material>
								</flow_mat>
								<flow_mat class="FILE_BLOCK">
									<material/>
								</flow_mat>
								<flow_mat class="LINK_BLOCK">
									<material>
										<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
									</material>
								</flow_mat>
							</flow_mat>
						</solutionmaterial>
					</solution>
				</itemfeedback>
				<itemfeedback ident="3FEE7F3B62D84E2593BFD0E04A751564" view="All">
					<solution feedbackstyle="Complete" view="All">
						<solutionmaterial>
							<flow_mat class="Block">
								<flow_mat class="FORMATTED_TEXT_BLOCK">
									<material>
										<mat_extension>
											<mat_formattedtext type="HTML"></mat_formattedtext>
										</mat_extension>
									</material>
								</flow_mat>
								<flow_mat class="FILE_BLOCK">
									<material/>
								</flow_mat>
								<flow_mat class="LINK_BLOCK">
									<material>
										<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
									</material>
								</flow_mat>
							</flow_mat>
						</solutionmaterial>
					</solution>
				</itemfeedback>
				<itemfeedback ident="30899B68515049FB8A144400B786333A" view="All">
					<solution feedbackstyle="Complete" view="All">
						<solutionmaterial>
							<flow_mat class="Block">
								<flow_mat class="FORMATTED_TEXT_BLOCK">
									<material>
										<mat_extension>
											<mat_formattedtext type="HTML"></mat_formattedtext>
										</mat_extension>
									</material>
								</flow_mat>
								<flow_mat class="FILE_BLOCK">
									<material/>
								</flow_mat>
								<flow_mat class="LINK_BLOCK">
									<material>
										<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
									</material>
								</flow_mat>
							</flow_mat>
						</solutionmaterial>
					</solution>
				</itemfeedback>
				<itemfeedback ident="94FC7B32387D4308A2C25E0F33FE24E1" view="All">
					<solution feedbackstyle="Complete" view="All">
						<solutionmaterial>
							<flow_mat class="Block">
								<flow_mat class="FORMATTED_TEXT_BLOCK">
									<material>
										<mat_extension>
											<mat_formattedtext type="HTML"></mat_formattedtext>
										</mat_extension>
									</material>
								</flow_mat>
								<flow_mat class="FILE_BLOCK">
									<material/>
								</flow_mat>
								<flow_mat class="LINK_BLOCK">
									<material>
										<mattext charset="us-ascii" texttype="text/plain" uri="" xml:space="default"/>
									</material>
								</flow_mat>
							</flow_mat>
						</solutionmaterial>
					</solution>
				</itemfeedback>
			</item>

		</section>
	</assessment>
</questestinterop>
BB6_XML;
        
        return $xml;
    }
    
    
}

?>
