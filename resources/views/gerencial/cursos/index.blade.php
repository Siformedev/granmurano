@extends('gerencial.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">
            
            <table class="table table-striped table-inverse table-responsive" id="cursos">
                <thead class="thead-inverse">
                    <tr>
                        <th>Id</th>
                        <th>Curso</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">1</td>
                            <td>Curso 1</td>
                            <td>Editar</td>
                        </tr>
                        <tr>
                            <td scope="row">2</td>
                            <td>Curso 2</td>
                            <td>Editar</td>
                        </tr>
                    </tbody>
            </table>




        </div>
    </section>
@endsection


@section('script')

<script>

$(document).ready(function() {
    $('#cursos').DataTable({
        language: {
          "url":"http://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json" ,                   
          }
     }); 
    
});


</script>

@endsection
