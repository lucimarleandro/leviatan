<?php foreach($consolidated as $key=>$value): ?>
    <div style="margin-left:1,5cm; margin-right: 1,5cm">
        <table width="100%" style="margin-top: 40px;">
            <tr>
                <td align="left">Memo <?php echo $value[$key]['Solicitation']['memo_number'];?></td>
                <td align="right"><?php echo $this->Utils->full_date($value[$key]['Solicitation']['created']);?></td>
            </tr>
        </table>

        <p>
        DA: <?php echo $value[$key]['Sector']['name'].' - '.$value[$key]['Unity']['name'];?>
        <br>		
        PARA: <?php echo $value[$key]['SectorResponsible']['name'].' - '.$value[$key]['UnityResponsible']['name'];?>
        </p>

        <!-- descrição da solicitação-->
        <div style="text-align: justify; margin-top: 50px; line-height: 170%;">
            <?php echo $value[$key]['Solicitation']['description'];?>
        </div>

        <p align="center" style="margin-top: 60px;">Atenciosamente,</p>
        <!-- solicitante-->
        <p align="center" style="margin-top: 30px;"><?php echo $value[$key]['Employee']['name'].' '.$value[$key]['Employee']['surname'];?></p>
    </div>

    <!-- Pula página -->
    <div class="page-break"></div>
    
    <!-- Listagem dos itens-->
    <p style="margin-top: 70px;">
    Unidade: <?php echo $value[$key]['Unity']['name'];?>
    <br>
    Setor: <?php echo $value[$key]['Sector']['name'];?>
    <br>
    Nº do memorando: <?php echo $value[$key]['Solicitation']['memo_number'];?>
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





