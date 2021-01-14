<?php
	foreach ($ListTasks as $task) {
			?>
				<article class="task">
					<div class="task_Resume">
						<div class="task_Name">
							<?= $task->Name() ?>
						</div>
						<div class="Space_Between"></div>
						<div class="task_Crea">
							<p>Créé le 10/01/2020 à 12h30</p>
						</div>
						<div class="task_Devlop">
							<img class="img_Devlop" src="http://task_manager.com/img/deroule.png"/>
						</div>
					</div>
					<div class="task_MoreInfo">
						<div class="task_Desc">
							<?= $task->Description() ?>
						</div>
						<div class="task_Client">
							<p>Clients</p>
							<ul>
								<li>Client 1</li>
								<li>Client 2</li>
							</ul>
						</div>
						<div class="task_Setting">
							<a href="/EditTask?Task=<?= $task->id() ?>" >
								<img src="http://task_manager.com/img/parametre.png"/>
							</a>
						</div>
					</div>
				</article>
			<?php
		}
?>