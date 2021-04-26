<?php
#
# Consultez le guide d'utilisation pour la 
# description complète des paramètres.

# Tableau d'administration : Identifiant de l'administrateur.
# Ne doit comporter ni espace, ni caractère accentué.
$sys_admin_username = "identifiant";

# Tableau d'administration : Mot de passe de l'administrateur.
# Ne doit comporter ni espace, ni caractère accentué.
$sys_admin_password = "motdepasse";

# Nom de domaine du site où est installé le script. SANS 'www.' et SANS 'http://' 
# Toutes les lettres doivent être des MINUSCULES. Il ne doit y avoir aucun '/'
$sys_domain = "nomdedomaine.com";

# Adresse email PRINCIPALE de votre compte PayPal. Votre compte doit être 
# de type Premier ou Business.
# Un compte de type Personnel ne peut pas être utilisé.
$sys_default_email = "mon@adresse-email-paypal.com";

# Adresse email ou de la page web de votre service client.
# Doit inclure 'http://' si c'est une page web ; ainsi :
# http://monsite.com/service-client/
$sys_support_address = "mon@adresse-service-client.com";

# Adresse email à laquelle est envoyée la notification de fraude si une 
# tentative est détectée
$sys_fraud_address = "mon@adresse-fraude.com";

# Nom du répertoire où vous installez le script. Changez la valeur ci-dessous 
# seulement si vous l'installez dans un répertoire. Si c'est le cas, vous DEVEZ 
# mentionner le '/' initial ET le '/' final. Exemple : Si vous installez à 
# monsite.com/produit1/ vous devez indiquer /produit1/ ci-dessous. Ne doit 
# comporter ni espace, ni caractère accentué.
# Ne changez PAS la valeur ci-dessous (laissez /) si vous installez le script 
# à la racine de votre site.
$sys_script_folder = "/";

# Nom du répertoire où sont placées les templates HTML et TXT. 
# Ne doit comporter ni espace, ni caractère accentué. 
# Utilisez un NOM DIFFICILE A DEVINER, par exemple 'tpl54526DF747'. 
# Vous DEVEZ PLACER UN '/' APRES CE NOM, mais PAS avant, comme dans 
# le modèle ci-dessous. Pensez à changer ce nom sur votre hébergement 
# web avec votre logiciel FTP si ce n'est pas déjà fait. 
# Donnez à ce répertoire les permissions d'accès 755 (CHMOD 755) avec 
# votre logiciel FTP.
$sys_template_folder = "templates997711/";

# Nom du Produit Principal.
# Pour éviter les problèmes d'affichage sur le site PayPal, remplacez les caractères
# accentués par leur équivalent non accentué (exemple : é devient e).
$sys_item_name = "Nom du Produit Principal";

# Référence/Identifiant du Produit Principal (Identifiant Objet PayPal ; 
# vous le choisissez comme vous voulez).
$sys_item_number = "PROD-001";

# Prix du Produit Principal. Utilisez le POINT si ce nombre est décimal, 
# PAS la virgule, comme dans le modèle ci-dessous.
$sys_item_cost = 7.50;

# Localisation du Produit Principal sous cette forme : repertoire/fichier.zip
# N'utilisez ni espace, ni caractère accentué.
# Utilisez un nom DIFFICILE A DEVINER pour le répertoire où est placé le produit. 
# Exemple : dl4789Uyt78
# C'est le répertoire d'installation du script qui sert de référence. Voir le 
# guide d'utilisation pour des exemples.
$sys_item_location = "repertoire/produit.zip";

# Commission d'affiliation pour le Produit Principal, en POURCENTS, SANS le signe '%'.
$sys_item_percent = 100;

# Adresses email PayPal auxquelles vous interdisez de participer au programme d''affiliation 
# séparées par une virgule (ainsi : a1@email1.com,b2@email2.com,c3@email3.fr).
# Laissez blanc si vous ne voulez bloquer aucune adresse.
$sys_blocked = "";

# Si vous proposez une Offre Spéciale Unique (OTO), indiquez 'true' ci-dessous.
# Sinon, indiquez 'false'. (Sans les ' ')
$sys_oto = true;

# Nom du produit de l'OTO.
# Pour éviter les problèmes d'affichage sur le site PayPal, remplacez les caractères
# accentués par leur équivalent non accentué (exemple : é devient e).
$sys_oto_name = "Mon Offre Speciale Unique";

# Référence/Identifiant du Produit de l'OTO (Identifiant Objet PayPal ; 
# vous le choisissez comme vous voulez).
$sys_oto_number = "PROD-002";

