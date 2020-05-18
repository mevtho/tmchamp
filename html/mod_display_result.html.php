<div align="center">
<table class="<?php echo $class; ?>">
    <tr class="<?php echo $class; ?>">
        <td class="<?php echo $class; ?>">
            <?php
                for ( $i=0 ; $i < count($teams) ; ++$i ) {
                    echo "<div class=\"".$class."\" onclick=\"sendData('id=+".$teams[$i][0]."','index.php?EX=".AJAX."&DO=".RESULT."','results')\">".$teams[$i][1]."</div>\n";
                }
            ?>
        </td>
        <td id="results">
            <?php echo seasonStats(TEAM,$id); ?>
        </td>
    </tr>
</table>
</div>
