<?php

///////////////////// Connexions //////////////////////////

    function logIn () {
        $act="index.php?EX=".JUSTLOGGED;
        $method="POST";
        $class="formcss";
        $txt_password=txt(txtPASSWORD,true)." : ";
        $txt_username=txt(txtUSERNAME,true)." : ";
        $txt_submit=txt(txtLOGIN,true);
        $end="<br>";
        require_once (HTML_DIRECTORY."mod_login_form.html.php");
    }
    
    function logOut () {
        global $logged;
        setcookie("User",$logged,time()-3600);
    }

    function doLog () {
        global $conf,$_POST,$dblink;
        if (isset($_POST)) {
            $sql="select * from ".TABLE_USERS." where nomUser='".strip_tags( $_POST['username'] )."' and passwordUser='".md5(strip_tags($_POST['pwd']))."'";    
            $res=mysqli_query($dblink,$sql);
            if (mysqli_num_rows($res)==1)  {
                $row=mysqli_fetch_assoc($res);
                setcookie("User",(int)$row['rights'],time()+3600);
                setcookie("UserId",(int)$row['idUser'],time()+3600);
                return array((int)$row['rights']);
            }
            else return VISITOR;
        }
        else {
            return VISITOR;
        }
    }

    function logged () {
        global $logged;
        return $logged>=USER;
    }

    function loggedAsScorer () {
        global $logged;
        return $logged>=SCORER;
    }

    function loggedAsUpdater () {
        global $logged;
        return $logged>=UPDATER;
    }

    function loggedAsAdministrator () {
        global $logged;
        return $logged>=ADMINISTRATOR;
    }

    function getUserId() {
        return (int)(isset($_COOKIE['UserId'])?$_COOKIE['UserId']:-1);
    }

    function openDatabase() {
        global $conf;
        $db_link = @mysqli_connect($conf['dbhostname'], $conf['dbuser'], $conf['dbpwd'])
                    or die("<B>An error occurred while trying to connect to the MySQL server.</B> MySQL returned the following error information: " .mysqli_connect_errno());

        // Retrieves the database.
        $db_get = mysqli_select_db($db_link, $conf['dbname'])
            or die("<B>Unable to locate the database.</B> Please double check <I>config.php</I> to make sure the <I>\$db_name</I> variable is set correctly.");
    
        // Return the connection
        return $db_link;
    }

