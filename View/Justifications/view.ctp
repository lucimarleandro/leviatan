 <div class="modal hide" id="myModal">
	<div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal">×</button>
    	<h3>Justificativa da negação</h3>
  	</div>
  	<div class="modal-body">
    	<?php 
    	echo $this->Form->Input('descritpion', array(
    			'label'=>false,
    			'disabled'=>true,
    			'class'=>'span5',
    			'rows'=>10,
    			'type'=>'textarea', 
    			'value'=>$justification['Justification']['description']
    		)
    	);
    	?>
  	</div>
  	<div class="modal-footer">
   		<a href="javascript:void(0)" class="btn" data-dismiss="modal">Fechar</a>
  	</div>
</div>