<table class="tb_delete">
	
	<tr>
		<th>name</th>
		<td><?php echo $this->oHastags->name ?></td>
	</tr>

	<tr>
		<th>nb_post</th>
		<td><?php echo $this->oHastags->nb_post ?></td>
	</tr>

	<tr>
		<th>dateLastUse</th>
		<td><?php echo $this->oHastags->dateLastUse ?></td>
	</tr>

</table>

<form action="" method="POST">
<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

<input type="submit" value="Confirmer la suppression" /> <a href="<?php echo $this->getLink('hastags::list')?>">Annuler</a>
</form>

