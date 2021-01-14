<?php
namespace Model;
 
use \MBFram\Manager;
use \Entity\Privileges;
 
abstract class PrivilegesManager extends Manager
{
  abstract public function save(int $User_id, Privileges $Privilege);
  abstract public function get(int $User_id);
  abstract public function add(int $User_id, int $Privilege_id);
  abstract public function remove(int $User_id, int $Privilege_id);
}