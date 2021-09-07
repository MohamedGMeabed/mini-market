@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-header">{{ __('Dashboard') }}</div>
        <div class="card">
          <div class="card-body">
                <h2>Order</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>total</th>
                          <th>status</th>
                          <th>Customer</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($order as $objOrder)
                        <tr>
                          <td>{{ $objOrder->id }}</td>
                          <td>{{ $objOrder->total }}</td>
                          <td>{{ $objOrder->status }}</td>
                          <td>{{ $objOrder->user->name }}</td>
                        </tr>                  
                      </tbody>
                    </table>
                </div>
              <div class="col-md-4 offset-md-3">
                <a href="{{route('payment')}}" class="btn btn-primary btn-block ">Pay with PayMob</a>
                <a  href="{{url('send-push-notification') }}/{{ $objOrder->id }}/success" class="btn btn-info btn-block">Cach On Delivery</a>
                </div>
               </div>
              </div>
              @endforeach
        <div class="card">
          <div class="card-body">
              <h2>Order Details</h2>
              <div class="table-responsive">
                <table class="table table-striped table-sm">
                  <thead>
                    <tr>
                          <th>ID</th>
                          <th>Product</th>
                          <th>Price</th>
                          <th>Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach ($Orderproducts as $Orderproduct)
                  <tr>
                  <td>{{ $Orderproduct->id }}</td>
                  <td>{{ $Orderproduct->product->title }}</td>
                  <td>{{ $Orderproduct->price }}</td>
                  <td>{{ $Orderproduct->quantity }}</td>
                  </tr>
                   @endforeach
                  </tbody>
                </table>
              </div>
            </div>
        </div>
  
        </div>

    </div>
</div>


@endsection

