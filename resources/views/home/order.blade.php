
<!DOCTYPE html>
<html>
   <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="/images/favicon.png" type="">
    <title>Famms - Fashion HTML Template</title>
    <!-- bootstrap core css -->
    <link  href="{{asset('home/css/bootstrap.css')}}" type="text/css"  rel="stylesheet"/>
    <!-- font awesome style -->
    <link href="{{asset('home/css/font-awesome.min.css')}}" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{asset('home/css/style.css')}}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{asset('home/css/responsive.css')}}"  rel="stylesheet" />
      <style>
        .center{
            margin: auto;
            width: 50%;
            text-align: center;
            margin-top: 30px;
            border: 3px solid gray;
            color: white
        }
        .h2_font{
            text-align: center;
            font-size: 40px;
            padding-bottom: 40; 
        }
        .tr1{
            background-color:rgb(228, 228, 228)  ;
            color: gray;
            font: bolder;
        }
      </style>
   </head>
   <body>
      <div class="hero_area">
        <!--  header section -->
        @include('home.header');
        <!-- end header section -->
         <table class="table center">
            <tr class="tr1">
                <th>product Title</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Payment Status</th>
                <th>delivery Status</th>
                 <th>image</th>
                 <th>cancel order</th>
            </tr>
            @foreach ($order as $order )
            <tr style="color: black;">
                <td>{{ $order->name }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ $order->price }}</td>
                <td>{{ $order->payment_status }}</td>
                <td>{{ $order->delivery_status }}</td>
                <td>
                    <img height="50" width="50"  src="/product/{{ $order->image }}" alt="">
                </td>
                <td>
                    @if ($order->delivery_status  =='processing')
                    <a onclick="return confirm('R u sure to cancel order!')"
                     href="{{ url('cancel_order',$order->id) }}" class="btn btn-danger">Cancel order</a>  
                     @else
                     <p style="color: red;">not allowed</p>                      
                    @endif
                </td>
            </tr>
            @endforeach
            
         </table>
      </div>
      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>