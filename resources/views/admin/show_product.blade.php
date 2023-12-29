<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
   @include('admin.css')
   <style class="text/css">
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
                <h2 class="h2_font">All Products</h2>
                <table  class="table center">
                    <tr class="tr1">
                        <th>Product <Title></Title></th>
                        <th>Descreption</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>color</th>
                        <th>Price</th>
                        <th>Discount Price</th>
                        <th>Image</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    @foreach ($product as $product)
                    <tr>
                        <td>{{ $product->title  }}</td>
                        <td>{{ $product->description  }}</td>
                        <td>{{ $product->quantity  }}</td>
                        <td>{{ $product->category  }}</td>
                        <td>{{ $product->color  }}</td>
                        {{-- <td>{{ implode(', ', $product->color ? explode(',', $product->color) : [""]) }}</td>
                        <td>{{ implode(', ', $product->color->pluck('color_name')->toArray()) }}</td> --}}
                        <td>{{ $product->price  }}</td>
                        <td>{{ $product->discount_price  }}</td>
                        <td>
                            <img  src="/product/{{ $product->image }}" alt="">
                        </td>
                        <td>
                            <a class="btn btn-success"  href="{{ url('update_product',$product->id) }}">Edit</a>
                        </td>
                        <td>
                            {{-- لما نضغط علي الزرار هيودينا للراوت ده --}}
                            <a class="btn btn-danger" onclick="return confirm('are u sure to confirm deleting!?')" href="{{ url('delete_product',$product->id) }}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
 @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>

