<?php

namespace App\Http\Controllers\Gerencial;

use Illuminate\Http\Request;

class CursosController extends Controller
{
    public function index(){
        return view('gerencial.cursos.index');
    }
}
