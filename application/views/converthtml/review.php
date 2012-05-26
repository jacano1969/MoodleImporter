<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/importer.css" />
    </head>
    <body>
        <script type="text/javascript" src="<?php echo base_url();?>scripts/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>scripts/modalwindow.js"></script>
        <script type="text/javascript">
            function checkAll(checkOn)
            {
                $('.shuffle').prop("checked", checkOn);
                return false;
            }
        
            function setPoints()
            {
                $('.points').prop("value", $('#defaultPoints').val());
                return false;
            }
            
            $(document).ready(function() {
                $('a[name=modal]').click(function() {
                   $('#question').html('Retrieving...');
                   $.ajax({
                       type: "POST",
                       data: "quizID=" + $(this).attr('title'),
                       url: "<?php echo site_url();?>/converthtml/reviewitem",
                       success: function(msg) {
                           $('#question').html(msg);
                       }
                   });
                });
                
            });
        </script>

        <div id="boxes">
            <div id="dialog" class="window">
                <div id="question">
                    
                </div>
                <!-- close button is defined as close class -->
                <a href="#" class="close">Close</a>
            </div>
            <!-- Do not remove div#mask, because you'll need it to fill the whole screen --> 
            <div id="mask"></div>
        </div>
        <h1>Moodle XML Importer</h1>
        <h2>The test file you provided contained the questions below:</h2>
        <?php echo form_open('converthtml/convert'); ?>
        Please enter a category for import: <?php echo form_input('category', $quiz->Category) ?><br />
        <?php echo form_checkbox() ?>Apply Team-Based Learning Scoring Template to all Multiple Choice Questions<br />
        <table border="1" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th>Question Name</th>
                    <th>Question Text</th>
                    <th>Shuffle Answers<br/><a href="test" onclick="return checkAll(true)">Mark All</a> | <a href="test2" onclick="return checkAll(false)">Unmark All</a></th>
                    <th>Point Value<br/>
                    <?php echo form_input('defaultPoints', '1', 'id="defaultPoints"') ?><input type="button" onclick="return setPoints()" value="Apply to all" /></th>
                </tr>
            </thead>
            <?php

                foreach ($quiz->Items as $item)
                {
                    echo '<tr>';
                    echo '<td><a name="modal" href="#dialog" title="' . $item->ID . '">' . $item->Name . '</a></td>';
                    echo '<td>' . $item->Text . '</td>';
                    if (property_exists($item, 'ShuffleAnswers'))
                    {
                        // @todo Enable the Mark All and Unmark All links to set/reset shuffle checkboxes
                        $shuffle = $item->ShuffleAnswers;
                    }
                    else
                    {
                        $shuffle = 'N/A';
                    }
                    echo '<td>' . ($shuffle !== 'N/A' ? form_checkbox($item->ID . 'shuffle', 'shuffle', $shuffle, 'class="shuffle"') : 'N/A') . '</td>';
                    echo '<td>' . form_input($item->ID . 'points', $item->PointValue, 'class="points"') . '</td>';
                    echo '</tr>';
                }
            ?>
        </table>
        <?php 
            echo form_button('mybutton', 'Back', 'onClick="history.go(-1)"'); 
            echo form_submit('converthtml/retrieve', 'Convert');
            echo form_close();
        ?>
        

    </body>
</html>
