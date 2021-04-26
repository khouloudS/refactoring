<?php
class User
{
  private $_password;
  private $_login;
  private $_authorazition

  public function __construct()
  {
  }
  public function __construct($password, $login, $authorazition)
  {
    $this->setPassword($id);
    $this->setLogin($status);
    $this->setAuthorazition()
  }

  public function setLogin($login)
  {
    $this->$_login= $login;
  }

  public function setPassword($password)
  {
    $this->$_password = $password;
  }

  public function setAuthorazition($authorazition)
  {
    $this->$_authorazition = $authorazition;
  }

  public function logout(){
    setcookie('7ds_admin', '', time() - 3600, $sys_script_folder, '.' . $sys_domain);
		header('Location: index.php');
  }

}
?>