<?php $oPluginHtml=new plugin_html?>
<form action="" method="POST"  enctype="multipart/form-data">

<div style="background:#ddd;width:676px;margin:10px;border:1px solid #ccc;">

	<div style="margin:auto;width:100px;background:#fff;margin-top:20px;border:2px solid #ccc"><img style="width:100px" src="<?php echo $this->oMembers->picture ?>"/><br/>
	<input type="file" name="picture" /><?php if($this->tMessage and isset($this->tMessage['picture'])): echo implode(',',$this->tMessage['picture']); endif;?>
	</div>


	<p style="text-align:center;font-weight:bold;font-size:14px">Shortname <input name="shortname" value="<?php echo $this->oMembers->shortname ?>" /><?php if($this->tMessage and isset($this->tMessage['shortname'])): echo implode(',',$this->tMessage['shortname']); endif;?></p>

	<p style="text-align:center;font-size:14px">@<?php echo $this->oMembers->login ?></p>


	<p style="text-align:center">Description <input name="description" value="<?php echo $this->oMembers->description ?>" /><?php if($this->tMessage and isset($this->tMessage['description'])): echo implode(',',$this->tMessage['description']); endif;?></p>

	<input type="hidden" name="token" value="<?php echo $this->token?>" />
	<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

	<p style="text-align:right;margin:10px"><input class="btn" type="submit" value="Modifier" /> <a href="<?php echo $this->getLink('profil::index')?>">Annuler</a></p>

</div>

<table class="profil">
	<tr>
		<td>
			<strong><?php echo $this->oMembers->nb_posts?></strong>
			<br />POSTS</td>
		<td>
			<strong><?php echo $this->oMembers->nb_followers?></strong>
			<br />ABONNES</td>
		<td style="width:450px">
			<strong><?php echo $this->oMembers->nb_subscriptions?></strong>
			<br />ABBONNEMENTS</td>
	</tr>
</table>


</form>

