<?php
    if ($_title) echo $titre."\n";
    echo txt(txtNB_MATCHS_PREVUS,true)." : ".$stats['Total']."<br>\n";
    echo txt(txtNB_MATCHS_JOUES,true)." : ".($stats['Victoire']+$stats['Defaite']+$stats['Nul'])."<br>\n";
    if ( $stats['Forfait'] > 0 ) echo txt(txtNB_MATCHS_FORFAITS,true)." pour cause de forfait : ".$stats['Forfait']."<br>\n";
    echo $stats['Victoire']." ".(($stats['Victoire']<=1)?txt(txtVICTOIRE):txt(txtVICTOIRES))."<br>\n";
    echo $stats['Defaite']." ".(($stats['Defaite']<=1)?txt(txtDEFAITE):txt(txtDEFAITES))."<br>\n";
    if ( $stats['Nul'] > 0 ) echo $stats['Nul']." ".(($stats['Nul']<=1)?txt(txtMATCH_NUL,true):txt(txtMATCHS_NULS,true))."<br>\n";
?>    

