<?php $oPluginHtml=new plugin_html?>
<form action="" method="POST" >
<table class="tb_edit">
	
	<tr>
		<th>name</th>
		<td><input name="name" value="<?php echo $this->oHastags->name ?>" /><?php if($this->tMessage and isset($this->tMessage['name'])): echo implode(',',$this->tMessage['name']); endif;?></td>
	</tr>

	<tr>
		<th>nb_post</th>
		<td><input name="nb_post" value="<?php echo $this->oHastags->nb_post ?>" /><?php if($this->tMessage and isset($this->tMessage['nb_post'])): echo implode(',',$this->tMessage['nb_post']); endif;?></td>
	</tr>

	<tr>
		<th>dateLastUse</th>
		<td><input name="dateLastUse" value="<?php echo $this->oHastags->dateLastUse ?>" /><?php if($this->tMessage and isset($this->tMessage['dateLastUse'])): echo implode(',',$this->tMessage['dateLastUse']); endif;?></td>
	</tr>

</table>

<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

<input type="submit" value="Modifier" /> <a href="<?php echo $this->getLink('hastags::list')?>">Annuler</a>
</form>

