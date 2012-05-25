<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Moodle XML Importer</title>
    </head>
    <body>
        <?php echo form_open('converthtml/review'); ?>
            <h1>Moodle XML Importer</h1>
            <h2>Convert HTML quiz to Moodle XML</h2>
            File to upload: <input type="text"> <input type="button" value="Browse..."><br />
            OR <br />
            Paste HTML markup below:<br />
            <?php echo form_textarea('htmlInput', '') ?><br />
            <?php echo form_submit('submit', 'Review') ?>
        <?php echo form_close() ?>
    </body>
</html>
