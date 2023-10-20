@extends('admin/adminlayout')

@section('container')


<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Agregar Repartidor</h4>
                    <br>

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

                    <form class="forms-sample" action="/add-delivery-boy-process" method="post" enctype="multipart/form-data">

                       @csrf

                      <div class="form-group">
                        <label for="exampleInputName1">Nombre</label>
                        <input type="text" name="name" class="form-control" id="exampleInputName1">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Email</label>
                        <input type="text" name="email" class="form-control" id="exampleInputName1">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Teléfono</label>
                        <input type="number" name="phone" class="form-control" id="exampleInputName1">
                      </div>

            


                      <div class="form-group">
                        <label for="exampleInputName1">Salario</label>
                        <input type="number" name="salary" class="form-control" id="exampleInputName1">
                      </div>


                      <div class="form-group">
                        <label for="exampleInputName1">Contraseña</label>
                        <input type="password" name="password" class="form-control" id="exampleInputName1">
                      </div>


                      <div class="form-group">
                        <label for="exampleInputName1">Confirmar Contraseña</label>
                        <input type="password" name="confirm_password" class="form-control" id="exampleInputName1">
                      </div>

                  
                      <div class="form-group">
                        <label for="exampleFormControlFile1">Imagen</label>
                        <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
                      </div>
                  
                    
                      <button type="submit" class="btn btn-primary me-2">Enviar</button>
                      <button class="btn btn-dark">Cancelar</button>
                    </form>
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