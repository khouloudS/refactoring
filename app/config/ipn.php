<?php

include("settings.php");

$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

$header .= "POST /cgi-bin/webscr HTTP/1.1\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Host: www.paypal.com\r\n";
$header .= "Connection: close\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

if (isset($_POST['item_name'])) {
$item_name = stripslashes($_POST['item_name']);
$item_number = stripslashes($_POST['item_number']);
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$payer_firstname = str_replace('|', '', $_POST['first_name']);
$payer_lastname = str_replace('|', '', $_POST['last_name']);
$payer_business = str_replace('|', '', $_POST['payer_business_name']);
$payer_country = $_POST['residence_country'];
$custom = $_POST['custom'];

# List of free email provider extensions to ignore when looking for duplicate email domains.
$emailprovs = array("@yahoo.com", "@yahoo.co.uk", "@yahoo.fr", "@yahoo.ca", "@aol.com", "@aol.fr", "@googlemail.com", "@gmail.com", "@hotmail.com", "@hotmail.fr", "@comcast.net", "@netscape.com", "@netscape.net", "@juno.com", "@verizon.net", "@laposte.net", "@orange.fr", "@msn.com", "@live.com", "@live.fr", "@live.ca", "@9online.fr", "@voila.fr", "@free.fr", "@aliceadsl.fr", "@neuf.fr", "@club.fr", "@club-internet.fr", "@noos.fr", "@wanadoo.fr", "@numericable.fr", "@sfr.fr", "@libertysurf.fr", "@videotron.ca", "@sympatico.ca", "@skynet.be", "@swing.be", "@orange.ch", "@bluewin.ch", "@sunrise.ch", "@green.ch", "@bellnet.ca", "@bell.net", "@cgocable.ca");
if (!$fp) {
	# HTTP error.
} else {
	fputs ($fp, $header . $req);
	while (!feof($fp)) {
		$res = fgets ($fp, 1024);
		if (strcmp (trim($res), "VERIFIED") == 0) {
			if ($payment_status == "Completed") {
				$expires = time() + (3600 * $sys_expire_hours);
				$time = time();

				# Compare hostnames of payer and receiver addresses.
				$e1 = substr($receiver_email, strpos($receiver_email, "@"));
				$e2 = substr($payer_email, strpos($payer_email, "@"));
				if ($e1 == $e2 && !in_array($e1, $emailprovs)) {
					# The payer may be trying to purchase from themselves.

					mailer("email_self-purchase.txt", $payer_email);
					mailer("email_self-purchase_notify.txt", $sys_fraud_address);

					# Write data to fraud file for review in admin panel.
					$done = false;
					while (!$done) {
						$fh = @fopen($sys_template_folder . "fraud.txt", "a");
						$fl = @flock($fh, LOCK_EX);
 						if ($fl) {
							@fwrite($fh, "$txn_id|$item_name|$item_number|$receiver_email|$payer_email|$payer_firstname|$payer_lastname|$payer_business|$payment_amount|$expires|0|$time|$custom\n");
							$done = true;
							@flock($fh, LOCK_UN);
						}
						@fclose($fh);
					}
				} elseif (($item_number == $sys_item_number && $payment_amount >= $sys_item_cost) || ($item_number == $sys_oto_number && $payment_amount >= $sys_oto_cost)) {
          $sales = @file($sys_template_folder . "ipn.txt");
          foreach ($sales as $sale) {
            $sale = explode("|", str_replace(array("\r", "\n"), "", $sale));
            if ($sale[0] == $txn_id) exit;
          }

					# Write info to IPN file.
					$done = false;
					while (!$done) {
						$fh = @fopen($sys_template_folder . "ipn.txt", "a");
						$fl = @flock($fh, LOCK_EX);
						if ($fl) {
							@fwrite($fh, "$txn_id|$item_name|$item_number|$receiver_email|$payer_email|$payer_firstname|$payer_lastname|$payer_business|$payment_amount|$expires|0|$time|$custom\n");
							$done = true;
							@flock($fh, LOCK_UN);
						}
						@fclose($fh);
					}

          $sys_ipn_email = isset($sys_ipn_email) ? $sys_ipn_email : true;
          if ($sys_ipn_email) {
					  mailer("email_download_link.txt", $payer_email);
          }
				} else {
					# A dishonest person tried to cheat and buy the product for less than its cost.

					mailer("email_wrong_price.txt", $payer_email);
					mailer("email_wrong_price_notify.txt", $sys_fraud_address);

					# Write fraud info to fraud.txt
					$done = false;
					while (!$done) {
						$fh = @fopen($sys_template_folder . "fraud.txt", "a");
						$fl = @flock($fh, LOCK_EX);
						if ($fl) {
							@fwrite($fh, "$txn_id|$item_name|$item_number|$receiver_email|$payer_email|$payer_firstname|$payer_lastname|$payer_business|$payment_amount|$expires|0|$time|$custom\n");
							$done = true;
							@flock($fh, LOCK_UN);
						}
						@fclose($fh);
					}
				}
			}
		} elseif (strcmp ($res, "INVALID") == 0) {
			# Log for manual investigation.
		}
	}
	fclose ($fp);
}}

function mailer($filename,$to) {
	global $item_name, $item_number, $payment_amount, $txn_id, $receiver_email, $payer_email, $payer_firstname, $payer_lastname, $payer_business, $sys_version, $sys_domain, $sys_script_folder, $sys_template_folder, $sys_support_address, $sys_item_name, $sys_expire_hours;
	
	if (substr($sys_support_address, 0, 7) == "http://") {
		$eaddress = "noreply@$sys_domain";
	} else {
		$eaddress = $sys_support_address;
	}

	$headers = "From: \"$sys_item_name\"<$eaddress>\r\n";
	$headers .= "X-Sender: \"$sys_item_name\"<$eaddress>\r\n";
	$headers .= "X-Mailer: 7DSS v$sys_version\r\n";
	$headers .= "X-Priority: 3\r\n";
	$headers .= "Return-Path: \"$sys_item_name\"<$eaddress>\r\n";
	$headers .= "Reply-To: \"$sys_item_name\"<$eaddress>";

	$body = file($sys_template_folder . $filename);
	$subject = trim(array_shift($body));
	$body = implode($body);

	$body = str_replace("[business]",$payer_business,$body);
	$body = str_replace("[buyer email]",$payer_email,$body);
	$body = str_replace("[download link]","http://$sys_domain" . $sys_script_folder . "?action=download&id=$txn_id",$body);
	$body = str_replace("[expire hours]",$sys_expire_hours,$body);
	$subject = str_replace("[first name]",$payer_firstname,$subject);
	$body = str_replace("[first name]",$payer_firstname,$body);
  $subject = str_replace("[item name]",$item_name,$subject);
  $body = str_replace("[item name]",$item_name,$body);
	$subject = str_replace("[item number]",$item_number,$subject);
	$body = str_replace("[item number]",$item_number,$body);
	$body = str_replace("[last name]",$payer_lastname,$body);
	$body = str_replace("[payment]",$payment_amount,$body);
	$body = str_replace("[receiver email]",$receiver_email,$body);
	$subject = str_replace("[site]",$sys_domain,$subject);
	$body = str_replace("[site]",$sys_domain,$body);
	$body = str_replace("[site link]","http://$sys_domain" . $sys_script_folder, $body);
	$body = str_replace("[support address]",$sys_support_address,$body);

	@mail($to, $subject, $body, $headers);
}
?>
