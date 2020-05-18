<?php
$end="<br>\n";
echo "<form action=\"index.php?EX=".$act."&DO=".$DO."\" method=\"POST\" class=\"formcss\" name=\"$formname\">\n";

echo "$txt_field[0]<select name=\"$field[0]\" id=\"club\" class=\"formcss\" onchange=\"sendData('id='+this.value+':-1','index.php?EX=".AJAX."&DO=".COURT."','terrain');\" onkeyup=\"sendData('id='+this.value+':-1','index.php?EX=".AJAX."&DO=".COURT."','terrain');\">\n";
echo "<option value=\"-1\" selected></option>\n";
$nb=count($sel[0]);        
for ($i=0;$i<$nb;$i++) {
    echo "<option value=\"".$sel[0][$i][0]."\" ".(($field_value[0]==$sel[0][$i][0])?"selected":"").">".$sel[0][$i][1]."</option>\n";
}
echo "</select>$end";


echo "$txt_field[1]<select name=\"$field[1]\" class=\"formcss\" onchange=\"sendDataInput('id='+this.value,'index.php?EX=".AJAX."&DO=".TIME."','heure');\" onkeyup=\"sendDataInput('id='+this.value,'index.php?EX=".AJAX."&DO=".TIME."','heure');\">\n";
echo "<option value=\"-1\" selected></option>\n";         
$nb=count($sel[1]);        
for ($i=0;$i<$nb;$i++) {
    echo "<option value=\"".$sel[1][$i][0]."\" ".(($field_value[1]==$sel[1][$i][0])?"selected":"").">".$sel[1][$i][1]."</option>\n";
}
echo "</select>$end";


echo "
$txt_field[2]<input type=\"text\" name=\"$field[2]\" class=\"formcss\" value=\"$field_value[2]\" >$end\n
$txt_field[3]<input type=\"text\" name=\"$field[3]\" id=\"heure\" class=\"formcss\" value=\"$field_value[3]\">$end\n 
";


echo "$txt_field[4]<select name=\"$field[4]\" class=\"formcss\">\n";
echo "<option value=\"-1\" selected></option>\n";         
$nb=count($sel[2]);        
for ($i=0;$i<$nb;$i++) {
    echo "<option value=\"".$sel[2][$i][0]."\" ".(($field_value[4]==$sel[2][$i][0])?"selected":"").">".$sel[2][$i][1]."</option>\n";
}
echo "</select>$end";


echo "$txt_field[5]<select name=\"$field[5]\" class=\"formcss\" id=\"terrain\">\n";
echo "<option value=\"-1\" selected></option>\n";         
$nb=count($sel[3]);        
for ($i=0;$i<$nb;$i++) {
    echo "<option value=\"".$sel[3][$i][0]."\" ".(($field_value[5]==$sel[3][$i][0])?"selected":"").">".$sel[3][$i][1]."</option>\n";
}
echo "</select> $end";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"checkbox\" onclick=\"javascript:if (this.checked) sendData('id=-1:'+getElementById('terrain').value,'index.php?EX=".AJAX."&DO=".COURT."','terrain'); else sendData('id='+getElementById('club').value+':'+getElementById('terrain').value,'index.php?EX=".AJAX."&DO=".COURT."','terrain');\" unchecked>".txt(txtAUTRE,true)."</input>";
echo $end."<div id=\"ter_rain\"></div>";

echo "
$txt_field[6]<input type=\"text\" name=\"$field[6]\" class=\"formcss\" value=\"$field_value[6]\" >$end\n
$txt_field[7]<input type=\"text\" name=\"$field[7]\" class=\"formcss\" value=\"$field_value[7]\" >$end\n 
$txt_field[9]<br/><textarea name=\"$field[9]\" class=\"formcss\">$field_value[9]</textarea>$end\n 
";

$checked=($field_value[8]==1)?"checked":"";
echo "
<input type=\"checkbox\" name=\"$field[8]\" class=\"formcss\" value=\"$field_value[8]\" $checked>$txt_field[8]</input>$end\n";

if (isset($id)) { 
    echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
}

echo "
<input type=\"submit\" name=\"$txt_submit\" class=\"formcss\"value=\"$txt_submit\"> 
</form>";
?>


