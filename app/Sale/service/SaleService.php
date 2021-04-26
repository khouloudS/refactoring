<?php
class SaleService implements ISales
{
    $systemTemplate = new Template();
    $salesRecords= new SalesRecord;
    static  $sales = $salesRecords->getSales($sys_template_folder, "ipn.txt");
    public function splitSalesAndReplaceOccurrences($sale) {
          return explode("|", str_replace(array("\r", "\n"), "", $sale));
    }

      public function splitSales($sale) {
          return explode("|", $sale);
    }

    public function openFile($sys_template_folder, $permission) {
      return @fopen($sys_template_folder . $file, $permission);
    }

    public function getIPSalesRecord($oto = false) {
    global $sys_template_folder, $sys_oto_number;
    $ip = $salesRecords->getIp(); 
    # Reverse so we can get the last sale.
    $reverseSales = array_reverse($sales);
    $output = "";
    foreach ($reverseSales as $sale) {
      $sale = splitSalesAndReplaceOccurrences($sale);
      if ($sale[14] == $ip) {
        $valid = true;
        if ($oto && $sale[2] != $sys_oto_number) {
          $output = "";
          $valid = false;
        }
        if ($valid) {
          # Make sure sale is within valid timeframe.
          if (time() < $sale[9]) {
            $output = $sale;
            break;
          } else {
            # Download has expired.
            $output = "";
          }
        }
      }
    }
    return $output;
  }

  public function getOTOSalesRecord($affemail) {
    global $sys_template_folder, $sys_oto_number;
    $output = "";
    foreach($sales as $sale) {
      $sale = splitSalesAndReplaceOccurrences($sale);
      if ($sale[4] == $affemail) {
        $valid = true;
        if ($sale[2] != $sys_oto_number) {
          $output = "";
          $valid = false;
        }
        if ($valid) {
          $output = $sale;
          break;
        }
      }
    }
    return $output;
  }

  public function getPaymentEmail($itemnumber, $percent) {
    global $sys_template_folder, $sys_default_email, $sys_paypal_primary;

    if (!empty($_COOKIE['aff'])) {
      $afftotal = 0;
      $affsales = 0;
      foreach ($sales as $sale) {
        $sale = splitSalesAndReplaceOccurrences($sale);
        if($sale[2] == $itemnumber && strtolower($sale[13]) == strtolower(urldecode($_COOKIE["aff"]))){
          # Sale referred by affiliate.
          $afftotal++;
          if (strtolower($sale[3]) != $sys_default_email && strtolower($sale[3]) != $sys_paypal_primary) {
            # Affiliate got the payment.
            $affsales++;
          }
        }
      }
      if ($afftotal > 0) {
        $affper = ($affsales / $afftotal)*100;
      } else {
        $affper = 0;
      }
      if ($percent > 0 && $affper <= $percent) {
        # Give payment to affiliate.
        $email = urldecode($_COOKIE["aff"]);
      } else {
        # Give payment to publisher.
        $email = $sys_default_email;
      }
      return $email;
    } else {
      return $sys_default_email;
    }
  }

