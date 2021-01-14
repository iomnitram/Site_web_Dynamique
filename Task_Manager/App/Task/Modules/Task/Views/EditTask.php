
<div id="blocEdit">
	<h2><?= $title_form?></h2>
	<?php
		if(isset($Task_error))
			echo "<p id='InfoError'>" . $Task_error . "</p>";
		if(isset($Task_Validation))
			echo "<p id='InfoValidation'>" . $Task_Validation . "</p>";
	?>

	<form id="form_task" name="task" method="post" action="">
		<p id="p_id">
			<input type="number" name="i_id" value="<?= $Task->id() ?>" style="display: none"/>
		</p>
		<p id="p_Name">
			<label for="i_Name">Nom :</label><br/>
			<input type="text" name="i_Name" id="i_Name" value="<?= $Task->Name() ?>"/>
		</p>
		<p id="p_Desc"> 
			<label for="i_Desc">Description :</label><br/>
			<textarea name="i_Desc" id="i_Desc"><?= $Task->Description() ?></textarea>
		</p>

		<p id="p_Done">
			<input type="checkbox" name="i_Done" id="i_Done" <?= ($Task->Done()?"checked":"") ?> /> <label for="i_Done">Términée</label>
		</p>
		
		<p id="p_submit_task">
			<input id="i_submit_task" type="submit" value="Valider" />
		</p>
	</form>

	<?php
		if(isset($EditClient) && $EditClient == true)
		{
			?>
			<div class="div_opt" id="part_client">
				<h3>Clients</h3>
				<div class="add_del">
					<form method="post" action="">
						<input type="number" name="i_id" value="<?= $Task->id() ?>" style="display: none"/>
						<p>
							<label for="delClient">Enlever un Client</label><br />
							<select name="delClient" id="newClient">
								<?php
									foreach ($Clients as $Client) {
										echo '<option value=' . $Client->id() . '>' . $Client->Name() . ' ' . $Client->FirstName()  . '</option>';
									}
								?>
							</select>
						</p>
						<p id="p_submit_Client">
							<input id="i_submit_Client" type="submit" value="Supprimer" />
						</p>
					</form>


					<form method="post" action="">
						<input type="number" name="i_id" value="<?= $Task->id() ?>" style="display: none"/>
						<p>
							<label for="newClient">Ajouter un Client</label><br />
							<select name="newClient" id="newClient">
								<?php
									foreach ($Not_Clients as $Client) {
										echo '<option value=' . $Client->id() . '>' . $Client->Name() . ' ' . $Client->FirstName()  . '</option>';
									}
								?>
							</select>
						</p>
						<p id="p_submit_Client">
							<input id="i_submit_Client" type="submit" value="Ajouter" />
						</p>
					</form>
				</div>
			</div>
			<?php
		}
		if(isset($EditTrav) && $EditTrav == true)
		{
			?>
			<div class="div_opt" id="part_Trav">
				<h3>Travailleurs</h3>
				<div class="add_del">
					<form id="form_Trav" name="Trav" method="post" action="">
						<input type="number" name="i_id" value="<?= $Task->id() ?>" style="display: none"/>
						<p>
							<label for="delTrav">Enlever un Travailleur</label><br />
							<select name="delTrav" id="newTrav">
								<?php
									foreach ($Travs as $Trav) {
										echo '<option value=' . $Trav->id() . '>' . $Trav->Name() . ' ' . $Trav->FirstName()  . '</option>';
									}
								?>
							</select>
						</p>
						<p id="p_submit_Trav">
							<input id="i_submit_Trav" type="submit" value="Supprimer" />
						</p>
					</form>

					<form id="form_Trav" name="Trav" method="post" action="">
						<input type="number" name="i_id" value="<?= $Task->id() ?>" style="display: none"/>
						<p>
							<label for="newTrav">Ajouter un Travailleur</label><br />
							<select name="newTrav" id="newTrav">
								<?php
									foreach ($Not_Travs as $Trav) {
										echo '<option value=' . $Trav->id() . '>' . $Trav->Name() . ' ' . $Trav->FirstName()  . '</option>';
									}
								?>
							</select>
						</p>
						<p id="p_submit_Trav">
							<input id="i_submit_Trav" type="submit" value="Ajouter" />
						</p>
					</form>
				</div>
			</div>
			<?php
		}
		?>	
</div>