<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RenegociacaoController extends Controller {

    private $modelProductsAndServices;
    private $modelFormandoProdutosParcelas;
    private $product;
    private $user;

    function __construct(\App\ProductAndService $modelProductsAndServices, \App\FormandoProdutosParcelas $modelFormandoProdutosParcelas) {
        parent::__construct();
        $this->modelProductsAndServices = $modelProductsAndServices;
        $this->modelFormandoProdutosParcelas = $modelFormandoProdutosParcelas;
    }

    public function index($prodId) {
        $this->product = $this->modelProductsAndServices->find($prodId);
        $this->user = \Auth::user();
        $parcelasEmAtraso = $this->modelFormandoProdutosParcelas->where(['formandos_id' => $this->user->id])->where('dt_vencimento', '<', date("Y-m-d"))->whereStatus(0)->get();
        $valorTotalParcelasEmAtraso = 0;
        $valormulta = 0.05;
        $valorjuros = 0.05;

        foreach ($parcelasEmAtraso as &$retorno) {
            $dateExplode = explode('-', $retorno->dt_vencimento);
            $datework = Carbon::createFromDate($dateExplode[0], $dateExplode[1], $dateExplode[2]);
            $now = Carbon::now();
            $mesesEmAtraso = $datework->diffInMonths($now);
            $valorParcela = $retorno->valor;
            $multa = $valorParcela * ($valormulta * $mesesEmAtraso);
            $juros = $valorParcela * ($valorjuros * $mesesEmAtraso);
            $valoratualizado = ($retorno->valor + $multa + $juros);
            $valorTotalParcelasEmAtraso += $valoratualizado;
            $retorno->valoratualizado = $valoratualizado;
        }

        return view('portal.renegociacao', ['produto' => $this->product, 'parcelasematraso' => $parcelasEmAtraso,'valortotal'=>$valorTotalParcelasEmAtraso]);
    }

}
