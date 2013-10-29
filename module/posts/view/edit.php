<?php $oPluginHtml=new plugin_html?>
<form action="" method="POST" >
<table class="tb_edit">
	
	<tr>
		<th>text</th>
		<td><input name="text" value="<?php echo $this->oPosts->text ?>" /><?php if($this->tMessage and isset($this->tMessage['text'])): echo implode(',',$this->tMessage['text']); endif;?></td>
	</tr>

</table>

<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

<input type="submit" value="Modifier" /> <a href="<?php echo $this->getLink('posts::list')?>">Annuler</a>
</form>

