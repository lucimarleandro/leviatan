<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Itens', array('controller'=>'items', 'action'=>'index'));
$this->Html->addCrumb('Visualizar', array('controller'=>'items', 'action'=>'view', $item['Item']['id']));

echo $this->Html->link(
	$this->Html->image('back.png'),
	'javascript:window.history.go(-1)',
	array('escape'=>false)
);
?>
<div class="well">	
	<div class="page-header">
		<h3>ITEM</h3>
	</div>
	<dl class="dl-horizontal">
		<dt><?php echo __('Classe');?></dt>
		<dd>
			<?php 
			echo $this->Html->link(
				$item['ItemClass']['keycode'].' - '.$item['ItemClass']['name'],
				array('controller'=>'item_classes', 'action'=>'view', 'id'=>$item['ItemClass']['id'])
			);
			?>
		</dd>
		<dt><?php echo __('PNGC');?></dt>
		<dd><?php 
			echo $this->Html->link(
				$item['PngcCode']['keycode'].' - '.$item['InputCategory']['name'].($item['InputSubcategory']['name'] == null ? ' ' : ' - '.$item['InputSubcategory']['name']),
				array('controller'=>'pngc_codes', 'action'=>'view', 'id'=>$item['PngcCode']['id'])			
			);
			?>
		</dd>
		<dt><?php echo __('Código');?></dt>
		<dd><?php echo $item['Item']['keycode'];?></dd>
		<dt><?php echo __('Nome');?></dt>
		<dd><?php echo $item['Item']['name']?></dd>
		<dt><?php echo __('Descrição');?></dt>
		<dd><?php echo $item['Item']['description'];?></dd>
		<dt><?php echo __('Especifição');?></dt>
		<dd><?php echo $item['Item']['specification'];?></dd>
		<dt><?php echo __('Imagem')?></dt>
		<dd><?php echo $item['Item']['image_path'] == null ? $this->Html->image('no-image.png') : $this->Html->image('items'.DS.$item['Item']['image_path']);?></dd>
	</dl>	
</div>