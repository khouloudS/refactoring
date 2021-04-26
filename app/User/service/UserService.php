<?php
class SaleService implements IAdmin
{
    
    $admin= new Admin;
    $salesRecords= new SalesRecord;
    
    public function checkIsAdmin($username, $password) {
        
        if ($username== $sys_admin_username && $password == $sys_admin_password) {
            # Valid.  Cookie and redirect.
            setcookie("7ds_admin", true, 0, $sys_script_folder, "." . $sys_domain);
            setcookie("7ds_uniq", $uniq, 0, $sys_script_folder, "." . $sys_domain);
            checkFile();
            header("Location: index.php?action=adminmenu&cv=$result");
            exit;
        } else {
            $systemTemplate->authError();
            exit;
        }
    }

    public function adminAction() {
        $messages = '';
		if (file_exists('config.php')) {
		  $messages .= "<span class=\"warning\">Attention : Vous devez supprimer 'config.php' avec votre logiciel FTP.</span><br />";
		}
		if (version_compare($current_version,$sys_version,'>')) {
		  $messages .= "<span class=\"notice\">La version " . $current_version ." est disponible.</span><br />";
		}
		# Get tell-a-friend count.
		$taf = @file_get_contents($sys_template_folder . "tellafriend.txt");
		if (!$taf) {
			$messages .= "Le message envoy&eacute; via la fonction &quot;Envoyer &agrave; un Ami&quot; n'a &eacute;t&eacute; exp&eacute;di&eacute; &agrave; personne pour l'instant.<br />";
	  }
	  elseif ($taf == 1) {
	    $messages .= "Le message envoy&eacute; via la fonction &quot;Envoyer &agrave; un Ami&quot; a &eacute;t&eacute; exp&eacute;di&eacute; &agrave; une personne.<br />";
	  }
	  else {
	    $messages .= "Le message envoy&eacute; via la fonction &quot;Envoyer &agrave; un Ami&quot; a &eacute;t&eacute; exp&eacute;di&eacute; &agrave; $taf personnes.<br />";
		}

		adminTable($messages)
    }

    public function showCustomer(){
       
		$count = isset($_REQUEST["count"]) ? $_REQUEST["count"] : 0;
		if ($records) {
			$rcount = count($records);
		} else {
			$rcount = 0;
			$records = array();
		}
		if ($count) {
			$showing = "les $count derni&egrave;res";
		} else {
			$showing = "toutes ($rcount)";
		}
		if ($action == "adminmine") {
			$showing = "celles qui vous sont attribu&eacute;es";
		}
		
		returnToMenu();
		$bgcolor = "#ffffff";
		foreach ($records as $rec) {
			$rcount--;
			if (!$count || $rcount < $count) {
				$rec = str_replace("\n", "", $rec);
				if (trim($rec)) {
					$record = explode("|", $rec);
					$date = "";
					if ($record[11]) {
						$date = date("Y-m-d H:i:s", $record[11]);
					}
					$expires = date("Y-m-d H:i:s", $record[9]);
					if ($record[3] == $sys_default_email || $record[3] == $sys_paypal_primary) {
						# Our sale. Yay! :)
						$bgcolor = "#ffffcc";
					}
					$show = true;
					if ($action == "adminmine") {
						if ($record[3] != $sys_default_email && $record[3] != $sys_paypal_primary) {
							$show = false;
						}
					}
					if ($show) {
						echo "
				<tr>
					<td bgcolor=$bgcolor><a href='index.php?action=download&amp;id=$record[0]' target=_blank>$record[0]</a></td>
					<td bgcolor=$bgcolor>$record[2]</td>
					<td bgcolor=$bgcolor>$record[3]</td>
					<td bgcolor=$bgcolor>$record[4]</td>
					<td bgcolor=$bgcolor>". stripslashes($record[5]) ."</td>
					<td bgcolor=$bgcolor>". stripslashes($record[6]) ."</td>
					<td bgcolor=$bgcolor>$record[8]</td>
					<td bgcolor=$bgcolor>$date</td>
					<td bgcolor=$bgcolor><a href='index.php?action=adminextend&amp;id=$record[0]'>$expires</a></td>
				</tr>
			";
					}
					$bgcolor = ($bgcolor=="#ffffff") ? "#eeeeee" : "#ffffff";
				}
			}
		}
		echo "</table>$adminfooter";
    }

