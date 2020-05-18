<?php
    echo "<div align=\"center\"><table><tr valign=\"top\">\n";
    $nb=count($list);
    for ( $i=0; $i<$nb; ++$i ) {
        echo "<td class=\"$class\" onclick=\"javascript:getElementById('id".$i."').innerHTML='<a href=\'index.php?EX=".$act[$i]."&DO=".ADD."\' class=\'".$class."\'>".$add."</a> | <a href=\'index.php?EX=".$act[$i]."&DO=".EDIT."\' class=\'".$class."\'>".$edit."</a>';\">".$list[$i]."</td>\n";
        if ($i%7==6) echo "</tr><tr>\n";
    }
    echo "</tr></table></div>\n";
?>

