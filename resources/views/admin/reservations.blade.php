@extends('admin/adminlayout')

@section('container')

<div class="row ">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Detalles de Reservaciones</h4>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
              

                <th> Fecha </th>
                <th> Tiempo </th>
                <th> Nombre </th>
                <th> Email </th>
                <th> Teléfono</th>
            
                <th> No. de Invitados </th>
  
      
                
                <th> Mensaje </th>
              </tr>
            </thead>
            <tbody>

            @foreach($reservations as $reservation)
              <tr>
               
                <td>
                  <span class="ps-2">{{ $reservation->date }}</span>
                </td>
                <td> {{ $reservation->time }} </td>
                <td> {{ $reservation->name }} </td>
                <td>


                {{ $reservation->email }}


                </td>


                <td>  {{  $reservation->phone }}</td>
                <td> {{ $reservation->no_guest }} </td>
         
     

                <td>

                {{ $reservation->message }}

                  </td>
              </tr>

            @endforeach
           
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

{{ $reservations->links() }}

@endsection()