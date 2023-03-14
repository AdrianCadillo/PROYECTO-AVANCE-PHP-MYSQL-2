@extends($this->getComponents("layout.app"))

@section('titulo_','sistema-roles')

@section('contenido')
<div class="container">
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Id_rol</th>
            <th>Nombre rol</th>
        </tr>
    </thead>
    
    <tbody>
      @foreach ($roles as $rol)
        <tr>
        <td>{{$rol->id_rol}}</td>
        <td>{{$rol->name_rol}}</td>    
        </tr>      
      @endforeach
    </tbody>
    </table>
</div>
@endsection