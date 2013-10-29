<form action="" method="POST">
	<table class="tbCenter">
		<tr>
			<th>Utilisateur</th>
			<td><input type="text" name="login" autocomplete="off"/></td>
		</tr>
		<tr>
			<th>Mot de passe</th>
			<td><input type="password" name="password" /></td>
		</tr>
		
		<tr>
			<td colspan="2" style="text-align:right"><input class="btn" type="submit" value="S'authentifier"/></td>
		</tr>
	</table>
</form>

<?php if($this->sMessage):?>
	<p style="color:red"><?php echo $this->sMessage ?></p>
<?php endif;?>

<p style="text-align:right;margin-right:15px"><a href="<?php echo _root::getLink('auth::inscription') ?>">Inscription</a></p>
