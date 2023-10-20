@extends('layout', ['title'=> 'Home'])

@section('page-content')
<div>
    <br>
    <br>
    <br>
    <br>
    <center>


    <h1>Mi Pedido</h1>

    <br>
    <br>


    </center>
<table id="cart" class="table table-hover table-condensed container">
    <thead>
        <tr>
            <th style="width:10%">Fecha</th>
            <th style="width:10%">Folio No.</th>
            <th style="width:50%">Producto</th>
            <th style="width:20%">Método de Pago</th>
            <th style="text-align:center;width:10%">Precio</th>
            <th style="width:8%">Cantidad</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            
        </tr>
    </thead>
    <tbody>
        @php $total = 0 @endphp
        @foreach($carts as $product)
            @php $total += $product['price'] * $product['quantity'] @endphp
            <tr>
                <td>{{$product->purchase_date}}</td>
                <td>{{$product->invoice_no}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->pay_method}}</td>
                <td style="text-align:center">${{$product->price}}</td>
                <td style="text-align:center">{{$product->quantity}}</td>
                <td style="text-align:center">${{$product->subtotal}}</td>
              
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
        @php 
        
        
        $total = $total_price;
        
        Session::put('total',$total_price);
        
        @endphp
            <td colspan="7" class="text-right"><h3><strong>Total ${{ $total_price }}</strong></h3></td>
        </tr>
        <tr>
            <td colspan="7" class="text-right">
                <a href="{{ url('/menu') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continuar comprando</a>
              
            </td>
        </tr>
    </tfoot>
</table>
</div>
@endsection