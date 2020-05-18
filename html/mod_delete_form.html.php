<?php
$end="<br>";
echo "<form action=\"index.php?EX=".$act."&DO=".$DO."\" method=\"POST\" class=\"formcss\" name=\"$formname\">";
echo $txt;
echo "<input type=\"hidden\" name=\"id\" value=\"$id\">\n";
echo "
<input type=\"submit\" name=\"$txt_submit\" class=\"formcss\" value=\"$txt_submit\"> 
<a href=\"index.php?EX=".$act."&DO=".EDIT."\" class=\"cancel\">$txt_cancel</a> 
</form>";
?>