///////////////////////// Combobox  ///////////////////////

    function getSelName($_EX) {
        $name="";
        switch ($_EX) {
            case GAME : $name="game"; break;
            case COURT : $name="court"; break;
            case CLUB : $name="club"; break;
            case VILLE : $name="ville"; break;
            case TEAM : $name="team"; break;
            case CONTACT : $name="contact"; break;
            case COACH : $name="coach"; break;
            case TYPE_RENCONTRE : $name="competition"; break;
            case CATEGORIE : $name="categorie"; break;
            case DIVISION : $name="division"; break;
            case DAY : $name="date"; break;
            default : $name="none"; break;    
        }
        return $name;
    }
    
    function getSelDisplay($_EX) {
        global $dblink, $conf;
        $val=array();
        $val[0]=mysqli_insert_id($dblink);
        $id=$val[0];
        switch ($_EX) {
            case GAME : break;
            case COURT :
                $sql="select * from ".TABLE_TERRAIN." where idTerrain=$id";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                $valc=mysqli_fetch_assoc($result);
                $val[1]=txt(stripslashes($valc['nomTerrain']));                
                break;
            case CLUB : 
                $sql="select * from ".TABLE_CLUB." where idClub=$id";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                $valc=mysqli_fetch_assoc($result);
                $val[1]=txt(stripslashes($valc['nomClubComplet']));                
                break;
            case VILLE :
                $sql="select * from ".TABLE_VILLE." where idVille=$id";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                $valc=mysqli_fetch_assoc($result);
                $val[1]=txt(cp($valc['cpVille'])." ".stripslashes($valc['nomVille']));
                break;
            case TEAM : 
                $sql="select * from ".TABLE_EQUIPE." where idEquipe=$id";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                $valc=mysqli_fetch_assoc($result);
                $val[1]=txt(stripslashes($valc['nomEquipe']));
                break; 
            case CONTACT :
                $sql="select * from ".TABLE_CONTACT." where idContact=$id";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                $valc=mysqli_fetch_assoc($result);
                $val[1]=txt(stripslashes($valc['nomContact']." ".$valc['prenomContact']));                
                break;
            case COACH :
                $sql="select * from ".TABLE_EQUIPE." where idEquipe=$id";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                $valc=mysqli_fetch_assoc($result);
                $val[1]=txt(stripslashes($valc['nomCoach']." ".$valc['prenomCoach']));                
                break;
            case TYPE_RENCONTRE : 
                $sql="select * from ".TABLE_TYPEDERENCONTRE." where idTypeDeRencontre=$id";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                $valc=mysqli_fetch_assoc($result);
                $val[1]=txt(stripslashes($valc['nomType']));                
                break;
            case CATEGORIE :
                $sql="select * from ".TABLE_CATEGORIE." where idCategorie=$id";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                $valc=mysqli_fetch_assoc($result);
                $val[1]=txt(stripslashes($valc['nomCategorie']));                
                break;
            case DIVISION : 
                $sql="select * from ".TABLE_DIVISION." where idDivision=$id";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                $valc=mysqli_fetch_assoc($result);
                $val[1]=txt(stripslashes($valc['nomDivision']));                
                break;
            default: break;                
        }
        return $val;
    }

    function getListItems($_EX) {
        global $dblink, $conf;
        $val=array();
        $i=0;
        switch ($_EX) {
            case GAME :
                $sql="select * from ".TABLE_MATCHS.", ".TABLE_EQUIPE.", ".TABLE_CLUB." where Club_idClub=idClub and Equipe_idEquipe=idEquipe order by Date ASC, Heure ASC, nomEquipe ASC";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                while ($valc=mysqli_fetch_assoc($result)) {
                    $sp=($valc['ScorePour']==-1)?"":(int)$valc['ScorePour'];    
                    $sc=($valc['ScoreContre']==-1)?"":(int)$valc['ScoreContre'];
                    if ($valc['Forfait']==1) {
                        $f=($sp>$sc)?txt(txtVICTOIRE,true):(($sc>$sp)?txt(txtDEFAITE,true):"");
                        $f.=(strlen($f)>0)?" ".txt(txtPAR)." ":"";
                        $f.=txt(txtFORFAIT);
                        $f=" ( ".$f." ) ";
                    }
                    else {
                        if (strlen($sc)>0 && strlen($sp)>0 )
                            $f=" ( ".$sp." - ".$sc." ) ";
                        else
                            $f="";
                    }    
                    $val[$i][1]=datetostr($valc['Date']).' : <b>'.txt(stripslashes($valc['nomEquipe']))."</b> - <b>".txt(stripslashes($valc['nomClubComplet']))."</b> $f";                
                    $val[$i][0]=(int)$valc['idMatchs'];
                    $i++;
                }
                break;
            case COURT :
                $sql="select * from ".TABLE_TERRAIN.", ".TABLE_VILLE." where Ville_idVille=idVille order by nomTerrain ASC";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                while ($valc=mysqli_fetch_assoc($result)) {
                    $val[$i][1]=txt(stripslashes($valc['nomTerrain'].((!empty($valc['nomVille']))?" ( ".$valc['nomVille']." )":""))); 
                    $val[$i][0]=(int)$valc['idTerrain'];
                    $i++;
                }
                break;
            case CLUB : 
                $sql="select * from ".TABLE_CLUB." order by nomClubComplet ASC";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                while ($valc=mysqli_fetch_assoc($result)) {
                    $val[$i][1]="<a href=\"index.php?EX=".CLUB."&id=".(int)$valc['idClub']."\">".txt(stripslashes($valc['nomClubComplet']))."</a>";
                    $val[$i][0]=(int)$valc['idClub'];
                    $i++;
                }
                break;
            case VILLE :
                $sql="select * from ".TABLE_VILLE." order by nomVille ASC";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                while ($valc=mysqli_fetch_assoc($result)) {
                    $val[$i][1]=txt(cp($valc['cpVille'])." ".stripslashes($valc['nomVille']));
                    $val[$i][0]=(int)$valc['idVille'];
                    $i++;
                }
                break;
            case TEAM : 
                $sql="select * from ".TABLE_EQUIPE." order by nomEquipe ASC";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                while ($valc=mysqli_fetch_assoc($result)) {
                    $val[$i][1]=txt(stripslashes($valc['nomEquipe']));
                    $val[$i][0]=(int)$valc['idEquipe'];
                    $i++;
                }
                break; 
            case CONTACT :
                $sql="select * from ".TABLE_CONTACT." order by nomContact ASC, prenomContact ASC";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                while ($valc=mysqli_fetch_assoc($result)) {
                    $val[$i][1]=txt(stripslashes($valc['nomContact']." ".$valc['prenomContact']));                
                    $val[$i][0]=(int)$valc['idContact'];
                    $i++;
                }
                break;
            case COACH :
                $sql="select * from ".TABLE_COACH." order by nomCoach ASC, prenomCoach ASC";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                while ($valc=mysqli_fetch_assoc($result)) {
                    $val[$i][1]=txt(stripslashes($valc['nomCoach']." ".$valc['prenomCoach']));                
                    $val[$i][0]=(int)$valc['idCoach'];
                    $i++;
                }
                break;
            case TYPE_RENCONTRE : 
                $sql="select * from ".TABLE_TYPEDERENCONTRE." order by nomType ASC";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                while ($valc=mysqli_fetch_assoc($result)) {
                    $val[$i][1]=txt(stripslashes($valc['nomType']));                
                    $val[$i][0]=(int)$valc['idTypeDeRencontre'];
                    $i++;
                }
                break;
            case CATEGORIE :
                $sql="select * from ".TABLE_CATEGORIE." order by nomCategorie ASC";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                while ($valc=mysqli_fetch_assoc($result)) {
                    $val[$i][1]=txt(stripslashes($valc['nomCategorie']));                
                    $val[$i][0]=(int)$valc['idCategorie'];
                    $i++;
                }
                break;
            case DIVISION : 
                $sql="select * from ".TABLE_DIVISION." order by nomDivision ASC";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                while ($valc=mysqli_fetch_assoc($result)) {
                    $val[$i][1]=txt(stripslashes($valc['nomDivision']));                
                    $val[$i][0]=(int)$valc['idDivision'];
                    $i++;
                }
                break;
             case DAY :
                $sql="select distinct(Date) from ".TABLE_MATCHS." order by Date ASC";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                while ($valc=mysqli_fetch_assoc($result)) {
                    $val[$i][1]=txt(datetostr($valc['Date']));                
                    $val[$i][0]=$valc['Date'];
                    $i++;
                }
                break;
             case USERS :
                $sql="select * from ".TABLE_USERS." order by nomUser ASC";
                $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                while ($valc=mysqli_fetch_assoc($result)) {
                    $val[$i][1]=$valc['nomUser'];                
                    $val[$i][0]=$valc['idUser'];
                    $i++;
                }
                break;
            default: break;                
        }
        return $val;
    }

    function selVille () {
        global $dblink, $conf;
        $sql="select * from ".TABLE_VILLE." order by nomVille ASC";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $i=0;
        $sel=array();
        while ( $vals=mysqli_fetch_assoc($res) ) {
            $sel[$i][0]=(int)$vals['idVille'];
            $sel[$i][1]=txt(cp($vals['cpVille'])." ".stripslashes($vals['nomVille']));
            $i++;
        }    
        return $sel;    
    }

    function selCompetition () {
        global $dblink, $conf;
        $sql="select * from ".TABLE_TYPEDERENCONTRE." order by nomType ASC";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $i=0;
        $sel=array();
        while ( $vals=mysqli_fetch_assoc($res) ) {
            $sel[$i][0]=(int)$vals['idTypeDeRencontre'];
            $sel[$i][1]=txt(stripslashes($vals['nomType']));
            $i++;
        }    
        return $sel;
    }
    
    function selTerrain ($w="") {
        global $dblink, $conf;
        if (strlen($w)>0) $w=" and ".$w;
        $sql="select * from ".TABLE_TERRAIN.", ".TABLE_VILLE." where Ville_idVille=idVille $w order by nomVille ASC, nomTerrain ASC";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $i=0;
        $sel=array();
        while ( $vals=mysqli_fetch_assoc($res) ) {
            $sel[$i][0]=(int)$vals['idTerrain'];
            $sel[$i][1]=txt(stripslashes($vals['nomVille'])." ( ".cp($vals['cpVille'])." ) - ".stripslashes($vals['nomTerrain']));
            $i++;
        }    
        return $sel;
    }
        
    function selEquipe () {
        global $dblink, $conf;
        $sql="select * from ".TABLE_EQUIPE." order by nomEquipe ASC";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $i=0;
        $sel=array();
        while ( $vals=mysqli_fetch_assoc($res) ) {
            $sel[$i][0]=(int)$vals['idEquipe'];
            $sel[$i][1]=txt(stripslashes($vals['nomEquipe']));
            $i++;
        }    
        return $sel;    
    }

    function selClub ($you=false) {
        global $dblink, $conf;
        if (!$you) $where="where idClub!=".$conf['idclub'].""; 
        $sql="select * from ".TABLE_CLUB." $where order by nomClubComplet ASC";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $i=0;
        $sel=array();
        while ( $vals=mysqli_fetch_assoc($res) ) {
            $sel[$i][0]=(int)$vals['idClub'];
            $sel[$i][1]=txt(stripslashes($vals['nomClubComplet']).(strlen($vals['numInformatiqueClub']>0)?" (".stripslashes($vals['numInformatiqueClub']).")":""));
            $i++;
        }    
        return $sel; 
    }
    
    function selDivision () {
        global $dblink, $conf;
        $sql="select * from ".TABLE_DIVISION." order by nomDivision ASC";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $i=0;
        $sel=array();
        while ( $vals=mysqli_fetch_assoc($res) ) {
            $sel[$i][0]=(int)$vals['idDivision'];
            $sel[$i][1]=txt(stripslashes($vals['nomDivision']));
            $i++;
        }    
        return $sel;
    }
    
    function selCoach() {
        global $dblink, $conf;
        $sql="select * from ".TABLE_COACH." order by nomCoach ASC, prenomCoach ASC";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $sel=array();
        $i=0;
        while ( $vals=mysqli_fetch_assoc($res) ) {
            $sel[$i][0]=(int)$vals['idCoach'];
            $sel[$i][1]=txt(stripslashes($vals['nomCoach']." ".$vals['prenomCoach']));
            $i++;
        }    
        return $sel;            
    }
    
    function selCategorie () {
        global $dblink, $conf;
        $sql="select * from ".TABLE_CATEGORIE." order by nomCategorie ASC";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $sel=array();
        $i=0;
        while ( $vals=mysqli_fetch_assoc($res) ) {
            $sel[$i][0]=(int)$vals['idCategorie'];
            $sel[$i][1]=txt(stripslashes($vals['nomCategorie']));
            $i++;
        }            
        return $sel;                
    }

    function getTeam ($id=-1) {
        global $dblink, $conf;
        $sql="select * from ".TABLE_EQUIPE." where idEquipe='".$id."'";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        if (mysqli_num_rows($res)!=1) return "";
        $vals=mysqli_fetch_assoc($res);
        return txt(stripslashes($vals['nomEquipe']));
    }        

    function getCompetition ($id=-1) {
        global $dblink, $conf;
        $sql="select * from ".TABLE_TYPEDERENCONTRE." where idTypeDeRencontre='".$id."'";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        if (mysqli_num_rows($res)!=1) return "";
        $vals=mysqli_fetch_assoc($res);
        return txt(stripslashes($vals['nomType']));
    }
    
    function getTerrainClub($_idc=-1) {
        if ($_idc!=-1) return selTerrain("Club_idClub=".$_idc);
        else return selTerrain();
    } 

    function getCoach ($id=-1,$where=COACH) {
        global $dblink, $conf;
        if ($where==TEAM) { 
            $sql="select * from ".TABLE_EQUIPE." where idEquipe='".$id."'";
            $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            if (mysqli_num_rows($res)!=1) return;
            $vals=mysqli_fetch_assoc($res);
            $id=$vals['Coach_idCoach'];                
        }
        $sql="select * from ".TABLE_COACH." where idCoach='".$id."'";
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        if (mysqli_num_rows($res)!=1) return "";
        $vals=mysqli_fetch_assoc($res);
        return txt(stripslashes($vals['nomCoach']." ".$vals['prenomCoach']));                
    }

    function occupant ($_id=-1) {
        if($_id==-1) return -1;
        global $dblink;
        if (strlen($w)>0) $w=" and ".$w;
        $sql="select Club_idClub from ".TABLE_TERRAIN." where idTerrain=".$_id;
        $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $vals=mysqli_fetch_row($res);
        if (empty($vals[0])) return -1;
        return $vals[0];
    }

    function getGameTime($_ide=-1) {
        global $dblink;
        if ($_ide==-1) return "00:00";
        else {
            $sql="select HoraireHabituel from ".TABLE_EQUIPE." where idEquipe=".$_ide;
            $res=mysqli_query($dblink,$sql);
            if (mysqli_num_rows($res)!=1) return "00:00";
            $row=mysqli_fetch_assoc($res);
            return txt(dispheure($row['HoraireHabituel']));
        }
    }
            
    function printable () {
        global $DO;
        switch ($DO) {
            case SCORES :
                echo "<h3>".txt(txtMATCHS." ".getTeam($_REQUEST['ide'])." ".((!empty($_REQUEST['date']) && $_REQUEST['date']!=-1)?datetostr($_REQUEST['date']):"")." ".getCompetition($_REQUEST['idc']),true)."</h3>";
                viewScores();
                break;    
            default :
                content($DO);
                break;
        }
        echo "<div align=\"center\"><img src=\"img/design/logobw.gif\"></div>";
    }    

    function strtodate ($_str) {
        $str=explode("/",$_str);
        return $str[2]."-".$str[1]."-".$str[0];
    }

    function datetostr ($_dat) {
        $dat=explode("-",$_dat);
        return $dat[2]."/".$dat[1]."/".$dat[0];
    }

    function dispheure ($_time) {
        $h=substr($_time,0,5);
        $h=explode(":",$h);
        return $h[0].":".$h[1];
    }

    function cp ($_cp) {
        return (($_cp<10000 && $_cp!=0)?"0":"").$_cp;
    }

    function aDomicile ($_idT) {
        global $dblink,$conf;    
        static $already=false;
        static $idTerrain=array();
        if ($already) {
            for ($i=0;$i<count($idTerrain);$i++)
                if ($_idT==$idTerrain[$i]) return true;
            return false;
        }
        else {
            $already=true;
            $sql="select idTerrain from ".TABLE_TERRAIN." where Club_idClub=".$conf['idclub'];
            $result=mysqli_query($dblink,$sql);
            $dom=false;
            while ($row=mysqli_fetch_assoc($result)) {
                $idTerrain[]=$row['idTerrain'];
                if ($row['idTerrain']==$_idT) $dom=true;
            }
            return $dom;                        
        }
    }

    function txt ($str,$maj=false) {
        if ($maj) $str=ucfirst($str);
        $str=stripslashes($str);
        return htmlentities($str);
    }

?>
