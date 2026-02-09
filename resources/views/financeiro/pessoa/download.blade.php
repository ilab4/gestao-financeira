<?php if (count($pessoas) > 0) { ?>

    <?php
    $nome_arquivo = 'CLIENTES-FORNECEDORES__'.md5(uniqid(time())).'.xls';
    // Configurações header para forçar o download
    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    header ("Content-type: application/x-msexcel");
    header ("Content-Disposition: attachment; filename=\"$nome_arquivo\"" );
    header ("Content-Description: PHP Generated Data" );
    ?>

    <table id="example1" class="table table-bordered table-striped">
        <tr>
                <th colspan='10' align="center">CLIENTES/FORMECEDORES</th>
        </tr>
        <tr>
                <th colspan='10' align="center"><br></th>
        </tr>  
        <tr>
          <th>Id</th>
          <th>Nome</th>
          <th>Email</th>
          <th>Tipo</th>
          <th>CNPJ/CPF</th>
          <th>Banco</th>
          <th>Tipo de Conta</th>
          <th>Agencia</th>
          <th>Conta</th>
          <th>Titular</th>
          <th>Status</th>
        </tr>
        @foreach($pessoas as $pessoa)
            <tr>
                <td>{{ $pessoa->id }}</td>
                <td>{{ $pessoa->nome }}</td>
                <td>{{ $pessoa->email }}</td>
                <td>{{ $pessoa->tipo }}</td>
                <td>{{ $pessoa->cnpj_cpf }}</td>
                <td><?php if(count($pessoa->banco)): ?>{{ $pessoa->banco->numero }} - {{ $pessoa->banco->descricao }}<?php endif; ?></td>
                <td>{{ $pessoa->banco_tipo_conta }}</td>
                <td>{{ $pessoa->banco_agencia }}</td>
                <td>{{ $pessoa->banco_conta }}</td>
                <td>{{ $pessoa->banco_titular }}</td>
                <td>{{ ($pessoa->ativo == 1) ? "Ativo" : "Inativo" }}</td>
            </tr>
        @endforeach 
      </table>

<?php } ?> 