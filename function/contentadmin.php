<?php
    
    function indexAdd() {
        $add=txt(txtAJOUTER,true);
        $edit=txt(txtEDITER,true);
        $class="listadd";
        
        $i=0;
        $items[$i]="<img src=\"img/design/game.png\"><br>".txt(txtMATCH,true)."<div id=\"id".$i."\"  onmouseout=\"javascript:this.innerHTML='';\"></div>";         $act[$i++]=GAME;
        $items[$i]="<img src=\"img/design/terrain.png\"><br>".txt(txtTERRAIN,true)."<div id=\"id".$i."\"  onmouseout=\"javascript:this.innerHTML='';\"></div>";       $act[$i++]=COURT;
        $items[$i]="<img src=\"img/design/club.png\"><br>".txt(txtCLUB,true)."<div id=\"id".$i."\"  onmouseout=\"javascript:this.innerHTML='';\"></div>";          $act[$i++]=CLUB;
        $items[$i]="<img src=\"img/design/equipe.png\"><br>".txt(txtEQUIPE,true)."<div id=\"id".$i."\"  onmouseout=\"javascript:this.innerHTML='';\"></div>";        $act[$i++]=TEAM;
        $items[$i]="<img src=\"img/design/coach.png\"><br>".txt(txtCOACH,true)."<div id=\"id".$i."\"  onmouseout=\"javascript:this.innerHTML='';\"></div>";         $act[$i++]=COACH;
        $items[$i]="<img src=\"img/design/categorie.png\"><br>".txt(txtCATEGORIE,true)."<div id=\"id".$i."\"  onmouseout=\"javascript:this.innerHTML='';\"></div>";     $act[$i++]=CATEGORIE;
        $items[$i]="<img src=\"img/design/division.png\"><br>".txt(txtDIVISION,true)."<div id=\"id".$i."\"  onmouseout=\"javascript:this.innerHTML='';\"></div>";      $act[$i++]=DIVISION;
        $items[$i]="<img src=\"img/design/competition.png\"><br>".txt(txtTYPE_RENCONTRE,true)."<div id=\"id".$i."\"  onmouseout=\"javascript:this.innerHTML='';\"></div>";   $act[$i++]=TYPE_RENCONTRE;
        $items[$i]="<img src=\"img/design/contact.png\"><br>".txt(txtCONTACT,true)."<div id=\"id".$i."\"  onmouseout=\"javascript:this.innerHTML='';\"></div>";       $act[$i++]=CONTACT;
        $items[$i]="<img src=\"img/design/ville.png\"><br>".txt(txtVILLE,true)."<div id=\"id".$i."\"  onmouseout=\"javascript:this.innerHTML='';\"></div>";         $act[$i++]=VILLE;

        if (loggedAsAdministrator()) {
            $items[$i]="<img src=\"img/design/users.png\"><br>".txt(txtUSER,true)."<div id=\"id".$i."\"  onmouseout=\"javascript:this.innerHTML='';\"></div>";         $act[$i++]=USERS;
        }

        $nb=count($items);
        for ($i=0;$i<$nb;$i++)
            $list[$i]=$items[$i];
            
        include(HTML_DIRECTORY."mod_table_edit.html.php");
    }
    
    function form_title () {
        global $EX,$DO;    
        require_once (FUNCTION_FORMS_FILE);
        $txt[EDIT]=($_SERVER['REQUEST_METHOD']=='POST')?"":txt(txtEDITION,true)." :";
        $txt[ADD]=($_SERVER['REQUEST_METHOD']=='POST')?"":txt(txtNOUVEAU,true)." :";
        $txt[DELETE]="";
        switch ($EX) {
            case GAME : echo "<h1>".$txt[$DO]." ".txt(txtMATCH,true)."</h1>";
                break;
            case COURT : echo "<h1>".$txt[$DO]." ".txt(txtTERRAIN,true)."</h1>";
                break;
            case CLUB : echo "<h1>".$txt[$DO]." ".txt(txtCLUB,true)."</h1>";
                break;    
            case VILLE : echo "<h1>".$txt[$DO]." ".txt(txtVILLE,true)."</h1>";
                break;
            case TEAM : echo "<h1>".$txt[$DO]." ".txt(txtEQUIPE,true)."</h1>";
                break;
            case CONTACT : echo "<h1>".$txt[$DO]." ".txt(txtCONTACT,true)."</h1>";
                break;
            case COACH : echo "<h1>".$txt[$DO]." ".txt(txtCOACH,true)."</h1>";
                break;
            case TYPE_RENCONTRE : echo "<h1>".$txt[$DO]." ".txt(txtCOMPETITION,true)."</h1>";
                break;
            case CATEGORIE : echo "<h1>".$txt[$DO]." ".txt(txtCATEGORIE,true)."</h1>";
                break;
            case DIVISION : echo "<h1>".$txt[$DO]." ".txt(txtDIVISION,true)."</h1>";
                break;
            case SCORE : echo "<h1>".$txt[$DO]." ".txt(txtSCORE,true)."</h1>";
                break;
            case USERS : echo "<h1>".$txt[$DO]." ".txt(txtUSER,true)."</h1>";
                break;
            default : 
                break;    
        }        
    }

    function forms ($id=-1) {
        global $EX,$DO;    
        require_once (FUNCTION_FORMS_FILE);
        form_title();
        switch ($EX) {
            case GAME : form_game($id);
                break;
            case COURT : form_court($id);
                break;
            case CLUB : form_club($id);
                break;    
            case VILLE : form_ville($id);
                break;
            case TEAM : form_team($id);
                break;
            case CONTACT : form_contact($id);
                break;
            case COACH : form_coach($id);         
                break;
            case TYPE_RENCONTRE : form_typerencontre($id);
                break;
            case CATEGORIE : form_categorie($id);
                break;
            case DIVISION : form_division($id);
                break;
            case SCORE : form_score($id);
                break;
            case USERS : form_user($id);
                break;
            default : 
                break;    
        }        
    }

    function delete_entry ($_EX,$_id) {
        global $conf,$dblink,$DO;    
        if ( $DO==DELETE ) {
            $id=$_id;
            switch ($_EX) {
                case GAME : 
                    $sql="delete from ".TABLE_MATCHS." where idMatchs=$id"; 
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    break;
                case COURT : 
                    $sql="update ".TABLE_MATCHS." set Terrain_idTerrain='' where Terrain_idTerrain=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    $sql="delete from ".TABLE_TERRAIN." where idClub=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    break;
                case CLUB : 
                    $sql="delete from ".TABLE_CLUB." where idClub=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    
                    $sql="delete from ".TABLE_MATCHS." where Club_idClub=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    
                    $sql="select idContact from ".TABLE_CONTACT." where Club_idClub=$id";
                    $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    while ($val=mysqli_fetch_assoc($res)) {
                        $sql="delete from ".TABLE_RESPONSABILITE." where Contact_idContact=".$val['idContact'];
                        mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    }

                    $sql="update ".TABLE_TERRAIN." set Club_idClub='' where Club_idClub=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    
                    $sql="delete from ".TABLE_CONTACT." where Club_idClub=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    break;
                case VILLE :
                    $sql="delete from ".TABLE_VILLE." where idVille=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    break;
                case TEAM : 
                    $sql="delete from ".TABLE_CANUPDATE." where Equipe_idEquipe=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    $sql="delete from ".TABLE_EQUIPE." where idEquipe=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    break;
                case CONTACT :
                    $sql="delete from ".TABLE_RESPONSABILITE." where Contact_idContact=".$id;
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    $sql="delete from ".TABLE_CONTACT." where idContact=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    break;
                case COACH :
                    $sql="update ".TABLE_EQUIPE." set Coach_idCoach='' where Coach_idCoach=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    $sql="delete from ".TABLE_COACH." where idCoach=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    break;            
                case TYPE_RENCONTRE : 
                    $sql="delete from ".TABLE_TYPEDERENCONTRE." where idTypeDeRencontre=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    break;    
                case CATEGORIE : 
                    $sql="update ".TABLE_EQUIPE." set Categorie_idCategorie='' where Categorie_idCategorie=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    $sql="delete from ".TABLE_CATEGORIE." where idCategorie=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    break;
                case DIVISION : 
                    $sql="update ".TABLE_EQUIPE." set Division_idDivision='' where Categorie_idCategorie=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    $sql="delete from ".TABLE_DIVISION." where idDivision=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    break;
                case USERS : 
                    $sql="delete from ".TABLE_CANUPDATE." where Users_idUser=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    $sql="delete from ".TABLE_USERS." where idUser=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    break;
                default : break;    
            }
            return true;
        }
        return false;
    }

    function form_delete ($_id=-1) {
        if ($_id==-1) return;
        global $EX,$DO;
        $formname="deleteform";
        $id=(int)$_id;
        $act=$EX;
        $txt_submit=txt(txtSUPPRIMER,true);
        $txt_cancel=txt(txtANNULER,true);
        $txt=txt(txtCONFIRMATION_SUPPRESSION,true)."<br><br>";
        require(HTML_DIRECTORY."mod_delete_form.html.php");
    }

    function form ($text) {
        global $EX, $DO;

        if ( loggedAsUpdater() ) {
            indexAdd();
            echo "<hr width=\"60%\">\n";
        }

        switch ($DO) {
            case NONE :
                view($EX);
                break;
            case ADD : 
            case EDIT :
                if (( !isset($_REQUEST['id']) || empty($_REQUEST['id']) ) && $DO==EDIT ) {
                    form_title();
                    indexEdit($EX);
                } 
                else {  
                    forms(empty($_REQUEST['id'])?-1:$_REQUEST['id']);    
                }    
                if ( $_SERVER['REQUEST_METHOD']=="POST" ) {
                    if ($EX==SCORE) {
                        gameScoreToEnter((loggedAsUpdater()?-1:getUserId()));
                        echo "<hr width=\"60%\" /><h1>".txt(txtSCORES,true)."</h1>\n";
                        viewScores();
                    }
                    else {
                        indexEdit($EX);
                    }
                }
                break;
            case DELETE : 
                if ( $_SERVER['REQUEST_METHOD']=="POST" ) {
                    if ( isset($_REQUEST['id']) && !empty($_REQUEST['id']) ) {
                        if (delete_entry($EX,$_REQUEST['id'])) echo "<div align=\"center\"><b>".txt(txtSUPPRESSION_EFFECTUE,true)."</b></div><hr width=\"60%\">\n";
                    }
                    form_title();
                    indexEdit($EX);
                }
                else {
                    form_title();
                    if ( isset($_REQUEST['id']) && !empty($_REQUEST['id']) ) {    
                        form_delete((int)$_REQUEST['id']);
                    }
                }    
                break; 
            default :
                break;
        }
    }
    

    function indexEdit($_EX) {
        $sel=getListItems($_EX);
        $class[0]="dispedit";
        $class[1]="dispeditfct";
        $fct[0]="<img src=\"img/design/edit.png\" alt=\"".txt(txtEDITION,true)."\">";
        $fct[1]="<img src=\"img/design/delete.png\" alt=\"".txt(txtSUPPRESSION,true)."\">";
        $none=txt(txtAUCUN." ".txtELEMENT_A_AFFICHER,true);
        $lnk[0]="index.php?EX=$_EX&DO=".EDIT."&id=";
        $lnk[1]="index.php?EX=$_EX&DO=".DELETE."&id=";

        require(HTML_DIRECTORY."mod_display_edit.html.php");
    }

    function gameScoreToEnter($_iduser=-1) {
        global $conf, $dblink;

        $date=date("Y-m-d",mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        if ($_iduser!=-1) {
                $w="and Users_idUser='".$_iduser."'";
                $sql="select * from ".TABLE_MATCHS." tm  left join ".TABLE_TERRAIN." tt on Terrain_idTerrain=idTerrain left join ".TABLE_VILLE." on tt.Ville_idVille=idVille, ".TABLE_CLUB.", ".TABLE_TYPEDERENCONTRE.", ".TABLE_CANUPDATE."  tc,".TABLE_EQUIPE." te where idEquipe=tm.Equipe_idEquipe and tc.Equipe_idEquipe=tm.Equipe_idEquipe $w and Date<='".$date."' and tm.Club_idClub=idClub and idTypeDeRencontre=TypeDeRencontre_idTypeDeRencontre and ScorePour=-1 and ScoreContre=-1 order by Date ASC,Heure ASC";
        }
        else {
            $sql="select * from ".TABLE_MATCHS." tm  left join ".TABLE_TERRAIN." tt on Terrain_idTerrain=idTerrain left join ".TABLE_VILLE." on tt.Ville_idVille=idVille, ".TABLE_CLUB.", ".TABLE_TYPEDERENCONTRE.", ".TABLE_EQUIPE." te where idEquipe=tm.Equipe_idEquipe  and Date<='".$date."' and tm.Club_idClub=idClub and idTypeDeRencontre=TypeDeRencontre_idTypeDeRencontre and ScorePour=-1 and ScoreContre=-1 order by Date ASC,Heure ASC";
        } 
     
        $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));

        echo "<h2>".((mysqli_num_rows($result)>1)?txt(txtSCORES_A_SAISIR,true):txt(txtSCORE_A_SAISIR,true))."</h2>";
        if (mysqli_num_rows($result) == 0) {
            echo "<b>".txt(txtAUCUN." ".txtMATCH." ".txtTO_UPDATE,true)."</b><br><br>";
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
            $vd=true;
            require(HTML_DIRECTORY."mod_table_score.html.php");
        }          
    }

?>
