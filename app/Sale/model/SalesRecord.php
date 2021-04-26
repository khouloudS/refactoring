<?php
class SalesRecord extends System
{
    private $_ip;
    private $_sales;


    public function __construct()
    {
    }
    public function __construct($ip, $sales)
    {
        $this->setIp($ip);
        $this->setSales($sales);
    }

    public function setIp($ip)
    {
        $this->_ip = $ip;
    }

    public function setSales($sales)
    {
        $this->_sales = $sales;
    }

    public function getIp()
    {
        return $this->_ip = $_SERVER["REMOTE_ADDR"];
    }

    public function getSales($sys_template_folder, $textFile)
    {
        return $this->_sales =  @file($sys_template_folder . "" .$textFile);
    }

   

}
?>