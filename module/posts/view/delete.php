<table class="tb_delete">
	
	<tr>
		<th>text</th>
		<td><?php echo $this->oPosts->text ?></td>
	</tr>

</table>

<form action="" method="POST">
<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

<input type="submit" value="Confirmer la suppression" /> <a href="<?php echo $this->getLink('posts::list')?>">Annuler</a>
</form>

