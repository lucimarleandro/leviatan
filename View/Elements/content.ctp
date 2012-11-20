<!-- conteúdo	-->
<div class="span9">
	<?php
	echo $this->Html->getCrumbList(array('id'=>'breadcrumb'), array(
		'text' => $this->Html->image('breadcrumb/home.gif', array('class'=>'home')),
		'url' => array('controller'=>'items', 'action'=>'home', 'admin'=>false, 'plugin'=>false),
		'escape' => false 
	));
	?>
	<?php echo $this->fetch('content');?>				
</div>