@extends('layout', ['title'=> 'Home'])

@section('page-content')
<div>
    <br>
    @if(Session::has('wrong'))
    <div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Opps !</strong> {{Session::get('wrong')}}
</div>
    @endif
    @if(Session::has('success'))
    <div class="success">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Listo !</strong> {{Session::get('success')}}
</div>
    @endif
    <br>
    <br>
    <br>
   
    
            <center>
                    <div class="contact-form">
                        <form id="" action="/trace/confirm" method="post">
                            @csrf
                          <div class="">
                            <div class="col-lg-12">
                                <h1>Rastrear mi Pedido</h1>
                                <br>
                                <br>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                              <fieldset>
                                <input name="invoice" type="text" id="name" placeholder="Folio no" required="">
                              </fieldset>
                            </div>
                            
                            <div class="col-lg-6 col-sm-12">
                              <fieldset>
                                <input name="phone" type="text" id="phone" placeholder="Teléfono" required="">
                              </fieldset>
                            </div>
                           
                           
                           
                            <div class="col-lg-6">
                              <fieldset>
                                <button type="submit" id="form-submit" class="main-button-icon">Enviar</button>
                              </fieldset>
                            </div>
                          </div>
                        </form>
                    </div>
               
                    </center>
            

</div>
@endsection








<style>
.alert {
  padding: 20px;
  background-color: #f44336;
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