    public function exportToCSV() {
        # Export purchase records to CSV.
		$first = true;
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=export.csv");
		header("Content-Transfer-Encoding: binary");
		$records = @file($sys_template_folder . "ipn.txt");
		if ($records) {
			foreach ($records as $rec) {
			$rec = str_replace("\n", "", $rec);
				if (trim($rec)) {
					if ($first) {
						# Output headers.
						echo '"Id. Transaction PayPal","Nom Produit","Identifiant Produit","Email Receveur","Email Client","Prénom Client","Nom Client","Entreprise Cliente","Montant","Date Achat","Date Expiraton","Référent","Affilié","IP","","","","Lettre de Vente"' . "\r\n";
						$first = false;
					}
					$record = explode("|", $rec);
					$date = "";
					if ($record[11]) {
						$date = date("Y-m-d H:i:s", $record[11]);
					}
					$expires = date("Y-m-d H:i:s", $record[9]);
					echo "\"$record[0]\",\"$record[1]\",\"$record[2]\",\"$record[3]\",\"$record[4]\",\"". stripslashes($record[5]) ."\",\"". stripslashes($record[6]) ."\",\"". stripslashes($record[7]) ."\",\"$record[8]\",\"$date\",\"$expires\",\"$record[12]\",\"$record[13]\",\"$record[14]\",\"$record[15]\",\"$record[16]\",\"$record[17]\",\"$record[18]\"\r\n";
				}
			}
        }
    }

    public function refferReport($isdomain){
        $records = $salesRecords->getSales($sys_template_folder, "ipn.txt");
        $count = isset($_REQUEST['count']) ? $_REQUEST['count'] : 0;
        if ($records) {
            $rcount = count($records);
        } else {
            $rcount = 0;
            $records = array();
        }
        if ($count) {
            $showing = "les $count derni&egrave;res";
        } else {
            $showing = "toutes ($rcount)";
        }
        if ($action == "adminrefdomainsmine") {
            $showing = "celles qui vous sont attribu&eacute;es";
        }
        else {
          $showing = "toutes";
        }
        totalNumberSales($rcount, $showing)
        if(!$isdomain) {
            showReport($records, $rcount);
        }else if ($isdomain) {
            showReportDomain($records, $rcount);
        }
    }

    public function showReport($records, $rcount) {
        
		$bgcolor = "#ffffff";
		$c = $rcount;
		$refs = array();
		foreach ($records as $rec) {
			$c--;
			if (!$count || $c < $count) {
				$rec = str_replace("\n", "", $rec);
				if (trim($rec)) {
					$record = explode("|", $rec);
					$show = true;
					if ($action == "adminrefsmine") {
						if ($record[3] != $sys_default_email && $record[3] != $sys_paypal_primary) {
							$show = false;
						}
					}
					if ($show) {
						$record[12] = str_replace('http://','',$record[12]);
						if (strlen($record[12]) > 100) {
							$ref = substr($record[12], 0, 98) . "..";
						} else {
							$ref = $record[12];
						}
						if (isset($refs[$record[12]])) {
							$refs[$record[12]]++;
						} else {
							$refs[$record[12]]=1;
						}
					}
				}
			}
		}
		arsort($refs);
		foreach ($refs as $ref => $sales) {
		  if(!empty($ref)) {
			  $parts = parse_url('http://'. $ref);
			}
			$host = isset($parts['host']) ? str_replace("www.", "", $parts['host']) : "";
			$keywords = searchKeywords($ref);
			if (strlen($ref) > 100) {
				$sref = substr($ref, 0, 97) . "...";
			} else {
				$sref = $ref;
			}
			echo "<tr>
			  <td bgcolor=$bgcolor><a href='http://$ref' target=_blank>$sref</a></td>
			  <td bgcolor=$bgcolor><a href='http://$host' target=_blank>$host</a></td>
			  <td bgcolor=$bgcolor>$keywords</td>
			  <td bgcolor=$bgcolor align=right>$sales</td>
			</tr>
			";
			$bgcolor = ($bgcolor=="#ffffff") ? "#eeeeee" : "#ffffff";
		}
		echo "</table>$adminfooter";
    }

