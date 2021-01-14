<?php
namespace Entity;
 
use \MBFram\Entity;
use \Entity\State;
 
class Task extends Entity
{
  protected $Name,
            $Description,
            $Done = 0;
 
  public function __construct(array $donnees = [])
  {
    parent::__construct($donnees);
  }

  // SETTERS //

  public function setName(string $Name)
  {
    $this->Name = $Name;
  }
  public function setDescription(string $Description)
  {
    $this->Description = $Description;
  }
  public function setDone(int $Done)
  {
    $this->Done = $Done;
  }

 
  // GETTERS //
 
  public function Name()
  {
    return $this->Name;
  }
 
  public function Description()
  {
    return $this->Description;
  }

  public function Done()
  {
    return $this->Done;
  }


}