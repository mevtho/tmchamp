<?php
$end="<br>";
echo "<form action=\"index.php?EX=".$act."&DO=".$DO."\" method=\"POST\" class=\"formcss\" name=\"$formname\">";

echo "
$txt_field[0]<input type=\"text\" name=\"$field[0]\" class=\"formcss\" value=\"$field_value[0]\" >$end\n
$txt_field[1]<input type=\"text\" name=\"$field[1]\" class=\"formcss\" value=\"$field_value[1]\" >$end\n 
$txt_field[2]<input type=\"text\" name=\"$field[2]\" class=\"formcss\" value=\"$field_value[2]\" >$end\n";

echo "$txt_field[3]<select name=\"$field[3]\" class=\"formcss\">\n";
echo "<option value=\"-1\"></option>\n";         
$nb=count($sel);        
for ($i=0;$i<$nb;$i++) {
    echo "<option value=\"".$sel[$i][0]."\" ".(($field_value[3]==$sel[$i][0])?"selected":"").">".$sel[$i][1]."</option>\n";
}
echo "</select>$end";

echo "
$txt_field[4]<input type=\"text\" name=\"$field[4]\" class=\"formcss\" value=\"$field_value[4]\" >$end\n
$txt_field[5]<input type=\"text\" name=\"$field[5]\" class=\"formcss\" value=\"$field_value[5]\" >$end\n
$txt_field[6]<input type=\"text\" name=\"$field[6]\" class=\"formcss\" value=\"$field_value[6]\" >$end\n
$txt_field[7]<input type=\"text\" name=\"$field[7]\" class=\"formcss\" value=\"$field_value[7]\" >$end\n
$txt_field[8]<input type=\"text\" name=\"$field[8]\" class=\"formcss\" value=\"$field_value[8]\" >$end\n
";

if (isset($id)) { 
    echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
}

echo "
<input type=\"submit\" name=\"$txt_submit\" class=\"formcss\"value=\"$txt_submit\"> 
</form>";
?>
