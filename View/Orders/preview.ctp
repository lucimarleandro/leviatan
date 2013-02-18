<?php
echo $this->Html->link(
    $this->Html->image('back.png'),
    array('controller'=>'orders', 'action'=>'view', $data[0]['Order']['created']),
    array('escape'=>false, 'title'=>'Retornar')		
);
?>

<div id="preview-report">
    <div style="margin: 10px;"> 
        
        <!-- Cabeçalho -->
        <?php echo $this->element('pdf/header');?>
       
        <p style="margin-top:30px; margin-bottom: 20px; font-weight: bold; text-align: center;">Parecer</p>
        <?php echo $data[0]['Order']['opinion']; ?>

         <p align="center" style="margin-top: 60px;">Atenciosamente,</p>
        <!-- Homologador -->
        <p align="center" style="margin-top: 30px;"><?php echo $user['Employee']['name'].' '.$user['Employee']['surname'];?></p>
        
        <!-- Rodapé -->
        <?php echo $this->element('pdf/footer'); ?>
        
        <!-- Pula linha para mostrar descrição da solicitação -->
        <hr />
        
        <?php 
        foreach($data as $key=>$value):
        ?>
            <!-- Cabeçalho -->
            <?php echo $this->element('pdf/header');?>
            
            <div style="margin-left:1,5cm;margin-right: 1,5cm">

                <table width="100%" style="margin-top: 40px;">
                    <tr>
                        <td align="left">Memo <?php echo $value['Solicitation']['memo_number'];?></td>
                        <td align="right"><?php echo $this->Utils->full_date($value['Solicitation']['created']);?></td>
                    </tr>
                </table>

                <p style="margin-top: 50px;">
                    <b>DA:</b> <?php echo $value['Sector']['name'].' - '.$value['Unity']['name'];?>
                    <br>		
                    <b>PARA:</b> <?php echo $value['SectorResponsible']['name'].' - '.$value['UnityResponsible']['name'];?>
                </p>

                <!-- descrição da solicitação-->
                <div style="text-align: justify; margin-top: 50px; line-height: 170%;">
                        <?php echo strip_tags($value['Solicitation']['description']);?>
                </div>

                <p align="center" style="margin-top: 60px;">Atenciosamente,</p>
                <!-- solicitante-->
                <p align="center" style="margin-top: 30px;"><?php echo $value['Employee']['name'].' '.$value['Employee']['surname'];?></p>
                
                <!-- Rodapé -->
                <?php echo $this->element('pdf/footer'); ?>
            </div>

            <!-- Pula linha para listar os itens solicitados -->
            <hr />
            
            <!-- Cabeçalho -->
            <?php echo $this->element('pdf/header');?>
            
            <p style="padding-bottom: 10px;">
                <b>Unidade:</b> <?php echo $value['Unity']['name'];?>
                <br>
                <b>Setor:</b> <?php echo $value['Sector']['name'];?>
                <br>
                <b>Nº do memorando:</b> <?php echo $value['Solicitation']['memo_number'];?>
            </p>
            
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th style="white-space: nowrap;">Código</th>
                        <th>Nome</th>
                        <th align="center">Qtde</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($value['solicitation_items'] as $item):?>
                        <tr>
                            <td valign="middle" style="white-space: nowrap;"><?php echo $item['Item']['keycode'];?></td>
                            <td align="left"><?php echo $item['Item']['name'];?></td>
                            <td align="center" valign="middle"><?php echo $item['SolicitationItem']['quantity'];?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>	
            
            <!-- Rodapé -->
            <?php echo $this->element('pdf/footer'); ?>

            <!-- Anexo do memorando-->
            <?php 
            if($value['Solicitation']['attachment']) {
            ?>
                <!-- Pula página -->
                <hr />
                
                <!-- Cabeçalho -->
                <?php echo $this->element('pdf/header');?>

                <!-- Anexo -->
                <p style="margin-top: 70px;">
                <b>Unidade:</b> <?php echo $value['Unity']['name'];?>
                <br>
                <b>Setor:</b> <?php echo $value['Sector']['name'];?>
                <br>
                <b>Nº do memorando:</b> <?php echo $value['Solicitation']['memo_number'];?>
                </p>

                <div style="text-align: center; margin-top: 30px; font-weight: bold">Anexo</div>

                <!-- anexo da solicitação-->
                <div style="text-align: justify; margin-top: 50px; line-height: 170%;">
                    <?php echo $value['Solicitation']['attachment'];?>
                </div>    
                
                <!-- Rodapé -->
                <?php echo $this->element('pdf/footer');?>
            <?php
            }    
            ?>

            <hr />
        <?php
        endforeach;
        ?>
        
        <!-- Cabeçalho -->
        <?php echo $this->element('pdf/header');?>
        
        <!-- Consolidado -->
        <h3 style="text-align:left; padding-bottom:10px;">Consolidado</h3>
        <table class="table table-condensed table-bordered table-striped">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th colspan="2">Quantitativo</th>
                    <th>Total</th>	
                </tr>
            </thead>
            <tbody>
                <?php $amount = array();?>
                <?php foreach($consolidation as $key=>$item):?>
                    <?php $sum = 0;?>
                    <tr>
                        <td valign="middle" style="white-space: nowrap;"><?php echo $key;?></td>		
                        <td align="left"><?php echo $descriptions[$key]['name'];?></td>	
                        <td style="white-space: nowrap;">
                            <?php foreach($columns as $column): 
                                echo $column.'<br>';
                             endforeach;?>
                        </td>
                        <td>
                            <?php foreach($columns as $column): ?>
                                <?php if(array_key_exists($column, $item)) {?>
                                    <?php echo $item[$column].'<br>';?>                               
                                    <?php $sum += $item[$column];?>
                                <?php }else {?>
                                       <?php echo ' - <br>';?>
                                <?php }?>
                            <?php endforeach;?>
                            <?php $amount[$key] = $sum;?> 
                        </td>
                        <td align="center" valign="middle"><?php echo $sum;?></td>		
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <!-- Rodapé -->
        <?php echo $this->element('pdf/footer');?>

        <!--Pula linha -->
        <hr />

        <!-- Descrição dos itens -->
        
        <!-- Cabeçalho -->
        <?php echo $this->element('pdf/header');?>

        <h3 style="text-align:left; padding-bottom:10px;">Termo de Referência</h3>
        <table class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th style="white-space: nowrap;">Código</th>
                    <th>Descrição/Especificação</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($consolidation as $key=>$item):?>
                    <tr>
                        <td style="white-space: nowrap;"><?php echo $key;?></td>		
                        <td align="left">
                            <b>Descrição</b>
                            <br>
                            <div class="justify">
                            <?php echo strip_tags($descriptions[$key]['description']);?>
                            </div>
                            <br>
                            <b>Especificações complementares:</b>
                            <br>
                            <div class="justify">
                            <?php echo strip_tags($descriptions[$key]['specification']);?>
                            </div>
                        </td>
                        <td align="center"><?php echo $amount[$key];?></td>				
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        
        <!-- Rodapé -->
        <?php echo $this->element('pdf/footer');?>
    </div>
</div>
