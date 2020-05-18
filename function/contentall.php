<?php
    function seasonStats($_type=-1,$_id=-1,$_title=true) {
        global $dblink, $conf;

        $_type=(int)$_type;
        $_id=(int)$_id;

        $where="";
        $titre="";
        if ($_id!=-1) {
            switch ($_type) {
                case CLUB :
                    $sql="select * from ".TABLE_CLUB." where idClub='$_id'";
                    $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    if (mysqli_num_rows($res)!=1) {
                        if ($_title) $titre="<i>".txt(txtAUCUN." ".txtCLUB." ".txtAVEC_ID)."</i>";
                        $where="";
                    }
                    else {
                        $row=mysqli_fetch_assoc($res);
                        $where=" and Club_idClub='".$_id."'";
                        if ($_title) $titre="<h2>".txt(txtSTATS_CONTRE." ".$row['nomClubComplet'],true)."</h2>";
                    }
                    break;
                case TEAM : 
                    $sql="select * from ".TABLE_EQUIPE." where idEquipe='$_id'";
                    $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    if (mysqli_num_rows($res)!=1) {
                        if ($_title) $titre="<i>".txt(txtAUCUN." ".txtEQUIPE." ".txtAVEC_ID)."</i>";
                        $where="";
                    }
                    else {
                        $row=mysqli_fetch_assoc($res);
                        $where=" and Equipe_idEquipe='".$_id."'";
                        if ($_title) $titre="<h2>".txt(txtSTATS_EQUIPE." ".$row['nomEquipe'],true)."</h2>";
                    }
                    break;
                default :
                    $where="";
                    break;
            }
        }

        if ($where=="") if ($_title) $titre= "<h2>".txt(txtSTATS_CUMULEES,true)."</h2>";
        $stats=array();

        $sql="select count(*) as NB from ".TABLE_MATCHS." where idMatchs!='-1'".$where."";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $row=mysqli_fetch_assoc($res) ;
        $stats['Total']=(int)$row['NB'];

        $sql="select count(*) as NB from ".TABLE_MATCHS." where Forfait='1'".$where."";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $row=mysqli_fetch_assoc($res) ;
        $stats['Forfait']=(int)$row['NB'];

        $sql="select count(*) as NB from ".TABLE_MATCHS." where ScorePour > ScoreContre".$where."";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $row=mysqli_fetch_assoc($res) ;
        $stats['Victoire']=(int)$row['NB'];

        $sql="select count(*) as NB from ".TABLE_MATCHS." where ScorePour < ScoreContre".$where."";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $row=mysqli_fetch_assoc($res) ;
        $stats['Defaite']=(int)$row['NB'];        

        $sql="select count(*) as NB from ".TABLE_MATCHS." where ScorePour = ScoreContre and ScorePour !='-1'".$where."";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $row=mysqli_fetch_assoc($res) ;
        $stats['Nul']=(int)$row['NB'];   

        include(HTML_DIRECTORY."mod_view_stats.html.php");
    } 

    function viewStats () {
        $teams=getListItems(TEAM);
        $class="teamresult";

        $id=(isset($_REQUEST['id']) && !empty($_REQUEST['id']))?(int)$_REQUEST['id']:-1;

        require(HTML_DIRECTORY."mod_display_result.html.php");        
    }

    function viewScores () {
        /************ Select choix equipe *****************/
        $txt_field[0]=txt(txtEQUIPE,true); $field[0]=getSelName(TEAM); $field_value[0]="";
        $sel[0]=selEquipe();
        /**************************************************/

        /************ Select choix comp&eacute;tition**************/
        $txt_field[1]=txt(txtTYPE_RENCONTRE,true); $field[1]=getSelName(TYPE_RENCONTRE); $field_value[1]="";
        $sel[1]=selCompetition();
        /***************************************************/
        
        /************ Select choix comp&eacute;tition**************/
        $txt_field[2]="Date"; $field[2]=getSelName(DAY); $field_value[2]="";
        $sel[2]=getListItems(DAY);
        /***************************************************/
        

        $ide=(isset($_REQUEST['ide']) && !empty($_REQUEST['ide']))?(int)$_REQUEST['ide']:-1;
        $idc=(isset($_REQUEST['idc']) && !empty($_REQUEST['idc']))?(int)$_REQUEST['idc']:-1;    
        $date=(isset($_REQUEST['date']) && !empty($_REQUEST['date']))?$_REQUEST['date']:-1;    
        $ida=(isset($_REQUEST['ida']) && !empty($_REQUEST['ida']))?$_REQUEST['ida']:-1;

        require(HTML_DIRECTORY."mod_display_score.html.php");
    }


    function Matchs ($_idEquipe=-1,$_idCompetition=-1,$_date=-1,$_idAdversaire=-1, $competitionInsteadOfTeam=false) {
        global $dblink,$EX,$conf;

        $class="game";

        $sql="select * 
              from ".TABLE_MATCHS." tm  left join ".TABLE_TERRAIN." tt on Terrain_idTerrain=idTerrain left join ".TABLE_VILLE." on tt.Ville_idVille=idVille, ".TABLE_CLUB.", ".TABLE_EQUIPE.", ".TABLE_TYPEDERENCONTRE."  
              where tm.Club_idClub=idClub and Equipe_idEquipe=idEquipe and idTypeDeRencontre=TypeDeRencontre_idTypeDeRencontre";

        if ( $_idEquipe!=-1 ) {
            $sql.=" and Equipe_idEquipe='$_idEquipe'"; 
        }

        if ( $_idCompetition!=-1 ) {
            $sql.=" and TypeDeRencontre_idTypeDeRencontre='$_idCompetition'"; 
        }

        if ( $_date!=-1 ) {
            $sql.=" and Date='$_date'";
        }

        $sql.=" order by ref ASC, Date ASC,Heure ASC";

        if ( $_idAdversaire!=-1 ) {
            $sql.=" and Club_idClub='$_idAdversaire'"; 
        }

        $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        
        if (mysqli_num_rows($result) == 0) {
            echo "<b>".txt(txtAUCUN." ".txtMATCH,true)."</b><br><br>";
        }
        else {
            $i=0;
            $line=Array();
            while ($i<mysqli_num_rows($result)) {
                $line[$i]=mysqli_fetch_assoc($result);
                foreach ( $line[$i] as $key => $value ) {
                    $line[$i][$key]=txt($value);
                }
                $line[$i]['nomClubComplet']="<a href=\"index.php?EX=".CLUB."&id=".$line[$i]['idClub']."\">".$line[$i]['nomClubComplet']."</a>";
                $line[$i]['nomEquipe']="<a href=\"index.php?EX=".TEAM."&id=".$line[$i]['idEquipe']."\">".$line[$i]['nomEquipe']."</a>";

                $i++;
            }
            if (!toprint() ) $printText="<a href=\"index.php?EX=".PRINTABLE."&DO=".SCORES."&ide=".$_idEquipe."&idc=".$_idCompetition."&date=".$_date."&ida=".$_idAdversaire."\">[ ".txt(txtIMPRIMER." ".txtLA_LISTE,true)." ]</a>";    
            require(HTML_DIRECTORY."mod_table_score.html.php");
        }          
    }

    function weekGame ($week=0) {
        global $dblink,$conf,$EX;

        if (date("w")==0) $w=$week-1; else $w=$week;
        $begin=  date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+($w*7-date("w")+1), date("Y")));    
        $end  =  date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+($w*7+(7-date("w"))), date("Y"))); 
        
        $class="game";

        $sql="select * 
              from ".TABLE_MATCHS." tm left join  ".TABLE_TERRAIN." tt on Terrain_idTerrain=idTerrain left join  ".TABLE_VILLE." on tt.Ville_idVille=idVille, ".TABLE_CLUB.", ".TABLE_EQUIPE.",".TABLE_TYPEDERENCONTRE."
              where tm.Club_idClub=idClub and Equipe_idEquipe=idEquipe and idTypeDeRencontre=TypeDeRencontre_idTypeDeRencontre and Date between '$begin' and '$end' order by ref ASC,Date ASC,Heure ASC ";

        $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));

        echo "<h4>".txt(sprintf(txtMATCHS." ".txtFROM_TO,datetostr($begin),datetostr($end)),true)."</h4><br>\n";
        echo "<div align=\"center\">";

        if (mysqli_num_rows($result) == 0) {
            echo "<b>".txt(txtAUCUN." ".txtMATCH,true)."</b><br><br>";
        }
        else {
            $i=0;
            $line=Array();
            while ($i<mysqli_num_rows($result)) {
                $line[$i]=mysqli_fetch_assoc($result);
                foreach ( $line[$i] as $key => $value ) {
                    $line[$i][$key]=stripslashes($value);
                }
                $line[$i]['nomClubComplet']="<a href=\"index.php?EX=".CLUB."&id=".$line[$i]['idClub']."\">".txt(stripslashes($line[$i]['nomClubComplet']))."</a>";
                $line[$i]['nomEquipe']="<a href=\"index.php?EX=".TEAM."&id=".$line[$i]['idEquipe']."\">".txt(stripslashes($line[$i]['nomEquipe']))."</a>";
                $i++;
            }
            require(HTML_DIRECTORY."mod_table_score.html.php");
        }          
        if (!toprint()) echo "<a href=\"index.php?EX=".$EX."&w=".((int)$week-1)."\">".txt(txtSEMAINE." ".txtPRECEDENTE)."</a> - <a href=\"index.php?EX=".$EX."&w=".((int)$week+1)."\">".txt(txtSEMAINE." ".txtSUIVANTE)."</a><br>";

        echo "</div>";
    }

    function infoClub ($_id) {
        global $dblink,$conf;    
        $sql="select * from ".TABLE_CLUB.",".TABLE_VILLE." where Ville_idVille=idVille and idClub='$_id'";
        
        $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));

        $info=mysqli_fetch_assoc($result);

        $isclub=($_id==$conf['idclub']);

        $pathtopic="img";
        if ($isclub) $pathtopic.="/club";

        require(HTML_DIRECTORY."mod_view_club.html.php");
    }

    function infoContact ($_id) {
        global $dblink,$conf;    
        $sql="select * from ".TABLE_CONTACT." tc left join ".TABLE_VILLE." on tc.Ville_idVille=idVille, ".TABLE_CLUB." where Club_idClub=idClub and idContact='$_id'";
        $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $info=mysqli_fetch_assoc($result);

        $sql="select Responsabilite from ".TABLE_RESPONSABILITE." where Contact_idContact=".$_id;
        $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        while($resp[]=mysqli_fetch_assoc($result));

        require(HTML_DIRECTORY."mod_view_contact.html.php");
    }

    function teamInfos($_id=-1) {
        global $dblink;
        if ($_id==-1) return; 
        $sql="select nomDivision, nomCategorie, nomCoach, prenomCoach, nomEquipe
              from ".TABLE_EQUIPE." left join ".TABLE_COACH." on Coach_idCoach=idCoach left join ".TABLE_CATEGORIE." on Categorie_idCategorie=idCategorie left join ".TABLE_DIVISION." on Division_idDivision=idDivision where idEquipe=".$_id;
        
        $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        if (mysqli_num_rows($result)!=1) return;
        $info=mysqli_fetch_assoc($result);

        $equipe=txt(stripslashes($info['nomEquipe']));
        $coach=txt(stripslashes($info['nomCoach']." ".$info['prenomCoach']));
        if ($coach==" ") $coach="";
        $categorie=txt(stripslashes($info['nomCategorie']));
        $division=txt(stripslashes($info['nomDivision']));

        include(HTML_DIRECTORY."mod_view_team.html.php");
    }


    function view($_EX) {
        switch ($_EX) {
            case CLUB : 
                if (isset($_GET['id'])) { 
                    infoClub($_GET['id']);
                    if (logged()) listContact($_GET['id']);
                }
                break;
            case GAME :
                $ide=(isset($_GET['ide']))?(int)$_GET['ide']:-1;
                $idc=(isset($_GET['idc']))?(int)$_GET['idc']:-1;
                $date=(isset($_GET['date']))?(int)$_GET['date']:-1;
                $ida=(isset($_GET['ida']))?(int)$_GET['ida']:-1;
                echo "<h1>Liste des matchs</h1>";
                Matchs($ide,$idc,$date,$ida);
                break;
            case TEAM : 
                $teamid=(isset($_GET['id']))?(int)$_GET['id']:-1; 
                teamInfos($teamid);
                seasonStats(TEAM,$teamid,false);
                echo "<br><br>";
                Matchs($teamid,-1,-1,-1,true);
                break;
            case CONTACT :
                if (isset($_GET['id'])) { 
                    infoContact($_GET['id']);
                }
            default : break;
        }
    }
?>
