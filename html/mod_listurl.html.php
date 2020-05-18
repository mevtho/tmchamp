<?php
    echo "<ul class='$class'>";
    foreach ( $items as $key => $value ) {
        echo "<li class='$class'><a href='$value' class='$class'>$key</a></li>";
    }
    echo "</ul>";
?>

