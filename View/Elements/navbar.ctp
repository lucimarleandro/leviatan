<!-- Navbar	-->
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            	<span class="icon-bar"></span>
            	<span class="icon-bar"></span>
            	<span class="icon-bar"></span>
          	</button>
            <!-- Logotipo -->
          	<?php 
            echo $this->Html->link(
                'Motirõ', 
                array('plugin'=>false, 'admin'=>false, 'controller'=>'items', 'action'=>'home'), 
                array(
                    'class'=>'brand',
                )
            );
            ?>
          	<div class="nav-collapse">
          		<ul class="nav pull-right">
                    <li>
                        <?php echo $this->Html->link('<i class="icon-shopping-cart icon-white"></i>', array('controller'=>'cart_items', 'action'=>'index'), array('escape'=>false, 'style'=>'display:'.((isset($pendingCartItems) && !empty($pendingCartItems)) ? 'block' : 'none'))); ?>
                        
                    </li>
                    <li>                        
                        <?php echo $this->Html->link('<i class="icon-exclamation-sign icon-white"></i>', array('controller'=>'solicitations', 'action'=>'analyze'), array('escape'=>false, 'style'=>'display:'.(!empty($pendingSolicitationItems) ? 'block' : 'none')));?>
                    </li>
          			<?php if(isset($user)) {?>          				
	          			<li class="dropdown">
							<?php echo $this->Html->link(
								//'<i class="icon-user icon-white"></i>'.
								$user['Employee']['name'].
								'<b class="caret"></b>', 
								"#", 
								array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown', 'escape'=>false));
							?>							
							<ul class="dropdown-menu">
								<li>
									<?php echo $this->Form->postLink('<i class="icon-user"></i> Meu perfil', array('admin'=>false, 'plugin'=>false, 'controller'=>'users', 'action'=>'profile', $user['id']), array('escape'=>false));?>
								</li>
								<li class="divider"></li>
								<li>
									<?php echo $this->Html->link('<i class="icon-off"></i> Logout', array('admin'=>false, 'plugin'=>false, 'controller'=>'users', 'action'=>'logout'), array('escape'=>false))?>
								</li>
							</ul>
						</li>
          			<?php }else {?>
						<li>
							<?php echo $this->Form->create('User', array('url'=>'/users/login','class'=>'form-horizontal'));?>
								<?php echo $this->Form->input('username', array('label'=>false, 'class'=>'input-small', 'div'=>false))?>
								<?php echo $this->Form->input('password', array('label'=>false, 'class'=>'input-small', 'div'=>false))?>
								<?php echo $this->Form->Button('<i class="icon-play-circle icon-white"></i>Entrar', array('class'=>'btn btn-primary'));?>									
							<?php echo $this->Form->end();?>
						</li>
          			<?php }?>
          		</ul>
          	</div>
		</div>
	</div>
</div>