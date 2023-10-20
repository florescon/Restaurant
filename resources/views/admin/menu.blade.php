@extends('admin/adminlayout')

@section('container')

  <a href="/add/menu" type="button" class="btn btn-success" style="width:170px;height:35px;padding-top:9px;">+ Agregar Menú</a>

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

  <?php
    $i=1;
  ?>

  @foreach($products as $product)
  <?php
                              
  $total_rate=DB::table('rates')->where('product_id',$product->id)
  ->sum('star_value');


  $total_voter=DB::table('rates')->where('product_id',$product->id)
  ->count();

  if($total_voter>0)
  {
      $per_rate=$total_rate/$total_voter;
  }
  else
  {

      $per_rate=0;
  }

  $per_rate=number_format($per_rate, 1);

  ?>

  @if($i%3==1)
    <div class="card-deck" style="margin-top:20px;">
  @endif


    <div class="card">
      <img class="card-img-top" src="{{ asset('assets/images/'.$product->image) }}" style="width:100%;height:auto;" alt="Card image cap">
      <div class="card-body">
        <h5 class="card-title">{{ $product->name }}</h5>
        <p class="card-text">{{ $product->description }}</p>
    
        <p style = "text-transform:capitalize;">Categoría : {{ $product->catagory }}</p>
        @if($product->session==0)
        <p style = "text-transform:capitalize;">Sesión : Desayuno</p>
        @endif
        @if($product->session==1)
        <p style = "text-transform:capitalize;">Sesión : Comida</p>
        @endif
        @if($product->session==2)
        <p style = "text-transform:capitalize;">Sesión : Día</p>
        @endif
        <p style = "text-transform:capitalize;">Precio : {{ $product->price }} Tk</p>
        @if($product->available =="Stock")

        <p style = "text-transform:capitalize;">Disponibilidad : Existencia </p>

        @endif

        @if($product->available !="Stock")

        <p style = "text-transform:capitalize;">Disponibilidad : Agotado </p>

        @endif

        <span class="rating_avg">Clasificación : {{  $per_rate}}</span>

      </div>
      <div class="card-footer">
        <small class="text-muted"><a href="{{ asset('/menu/edit/'.$product->id) }}" class="btn btn-primary">Editar</a>
        <a href="{{ asset('/menu/delete/'.$product->id) }}" class="btn btn-danger" style="margin-left:10px;">Eliminar</a>
        </small>
      </div>
    </div>
    

  @if($i%3==0)
  </div>
  @endif

  <?php
    $i++;
  ?>

  @endforeach

  @if(($i-1)%3!=0)
    @if($fraction==2)
      <div class="card" style="background-color:black;"></div>
    @endif

    @if($fraction==1)
      <div class="card" style="background-color:black;"></div>
      <div class="card" style="background-color:black;"></div>
    @endif
  @endif

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