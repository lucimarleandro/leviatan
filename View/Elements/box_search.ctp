<div class="box-search">
	<?php echo $this->Form->create('Item', array('class'=>'well'));?>
		<?php echo $this->Form->input('complete', array('type'=>'hidden', 'value'=>$complete))?>
		<?php echo $this->Form->input('item_group_id', array('div'=>false, 'label'=>'Grupo', 'type'=>'select', 'class'=>'span6', 'options'=>$groups));?>
		<?php echo $this->Form->input('item_class_id', array('div'=>false, 'label'=>'Classe', 'type'=>'select', 'class'=>'span6', 'options'=>array(''=>'Selecione um grupo')));?>
		<?php echo $this->Form->input('item_name', array('label'=>'Nome', 'type'=>'text', 'class'=>'span6'));?>
		<?php echo $this->Form->button('Filtrar', array('type'=>'button', 'class'=>'btn btn-primary', 'id'=>'filter-items'));?>
	<?php echo $this->Form->end();?>
</div>
