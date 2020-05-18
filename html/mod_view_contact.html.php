<table>
    <tr valign="top" align="left">
        <td>
<?php
echo "<h1>".$info['prenomContact']." ".$info['nomContact']."</h1>";
echo "<h2>".$info['nomClubComplet']."</h2>";
echo "".$info['adresseContact']."<br>";
echo "".$info['cpVille']." ".$info['nomVille']."<br>";
if (!empty($info['telContact'])) echo "<b>".txt(txtTEL,true)." :</b> ".$info['telContact']."<br>";
if (!empty($info['faxContact'])) echo "<b>".txt(txtFAX,true)." :</b> ".$info['faxContact']."<br>";
if (!empty($info['emailContact'])) echo "<b>".txt(txtEMAIL,true)." :</b> <a href=\"mailto:".$info['emailContact']."\">".$info['emailContact']."</a><br>";

$nb=count($resp);
if ($nb==2) echo "<h2>".txt(txtRESPONSABILITE,true)." :</h2>";
if ($nb>2) echo "<h2>".txt(txtRESPONSABILITES,true)." :</h2>";
if ($nb>1) {
    echo "<ul>\n";    
    for ($i=0;$i<count($resp);++$i)
        echo "<li>".$resp[$i]['Responsabilite']."</li>\n";
    echo "</ul>\n";
}
?>

        </td>
    <tr>
</table>
