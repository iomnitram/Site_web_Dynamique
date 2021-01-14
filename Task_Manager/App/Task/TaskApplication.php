<?php
namespace App\Task;
 
use \MBFram\Application;
 
class TaskApplication extends Application
{
  public function __construct()
  {
    parent::__construct();
 
    $this->name = 'Task';
  }
 
  public function run()
  {
    if ($this->user->isAuthenticated())
    {

      if ($this->httpRequest->postExists('ChoicePriv'))
        $this->user->setAttribute('Priv',$this->user->getAttribute("Account")->Privileges()->getPrivilege($this->httpRequest->postData('ChoicePriv')));
      elseif ($this->user->getAttribute('Priv') == null)
        $this->user->setAttribute('Priv',$this->user->getAttribute("Account")->Privileges()->getPrivilege('1'));
      else
        $this->user->setAttribute('Priv',$this->user->getAttribute("Account")->Privileges()->getPrivilege($this->user->getAttribute('Priv')));

      
      $controller = $this->getController();
      $controller->execute();

      $this->prepareMenu($controller, $this->user->getAttribute('Priv'));

    }
    else
    {
      $controller = new Modules\User\UserController($this, 'User', 'Connection');
      $controller->execute();
    }

    $this->httpResponse->setPage($controller->page());
    $this->httpResponse->send();
    
  }

  private function prepareMenu($controller, string $priv)
  {
    switch ($priv) {
      case '1':
        $nav = '<a href="/NewUser"><p>Nouvel utilisateur</p><img src="http://task_manager.com/img/AddUsers.png"></a>
                <a href="/User"><p>Liste des utilisateur</p><img src="http://task_manager.com/img/Users.png"></a>
                <a href="/NewTask"><p>Nouvelle tâche</p><img src="http://task_manager.com/img/AddChrono.png"></a>
                <a href="/CurrentTask"><p>Tâhces en cours</p><img src="http://task_manager.com/img/Chrono.png"></a>
                <a href="/TaskCompleted"><p>Tâches terminées</p><img src="http://task_manager.com/img/valide.png"></a>';
        break;
      case '2':
        $nav = '<a href="/NewUser"><p>Nouvel utilisateur</p><img src="http://task_manager.com/img/AddUsers.png"></a>
                <a href="/User"><p>Liste des utilisateur</p><img src="http://task_manager.com/img/Users.png"></a>
                <a href="/NewTask"><p>Nouvelle tâche</p><img src="http://task_manager.com/img/AddChrono.png"></a>
                <a href="/CurrentTask"><p>Tâhces en cours</p><img src="http://task_manager.com/img/Chrono.png"></a>
                <a href="/TaskCompleted"><p>Tâches terminées</p><img src="http://task_manager.com/img/valide.png"></a>';
        break;
      case '3':
        $nav = '<a href="/CurrentTask"><p>Tâhces en cours</p><img src="http://task_manager.com/img/Chrono.png"></a>
                <a href="/TaskCompleted"><p>Tâches terminées</p><img src="http://task_manager.com/img/valide.png"></a>';
        break;
      case '4':
        $nav = '<a href="/CurrentTask"><p>Tâhces en cours</p><img src="http://task_manager.com/img/Chrono.png"></a>
                <a href="/TaskCompleted"><p>Tâches terminées</p><img src="http://task_manager.com/img/valide.png"></a>';
        break;
    }
    $controller->page()->addVar('nav', $nav);
  }
}