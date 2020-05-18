<?php

function listContact($id=-1) {
    global $dblink;
    if ($id==-1) return;

    $sql="select * from ".TABLE_CONTACT." where Club_idClub=$id order by nomContact ASC, prenomContact ASC";
    $result=mysqli_query($dblink,$sql) or die (mysqli_error($dblink));

    $items=array();
    while ($valc=mysqli_fetch_assoc($result)) {
        $items[txt($valc['nomContact']." ".$valc['prenomContact'])]="index.php?EX=".CONTACT."&DO=".NONE."&id=".(int)$valc['idContact'];
        $i++;
    }

    require(HTML_DIRECTORY."mod_listurl.html.php");
}

?>
