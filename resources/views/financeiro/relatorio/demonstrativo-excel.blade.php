<?php $url_base = getenv('URL_BASE_FIN'); ?>
<?php


function array_sort1($array, $on, $order=SORT_ASC){
        
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}
?>
<?php
$nome_arquivo = 'demonstrativo-financeiro__'.md5(uniqid(time())).'.xls';

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"$nome_arquivo\"" );
?>

    
@if(isset($demonstrativo) AND count($demonstrativo))

<table id="example11" class="table table-bordered table-striped">
    <thead>
        <tr style="background-color: #000000; color: #ffffff;">
            <th width="20%"></th>
            @foreach($data_previsao as $data)
            <th width="10%">{{ $meses[$data] }}</th>
            @endforeach
            <th>Totais</th>
        </tr>
    </thead>
    <tbody>

        @foreach($demonstrativo['entrada_saida'] as $item2)
        @if(count($item2))
        <tr style="background-color: #bf9000; color: #ffffff;">
            <th>{{ $item2['nome'] }}</th>
            @foreach($data_previsao as $data)
            <th>
                @if(isset($demonstrativo['entrada_saida'][$item2['tipo']]['subtotal'][$data]))
                {{  number_format($demonstrativo['entrada_saida'][$item2['tipo']]['subtotal'][$data], 2, ',', '.') }}
                @else
                {{ number_format(0, 2, ',', '.') }}
                @endif
            </th>
            @endforeach
            <th>{{  number_format($demonstrativo['entrada_saida'][$item2['tipo']]['subtotal1'], 2, ',', '.') }}</th>
        </tr>
        <?php
        $item2_plano_conta = array_sort1($item2['plano_conta'], 'nome', SORT_ASC);
        ?>
        @foreach($item2_plano_conta as $item3)
        <?php
        $item3_nome = preg_replace( '/[`´^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $item3['nome'] ) );
        ?>
        <tr>
            <td><b>{{ $item3_nome }}</b></td>
            @foreach($data_previsao as $data)
            <td>
                @if(isset($demonstrativo['entrada_saida'][$item2['tipo']]['plano_conta'][$item3['nome']][$data]))
                <b>{{ number_format($demonstrativo['entrada_saida'][$item2['tipo']]['plano_conta'][$item3['nome']][$data], 2, ',', '.') }}</b>
                @else
                <b>{{ number_format(0, 2, ',', '.') }}</b> 
                @endif
            </td>
            @endforeach
            <td>
                @if(isset($demonstrativo['entrada_saida'][$item2['tipo']]['plano_conta'][$item3['nome']]['subtotal']))
                <b>{{ number_format($demonstrativo['entrada_saida'][$item2['tipo']]['plano_conta'][$item3['nome']]['subtotal'], 2, ',', '.') }}</b>
                @else
                <b>{{ number_format(0, 2, ',', '.') }}</b>
                @endif
            </td>
        </tr>
        <?php
        $item3_detalhe = array_sort1($item3['detalhe'], 'nome', SORT_ASC);
        ?>
        @foreach($item3_detalhe as $item4)
        <?php
        $item4_nome = preg_replace( '/[`´^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $item4['nome'] ) );
        ?>
        <tr>
            <td>{{ $item4_nome }}</td>
            @foreach($data_previsao as $data)
            <td>
                @if(isset($demonstrativo['entrada_saida'][$item2['tipo']]['plano_conta'][$item3['nome']]['detalhe'][$item4['nome']][$data]))
                {{ number_format($demonstrativo['entrada_saida'][$item2['tipo']]['plano_conta'][$item3['nome']]['detalhe'][$item4['nome']][$data], 2, ',', '.') }}
                @else
                {{ number_format(0, 2, ',', '.') }} 
                @endif
            </td>
            @endforeach
            <td>
                @if(isset($demonstrativo['entrada_saida'][$item2['tipo']]['plano_conta'][$item3['nome']]['detalhe'][$item4['nome']]['subtotal']))
                {{ number_format($demonstrativo['entrada_saida'][$item2['tipo']]['plano_conta'][$item3['nome']]['detalhe'][$item4['nome']]['subtotal'], 2, ',', '.') }}
                @else
                {{ number_format(0, 2, ',', '.') }} 
                @endif
            </td>
        </tr>
        @endforeach

        @endforeach
        @endif
        @endforeach

        <tr style="background-color: #0269bd; color: #ffffff;">
            <th>{{ $demonstrativo['subtotal']['nome'] }}</th>
            @foreach($data_previsao as $data)
            <th>
                @if(isset($demonstrativo['subtotal'][$data]))
                {{  number_format($demonstrativo['subtotal'][$data], 2, ',', '.') }}
                @else
                {{ number_format(0, 2, ',', '.') }} 
                @endif
            </th>
            @endforeach
            <th>
                @if(isset($demonstrativo['subtotal1']))
                {{  number_format($demonstrativo['subtotal1'], 2, ',', '.') }}
                @else
                {{ number_format(0, 2, ',', '.') }}
                @endif
            </th>
        </tr>



    </tbody>
</table>
@endif