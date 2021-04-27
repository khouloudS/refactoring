<?php

$sys_version = "2.9";


$salesServices = new SaleService; 
$system = new System;





$action = isset($_REQUEST['action']) ? strtolower($_REQUEST['action']) : "";

# Set privacy policy for IE6/WinXP users
# If you don't do this, a lot of IE browsers won't accept cookies
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');

if (isset($_GET['e'])) {
	if (!empty($_GET['e']) && strpos($_GET['e'], '@')) {
		# Make sure this account hasn't been blocked.
		if (isset($sys_blocked) && !strpos(" $sys_blocked", $_GET['e'])) {
			# Set cookie and redirect visitor if it's through an affiliate link.
			if (isset($sys_purchasers_only) && $sys_purchasers_only) {
				if (isset($sys_purchasers_override) && strpos(strtolower(" $sys_purchasers_override"), strtolower($_GET['e']))) {
					# Affiliate is in override list. Let them sell.
					$sellit = true;
				} else {
					# Verify that this paypal email address is in our ipn.txt
					$sellit = $salesServices->verifyPaypalEmailAddress($_GET['e']))
				}
			} else {
				# Anybody can sell the product.
				$sellit = true;
			}

			if ($sellit) {
				setcookie("aff", $_GET['e'], time()+31536000, $sys_script_folder, "." . $sys_domain);
				if (isset($_GET['taf'])) {
					# This was a tell-a-friend referral.
					header("Location: index.php?taf=1");
				} else {
					header("Location: index.php");
				}
			} else {
				# Clear affiliate cookie
				# Show a message indicating that only people who bought can sell
				setcookies("aff", $sys_default_email, time()+31536000, $sys_script_folder, $sys_domain, "customersonly.html");
			}
			exit;
		} else {
			# Clear affiliate cookie.
			# Inform visitor that this affiliate's link has been disabled.
			setcookies("aff", $sys_default_email, time()+31536000, $sys_script_folder, "." . $sys_domain, "fraud.html");
			exit;
		}
	} else {
		# Clear affiliate cookie.
		setcookie("aff", "", time()-31536000, $sys_script_folder, "." . $sys_domain);
		header("Location: index.php");
	}
}

# If the affiliate was blocked after a cookie was set, clear the cookie.
if (isset($_COOKIE["aff"]) && isset($sys_blocked) && strpos(" $sys_blocked", $_COOKIE["aff"])) {
		setcookie("aff", "", time()-31536000, $sys_script_folder, "." . $sys_domain);
		header("Location: index.php");
}

if ((($action == "squeeze" && !isset($_GET['id'])) || $action == "downloadoto") && !isset($_COOKIE["giveaway"])) {
	# Check for customer IP address in IPN file.
	if ($action == "downloadoto") {
		$oto = true;
	} else {
		$oto = false;
	}
	$sale = sales->getIPSalesRecord($oto);
	if (is_array($sale)) {
    	# Purchase record found
		if ($action == "downloadoto") {
			$url = "index.php?action=download&id=$sale[0]";
		} else {
			$url = "index.php?action=squeeze&id=$sale[0]";
		}

		# Send to appropriate page
		header("Location: $url");
		exit;
	} elseif ($_GET["tries"] < 12) {
		# Give one minute for PayPal to post IPN record before giving up and showing an error
		$tries = isset($_GET["tries"]) ? $_GET['tries'] + 1 : 1;
		$seconds = 65 - ($tries * 5);
		$timeleft = str_replace("%n",$seconds,$lang['from_paypal_time']);
		SetTimeToPostIPN($action, $tries)
	} else {
		# IP not found in records. Show error message.
		if (substr($sys_support_address, 0, 7) == "http://") {
			$eaddress = $sys_support_address;
		} else {
			$eaddress = "mailto:$sys_support_address";
		}
		showTemplate("purchase_notfound.html");
	}
	exit;
}

# =============================================================================
# NO ACTION = SHOW SALES LETTER
# =============================================================================
if ($action == "") {
	# Save referrer
	$salesServices->showSalesLetters();
	exit;
}

# =============================================================================
# GIVEAWAY = HANDLE GIVE-AWAY PRODUCT
# =============================================================================
elseif ($action == "giveaway") {
	if ($sys_giveaway_product) {
		# Set giveaway cookie.
		setcookie("giveaway", true, time() + (3600 * $sys_expire_hours), $sys_script_folder, "." . $sys_domain);
		header("Location: index.php?action=squeeze&giveaway=1");
		exit;
	}
}

