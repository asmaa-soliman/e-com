<section class="product_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
           {{-- to search --}}
           <br><br>
           <div>
             <form action="{{ url('search_product') }}" method="GET">
                @csrf
                <input style="width: 500px;" type="text" name="search" placeholder="search for something">
                <select name="search_by" style="background-color: #333333;color:white">
                   <option value="title">Search by Title</option>
                   <option value="category">Search by Category</option>
                </select>
                <input type="submit" value="search">
             </form>
          </div>
        </div>
        @if (session()->has('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" 
                    aria-hidden="true">x</button>
                    {{session()->get('message')}}
                </div>
                @endif
        <div class="row">
          @foreach ($product as $products )
           <div class="col-sm-6 col-md-4 col-lg-4">
              <div class="box">
                 <div class="option_container">
                    <div class="options">
                       <a href="{{ url('product_details',$products->id) }}" class="option1">
                       Product Details
                       </a>
                       <form action="{{ url('add_cart',$products->id) }}" method="POST">
                         @csrf
                         <div class="row">
                            <div class="col-md-4">
                         <input type="number" name="quantity" value="1" min="1" style="width: 100%">
                         </div>
                         <div class="col-md-4">
                         <input type="submit" value="add to cart">
                      </div>
                      </div>
                       </form>
                       
                    </div>
                 </div>
                 <div class="img-box">
                    <img src="product/{{ $products->image }}" alt="">
                 </div>
                 <div class="detail-box">
                    <h5>
                      {{$products->title}}
                    </h5>
                    @if ($products->discount_price!=null)
                    <h6 style="color:#f7444e;">
                      discount
                      <br>
                      ${{$products->discount_price}}
                   </h6>
                   {{-- بيحط كروس علي البرايس --}}
                   <h6 style="text-decoration: line-through;color:#002c3e;">
                      price
                      <br>
                      ${{$products->price}}
                   </h6>
                   @else
                   <h6 style="color: #002c3e;">
                      price
                      <br>
                      ${{$products->price}}
                   </h6>
                   @endif
                   
                 </div>
              </div>
           </div>
        @endforeach
        {{-- optin to going on mor page (paganate) --}}
        <span style="padding-top: 25px">
        {!!$product->appends(Request::all())->links('pagination::bootstrap-5')!!}
       </span>
       </div>
    </div>
  </section>