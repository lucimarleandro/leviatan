<div class="pngcCodes form">
<?php echo $this->Form->create('PngcCode'); ?>
	<fieldset>
		<legend><?php echo __('Edit Pngc Code'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('keycode');
		echo $this->Form->input('expense_group_id');
		echo $this->Form->input('input_id');
		echo $this->Form->input('measure_type_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('PngcCode.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('PngcCode.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Pngc Codes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Expense Groups'), array('controller' => 'expense_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Expense Group'), array('controller' => 'expense_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Inputs'), array('controller' => 'inputs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Input'), array('controller' => 'inputs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Measure Types'), array('controller' => 'measure_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Measure Type'), array('controller' => 'measure_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Items'), array('controller' => 'items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Item'), array('controller' => 'items', 'action' => 'add')); ?> </li>
	</ul>
</div>
