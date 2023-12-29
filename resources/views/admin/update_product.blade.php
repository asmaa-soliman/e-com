<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
  
   @include('admin.css')
   <style class="text/css">
   .div_center{
    text-align: center;
    padding-top: 40px;
   }
   .fot_size{
    font-size: 40px;
    padding-bottom: 40px;

   }
   .text_color{
    color: black;
    padding-bottom: 20px;
   }
label{
    display: inline-block;
    width: 180px;
}
div,input{
    padding-bottom: 20px
}
   </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
     @include('admin.sidebar')
      <!-- partial -->
     @include('admin.header')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                @if (session()->has('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" 
                    aria-hidden="true">x</button>
                    {{session()->get('message')}}
                </div>
                @endif
                <div class="div_center">
                    <h1 class="fot_size">update Product</h1>
                    <form action="{{ url('/update_product_confirm',$product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div>
                       <label for=""> Product Title : </label>
                       <input required=""class="text_color" type="text" value="{{ $product->title }}" 
                       name="title" id="" placeholder="write a title">
                    </div>
                    <div>
                       <label for="">Product Description</label>
                       <input required="" class="text_color" type="text" value="{{ $product->description }}"
                        name="description" id="" placeholder="write a description">
                    </div>
                    <div>
                        <label for=""> Product Price : </label>
                        <input required="" class="text_color" type="number" value="{{ $product->price }}"
                         name="price" id="" placeholder="write a price">
                     </div>
                     <div>
                        <label for=""> Discount Price : </label>
                        <input class="text_color" type="number" name="dis_price" value="{{ $product->discount_price }}"
                        id="" placeholder="write discount">
                     </div>
                     <div>
                        <label for=""> Product  Quantity : </label>
                        <input required="" class="text_color" type="number" name="quantity" value="{{ $product->quantity }}"
                          min="0" id="" placeholder="write a quantity">
                     </div>
                     <div>
                        <label for=""> Product  Category : </label>
                        {{-- real value from the product category --}}
                        <select  class="text_color" name="category" id="" required="">
                            <option value="{{ $product->category }}" selected="">{{ $product->category }}</option>
                            {{-- @foreach ($category as $category )
                            <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                            @endforeach --}}
                        </select>
                     </div>
                     <div>
                        <label for=""> current Product  Image : </label>
                        <img width="150" style="margin:auto; height="150" src="/product/{{ $product->image }}" alt="">
                     </div>
                     <div>
                        <label for=""> Change Product  Image : </label>
                        <input type="file" name="image" id="" >
                     </div>
                     <div>
                        <input type="submit" value="Update Product" class="btn btn-primary">
                     </div>  
                    </form> 
                </div>
            </div>
        </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
 @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>
