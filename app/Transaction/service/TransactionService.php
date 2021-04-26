<?php
class TransactionService implements ITransaction
{
  $systemTemplate = new Template();
  $transactions = new Transaction("", "invalid", 0);
  $salesRecords= new SalesRecord;
  static  $fh = fopen($sys_template_folder . $filename, "r");
  
  public function getTransaction ($id = "") {
    $transaction = $transactions->getObjectVars();  
    checkForSale($id);
    $oto = checkForIpRelated($id);
    $fh = $salesRecords->openFile($_ENV['sys_template_folder'], "ipn.txt", "r")
    while ($rec = @fgets($fh)) {
      $rec = str_replace("\n", "", $rec);
      if (trim($rec)) {
        $record = explode("|", $rec);
        if ($id != "") {
          if ($record[0] == $id) { # found a sales record	
            $transaction['id'] = $record[0];
            $transaction['oto'] = $record[2] == $_ENV['sys_oto_number'] ? 1 : 0;
            if (time() <= $record[9]) { # it's valid
              $transaction['status'] = "valid";
            } else {
              $transaction['status'] = "expired";
            }
            break; # no need to continue looking
          }
        } else {
          if ($record[14] == $ip) {
            if (time() <= $record[9]) { # found a valid sales record
              if (($oto && $record[2] == $_ENV['sys_oto_number']) || (!$oto && $record[2] == $_ENV['sys_item_number'])) {
                $transaction['id'] = $record[0];
                $transaction['status'] = "valid";
                $transaction['oto'] = $record[2] == $_ENV['sys_oto_number'] ? 1 : 0;
                # break; # don't break, we want to find the last valid one
              }
            } else { # no need to set anything but the expired status
              $transaction['status'] = "expired";
            }
          } # if no IP-related sale is found, status will be invalid
        }
      }
    }
    if ($transaction['status'] == "valid" && !isset($filename)) {
      setcookie("7ds_id", $transaction['id'], 0, $_ENV['sys_script_folder'], "." . $_ENV['sys_domain']);
    }
    return $transaction;
  }

  public function checkForSale($id) {
    # if ID is set, use that to check for sale
    # if ID is not set, use cookie to check for sale
    # if there is no cookie, check for IP-related sale
    if ($id == "") {
      $id = (isset($_COOKIE['7ds_id']) && !empty($_COOKIE['7ds_id'])) ? $_COOKIE['7ds_id'] : "";
      $ip = $_SERVER["REMOTE_ADDR"];
    }
    
    if ($id == "" && isset($_COOKIE['giveaway']) && $_ENV['sys_giveaway_product']) {
      $transaction['status'] = "valid";
    }
  }
  
  public function checkForIpRelated($id) {
    if ($id == "" && $action == "downloadoto") {
      return 1;
    } else {
      return 0;
    }
  }

  public function sys_download_url($oto) {
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    $transaction = getTransaction($id);
    return "index.php?action=dlid&oto=$oto&id=".$transaction['id'];
  }
  

  public function downloadById() {
  $transaction= getTransaction($_GET['id']);
	if ($transaction['status'] == "valid") {
		if ($transaction['oto']) {
			$filename = "downloadoto.html";
		} else {
			if ($action == "squeeze") {
				$filename = "squeeze.html";
			} else {
				$filename = "download.html";
			}
		}
	} elseif ($transaction['status'] == "expired") {
		$filename = "downloadexpired.html";
	} else {
		$filename = "invalid.html";
	}
	showTemplate($filename);
  }
  
  public function sendPrroductDownloadToBrowser() {
    # Send product download to browser
      $transaction = getTransaction($_GET['id']);
      if ($transaction['status'] == "valid") {
        header("Content-Type: application/octet-stream");
        header("Content-Transfer-Encoding: binary");
        header("Content-Description: File Transfer");
        if ($_GET["oto"] && $transaction['oto']) {
          $fparts = explode("/", $sys_oto_location);
          $filename = $fparts[count($fparts)-1];
          header("Content-Disposition: attachment; filename=$filename");
          @readfile($sys_oto_location);
        } else {
          $fparts = explode("/", $sys_item_location);
          $filename = $fparts[count($fparts)-1];
          header("Content-Disposition: attachment; filename=$filename");
          @readfile($sys_item_location);
        }
        exit;
      } elseif ($transaction['status'] == "expired") {
        $filename = "downloadexpired.html";
      } else {
        $filename = "invalid.html";
      }
      showTemplate($filename);
  }
}
?>