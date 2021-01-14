<?php
namespace Entity;
 
use \MBFram\Entity;
 
class State extends Entity
{
  protected $TaskId,
            $Name,
            $Time;
 
  public function __construct(array $donnees = [])
  {
    parent::__construct($donnees);
    $this->Name = "";
    $this->Time = time();
  }

  // SETTERS //

  public function setTaskId(int $TaskId)
  {
    $this->TaskId = $TaskId;
  }
  public function setName(string $Name)
  {
    $this->Name = $Name;
  }
  public function setTime( $Time)
  {
    $this->Time = $Time;
  }

 
  // GETTERS //
  public function TaskId()
  {
    return $this->TaskId;
  }
  public function Name()
  {
    return $this->Name;
  }
 
  public function Time()
  {
    return $this->Time;
  }
}