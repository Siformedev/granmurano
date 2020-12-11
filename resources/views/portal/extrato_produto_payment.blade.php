@extends('portal.inc.layout')

@section('content')
<section class="page-content">
    <div class="page-content-inner">

        <section class="panel">
            <div class="panel-heading" style="padding: 10px 20px;">

                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-3"><a class="btn btn-default"
                            href="{{route('portal.extrato.produto', ['prod' => $prod['id']])}}">Voltar</a>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-9">
                        <h3>{{$prod['name']}}</h3>
                    </div>
                </div>
            </div>
        </section>

        @if(Session::has('process_message'))
        <div class="alert alert-danger">{{Session::get('process_message')}}! Código:
            LR-{{Session::get('process_lr')}}</div>
        @endif

        @if(Session::has('process_success_msg'))
        <div class="alert alert-warning">Pagamento {{Session::get('process_success_msg')}}!</div>
        @endif

        <section class="panel col-md-12">
            <div class="panel-heading">

                <div class="row">

                    <div class="col-md-12">
                        <h3>Saldo a Pagar</h3>
                        
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12" style="font-size: 16px;">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-
                                    " scope="row">Total</th>
                                    <td>R$ {{number_format($prod->valorFinal(), 2, ",", ".")}}</td>
                                </tr>
                                <tr>
                                    <th class="text-center" scope="row">Valor Pago</th>
                                    <td>R$ {{number_format($valor_pago_p, 2, ",", ".")}}</td>
                                </tr>
                                <tr>
                                    <th class="text-center" scope="row">Saldo</th>
                                    <td>R$ {{number_format($saldo_pagar, 2, ",", ".")}}</td>
                                </tr>
                                @if($saldo_pagar <= 0) <tr class="text-center">
                                    <td colspan="2">
                                        <img src="{{ asset("img/icon_pago.png") }}" class="img-responsive"
                                            style="max-height: 100px;">
                                        <hr>
                                        <h2 style="color: #00ad21">Parabéns Tudo Pago!</h2>
                                    </td>
                                    </tr>
                                    @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel col-md-12">
            <p class="" align="center">
                <a class="btn btn-success col-md-auto btn-block-xs-only" data-toggle="collapse" href="#area_cc"
                    role="button" aria-expanded="true" aria-controls="area_cc"><u>Cartão de Crédito</u></a>
                <button class="btn btn-success col-md-auto btn-block-xs-only" type="button" data-toggle="collapse"
                    data-target="#area_boleto" aria-expanded="true" aria-controls="area_boleto"><u>Boleto
                        Bancário</u></button>
            </p>

            <div class="row">
                <div class="col">
                    <div class="collapse show" id="area_cc">
                        <div class="card card-body">
                            <div class="panel-body">
                                <form id="payment-form"
                                    action="{{route('portal.extrato.produto.paycredit.process', ['prod' => $prod['id']])}}"
                                    method="POST">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="cc-nome">Nome no cartão</label>
                                            <input type="text" pattern="[A-Z a-z]{1,32}" name="nome_cc"
                                                class="form-control cc-nome"
                                                title="Nome como esta no cartão, tudo em caixa alta" placeholder=""
                                                required="">
                                            <small class="text-muted">Nome completo, como mostrado no cartão.</small>
                                            <div class="invalid-feedback">
                                                O nome que está no cartão é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="cc-numero">Data de Nascimento</label>
                                            <input type="text" name="data_nasc" class="form-control cc-data_nasc"
                                                placeholder="" required="" data-mask="00/00/0000" maxlength="11">
                                            <small class="text-muted">Dado do titular do Cartão</small>
                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="cc-numero">CPF do Titular do cartão</label>
                                            <input type="text" data-mask="000.000.000-00"
                                                pattern="\d{3}\.?\d{3}\.?\d{3}-?\d{2}"
                                                title="Digite um CPF no formato: xxx.xxx.xxx-xx" name="cpf_tit"
                                                class="form-control cc-cpf" placeholder="" required="">
                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="cc-numero">Número do cartão de crédito</label>
                                            <input type="text" class="form-control cc-numero" placeholder=""
                                                required="">
                                            <div class="invalid-feedback">
                                                O número do cartão de crédito é obrigatório.
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-4">
                                            <label for="cc-expiracao">Data de expiração</label>
                                            <input type="text" class="form-control cc-expiracao" data-mask="00/0000"
                                                maxlength="7" placeholder="" required="">
                                            <div class="invalid-feedback">
                                                Data de expiração é obrigatória.
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="cc-cvv">CVV</label>
                                            <input type="text" class="form-control cc-cvv" placeholder="" required="">
                                            <div class="invalid-feedback">
                                                Código de segurança é obrigatório.
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <label class="form-control-label">Selecione a quantidade de
                                                parcelas:</label>
                                            <select name="pay-parcels" class="form-control">
                                                @if(false)
                                                @for($i=1;$i<=$parce_max;$i++) <?php $valor_f =  $saldo_pagar/$i; ?>
                                                    <option value="{{$i}}">{{$i}}X de R$
                                                    {{number_format($valor_f, 2, ",", ".")}}</option>
                                                    @endfor
                                                    @else
                                                    <option> Aguardando número do Cartão </option>
                                                    @endif
                                            </select>
                                        </div>
                                        <button class="btn btn-primary" align="center" type="submit" id="btn-pagar">
                                            Processar compra
                                        </button>
                                    </div>
                                    <input type="hidden" name="token" id="token">
                                    <input type="hidden" name="hash" id="hash">
                                    <input type="hidden" name="prod" value="{{$prod['id']}}">
                                    <input type="hidden" name="saldo" value="{{$saldo_pagar}}">

                                    @foreach($sum_pags as $p)
                                    <input type="hidden" name="parcels[]" value="{{$p}}">
                                    @endforeach

                                    {!! csrf_field() !!}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="collapse" id="area_boleto">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-md-12" style="font-size: 16px;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Vencimento</th>
                                                <th class="text-center">Valor</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($parcelas as $parcela)
                                            <?php
                                        //dd($parcelas);
                                        //dd($pagamentos);
                                            $actionParc = '';
                                            $sumpg = 0;
                                            $tptype = '';
                                            //dd($parcelas);
                                            if(isset($pagamentos[$parcela['id']]) ){
        
                                                $parc = $pagamentos[$parcela['id']];
                                                $sumpg = $parc->valor_pago;
                                                if(isset($parc->typepaind_type)){
                                                    $tptype = $parc->typepaind_type;
                                                    $credit_parcels = isset($parc->typepaind->installments)?$parc->typepaind->installments:'';
                                                    $credit_link_pdf = isset($parc->typepaind->secure_url)?$parc->typepaind->secure_url:'';
                                                }else{
                                                    $tptype = null;
                                                }
        
                                            }

                                            $dt_venc = (strtotime($parcela['dt_vencimento']));
                                            //$dt_venc_boleto = strtotime(date('Y-m-d'));
                                            $dt_venc_boleto = strtotime('+0 day', strtotime(date('Y-m-d')));
                                            //$dt_venc = strtotime('+0 day', strtotime(date('2020-06-20')));
                                            
                                            //print_r(date("Y-m-d",$dt_venc));
                                            //echo '<br>';
                                            //print_r(date("Y-m-d",$dt_venc_boleto));
                                            $dt_calc = $dt_venc - $dt_venc_boleto;
                                            //echo '<br>';
                                            //echo date("Y-m-d",$dt_calc);
                                            //echo '<br>';
                                            //dd($dt_calc);

                                            //echo date('Y-m-d', strtotime($parcela['dt_vencimento']));
                                            //dd($tptype);
                                            if($sumpg >= $parcela['valor'] ){
                                                
                                                if($tptype == ''){
                                                    $actionParc = '<span class="label label-success">PAGO</span>';
                                                }elseif($tptype == 'App\PagamentosBoleto'){
                                                    $actionParc = '<span class="label label-success">PAGO</span>';
                                                }elseif($tptype == 'App\PagamentosCartao'){
                                                    $credit_parcels = ($credit_parcels <= 0) ? 1 : $credit_parcels;
                                                    $actionParc = '<span style="height: 30px; " class="label label-success">PAGO</span> <a target="_blank" href="'.$credit_link_pdf.'.pdf"> <img style="height: 60px;" src="'.asset('img/pay_credit_X'.$credit_parcels.'.png').'"></a>';
                                                }
        
        
                                            }elseif($sumpg <= 0 ){
                                                

                                                //dd($parc);
                                                //var_dump($parc->typepaind_type);
                                                if(date('Y-m-d', strtotime($parcela['dt_vencimento'])) <= $dateLimit->format('Y-m-d')){
                                                    if(date('Y-m-d', strtotime($parcela['dt_vencimento'])) < date('Y-m-d')){
                                                        //$actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 5 dias antes do vencimento" target="_blank">Emitindo seu boleto...</span>';
                                                        $actionParc = '<a href_javascript="'.route('portal.formando.boleto',['parcela' => $parcela['id']]).'" class="label label-danger boleto-imprimir" target="_blank">Vencida</a>';
                                                    }
                                                    elseif( isset($parc->typepaind_type) && $parc->typepaind_type == 'App\PagamentosCartao'){
                                                        
                                                    if($pgto['status'] == 'Recusado'){
                                                        $actionParc = '<a  class="label label-danger" target="_blank"> Cartão '.$pgto['status'].' </a>';
                                                    }else{
                                                        $actionParc = '<a  class="label label-warning" target="_blank"> Cartão '.$pgto['status'].' </a>';
                                                        $disable_cc_pgto = true;
                                                    }
                                                            
                                                }elseif( $dt_calc <= 345600 && $dt_calc >= 0 ){
                                                    
                                                    
                                                    //dd($dateLimit->format('Y-m-d'));
                                                    //$date = date("Y-m-d");
                                                    //dd((strtotime('-10 day',strtotime($parcela['dt_vencimento'])) - strtotime('+10 day', strtotime(date('Y-m-d')))));
                                                    //$mod_date = strtotime($date."+ 4 days");
                                                    //echo date("Y-m-d",$mod_date) . "\n";exit;
                                                        //$dt_limite = strtotime('+4 day', strtotime(date('Y-m-d')));
                                                        /*$dt_venc = (strtotime($parcela['dt_vencimento']));
                                                        $dt_venc_boleto = strtotime('+4 day', strtotime(date('Y-m-d')));
                                                    echo date("Y-m-d",$x);
                                                    echo '<br>';
                                                    echo date("Y-m-d",$y);
                                                    echo '<br>';
                                                    echo $x-$y;
                                                    //echo date('Y-m-d', strtotime($parcela['dt_vencimento'])) -date('Y-m-d');
                                                    exit;
*/
                                                        $actionParc = '<a href_javascript="'.route('portal.formando.boleto',['parcela' => $parcela['id']]).'" class="label label-warning boleto-imprimir" target="_blank">Imprimir</a>';
                                                        
                                                        //$actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 5 dias antes do vencimento" target="_blank">Emitindo seu boleto...</span>';
                                                    }elseif(date('Y-m-d', strtotime($parcela['dt_vencimento'])) < date('Y-m-d')){
                                                        //$actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 5 dias antes do vencimento" target="_blank">Emitindo seu boleto...</span>';
                                                        $actionParc = '<a href_javascript="'.route('portal.formando.boleto',['parcela' => $parcela['id']]).'" class="label label-danger boleto-imprimir" target="_blank">Vencida</a>';
                                                    }else{
                                                        
                                                        $actionParc = '<span onclick="aviso_vencimento()" class="label label-primary a-vencer-click" title="Seu boleto estará disponível 30 dias antes do vencimento" style="cursor: pointer ;">A Vencer</span>';
                                                    }
                                                }else{
                                                        
                                                        $actionParc = '<span onclick="aviso_vencimento()" class="label label-primary a-vencer-click" title="Seu boleto estará disponível 30 dias antes do vencimento" style="cursor: pointer ;">A Vencer</span>';
                                                    }
                                            }
        
        
                                            ?>
                                            <tr>
                                                <td class="text-center">{{$parcela['numero_parcela']}}</td>
                                                <td class="text-center">
                                                    {{date('d/m/Y', strtotime($parcela['dt_vencimento']))}}</td>
                                                <td class="text-center">{{number_format($parcela['valor'],2, ",", ".")}}
                                                </td>
                                                <td class="text-center"> {!! $actionParc !!} </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if($saldo_pagar > 0)
        <section class="panel col-md-7">

        </section>


        @endif
    </div>

