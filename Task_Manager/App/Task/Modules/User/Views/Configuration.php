<div id="blocConfiguration">
	<h2>Paramètres de votre compte</h2>
	<?php
		if(isset($User_error))
			echo "<p id='InfoError'>" . $User_error . "</p>";
		if(isset($User_Validation))
			echo "<p id='InfoValidation'>" . $User_Validation . "</p>";
	?>

	<form id="form_param" name="param" method="post" action="">
		<?php $account = $user->getAttribute("Account"); ?>
		
		<p id="FirstName">
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
		<p id="p_OldPass"> 
			<label for="OldPass">Ancien mot de passe :</label><br/>
			<input type="password" name="OldPass" id="OldPass" />
			<input type="password" id="VerifOld" value="<?= $account->Password() ?>"/>
		</p>
		<p id="p_NewPass"> 
			<label for="NewPass">Nouveau mot de passe :</label><br/>
			<input type="password" name="NewPass" id="NewPass" />
		</p>
		<p id="p_RepPass"> 
			<label for="RepPass">Répéter Nouveau mot de passe :</label><br/>
			<input type="password" name="RepPass" id="RepPass" />
		</p>
		<p id="p_submit">
			<input id="submit" type="submit" value="Valider" />
		</p>
	</form>
</div>
	