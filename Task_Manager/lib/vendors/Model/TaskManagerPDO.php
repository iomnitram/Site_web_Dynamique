<?php
namespace Model;
 
use \Entity\Task;
 
class TaskManagerPDO extends TaskManager
{
  public function save(Task $Task)
  {
    if($this->exist($Task->id()))
      $this->modify($Task);
    else
      $Task->setId($this->new($Task));
    return $Task->id();
  }

  protected function new(Task $Task)
  {
    $requete = $this->dao->prepare('CALL new_Task(:Name , :Description, :Done)');
    $requete->bindValue(':Name', $Task->Name());
    $requete->bindValue(':Description', $Task->Description());
    $requete->bindValue(':Done', $Task->Done());
    $requete->execute();
    
    $ans = $requete->fetch();
    $requete->closeCursor();
    return $ans['id'];
  }

  protected function modify(Task $Task)
  {
    $requete = $this->dao->prepare('CALL update_Task(:id , :Name , :Description, :Done)');
    $requete->bindValue(':id', $Task->id());
    $requete->bindValue(':Name', $Task->Name());
    $requete->bindValue(':Description', $Task->Description());
    $requete->bindValue(':Done', $Task->Done());
    $requete->execute();
    $requete->closeCursor();
  }

  public function delete(Task $Task)
  {
    $requete = $this->dao->prepare('CALL delete_Task(:id)');
    $requete->bindValue(':id', $Task->id());
    $requete->execute();
    $requete->closeCursor();
  }

  public function get(int $id)
  {
    $requete = $this->dao->prepare('CALL get_Task(:id)');
    $requete->bindValue(':id', $id);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Task');
  
    $ans = $requete->fetch();
    $requete->closeCursor();
    return $ans;
  }
  public function exist(int $id)
  {
    $requete = $this->dao->prepare('CALL exist_Task(:id)');
    $requete->bindValue(':id', $id);
    $requete->execute();

    $ans = $requete->fetch();
    $requete->closeCursor();

    return $ans['num'] == 1;
  }


  public function getAll()
  {
    $requete = $this->dao->prepare('CALL get_Task_All()');
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Task');
    
    $ans = $requete->fetchAll();
    $requete->closeCursor();
    return $ans;
  }

  public function getOnDone(int $Done)
  {
    $requete = $this->dao->prepare('CALL get_Task_OnDone(:Done)');
    $requete->bindValue(':Done', $Done);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Task');
  
    $ans = $requete->fetchAll();
    $requete->closeCursor();
    return $ans;
  }

  public function getClientOnDone(int $id_Account, int $Done)
  {
    $requete = $this->dao->prepare('CALL get_Task_Client_OnDone(:id_Account, :Done)');
    $requete->bindValue(':id_Account', $id_Account);
    $requete->bindValue(':Done', $Done);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Task');
  
    $ans = $requete->fetchAll();
    $requete->closeCursor();
    return $ans;
  }

  public function getWorkOnDone(int $id_Account, int $Done)
  {
    $requete = $this->dao->prepare('CALL get_Task_Trav_OnDone(:id_Account, :Done)');
    $requete->bindValue(':id_Account', $id_Account);
    $requete->bindValue(':Done', $Done);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Task');
  
    $ans = $requete->fetchAll();
    $requete->closeCursor();
    return $ans;
  }

  public function addClient(int $Task_id, int $Account_id)
  {
    if($this->existClient($Task_id,$Account_id)) return;
    $requete = $this->dao->prepare('CALL add_Order(:Task_id, :Account_id)');
    $requete->bindValue(':Task_id', $Task_id);
    $requete->bindValue(':Account_id', $Account_id);
    $requete->execute();
  }
  public function deleteClient(int $Task_id, int $Account_id)
  {
    $requete = $this->dao->prepare('CALL delete_Order(:Task_id, :Account_id)');
    $requete->bindValue(':Task_id', $Task_id);
    $requete->bindValue(':Account_id', $Account_id);
    $requete->execute();
  }
  public function existClient(int $Task_id, int $Account_id)
  {
    $requete = $this->dao->prepare('CALL exist_Order(:Task_id, :Account_id)');
    $requete->bindValue(':Task_id', $Task_id);
    $requete->bindValue(':Account_id', $Account_id);
    $requete->execute();

    $ans = $requete->fetch();
    $requete->closeCursor();

    return $ans['num'] == 1;
  }

  public function addTrav(int $Task_id, int $Account_id)
  {
    if($this->existTrav($Task_id,$Account_id)) return;
    $requete = $this->dao->prepare('CALL add_Work(:Task_id, :Account_id)');
    $requete->bindValue(':Task_id', $Task_id);
    $requete->bindValue(':Account_id', $Account_id);
    $requete->execute();
  }
  public function deleteTrav(int $Task_id, int $Account_id)
  {
    $requete = $this->dao->prepare('CALL delete_Work(:Task_id, :Account_id)');
    $requete->bindValue(':Task_id', $Task_id);
    $requete->bindValue(':Account_id', $Account_id);
    $requete->execute();
  }
  public function existTrav(int $Task_id, int $Account_id)
  {
    $requete = $this->dao->prepare('CALL exist_Work(:Task_id, :Account_id)');
    $requete->bindValue(':Task_id', $Task_id);
    $requete->bindValue(':Account_id', $Account_id);
    $requete->execute();

    $ans = $requete->fetch();
    $requete->closeCursor();

    return $ans['num'] == 1;
  }
}