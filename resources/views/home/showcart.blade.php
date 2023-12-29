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
      <style type="text/css">
      .center{
        margin: auto;
        width: 50%;
        text-align: center;
        padding: 30px; 
      }
      table,th,td{
        border: 1px solid gray;
      }
      .th_deg{
        font-size: 30px;
        padding: 3px;
        background: #dddddd;
      }
      .img_deg{
        height: 150px;
        width: 150px;
      }

      </style>
   </head>
   <body>
      <div class="hero_area">
        <!--  header section -->
        @include('home.header');
        <!-- end header section -->
        @if (session()->has('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{session()->get('message')}}
                </div>
                @endif
     
      <div class="center">
        <table>
            <tr>
                <th class="th_deg">Product title</th>
                <th class="th_deg" >Product Quantity</th>
                <th class="th_deg">color</th>
                <th class="th_deg">Price</th>
                <th class="th_deg">Image</th>
                <th class="th_deg">Action</th>
            </tr>
            <?php $totalprice=0; ?>
            @foreach ($cart as $cart)
            <tr>
                <td>{{$cart->product_title}}</td>
                <td>{{$cart->quantity}}</td>
                <td>{{$cart->color_id}}</td>
                <td>${{$cart->price}}</td>
                <td> <img class="img_deg" src="/product/{{ $cart->image }}"></td>
                <td><a class="btn btn-danger" onclick="return confirm('Are you sure to delete this product?')" href="{{ url('/remove_cart',$cart->id) }}">Delete</a></td>

            </tr>
            <?php $totalprice=$totalprice + $cart->price; ?>
            @endforeach
        </table>
        <div><h1 style=" padding:40px;font-size:20px"><span style="color: red"> Total Price :</span>${{ $totalprice }} </h1></div>

        {{-- payment way --}}
        <div>
          <h1 style=" padding:20px;font-size:25px;color: red"> Order :</h1>
          <a class="btn btn-dark" href="{{ url('cash_order') }}">Cash</a>
          <a class="btn btn-dark" href="{{ url('stripe',$totalprice) }}">Card</a>
        </div>

      </div>
      
     
      
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
         
            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
         
         </p>
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