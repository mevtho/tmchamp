<html>
<head>
<?php styleprint.css.php ?>
<title><?php echo $conf['title']; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo PRINT_CSS; ?>">
<?php getHeadItems(); ?>
</head>
<body class="content">
    <div align="center"><img src=img/club/logobw.gif></div><br><br>
    <?php content(); ?>
</body>
</html>
