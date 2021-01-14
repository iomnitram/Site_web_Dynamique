<?php
namespace App\Task\Modules\User;
 
use \MBFram\BackController;
use \MBFram\HTTPRequest;
use \Entity\Account;
use \Entity\Privileges;
use PDOException;
 
class UserController extends BackController
{
	public function executeConnection(HTTPRequest $request)
	{
		if($this->app->user()->isAuthenticated())
		{
			$this->app->httpResponse()->redirect('.');
			return;
		}

		$this->page->addVar('title', 'Connexion | Task_Manager');
		$this->page->addStylesheet("Connexion");
		$this->page->addScript("Connexion");
		$this->page->addScript("md5");

		if ($request->postExists('Login') && $request->postExists('Password'))
		{
			$login = $request->postData('Login');
			$password = $request->postData('Password');
			
			$manager = $this->managers->getManagerOf('Account');
			$acc = $manager->getConnection($login,$password);

			if ($acc != NULL)
			{
				$acc = $manager->get($acc->id());

				$this->app->user()->setAuthenticated(true);
				$this->app->user()->setAttribute('Account',$acc);
				$this->app->httpResponse()->redirect($this->app->httpRequest()->requestURI());
			}
			else
			{
				$this->app->user()->setFlash('Le pseudo ou le mot de passe est incorrect.');
			}
		}
	}

	public function executeDisconnection(HTTPRequest $request)
	{
		$this->app->user()->setAuthenticated(false);
		$this->app->user()->setAttribute('Account',null);
		$this->app->httpResponse()->redirect('.');

	}

	public function executeConfiguration(HTTPRequest $request)
	{
		$this->saveAccount($request);

		$this->page->addVar('title', 'Configuration | Task_Manager');
		$this->page->addStylesheet("EditAccount");
		$this->page->addScript("ValidAccount");
		$this->page->addScript("md5");
		$this->setView('Edit');


		$id = (int)$request->getData('Account');
		if($id == 0)
			$id = $this->app->user()->getAttribute('Account')->id();

		if($this->app->user()->getAttribute('Priv') != '1'
				&& $this->app->user()->getAttribute('Priv') != '2'
				&& $id != $this->app->user()->getAttribute('Account')->id())
			$this->app->httpResponse()->redirect('Setting');

		$manager = $this->managers->getManagerOf('Account');
		$account = $manager->get($id);
		if($account == null)
			$this->app->httpResponse()->redirect('Setting');

		
		
		$this->page->addVar('account', $account);
		$this->page->addVar('ModifPriv', true);

		if($id == $this->app->user()->getAttribute('Account')->id())
		{
			$this->page->addVar('CheckOldPass', true);
			$this->page->addVar('title_Form', 'Votre compte');
		}

		else
		{
			$this->page->addVar('CheckOldPass', false);
			$this->page->addVar('title_Form', 'Modification du compte');
		}
	}

	public function executeShowAll(HTTPRequest $request)
	{
		$this->page->addStylesheet("UserShowAll");
		if($this->app->user()->getAttribute('Priv') != '1'
				&& $this->app->user()->getAttribute('Priv') != '2')
			$this->app->httpResponse()->redirect('.');

		$this->page->addVar('title', 'Liste utilisateurs | Task_Manager');

		$manager = $this->managers->getManagerOf('Account');
		
		$this->page->addVar('ListAccount', $manager->getAll());
		$this->page->addVar('NbAccount_Total', $manager->count());
		$this->page->addVar('NbAccount_Admin', $manager->countPrivilege(1));
		$this->page->addVar('NbAccount_Staff', $manager->countPrivilege(2));
		$this->page->addVar('NbAccount_Trav', $manager->countPrivilege(3));
		$this->page->addVar('NbAccount_Client', $manager->countPrivilege(4));
		
	}

