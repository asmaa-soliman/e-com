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
                    <h1 class="fot_size">Add Product</h1>
                    <form action="{{ url('/add_product') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div>
                       <label for=""> Product Title : </label>
                       <input required=""class="text_color" type="text" name="title" id="" placeholder="write a title">
                    </div>
                    <div>
                       <label for="">Product Description</label>
                       <input required="" class="text_color" type="text" name="description" id="" placeholder="write a description">
                    </div>
                    <div>
                        <label for=""> Product Price : </label>
                        <input required=""class="text_color" type="number" name="price" id="" placeholder="write a price">
                     </div>
                     <div>
                        <label for=""> Discount Price : </label>
                        <input class="text_color" type="number" name="dis_price" id="" placeholder="write discount">
                     </div>
                     <div>
                        <label for=""> Product  Quantity : </label>
                        <input required="" class="text_color" type="number" name="quantity"  min="0" id="" placeholder="write a quantity">
                     </div>
                     <div>
                        <label for=""> Product  Category : </label>
                        <select  class="text_color" name="category" id="" required="">
                            <option value="" selected="">Add A category Here :</option>
                            @foreach ($category as $category )
                            <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                     </div>
                     <div>
                        <label for=""> Product Color: </label>
                        @foreach($color as $color)
                            <label for="">
                                <input type="checkbox" class="text_color" name="color[]" id="" value=" ">
                                {{ $color->color_name }}
                            </label>
                        @endforeach
                    </div>
                     <div>
                        <label for=""> Product  Image : </label>
                        <input type="file" name="image" id="" required="">
                     </div>
                     <div>
                        <input type="submit" value="Add Product" class="btn btn-primary">
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
