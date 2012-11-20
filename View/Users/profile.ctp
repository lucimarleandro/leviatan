<?php
$this->Html->addCrumb('Usuários', '/users/');
$this->Html->addCrumb('Perfil', '/users/profile/'.$profile['User']['id']);
 
echo $this->Html->link(
	$this->Html->image('back'),
	array('controller'=>'items', 'action'=>'home'),
	array('escape'=>false)		
);
?>
<div class="well">
	<?php echo $this->Form->create('User', array('class'=>'form-horizontal')); ?>
		<?php echo $this->Form->input('user_id', array('type'=>'hidden', 'value'=>$profile['User']['id']));?>
		<?php echo $this->Form->input('employee_id', array('type'=>'hidden', 'value'=>$profile['Employee']['id']));?>
		<fieldset>
			<legend>Editar perfil</legend>
			<div class="control-group">
				<label class="control-label" for="Matrícula">Matrícula</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('registration', 
						array(
							'label'=>false, 
							'class'=>'input-small',
							'value'=>$profile['Employee']['registration'],
							'disabled'=>true
						)
					);
					?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="Nome do usuário">Nome</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('name', 
						array(
							'label'=>false, 
							'class'=>'input-xlarge',
							'value'=>$profile['Employee']['name'].' '.$profile['Employee']['surname'],
							'disabled'=>true
						)
					);
					?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="Telefone">Telefone</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('phone', 
						array(
							'label'=>false, 
							'class'=>'input',
							'value'=>$profile['Employee']['phone']
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Email">Email</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('email', 
						array(
							'label'=>false, 
							'class'=>'input-xlarge',
							'value'=>$profile['Employee']['email']
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Nova senha">Nova senha</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('new_password', 
						array(
							'label'=>false, 
							'class'=>'input-small',
							'type'=>'password'
						)
					);
					?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="Confirma senha">Confirma senha</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('confirm_password', 
						array(
							'label'=>false, 
							'class'=>'input-small',
							'type'=>'password'
						)
					);
					?>
				</div>
			</div>			
			<div class="form-actions">
				<?php echo $this->Form->button('Enviar', array('class'=>'btn btn-primary', 'type'=>'submit'));?>
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'items', 'action'=>'home'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>

<script>

$('#UserPhone').mask('(99)9999-9999', {placeholder:" ", completed:function(){$('.mask-phone').unmask()}}); //telefone

$('#UserProfileForm').validate({
	ignore: "",
	rules: {
		'data[User][birth_date]': {
		    required: true
		},
		'data[User][phone]': {
		    required: true
		},
		'data[User][email]': {
			required: true,
		    email: true
		},
		'data[User][new_password]': {
			minlength: 6
		},
		'data[User][confirm_password]':{
			equalTo: "#UserNewPassword"
		}
	},
	messages: {
		'data[User][birth_date]': {
		    required: "Campo obrigatório"
		},
		'data[User][phone]': {
		    required: "Campo obrigatório"
		},
		'data[User][email]': {
			required: "Campo obrigatório",
		    email: 'Email inválido'
		},
		'data[User][new_password]': {
			minlength: 'Mínimo de 6 caracteres'
		},
		'data[User][confirm_password]':{
			equalTo: 'Senhas não conferem'
		}
	},
	highlight: function(label) {
		$(label).closest('.control-group').addClass('error');
	},
	success: function(label) {
		label
		.text('OK!').addClass('valid')
		.closest('.control-group').addClass('success');
	},
	errorPlacement: function(label, element) {
		// position error label after generated textarea
		if (element.is("textarea")) {
			label.insertAfter(element.next());
		} else {
			label.insertAfter(element)
		}
	}
});
</script>