<?php
namespace App\Task\Modules\Task;
 
use \MBFram\BackController;
use \MBFram\HTTPRequest;
use \Entity\Task;
 
class TaskController extends BackController
{
  public function executeCurrent(HTTPRequest $request)
  {
    $this->page->addVar('title', $this->app->user()->getAttribute('Account')->id() . 'Tâches en cours | Task_Manager');
    $this->setView('ListTask');
    $this->page->addStylesheet("ListTask");
    $this->page->addScript("ListTask");
    $Task_Manager = $this->managers->getManagerOf('Task');

   	switch ($this->app->user()->getAttribute('Priv')) {
   		case '1':
   		case '2':
   			$this->page->addVar('ListTasks', $Task_Manager->getOnDone(false));
   			break;
   		case '3':
   			$this->page->addVar('ListTasks', $Task_Manager->getWorkOnDone($this->app->user()->getAttribute('Account')->id(),false));
   			break;
   		case '4':
   			$this->page->addVar('ListTasks', $Task_Manager->getClientOnDone($this->app->user()->getAttribute('Account')->id(),false));
   			break;
   	}
   	
  }

  public function executeCompleted(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Tâches terminées | Task_Manager');
    $this->setView('ListTask');
    $this->page->addStylesheet("ListTask");
    $this->page->addScript("ListTask");
    $Task_Manager = $this->managers->getManagerOf('Task');

   	switch ($this->app->user()->getAttribute('Priv')) {
   		case '1':
   		case '2':
   			$this->page->addVar('ListTasks', $Task_Manager->getOnDone(true));
   			break;
   		case '3':
   			$this->page->addVar('ListTasks', $Task_Manager->getWorkOnDone($this->app->user()->getAttribute('Account')->id(),true));
   			break;
   		case '4':
   			$this->page->addVar('ListTasks', $Task_Manager->getClientOnDone($this->app->user()->getAttribute('Account')->id(),true));
   			break;
   	}
   	
  }

  public function executeEdit(HTTPRequest $request)
  {

    $this->page->addVar('title', 'Éditer tâche | Task_Manager');
    $this->setView('EditTask');
    $this->page->addStylesheet("EditTask");

    $this->SaveTask($request);

    $Task_Manager = $this->managers->getManagerOf('Task');
    $Account_manager = $this->managers->getManagerOf('Account');

    $id = (int)$request->getData('Task');
    $task = $Task_Manager->get($id);
	if($task == null)
	{
		$this->app->httpResponse()->redirect('');
		return;
	}

	$this->page->addVar('Task', $task);
	
	if($this->app->user()->getAttribute('Priv') == '1'
        || $this->app->user()->getAttribute('Priv') == '2')
   	{
		$this->page->addVar('Not_Clients', $Account_manager->Not_Client($id));
		$this->page->addVar('Not_Travs', $Account_manager->Not_Worker($id));
		$this->page->addVar('Clients', $Account_manager->Client($id));
		$this->page->addVar('Travs', $Account_manager->Worker($id));

		
		$this->page->addVar('EditClient', true);
		$this->page->addVar('EditTrav', true);
	}
	else
	{
		$this->page->addVar('EditClient', false);
		$this->page->addVar('EditTrav', false);
	}

    $this->page->addVar('title_form', "Éditer tâche");
  }

  public function executeNew(HTTPRequest $request)
  {
  	if($this->app->user()->getAttribute('Priv') != '1'
        && $this->app->user()->getAttribute('Priv') != '2')
      $this->app->httpResponse()->redirect('.');

    $this->page->addVar('title', 'Nouvelle tâche | Task_Manager');
    $this->setView('EditTask');
    $this->page->addStylesheet("EditTask");

    $this->SaveTask($request);

    $Task_Manager = $this->managers->getManagerOf('Task');
    $Account_manager = $this->managers->getManagerOf('Account');

	$this->page->addVar('Task', new Task());

	
	$this->page->addVar('EditClient', false);
	$this->page->addVar('EditTrav', false);

    $this->page->addVar('title_form', "Nouvelle tâche");
    
   	
  }

  private function SaveTask(HTTPRequest $request)
  {
  	$hasSave = false;
  	$Task_manager = $this->managers->getManagerOf('Task');

//Save
	if ($request->postExists('i_id')
		&& $request->postExists('i_Name')
		&& $request->postExists('i_Desc')
		&& $request->postData('i_Name') != "")
	{
		$ta = new Task();
		$ta->setId($request->postData('i_id'));
		$ta->setName($request->postData('i_Name'));
		$ta->setDescription($request->postData('i_Desc'));
		$ta->setDone($request->postExists('i_Done'));

		$Task_manager->Save($ta);
		$this->page->addVar('Task_Validation', "La tâche a bien été sauvegardée");
		$hasSave = true;
	}
//Add Client
	if ($request->postExists('i_id')
		&& $request->postExists('newClient'))
	{
		$Task_manager->addClient((int) $request->postData('i_id'),(int) $request->postData('newClient'));
		$this->page->addVar('Task_Validation', "Le client a été ajouté");
		$hasSave = true;
	}

//Add Trav
	if ($request->postExists('i_id')
		&& $request->postExists('newTrav'))
	{
		$Task_manager->addTrav((int) $request->postData('i_id'),(int) $request->postData('newTrav'));
		$this->page->addVar('Task_Validation', "Le Travailleur a été ajouté");
		$hasSave = true;
	}

//Del Client
	if ($request->postExists('i_id')
		&& $request->postExists('delClient'))
	{
		$Task_manager->deleteClient((int) $request->postData('i_id'),(int) $request->postData('delClient'));
		$this->page->addVar('Task_Validation', "Le client a été supprimé");
		$hasSave = true;
	}

//Del Trav
	if ($request->postExists('i_id')
		&& $request->postExists('delTrav'))
	{
		$Task_manager->deleteTrav((int) $request->postData('i_id'),(int) $request->postData('delTrav'));
		$this->page->addVar('Task_Validation', "Le Travailleur a été supprimé");
		$hasSave = true;
	}

	return $hasSave;
  }

}