# =============================================================================
# ORDER = HANDLE ORDER VIA PAYPAL
# =============================================================================
elseif ($action == "order") {
	$salesServices->handleSaleOrder();
	exit;
}

# =============================================================================
# SQUEEZE/DOWNLOAD WITH ID = HANDLE SQUEEZE/DOWNLOAD PAGE
# =============================================================================
elseif (($action == "squeeze" || $action == "download") && isset($_GET['id'])) {
	# Check that: 1) ID is valid and 2) download has not timed out
	$transactionServices->downloadById();
	exit;
}

# =============================================================================
# DLID = SEND DOWNLOAD TO BROWSER
# =============================================================================
elseif ($action == "dlid") {
	$transactionServices->sendPrroductDownloadToBrowser()
	exit;
}

# =============================================================================
# TELLAFRIEND = SEND TELL A FRIEND EMAIL
# =============================================================================
elseif ($action == "tellafriend") {
	# Send tell-a-friend message to people.
	$sendername = $_POST["sendername"];
	$senderpaypal = $_POST["senderpaypal"];
	$emails = $_POST["senderemail"];
	tellFriendMessage($sendername, $senderpaypal, $email);
}

# =============================================================================
# REMOVE = REMOVE AFFILIATE FROM EMAIL LIST
# =============================================================================
elseif ($action == "remove") {
	# Remove affiliate from email list.
	if ($_REQUEST["email"]) {
		$systemTemplate->removeAffiliateFromEmail();
		exit;
	}
}

# =============================================================================
# ALL OTHER PURCHASE-REQUIRED ACTIONS
# =============================================================================
elseif ($action == "download" || $action == "oto" || $action == "squeeze") {
	$transactionServices->getTransaction();
	if ($transaction['status'] == "valid") {
		if ($action == "oto") {
			$filename = "oto.html";
		} elseif ($action == "squeeze") { # This is for a giveaway
			$filename = "squeeze.html";
		} elseif ($action == "download") { # This is the AR return/squeeze bypass
			if ($sys_oto && !isset($_GET["dl"])) {
				$filename = "oto.html";
			} else { # This is the OTO bypass
				$filename = "download.html";
			}
		}
	} elseif ($transaction['status'] == "expired") {
		$filename = "downloadexpired.html";
	} else {
		$filename = "invalid.html";
	}
	showTemplate($filename);
	exit;
}

# =============================================================================
# ADMIN BACK-END FUNCTIONS
# =============================================================================
if (substr($action, 0, 5) == "admin" && $action != "admin" && $action != "adminlogin" && !$_COOKIE["7ds_admin"]) {
	# Not logged in.  Redirect to login.
	header("Location: index.php?action=admin");
	exit;
}

if ($action == "admin") {
	# Get username/password for admin area.
	adminArea()
	exit;
} elseif ($action == "adminlogin") {
	# Verify admin username/password.
		$admin->checkIsAdmin($_POST["username"], $_POST["password"])
}

if ($_COOKIE["7ds_admin"]) {
	$uniq = file_get_contents($sys_template_folder . "uniq.txt");
	if ($_COOKIE["7ds_uniq"] != $uniq) {
		# Somebody's trying to hack.
		setcookie("7ds_admin", "", time() - 3600);
		header("Location: index.php?action=admin");
		exit;
	}
	$adminheader = adminHeader();
	$adminfooter = adminFooter();
	# Admin functions.
	if ($action == "adminmenu") {
	  $current_version = isset($_GET['cv']) ? $_GET['cv'] : '0';
	  $admin->adminAction()
		exit;
	} elseif ($action == "adminbuys" || $action == "adminmine") {
		# Show all customers.
		$admin->showCustomer();
		exit;
	} elseif ($action == "adminexport") {
		$admin->exportToCSV();
		
		exit;
	} elseif ($action == "adminrefs" || $action == "adminrefsmine") {
		# Show referrer report.
		$admin->refferReport($isdomain=false);
		exit;
	} elseif ($action == "adminrefdomains" || $action == "adminrefdomainsmine") {
		# Show referrer report.
		$admin->refferReport($isdomain=true)
		exit;
	} elseif ($action == "adminaffiliates") {
		$admin->totalSales();
		exit;
	} elseif ($action == "adminextend") {
		# Extend duration of purchase download link
		$admin->extendDuration();
		exit;
	} elseif ($action == "adminemailaffiliates") {
		# Show affiliate mailer form.
		affiliateMailerForm();	
		exit;
	} elseif ($action == "adminlogout") {
		# Logout.
		$user->logout();
		exit;
	}
}

header('Location: index.php');
?>