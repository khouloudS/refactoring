<?php
$sys_version = "2.9";

$settings_header = "";

# Default settings.
$help["sys_admin_username"] = "Tableau d'administration : Identifiant de l'administrateur. Ne doit comporter ni espace, ni caractère accentué.";
$help2["sys_admin_username"] = $help["sys_admin_username"];
$vars["sys_admin_username"] = "identifiant";
$type["sys_admin_username"] = "text";

$help["sys_admin_password"] = "Tableau d'administration : Mot de passe de l'administrateur. Ne doit comporter ni espace, ni caractère accentué.";
$help2["sys_admin_password"] = $help["sys_admin_password"];
$vars["sys_admin_password"] = "motdepasse";
$type["sys_admin_password"] = "text";

$help["sys_domain"] = "Nom de domaine du site où est installé le script. SANS 'www.' et SANS 'http://' Toutes les lettres doivent être des MINUSCULES. Il ne doit y avoir aucun '/'";
$help2["sys_domain"] = $help["sys_domain"];
$vars["sys_domain"] = "nomdedomaine.com";
$type["sys_domain"] = "text";

$help["sys_default_email"] = "Adresse email principale de votre compte PayPal. Votre compte doit être de type Premier ou Business. Un compte de type Personnel ne peut PAS être utilisé.";
$help2["sys_default_email"] = $help["sys_default_email"];
$vars["sys_default_email"] = "mon@adresse-email-paypal.com";
$type["sys_default_email"] = "text";

$help["sys_support_address"] = "Adresse email ou de la page web de votre service client. Doit inclure 'http://' si c'est une page web ; ainsi : http://monsite.com/service-client/";
$help2["sys_support_address"] = "Adresse email ou de la page web de votre service client.
# Doit inclure 'http://' si c'est une page web ; ainsi : http://monsite.com/service-client/";
$vars["sys_support_address"] = "mon@adresse-service-client.com";
$type["sys_support_address"] = "text";

$help["sys_fraud_address"] = "Adresse email à laquelle est envoyée la notification de fraude si une tentative est détectée.";
$help2["sys_fraud_address"] = $help["sys_fraud_address"];
$vars["sys_fraud_address"] = "mon@adresse-fraude.com";
$type["sys_fraud_address"] = "text";

$help["sys_script_folder"] = "Nom du répertoire où vous installez le script. Changez la valeur ci-dessous seulement si vous l'installez dans un répertoire. Si c'est le cas, vous DEVEZ mentionner le '/' initial ET le '/' final. Exemple : Si vous installez à monsite.com/produit1/ vous devez indiquer /produit1/ ci-dessous. Ne doit comporter ni espace, ni caractère accentué. Ne changez PAS la valeur ci-dessous (laissez /) si vous installez le script à la racine de votre site.";
$help2["sys_script_folder"] = "Nom du répertoire où vous installez le script. Changez la valeur ci-dessous seulement
# si vous l'installez dans un répertoire. Si c'est le cas, vous DEVEZ mentionner le '/' initial ET le '/' final.
# Exemple : Si vous installez à monsite.com/produit1/ vous devez indiquer /produit1/ ci-dessous. Ne doit 
# comporter ni espace, ni caractère accentué. Ne changez PAS la valeur ci-dessous (laissez /) si vous installez
# le script à la racine de votre site.";
$vars["sys_script_folder"] = "/";
$type["sys_script_folder"] = "text";

$help["sys_template_folder"] = "Nom du répertoire où sont placées les templates HTML et TXT. Ne doit comporter ni espace, ni caractère accentué. Utilisez un NOM DIFFICILE A DEVINER, par exemple 'tpl54526DF747'. Vous DEVEZ PLACER UN '/' APRES CE NOM, mais PAS avant, comme dans le modèle ci-dessous. Pensez à changer ce nom sur votre hébergement web avec votre logiciel FTP si ce n'est pas déjà fait. Donnez à ce répertoire les permissions d'accès 755 (CHMOD 755) avec votre logiciel FTP.";
$help2["sys_template_folder"] = "Nom du répertoire où sont placées les templates HTML et TXT. Ne doit comporter 
# ni espace, ni caractère accentué. Utilisez un NOM DIFFICILE A DEVINER, par exemple 'tpl54526DF747'. Vous DEVEZ 
# PLACER UN '/' APRES CE NOM, mais PAS avant, comme dans le modèle ci-dessous. Pensez à changer ce nom sur votre
# hébergement web avec votre logiciel FTP si ce n'est pas déjà fait. Donnez à ce répertoire les permissions
# d'accès 755 (CHMOD 755) avec votre logiciel FTP.";
$vars["sys_template_folder"] = "templates997711/";
$type["sys_template_folder"] = "text";

