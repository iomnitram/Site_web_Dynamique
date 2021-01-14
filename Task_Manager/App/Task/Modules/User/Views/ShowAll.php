<?php
	$aside = '	<div class="count">
					<p class="count_Priv">Total</p><p>' . $NbAccount_Total . '</p>
				</div>
				<div class="count">
					<p class="count_Priv">Staff</p><p>' . $NbAccount_Staff . '</p>
				</div>
				<div class="count">
					<p class="count_Priv">Travailleur</p><p>' . $NbAccount_Trav . '</p>
				</div>
				<div class="count">
					<p class="count_Priv">Client</p><p>' . $NbAccount_Client . '</p>
				</div>';

?>

<?php
		foreach ($ListAccount as $acc) {
			?>
				<article>
					<div class="acc_Name">
						<?= $acc->FirstName() . ' ' . $acc->Name() ?>
						
					</div>
					<div class="acc_Priv">
						<?php
							if($acc->Privileges()->Admin())
								echo "<p>Admin</p>";
							if($acc->Privileges()->Staff())
								echo "<p>Staff</p>";
							if($acc->Privileges()->Trav())
								echo "<p>Travailleur</p>";
							if($acc->Privileges()->Client())
								echo "<p>Client</p>";
						?>
					</div>
					<div class="acc_Space">
					</div>
					<div class="acc_Config">
						<a id="Header_User_Param"href="/Setting?Account= <?= $acc->id() ?>"><img src="http://task_manager.com/img/parametre.png"></a>
					</div>
					
				</article>
			<?php
		}
?>
