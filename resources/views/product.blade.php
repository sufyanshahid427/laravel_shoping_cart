@extends('layout')

@section('content')
<div class="container">
    <div class="row">

        @foreach($products as $product)

        <div class="col-sm-3 mt-1">
            <div class="card" style="width: 16rem ;">
                <img class="card-img-top" src="{{ asset('img') }}/{{ $product->photo }}" width="250px" height="250px"
                    class="img-fluid" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title text-danger">{{ $product->product_name }}</h5>
                    <p class="card-text">{{ $product->product_description }}</p>
                    <p><strong>Price: </strong> ${{ $product->price }}</p>
                    <a href="{{ route('add_to_cart', $product->id) }}" class="btn btn-primary btn-block text-center"
                        role="button">Add to cart</a>
                </div>
            </div>
        </div>


        @endforeach

    </div>
</div>
@endsection