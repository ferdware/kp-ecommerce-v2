@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1>Shopping Cart</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                @if(session('cart'))
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th width="50%">Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $total = 0 @endphp
                                @foreach(session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                    <tr data-id="{{ $id }}">
                                        <td>
                                            <div class="d-flex">
                                                <img src="{{ $details['image'] ? asset($details['image']) : 'https://via.placeholder.com/100' }}" alt="{{ $details['name'] }}" width="100" class="img-fluid rounded">
                                                <div class="ms-3">
                                                    <h5>{{ $details['name'] }}</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>${{ number_format($details['price'], 2) }}</td>
                                        <td>
                                            <input type="number" min="1" value="{{ $details['quantity'] }}" class="form-control quantity cart-update" style="width: 70px" />
                                        </td>
                                        <td>${{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm cart-remove"><i class="fa fa-trash"></i> Remove</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        Your cart is empty. <a href="{{ route('products.index') }}">Continue shopping</a>
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        @if(session('cart'))
                            <p>Total Items: <strong>{{ count((array) session('cart')) }}</strong></p>
                            <p>Total: <strong>${{ number_format($total, 2) }}</strong></p>
                            <hr>
                            <div class="d-grid gap-2">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Continue Shopping</a>
                                <a href="#" class="btn btn-primary">Proceed to Checkout</a>
                            </div>
                        @else
                            <p>Your cart is empty.</p>
                            <div class="d-grid">
                                <a href="{{ route('products.index') }}" class="btn btn-primary">Start Shopping</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
       $(document).ready(function() {
          // Update cart quantity
          $(".cart-update").change(function(e) {
             e.preventDefault();

             var ele = $(this);

             $.ajax({
                url: '{{ route('update.cart') }}',
                method: "PATCH",
                data: {
                   _token: '{{ csrf_token() }}',
                   id: ele.parents("tr").attr("data-id"),
                   quantity: ele.val()
                },
                success: function(response) {
                   window.location.reload();
                },
                error: function(response) {
                   console.log('Error updating cart:', response);
                }
             });
          });

          // Remove from cart - Updated event handler
          $(".cart-remove").click(function(e) {
             e.preventDefault();
             console.log('Remove button clicked'); // Debug log

             var ele = $(this);
             var productId = ele.parents("tr").attr("data-id");
             console.log('Product ID:', productId); // Debug log

             if(confirm("Are you sure you want to remove this item?")) {
                $.ajax({
                   url: '{{ route('remove.from.cart') }}',
                   method: "DELETE",
                   data: {
                      _token: '{{ csrf_token() }}',
                      id: productId
                   },
                   success: function(response) {
                      console.log('Item removed successfully'); // Debug log
                      window.location.reload();
                   },
                   error: function(xhr, status, error) {
                      console.error('Error removing item:', xhr.responseText);
                      alert('Error removing item. Please try again.');
                   }
                });
             }
          });
       });
    </script>
@endsection


