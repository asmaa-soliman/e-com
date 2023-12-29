<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
   @include('admin.css')
   <style>
    .title_deg
    {
        text-align: center;
        font-size: 35px;
        font-weight: bold;
    }
    .center{
            margin: auto;
            width: 50%;
            text-align: center;
            margin-top: 30px;
            border: 3px solid gray;
            color: white
        }
        .tr1{
            background-color:rgb(228, 228, 228)  ;
            color: gray;
            font: bolder;
        }
       
   </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
     @include('admin.sidebar')
      <!-- partial -->
     @include('admin.header')
       

     <div class="main-panel">
        <div class="content-wrapper">
            <h1 class="title_deg">All Orders</h1>

            {{-- searsh about order --}}
            <div style="padding-left:450px;padding-top:25px;">
                <form action="{{ url('search') }}" method="get">
                    @csrf
                    <input type="text" style="color:black;"  name="search" placeholder="search for something">
                    <input type="submit" value="search" class="btn btn-outline-primaary">

                </form>
            </div>
            <table class="table center">
                <tr class="tr1">
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Product title</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Payment Status</th>
                    <th>Delivery Status</th>
                    <th>Image</th>
                    <th>Delivered</th>
                    <th>Print PDF</th>
                    <th>Send Mail</th>
                </tr>
                @forelse($order as $order)

                <tr>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->product_title }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->price }}</td>
                    <td>{{ $order->payment_status }}</td>
                    <td>{{ $order->delivery_status }}</td>
                    <td>
                        <img  src="/product/{{ $order->image }}" alt="">
                    </td>
                    <td>
                        @if ( $order->delivery_status=='processing')
                        <a href="{{ url('delivered',$order->id )}}" onclick="return confirm('are u sure this product is delivered?!')" class="btn btn-primary">Delivered</a>
                        @else
                        <p style="color: rgb(0, 200, 255); font-size:20px;">delivered</p>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url('print_pdf',$order->id) }}" class="btn btn-primary" >print</a>
                    </td>
                    <td>
                        <a href="{{ url('send_email',$order->id) }}" class="btn btn-info" >send</a>
                    </td>
                </tr>
                {{-- empty doesent come with foreach so we use forelse  --}}
                    @empty
                        <tr>
                            <td colspan="16">no data founded</td>
                        </tr>
                @endforelse
            </table>
        </div>
     </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
 @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>