$help["sys_item_name"] = "Nom du Produit Principal. Pour éviter les problèmes d'affichage sur le site PayPal, remplacez les caractères accentués par leur équivalent non accentué (exemple : é devient e).";
$help2["sys_item_name"] = $help["sys_item_name"];
$vars["sys_item_name"] = "Nom du Produit Principal";
$type["sys_item_name"] = "text";

$help["sys_item_number"] = "Référence/Identifiant du Produit Principal (Identifiant Objet PayPal ; vous le choisissez comme vous voulez).";
$help2["sys_item_number"] = $help["sys_item_number"];
$vars["sys_item_number"] = "PROD-001";
$type["sys_item_number"] = "text";

$help["sys_item_cost"] = "Prix du Produit Principal. Utilisez le POINT si ce nombre est décimal, PAS la virgule, comme dans le modèle ci-dessous.";
$help2["sys_item_cost"] = $help["sys_item_cost"];
$vars["sys_item_cost"] = "7.50";
$type["sys_item_cost"] = "number";

$help["sys_item_location"] = "Localisation du Produit Principal sous cette forme : repertoire/fichier.zip. C'est le répertoire d'installation du script qui sert de référence (voir le guide d'utilisation pour des exemples). N'utilisez ni espace, ni caractère accentué. Utilisez un nom DIFFICILE A DEVINER pour le répertoire où est placé le produit. Exemple : dl4789Uyt78";
$help2["sys_item_location"] = "Localisation du Produit Principal sous cette forme : repertoire/fichier.zip.
# C'est le répertoire d'installation du script qui sert de référence (voir le guide d'utilisation pour des exemples).
# N'utilisez ni espace, ni caractère accentué. Utilisez un nom DIFFICILE A DEVINER pour le répertoire où est placé 
# le produit. Exemple : dl4789Uyt78";
$vars["sys_item_location"] = "repertoire/produit.zip";
$type["sys_item_location"] = "text";

$help["sys_item_percent"] = "Commission d'affiliation pour le Produit Principal, en POURCENTS, SANS le signe '%'.";
$help2["sys_item_percent"] = "Commission d'affiliation pour le Produit Principal,
# en POURCENTS, SANS le signe '%'.";
$vars["sys_item_percent"] = 100;
$type["sys_item_percent"] = "number";

$help["sys_blocked"] = "Adresses email PayPal auxquelles  vous interdisez de participer au programme d'affiliation, séparées par une virgule (ainsi : a1@email1.com,b2@email2.com,c3@email3.fr). Laissez blanc si vous ne voulez bloquer aucune adresse.";
$help2["sys_blocked"] = "Adresses email PayPal auxquelles qui vous interdisez
# de participer au programme d'affiliation, séparées par une virgule
# (ainsi : a1@email1.com,b2@email2.com,c3@email3.fr). Laissez blanc si
# vous ne voulez bloquer aucune adresse.";
$vars["sys_blocked"] = "";
$type["sys_blocked"] = "text";

$help["sys_oto"] = "Proposez-vous une Offre Spéciale Unique (OTO) ?";
$help2["sys_oto"] = "Proposez-vous une Offre Spéciale Unique (OTO) ? Indiquez 'true' ci-dessous. Sinon, indiquez 'false'. (Sans les ' ')";
$vars["sys_oto"] = true;
$type["sys_oto"] = "boolean";

$help["sys_oto_name"] = "Nom du Produit de l'OTO. Pour éviter les problèmes d'affichage sur le site PayPal, remplacez les caractères accentués par leur équivalent non accentué (exemple : é devient e).";
$help2["sys_oto_name"] = $help["sys_oto_name"];
$vars["sys_oto_name"] = "Mon Offre Speciale Unique";
$type["sys_oto_name"] = "text";

$help["sys_oto_number"] = "Référence/Identifiant du Produit de l'OTO (Identifiant Objet PayPal ; vous le choisissez comme vous voulez).";
$help2["sys_oto_number"] = $help["sys_oto_number"];
$vars["sys_oto_number"] = "OTO-1234";
$type["sys_oto_number"] = "text";

$help["sys_oto_cost"] = "Prix de l'OTO. Si ce nombre est décimal, vous devez utiliser le point, PAS la virgule, comme dans l'exemple ci-dessous.";
$help2["sys_oto_cost"] = $help["sys_oto_cost"];
$vars["sys_oto_cost"] = "27.50";
$type["sys_oto_cost"] = "text";

