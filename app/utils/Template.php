<?php
class Template
{
    public function SetTimeToPostIPN($action, $tries) {
    echo "<html>
            <head>
                <title>".$lang['from_paypal_title']."</title>
                <meta http-equiv=\"refresh\" content=\"5;index.php?action=$action&tries=$tries\">
                <script language=\"Javascript\"><!--
                    function refresh () {
                        setTimeout(\"window.location.replace('index.php?action=$action&tries=$tries')\",5000)
                    }
                --></script>
            </head>
            <body onload=\"refresh()\";>
                <p align=\"center\">
                    <table height=\"100%\">
                        <tr>
                            <td valign=\"middle\">
                                <p align=\"center\">
                                    <table width=\"400px\" border=\"1\">
                                        <tr>
                                            <td>
                                                <font face=\"verdana\"><p align=\"center\"><b>".$_ENV['lang['from_paypal_explain']']."</b></p>
                                                <p align=\"center\"><i>".$timeleft."</i></p>
                                                <p align=\"center\">".$_ENV['lang['from_paypal_explain2']']."</p></font>
                                            </td>
                                        </tr>
                                    </table>
                                </p>
                            </td>
                        </tr>
                    </table>
                </p>
            </body>
        </html>";
	}

    public function paymenForm($affemail, $email, $item_name, $item_number, $item_cost, $item_download_url, $item_cancel_url, $sys_currency, $sys_locale, $sys_charset, $item_ipn_url, $ref,$aff, $ip, $salesletter) {
        # Use meta-refresh instead of header() redirect
	# header() seems to cause session issues with PayPal
	echo "<html>
	<head>
		<title>".$_ENV['lang['goto_paypal_title']']."</title>
	</head>
	<body>
		<p align=center>
		<table width=100% height=100%>
			<tr>
				<td align=center valign=center>
					<table width=420px cellpadding=5 style='border: 1px solid black; font-size: 12px;'>
						<tr>
							<td><font face=verdana><p>".$_ENV['lang['goto_paypal_explain']']."</p>
							<p>".$_ENV['lang['goto_paypal_explain2']']."</p></font></td>
						</tr>
					</table></td>
			</tr>
			<tr>
				<td align=center valign=top height=50px><p align=center><font style='font-size: 12px;'>[".$_ENV['lang['goto_paypal_affiliate']']." = $affemail]</font></p></td>
			</tr>
		</table></p>
		<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" id=paymentform>
		<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">
		<input type=\"hidden\" name=\"business\" value=\"$email\">
		<input type=\"hidden\" name=\"item_name\" value=\"$item_name\">
		<input type=\"hidden\" name=\"item_number\" value=\"$item_number\">
		<input type=\"hidden\" name=\"amount\" value=\"$item_cost\">
		<input type=\"hidden\" name=\"no_shipping\" value=\"1\">
		<input type=\"hidden\" name=\"return\" value=\"$item_download_url\">
		<input type=\"hidden\" name=\"cancel_return\" value=\"$item_cancel_url\">
		<input type=\"hidden\" name=\"no_note\" value=\"1\">
		<input type=\"hidden\" name=\"shipping\" value=\"0.00\">
		<input type=\"hidden\" name=\"currency_code\" value=\"$sys_currency\">
		<input type=\"hidden\" name=\"lc\" value=\"$sys_locale\">
		<input type=\"hidden\" name=\"charset\" value=\"$sys_charset\">
		<input type=\"hidden\" name=\"bn\" value=\"PP-BuyNowBF\">
		<input type=\"hidden\" name=\"rm\" value=\"2\">
		<input type=\"hidden\" name=\"notify_url\" value=\"$item_ipn_url\">
		<input type=\"hidden\" name=\"cbt\" value=\"".$_ENV['lang['return_button']']."\">
		<input type=\"hidden\" name=\"custom\" value=\"$ref|$aff|$ip||||$salesletter\">
		</form>
				<script language=javascript><!--
		setTimeout('redir()', 5000);

		function redir() {
			document.getElementById('paymentform').submit();
			}
				--></script>
			</body>
		</html>";
    }

    public function thanks() {
        echo "<html>
				<head>
					<title>".$_ENV['lang['taf_title']']."</title>
				</head>
				<body>
					<p><font color=\"blue\">".$_ENV['lang['taf_thankyou']']."</font></p>
				</body>
			</html>";
    }

    public function error() {
        echo "<html>
			<head>
				<title>".$_ENV['lang['error_title']']."</title>
			</head>
			<body>
				<p><font color=\"red\">".$_ENV['lang['taf_required']']."</font></p>
			</body>
		</html>";
    }

    public function adminArea(){
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html>
			<head>
				<title>Tableau d'Administration</title>
				<style type=\"text/css\"><!--
		body, p, td {font-size: 12px; font-family: Verdana,Arial;}
				--></style>
			</head>
			<body>
				<img src='images/adminlogo.gif' alt=\"\" border=0 />
				<p><b>Acc&egrave;s Administrateur</b></p>
				<form action='index.php' method=post>
				<table>
					<tr><td>nom d'utilisateur</td><td><input type=text name=username size=20 /></td></tr>
					<tr><td>mot de passe</td><td><input type=password name=password size=20 /></td></tr>
				</table>
				<input type=submit value='Connexion' />
				<input type=hidden name=action value=adminlogin />
				</form>
			</body>
		</html>";
    }

    public function authError() {
        echo "<html>
        <head>
            <title>Erreur lors de l'identification</title>
        </head>
        <body>
            <p><font color=\"red\"><b>Nom d'utilisateur ou mot de passe invalide.<br>Cliquez sur le bouton &quot;Retour&quot; de votre navigateur et essayez &agrave nouveau.</b></font></p>
            </body>
        </html>";
    }

    public function adminHeader() {
        $adminheader = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html>
			<head>
				<title>Tableau d'Administration</title>
				<style type=\"text/css\"><!--
		body {font-family: arial; font-size: 11pt;}
		a:link, a:visited, a:hover {color:blue}
		table {border-style: solid; border-width: 0 0 1px 0; border-color: #aaaaaa;}
		td {border-width: 1px 1px 0 1px; border-style: solid; border-color: #aaaaaa; padding: 2px; font-family: Verdana,Arial; font-size: 8pt;}
		.error {font-weight: bold; color: red;}
		.warning {font-weight: bold; color: orange;}
		.notice {font-weight: bold; color: green;}
				--></style>
			</head>
			<body>
				<a href=\"index.php?action=adminmenu\">menu</a>
		";
        return $adminheader;
    }

    public function adminFooter() {
        $adminfooter = "
        </body>
    </html>";
        return $adminfooter;
    }
    public function adminTable($messages) {
        echo adminHeader();
		echo "<p><b>Tableau d'Administration</b></p>
		<ol>
			<li><a href='index.php?action=adminbuys'>Voir Toutes les Ventes</a></li>
			<li><a href='index.php?action=adminbuys&amp;count=50'>Voir les 50 Derni&egrave;res Ventes</a></li>
			<li><a href='index.php?action=adminbuys&amp;count=100'>Voir les 100 Derni&egrave;res Ventes</a></li>
			<li><a href='index.php?action=adminmine'>Voir Mes Ventes</a></li>
			<li><a href='index.php?action=adminsearch'>Faire une Recherche sur les Ventes</a></li>
			<li><a href='index.php?action=adminconversion'>Rapport de Conversion</a></li>
			<li><a href='index.php?action=adminrefs'>Tous les R&eacute;f&eacute;rents</a></li>
			<li><a href='index.php?action=adminrefdomains'>Tous les Noms de Domaine R&eacute;f&eacute;rents</a></li>
			<li><a href='index.php?action=adminrefsmine'>R&eacute;f&eacute;rents pour Mes Ventes</a></li>
			<li><a href='index.php?action=adminrefdomainsmine'>Noms de Domaine R&eacute;f&eacute;rents pour Mes Ventes</a></li>
			<li><a href='index.php?action=adminfraud'>Rapport de Fraude</a></li>
			<li><a href='index.php?action=adminaffiliates'>Rapport Affili&eacute;s</a></li>
			<li><a href='index.php?action=adminemailaffiliates'>Envoyer un Message aux Affili&eacute;s</a></li>
			<li><a href='index.php?action=adminexport'>T&eacute;l&eacute;charger les Donn&eacute;es des Transactions (Format CSV)</a></li>
			<li><a href='index.php?action=adminlogout'>D&eacute;connexion</a></li>
		</ol>
		<p>$messages</p>";
		echo adminFooter();
    }

    public function returnToMenu() {
        echo adminHeader();
		echo "<a href='index.php?action=adminmenu'>Retour au Menu</a>
		<p><i>Pour prolonger la validit&eacute; du lien de t&eacute;l&eacute;chargement de $sys_expire_hours heures, cliquez sur le lien &quot;Date Expiration&quot;.</i></p>
		<p>Nombre total de ventes : $rcount. Montr&eacute;es ici : $showing. Vos ventes sont <span style='background-color: #ffffcc;'>en jaune</span>.</p>
			<table cellspacing=0 cellpadding=0>
				<tr>
					<td><b>Id. Transaction PayPal</b></td>
					<td><b>Identifiant Produit</b></td>
					<td><b>Email Receveur</b></td>
					<td><b>Email Client</b></td>
					<td><b>Pr&eacute;nom Client</b></td>
					<td><b>Nom Client</b></td>
					<td><b>Montant</b></td>
					<td><b>Date Achat</b></td>
					<td><b>Date Expiration</b></td>
				</tr>";
    }

    public function searchForms(){
        echo adminHeader();
			echo "<p><a href='index.php?action=adminmenu'>Retour au Menu</a></p>
			<form action='index.php' method='post' name='search'>
			<b>Trouver les ventes correspondant &agrave :</b><br />
			<select name='field'>
				<option value=0>Id. Transaction PayPal</option>
				<option value=2>Identifiant Produit</option>
				<option value=3>Email du Receveur</option>
				<option value=13>Email de l'Affili&eacute;</option>
				<option value=4 selected>Email du Client</option>
				<option value=5>Pr&eacute;nom du Client</option>
				<option value=6>Nom du Client</option>
			</select>
			<br />
			<select name=compare>
				<option value=1>est exactement</option>
				<option value=2 selected>contient</option>
			</select>
			<br />
			<input type=text size=30 name=\"query\" value=\"cl&eacute; de recherche\" />
			<p><input type=submit value='Lancer la Recherche' /></p>
			<input type=hidden name=action value=adminsearch2 />
			</form>
			<script type=\"text/javascript\">
			  document.search.query.focus();
			</script>";
            echo adminFooter();
			
    }
    public function baseSearchResult() {
        echo "<tr>
        <td><b>Id. Transaction PayPal</b></td>
        <td><b>Identifiant Produit</b></td>
        <td><b>Email Receveur</b></td>
        <td><b>Email Client</b></td>
        <td><b>Pr&eacute;nom Client</b></td>
        <td><b>Nom Client</b></td>
        <td><b>Montant</b></td>
        <td><b>Date Achat</b></td>
        <td>&nbsp;</td>
    </tr>"
    }
    public function researchResult() {
        echo adminHeader();
		echo "<p><a href='index.php?action=adminmenu'>Retour au Menu</a></p>
			<p><b>Ventes correspondant &agrave; votre recherche :</b></p>
			<p><i>Pour prolonger la validit&eacute; du lien de t&eacute;l&eacute;chargement de $sys_expire_hours heures, cliquez sur le lien &quot;Date Expiration&quot;.</i></p>
			";
        baseSearchResult()
    }

    public function researchfraudes() {
        echo adminHeader();
    echo "<a href='index.php?action=adminmenu'>Retour au Menu</a>
    <p>Nombre total de fraudes pr&eacute;sum&eacute;es : $rcount. (Le lien de t&eacute;l&eacute;chargement n'est dans ce cas pas envoy&eacute;.)</p>
    <table cellspacing=0 cellpadding=0>   
    ";
    }
    
    public function conversionReport(){
        echo adminHeader();
			echo "<p><a href='index.php?action=adminmenu'>Retour au Menu</a></p>
			<p><b>Rapport de Conversion</b></p>
			<table cellspacing=0 cellpadding=0 width=700>
				<tr>
					<td><b>Lettre de Vente</b></td><td><b>Nombre de Visites</b></td><td><b>Nombre de Ventes</b></td><td><b>Taux de Conversion</b></td></tr>
			";
    }

    public function totalNumberSales($rcount, $showing) {
        echo adminHeader();
		echo "<a href='index.php?action=adminmenu'>Retour au Menu</a>
		<p>Nombre total de ventes : $rcount. Prises en compte ici : $showing.</p>
		<table cellspacing=0 cellpadding=0>
			<tr>
				<td><b>R&eacute;f&eacute;rent</b></td>
				<td><b>Nom de Domaine</b></td>
				<td><b>Mots cl&eacute;s</b></td>
				<td align=right><b>Nbre. de Ventes</b></td>
			</tr>
			";
    }

    public function affiliateMailerForm(){
        echo adminHeader();
			echo "<a href='index.php?action=adminmenu'>Retour au Menu</a>
			<form action='index.php' method=post>
			<p><b>Sujet du Message :</b><br />
				<input type=text name=esubject size=30 maxlength=255 /></p>
			<p><b>Texte du Message :</b><br />
				<textarea name=ebody rows=10 cols=60></textarea></p>
			<p>Envoyer seulement aux affili&eacute;s ayant r&eacute;alis&eacute; au moins <input type=text name=esales value='0' size=5 /> vente(s).</p>
			<p><input type=submit value='Envoyer le Message' /></p>
			<input type=hidden name=action value=adminemailaffiliates2 />
			</form>";
            echo adminFooter();
    }

    public function removeAffiliate() {
        echo "<html>
			<head>
				<title>".$lang['unsub_title']."</title>
			</head>
			<body>
				<p><font color=\"blue\">".$lang['unsub_explain']."</font></p>
			</body>
		</html>";
    }
}
?>