@extends('portal.inc.layout')
@section('content')
<?php

use App\Helpers\MainHelper; ?>
<section class="page-content">
    <div class="page-content-inner">
        <section class="panel">
            <div class="panel-heading">
                <h1>Renegociação <?= $produto->name; ?></h1>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                    </div>
                </div>
            </div>
        </section>
        <section class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Data Vencimento
                                    </th>
                                    <th>
                                        Número da Parcela
                                    </th>
                                    <th>
                                        Valor
                                    </th>
                                    <th>
                                        Valor Negociação
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($parcelasematraso as $retorno) { ?>
                                    <tr>
                                        <td>
                                            <?= $retorno->id; ?>
                                        </td>
                                        <td>
                                            <?= (new MainHelper())->ToMysqlDate($retorno->dt_vencimento, false); ?>
                                        </td>
                                        <td>
                                            <?= $retorno->numero_parcela; ?>
                                        </td>
                                        <td>
                                            R$ <?= $retorno->valor; ?>
                                        </td>
                                        <td>
                                            R$ <?= $retorno->valoratualizado; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>

                                    <td colspan="5" class='text-center'>
                                        <br/>
                                        Valor da negociação: R$ <?= $valortotal; ?>
                                        <div class='col-lg-12'>
                                            <br/>
                                            <a href='javascript:;' class='btn btn-primary'>

                                                <i class='fa fa-barcode'></i>   Gerar Boleto e Realizar Pagamento

                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection