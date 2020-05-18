<?php

    function form_game ($id=-1) {
        global $dblink,$DO,$conf;    
        $act=GAME;    
        if ( $_SERVER['REQUEST_METHOD']=="POST" ) {
            $idc=(int)$_POST[getSelName(CLUB)];
            $ide=(int)$_POST[getSelName(TEAM)];
            $date=strtodate($_POST['date']);
            $heure=$_POST['heure'];
            $type=(int)$_POST[getSelName(TYPE_RENCONTRE)];
            $terrain=(int)$_POST[getSelName(COURT)];
            $sp=($_POST['pour']=='')?-1:(int)$_POST['pour'];
            $sc=($_POST['contre']=='')?-1:(int)$_POST['contre'];
            $f=($_POST['forfait']=='')?0:1;
            $note=$_POST['note'];

            if ( $DO==ADD ) {
                    $sql="insert into ".TABLE_MATCHS." (Club_idClub,Equipe_idEquipe,Date,Heure,TypeDeRencontre_idTypeDeRencontre,Terrain_idTerrain,ScorePour,ScoreContre,Forfait,Notes) values ('$idc','$ide','$date','$heure','$type','$terrain','$sp','$sc','$f','$note')";
                    mysqli_query($sql,$dblink) or die (mysqli_error($dblink));
            }
            else {                    
                if ( $DO==EDIT ) {
                    $id=(int)$_POST['id'];
                    $sql="update ".TABLE_MATCHS." set Club_idClub='$idc',Equipe_idEquipe='$ide',Date='$date',Heure='$heure',TypeDeRencontre_idTypeDeRencontre='$type',Terrain_idTerrain='$terrain',ScorePour='$sp', ScoreContre='$sc',Forfait='$f',Notes='$note' where idMatchs='$id'";
                    mysqli_query($dblink, $sql) or die (mysqli_error($dblink));
                }    
            }
        }                    
        else {
            $sql="select * from ".TABLE_MATCHS." where idMatchs=$id";
            $result=mysqli_query($dblink, $sql) or die (mysqli_error($dblink));
            $val=Array();    
            if ( mysqli_num_rows($result) == 1 ) {
                $txt_submit=txt(txtEDITION,true);
                $val=mysqli_fetch_assoc($result);
            }   
            else {
                $txt_submit=txt(txtAJOUTER,true);
            }
               
            /************ Select choix club *******************/
            $txt_field[0]=txt(txtCLUB." ".txtADVERSAIRE,true); $field[0]=getSelName(CLUB); $field_value[0]=txt($val['Club_idClub']);
            $sel[0]=selClub();
            $lnkAdd[0]="<a href=\"javascript:popup(".CLUB.",".ADD.");\">Ajouter club</a>";
            /**************************************************/
 
            /************ Select choix equipe *****************/
            $txt_field[1]=txt(txtEQUIPE,true); $field[1]=getSelName(TEAM); $field_value[1]=txt($val['Equipe_idEquipe']);
            $sel[1]=selEquipe();
            $lnkAdd[1]="<a href=\"javascript:popup(".TEAM.",".ADD.");\">Ajouter equipe</a>";
            /**************************************************/
        
            $txt_field[2]=txt(txtDATE,true); $field[2]="date"; $field_value[2]=(!empty($val['Date']))?datetostr(txt($val['Date'])):txt(txtDATE_FORMAT);      
            $txt_field[3]=txt(txtHEURE,true); $field[3]="heure"; $field_value[3]=((!empty($val['Heure']))?dispheure($val['Heure']):getGameTime((!empty($val['Equipe_idEquipe'])?$val['Equipe_idEquipe']:-1)));
            if ($field_value[3]=="00:00") $field_value[3]=txt(txtTIME_FORMAT);
            
            /************ Select choix comp�tition**************/
            $txt_field[4]=txt(txtTYPE_RENCONTRE,true); $field[4]=getSelName(TYPE_RENCONTRE); $field_value[4]=$val['TypeDeRencontre_idTypeDeRencontre'];
            $sel[2]=selCompetition();
            $lnkAdd[2]="<a href=\"javascript:popup(".TYPE_RENCONTRE.",".ADD.");\">Ajouter comp�tition</a>";
            /***************************************************/
 
            /************ Select choix terrain *****************/
            $txt_field[5]=txt(txtTERRAIN,true); $field[5]=getSelName(COURT); $field_value[5]=$val['Terrain_idTerrain'];
            if (!empty($val['Club_idClub'])){
                $sel[3]=array_merge(getTerrainClub($conf['idclub']),array(array(-1,"--------")),getTerrainClub($val['Club_idClub']));
                if (!empty($val['Terrain_idTerrain']) && $val['Terrain_idTerrain']!=-1) {
                    $idC=occupant($val['Terrain_idTerrain']);
                    if (($idC!=$conf['idclub']) && ($idC!=$val['Club_idClub']))
                        $sel[3]=array_merge($sel[3],array(array(-1,"--------")),selTerrain("idTerrain=".$val['Terrain_idTerrain']));
                }
            }
            else $sel[3]=selTerrain();
            $lnkAdd[3]="<a href=\"javascript:popup(".COURT.",".ADD.");\">Ajouter terrain</a>";
            /***************************************************/
 
            $txt_field[6]=txt(txtSCORE." ".txtPOUR,true); $field[6]="pour"; $field_value[6]=($val['ScorePour']==-1)?"":$val['ScorePour'];
            $txt_field[7]=txt(txtSCORE." ".txtCONTRE,true); $field[7]="contre"; $field_value[7]=($val['ScoreContre']==-1)?"":$val['ScoreContre'];
     
            $txt_field[8]=txt(txtFORFAIT,true); $field[8]="forfait"; $field_value[8]=$val['Forfait'];

            $txt_field[9]=txt(txtNOTES,true); $field[9]="note"; $field_value[9]=$val['Notes'];

            require(HTML_DIRECTORY."mod_match_form.html.php");
        }                    
    }                    
        
    function form_court ($id=-1) {
        global $dblink,$DO;    
        $act=COURT;    
        if ( $_SERVER['REQUEST_METHOD']=="POST" ) {
            $nom=addslashes($_POST['nom']);
            $rue=addslashes($_POST['rue']);
            $url=addslashes($_POST['url']);
            $idv=(int)$_POST[getSelName(VILLE)];
            $idc=(int)$_POST[getSelName(CLUB)];

            if ( $DO==ADD ) {
                $sql="insert into ".TABLE_TERRAIN." (nomTerrain,rueTerrain,Ville_idVille,urlLocalisationTerrain,Club_idClub) values ('$nom','$rue','$idv','$url','$idc')";
                mysqli_query($dblink, $sql) or die (mysqli_error($dblink));
            }
            else {                    
                if ( $DO==EDIT ) {
                    $id=(int)$_POST['id'];
                    $sql="update ".TABLE_TERRAIN." set nomTerrain='$nom',rueTerrain='$rue',Ville_idVille='$idv',urlLocalisationTerrain='$url',Club_idClub='$idc' where idTerrain='$id'";
                    mysqli_query($dblink, $sql) or die (mysqli_error($dblink));
                }    
            }
        }                    
        else {
            $sql="select * from ".TABLE_TERRAIN." where idTerrain=$id";
            $result=mysqli_query($dblink, $sql) or die (mysqli_error($dblink));
            $val=Array();    
            if ( mysqli_num_rows($result) == 1 ) {
                $txt_submit=txt(txtEDITION,true);
                $val=mysqli_fetch_assoc($result);
            }   
            else {
                $txt_submit=txt(txtAJOUTER,true);
            }
            $txt_field[0]=txt(txtNOM,true); $field[0]="nom"; $field_value[0]=txt($val['nomTerrain']);
            $txt_field[1]=txt(txtRUE,true); $field[1]="rue"; $field_value[1]=txt($val['rueTerrain']);
                     
            /************ Select choix ville ******************/
            $txt_field[2]=txt(txtVILLE,true); $field[2]=getSelName(VILLE); $field_value[2]=$val['Ville_idVille'];
            $sel[1]=selVille();
            $lnkAdd[2]="<a href=\"javascript:popup(".VILLE.",".ADD.");\">Ajouter ville</a>";
            /**************************************************/
                
            $txt_field[3]=txt(txtURL,true); $field[3]="url"; $field_value[3]=txt($val['urlLocalisationTerrain']);
            
            /************ Select choix club ******************/
            $txt_field[4]=txt(txtCLUB,true); $field[4]=getSelName(CLUB); $field_value[4]=$val['Club_idClub'];
            $sel[2]=selClub(true);
            $lnkAdd[4]="<a href=\"javascript:popup(".CLUB.",".ADD.");\">Ajouter club</a>";
            /**************************************************/
                     
            require(HTML_DIRECTORY."mod_court_form.html.php");
        }                    
    }                    
                    
                
    function form_club ($id=-1) {
        global $dblink,$DO;    
        $act=CLUB;    
        if ( $_SERVER['REQUEST_METHOD']=="POST" ) {
            $ncc=addslashes($_POST['NCcomplet']);
            $ncs=addslashes($_POST['NCcourt']);
            $str=addslashes($_POST['rue']);
            $idV=(int)$_POST[getSelName(VILLE)];
            $tel=addslashes($_POST['tel']);
            $fax=addslashes($_POST['fax']);
            $email=addslashes($_POST['email']);
            $numinfo=addslashes($_POST['numinfo']);
            $url=addslashes($_POST['web']);
                    
            if ( $DO==ADD ) {
                $sql="insert into ".TABLE_CLUB." (nomClubComplet,nomClubCourt,rueClub,Ville_idVille ,telClub ,faxClub ,emailClub ,numInformatiqueClub,urlwebpage) values ('$ncc','$ncs','$str','$idV','$tel','$fax','$email','$numinfo','$url')";
                mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            }
            else {                    
                if ( $DO==EDIT ) {
                    $id=(int)$_POST['id'];
                    $sql="update ".TABLE_CLUB." set nomClubComplet='$ncc',nomClubCourt='$ncs',rueClub='$str',Ville_idVille='$idV',telClub='$tel',faxClub='$fax',emailClub='$email',numInformatiqueClub='$numinfo',urlwebpage='$url' where idClub=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                }    
            }
        }                    
        else {
            $sql="select * from ".TABLE_CLUB." where idClub=$id";
            $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            $val=Array();    
            if ( mysqli_num_rows($result) == 1 ) {
                $txt_submit=txt(txtEDITION,true);
                $val=mysqli_fetch_assoc($result);
            }   
            else {
                $txt_submit=txt(txtAJOUTER,true);
            }
            $txt_field[0]=txt(NOM_CLUB_COMPLET,true); $field[0]="NCcomplet"; $field_value[0]=txt($val['nomClubComplet']);
            $txt_field[1]=txt(txtNOM_CLUB_COURT,true); $field[1]="NCcourt"; $field_value[1]=txt($val['nomClubCourt']);
            $txt_field[2]=txt(txtRUE,true); $field[2]="rue"; $field_value[2]=txt($val['rueClub']);

            /************ Select choix ville ******************/
            $txt_field[3]=txt(txtVILLE,true); $field[3]=getSelName(VILLE); $field_value[3]=$val['Ville_idVille'];
            $sel=selVille();
            $lnkAdd[3]="<a href=\"javascript:popup(".VILLE.",".ADD.");\">Ajouter ville</a>";
            /**************************************************/
            $txt_field[4]=txt(txtTEL,true); $field[4]="tel"; $field_value[4]=$val['telClub'];
            $txt_field[5]=txt(txtFAX,true); $field[5]="fax"; $field_value[5]=$val['faxClub'];
            $txt_field[6]=txt(txtEMAIL,true); $field[6]="email"; $field_value[6]=txt($val['emailClub']);
            $txt_field[7]=txt(txtNUM_INFORMATIQUE,true); $field[7]="numinfo"; $field_value[7]=txt($val['numInformatiqueClub']);
            $txt_field[8]=txt(txtWEBSITE,true); $field[8]="web"; $field_value[8]=txt($val['urlwebpage']);

            require(HTML_DIRECTORY."mod_club_form.html.php");
        }                    
    }                    
    
    function form_ville ($id=-1) {
        global $dblink,$DO;    
        $act=VILLE;    
        if ( $_SERVER['REQUEST_METHOD']=="POST" ) {
            $ville=addslashes($_POST['ville']);
            $cp=(int)$_POST['cp'];
                    
            if ( $DO==ADD ) {
                $sql="insert into ".TABLE_VILLE." (cpVille, nomVille) values ($cp,'$ville')";
                mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            }
            else { 
                if ( $DO==EDIT ) {
                    $id=(int)$_POST['id'];
                    $sql="update ".TABLE_VILLE." set cpVille=$cp, nomVille='$ville' where idVille=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                }    
            }
        }                    
        else {
            $sql="select * from ".TABLE_VILLE." where idVille=$id";
            $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            $val=Array();    
            if ( mysqli_num_rows($result) == 1 ) {
                $txt_submit=txt(txtEDITION,true);
                $val=mysqli_fetch_assoc($result);
            }   
            else {
                $txt_submit=txt(txtAJOUTER,true);
            }
            $txt_field[0]=txt(txtVILLE,true); $field[0]="ville"; $field_value[0]=txt($val['nomVille']);
            $txt_field[1]=txt(txtCODE_POSTAL,true); $field[1]="cp"; $field_value[1]=cp($val['cpVille']);
               
            require(HTML_DIRECTORY."mod_2text_form.html.php");         
        }                    
    }                    
    
    function form_team ($id=-1) {
        global $dblink,$DO;    
        $act=TEAM;    
        if ( $_SERVER['REQUEST_METHOD']=="POST" ) {
            $ncc=addslashes($_POST['NCcomplet']);
            $ncs=addslashes($_POST['NCcourt']);
            $idc=(int)$_POST[getSelName(CATEGORIE)];    
            $iddiv=(int)$_POST[getSelName(DIVISION)];    
            $idcoach=(int)$_POST[getSelName(COACH)];
            $ref=addslashes($_POST['ref']);
            $hm=$_POST['hm'];
            $dur=$_POST['dur'];
                    
            if ( $DO==ADD ) {
                $sql="insert into ".TABLE_EQUIPE." (nomEquipe,nomEquipeCourt,Categorie_idCategorie,Division_idDivision,Coach_idCoach,HoraireHabituel,DureeTheoriqueMatch,ref) values ('$ncc','$ncs','$idc','$iddiv','$idcoach','$hm','$dur','$ref')";
                mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            }
            else {        
                if ( $DO==EDIT ) {
                    $id=(int)$_POST['id'];
                    $sql="update ".TABLE_EQUIPE." set nomEquipe='$ncc',nomEquipeCourt='$ncs',Categorie_idCategorie='$idc',Division_idDivision='$iddiv',Coach_idCoach='$idcoach',HoraireHabituel='$hm',DureeTheoriqueMatch='$dur', ref='$ref' where idEquipe=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                }    
            }
        }                    
        else {                    
            $sql="select * from ".TABLE_EQUIPE." where idEquipe=$id";
            $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            $val=Array();    
            if ( mysqli_num_rows($result) == 1 ) {
                $txt_submit=txt(txtEDITION,true);
                $val=mysqli_fetch_assoc($result);
            }   
            else {
                $txt_submit=txt(txtAJOUTER,true);
            }
            $txt_field[0]="Nom �quipe complet"; $field[0]="NCcomplet"; $field_value[0]=txt($val['nomEquipe']);
            $txt_field[1]="Nom �quipe court"; $field[1]="NCcourt"; $field_value[1]=txt($val['nomEquipeCourt']);
                  
            /************ Select choix categorie *************/
            $txt_field[2]=txt(txtCATEGORIE,true); $field[2]=getSelName(CATEGORIE); $field_value[2]=$val['Categorie_idCategorie'];
            $sel[1]=selCategorie();
            $lnkAdd[2]="<a href=\"javascript:popup(".CATEGORIE.",".ADD.");\">Ajouter cat�gorie</a>";
            /**************************************************/
               
            /************ Select choix division ***************/
            $txt_field[3]=txt(txtDIVISION,true); $field[3]=getSelName(DIVISION); $field_value[3]=$val['Division_idDivision'];
            $sel[2]=selDivision();
            $lnkAdd[3]="<a href=\"javascript:popup(".DIVISION.",".ADD.");\">Ajouter division</a>";
            /**************************************************/

            /************ Select choix coach ******************/
            $txt_field[4]=txt(txtCOACH,true); $field[4]=getSelName(COACH); $field_value[4]=$val['Coach_idCoach'];
            $sel[3]=selCoach();
            $lnkAdd[4]="<a href=\"javascript:popup(".COACH.",".ADD.");\">Ajouter coach</a>";
            /**************************************************/

            $txt_field[5]=txt(txtHEURE_MATCH_THEORIQUE,true); $field[5]="hm"; $field_value[5]=(!empty($val['HoraireHabituel']))?dispheure($val['HoraireHabituel']):txt(txtTIME_FORMAT);
            $txt_field[6]=txt(txtDUREE_MATCH,true); $field[6]="dur"; $field_value[6]=(!empty($val['DureeTheoriqueMatch']))?dispheure($val['DureeTheoriqueMatch']):txt(txtTIME_FORMAT);
            $txt_field[7]=txt(txtREFERENCE,true); $field[7]="ref"; $field_value[7]=txt($val['ref']);
            
            require(HTML_DIRECTORY."mod_team_form.html.php");         
        }
    }                    
    
    function form_contact ($id=-1) {
        global $dblink,$DO;    
        $act=CONTACT;    
        if ( $_SERVER['REQUEST_METHOD']=="POST" ) {
            $idc=(int)$_POST['idc'];
            $nom=addslashes($_POST['nom']);
            $pnom=addslashes($_POST['prenom']);
            $str=addslashes($_POST['rue']);
            $city=(int)$_POST[getSelName(VILLE)];
            $tel=addslashes($_POST['tel']);
            $fax=addslashes($_POST['fax']);
            $email=addslashes($_POST['email']);
                   
            $sql="select max(idContact) as nb from ".TABLE_CONTACT."";
            $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            $res=mysqli_fetch_assoc($res);
            $id=$res['nb']+1;
            
            if ( $DO==ADD ) {
                $sql="insert into ".TABLE_CONTACT." (idContact,Club_idClub,nomContact,prenomContact,adresseContact,Ville_idVille,telContact,faxContact,emailContact) values('$id','$idc','$nom','$pnom','$str','$city','$tel','$fax','$email')";
                mysqli_query($dblink,$sql) or die (mysqli_error($dblink));

                $resp=explode("\n",$_POST['resp']);
                foreach ( $resp as $r ) {
                    $sql="insert into ".TABLE_RESPONSABILITE." values ('$id','".addslashes($r)."')";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                }
            }
            else {
                if ( $DO==EDIT ) {
                    $id=(int)$_POST['id'];
                    $sql="update ".TABLE_CONTACT." set Club_idClub='$idc',nomContact='$nom',prenomContact='$pnom,adresseContact='$str',Ville_idVille='$city',telContact='$tel', faxContact='$fax', emailContact='$email' where idContact='$id'";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
               
                    $resp=explode("\n",$_POST['resp']);
                    $sql="delete from ".TABLE_RESPONSABILITE." where Contact_idContact='$id'";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    foreach ( $resp as $r ) {
                        $sql="insert into ".TABLE_RESPONSABILITE." values ('$id','".addslashes($r)."')";
                        mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                    }   
                }    
            }
        }                    
        else {
            $sql="select * from ".TABLE_CONTACT." where idContact=$id";
            $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            $val=Array();    
            if ( mysqli_num_rows($result) == 1 ) {
                $txt_submit=txt(txtEDITION,true);
                $val=mysqli_fetch_assoc($result);
            }   
            else {
                $txt_submit=txt(txtAJOUTER,true);
            }
            /************ Select choix club ******************/
            $txt_field[0]=txt(txtCLUB,true); $field[0]=getSelName(CLUB); $field_value[0]=$val['Club_idClub'];
            $sel[1]=selClub(true);
            $lnkAdd[0]="<a href=\"javascript:popup(".CLUB.",".ADD.");\">Ajouter club</a>";
            /**************************************************/

            $txt_field[1]=txt(txtNOM,true); $field[1]="nom"; $field_value[1]=txt($val['nomContact']);
            $txt_field[2]=txt(txtPRENOM,true); $field[2]="prenom"; $field_value[2]=txt($val['prenomContact']);
            $txt_field[3]=txt(txtRUE,true); $field[3]="rue"; $field_value[3]=txt($val['adresseContact']);

            /************ Select choix ville ******************/
            $txt_field[4]=txt(txtVILLE,true); $field[4]=getSelName(VILLE); $field_value[4]=$val['Ville_idVille'];
            $sel[2]=selVille();
            $lnkAdd[4]="<a href=\"javascript:popup(".VILLE.",".ADD.");\">Ajouter ville</a>";
            /**************************************************/

            $txt_field[5]=txt(txtTEL,true); $field[5]="tel"; $field_value[5]=$val['telContact'];
            $txt_field[6]=txt(txtFAX,true); $field[6]="fax"; $field_value[6]=$val['faxContact'];
            $txt_field[7]=txt(txtEMAIL,true); $field[7]="email"; $field_value[7]=txt($val['emailContact']);

            /**************** textarea responsabilit�s ********/
            $txt_field[8]=txt(txtRESPONSABILITE,true); $field[8]="resp"; $field_value[8]="";
            $sql="select * from ".TABLE_RESPONSABILITE." where Contact_idContact='$id'";
            $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            while ( $vals=mysqli_fetch_assoc($res) ) {
                $list[8].="".$vals['Responsabilite']."\n";
            }
            /**************************************************/ 

            require(HTML_DIRECTORY."mod_contact_form.html.php");
        }
    }
                       
            
    function form_coach ($id=-1) {
        global $dblink,$DO;    
        $act=COACH;    
        if ( $_SERVER['REQUEST_METHOD']=="POST" ) {
            $nom=addslashes($_POST['nom']);
            $prenom=addslashes($_POST['prenom']);
            $tel=addslashes($_POST['tel']);
            $mail=addslashes($_POST['mail']);
            $lic=(int)$_POST['lic'];
                    
            if ( $DO==ADD ) {
                $sql="insert into ".TABLE_COACH." (nomCoach,prenomCoach,telCoach,emailCoach,licCoach) values ('$nom','$prenom','$tel','$mail','$lic')";                    
                mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            }
            else {                    
                if ( $DO==EDIT ) {
                    $id=(int)$_POST['id'];
                    $sql="update ".TABLE_COACH." set nomCoach='$nom',prenomCoach='$prenom',telCoach='$tel',emailCoach='$mail',licCoach='$lic' where idCoach=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                }    
            }
        }                    
        else {
            $sql="select * from ".TABLE_EQUIPE." where idEquipe=$id";
            $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            $val=Array();    
            if ( mysqli_num_rows($result) == 1 ) {
                $txt_submit=txt(txtEDITION,true);
                $val=mysqli_fetch_assoc($result);
            }   
            else {
                $txt_submit=txt(txtAJOUTER,true);
            }
            $txt_field[0]=txt(txtNOM,true); $field[0]="nom"; $field_value[0]=txt($val['nomCoach']);
            $txt_field[1]=txt(txtPRENOM,true); $field[1]="prenom"; $field_value[1]=txt($val['prenomCoach']);
            $txt_field[2]=txt(txtTEL,true); $field[2]="tel"; $field_value[2]=$val['telCoach'];
            $txt_field[3]=txt(txtEMAIL,true); $field[3]="mail"; $field_value[3]=txt($val['emailCoach']);
            $txt_field[4]=txt(txtNUM_LICENCE,true); $field[4]="lic"; $field_value[4]=$val['licCoach'];
                      
            require(HTML_DIRECTORY."mod_2text_form.html.php");
        }                    
    }                    
    
    function form_typerencontre ($id=-1) {
        global $dblink,$DO;    
        $act=TYPE_RENCONTRE;    
        if ( $_SERVER['REQUEST_METHOD']=="POST" ) {
            $typ=addslashes($_POST['type']);
                    
            if ( $DO==ADD ) {
                $sql="insert into ".TABLE_TYPEDERENCONTRE." (nomType) values ('$typ')";
                mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            }
            else {                    
                if ( $DO==EDIT ) {
                    $id=(int)$_POST['id'];
                    $sql="update ".TABLE_TYPEDERENCONTRE." set nomType='$typ' where idTypeDeRencontre=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                }    
            }
        }                    
        else {
            $sql="select * from ".TABLE_TYPEDERENCONTRE." where idTypeDeRencontre=$id";
            $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            $val=Array();    
            if ( mysqli_num_rows($result) == 1 ) {
                $txt_submit=txt(txtEDITION,true);
                $val=mysqli_fetch_assoc($result);
            }   
            else {
                $txt_submit=txt(txtAJOUTER,true);
            }
            $val=mysqli_fetch_assoc($result);
            $txt_field[0]=txt(txtTYPE_RENCONTRE,true); $field[0]="type"; $field_value[0]=txt($val['nomType']); 
               
            require(HTML_DIRECTORY."mod_2text_form.html.php");
        }                    
    }                    
 
    function form_categorie ($id=-1) {
        global $dblink,$DO;    
        $act=CATEGORIE;    
        if ( $_SERVER['REQUEST_METHOD']=="POST" ) {
            $cat=addslashes($_POST['categorie']);
                    
            if ( $DO==ADD ) {
                $sql="insert into ".TABLE_CATEGORIE." (nomCategorie) values ('$cat')";
                mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            }
            else {                    
                if ( $DO==EDIT ) {
                    $id=(int)$_POST['id'];
                    $sql="update ".TABLE_CATEGORIE." set nomCategorie='$cat' where idCategorie=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                }    
            }
        }                    
        else {
            $sql="select * from ".TABLE_CATEGORIE." where idCategorie=$id";
            $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            $val=Array();    
            if ( mysqli_num_rows($result) == 1 ) {
                $txt_submit=txt(txtEDITION,true);
                $val=mysqli_fetch_assoc($result);
            }   
            else {
                $txt_submit=txt(txtAJOUTER,true);
            }
            $txt_field[0]=txt(txtCATEGORIE,true);
            $field[0]="categorie";
            $field_value[0]=txt($val['nomCategorie']); 
               
            require(HTML_DIRECTORY."mod_2text_form.html.php");
        }                    
    }                    
                
    function form_division ($id=-1) {
        global $dblink,$DO;    
        $act=DIVISION;    
        if ( $_SERVER['REQUEST_METHOD']=="POST" ) {
            $div=addslashes($_POST['division']);
                    
            if ( $DO==ADD ) {
                $sql="insert into ".TABLE_DIVISION." (nomDivision) values ('$div')";
                mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            }
            else {                    
                if ( $DO==EDIT ) {
                    $id=(int)$_POST['id'];
                    $sql="update ".TABLE_DIVISION." set nomDivision='$div' where idDivision=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                }    
            }
        }                    
        else {
            $sql="select * from ".TABLE_DIVISION." where idDivision=$id";
            $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            $val=Array();    
            if ( mysqli_num_rows($result) == 1 ) {
                $txt_submit=txt(txtEDITION,true);
                $val=mysqli_fetch_assoc($result);
            }   
            else {
                $txt_submit=txt(txtAJOUTER,true);
            }
            $txt_field[0]=txt(txtDIVISION,true); $field[0]="division"; $field_value[0]=txt($val['nomDivision']); 
                
            require(HTML_DIRECTORY."mod_2text_form.html.php");
        }                    
    }                    

    function form_score ($id=-1) {
        global $dblink,$DO;    
        $act=SCORE;
        if ( $_SERVER['REQUEST_METHOD']=="POST" ) {
            $sp=($_POST['sp']=='')?-1:(int)$_POST['sp'];
            $sc=($_POST['sc']=='')?-1:(int)$_POST['sc'];
                    
            $id=(int)$_POST['id'];
            $sql="update ".TABLE_MATCHS." set ScorePour='$sp', ScoreContre='$sc' where idMatchs=$id";

            mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        }
        else {
            $sql="select * 
                  from ".TABLE_MATCHS.", ".TABLE_EQUIPE.", ".TABLE_CLUB." 
                  where idMatchs=$id and Club_idClub=idClub and Equipe_idEquipe=idEquipe";
            $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            $val=Array();    
            if ( mysqli_num_rows($result) == 1 ) {
                $txt_submit=txt(txtEDITION,true);
                $val=mysqli_fetch_assoc($result);
            }   
            else {
                $txt_submit="";
            }
			$titreform = txt($val['nomEquipe']);
            $txt_field[0]=(strlen(getShortName())!=0)?getShortName():txt($val['nomEquipe']); $field[0]="sp"; $field_value[0]=(($val['ScorePour']!=-1)?$val['ScorePour']:""); 
			//$txt_field[0]=txt($val['nomEquipe']); $field[0]="sp"; $field_value[0]=(($val['ScorePour']!=-1)?$val['ScorePour']:""); 
            $txt_field[1]=txt($val['nomClubComplet']); $field[1]="sc"; $field_value[1]=(($val['ScoreContre']!=-1)?$val['ScoreContre']:""); 
            
            $end="<br>";
            require(HTML_DIRECTORY."mod_2text_form.html.php");
        }                    
    }                    

    function form_user ($id=-1) {
        global $dblink,$DO;    
        $act=USERS;    
        if ( $_SERVER['REQUEST_METHOD']=="POST" ) {
            $name=addslashes($_POST['name']);
            $pwd=md5($_POST['pwd']);
            $rights=(int)$_POST['right'];
            $teams=$_POST['team'];

            if ( $DO==ADD ) {
                $sql="select * from ".TABLE_USERS." where nomUser='$name'";
                $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                if (mysqli_num_rows($res)>0) { echo "<b>".txt(sprintf(txtALREADYEXISTS,$name),true)."</b><br>"; return; }

                $sql="insert into ".TABLE_USERS." (nomUser, passwordUser,rights) values ('$name','$pwd',$rights)";
                mysqli_query($dblink,$sql) or die (mysqli_error($dblink));

                $id=mysqli_insert_id($dblink);

                if ($rights==SCORER && !empty($teams)) {
                    foreach ($teams as $key=>$value) {
                        $sql="insert into ".TABLE_CANUPDATE." values ($id,$value)";
                        mysqli_query($dblink,$sql);
                    }
                }
            }
            else { 
                if ( $DO==EDIT ) {
                    $id=(int)$_POST['id'];
                    $sql="update ".TABLE_USERS." set nomUser='$name', passwordUser='$pwd', rights='$rights' where idUser=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));

                    $sql="delete from ".TABLE_CANUPDATE." where Users_idUser=$id";
                    mysqli_query($dblink,$sql) or die (mysqli_error($dblink));

                    if ($rights==SCORER) {
                        foreach ($teams as $key=>$value) {
                            $sql="insert into ".TABLE_CANUPDATE." values ($id,$value)";
                            mysqli_query($dblink,$sql);
                        }
                    }
                }    
            }
        }                    
        else {
            $sql="select * from ".TABLE_USERS." where idUser=$id";
            $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
            $val=Array();    
            if ( mysqli_num_rows($result) == 1 ) {
                $txt_submit=txt(txtEDITION,true);
                $val=mysqli_fetch_assoc($result);
            }   
            else {
                $txt_submit=txt(txtAJOUTER,true);
            }
            $txt_field[0]=txt(txtUSERNAME,true); $field[0]="name"; $field_value[0]=txt($val['nomUser']);
            $txt_field[1]=txt(txtPASSWORD,true); $field[1]="pwd"; $field_value[1]="";
            
            /********* Select choix niveau acces **************/
            $txt_field[2]=txt(txtACCES,true); $field[2]=('right'); $field_value[2]=$val['rights'];
            $sel[1][]=Array(USER,txt(txtUSER,true));
            $sel[1][]=Array(SCORER,txt(txtSCORER,true));
            $sel[1][]=Array(UPDATER,txt(txtUPDATER,true));
            $sel[1][]=Array(ADMINISTRATOR,txt(txtADMINISTRATOR,true));
            /**************************************************/

            if ($val['rights']==SCORER) {
                $selT=getListItems(TEAM);

                $sql="select * from ".TABLE_CANUPDATE." where Users_idUser=".$id;
                $res=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
                while ($line=mysqli_fetch_assoc($res))
                    $row[]=$line['Equipe_idEquipe'];
           
                $d=txt(txtEQUIPEAGERER,true)." :"; 
                $d.="<table  cellpadding=\"5\">\n";
                for ($i=0;$i<count($selT);++$i) {
                    $checked="";    
                    for ($j=0; $j<count($row);++$j) {
                        if ($row[$j]==$selT[$i][0]) { $checked="checked"; break; }    
                    }
                    $d.=(($i%2==0)?"\t<tr>\n":"")."\t\t<td><input type=\"checkbox\" name=\"team['".$selT[$i][0]."']\" value=\"".$selT[$i][0]."\" $checked>".txt($selT[$i][1])."</input></td>".(($i%2)?"\n\t</tr>\n":"\n");
                }    
                if (!$i%2) $d.="\t</tr>\n";                    
                $d.="</table>\n";
            }        

            require(HTML_DIRECTORY."mod_user_form.html.php");         
        }                    
    }

?>
