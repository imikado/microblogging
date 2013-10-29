<h1>Hashtags</h1>
<table class="tb_posts">
	
	<?php if($this->tHastags):?>
	<?php foreach($this->tHastags as $oHastags):?>
	<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
		
		<td><strong><a href="<?php echo _root::getLink('hashtags::show',array('name'=>$oHastags->name))?>">#<?php echo $oHastags->name ?></a></strong>
			<br /><strong><?php echo $oHastags->nb_posts ?></strong> TWEETS <br/>
				<i>dernier tweet le <?php echo $oHastags->dateLastUse ?></i>
			</td>


		
	</tr>	
	<?php endforeach;?>
	<?php endif;?>
</table>

