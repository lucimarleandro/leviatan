<?php if (empty($classes)) { ?>
    <h3><?php echo __('Não há Classes dos Itens'); ?>
    <?php } else { ?>
        <div class="box-content">
            <table id="table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?php echo __('Código') ?></th>
                        <th><?php echo __('Nome'); ?></th>
                        <th><?php echo __('Grupo') ?></th>
                        <th><?php echo __('Ações'); ?></th>
                    </tr>
                </thead>	
                <tbody>
                    <?php foreach ($classes AS $class): ?>
                        <tr>
                            <td style="white-space: nowrap">
                                <?php
                                echo $class['ItemClass']['keycode'];
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Html->link(
                                        $class['ItemClass']['name'], array('controller' => 'item_classes', 'action' => 'view', $class['ItemClass']['id'])
                                );
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Html->link(
                                        $class['ItemGroup']['keycode-name'], array('controller' => 'item_groups', 'action' => 'view', $class['ItemGroup']['id'])
                                );
                                ?>
                            </td>
                            <td class="acoes">
                                <?php
                                echo $this->Html->link(
                                        $this->Html->image('edit'), array('controller' => 'item_classes', 'action' => 'edit', $class['ItemClass']['id']), array(
                                    'escape' => false,
                                    'alt' => 'Editar',
                                    'title' => 'Editar Classe do Item',
                                        )
                                );
                                echo $this->Form->postLink(
                                        $this->Html->image('delete'), array('controller' => 'item_classes', 'action' => 'delete', $class['ItemClass']['id']), array(
                                    'escape' => false,
                                    'alt' => 'Deletar',
                                    'title' => 'Deletar Classe do Item',
                                        )
                                );
                                ?>
                            </td>
                        </tr>
                            <?php endforeach; ?>
                </tbody>	
            </table>
        </div>	
    <?php
        echo $this->Paginator->options(
            array(
                'update' => '#items',
                'evalScript' => true
            )
        );
    
        echo $this->element('pagination'); 
    
    }
    ?>