  public function verifyPaypalEmailAddress($get) {
    $sellit = false;
    foreach ($sales as $sale) {
      $sale = $salesRecord->splitSales($sale);
      if (strtolower($sale[4]) == strtolower($get) {
        # They're a customer.
        $sellit = true;
        break;
      }
    }
    return  $sellit;
  }

  public function getSalesLetters () {
    # Get salesletters array
    if (!is_array($_ENV['sys_salesletters'])) {
      return $salesletters = array("salesletter.html");
    } else {
      return $salesletters = $sys_salesletters;
    }
  }
  
  public function updateVisitorData() {
  		# Update visitor data for this sales letter.
      $salesletter = getSalesLetters ();
      if (file_exists($sys_template_folder . $salesletter . ".dat")) {
        $fh = openFile($sys_template_folder . $salesletter . ".dat", "r");
        $count = str_replace("\n", "", fgets($fh));
        fclose($fh);
      } else {
        $count = 0;
      }
      $count++;
  
      $done = false;
      $fh = openFile($sys_template_folder . $salesletter . ".dat", "w+");
      while (!$done) {
        $fl = @flock($fh, LOCK_EX);
        if ($fl) {
          @fwrite($fh, $count . "\n");
          $done = true;
          @flock($fh, LOCK_UN);
        }
      }
      @fclose($fh);
    }
  
  public function checkSoldeOut() {
    # See if we're sold out.
		$oc = 0;
		foreach ($sales as $order) {
			$order = explode("|", str_replace("\n", "", $order));
			if ($order[2]==$sys_item_number) {
				$oc++;
			}
		}
		if ($oc >= $sys_max_sales) {
			# Sold out
			showTemplate("soldout.html");
			exit;
		}
  }

  public function showSalesLetters() {
    if (isset($_GET["taf"])) {
      setcookie("ref", "TELL-A-FRIEND", time()+31536000, $sys_script_folder, "." . $sys_domain);
    } else {
      if (isset($_SERVER["HTTP_REFERER"])) {
        setcookie("ref", str_replace(array('http://','https://'),'',$_SERVER["HTTP_REFERER"]), time()+31536000, $sys_script_folder, "." . $sys_domain);
      }
    }
  
    # Get salesletters array
      $salesletters = getSalesLetters()
    
  
    if (isset($_COOKIE["sln"]) && ($_COOKIE["sln"] <= count($salesletters)-1)) {
      # This visitor has already been shown a particular sales letter.
      # Keep the same one in front of them and don't log another visit.
      $salesletter = $salesletters[$_COOKIE["sln"]];
    } else {
      # Randomly select sales letter to display.
      srand();
      $r = rand(0, count($salesletters)-1);
      $salesletter = $salesletters[$r];
  
      $systemTemplate->updateVisitorData();
      setcookie("sln", $r, time()+31536000, $sys_script_folder, "." . $sys_domain);
    }
  
    # Show sales letter.
    showTemplate($salesletter);
  }

  public function getConversionSalesLetters() {
     # Get conversion sales letter
     if (!is_array($sys_salesletters) || !isset($_COOKIE["sln"])) {
      return $salesletter = "salesletter.html";
    } else {
      return $salesletter = $sys_salesletters[$_COOKIE["sln"]];
    }
  }

  public function handleSaleOrder() {
    if (isset($sys_max_sales) && $sys_max_sales > 0) {
      checkSoldeOut();
    }
  
    if (!$sys_currency) {
      $sys_currency = "EUR";
    }
    
    if (!$sys_locale) {
      $sys_locale = "FR";
    }
  
    $salesletter = getConversionSalesLetters()
  
    # Send them through the order process
    if (isset($_GET['oto']) && isset($sys_oto) && $sys_oto) {
      # Buying OTO product
      if (!isset($_COOKIE['aff'])) {
        # No affiliate -- use default email address
        $email = $sys_default_email;
      } else {
        $checksale = true;
        if (isset($sys_oto_purchasers_only) && $sys_oto_purchasers_only) {
          $checksale = false;
          # Restrict OTO commissions to OTO purchasers only
          $sale = $salesRecord->getOTOSalesRecord(urldecode($_COOKIE["aff"]));
          if (is_array($sale)) {
            # They are an OTO customer
            $checksale = true;
          }
        }
        if ($checksale) {
          $email = $sales ->getPaymentEmail($sys_oto_number, $sys_oto_percent);
        } else {
          # Send payment to vendor
          $email = $sys_default_email;
        }
      }
      $item_name = $_ENV['sys_oto_name'];
      $item_number = $_ENV['sys_oto_number'];
      $item_cost = $_ENV['sys_oto_cost'];
      $item_download_url = "http://$sys_domain" . $_ENV['sys_script_folder'] . "?action=downloadoto";
      $item_cancel_url = "http://$sys_domain" . $_ENV['sys_script_folder'] . "?action=download";
      $item_ipn_url = "http://$sys_domain" . $_ENV['sys_script_folder'] . "ipn.php";
    } else {
      # Buying front-end product
      if (!isset($sys_item_percent)) {
        # 100% commission is the default
        $sys_item_percent = 100;
      }
      $email = $sales ->getPaymentEmail($sys_item_number, $sys_item_percent);
      $item_name = $_ENV['sys_item_name'];
      $item_number = $_ENV['sys_item_number'];
      $item_cost = $_ENV['sys_item_cost'];
      $item_download_url = "http://".$_ENV['sys_domain'] . $_ENV['sys_script_folder'] . "?action=squeeze";
      $item_cancel_url = isset($_ENV['sys_item_cancel_url']) && !empty($_ENV['sys_item_cancel_url']) ? $_ENV['sys_item_cancel_url'] : "http://".$_ENV['sys_domain'] " ." $_ENV['sys_script_folder'];
      $item_ipn_url = "http://"$_ENV['sys_domain']" . $_ENV['sys_script_folder'] " . "ipn.php";
    }
  
    # Get customer IP address
    $ip = $_SERVER["REMOTE_ADDR"];
  
    # Set affiliate email for display and credit
    $affemail = isset($_COOKIE['aff']) ? $_COOKIE['aff'] : "aucun";
    $aff = isset($_COOKIE['aff']) ? $_COOKIE['aff'] : "";
  
    # Set referrer
    $ref = isset($_COOKIE['ref']) ? substr($_COOKIE['ref'],0,250 - (strlen($salesletter) + strlen($aff) + strlen($ip))) : "";
  
    $systemTemplate->paymenForm($affemail, $email, $item_name, $item_number, $item_cost, $item_download_url, $item_cancel_url, $sys_currency, $sys_locale, $sys_charset, $item_ipn_url, $ref,$aff, $ip, $salesletter) ;
    
  }

}
?>