</section>
<script src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>

<script>
    let cc = {};
    $('.invalid-feedback').hide();
    $(".cc-expiracao").mask("99/9999",{placeholder:"MM/AAAA"});
    $(".cc-data_nasc").mask("99/99/9999",{placeholder:"DD/MM/AAAA"});
    $(".cc-cpf").mask("999.999.999-99",{placeholder:"xxx.xxx.xxx-xx"});
    PagSeguroDirectPayment.setSessionId('{{$id_sessao}}');        
    PagSeguroDirectPayment.onSenderHashReady(function(response){
    if(response.status == 'error') {
        //console.log(response.message);
        //return false;
    }
    //hash = response.senderHash; //Hash estará disponível nesta variável.
    $('#hash').val(response.senderHash);    
    });

$('.cc-numero').keyup(function(){    
    pagseguroValidateCard(this.value, false);
});
$('.cc-numero').focusout(function(){
    pagseguroValidateCard(this.value, true);
});
$('.cc-expiracao').focusout(function(){
    if(pagseguroValidateExp(this.value)){
        $(this).unbind('focusout');
    };
});

$( "#payment-form" ).submit(function( event ) {  
  event.preventDefault();
  
  cc.nome = $('.cc-nome').val();
  cc.num = $('.cc-numero').val();  
  cc.cvv = $('.cc-cvv').val();
  
  tokenCC().then(token_success).catch(error_handler);
  /*if(cc.token){
    $(this).unbind().submit();
  }*/
});

