@extends('admin/adminlayout')

@section('container')


<a href="/add/coupon" type="button" class="btn btn-success" style="width:170px;height:35px;padding-top:9px;">+ Agregar Cupón</a>


<br>
<br>


<div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Detalles del Cupón</h4>

                    @if(Session::has('wrong'))
              
                    <div class="alert">
                  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                  <strong>Opps !</strong> {{Session::get('wrong')}}
                </div>
                <br>
                    @endif
                    @if(Session::has('success'))
              
                    <div class="success">
                  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                  <strong>Listo !</strong> {{Session::get('success')}}
                </div>
                    <br>
                    @endif
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                          
           
                            <th> ID </th>
                            <th> Nombre </th>
                            <th> Detalles </th>
                            <th>Código</th>
                            <th> Porcentaje de Descuento</th>
                        
                            <th> Fecha de validación </th>

                            <th> Acción </th>
                          </tr>
                        </thead>
                        <tbody>

                        @foreach($coupons as $coupon)
                          <tr>
                           
                            <td>
                              <span>{{ $coupon->id }}</span>
                            </td>
                            <td> {{ $coupon->name }} </td>


                         


                            <td>  {{  $coupon->details }}</td>


                            <td>  {{  $coupon->code }}</td>
                            <td> {{ $coupon->percentage }}%</td>


                            <td> {{ $coupon->validate }} </td>
                     


                            <td>

                            <a href="{{ asset('/admin/coupon/edit/'.$coupon->id) }}" class="badge badge-outline-primary">Editar</a>
                              <a href="{{ asset('/admin/coupon/delete/'.$coupon->id) }}" class="badge badge-outline-danger" style="margin-left:10px;">Eliminar</a>
                            </td>
                          </tr>

                        @endforeach
                       
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>





@endsection()



<style>
.alert {
  padding: 20px;
  background-color: #f44336;
  color: white;
}

.success {
  padding: 20px;
  background-color: #4BB543 ;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>