	public function executeNew(HTTPRequest $request)
	{
		$this->saveAccount($request);

		if($this->app->user()->getAttribute('Priv') != '1'
				&& $this->app->user()->getAttribute('Priv') != '2')
			$this->app->httpResponse()->redirect('.');

		$this->page->addVar('title', 'Nouvel utilisateurs | Task_Manager');
		$this->setView('Edit');
		$this->page->addStylesheet("EditAccount");

		$this->page->addScript("ValidAccount");
		$this->page->addScript("md5");
		$this->page->addScript("Eid");

		

		$this->page->addVar('account', new Account());
		$this->page->addVar('ModifPriv', true);
		$this->page->addVar('CheckOldPass', false);
		$this->page->addVar('title_Form', 'Nouveau compte');
	}

	private function saveAccount(HTTPRequest $request)
	{
		$manager = $this->managers->getManagerOf('Account');

		if ($request->postExists('p_id')
				&& $request->postExists('FirstName')
				&& $request->postExists('Name')
				&& $request->postExists('pseudo')
				&& $request->postExists('NewPass')
				&& $request->postExists('RepPass'))
		{
			$acc = new Account();
			$acc->setId($request->postData('p_id'));
			$acc->setFirstName($request->postData('FirstName'));
			$acc->setName($request->postData('Name'));
			$acc->setPseudo($request->postData('pseudo'));

			$NewPass = $request->postData('NewPass');
			$RepPass = $request->postData('RepPass');

			$this->page->addVar('title', $acc->id());

			if($acc->id() < 0 || !$manager->exist($acc->id()))
				$acc->setId(0);

			if($acc->id() != $this->app->user()->getAttribute('Account')->id())
			{
				if($this->app->user()->getAttribute('Priv') != '1'
						&& $this->app->user()->getAttribute('Priv') != '2')
				{
					$this->page->addVar('User_error', "Vous n'avez pas le droit de modifier ce profil");
					return;
				}
			}

			if($NewPass != "" || $RepPass != "")
			{
				if($NewPass != $RepPass)
				{
					$this->page->addVar('User_error', "Le mot de passe répété n'est pas le même");
					return;
				}

				if($acc->id() == $this->app->user()->getAttribute('Account')->id())
				{
					if(!$request->postExists('OldPass')
							|| $request->postData('OldPass') != $this->app->user()->getAttribute('Account')->Password())
					{
						$this->page->addVar('User_error', "L'ancien mot de passe n'est pas correct");
						return;
					}
				}

				if($NewPass == "d41d8cd98f00b204e9800998ecf8427e")
				{
					$this->page->addVar('User_error', "Le nouveau mot de passe ne peut pas être nul");
					return;
				}

				$acc->setPassword($NewPass);
			}
			else
			{
				$accOriginal = $manager->get($acc->id());
				if($accOriginal == null)
				{
					$this->page->addVar('User_error', "Il faut indiquer un mot de passe pour les nouveaux comptes");
					return;
				}
				$acc->setPassword($accOriginal->Password());
			}

			if(!$acc->isValid())
			{
				$this->page->addVar('User_error', "Le profil n'est pas valide");
				return;
			}
			try
			{
				
				 $acc->setId($manager->save($acc));
				$this->page->addVar('User_Validation', "Le profil a bien été sauvegardé");
			}
			catch (Exception $e)
			{
				
				$this->page->addVar('User_error', "Le profil n'a pas pu être sauvegadé (ce pseudo existe surement déjà)" . $acc->Pseudo());
			}

			if($request->postExists('p_Pr_On')
				&& ($this->app->user()->getAttribute('Priv') == '1'
						|| $this->app->user()->getAttribute('Priv') == '2'))
			{
				$privi = new Privileges();
				if($request->postExists('p_Pr_Admin'))
					$privi->setAdmin(true);
				if($request->postExists('p_Pr_Staff'))
					$privi->setStaff(true);
				if($request->postExists('p_Pr_Trav'))
					$privi->setTrav(true);
				if($request->postExists('p_Pr_Client'))
					$privi->setClient(true);

				$manager_Privi = $this->managers->getManagerOf('Privileges');
				$manager_Privi->save($acc->id(),$privi);
			}

			$this->app->user()->setAttribute('Account',
															$manager->get(
																				$this->app->user()->getAttribute('Account')->id()));
		}
	}

}