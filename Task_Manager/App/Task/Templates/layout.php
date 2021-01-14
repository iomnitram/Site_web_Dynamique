<?php
	$account = $user->getAttribute("Account");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
		<?= isset($title) ? $title : 'Task Manager' ?>
		</title>

		<meta charset="utf-8" />
		<?= $stylesheet ?>
	</head>

	<body>
		<header>
			<div id="title">
				<h1><a href=".">Task Manager</a></h1>
				<?php
					if($account != null && $account->Privileges()->Count() > 1)
					{
						?>
						<form id="formPriv" method="post" action="">
							<input type="text" name="ChoicePriv" id="ChoicePriv" value= <?= '"' . $user->getAttribute("Priv") . '"'?> />
						</form>
						<div id="privileges">
							<?php
								if($account->Privileges()->Admin())
									echo "<p id='priv_Admin' href='.'>Admin</p>";
								if($account->Privileges()->Staff())
									echo "<p id='priv_Staff' href='.'>Staff</p>";
								if($account->Privileges()->Trav())
									echo "<p id='priv_Trav' href='.'>Travailleur</p>";
								if($account->Privileges()->Client())
									echo "<p id='priv_Client' href='.'>Client</p>";
							?>
						</div>
						<?php
					}?>
				
			</div>
			<?php
				if($account != null)
				{
					?>
					<div id="Header_User">
						<a id="Header_User_Param"href="/Setting"><img src="http://task_manager.com/img/parametre.png"></a>
						<a id="Header_User_Name">
							<?php
								if($account->FirstName()=='')
									echo $account->Pseudo();
								else
									echo $account->FirstName() . ' ' . $account->Name();
							?>
						</a>
						<a id="Header_User_Quit"href="/Deconnexion"><img src="http://task_manager.com/img/deconnexion.png"></a>
					</div>
					<?php
				} ?>
		</header>
		<div id="mainSpace">

			<?= isset($nav) ? "<nav>" . $nav . "</nav>": "" ?>
			<div id="centerSpace">
				<div id="rollingSpace">
					<section>
						<?= $content ?>
					</section>
					<footer>
						<a href="">Conditions d'utilisation</a>
					</footer>
				</div>
				
			</div>
			<?= isset($aside) ? "<aside>" . $aside . "</aside>": "" ?>
			
		</div>

		<?= $script ?>
	</body>

	<script src="/js/FormPrivileges.js"></script>

</html>