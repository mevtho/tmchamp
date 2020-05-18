<?php
 
// Configuration //
    define ("CONFIG_DIRECTORY","rsc/");
    define ("CONFIG_FILE",CONFIG_DIRECTORY."config.php");    
    define ("PRINT_CSS_FILE",CONFIG_DIRECTORY."style.css.php");    
    
    require_once (CONFIG_FILE);
    define ("FUNCTION_LANG_FILE",CONFIG_DIRECTORY."lang/".$conf['lang'].".inc.php");


// Theme //
    define ("THEME_DIRECTORY","theme/");
    define ("THEME_FILE","/template.html");
    define ("THEME_POPUP_FILE","/template_popup.html");
    define ("THEME_PRINT_FILE","/template_print.html");

// Class //
    define ("CLASS_DIRECTORY","class/");

// Class //
    define ("JAVASCRIPT_DIRECTORY","js/");

// Functions //
    define ("FUNCTION_DIRECTORY","function/");
    define ("FUNCTION_DESIGN_FILE",FUNCTION_DIRECTORY."design.php");
    define ("FUNCTION_UTIL_FILE",FUNCTION_DIRECTORY."utils.php");
    define ("FUNCTION_FORMS_FILE",FUNCTION_DIRECTORY."forms.php");
    define ("FUNCTION_CONTENT_ADMIN_FILE",FUNCTION_DIRECTORY."contentadmin.php");
    define ("FUNCTION_CONTENT_LOGGED_FILE",FUNCTION_DIRECTORY."contentlogged.php");
    define ("FUNCTION_CONTENT_ALL_FILE",FUNCTION_DIRECTORY."contentall.php");
    define ("FUNCTION_AJAX_FILE",FUNCTION_DIRECTORY."ajax_trait.php");
    

// HTML //
    define ("HTML_DIRECTORY","html/");

// Print //
    define ("PRINT_FILE",HTML_DIRECTORY."template_print.html.php");
    define ("PRINT_CSS",HTML_DIRECTORY."styleprint.css.php");

// DB //
    define ("TABLE_CATEGORIE",$conf['dbprefix']."categorie");
    define ("TABLE_CANUPDATE",$conf['dbprefix']."canupdate");
    define ("TABLE_CLUB",$conf['dbprefix']."club");
    define ("TABLE_COACH",$conf['dbprefix']."coach");
    define ("TABLE_CONTACT",$conf['dbprefix']."contact");
    define ("TABLE_DIVISION",$conf['dbprefix']."division");
    define ("TABLE_EQUIPE",$conf['dbprefix']."equipe");
    define ("TABLE_MATCHS",$conf['dbprefix']."matchs");
    define ("TABLE_RESPONSABILITE",$conf['dbprefix']."responsabilite");
    define ("TABLE_TERRAIN",$conf['dbprefix']."terrain");
    define ("TABLE_TYPEDERENCONTRE",$conf['dbprefix']."typederencontre");
    define ("TABLE_USERS",$conf['dbprefix']."users");
    define ("TABLE_VILLE",$conf['dbprefix']."ville");
    define ("TABLE_WEBSITETYPERENCONTRE",$conf['dbprefix']."websitetypederencontre");

// Content //
    $i=0;
    define ("HOME",$i++);
    define ("LOGIN",$i++);
    define ("LOGOUT",$i++);
    define ("JUSTLOGGED",$i++);
    define ("GAME",$i++);
    define ("COURT",$i++);
    define ("CLUB",$i++);
    define ("VILLE",$i++);
    define ("TEAM",$i++);
    define ("CONTACT",$i++);
    define ("COACH",$i++);
    define ("TYPE_RENCONTRE",$i++);
    define ("CATEGORIE",$i++);
    define ("DIVISION",$i++);
    define ("SCORE",$i++);
    define ("WEEK",$i++);
    define ("TIME",$i++);
    define ("USERS",$i++);

    define ("RESULTS",$i++);
    define ("SCORES",$i++);
    define ("AJAX",$i++);
    define ("PRINTABLE",$i++);
    define ("DAY",$i++);

// Act //
    define ("NONE",$i++);
    define ("ADD",$i++);
    define ("EDIT",$i++);
    define ("ADDED",$i++);
    define ("EDITED",$i++);
    define ("DELETE",$i++);

// Access Level //
    define ("VISITOR",0);
    define ("USER",1);
    define ("SCORER",2);
    define ("UPDATER",3);
    define ("ADMINISTRATOR",4);

?>
