<?php
namespace Model;
 
use \Entity\Privileges;
 
class PrivilegesManagerPDO extends PrivilegesManager
{
  public function save(int $User_id, Privileges $Privileges)
  {
    $base = $this->get($User_id);

    if($Privileges->Admin() && !$base->Admin())
        $this->add($User_id,1);
    if(!$Privileges->Admin() && $base->Admin())
        $this->remove($User_id,1);

    if($Privileges->Staff() && !$base->Staff())
        $this->add($User_id,2);
    if(!$Privileges->Staff() && $base->Staff())
        $this->remove($User_id,2);

    if($Privileges->Trav() && !$base->Trav())
        $this->add($User_id,3);
    if(!$Privileges->Trav() && $base->Trav())
        $this->remove($User_id,3);

    if($Privileges->Client() && !$base->Client())
        $this->add($User_id,4);
    if(!$Privileges->Client() && $base->Client())
        $this->remove($User_id,4);
  }

  public function get(int $User_id)
  {
    $ans = new Privileges();

    $requete = $this->dao->prepare('CALL get_Privilege(:User_id)');
    $requete->bindValue(':User_id', $User_id);
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

    return $ans;

  }

  public function add(int $User_id, int $Privilege_id)
  {
    $requete = $this->dao->prepare('CALL add_Privilege(:id_User , :id_Privilege)');
    $requete->bindValue(':id_User', $User_id);
    $requete->bindValue(':id_Privilege', $Privilege_id);
    $requete->execute();
    $requete->closeCursor();
  }

  public function remove(int $User_id, int $Privilege_id)
  {
    $requete = $this->dao->prepare('CALL remove_Privilege(:id_User , :id_Privilege)');
    $requete->bindValue(':id_User', $User_id);
    $requete->bindValue(':id_Privilege', $Privilege_id);
    $requete->execute();
    $requete->closeCursor();
  }

}