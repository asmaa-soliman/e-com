<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
    <!-- Required meta tags -->
   @include('admin.css')
   <style>
    .title
    {
        text-align: center;
        font-size: 25px;
        font-weight: bold;
        color: rgb(0, 200, 255);
    }
    .center{
            margin: auto;
            width: 50%;
            text-align: center;
            margin-top: 30px;
            /* border: 3px solid gray; */
            color: white
        }
        label{
            display: inline-block;
            width: 300px;
            color: rgb(0, 200, 255);
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
                <form action="{{ url('send_user_email',$order->id) }}" method="post">
                    @csrf
                <h1 class="title">Send Email To {{ $order->email }}</h1>
                <div  class="center">
                    <label for="" style="padding-right: 30px"> Email Greeting   </label>
                    <input type="text" style="color: black;" name="greeting">
                </div>
                <div  class="center">
                    <label for="" style="padding-right: 30px"> Email FirstLine    </label>
                    <input type="text" style="color: black;" name="firstline">
                </div>
                <div  class="center">
                    <label for="" style="padding-right: 30px"> Email Body    </label>
                    <input type="text" style="color: black;"name="body">
                </div>
                <div  class="center">
                    <label for="" style="padding-right: 30px"> Email Button Name    </label>
                    <input type="text" style="color: black;"name="button">
                </div>
                <div  class="center">
                    <label for="" style="padding-right: 30px"> Email Url    </label>
                    <input type="text"style="color: black;" name="url">
                </div>
                <div  class="center">
                    <label for="" style="padding-right: 30px"> Email LastLine    </label>
                    <input type="text" style="color: black;"name="lastline">
                </div>
                <div  class="center">
                    <input type="submit"  value="Send Email" class="btn btn-primary">
                </div>
            </form>
            </div>
        </div>
      
    <!-- plugins:js -->
 @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>

