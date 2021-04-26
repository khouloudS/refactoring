<?php

// Declaration de l'interface 'ISales'
interface ISales
{
    public function splitSalesAndReplaceOccurrences($sale) ;
    public function getIPSalesRecord($oto);
    public function getOTOSalesRecord($affemail);
    public function getPaymentEmail($itemnumber, $percent);
    public function splitSales($sale) ;
    public function openFile($sys_template_folder, $permission) ;
    public function verifyPaypalEmailAddress($get);
    public function getSalesLetters();
    public function updateVisitorData();
    public function checkSoldeOut();
    public function showSalesLetters();
    public function getConversionSalesLetters();
    public function handleSaleOrder();

}
?>