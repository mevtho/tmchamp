<h1><?php echo $equipe; ?></h1>
<?php
    if (strlen($coach)>0) echo "<b>".txt(txtCOACH,true)." : </b>".$coach."<br>";
    if (strlen($categorie)>0) echo "<b>".txt(txtCATEGORIE,true)." : </b>".$categorie."<br>";
    if (strlen($division)>0) echo "<b>".txt(txtDIVISION,true)." : </b>".$division."<br>";
    if (strlen($coach+$categorie+$division)>0) echo "<br>\n";
?>

