<?php 
    if ( count($sel) > 0 ) {
        echo "<table class=\"$class[0]\">";
        for ($i=0; $i<count($sel); ++$i )
            echo "<tr>
                      <td class=\"".$class[0]."\">".$sel[$i][1]."</td>
                      <td class=\"".$class[1]."\"><a href=\"".$lnk[0].$sel[$i][0]."\">".$fct[0]."</a></td>
                      <td class=\"".$class[1]."\"><a href=\"".$lnk[1].$sel[$i][0]."\">".$fct[1]."</a></td>
                  </tr>\n";
        echo "</table>";
    }
    else {
        echo "<span class=\"".$class[0]."\">".$none."<span><br>";
    }
?>    
