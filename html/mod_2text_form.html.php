<?php
if (!isset($end)) $end="<br>";

if (isset($titreform) && strlen($titreform) > 0)
	echo "<h2 style=\"text-align:center\">".$titreform."<h2>";

echo "<form action=\"index.php?EX=".$act."&DO=".$DO."\" method=\"POST\" class=\"formcss\" name=\"$formname\">";

$nb=count($field);

for ( $i=0; $i<$nb; $i++ )
    echo $txt_field[$i]."<input type=\"text\" name=\"".$field[$i]."\" class=\"formcss\" value=\"".$field_value[$i]."\">$end\n";

if (isset($id)) { 
    echo "<input type=\"hidden\" name=\"id\" value=\"$id\">\n";
}

echo"
    <input type=\"submit\" name=\"$txt_submit\" class=\"formcss\" value=\"$txt_submit\">
</form>
";
?>
