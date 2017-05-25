<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $template->getTitle(); ?></title>
        <link rel="stylesheet" type="text/css" href="/css/default.css">
        <?php echo $template->getMeta(); ?>
        <style>
<?php echo $template->getCSS(); ?>
        </style>
    </head>
    <body>
        <?php echo $template->getHeader(); ?>
        <?php echo $template->getBody(); ?>
        <?php echo $template->getFooter(); ?>
        <script type="text/javascript">
<?php echo $template->getJavascript(); ?>
        </script>
    </body>
</html>