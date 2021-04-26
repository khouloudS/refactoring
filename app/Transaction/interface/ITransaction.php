<?php

// Declaration de l'interface 'ITransaction'
interface ITransaction
{
    public function getTransaction($id);
    public function checkForSale($id);
    public function checkForIpRelated($id);
    public function downloadById();
    public function sys_download_url($oto);
    public function sendPrroductDownloadToBrowser();
}
?>