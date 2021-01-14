<?php
namespace Model;
 
use \MBFram\Manager;
use \Entity\Task;
 
abstract class TaskManager extends Manager
{
  abstract public function save(Task $Task);
  abstract protected function new(Task $Task);
  abstract protected function modify(Task $Task);
  abstract public function delete(Task $Task);
  abstract public function get(int $id);
  abstract public function exist(int $id);

  abstract public function getAll();

  abstract public function getOnDone(int $Done);

  abstract public function getWorkOnDone(int $id_Account, int $Done);

  abstract public function getClientOnDone(int $id_Account, int $Done);

  abstract public function addClient(int $Task_id, int $Account_id);
  abstract public function deleteClient(int $Task_id, int $Account_id);
  abstract public function existClient(int $Task_id, int $Account_id);

  abstract public function addTrav(int $Task_id, int $Account_id);
  abstract public function deleteTrav(int $Task_id, int $Account_id);
  abstract public function existTrav(int $Task_id, int $Account_id);

  


  
  
}