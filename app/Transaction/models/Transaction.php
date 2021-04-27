<?php
class Transaction extends System
{
  private $_id;
  private $_status;
  private $_oto;

  public function __construct()
  {
    
  }
  public function __construct($id, $status, $oto)
  {
    $this->setId($id); // Initialize id.
    $this->setStatus($status); // Initialize status.
    $this->setOto($oto); // Initialize oto.

}

  public function setId($id)
  {
    $this->_id = $id;
  }

  public function setStatus($status)
  {
    $this->_status = $status;
  }

   public function setOto($oto)
   {
     $this->_oto = $oto;
   }
}
?>