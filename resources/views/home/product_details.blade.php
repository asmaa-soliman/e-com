<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      {{-- to css style --}}
      {{-- <base href="/public"> --}}
      {{-- asset =proper way to write URL in laravel --}}
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
   </head>
   <body>
      <div class="hero_area">
        <!--  header section -->
        @include('home.header');
        <!-- end header section -->

      {{-- show details --}}
      <div class="col-sm-6 col-md-4 col-lg-4" style="margin: auto; width:50%; padding:30px">
           <div class="img-box" style="padding:20px">
              <img src="/product/{{ $product->image }}" alt="">
           </div>
           <div class="detail-box">
              <h5>
                {{$product->title}}
              </h5>
              @if ($product->discount_price!=null)
              <h6 style="color:#f7444e;">
                discount
                <br>
                ${{$product->discount_price}}
             </h6>
             {{-- بيحط كروس علي البرايس --}}
             <h6 style="text-decoration: line-through;color:#002c3e;">
                price
                <br>
                ${{$product->price}}
             </h6>
             @else
             <h6 style="color: #002c3e;">
                price
                <br>
                ${{$product->price}}
             </h6>
             @endif
             
             <h6> Product Category : <br>
                {{$product->category}}</h6>
             <h6> Product details : <br>
                {{$product->description}}</h6>
             <h6> Availaible Quantity : <br>
                 {{$product->quantity}}</h6>
                 <form action="{{ url('add_cart',$product->id) }}" method="POST">
                  @csrf
                  <div class="row">
                     <div class="col-md-4">
                  <input type="number" name="quantity" value="1" min="1" style="width: 100%">
                  </div>
                  <div>
                  <h6> Product color : <br>
                     {{$product->color}}</h6>
                     @foreach ($color as $color)
                <input type="checkbox" name="colors[]" value="{{ $color->id }}" id="color{{ $color->id }}">
                <label for="color{{ $color->id }}">{{ $color->color_name }}</label>
               @endforeach
            </div>
                  <div class="col-md-4">
                  <input type="submit" value="add to cart">
               </div>
               </div>
                </form>
                
           </div>
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