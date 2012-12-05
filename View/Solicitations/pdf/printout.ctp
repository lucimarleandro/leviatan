<?php foreach($consolidated as $key=>$value): ?>
    <div style="margin-left:1,5cm; margin-right: 1,5cm">
        <table width="100%" style="margin-top: 40px;">
            <tr>
                <td align="left">Memo <?php echo $value[0]['Solicitation']['memo_number'];?></td>
                <td align="right"><?php echo $this->Utils->full_date($value[0]['Solicitation']['created']);?></td>
            </tr>
        </table>

        <p>
        DA: <?php echo $value[0]['Sector']['name'].' - '.$value[0]['Unity']['name'];?>
        <br>		
        PARA: <?php echo $value[0]['SectorResponsible']['name'].' - '.$value[0]['UnityResponsible']['name'];?>
        </p>

        <!-- descrição da solicitação-->
        <div style="text-align: justify; margin-top: 50px; line-height: 170%;">
            <?php echo $value[0]['Solicitation']['description'];?>
        </div>

        <p align="center" style="margin-top: 60px;">Atenciosamente,</p>
        <!-- solicitante-->
        <p align="center" style="margin-top: 30px;"><?php echo $value[0]['Employee']['name'].' '.$value[0]['Employee']['surname'];?></p>
    </div>

    <!-- Pula página -->
    <div class="page-break"></div>
    
    <!-- Listagem dos itens-->
    <p style="margin-top: 70px;">
    Unidade: <?php echo $value[0]['Unity']['name'];?>
    <br>
    Setor: <?php echo $value[0]['Sector']['name'];?>
    <br>
    Nº do memorando: <?php echo $value[0]['Solicitation']['memo_number'];?>
    </p>

    <table class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th>Código</th>
                <th>Item</th>
                <th>Quantidade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($value as $item):?>
            <tr>
                <td align="center" style="white-space: nowrap;"><?php echo $item['Item']['keycode'];?></td>
                <td><?php echo $item['Item']['name'];?></td>
                <td align="center" valign="middle"><?php echo $item['SolicitationItem']['quantity'];?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    
    <!-- Pula página -->
    <div class="page-break"></div>
<?php endforeach; ?>