    public function showReportDomain($records, $rcount){
        $records = @file($sys_template_folder . "ipn.txt");
		$count = isset($_REQUEST['count']) ? $_REQUEST['count'] : 0;
		if ($records) {
			$rcount = count($records);
		} else {
			$rcount = 0;
			$records = array();
		}
		if ($count) {
			$showing = "les $count derni&egrave;res";
		} else {
			$showing = "toutes ($rcount)";
		}
		if ($action == "adminrefdomainsmine") {
			$showing = "celles qui vous sont attribu&eacute;es";
		}
		else {
		  $showing = "toutes";
		}
		totalNumberSales($rcount, $showing)
		$bgcolor = "#ffffff";
		$c = $rcount;
		$refs = array();
		foreach ($records as $rec) {
			$c--;
			if (!$count || $c < $count) {
				$rec = str_replace("\n", "", $rec);
				if (trim($rec)) {
					$record = explode("|", $rec);
					$show = true;
					if ($action == "adminrefdomainsmine") {
						if($record[3] != $sys_default_email && $record[3] != $sys_paypal_primary) {
							$show = false;
						}
					}
					if ($show) {
					  // Protocol was saved with referrer pre-2.9.
						$record[12] = str_replace('http://','',$record[12]);
						if (!empty($record[12])) {
						  $parts = parse_url('http://'. $record[12]);
						}
						$host = isset($parts['host']) ? str_replace("www.", "", $parts['host']) : "";
						if (isset($refs[$host])) {
							$refs[$host]++;
						} else {
							$refs[$host]=1;
						}
					}
				}
			}
		}
		arsort($refs);
		foreach ($refs as $ref => $sales){
			echo "
			<tr>
				<td bgcolor=$bgcolor><a href='http://$ref' target=_blank>$ref</a></td>
				<td bgcolor=$bgcolor align=right>$sales</td>
			</tr>
			";
			$bgcolor = ($bgcolor=="#ffffff") ? "#eeeeee" : "#ffffff";
		}
		echo "</table>$adminfooter";
    }

   public function totalSales(){
        $records = @file($sys_template_folder . "ipn.txt");
		$count = isset($_REQUEST['count']) ? $_REQUEST['count'] : 0;
		if ($records) {
			$rcount = count($records);
		} else {
			$rcount = 0;
			$records = array();
		}
		if ($count) {
			$showing = "the last $count";
		} else {
			$showing = "all $rcount";
		}
		totalSales($records)
		$bgcolor = "#ffffff";
		$c = $rcount;
		$refs = array();
		foreach ($records as $rec) {
			$c--;
			if (!$count || $c < $count) {
				$rec = str_replace("\n", "", $rec);
				if (trim($rec)) {
					$record = explode("|", $rec);
					if (isset($refs[$record[3]])) {
						$refs[$record[3]]++;
					} else {
						$refs[$record[3]]=1;
					}
				}
			}
		}
		arsort($refs);
		foreach ($refs as $ref => $sales) {
			if ($ref == $sys_default_email || $ref == $sys_paypal_primary) {
				$bgcolor = "#ffffcc";
			}
			echo "
				<tr>
					<td bgcolor=$bgcolor><a href='mailto:$ref'>$ref</a></td>
					<td bgcolor=$bgcolor>$sales</td>
				</tr>
			";
			$bgcolor = ($bgcolor=="#ffffff") ? "#eeeeee" : "#ffffff";
		}
		echo "</table>$adminfooter";
    }

    public function extendDuration() {
        $id = $_REQUEST["id"];
		$records = @file($sys_template_folder . "ipn.txt");
		$recs = array();
		if ($records) {
			foreach ($records as $rec) {
				$rec = str_replace("\n", "", $rec);
				if (trim($rec)) {
					$record = explode("|", $rec);
					if ($record[0] == $id) {
						# Extend this record.
						$changes = true;
						$record[9] = time() + (3600 * $sys_expire_hours);
						$rec = "";
						for ($i=0;$i<count($record);$i++) {
							if ($i < count($record)-1) {
								$rec .= $record[$i] . "|";
							} else {
								$rec .= $record[$i];
							}
						}
						$recs[] = $rec;
					} else {
						$recs[] = $rec;
					}
				}
			}
		}
		if ($changes) {
			# Update IPN file.
			updateIPN($record);
		} else {
			echo "
				<a href='index.php?action=adminmenu'>Retour au Menu</a>
				<p>La transaction correspondante n'a pas &eacute;t&eacute; trouv&eacute;e.</p>
		  ";
		}
    }
    public function updateIPN($record) {
        $done = false;
			$fh = openFile($sys_template_folder . "ipn.txt", "w+");
			while (!$done) {
				$fl = @flock($fh, LOCK_EX);
				if ($fl) {
					foreach ($recs as $record) {
						@fwrite($fh, $record . "\n");
					}
					$done = true;
					@flock($fh, LOCK_UN);
				}
			}
			@fclose($fh);
			echo "$adminheader
				<a href='index.php?action=adminmenu'>Retour au Menu</a>
				<p>Le lien de t&eacute;l&eacute;chargement est valide pour $sys_expire_hours heures &agrave; partir de maintenant.</p>
				<p>Donnez le lien de t&eacute;l&eacute;chargement suivant &agrave; votre client :</p>
				<p>http://$sys_domain" . $sys_script_folder . "?action=download&amp;id=$id</p>
				<p>Aucun email automatique ne lui sera exp&eacute;di&eacute;. Vous devez lui envoyer ce lien <u>vous-m&ecirc;me</u>.</p>
				$adminfooter
				";
    }
}
?>