# Prix de l'OTO. Si ce nombre est décimal, vous devez utiliser le point, 
# PAS la virgule, comme dans l'exemple ci-dessous.
$sys_oto_cost = 27.50;

# Localisation du Produit de l'OTO sous cette forme : repertoire/fichier.zip. 
# C'est le répertoire d'installation du script qui sert de référence (voir le guide d'utilisation 
# pour des exemples). N'utilisez ni espace, ni caractère accentué. Utilisez un nom 
# DIFFICILE A DEVINER pour le répertoire où est placé le produit. Exemple : dl4789Uyt78";
$sys_oto_location = "repertoire/oto.zip";

# Commission d'affiliation pour l'OTO, en POURCENTS, sans le signe '%'.
$sys_oto_percent = 50;

# Nombre d'heures après lequel le lien de téléchargement devient inactif.
$sys_expire_hours = 72;

# Si vous DONNEZ le Produit Principal au lieu de le vendre, indiquez 'true', sinon, laissez 'false'. 
# (Note : Si vous le donnez, il est vivement recommandé d'attribuer une commission pour l'OTO, sinon vos 
# affiliés ne seront pas motivés à faire la promotion de votre offre.) 
# ATTENTION : Dans le template 'salesletter.html', le lien 'Commander' doit dans ce cas être remplacé 
# par un lien spécial - voir le guide d'utilisation.
$sys_giveaway_product = false;

# Split-testing (optionnel) de la page de vente du Produit Principal. 
# Ne modifiez PAS la ligne ci-dessous.
$sys_salesletters = array();

# Pour faire un split-test entre 2 pages de vente, ajoutez la ligne suivante 
# sous la ligne $sys_salesletters[] = "salesletter.html"; :
# $sys_salesletters[] = "salesletter2.html";
# Si vous voulez tester 3 pages de vente, ajoutez en supplément la ligne :
# $sys_salesletters[] = "salesletter3.html";
# N'oubliez pas de créer les templates "salesletter2.html" et "salesletter3.html"
# et de les transférer dans le répertoire "templates".
# Voir le guide d'utilisation.
$sys_salesletters[] = "salesletter.html";

# Si vous voulez restreindre la vente du Produit Principal à un certain nombre d'exemplaires, 
# indiquez ce nombre ci-dessous. 
# Laissez '0' (zéro) pour ne pas limiter cette vente.
$sys_max_sales = 0;

# Paramètres de localisation géographique.

# Monnaie du paiement.
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
# USA : Dollar Américain					USD
$sys_currency = "EUR";

# Langue de la page de paiement PayPal.
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
# Japonais				 			JP
$sys_locale = "FR";

# Jeu de caractères pour la transaction PayPal.
$sys_charset = "ISO-8859-1";


# Messages vus par les clients.
$lang = array();
$lang['from_paypal_title'] = "Attente de connexion au site PayPal.";
$lang['from_paypal_explain'] = "Attente de la confirmation du paiement par PayPal. Veuillez patienter...";
$lang['from_paypal_time'] = "%n secondes restantes..."; # %n indique le nombre de secondes
$lang['from_paypal_explain2'] = "(Cette page va se recharger toutes les 5 secondes jusqu'&agrave; ce que PayPal confirme votre paiement.)";
$lang['return_button'] = "IMPORTANT : Cliquer ici pour t&eacute;l&eacute;charger votre achat";
$lang['goto_paypal_title'] = "Veuillez patienter...";
$lang['goto_paypal_explain'] = "Vous allez &ecirc;tre dirig&eacute; sur le site de paiement s&eacute;curis&eacute; PayPal dans 5 secondes.";
$lang['goto_paypal_explain2'] = "N'oubliez pas de cliquer sur <b>\"IMPORTANT : Cliquez ici pour t&eacute;l&eacute;charger votre achat\"</b> apr&egrave;s validation du paiement. Autrement, vous ne recevrez pas votre produit.";
$lang['goto_paypal_affiliate'] = "affili&eacute;";
$lang['error_title'] = "Erreur";
$lang['taf_title'] = "Message Envoy&eacute;";
$lang['taf_thankyou'] = "Merci ! Le message a &eacute;t&eacute; envoy&eacute;.";
$lang['taf_mail_error'] = "Le message peut &ecirc;tre envoy&eacute; seulement &agrave; partir de $sys_domain.";
$lang['taf_required'] = "Les champs Votre Pr&eacute;nom et Votre Adresse Email PayPal ne doivent pas &ecirc;tre vides.";
$lang['unsub_title'] = "D&eacute;sinscrition Prise En Compte.";
$lang['unsub_explain'] = "Vous ne recevrez plus de message concernant $sys_item_name.";
?>