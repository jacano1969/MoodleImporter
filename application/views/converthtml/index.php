<?php
/**
 * @package MoodleXMLImporter 
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Moodle XML Importer</title>
    </head>
    <body>
        <?php echo form_open('converthtml/review', 'enctype="multipart/form-data"'); ?>
            <h1>Moodle XML Importer</h1>
            <h2>Convert HTML quiz to Moodle XML</h2>
            File to upload: <input type="file" name="uploadFile" id="uploadFile"><br />
            OR <br />
            Paste HTML markup below:<br />
            <?php echo form_textarea('htmlInput', '') ?><br />
            <?php echo form_submit('submit', 'Review') ?>
        <?php echo form_close() ?>
    </body>
</html>
