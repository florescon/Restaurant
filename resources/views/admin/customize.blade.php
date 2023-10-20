@extends('admin/adminlayout')

@section('container')


<a href="/customize/edit" type="button" class="btn btn-primary">Editar Plantilla</a>
<br><br>

@foreach($customize as $customize_theme)
<div class="card">
  <h5 class="card-header">Título : {{ $customize_theme->title }}</h5>
  <div class="card-body">
    <p class="card-text"><b>Descripción : </b> {{ $customize_theme->description }}</p>
    <br>
  </div>
</div>

<br>
<br>

<div class="card-group">
  <div class="card">
    <img src="{{ asset('assets/images/'.$customize_theme->image1) }}" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Sección 1 Imagen</h5>
      <p class="card-text">

        


    
      </p>
    </div>
  
  </div>
  <div class="card" style="margin-left:20px;">
    <img src="{{ asset('assets/images/'.$customize_theme->image2) }}" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Sección 2 Imagen</h5>

    <p class="card-text">

        




</p>
</div>
  </div>
  <div class="card"  style="margin-left:20px;">
    <img src="{{ asset('assets/images/'.$customize_theme->image3) }}" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Sección 3 Imagen</h5>

    <p class="card-text">

        





</p>
</div>
  </div>
</div>

<br><br>
<h1>Video</h1>
<br>

<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="{{ $customize_theme->youtube_link }}" allowfullscreen></iframe>
</div>

<br>
<br>



<br>
<br>
<br>



<div class="card mb-3">
  <img src="{{ asset('assets/images/'.$customize_theme->vd_image) }}" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Video Thumbnail</h5>
  </div>
</div>

@endforeach

@endsection()