$help["sys_oto_location"] = "Localisation du Produit de l'OTO sous cette forme : repertoire/fichier.zip. C'est le répertoire d'installation du script qui sert de référence (voir le guide d'utilisation pour des exemples). N'utilisez ni espace, ni caractère accentué. Utilisez un nom DIFFICILE A DEVINER pour le répertoire où est placé le produit. Exemple : dl4789Uyt78";
$help2["sys_oto_location"] = "Localisation du Produit de l'OTO sous cette forme : repertoire/fichier.zip. 
# C'est le répertoire d'installation du script qui sert de référence (voir le guide d'utilisation pour 
# des exemples). N'utilisez ni espace, ni caractère accentué. Utilisez un nom DIFFICILE A DEVINER pour
# le répertoire où est placé le produit. Exemple : dl4789Uyt78";
$vars["sys_oto_location"] = "repertoire/oto.zip";
$type["sys_oto_location"] = "text";

$help["sys_oto_percent"] = "Commission d'affiliation pour l'OTO, en POURCENTS, sans le signe '%'.";
$help2["sys_oto_percent"] = "Commission d'affiliation pour l'OTO, en POURCENTS, sans le signe '%'.";
$vars["sys_oto_percent"] = 50;
$type["sys_oto_percent"] = "number";

$help["sys_expire_hours"] = "Nombre d'heures après lequel le lien de téléchargement devient inactif.";
$help2["sys_expire_hours"] = $help["sys_expire_hours"];
$vars["sys_expire_hours"] = 72;
$type["sys_expire_hours"] = "number";

$help["sys_giveaway_product"] = "DONNEZ-vous le Produit Principal au lieu de le vendre ? (Note : Si vous le donnez, il est vivement recommandé d'attribuer une commission pour l'OTO, sinon vos affiliés ne seront pas motivés à faire la promotion de votre offre.) ATTENTION : Dans le template 'salesletter.html', le lien 'Commander' doit dans ce cas être remplacé par un lien spécial - voir le guide d'utilisation.";
$help2["sys_giveaway_product"] = "DONNEZ-vous le Produit Principal au lieu de le vendre ? (Note : Si vous le donnez,
# il est vivement recommandé d'attribuer une commission pour l'OTO, sinon vos affiliés ne seront pas motivés
# à faire la promotion de votre offre.) ATTENTION : Dans le template 'salesletter.html', le lien 'Commander'
# doit dans ce cas être remplacé par un lien spécial - voir le guide d'utilisation.";
$vars["sys_giveaway_product"] = false;
$type["sys_giveaway_product"] = "boolean";

$help["sys_salesletters"] = "";
$help2["sys_salesletters"] = "Split-testing (optionnel) de la page de vente du Produit Principal.
\$sys_salesletters = array();
# Vous devez modifier le fichier 'settings.php' manuellement pour cela.
# Voir le guide d'utilisation.
\$sys_salesletters[] = \"salesletter.html\";";
$vars["sys_salesletters"] = "salesletter.html";
$type["sys_salesletters"] = "skip";

$help["sys_max_sales"] = "Si vous voulez restreindre la vente du Produit Principal à un certain nombre d'exemplaires, indiquez ce nombre ci-dessous. Laissez '0' (zéro) pour ne pas limiter cette vente.";
$help2["sys_max_sales"] = "Si vous voulez restreindre la vente du Produit Principal à un certain nombre
# d'exemplaires, indiquez ce nombre ci-dessous. Laissez '0' (zéro) pour ne pas limiter cette vente.";
$vars["sys_max_sales"] = 0;
$type["sys_max_sales"] = "number";

$help["sys_currency"] = "Monnaie du paiement.";
$help2["sys_currency"] = "Monnaie du paiement

# Pays/Zone : Monnaie						Valeur à utiliser
# ============================================================
# Euro [valeur par défaut]					EUR
# Australie : Dollar Australien				AUD
# Brésil : Real								BRL
# Canada : Dollar Canadien					CAD
# Danemark : Couronne Danoise				DKK
# Hong Kong : Dollar de Hong Kong			HKD
# Hongrie : Forint							HUF
# Israël : Shekel							ILS
# Japon : Yen								JPY
# Malaisie : Ringgit						MYR
# Mexique : Peso Mexicain					MXN
# Norvège : Couronne Norvégienne			NOK
# Nouvelle-Zélande : Dollar Néo-Zélandais	NZD
# Philippines : Peso Philippin				PHP
# Pologne : Zloty							PLN
# Royaume-Uni : Livre Sterling				GBP
# Singapour : Dollar de Singapour			SGD
# Suède : Couronne Suédoise					SEK
# Suisse : Franc Suisse						CHF
# Taïwan : Dollar de Taïwan					TWD
# Tchéquie : Couronne Tchèque				CZK
# Thaïlande : Baht							THB
# Turquie : Livre Turque					TRY
# USA : Dollar Américain					USD";
$vars["sys_currency"] = "EUR";
$type["sys_currency"] = "select";
$values["sys_currency"] = "<option value='AUD'>Australie : Dollar Australien</option><option value='BRL'>Brésil : Réal</option><option value='CAD'>Canada : Dollar Canadien</option><option value='DKK'>Danemark : Couronne Danoise</option><option value='EUR' selected>Euro</option><option value='HKD'>Hong Kong : Dollar de Hong Kong</option><option value='HUF'>Hongrie : Forint</option><option value='ILS'>Israël : Shekel</option><option value='JYP'>Japon : Yen</option><option value='MYR'>Malaisie : Ringgit</option><option value='MXN'>Mexique : Peso Mexicain</option><option value='NOK'>Norvège : Couronne Norvégienne</option><option value='NZD'>Nouvelle-Zélande : Dollar Néo-Zélandais</option><option value='PHP'>Philippines : Peso Philippin</option><option value='PLN'>Pologne : Zloty</option><option value='GBP'>Royaume-Uni : Livre Sterling</option><option value='SGD'>Singapour : Dollar de Singapour</option><option value='SEK'>Suède : Couronne Suédoise</option><option value='CHF'>Suisse : Franc Suisse</option><option value='TWD'>Taïwan : Dollar de Taïwan</option><option value='CZK'>Tchéquie : Couronne Tchèque</option><option value='THB'>Thaïlande : Baht</option><option value='TRY'>Turquie : Livre Turque</option><option value='USD'>USA : Dollar Américain</option>";

$help["sys_locale"] = "Langue de la page de paiement PayPal.";
$help2["sys_locale"] = "Langue de la page de paiement PayPal.
# Langue							Valeur à utiliser
# ====================================================
# Français [valeur par défaut]		FR
# Allemand							DE
# Anglais - Australie				AU
# Anglais - Royaume-Uni				UK
# Anglais - USA		 				US
# Chinois				 			CN
# Espagnol				 			ES
# Italien				 			IT
# Japonais				 			JP";
$vars["sys_locale"] = "FR";
$type["sys_locale"] = "select";
$values["sys_locale"] = "<option value='DE'>Allemand</option><option value='AU'>Anglais - Australie</option><option value='UK'>Anglais - Royaume-Uni</option><option value='US'>Anglais - USA</option><option value='CN'>Chinois</option><option value='ES'>Espagnol</option><option value='FR' selected>Français</option><option value='IT'>Italien</option><option value='JP'>Japonais</option>";

$settings_footer= "# Jeu de caractères pour la transaction PayPal.
\$sys_charset = \"ISO-8859-1\";


# Messages vus par les clients.
\$lang = array();
\$lang['from_paypal_title'] = \"Attente de connexion au site PayPal.\";
\$lang['from_paypal_explain'] = \"Attente de la confirmation du paiement par PayPal. Veuillez patienter...\";
\$lang['from_paypal_time'] = \"%n secondes restantes...\"; # %n indique le nombre de secondes
\$lang['from_paypal_explain2'] = \"(Cette page va se recharger toutes les 5 secondes jusqu'&agrave; ce que PayPal confirme votre paiement.)\";
\$lang['return_button'] = \"IMPORTANT : Cliquer ici pour t&eacute;l&eacute;charger votre achat\";
\$lang['goto_paypal_title'] = \"Veuillez patienter...\";
\$lang['goto_paypal_explain'] = \"Vous allez &ecirc;tre dirig&eacute; sur le site de paiement s&eacute;curis&eacute; PayPal dans 5 secondes.\";
\$lang['goto_paypal_explain2'] = \"N'oubliez pas de cliquer sur <b>\".\$lang['return_button'].\"</b> apr&egrave;s validation du paiement. Autrement, vous ne recevrez pas votre produit.\";
\$lang['goto_paypal_affiliate'] = \"affili&eacute;\";
\$lang['error_title'] = \"Erreur\";
\$lang['taf_title'] = \"Message Envoy&eacute;\";
\$lang['taf_thankyou'] = \"Merci ! Le message a &eacute;t&eacute; envoy&eacute;.\";
\$lang['taf_mail_error'] = \"Le message peut &ecirc;tre envoy&eacute; seulement &agrave; partir de \$sys_domain.\";
\$lang['taf_required'] = \"Les champs Votre Pr&eacute;nom et Votre Adresse Email PayPal ne doivent pas &ecirc;tre vides.\";
\$lang['unsub_title'] = \"D&eacute;sinscrition Prise En Compte.\";
\$lang['unsub_explain'] = \"Vous ne recevrez plus de message concernant \$sys_item_name.\";";

