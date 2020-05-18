<?php
    require_once (FUNCTION_UTIL_FILE);
    require_once (FUNCTION_LANG_FILE);

    function head() {
        global $DO, $EX, $conf, $logged, $dblink, $userid;
        $EX=isset($_REQUEST['EX'])?(int)$_REQUEST['EX']:HOME;
        $DO=isset($_REQUEST['DO'])?(int)$_REQUEST['DO']:NONE;
         
        $dblink=openDatabase();
        
        $logged=isset($_COOKIE['User'])?(int)$_COOKIE['User']:VISITOR;  

        if ( $EX==JUSTLOGGED ) $logged=doLog();
        if ( $EX==LOGOUT ) { logOut(); $logged=VISITOR; } 
    }
 
    function includePage () {
        global $conf,$DO,$EX;
        head();
        switch ($EX) {    
            case AJAX :
                require_once ( FUNCTION_CONTENT_ALL_FILE ); 
                require_once ( FUNCTION_AJAX_FILE );   
                break;
            case PRINTABLE : 
                require_once ( PRINT_FILE );
                break;
            default :
                require_once (THEME_DIRECTORY.$conf['theme'].THEME_FILE);

                break;
        }
    }
        
    function menu() {
        if (!logged()) {
            $items=array ( 
                        txt(txtACCUEIL,true) => "index.php?EX=".HOME ,
                        txt(txtRESULTATS,true) => "index.php?EX=".RESULTS ,
                        txt(txtSEMAINE,true) => "index.php?EX=".WEEK
                   ) ;
        }
        else {
            $items=array ( 
                        txt(txtACCUEIL,true) => "index.php?EX=".HOME ,
                        txt(txtSCORES,true) => "index.php?EX=".SCORES ,
                        txt(txtRESULTATS,true) => "index.php?EX=".RESULTS ,
                        txt(txtSEMAINE,true) => "index.php?EX=".WEEK
                   ) ;

            if (loggedAsScorer()) {
            }

            if (loggedAsUpdater()) {
                $items[txt(txtEDITION,true)]="index.php?EX=".ADD;
            }

            if (loggedAsAdministrator()) {
            }

        }

        $class="menubar";

        require (HTML_DIRECTORY."mod_listurl.html.php");
    }

    function content($_EX=-1) {
        global $EX,$DO,$conf,$logged;
        require_once (FUNCTION_CONTENT_ALL_FILE);

        $EXE=($_EX==-1)?$EX:$_EX;

        
        if (!logged()) {
            switch ($EXE) {
                case LOGIN : echo "<h1>".txt(txtLOGIN,true)."</h1>"; logIn(); break;
                case JUSTLOGGED : echo "<i>".txt(txtLOGIN_FAILED,true)."</i><br>"; logIn(); break; 
                case GAME : view(GAME); break; 
                case CLUB : view(CLUB); break; 
                case TEAM : view(TEAM); break; 
                case RESULTS : echo "<h1>".txt(txtRESULTATS,true)."</h1>"; viewStats();
                               echo "<hr height=\"0\" width=\"80%\" />";
                case SCORES : echo "<h1>".txt(txtSCORES,true)."</h1>"; viewScores(); break;
                case PRINTABLE : printable(); break;
                case WEEK : echo (($EX!=PRINTABLE)?"<h1>".txt(txtMATCHS." ".txtPAR." ".txtSEMAINE,true)."</h1>":""); weekGame((int)$_REQUEST['w']); break; 
                case LOGOUT :  
                case HOME : echo "<h1>".txt(txtACCUEIL,true)."</h1>"; infoClub($conf['idclub']); echo "<hr>"; weekGame((int)$_GET['w']); break;
                default : echo txt(txtPAGE_NOT_FOUND,true); break;
            }
        }
        else {
            require_once (FUNCTION_CONTENT_LOGGED_FILE);
            
            if (loggedAsAdministrator()) {
                require_once (FUNCTION_CONTENT_ADMIN_FILE);
                switch ($EXE) {
                    case CLUB : form("club"); break; 
                    case COURT : form("court"); break; 
                    case COACH : form("coach"); break; 
                    case GAME : form("game"); break; 
                    case DIVISION : form("division"); break;
                    case VILLE : form("ville"); break;
                    case CONTACT : form("contact"); break;
                    case SCORE : form("score"); break;
                    case USERS : form("user"); break;
                    case TYPE_RENCONTRE : form("competition"); break;
                    case TEAM : form("equipe"); break;            
                    case CATEGORIE : form("categorie"); break;
                    case ADD : echo "<h1>".txt(txtEDITION,true)."</h1>"; indexAdd(); break;
                    case SCORES : echo "<h1>".txt(txtSCORES,true)."</h1>"; viewScores(); break;
                    case JUSTLOGGED : 
                        echo "<i>".txt(txtLOGIN_SUCCESSFULL,true)."</i><br>"; content(HOME);
                        break;
                    case RESULTS : echo "<h1>".txt(txtRESULTATS,true)."</h1>"; viewStats();
                                   echo "<hr height=\"0\" width=\"80%\" />";
                                   weekGame((int)$_REQUEST['w']-1);
                                   weekGame((int)$_REQUEST['w']);
                                   break;
                    case SCORES : echo "<h1>".txt(txtSCORES,true)."</h1>"; viewScores(); break;
                    case PRINTABLE : printable(); break;
                    case WEEK : echo (($EX!=PRINTABLE)?"<h1>".txt(txtMATCHS." ".txtPAR." ".txtSEMAINE,true)."</h1>":""); weekGame((int)$_REQUEST['w']); break; 
                    case HOME : echo "<h1>".txt(txtACCUEIL,true)."</h1>"; gameScoreToEnter(); break;
                    default : echo txt(txtPAGE_NOT_FOUND,true); break;   
                }
                return;
            }
            
            if (loggedAsUpdater()) {
                require_once (FUNCTION_CONTENT_ADMIN_FILE);
                switch ($EXE) {
                    case CLUB : form("club"); break; 
                    case COURT : form("court"); break; 
                    case COACH : form("coach"); break; 
                    case GAME : form("game"); break; 
                    case DIVISION : form("division"); break;
                    case VILLE : form("ville"); break;
                    case CONTACT : form("contact"); break;
                    case SCORE : form("score"); break;
                    case TYPE_RENCONTRE : form("competition"); break;
                    case TEAM : form("equipe"); break;            
                    case CATEGORIE : form("categorie"); break;
                    case ADD : echo "<h1>".txt(txtEDITION,true)."</h1>"; indexAdd(); break;
                    case SCORES : echo "<h1>".txt(txtSCORES,true)."</h1>"; viewScores(); break;
                    case JUSTLOGGED : 
                        echo "<i>".txt(txtLOGIN_SUCCESSFULL,true)."</i><br>";  content(HOME);
                        break;
                    case RESULTS : echo "<h1>".txt(txtRESULTATS,true)."</h1>"; viewStats();
                                   echo "<hr height=\"0\" width=\"80%\" />";
                                   weekGame((int)$_REQUEST['w']-1);
                                   weekGame((int)$_REQUEST['w']);
                                   break;
                    case PRINTABLE : printable(); break;
                    case WEEK : echo (($EX!=PRINTABLE)?"<h1>".txt(txtMATCHS." ".txtPAR." ".txtSEMAINE,true)."</h1>":""); weekGame((int)$_REQUEST['w']); break; 
                    case HOME : echo "<h1>".txt(txtACCUEIL,true)."</h1>"; gameScoreToEnter(); break;
                    default : echo txt(txtPAGE_NOT_FOUND,true); break;   
                }
                return;
            }      

            if (loggedAsScorer()) {
                require_once (FUNCTION_CONTENT_ADMIN_FILE);
                switch ($EXE) {
                    case CLUB : view(CLUB); break; 
                    case CONTACT : view(CONTACT); break; 
                    case SCORE : form("score"); break;
                    case JUSTLOGGED : 
                        echo "<i>".txt(txtLOGIN_SUCCESSFULL,true)."</i><br>";  content(HOME);
                        break;
                    case RESULTS : echo "<h1>".txt(txtRESULTATS,true)."</h1>"; viewStats();
                                   echo "<hr height=\"0\" width=\"80%\" />";
                                   weekGame((int)$_REQUEST['w']-1);
                                   weekGame((int)$_REQUEST['w']);
                                   break;
                    case SCORES : echo "<h1>".txt(txtSCORES,true)."</h1>"; viewScores(); break;
                    case PRINTABLE : printable(); break;
                    case WEEK : echo (($EX!=PRINTABLE)?"<h1>".txt(txtMATCHS." ".txtPAR." ".txtSEMAINE,true)."</h1>":""); weekGame((int)$_REQUEST['w']); break; 
                    case HOME : echo "<h1>".txt(txtACCUEIL,true)."</h1>"; gameScoreToEnter(getUserId());  weekGame((int)$_REQUEST['w']); break;
                    default : echo txt(txtPAGE_NOT_FOUND,true);  break;   
                }
                return;
            }      
            
            
            if (logged()) {
                switch ($EXE) {
                    case LOGIN : echo "<h1>".txt(txtLOGIN,true)."</h1>"; logIn(); break;
                    case JUSTLOGGED : echo "<i>".txt(txtLOGIN_SUCCESSFULL,true)."</i><br>"; content(HOME); break; 
                    case CONTACT : view(CONTACT); break; 
                    case GAME : view(GAME); break; 
                    case CLUB : view(CLUB); break; 
                    case TEAM : view(TEAM); break; 
                    case RESULTS : echo "<h1>".txt(txtRESULTATS,true)."</h1>"; viewStats();
                                   echo "<hr height=\"0\" width=\"80%\" />";
                    case SCORES : echo "<h1>".txt(txtSCORES,true)."</h1>"; viewScores(); break;
                    case PRINTABLE : printable(); break;
                    case WEEK : echo (($EX!=PRINTABLE)?"<h1>".txt(txtMATCHS." ".txtPAR." ".txtSEMAINE,true)."</h1>":""); weekGame((int)$_REQUEST['w']); break; 
                    case LOGOUT :  
                    case HOME : echo "<h1>".txt(txtACCUEIL,true)."</h1>"; infoClub($conf['idclub']); echo "<hr>"; weekGame((int)$_GET['w']); break;
                    default : break;
                }
                return;            
            }
        }
    }
    
    function checkInclude() {
        return true;
    }
 
    function getHeadItems() {
        echo "<script language=\"javascript\" src=\"".JAVASCRIPT_DIRECTORY."function.js.php\"></script>\n";
        echo "<link rel=\"shortcut icon\" href=\"./img/design/logo.gif\" type=\"image/x-icon\" />\n";
    }
    
    function scriptEnd ($pu) {
        global $DO,$EX;
        echo "<script language=\"javascript\">\n";
        echo "</script>\n";
    }

    function foot () {
        global $EX, $DO;
        $items=array ();
        if (!logged()) {
            $items['[ '.txt(txtLOGIN,true).' ]']="index.php?EX=".LOGIN;
        }
        else /* (logged()) */ {
            $items['[ '.txt(txtLOGOUT,true).' ]']="index.php?EX=".LOGOUT;
        }

        if ($EX!=SCORES && $EX!=RESULTS) {
            $items['[ '.txt(txtIMPRIMER,true).' ]']="index.php?EX=".PRINTABLE."&DO=".$EX;
            foreach ( $_GET as $key=>$value )
                if ($key!="DO" && $key!="EX") $items['[ Imprimer ]'].="&$key=$value";
        }        

        $items['by mevtho.com 2006']="http://tmChamp.mevtho.com";
        
        $class="foot";

        require (HTML_DIRECTORY."mod_listurl.html.php");
    }

    function toPrint() {
        global $EX,$DO;
        return ( $EX==PRINTABLE || $DO==PRINTABLE );
    }

    function cssStyle ($css) {
        global $conf;    
        echo"<link rel=\"stylesheet\" type=\"text/css\" href=\"".THEME_DIRECTORY.$conf['theme']."/".$css."\">\n";
    }

    function getThemeDir() {
        global $conf;        
        return THEME_DIRECTORY.$conf['theme'];
    }

    function getShortName() {
        global $dblink,$conf;
        $sql="select nomClubCourt from ".TABLE_CLUB." where idClub=".$conf['idclub'];
        $row=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));
        $res=mysqli_fetch_assoc($row);
        return txt($res['nomClubCourt']);
    }

?>
