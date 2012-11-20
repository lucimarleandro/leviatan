<?php if(!$ajax) {?>
<div class="box">
	<?php echo $this->element('box_search');?>
	<?php echo $this->Form->input('url', array('type'=>'hidden', 'id'=>'url', 'value'=>'/items/home'));?>
	<div id="items">
		<?php echo $this->element('ajax/items/home');?>
	</div>
</div>
<?php }else {
	echo $this->element('ajax/items/home');
}?>
