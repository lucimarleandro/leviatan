<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<base href="<?php echo $this->Html->url('/', true);?>" />
	
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo 'Motirõ' ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="device-width, initial-scale=1.0">
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array('bootstrap', 'bootstrap-responsive'));
		echo $this->Html->css(array('jquery-ui-1.9.0.custom'));
		echo $this->Html->css(array('leviatan', 'chosen'));
		
		echo $this->Html->script(array('jquery-1.8.0.min', 'jquery-ui-1.9.0.custom.min', 
				'jquery.validate.min', 'jquery.maskedinput-1.3.min', 'chosen.jquery.min'));
		echo $this->Html->script(array('functions'));
		echo $this->Html->script(array('bootstrap.min'));
        
		echo $this->fetch('script');
		echo $this->fetch('meta');
		echo $this->fetch('css');		
	?>	
</head>
<body data-target=".bs-docs-sidebar" data-spy="scroll" data-twttr-rendered="true">
	<div class="modal1"></div>
	<?php echo $this->element('navbar');?>

    <!--		-->
	<div style="padding:25px 0;">	
	</div>
    <!-- -->
    
    <!-- Breadcrumb -->
    <div class="row affix">
        <div class="span12">
        <?php
        echo $this->Html->getCrumbList(array('id'=>'breadcrumb'));
        ?>
        </div>
    </div>
    
    <!-- -->
    <div style="padding:25px 0;">	
	</div>
    <!-- -->
	
    <div id="alert-message">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->Session->flash('auth'); ?>
	</div>	
	<div class="container">
        
		<div class="row">
			<?php echo $this->element('menu');?>
			<?php echo $this->element('content');?>	
		</div>
	</div>	
	<?php //echo $this->element('sql_dump');?>
	<script>
	$(document).ready(function() {
		$('.menu li a').click(function(e) {	
			jQuery.each($('.menu li'), function(i, val) {
				$(this).removeClass('active');	
			});
			
		  	var $this = $(this).parent();
		  	if (!$this.hasClass('active')) {
		    	$this.addClass('active');
		  	}
		});
	});

	$("body").on({		
	    // When ajaxStart is fired, add 'loading' to body class
	    ajaxStart: function() {
		    if(!noLoading) {		    
	        	$(this).addClass("loading");
		    }else { 
				noLoading = false;
		    }
	    },
	    // When ajaxStop is fired, rmeove 'loading' from body class
	    ajaxStop: function() {
	        $(this).removeClass("loading");
	    }    		
	});
	</script>
	<?php if(class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) echo $this->Js->writeBuffer(); ?>
</body>
</html>
