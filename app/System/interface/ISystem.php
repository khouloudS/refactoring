<?php

// Declaration de l'interface 'iTemplate'
interface ISales
{
    public function showTemplate($filename);
    public function openFile($sys_template_folder, $filename, $permission);
    public function checkFile($filename);
    public function setcookies($name, $value, $expires,  $path, $domain, $location);
    public function searchKeywords($url);
    public function tellFriendMessage($sendername, $senderpaypal, $email);
    public function removeAffiliateFromEmail();
    public function mailer($filename,$to);
}
?>