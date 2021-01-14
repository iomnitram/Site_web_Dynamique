<?php
namespace Model;
 
use \MBFram\Manager;
use \Entity\Account;
 
abstract class AccountManager extends Manager
{
  abstract protected function add(Account $account);
  abstract protected function modify(Account $account);
  abstract public function delete(Account $account);
  abstract public function get(int $id);
  abstract public function getAll();
  abstract public function getPrivilege(int $Privilege);
  abstract public function getConnection(string $pseudo, string $password);
  abstract public function count();
  abstract public function countPrivilege(int $Privilege);
  abstract public function exist(int $id);
  abstract public function save(Account $account);

  abstract public function Worker(int $Task_id);
  abstract public function Not_Worker(int $Task_id);
  abstract public function Client(int $Task_id);
  abstract public function Not_Client(int $Task_id);
}