<form action="" method="POST">

	<table class="tbCenter">
		<tr>
			<th>Nom d'utilisateur</th>
			<td><input type="text" name="login" value="<?php echo _root::getParam('login')?>"/>
				<?php if($this->tMessage and isset($this->tMessage['login']))	:?>
					<p style="color:red"><?php echo implode(',',$this->tMessage['login'])?></p>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<th>Mot de passe</th>
			<td><input type="password" name="password"/>
				<?php if($this->tMessage and isset($this->tMessage['password']))	:?>
					<p style="color:red"><?php echo implode(',',$this->tMessage['password'])?></p>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<th>Repeter le mot de passe</th>
			<td><input type="password" name="password2"/></td>
		</tr>
		
		<tr>
			<td colspan="2" style="text-align:right"><a href="<?php echo _root::getLink('auth::login') ?>">Annuler</a> <input class="btn" type="submit" value="Enregistrer"/></td>
		</tr>
	</table>

</form>