function bandeira_error(r){
 console.log("failed with status", r);
}
function token_success(r){
    //console.log(r)
    $('#token').val(r.card.token);
    $( "#payment-form" ).unbind().submit();    
}

function error_handler(r){
    //error_string = "";
    //console.log(r)
    cc.token=false;
    if (r.hasOwnProperty('errors')) {

    Object.keys(r.errors).forEach(function(prop) {
        alert(r.errors[prop]);
    });
    }else{
        console.log(r)
    }
    
    //alert(error_string);
}
function tokenCC(){
    
var promiseObj = new Promise(function(fullfill, reject){
   PagSeguroDirectPayment.createCardToken({
   cardNumber: cc.num.replace(/\s/g, ''), // Número do cartão de crédito
   brand: cc.brand, // Bandeira do cartão
   cvv: cc.cvv, // CVV do cartão
   expirationMonth: cc.mes, // Mês da expiração do cartão
   expirationYear: cc.ano, // Ano da expiração do cartão, é necessário os 4 dígitos.
   success: function(response) {
        // Retorna o cartão tokenizado.
        fullfill(response);
   },
   error: function(response) {
		    // Callback para chamadas que falharam.
            reject(response)      
   },
   complete: function(response) {
        // Callback para todas chamadas.
   }
});
});
return promiseObj;       
}

