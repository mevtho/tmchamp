<div align="center">
<?php
    if (!toprint()) {
?>

<?php

echo "$txt_field[0] <select name=\"$field[0]\" id=\"$field[0]\" class=\"$class\" OnKeyUp=\"sendData('id='+this.value+','+document.getElementById('".$field[1]."').value+','+document.getElementById('".$field[2]."').value,'index.php?EX=".AJAX."&DO=".GAME."','contenu')\" OnChange=\"sendData('id='+this.value+','+document.getElementById('".$field[1]."').value+','+document.getElementById('".$field[2]."').value,'index.php?EX=".AJAX."&DO=".GAME."','contenu')\">\n";
echo "<option value=\"-1\" selected></option>\n";         
$nb=count($sel[0]);        
for ($i=0;$i<$nb;$i++) {
    echo "<option value=\"".$sel[0][$i][0]."\" ".(($field_value[0]==$sel[0][$i][0])?"selected":"").">".$sel[0][$i][1]."</option>\n";
}
echo "</select>";


echo "&nbsp; &nbsp;$txt_field[1] <select name=\"$field[1]\" id=\"$field[1]\" class=\"$class\"  OnKeyUp=\"sendData('id='+document.getElementById('".$field[0]."').value+','+this.value+','+document.getElementById('".$field[2]."').value,'index.php?EX=".AJAX."&DO=".GAME.",'contenu')\" OnChange=\"sendData('id='+document.getElementById('".$field[0]."').value+','+this.value+','+document.getElementById('".$field[2]."').value,'index.php?EX=".AJAX."&DO=".GAME."','contenu')\">\n";
echo "<option value=\"-1\" selected></option>\n";         
$nb=count($sel[1]);        
for ($i=0;$i<$nb;$i++) {
    echo "<option value=\"".$sel[1][$i][0]."\" ".(($field_value[1]==$sel[1][$i][0])?"selected":"").">".$sel[1][$i][1]."</option>\n";
}
echo "</select>";


echo "&nbsp; &nbsp;$txt_field[2] <select name=\"$field[2]\" id=\"$field[2]\" class=\"$class\"  OnKeyUp=\"sendData('id='+document.getElementById('".$field[0]."').value+','+document.getElementById('".$field[1]."').value+','+this.value,'index.php?EX=".AJAX."&DO=".GAME."','contenu')\" OnChange=\"sendData('id='+document.getElementById('".$field[0]."').value+','+document.getElementById('".$field[1]."').value+','+this.value,'index.php?EX=".AJAX."&DO=".GAME."','contenu')\">\n";
echo "<option value=\"-1\" selected></option>\n";         
$nb=count($sel[2]);        
for ($i=0;$i<$nb;$i++) {
    echo "<option value=\"".$sel[2][$i][0]."\" ".(($field_value[1]==$sel[2][$i][0])?"selected":"").">".$sel[2][$i][1]."</option>\n";
}
echo "</select>";

?>

<hr border="0" width="300px">

<?php
    }
?>

<div id="contenu"><?php Matchs($ide,$idc,$date,$ida) ; ?></div>



</div>

