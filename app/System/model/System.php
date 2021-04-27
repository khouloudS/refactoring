<?php

class System implements ISystem
{
    public function __construct()
    {
        $this->checkFile(pathname);
        $this->checkFile("ipn.txt");
        $this->checkFile("fraud.txt");
        $this->checkFile("tellafriend.txt");
        $this->checkFile("uniq.txt");
        $this->checkFile("unsubs.txt");
    }   
    public function showTemplate($filename) {
        $filename = $_ENV['sys_template_folder'] . $filename;
        include($filename);
    }
    
    public function openFile($sys_template_folder, $filename, $permission) {
        return fopen($sys_template_folder . $filename, $permission);
    }
 
    public function checkFile($filename) {    
        if (!file_exists($_ENV['sys_template_folder'] . $filename)) {
            $fh = openFile($_ENV['sys_template_folder']. $filename, "w+");
            fwrite($fh, "");
            fclose($fh);
        }
        return;
    }

    public function setcookies($name, $value, $expires,  $path, $domain, $location) {
        setcookie($name, $value, $expires, $path, "." . $domain);
		showTemplate($location);
    }

    public function searchKeywords($url) {
        $parts = parse_url($url);
        $host = isset($parts['host']) ? str_replace("www.", "", $parts["host"]) : "";
        $keywords = "";
        if (isset($parts['query'])) {
            parse_str($parts["query"], $vars);
            if (strpos(" $host", "google")) {
                $keywords = urldecode($vars["q"]);
            } elseif (strpos(" $host", "yahoo")) {
                $keywords = urldecode($vars["p"]);
            } elseif (strpos(" $host", "live")) {
                $keywords = urldecode($vars["q"]);
            } elseif ($vars["keywords"]) {
                $keywords = urldecode($vars["keywords"]);
            } elseif ($vars["query"]) {
                $keywords = urldecode($vars["query"]);
            } else {
                $keywords = urldecode($vars["q"]);
            }
        }
        return $keywords;
    }
    public function tellFriendMessage($sendername, $senderpaypal, $email) {
        if (!empty($sendername) && !empty($senderpaypal) && is_array($emails)) {
            if (strpos(strtolower($_SERVER["HTTP_REFERER"]), strtolower($sys_domain)) > 0) {

                # Read number of tell-a-friend mails sent to date.
                $tafcount = @file_get_contents($sys_template_folder . "tellafriend.txt");
                if (!$tafcount) {
                    $tafcount = 0;
                }

                # Send the message.
                foreach ($emails as $email) {
                    if ($email) {
                        mailer("email_taf.txt", $email);
                        $tafcount++;
                    }
                }

                # Write new count.
                $fh = openFile($sys_template_folder, "tellafriend.txt", "w+");
                @fwrite($fh, $tafcount);
                @fclose($fh);

                # Thanks!
                $systemTemplate->thanks();
                exit;
            } else {
                # Mail can only be sent from this domain.
                $systemTemplate->thanks();
                exit;
            }
        } else {
            $systemTemplate->thanks();
            exit;
        }
    }

    public function removeAffiliateFromEmail() {

        $fh = openFile($sys_template_folder, "unsubs.txt", "a+");
		@fwrite($fh, $_REQUEST["email"] . "\n");
		@fclose($fh);
		$systemTemplate->removeAffiliate();
    }

    public function mailer($filename,$to) {
        
        if ($action == "tellafriend") {
            $eaddress = $senderpaypal;
        } else {
            if (substr($sys_support_address, 0, 7) == "http://") {
                $eaddress = "noreply@$sys_domain";
            } else {
                $eaddress = $sys_support_address;
            }
            $sendername = $sys_item_name;
        }
    
        $headers = "From: \"$sendername\"<$eaddress>\r\n";
        $headers .= "X-Sender: \"$sendername\"<$eaddress>\r\n";
        $headers .= "X-Mailer: 7DSS v$sys_version\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "Return-Path: \"$sendername\"<$eaddress>\r\n";
        $headers .= "Reply-To: \"$sendername\"<$eaddress>";
    
        $body = file($sys_template_folder . $filename);
        $subject = trim(array_shift($body));
        $body = implode($body);
    
        $body = str_replace("[business]",$payer_business,$body);
        $body = str_replace("[buyer email]",$payer_email,$body);
        $body = str_replace("[download link]","http://$sys_domain" . $sys_script_folder . "?action=download&id=$txn_id",$body);
        $body = str_replace("[expire hours]",$sys_expire_hours,$body);
        $subject = str_replace("[first name]",$payer_firstname,$subject);
        $body = str_replace("[first name]",$payer_firstname,$body);
        if ($action == "tellafriend") {
            $subject = str_replace("[item name]",$sys_item_name,$subject);
            $body = str_replace("[item name]",$sys_item_name,$body);
        } else {
            $subject = str_replace("[item name]",$item_name,$subject);
            $body = str_replace("[item name]",$item_name,$body);
        }
        $subject = str_replace("[item number]",$item_number,$subject);
        $body = str_replace("[item number]",$item_number,$body);
        $body = str_replace("[last name]",$payer_lastname,$body);
        $body = str_replace("[payment]",$payment_amount,$body);
        $body = str_replace("[receiver email]",$receiver_email,$body);
        $subject = str_replace("[site]",$sys_domain,$subject);
        $body = str_replace("[site]",$sys_domain,$body);
        $body = str_replace("[site link]","http://$sys_domain" . $sys_script_folder, $body);
        $body = str_replace("[support address]",$sys_support_address,$body);
        $body = str_replace("[taf email]",$senderpaypal,$body);
        $body = str_replace("[taf link]","http://$sys_domain" . $sys_script_folder . "?taf=1&e=$senderpaypal",$body);
        $subject = str_replace("[taf name]",$sendername,$subject);
        $body = str_replace("[taf name]",$sendername,$body);
    
        @mail($to, $subject, $body, $headers);
        return;
    }
    
}
?>