<div class="login-form inline-form div-450">
    <?php
    echo $this->Form->create('User', array());
        echo $this->Form->input('username', array(
            'label' => 'Usuário'
        ));
        echo $this->Form->input('password', array(
            'label' => 'Senha',
            'type' => 'password'
        ));
        ?>

        <div class="submit">
            <?php echo $this->Form->submit('Autenticar', array('div' => false)); ?>
            <?php echo $this->Html->link('Esqueceu a senha?', 'javascript:;', array('style' => 'font-size: .85em')); ?>
        </div>    
    <?php echo $this->Form->end(); ?>
</div>