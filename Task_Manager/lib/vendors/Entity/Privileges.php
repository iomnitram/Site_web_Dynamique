<?php
namespace Entity;
 
use \MBFram\Entity;
 
class Privileges extends Entity
{
  protected $Admin,
            $Staff,
            $Trav,
            $Client;
 
  public function __construct(array $donnees = [])
  {
    parent::__construct($donnees);
    $this->Admin = false;
    $this->Staff = false;
    $this->Trav = false;
    $this->Client = false;
  }

  public function copy()
  {
    $ans = new Privileges();
    $ans->setAdmin($this->Admin());
    $ans->setStaff($this->Staff());
    $ans->setTrav($this->Trav());
    $ans->setClient($this->Client());

    return $ans;
  }

  // SETTERS //

  public function setAdmin(bool $Admin)
  {
    $this->Admin = $Admin;
  }
  public function setStaff(bool $Staff)
  {
    $this->Staff = $Staff;
  }
  public function setTrav(bool $Trav)
  {
    $this->Trav = $Trav;
  }
  public function setClient(bool $Client)
  {
    $this->Client = $Client;
  }
 
  // GETTERS //
 
  public function Admin()
  {
    return $this->Admin;
  }
 
  public function Staff()
  {
    return $this->Staff;
  }
 
  public function Trav()
  {
    return $this->Trav;
  }

  public function Client()
  {
    return $this->Client;
  }
  public function Count()
  {
    $ans = 0;
    if($this->Admin) $ans++;
    if($this->Staff) $ans++;
    if($this->Trav) $ans++;
    if($this->Client) $ans++;
    return $ans;
  }

  public function getPrivilege(string $pref)
  {
    switch ($pref) {
      case '1':
        if($this->Admin)return '1';
        break;
      case '2':
        if($this->Staff)return '2';
        break;
      case '3':
        if($this->Trav)return '3';
        break;
      case '4':
        if($this->Client)return '4';
        break;
    }
    if($this->Admin)return '1';
    if($this->Staff)return '2';
    if($this->Trav)return '3';
    if($this->Client)return '4';
    return '0';
  }
}