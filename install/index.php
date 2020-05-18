<?php

    session_start();

    define ("ADMINISTRATOR",3);

    function start() {
        session_register("dbprefix");
        session_register("dbname");
        session_register("dbuser");
        session_register("dbpwd");
        session_register("dbhostname");
        session_register("idclub");
        session_register("lang");
    }

    function form_db() {
        echo "<form name=\"db\" action=\"index.php?i=1\" method=\"POST\"><br>\n";
        echo "\t<table>\n";
        echo "\t<tr><td>Nom de la base de données </td><td> <input type=\"text\" name=\"dbname\"></input></td></tr>\n";
        echo "\t<tr><td>Serveur de base de données </td><td> <input type=\"text\" name=\"dbhost\"></input></td></tr>\n";
        echo "\t<tr><td>Utilisateur base de données </td><td> <input type=\"text\" name=\"dbusername\"></input></td></tr>\n";
        echo "\t<tr><td>Mot de passe base de données </td><td> <input type=\"password\" name=\"dbpwd\"></input></td></tr>\n";
        echo "\t<tr><td>Préfixe des tables </td><td> <input type=\"text\" name=\"dbprefix\" value=\"tm_\"></input><br>\n";
        echo "\t<tr><td>Suivant les tables</td><td> <input type=\"checkbox\" name=\"dbcreate\" checked></input><br>\n";
        echo "\t</table>\n";
        echo "\t<br>\n";
        echo "\t<input type=\"submit\" name=\"ok\" class=\"formcss\"value=\"Suivant\"><br>\n";
        echo "</form>\n";
    }

    function trait_form_db() {
        $_SESSION['dbprefix']=$_POST['dbprefix'];
        $_SESSION['dbname']=$_POST['dbname'];
        $_SESSION['dbuser']=$_POST['dbusername'];
        $_SESSION['dbpwd']=$_POST['pwd'];
        $_SESSION['dbhostname']=$_POST['host'];

        if ( !empty($_POST['dbcreate']) ) {
            $req[]="DROP TABLE IF EXISTS `".$_SESSION['dbprefix']."categorie`";
            $req[]="CREATE TABLE `".$_SESSION['dbprefix']."categorie` (`idCategorie` int(10) unsigned NOT NULL auto_increment, `nomCategorie` varchar(50) NOT NULL, PRIMARY KEY (`idCategorie`))";
            $req[]="DROP TABLE IF EXISTS `".$_SESSION['dbprefix']."club`";
            $req[]="CREATE TABLE `".$_SESSION['dbprefix']."club` ( `idClub` int(10) unsigned NOT NULL auto_increment, `nomClubComplet` varchar(80) NOT NULL, `nomClubCourt` varchar(20) default NULL, `rueClub` varchar(130) default NULL, `Ville_idVille` int(10) unsigned NOT NULL, `telClub` varchar(14) default NULL, `faxClub` varchar(14) default NULL, `emailClub` varchar(80) default NULL, `numInformatiqueClub` varchar(15) default NULL, `urlwebpage` varchar(120) default NULL, PRIMARY KEY (`idClub`))";
            $req[]="DROP TABLE IF EXISTS `".$_SESSION['dbprefix']."coach`";
            $req[]="CREATE TABLE `".$_SESSION['dbprefix']."coach` ( `idCoach` int(10) unsigned NOT NULL auto_increment, `nomCoach` varchar(40) NOT NULL, `prenomCoach` varchar(40) NOT NULL, `telCoach` varchar(14) default NULL, `emailCoach` varchar(50) default NULL, `licCoach` int(10) unsigned default NULL, PRIMARY KEY (`idCoach`)) ";
            $req[]="DROP TABLE IF EXISTS `".$_SESSION['dbprefix']."contact`";
            $req[]="CREATE TABLE `".$_SESSION['dbprefix']."contact` ( `idContact` int(10) unsigned NOT NULL auto_increment, `Club_idClub` int(10) unsigned NOT NULL, `nomContact` varchar(40) default NULL, `prenomContact` varchar(40) default NULL, `adresseContact` varchar(80) default NULL, `Ville_idVille` int(10) unsigned NOT NULL, `telContact` varchar(14) default NULL, `faxContact` varchar(14) default NULL, `emailContact` varchar(80) default NULL, PRIMARY KEY (`idContact`)) ";
            $req[]="DROP TABLE IF EXISTS `".$_SESSION['dbprefix']."division`";
            $req[]="CREATE TABLE `".$_SESSION['dbprefix']."division` ( `idDivision` int(10) unsigned NOT NULL auto_increment, `nomDivision` varchar(50) NOT NULL, PRIMARY KEY (`idDivision`)) ";
            $req[]="DROP TABLE IF EXISTS `".$_SESSION['dbprefix']."equipe`";
            $req[]="CREATE TABLE `".$_SESSION['dbprefix']."equipe` ( `idEquipe` int(10) unsigned NOT NULL auto_increment, `nomEquipe` varchar(50) NOT NULL, `nomEquipeCourt` varchar(10) default NULL, `Categorie_idCategorie` int(10) unsigned NOT NULL, `Division_idDivision` int(10) unsigned NOT NULL, `Coach_idCoach` int(10) unsigned NOT NULL, `HoraireHabituel` time NOT NULL, `DureeTheoriqueMatch` time NOT NULL, `order` varchar(10) NOT NULL, PRIMARY KEY (`idEquipe`)) ";
            $req[]="DROP TABLE IF EXISTS `".$_SESSION['dbprefix']."responsabilite`";
            $req[]="CREATE TABLE `".$_SESSION['dbprefix']."responsabilite` ( `Contact_idContact` int(10) unsigned NOT NULL, `Responsabilite` varchar(30) NOT NULL, PRIMARY KEY (`Contact_idContact`,`Responsabilite`)) ";
            $req[]="DROP TABLE IF EXISTS `".$_SESSION['dbprefix']."terrain`";
            $req[]="CREATE TABLE `".$_SESSION['dbprefix']."terrain` ( `idTerrain` int(10) unsigned NOT NULL auto_increment, `nomTerrain` varchar(80) NOT NULL, `rueTerrain` varchar(130) default NULL, `Ville_idVille` int(10) unsigned NOT NULL, `urlLocalisationTerrain` varchar(130) default NULL, `Club_idClub` int(10) unsigned NOT NULL, PRIMARY KEY (`idTerrain`)) ";
            $req[]="DROP TABLE IF EXISTS `".$_SESSION['dbprefix']."typederencontre`";
            $req[]="CREATE TABLE `".$_SESSION['dbprefix']."typederencontre` ( `idTypeDeRencontre` int(10) unsigned NOT NULL auto_increment, `nomType` varchar(50) NOT NULL, PRIMARY KEY (`idTypeDeRencontre`)) ";
            $req[]="INSERT INTO `".$_SESSION['dbprefix']."typederencontre` (nomType) value ('Championnat')";
            $req[]="DROP TABLE IF EXISTS `".$_SESSION['dbprefix']."matchs`";
            $req[]="CREATE TABLE `".$_SESSION['dbprefix']."matchs` ( `idMatchs` int(11) NOT NULL auto_increment, `Club_idClub` int(10) unsigned NOT NULL, `Equipe_idEquipe` int(10) unsigned NOT NULL, `Date` date NOT NULL, `Heure` time NOT NULL, `TypeDeRencontre_idTypeDeRencontre` int(10) unsigned NOT NULL default 1, `Terrain_idTerrain` int(10) unsigned NOT NULL, `ScorePour` int(10) NOT NULL default '-1', `ScoreContre` int(10) NOT NULL default '-1', `Forfait` tinyint(1) NOT NULL default '0', `Notes` text NOT NULL, PRIMARY KEY (`idMatchs`)) ";
            $req[]="DROP TABLE IF EXISTS `".$_SESSION['dbprefix']."ville`";
            $req[]="CREATE TABLE `".$_SESSION['dbprefix']."ville` ( `idVille` int(10) unsigned NOT NULL auto_increment, `cpVille` int(10) unsigned NOT NULL, `nomVille` varchar(60) NOT NULL, PRIMARY KEY (`idVille`)) ";
            $req[]="DROP TABLE IF EXISTS `websitetyperencontre`";
            $req[]="CREATE TABLE `".$_SESSION['dbprefix']."websitetyperencontre` ( `Equipe_idEquipe` int(10) unsigned NOT NULL, `TypeDeRencontre_idTypeDeRencontre` int(10) unsigned NOT NULL, `urlChampionnat` varchar(120) NOT NULL, PRIMARY KEY (`Equipe_idEquipe`,`TypeDeRencontre_idTypeDeRencontre`)) ";
            $req[]="DROP TABLE IF EXISTS `".$_SESSION['dbprefix']."users`";
            $req[]="CREATE TABLE `".$_SESSION['dbprefix']."users` ( `idUser` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, `nomUser` VARCHAR(20) NOT NULL, `passwordUser` VARCHAR(32) NOT NULL, `rights` INT NOT NULL )";
            $req[]="DROP TABLE IF EXISTS `".$_SESSION['dbprefix']."canupdate`";
            $req ="CREATE TABLE `".$_SESSION['dbprefix']."canupdate` (Users_idUser INT NOT NULL, Equipe_idEquipe INT NOT NULL, PRIMARY KEY (`User_idUser`, `Equipe_idEquipe`))";

            $dbLink=mysqli_connect($_SESSION['dbhost'],$_SESSION['dbusername'],$_SESSION['dbpwd']) or die ("Connexion au serveur échouée<br>".form_db());
            mysqli_select_db($dbLink,$_SESSION['dbname']) or die("Connexion au serveur échouée<br>".form_db());
            for ($i=0;$i<count($req);$i++){
                mysqli_query($dbLink, $req[$i]) or die (mysqli_error($dbLink));
            }    
            mysqli_close();
        }
    }    

    function form_club() {
        echo "<form name=\"club\" action=\"index.php?i=2\" method=\"POST\"><br>\n";
        echo "\t<table>\n";
        echo "\t<tr><td>Nom du club complet </td><td> <input type=\"text\" name=\"ncc\"></input></td></tr>\n";
        echo "\t<tr><td>Nom du club utilisé </td><td> <input type=\"text\" name=\"ncused\"></input></td></tr>\n";
        echo "\t<tr><td>Rue </td><td> <input type=\"text\" name=\"rue\"></input></td></tr>\n";
        echo "\t<tr><td>Code Postal </td><td> <input type=\"text\" name=\"cp\"></input></td></tr>\n";
        echo "\t<tr><td>Ville </td><td> <input type=\"text\" name=\"ville\"></input><br>\n";
        echo "\t<tr><td>Téléphone </td><td> <input type=\"text\" name=\"tel\"></input><br>\n";
        echo "\t<tr><td>Fax </td><td> <input type=\"text\" name=\"fax\"></input><br>\n";
        echo "\t<tr><td>E-mail </td><td> <input type=\"text\" name=\"email\"></input><br>\n";
        echo "\t<tr><td>Numéro informatique </td><td> <input type=\"text\" name=\"numinfo\"></input><br>\n";
        echo "\t<tr><td>Site internet </td><td> <input type=\"text\" name=\"website\"></input><br>\n";
        echo "\t</table>\n";
        echo "\t<br>\n";
        echo "\t<input type=\"submit\" name=\"ok\" class=\"formcss\"value=\"Suivant\"><br>\n";
        echo "</form>\n";
    }

    function trait_form_club() {
        $dbLink = mysqli_connect($_SESSION['dbhost'],$_SESSION['dbusername'],$_SESSION['dbpwd']) or die ("Connexion au serveur échouée<br>".form_db());
        mysqli_select_db($dbLink, $_SESSION['dbname']) or die("Connexion au serveur échouée<br>".form_db());

        $req="select * from ".$_SESSION['dbprefix']."ville where cpVille='".(int)$_POST['cp']."' and nomVille='".addslashes($_POST['ville'])."'";
        $res=mysqli_query($dbLink, $req);
        $idville=-1;
        if (mysqli_num_rows($res)==1) {
            $res=mysqli_fetch_assoc($res);
            $idville=$res['idVille'];
        }
        else {
            $req="insert into ".$_SESSION['dbprefix']."ville (cpVille,nomVille) value ('".(int)$_POST['cp']."','".addslashes($_POST['ville'])."')"; 
            mysqli_query($dbLink, $req) or die (mysqli_error($dbLink));
            $idville=mysqli_insert_id($dbLink);
        }

        $req="insert into ".$_SESSION['dbprefix']."club (nomClubComplet,nomClubCourt,rueClub,Ville_idVille,telClub,faxClub,emailClub,numInformatiqueClub,urlwebpage) value ('".addslashes($_POST['ncc'])."','".addslashes($_POST['ncused'])."','".addslashes($_POST['rue'])."','".(int)$idville."','".addslashes($_POST['tel'])."','".addslashes($_POST['fax'])."','".addslashes($_POST['email'])."','".(int)$_POST['numinfo']."','".addslashes($_POST['website'])."')"; 
        mysqli_query($dbLink, $req) or die (mysqli_error($dbLink));

        $_SESSION['idclub']=mysqli_insert_id($dbLink);
        $_SESSION['title']="tmChamp - ".$_POST['ncc'];
        
        mysqli_close($dbLink);
    }

    function form_admin() {
        echo "<form name=\"admin\" action=\"index.php?i=3\" method=\"POST\"><br>\n";
        echo "\t<table>\n";
        echo "\t<tr><td>Username </td><td> <input type=\"text\" name=\"usr\"></input></td></tr>\n";
        echo "\t<tr><td>Pasword </td><td> <input type=\"password\" name=\"pwd\"></input></td></tr>\n";
        echo "\t</table>\n";
        echo "\t<br>\n";
        echo "\t<input type=\"submit\" name=\"ok\" class=\"formcss\"value=\"Suivant\"><br>\n";
        echo "</form>\n";
    }

    function trait_form_admin() {
        $dbLink=mysqli_connect($_SESSION['dbhost'],$_SESSION['dbusername'],$_SESSION['dbpwd']) or die ("Connexion au serveur échouée<br>".form_db());
        mysqli_select_db($dbLink, $_SESSION['dbname']) or die("Connexion au serveur échouée<br>".form_db());

        $sql="insert into `".$_SESSION['dbprefix']."users` (nomUser,passwordUser,rights) values ('".$_POST['usr']."', '".md5($_POST['pwd'])."', '".ADMINISTRATOR."')";

        mysqli_query($dbLink, $sql) or die (mysqli_error($dbLink));

        mysqli_close($dbLink);
    }    

    function write() {
        $f=fopen("../rsc/config.php","w");
        
        $_SESSION['theme']="base";
        $_SESSION['title']="tmChamp";
        $_SESSION['lang']="fr";


        fwrite ($f,"<?php\n");
        fwrite ($f,"\t\$conf=array();\n");
        foreach ( $_SESSION as $key=>$val ) {
            fwrite($f,"\t\$conf['$key']=\"$val\";\n");
        }
        fwrite ($f,"?>");

        fclose($f);

        echo html_entities("fichier de configuration généré<br>veuillez supprimer le répértoire \"install\" pour des raisons de sécurité");
    }

    function Routeur () {
        $step=array ( "base de données", "club", "administration" );
        $i=(int)$_GET['i'];


        for ($j=0;$j<count($step);$j++) {
            echo (($j<=$i)?"<b>":"").ucfirst($step[$j]).(($j<=$i)?"</b>":"");
            if ($j!=count($step)-1) echo " - ";
        }

        switch ($i) {
            case 0 : start(); form_db (); break;
            case 1 : trait_form_db (); form_club (); break;
            case 2 : trait_form_club (); form_admin (); break;
            case 3 : trait_form_admin (); write (); break;
            default : break;    
        }
    }


?>

<html>
<head><title>tmChamp - install</title></head>
<style>
td {
    vertical-align : top;
}

h1 {
    font-size:60px;
    font-weight:bold;
}

div {
    border : 1px solid #000000;
    width : 50%;
}

</style>
<body>
    <table width="100%" height="100%">
        <tr>
            <td  align="center">
                <div><h1><img src="logo.gif">Champ installation</h1><?php Routeur(); ?></div>
            </td>
        </tr>
    </table>
</body>
</html>
