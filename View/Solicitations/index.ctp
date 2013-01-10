<?php
$this->Html->addCrumb('Home', array('controller' => 'items', 'action' => 'home'));
$this->Html->addCrumb('Solicitações', array('controller' => 'solicitations', 'action' => 'index'));
?>
<?php if (empty($solicitations)) { ?>
    <h3><?php echo __('Não há solicitações'); ?>
<?php } else { ?>
    <div class="box-content">
        <table id="table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><?php echo __('Código'); ?></th>
                    <th><?php echo __('Nº do Memorando'); ?></th>
                    <th><?php echo __('Data'); ?></th>
                    <th><?php echo __('Situação'); ?></th>
                    <th><?php echo __('Ações'); ?></th>
                </tr>
            </thead>	
            <tbody>
                <?php foreach ($solicitations AS $solicitation): ?>
                    <tr>
                        <td><?php echo $solicitation['Solicitation']['keycode']; ?></td>
                        <td><?php echo $solicitation['Solicitation']['memo_number']; ?></td>
                        <td><?php echo $this->Time->format('d/m/Y', $solicitation['Solicitation']['created']); ?></td>
                        <td><?php echo $solicitation['Status']['name']; ?></td>
                        <td class="acoes">
                            <?php
                            echo $this->Html->link(
                                $this->Html->image('preview.png'), 
                                array('controller' => 'solicitations', 'action' => 'view', 'id' => $solicitation['Solicitation']['id']), 
                                array(
                                    'escape' => false,
                                    'alt' => 'Visualizar',
                                    'title' => 'Visualizar solicitação',
                                    'class' => 'view-solicitation'
                                )
                            );
                            echo $this->Html->link(
                                $this->Html->image('print.png'), 
                                array('controller'=>'solicitations', 'action'=>'printout', $solicitation['Solicitation']['id'], 'ext' => 'pdf'), 
                                array(
                                    'escape'=>false,
                                    'alt'=>'Imprimir',
                                    'title'=>'Imprimir solicitação',
                                    'class'=>'print-solicitation'
                                )                            
                            );
                            ?>
                        </td>
                    </tr>
                        <?php endforeach; ?>
            </tbody>	
        </table>
    </div>	
    <?php echo $this->element('pagination'); ?>
<?php } ?>
