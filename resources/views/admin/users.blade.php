@extends('admin/adminlayout')

@section('container')

<div class="row ">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Detalles del Cliente</h4>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th> ID </th>
                <th> Nombre </th>
                <th> Email </th>
                <th> Teléfono</th>
              </tr>
            </thead>
            <tbody>

            @foreach($users as $user)
              <tr>
                <td>
                  <span>{{ $user->id }}</span>
                </td>
                <td> {{ $user->name }} </td>
                <td> {{ $user->email }}</td>
                <td> {{ $user->phone }} </td>
              </tr>
            @endforeach
           
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection()