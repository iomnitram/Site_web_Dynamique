<?php
namespace Entity;
 
use \MBFram\Entity;
 
class Account extends Entity
{
  protected $FirstName,
            $Name,
            $Pseudo,
            $Password,
            $Privileges;
 
  public function __construct(array $donnees = [])
  {
    parent::__construct($donnees);
    $this->FirstName = '';
    $this->Name = '';
    $this->Pseudo = '';
    $this->Password = '';
    $this->Privileges = new Privileges;
  }

  public function copy()
  {
    $ans = new Account();
    $ans->setId($this->id());
    $ans->setFirstName($this->FirstName());
    $ans->setName($this->Name());
    $ans->setPseudo($this->Pseudo());
    $ans->setPassword($this->Password());
    $ans->setPrivileges($this->Privileges()->copy());

    return $ans;
  }

  public function isValid()
  {
    if (!is_string($this->FirstName))
    {
      return false;
    }
    if (!is_string($this->Name))
    {
      return false;
    }
    if (!is_string($this->Pseudo) || empty($this->Pseudo))
    {
      return false;
    }
     if (!is_string($this->Password) || empty($this->Password))
    {
      return false;
    }
    return true;
  }

  // SETTERS //

  public function setFirstName(string $FirstName)
  {
    $this->FirstName = $FirstName;
  }
  public function setName(string $Name)
  {
    $this->Name = $Name;
  }
  public function setPseudo(string $Pseudo)
  {
    $this->Pseudo = $Pseudo;
  }
  public function setPassword(string $Password)
  {
    $this->Password = $Password;
  }

  public function setPrivileges(Privileges $Privileges)
  {
    $this->Privileges = $Privileges;
  }
 
  // GETTERS //
 
  public function FirstName()
  {
    return $this->FirstName;
  }
 
  public function Name()
  {
    return $this->Name;
  }
 
  public function Pseudo()
  {
    return $this->Pseudo;
  }

  public function Password()
  {
    return $this->Password;
  }
  public function Privileges()
  {
    return $this->Privileges;
  }
}