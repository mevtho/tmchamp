<?php
if ( isset($_POST['id']) ) {
    switch ($DO) {
        case GAME :
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $line=explode(",",$_POST['id']);
                $idEquipe=(!empty($line[0]))?(int)$line[0]:-1;
                $idCompetition=(!empty($line[1]))?(int)$line[1]:-1;
                $date=(!empty($line[2]))?$line[2]:-1;
            }
            Matchs ($idEquipe,$idCompetition,$date);
            break;
        case RESULT :
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $line=$_POST['id'];
                $idEquipe=(int)$line;
            }
            seasonStats(TEAM,$idEquipe);  
            if (!toprint()){  
                echo "<br>[ <a href=\"index.php?EX=".TEAM."&id=".$idEquipe."\">".txt(txtDETAILS,true)."</a> ]";
                echo "[ <a href=\"index.php?EX=".GAME."&ide=".$idEquipe."\">".txt(txtLISTE_MATCHS,true)."</a> ]";
            }
            break;
        case COURT ;
            echo "<option value=\"-1\" selected></option>\n";
            $id=(isset($_POST['id']) && !empty($_POST['id']))?$_POST['id']:-1;
            $p=explode(":",$id);
            $id=$p[0];
            $idT=$p[1];
            if ($id!=-1) {
                $away=getTerrainClub((int)$id);
                $home=getTerrainClub((int)$conf['idclub']);
                for ($i=0;$i<count($home);++$i) {
                    echo "<option value=\"".$home[$i][0]."\" ".(($idT==$home[$i][0])?"selected":"").">".$home[$i][1]."</option>\n";
                }
                echo "<option value=\"-1\">----------</option>\n";
                for ($i=0;$i<count($away);++$i) {
                    echo "<option value=\"".$away[$i][0]."\" ".(($idT==$away[$i][0])?"selected":"").">".$away[$i][1]."</option>\n";
                }
            
                $idC=occupant($idT);
                if (($idC!=$conf['idclub']) && ($idC!=$val['Club_idClub'])) {
                    echo "<option value=\"-1\">----------</option>\n";
                    $v=selTerrain("idTerrain=".$idT);
                    echo "<option value=\"".$v[0][0]."\" selected>".$v[0][1]."</option>\n";
                }        
            }
            else {
                $court=getTerrainClub();
                for ($i=0;$i<count($court);++$i) {
                    echo "<option value=\"".$court[$i][0]."\" ".(($idT==$court[$i][0])?"selected":"").">".$court[$i][1]."</option>\n";
                }
            }
            break;
        case TIME :
            $id=(isset($_POST['id']) && !empty($_POST['id']))?$_POST['id']:-1;
            if ($id!=-1) {
                $time=getGameTime($id);
                if ($time=="00:00") $time=txt(txtTIME_FORMAT);
                echo $time;
            }
            else {
                echo txt(txtTIME_FORMAT);
            }
            break;
        case USERS :
            global $dblink;
            $sel=getListItems(TEAM);

            $id=(isset($_POST['id']) && !empty($_POST['id']))?$_POST['id']:-1;
            $sql="select * from ".TABLE_CANUPDATE." where Users_idUser=".$id;
            $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            while ($line=mysqli_fetch_assoc($res))
                $row[]=$line['Equipe_idEquipe'];
           
            echo txt(txtEQUIPEAGERER,true)." :"; 
            echo "<table  cellpadding=\"5\">\n";
            for ($i=0;$i<count($sel);++$i) {
                $checked="";    
                for ($j=0; $j<count($row);++$j) {
                    if ($row[$j]==$sel[$i][0]) { $checked="checked"; break; }    
                }
                echo (($i%2==0)?"\t<tr>\n":"")."\t\t<td><input type=\"checkbox\" name=\"team['".$sel[$i][0]."']\" value=\"".$sel[$i][0]."\" $checked>".txt($sel[$i][1])."</input></td>".(($i%2)?"</tr>\n":"\n");
                
            }    
            if (!$i%2) echo "\t</tr>\n";                    
            echo "</table>\n";
 
            break;
        default : echo "default"; 
            break;
    }

}

?>

