<?php
namespace Model;
 
use \Entity\Account;
use \Entity\Privileges;
 
class AccountManagerPDO extends AccountManager
{
  protected function add(Account $account)
  {
    $requete = $this->dao->prepare('CALL new_Account(:FirstName , :Name , :Pseudo , :Password)');
    $requete->bindValue(':FirstName', $account->FirstName());
    $requete->bindValue(':Name', $account->Name());
    $requete->bindValue(':Pseudo', $account->Pseudo());
    $requete->bindValue(':Password', $account->Password());
    $requete->execute();
    
    $ans = $requete->fetch();
    $requete->closeCursor();
    return $ans['id'];
  }
  protected function modify(Account $account)
  {
    $requete = $this->dao->prepare('CALL update_Account(:id , :FirstName , :Name , :Pseudo , :Password)');
    $requete->bindValue(':id', $account->id());
    $requete->bindValue(':FirstName', $account->FirstName());
    $requete->bindValue(':Name', $account->Name());
    $requete->bindValue(':Pseudo', $account->Pseudo());
    $requete->bindValue(':Password', $account->Password());
    $requete->execute();
    $requete->closeCursor();
  }
  public function delete(Account $account)
  {
    $requete = $this->dao->prepare('CALL remove_Account(:id)');
    $requete->bindValue(':id', $account->id());
    $requete->execute();
    $requete->closeCursor();
  }

  public function get(int $id)
  {
    $requete = $this->dao->prepare('CALL get_Account(:id)');
    $requete->bindValue(':id', $id);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Account');
  
    $account = $requete->fetch();
    $requete->closeCursor();
    if($account == null)
      return null;
    $account = $this->getPrivileges($account);
    return $account;
  }
  public function getAll()
  {
    $requete = $this->dao->prepare('CALL get_Accounts()');
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Account');
    
    $ans = $requete->fetchAll();
    $requete->closeCursor();
    foreach ($ans as $acc) {
      $acc = $this->getPrivileges($acc);
    }
    return $ans;
  }
  public function getPrivilege(int $Privilege)
  {
    $requete = $this->dao->prepare('CALL get_AccountPrivilegied(:id)');
    $requete->bindValue(':id', $Privilege);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Account');
 
    $ans = $requete->fetchAll();
    $requete->closeCursor();
    return $ans;
  }

  public function getConnection(string $pseudo, string $password)
  {
    $requete = $this->dao->prepare('CALL get_Connection(:pseudo , :password)');
    $requete->bindValue(':pseudo', $pseudo);
    $requete->bindValue(':password', $password);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Account');

    $ans = $requete->fetch();
    $requete->closeCursor();
    return $ans;
  }

  public function count()
  {
    $requete = $this->dao->prepare('CALL count_Account()');
    $requete->execute();
    $ans = $requete->fetch();
    $requete->closeCursor();
    return $ans['num'];
  }

  public function countPrivilege(int $Privilege)
  {
    $requete = $this->dao->prepare('CALL count_AccountPrivilegied(:id)');
    $requete->bindValue(':id', $Privilege);
    $requete->execute();
    $ans = $requete->fetch();
    $requete->closeCursor();
    return $ans['num'];
  }

  private function getPrivileges(Account $account)
  {
    $ans = new Privileges();

    $requete = $this->dao->prepare('CALL get_Privilege(:User_id)');
    $requete->bindValue(':User_id', $account->id());
    $requete->execute();
    
    while ($priv = $requete->fetch())
    {
      switch ($priv['Privilege_id']) {
        case 1:
          $ans->setAdmin(true);
          break;
        case 2:
          $ans->setStaff(true);
          break;
        case 3:
          $ans->setTrav(true);
          break;
        case 4:
          $ans->setClient(true);
          break;
        
        default:
          # code...
          break;
      }
    }
    $requete->closeCursor();
    $account->setPrivileges($ans);
    return $account;
  }

  public function exist(int $id)
  {
    $requete = $this->dao->prepare('CALL exist_Account(:id)');
    $requete->bindValue(':id', $id);
    $requete->execute();

    $ans = $requete->fetch();
    $requete->closeCursor();

    return $ans['num'] == 1;
  }

  public function save(Account $account)
  {
    if($this->exist($account->id()))
      $this->modify($account);
    else
      $account->setId($this->add($account));
    return $account->id();
  }


  public function Worker(int $Task_id)
  {
    $requete = $this->dao->prepare('CALL work_on(:Task_id)');
    $requete->bindValue(':Task_id', $Task_id);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Account');
 
    $ans = $requete->fetchAll();
    $requete->closeCursor();
    return $ans;
  }
  public function Not_Worker(int $Task_id)
  {
    $requete = $this->dao->prepare('CALL dont_work_on(:Task_id)');
    $requete->bindValue(':Task_id', $Task_id);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Account');
 
    $ans = $requete->fetchAll();
    $requete->closeCursor();
    return $ans;
  }
  public function Client(int $Task_id)
  {
    $requete = $this->dao->prepare('CALL client(:Task_id)');
    $requete->bindValue(':Task_id', $Task_id);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Account');
 
    $ans = $requete->fetchAll();
    $requete->closeCursor();
    return $ans;
  }
  public function Not_Client(int $Task_id)
  {
    $requete = $this->dao->prepare('CALL not_client(:Task_id)');
    $requete->bindValue(':Task_id', $Task_id);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Account');
 
    $ans = $requete->fetchAll();
    $requete->closeCursor();
    return $ans;
  }
}