function getBrand(cc){    
    
    var promiseObj = new Promise(function(fullfill, reject){
    PagSeguroDirectPayment.getBrand({
    cardBin: cc.num.substr(0, 6),
    success: function(response) {
      fullfill(response);
    },
    error: function(response) {
      
    },
    complete: function(response) {
        reject(response)
    }      
  });
});  
  return promiseObj;       
}

function pagseguroValidateExp(element){
    
    str = element.split('/');
    if(element.length < 7 || str[0] > 12 || str[0] < 1 || str[1] < 2020){
        alert("Verifique se a data de vencimento esta correta");
        
        return false
    }
    cc.mes = str[0];
    cc.ano = str[1];
}

function pagseguroValidateCard (element, bypassLengthTest) {

        $('input[name=pagseguro\\[creditCardToken\\]]').val('');
        var cardNum = element.replace(/[^\d.]/g, '');
        var card_invalid = 'Validamos os primeiros 6 números do seu cartão de crédito e está inválido. Por favor esvazie o campo e tente digitar de novo.';

        if (cardNum.length == 6 || (bypassLengthTest && cardNum.length >= 6)) {
            PagSeguroDirectPayment.getBrand({
            cardBin: cardNum.substr(0, 6),
            success: function(response) {
                if (typeof response.brand.name != 'undefined') {

                    $('input[name=pagseguro\\[brand\\]]').val(response.brand.name);
                    cc.brand = response.brand.name;
                    PagSeguroDirectPayment.getInstallments({
                        amount: {{$saldo_pagar}},
                        maxInstallmentNoInterest: 6,
                        brand: response.brand.name,
                        success: function(response1) {
                            //$('select[name=pagseguro\\[installments\\]]').html('');
                            $('select[name=pay-parcels]').html('');
                            
                            $.each(response1.installments[response.brand.name], function(key, value){
                                if(value.quantity <= 6){
                                    $('select[name=pay-parcels]').append('<option value="'+value.quantity+'x'+value.installmentAmount.toFixed(2)+'">'+value.quantity+' vezes  '+value.installmentAmount.toFixed(2).replace('.', ',')+' (Total: '+value.totalAmount.toFixed(2).replace('.', ',')+') - ' + response.brand.name.toUpperCase() + '</option>');
                                }
                                
                            });
                            //$('.pagseguro-installments').show();
                            //$('.pagseguro-installments-info').hide();
                        },
                        error: function(){
                            alert(card_invalid);
                            $(this).unbind('focusout');
                            return false;
                        }
                    });

                }else{
                    alert(card_invalid);
                    $(this).unbind('focusout');
                    return false;
                }
            },
            error: function(response) {
                alert(card_invalid);
                $(this).unbind('focusout');
                return false;
            }});
        }
    }
    //start opened
    $('#area_cc').collapse('show')
    $('.panel').on('shown.bs.collapse', function (e) {
    
    if(e.target.id == "area_boleto"){
        $('#area_cc').collapse('hide')
    }else{
        $('#area_boleto').collapse('hide')
        
    }
})
</script>

<script type="text/javascript">
    $(function(){
            $(".a-vencer-click").click(function (e) {
                //alert("Seu boleto estará disponível 30 dias antes do vencimento");
                swal({ title: "Aviso", text: "Seu boleto estará disponível 4 dias antes do vencimento", type: "warning" });
            });
            
            $(".boleto-imprimir").click(function (e) {
                let url = "";
                url = $(this).attr('href_javascript');
                if(url.length < 50){
                    hash = $('#hash').val();
                    url += '/'+hash;
                    //this.href = url;
                    //console.log(url)
                    location.replace(url);
                }                
            });
        });
    
    PagSeguroDirectPayment.onSenderHashReady(function(response){
    if(response.status == 'error') {
        alert('Ocorreu um erro, por favor atualize a página');
        console.log(response.message);
        return false;
    }
    //hash = response.senderHash; //Hash estará disponível nesta variável.
    });   

    
function aviso_vencimento(){
    swal({ title: "Aviso", text: "Para todos os boletos gerados, a data de vencimento do mesmo será gerado em D+4", type: "warning" });
}
</script>

<style>
    @media (max-width: 575.98px) {
        .btn-block-xs-only {
            display: block;
            width: 100%;
            margin-bottom: 1em;
        }
    }
</style>

@endsection