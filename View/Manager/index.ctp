<?php 
$this->Html->addCrumb('Gerência', '/manager/');
?>
<div class="row-fluid">
    <ul>
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'Usuários', 
                array('controller'=>'users', 'action'=>'index')	
            );
            ?>
        </li>
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'Funcionários', 
                array('controller'=>'employees', 'action'=>'index')	
            );
            ?>
        </li>
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'Unidades-Setores', 
                array('controller'=>'unity_sectors', 'action'=>'index')	
            );
            ?>
        </li>
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'Setores', 
                array('controller'=>'sectors', 'action'=>'index')	
            );
            ?>
        </li>
    </ul>
    <ul>
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'Unidades', 
                array('controller'=>'unities', 'action'=>'index')	
            );
            ?>
        </li>
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'Tipos de unidades', 
                array('controller'=>'unity_types', 'action'=>'index')	
            );
            ?>
        </li>
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'Distritos Sanitários', 
                array('controller'=>'health_districts', 'action'=>'index')	
            );
            ?>
        </li>	
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'Tipos de Grupos', 
                array('controller'=>'group_types', 'action'=>'index')	
            );
            ?>
        </li>	
    </ul>
    <ul>
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'Grupos dos Itens', 
                array('controller'=>'item_groups', 'action'=>'index')	
            );
            ?>
        </li>
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'Classes dos Itens', 
                array('controller'=>'item_classes', 'action'=>'index')	
            );
            ?>
        </li>
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'Tipos de Medidas', 
                array('controller'=>'measure_types', 'action'=>'index')	
            );
            ?>
        </li>	
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'Grupos de Gastos', 
                array('controller'=>'expense_groups', 'action'=>'index')	
            );
            ?>
        </li>	
    </ul>
    <ul>
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'Insumos', 
                array('controller'=>'inputs', 'action'=>'index')	
            );
            ?>
        </li>
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'Categoria de Insumos', 
                array('controller'=>'input_categories', 'action'=>'index')	
            );
            ?>
        </li>
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'Subcat. de insumos ', 
                array('controller'=>'input_subcategories', 'action'=>'index')	
            );
            ?>
        </li>	
        <li class="span3 well">
            <?php 
            echo $this->Html->link(
                'PNGC', 
                array('controller'=>'pngc_codes', 'action'=>'index')	
            );
            ?>
        </li>	
    </ul>
    <ul>
        <li class="span3 well">
           <?php 
            echo $this->Html->link(
                'Unidade-Classe', 
                array('controller'=>'head_orders', 'action'=>'index')	
            );
            ?>
        </li>
    </ul>
</div>