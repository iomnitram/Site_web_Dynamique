

<div id="blocEdit">
	<h2><?= $title_Form?></h2>
	<?php
		if(isset($User_error))
			echo "<p id='InfoError'>" . $User_error . "</p>";
		if(isset($User_Validation))
			echo "<p id='InfoValidation'>" . $User_Validation . "</p>";
	?>

	<form id="form_param" name="param" method="post" action="">
		<p id="p_id">
			<input type="number" name="p_id" id="p_id" value="<?= $account->id() ?>" style="display: none"/>
		</p>
		<p id="p_FirstName">
			<label for="FirstName">Prénom :</label><br/>
			<input type="text" name="FirstName" id="FirstName" value="<?= $account->FirstName() ?>"/>
		</p>
		<p id="p_Name"> 
			<label for="Name">Nom :</label><br/>
			<input type="text" name="Name" id="Name" value="<?= $account->Name() ?>"/>
		</p>
		<p id="p_pseudo">
			<label for="pseudo">Pseudo :</label><br/>
			<input type="text" name="pseudo" id="pseudo" value="<?= $account->Pseudo() ?>"/>
		</p>
		<?php 
			if(isset($CheckOldPass) && $CheckOldPass == true)
				echo '
					<p id="p_OldPass"> 
						<label for="OldPass">Ancien mot de passe :</label><br/>
						<input type="password" name="OldPass" id="OldPass" />
					</p>';
		?>
		<p id="p_NewPass"> 
			<label for="NewPass">Nouveau mot de passe :</label><br/>
			<input type="password" name="NewPass" id="NewPass" />
		</p>
		<p id="p_RepPass"> 
			<label for="RepPass">Répéter Nouveau mot de passe :</label><br/>
			<input type="password" name="RepPass" id="RepPass" />
		</p>

		<?php 
			if(isset($ModifPriv) && $ModifPriv == true)
				echo '<div id="p_Privilege">
							<input type="checkbox" name="p_Pr_On" id="p_Pr_On" checked style="display: none"/>
							<p>
							<input type="checkbox" name="p_Pr_Admin" id="p_Pr_Admin" ' . ($account->Privileges()->Admin()?"checked":"") . ' /> <label for="p_Pr_Admin">Admin</label>
							</p>
							<p>
							<input type="checkbox" name="p_Pr_Staff" id="p_Pr_Staff" ' . ($account->Privileges()->Staff()?"checked":"") . ' /> <label for="p_Pr_Staff">Staff</label>
							</p>
							<p>
							<input type="checkbox" name="p_Pr_Trav" id="p_Pr_Trav" ' . ($account->Privileges()->Trav()?"checked":"") . ' /> <label for="p_Pr_Trav">Travailleur</label>
							</p>
							<p>
							<input type="checkbox" name="p_Pr_Client" id="p_Pr_Client" ' . ($account->Privileges()->Client()?"checked":"") . ' /> <label for="p_Pr_Client">Client</label>
							</p>
						</div>';
		?>
					


		<p id="p_submit">
			<input id="submit" type="submit" value="Valider" />
		</p>
	</form>
</div>
	