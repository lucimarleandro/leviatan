<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <base href="<?php echo $this->Html->url('/', true);?>" />

        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo 'Leviatan' ?>:
            <?php echo 'Manutenção' ?>
        </title>
        <meta name="viewport" content="device-width, initial-scale=1.0">
        <?php
            echo $this->Html->meta('icon');
            echo $this->Html->css(array('bootstrap', 'bootstrap-responsive'));
            echo $this->Html->css(array('leviatan'));

            echo $this->Html->script(array('bootstrap.min'));

            echo $this->fetch('script');
            echo $this->fetch('meta');
            echo $this->fetch('css');		
        ?>	
    </head>
    <body data-target=".bs-docs-sidebar" data-spy="scroll" data-twttr-rendered="true">
        <div class="modal1"></div>
        <div class="container">
            <div class="row">
                <div class="span9">
                    <h3>Sistema em manutenção</h3>
                </div>
            </div>
        </div>	

        <?php if(class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) echo $this->Js->writeBuffer(); ?>
    </body>
</html>