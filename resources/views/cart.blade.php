@extends('layout')
   
@section('content')
<table id="cart" class="table table-hover table-condensed">
    <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
    </thead>
     <tbody>        <!-- /* this blade template display the line of shoping cart add to cart main jitna hi data ho ga ye table main show krwae ga -->
        @php $total = 0 @endphp  
        @if(session('cart')) <!--  This Blade directive checks if there's a "cart" data in the session. If the cart data exists, it proceeds with the code inside the-->
            @foreach(session('cart') as $id => $details)
                @php $total += $details['price'] * $details['quantity'] 
                @endphp
                <tr data-id="{{ $id }}"> <!-- data-id this is  attribute that store the value of  Product id --->
                    <td >
                        <div class="row">
                            <div class="col-sm-3 hidden-xs"><img src="{{ asset('img') }}/{{ $details['photo'] }}" width="50px" height="50px" class="img-responsive"/></div>
                            <div class="col-sm-9">
                                <h5 class="width: 16rem">{{ $details['product_name'] }}</h5>
                            </div>
                        </div>
                    </td>
                    <td >${{ $details['price'] }}</td>
                    <td >
                        <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity cart_update" min="1" />
                    </td>
                    <td  class="text-center">${{ $details['price'] * $details['quantity'] }}</td>
                    <td class="actions" data-th="">
                        <button class="btn btn-danger btn-sm cart_remove"><i class="fa fa-trash-o"></i> Cancel</button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right"><h3><strong>Total ${{ $total }}</strong></h3></td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">
                <form action="/session" method="POST">
                @csrf
                <a href="{{ url('/') }}" class="btn btn-danger"> <i class="fa fa-arrow-left"></i> Continue Shopping</a>
                <button class="btn btn-success"><i class="fa fa-money"></i> Checkout</button>
                </form>
            </td>
        </tr>
    </tfoot>
</table>
@endsection
   
@section('scripts')                       <!-- ajax is used for quantity update and quantity remove -->
<script type="text/javascript">
   
    $(".cart_update").change(function (e) {       // This line selects elements with the class "cart_update" and attaches a change event handler to them
        e.preventDefault();                        //This line prevents the default behavior of the change event
   
        var ele = $(this);  
   
        $.ajax({                                        // $.ajax() function. It sends a request to the server to update the cart quantity.
            url: '{{ route('update_cart') }}',          // This specifies the URL to which the AJAX request is sent. It uses Laravel's route()
            method: "patch",                            //This indicates that the HTTP method for the request is "PATCH," which is often used for updating existing resources.
            data: {
                _token: '{{ csrf_token() }}', 
                id: ele.parents("tr").attr("data-id"), 
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });
   
    $(".cart_remove").click(function (e) {
        e.preventDefault();
   
        var ele = $(this);
   
        if(confirm("Do you really want to remove?")) {
            $.ajax({
                url: '{{ route('remove_from_cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
   
</script>
@endsection