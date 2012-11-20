<div class="pagination pagination-right">
	<div style="margin-bottom: 10px;">
		<?php 
		echo $this->Paginator->counter(
	    'Página {:page} de {:pages}, mostrando {:current} registros de
	     {:count}, iniciando no registro {:start}, terminando no {:end}'	
		);?>
	</div>
	<ul>
		<li>
			<?php echo $this->Paginator->first('Início'); ?>
		</li>
		<li>
			<?php echo $this->Paginator->prev('« Anterior', null, null, array('class' => 'disabled')) ?>
		</li>
		<li>	
			<?php echo str_replace( '|', '</li><li>', $this->Paginator->numbers()) ?>
		</li>
		<li>
			<?php echo $this->Paginator->next(' Próximo »', null, null, array('class' => 'next disabled')) ?>
		</li>
		<li>
			<?php echo $this->Paginator->last('Fim'); ?>
		</li>
	</ul>
</div>