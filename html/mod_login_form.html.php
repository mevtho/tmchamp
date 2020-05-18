<?php
echo "
<form action=\"$act\" method=\"$method\" class=\"$class\">
	$txt_username <input type=\"text\" name=\"username\" class=\"$class\" value=\"\">$end
	$txt_password <input type=\"password\" name=\"pwd\" class=\"$class\" value=\"\">$end
	<input type=\"submit\" name=\"$txt_submit\" class=\"$class\"value=\"$txt_submit\"> 
</form>
";
?>
