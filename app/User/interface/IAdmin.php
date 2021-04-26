<?php

// Declaration de l'interface 'IAdmin'
interface IAdmin
{
    public function checkIsAdmin($username, $password);
    public function adminAction();
    public function showCustomer();
    public function exportToCSV();
    public function refferReport($isdomain);
    public function showReport($records, $rcount);
    public function showReportDomain($records, $rcount);
    public function totalSales();
    public function extendDuration();
    public function updateIPN($record);

}
?>