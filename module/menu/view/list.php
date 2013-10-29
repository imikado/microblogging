<ul>
<?php foreach($this->tLink as $sLibelle => $tModule):?>
	<?php list($sModule,$sAction)=$tModule;?>
	<li <?php if(_root::getModule()==$sModule):?>class="selectionne"<?php endif;?>><a href="<?php echo _root::getLink($sModule.'::'.$sAction)?>"><?php echo $sLibelle?></a></li>
<?php endforeach;?>
	<li class="write"><a href="<?php echo _root::getLink('posts::new')?>"><img src="css/images/write.png" /></a></li>
	<li><a href="<?php echo _root::getLink('auth::logout')?>">[Se d&eacute;connecter]</a></li>
</ul>
