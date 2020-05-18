<?php
    echo "<ul class='$class'>\n";
    $nb=count($list);
    for ( $i=0; $i<$nb; ++$i ) {
        echo "<li class='$class'>$list[$i]</li>\n";
    }
    echo "</ul>\n";
?>