$action = $_POST["action"];
if ($action != "create") {
	# First, test that settings.php is writable
	if (file_exists("settings.php") && !is_writable("settings.php")) {
		utility_header();
?>
      <h2>Erreur !</h2>

			<p><span style="color: red; font-weight: bold;">Le fichier 'settings.php' doit avoir les permissions 664 ou 755 (CHMOD 664 ou 755).</span> Changez-les avec votre logiciel FTP, puis rechargez 'config.php'.</p>
<?php
		utility_footer();
		exit;
	}
	# Show the form.
	utility_header();
?>
        <h2>Configuration du script</h2>

        <p>Utilisez cet utilitaire pour paramétrer le script.</p>
        <hr />
<?php
	$output = "             <form action=\"config.php\" method=\"post\">
";
	$keys = array_keys($vars);
	foreach ($keys as $key) {
	$itemhtml = "";
	switch($type[$key]){
		case "text":
			$itemhtml = "<input type='text' name='$key' size='40' value=\"" . $vars[$key] . "\" />";
			break;
		case "textarea":
			$itemhtml = "<textarea name='$key' rows='5' cols='80'>" . $vars[$key] . "</textarea>";
			break;
		case "number":
			$itemhtml = "<input type='text' name='$key' size='40' value=\"" . $vars[$key] . "\" />";
			break;
		case "boolean":
			if ($vars[$key]) {
				# Default to true.
				$itemhtml = "<input type='radio' name='$key' value='true' checked /> Oui &nbsp; &nbsp; ";
				$itemhtml .= "<input type='radio' name='$key' value='false' /> Non";
			} else {
				# Default to false.
				$itemhtml = "<input type='radio' name='$key' value='true' /> Oui &nbsp; &nbsp; ";
				$itemhtml .= "<input type='radio' name='$key' value='false' checked /> Non";
			}
			break;
		case "select":
			$itemhtml = "<select name='$key'>" . $values[$key] . "</select>";
			break;
		case "skip":
			$itemhtml = "<input type='hidden' name='$key' size='40' value=\"" . $vars[$key] . "\" />";
		}
		$output .= "				  <p>" . $help[$key] . "<br />$itemhtml</p>\n";
	}
	echo $output;
?>
				  <hr />
				  <p style="color: red; font-weight: bold;">Lancer le paramétrage en appuyant sur le bouton ci-dessous remplacera, dans 'settings.php', tous les paramètres éventuellement entrés précédemment par ceux indiqués ci-dessus.</p>
				  <input name="submit" type="submit" value="Lancer le Paramétrage du Script" />
				  <input type="hidden" name="action" value="create" />
			</form>
<?php
	utility_footer();
} else {
	# Create the settings file.
	$fh = fopen("settings.php", "w+");
	fwrite($fh, "<" . "?" . "php\n");
	fwrite($fh, $settings_header);
	foreach($_POST as $key => $value) {
		if ($key != "submit" && $key != 'action') {
			fwrite($fh, "# " . $help2[$key] . "\n");
			switch ($type[$key]) {
				case "text":
					fwrite($fh, "$$key = \"$value\";\n");
					break;
				case "number":
					fwrite($fh, "$$key = $value;\n");
					break;
				case "textarea":
					fwrite($fh, "$$key = \"$value\";\n");
					break;
				case "boolean":
					fwrite($fh, "$$key = $value;\n");
					break;
				case "select":
					fwrite($fh, "$$key = \"$value\";\n");
					break;
				case "skip":
			}
			fwrite($fh, "\n");
		}
	}
	fwrite($fh, $settings_footer . "\n");
	fwrite($fh, "?" . ">");
	fclose($fh);
	utility_header();
?>
      <h2>Paramétrage effectué.</h2>

			<p style="color: red; font-weight: bold;">Supprimez le fichier 'config.php' en utilisant votre logiciel FTP.</p>
<?php
  utility_footer();
}

function utility_header() {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Configuration du script</title>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		<style type="text/css"><!--
body, p, td {
	font-size: 16px;
	font-family: Verdana;
}

body {
	background-color: #36648B;
}

#content {
	border: 2px groove silver;
	background-color: white;
	width: 690px;
	margin: 20px auto;
	padding: 30px;
}
		--></style>
	</head>
	<body>
    <div id="content">
      <img src="images/adminlogo.gif" />
<!-- Content     -->
<?php }

function utility_footer() {
?>
<!-- End content -->
		</div>
	</body>
</html>
<?php } ?>