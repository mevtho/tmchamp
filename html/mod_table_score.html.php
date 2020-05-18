<div align="center">
<table class="<?php echo $class; ?>" cellspacing="0" cellpadding="0">
<tr><th></th><th><?php echo txt(txtDATE,true); ?></th><th><?php echo ($competitionInsteadOfTeam)?txt(txtTYPE_RENCONTRE,true):txt(txtEQUIPE,true); ?></th><th><?php echo txt(txtADVERSAIRE,true); ?></th><th><?php echo txt(txtSCORE,true); ?></th></tr>
<?php
    $nb=count($line);
    for ($i=0;$i<$nb;$i++) {
        // Victoire / Défaite / ... //    
        $j=($line[$i]['ScorePour']==-1 || $line[$i]['ScoreContre']==-1)?"<img src=\"img/design/question.png\">":(($line[$i]['ScorePour']==$line[$i]['ScoreContre'])?"<img src=\"img/design/equal.png\">":(($line[$i]['ScorePour']>$line[$i]['ScoreContre'])?"<img src=\"img/design/win.png\">":"<img src=\"img/design/lost.png\">"));

        $time=($line[$i]['Heure']!="00:00:00")?$line[$i]['Heure']:"";  
        
        $disp=((strlen($line[$i]['urlLocalisationTerrain']))?"<a href='".$line[$i]['urlLocalisationTerrain']."\'>".$line[$i]['nomTerrain']."</a>":$line[$i]['nomTerrain']).((strlen($line[$i]['nomVille'])>0)?' ( '.((strlen($line[$i]['rueTerrain'])>0)?$line[$i]['rueTerrain'].", ":"").''.$line[$i]['nomVille'].' )':'');
        $disp.=(((strlen($disp)>0) && (strlen($line[$i]['nomType'])>0))?" - ":"").$line[$i]['nomType'];
        $disp.=(((strlen($disp)>0) && (strlen($time)>0))?" - ":"").((strlen($time)>0)?dispheure($time):"");
        $disp=((strlen($disp)>0)?' <img src=\'img/design/dir.png\'> ':'').$disp; 

      
        if ($EX==PRINTABLE) {
            $js="onload=\"$dispterrain\"";  
            $view=stripslashes($disp);
        }
        else {
//            $js="onmouseover=\"javascript:getElementById('lieu".$line[$i]['idMatchs']."').innerHTML='".addslashes($disp)."';\" onmouseout=\"javascript:getElementById('lieu".$line[$i]['idMatchs']."').innerHTML='';\"";
            $js="onclick=\"javascript:if (getElementById('lieu".$line[$i]['idMatchs']."').innerHTML.length==0) getElementById('lieu".$line[$i]['idMatchs']."').innerHTML='".addslashes($disp)."'; else getElementById('lieu".$line[$i]['idMatchs']."').innerHTML='';\"";
            
            // Domicile / Extérieur //
            $j.="<img src=\"".(($line[$i]['Terrain_idTerrain']==0)?"img/design/question.png":((aDomicile($line[$i]['Terrain_idTerrain']))?"img/design/home.png":"img/design/car.png"))."\" >";
        }

        if ((loggedAsUpdater() || $vd ) && !toprint()) {
            $j="<a href=\"index.php?EX=".SCORE."&DO=".EDIT."&id=".$line[$i]['idMatchs']."\"><img src=\"img/design/digit.png\"></a>".$j." ";
        }

        $score=( $line[$i]['ScorePour'] !=-1 && $line[$i]['ScoreContre'] !=-1 )?($line[$i]['ScorePour']." - ".$line[$i]['ScoreContre']):"";
        echo "\t\t<tr class=\"selRow\" ".$js."><td>$j</td><td class=\"scoreA\">".datetostr($line[$i]['Date'])."</td><td class=\"scoreB\">".(($competitionInsteadOfTeam)?$line[$i]['nomType']:$line[$i]['nomEquipe'])."</td><td class=\"scoreC\">".$line[$i]['nomClubComplet']."</td><td class=\"scoreD\">".$score."</td></tr>\n";
        echo "\t\t<tr><td colspan=\"5\" padding=\"0\" class=\"lieu\" id=\"lieu".$line[$i]['idMatchs']."\">$view</td></tr>\n";
    }
?>            
</table>
</div>
<br><br>
<?php
    if (!toprint()) {
?>
<div align="right"><?php echo $printText ?></div>
<?php
    }
?>
