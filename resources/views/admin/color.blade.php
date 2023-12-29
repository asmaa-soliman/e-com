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
        .h2_font{
            font-size: 40px;
            padding-bottom: 40; 
        }
        .input_color{
            color: black
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
                    <h2 class="h2_font" >Add Color</h2>

                    <form action="{{ url('/add_color') }}" method="POST">
                        @csrf
                        <input type="text" class="input_color" name="color" placeholder="Write Color Name">
                        <input type="submit" name="submit" class="btn btn-primary" value="Add Color">
                    </form>
                </div>
                {{-- to show cates --}}
                <table class="table center">
                    <thead>
                    <tr class="tr1">
                        <td >Color Name</td>
                        <td>Action</td>
                    </tr>
                </thead>
                    @foreach ( $data as $data )
                    <tr>
                        <td>{{ $data->color_name }}</td>
                        <td>
                            <a onClick="return confirm('ar u sure to delete!?')" href="{{ url('delete_color',$data->id) }}" class="btn btn-danger">Delete</a>
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