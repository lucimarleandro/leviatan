<?php 
foreach($data as $key=>$value):
?>
	<div style="margin-left:1,5cm;margin-right: 1,5cm">
		<!-- Cabeçalho -->
		<?php echo $this->element('pdf/header');?>
		
		<table width="100%" style="margin-top: 40px;">
			<tr>
				<td align="left">Memo <?php echo $value['Solicitation']['memo_number'];?></td>
				<td align="right"><?php echo $this->Utils->full_date($value['Solicitation']['created']);?></td>
			</tr>
		</table>
		
		<p>
		DA: <?php echo $value['Sector']['name'];?>
		<br>		
		PARA: Núcleo de Engenharia Clínica
		</p>
		
		<!-- descrição da solicitação-->
		<div style="text-align: justify; margin-top: 50px; line-height: 170%;">
		 	<?php echo strip_tags($value['Solicitation']['description']);?>
		</div>
		
		<p align="center" style="margin-top: 60px;">Atenciosamente,</p>
		<!-- solicitante-->
		<p align="center" style="margin-top: 30px;"><?php echo $value['Employee']['name'].' '.$value['Employee']['surname'];?></p>
	</div>
	
	<!-- Rodapé -->
	<?php echo $this->element('pdf/footer');?>
	
	<!-- Pula linha para listar os itens solicitados -->
	<div class="page-break"></div>
	
	<!-- Cabeçalho -->
	<?php echo $this->element('pdf/header');?>
	
	<p style="padding-bottom: 10px;">
	Unidade: <?php echo $value['Unity']['name'];?>
	<br>
	Setor: <?php echo $value['Sector']['name'];?>
	<br>
	Nº do memorando: <?php echo $value['Solicitation']['memo_number'];?>
	</p>
	
	<div>
		<div style="border: 1px solid #000;">
			<div style="width: 13%; display: inline-block; text-align: center; border-right: 1px solid #000;">Código</div>
			<div style="width: 69%; display: inline-block; text-align: center; border-right: 1px solid #000;">Nome</div>
			<div style="width: 15%; display: inline-block; text-align: center;">Qtde</div>				
		</div>		
		<div>
			<?php foreach($value['solicitation_items'] as $item):?>
				<div style="border: 1px solid #000;">
					<div style="width: 13%; display: inline-block; text-align: center; border-right: 1px solid #000;">
						<?php echo $item['Item']['keycode'];?>
					</div>
					<div style="width: 69%; display: inline-block; text-align: center; border-right: 1px solid #000;">
						<?php echo $item['Item']['name'];?>
					</div>
					<div style="width: 15%; display: inline-block; text-align: center;">
						<?php echo $item['SolicitationItem']['quantity'];?>					
					</div>	
				</div>
			<?php endforeach;?>
		</div>	
	</div>
	
	<!-- Rodapé -->
	<?php echo $this->element('pdf/footer');?>
	<div class="page-break"></div>
<?php
endforeach;
?>

<!-- Cabeçalho -->
<?php echo $this->element('pdf/header');?>
<!-- Consolidado -->
<h3 style="text-align:left; padding-bottom:10px;">Consolidado</h3>

<table class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th>Código</th>
			<th>Nome</th>
			<?php foreach($columns as $column): ?>
				<th><?php echo $column;?></th>
			<?php endforeach;?>
			<th>Total</th>	
		</tr>
	</thead>
	<tbody>
		<?php $amount = array();?>
		<?php foreach($consolidation as $key=>$item):?>
			<?php $sum = 0;?>
			<tr>
				<td valign="middle" style="white-space: nowrap;"><?php echo $key;?></td>		
				<td align="left"><?php echo $descriptions[$key]['name'];?></td>				
				<?php foreach($columns as $column): ?>
					<?php if(array_key_exists($column, $item)) {?>
						<td align="center" valign="middle"><?php echo $item[$column];?></td>
						<?php $sum += $item[$column];?>
					<?php }else {?>
						<td align="center" valign="middle"> - </td>
					<?php }?>
				<?php endforeach;?>
				<?php $amount[$key] = $sum;?>
				<td align="center" valign="middle"><?php echo $sum;?></td>		
			</tr>
		<?php endforeach;?>
	</tbody>
</table>
<!-- Rodapé -->
<?php echo $this->element('pdf/footer');?>
<div class="page-break"></div>

<!-- Descrição dos itens -->
<!-- Cabeçalho -->
<?php echo $this->element('pdf/header');?>

<h3 style="text-align:left; padding-bottom:10px;">Termo de Referência</h3>

	<div>
		<div style="border: 1px solid #000; overflow: hidden;">
			<div style="width: 13%; float: left; text-align: center; border-right: 1px solid #000;">Código</div>
			<div style="width: 69%; float: left; text-align: center; border-right: 1px solid #000;">Descrição/Especificação</div>
			<div style="width: 15%; float: left; text-align: center;">Total</div>				
		</div>		
		<div>
			<?php foreach($consolidation as $key=>$item):?>
				<div style="border: 1px solid #000; overflow: hidden;">
					<div style="width: 13%; float:left; text-align: center; padding: 50% 0;">
						<?php echo $key;?>
					</div>
					<div style="width: 69%; float:left; text-align: center; border: 1px solid #000;">
						<b>Descrição</b>
						<br>
						<div style="text-align: justify;">
						<?php echo strip_tags($descriptions[$key]['description']);?>
						</div>
						<br>
						<b>Especificações complementares:</b>
						<br>
						<div style="text-align: justify;">
						<?php echo strip_tags($descriptions[$key]['specification']);?>
						</div>
					</div>
					<div style="width: 15%; float:left; text-align: center; padding: 50% 0;">
						<?php echo $amount[$key];?>			
					</div>	
				</div>
			<?php endforeach;?>
		</div>	
	</div>
<!-- Rodapé -->
<?php echo $this->element('pdf/footer');?>