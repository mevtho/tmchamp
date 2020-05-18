<table>
    <tr valign="top" align="left">
        <td><img src="<?php echo $pathtopic; ?>/logo.gif"></td>
        <td>
<?php
echo "<h1>".$info['nomClubComplet']."</h1>";
echo "".$info['rueClub']."<br>";
echo "".$info['cpVille']." ";
echo "".$info['nomVille']."<br>";
if (!empty($info['telClub'])) echo "<b>".txt(txtTEL,true)." :</b> ".$info['telClub']."<br>";
if (!empty($info['faxClub'])) echo "<b>".txt(txtFAX,true)." :</b> ".$info['faxClub']."<br>";
if (!empty($info['emailClub'])) echo "<b>".txt(txtEMAIL,true)." :</b> <a href=\"mailto:".$info['emailClub']."\">".$info['emailClub']."</a><br>";
if (!empty($info['urlwebpage'])) echo "<a href=\"".$info['urlwebpage']."\">".txt(txtWEBSITE,true)."</a><br>";

if (!$isclub) {
    echo "<br><br>";    
    echo "[ <a href=\"index.php?EX=".GAME."&ida=".$info['idClub']."\">".txt(txtMATCHS_CONTRE_CLUB,true)."</a> ]";
}
?>
        </td>
    <tr>
</table>
