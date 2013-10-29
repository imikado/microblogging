<?php $oPluginHtml=new plugin_html?>
<form action="" method="POST" >

<p><strong>Votre post</strong></p>
<textarea name="text" style="width:680px;height:100px"></textarea><?php if($this->tMessage and isset($this->tMessage['text'])): echo implode(',',$this->tMessage['text']); endif;?>
		
		

<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

<p style="text-align:right;margin-right:15px"><input class="btn" type="submit" value="Ajouter" /> <a href="<?php echo $this->getLink('posts::list')?>">Annuler</a></p>
</form>

