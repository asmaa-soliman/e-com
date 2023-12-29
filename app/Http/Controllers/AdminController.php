<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Color;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Notifications\Notification as NotificationsNotification;
// use Illuminate\Notifications\Notification;
use Notification;
use PDF;
use App\Notifications\SendEmailNotification;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function view_category(){
        if(Auth::id()){
            // getting data from cat table using act model بعدين نبعتها لادمن فيو كاتيجورى
        $data=Category::all();
        return view('admin.category',compact('data'));
        }
        else{
            return redirect('login');
        }
        
    }

    public function add_category(Request $request){
        if(Auth::id()){
        // cat data come from data base
        $data= new Category;
        $data->category_name=$request->category;
        $data->save();
        return redirect()->back()->with('message','cats added successfuly');
        }
        else{
            return redirect('login');
        }
    }
    public function delete_category($id){
        if(Auth::id()){
        $data=Category::find($id);
        $data->delete();
        return redirect()->back()->with('message','cats deleted successfuly');
        }
        else{
            return redirect('login');
        }

    }
    public function view_product(){
        if(Auth::id()){
        $category=category::all();
        $color=color::all();
        return view('admin.product',compact('category','color'));
        }
        else{
            return redirect('login');
        }
    }
    public function add_product(Request $request){
        if(Auth::id()){
        $product=new product;
        // get dataالجدول برودكت فيه عمود اسمه تايتل قيمته هتساوي الريكوست اللي جاي من الفورم اللي واخد اسم اسمه تاييتل
        $product->title=$request->title;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->quantity=$request->quantity;
        $product->discount_price=$request->dis_price;
        $product->category=$request->category;
        // هنبعت الكالر في ارراي
        
        $product->color=$request->color_name;
        // هنجيب الصورة ونخزنها في  المتغير ده
        $image=$request->image;
        // هندي للصوره ينيك نيم باستخدام دالة النتايم
        $imagename=time().'.'.$image->getClientOriginalExtension();
        // هنحفظ الصوره فين
        $request->image->move('product',$imagename);
        $product->image=$imagename;
        // store data in the db
        $product->save();
        return redirect()->back()->with('message','Product Added Successfuly');
        }
        else{
            return redirect('login');
        }
    }
    // show_product
    // send product data to blade view
    public function show_product(){
        if(Auth::id()){
        // get data
        $product=product::all();
        return view('admin.show_product',compact('product'));
        }
        else{
            return redirect('login');
        }
    }
    // $id علشان يجيب الاي دي من الراوت
    public function delete_product($id){
        if(Auth::id()){
        $product=Product::find($id);
        $product->delete();
        // علشان  بعد المسح يظهر نفس الصفحه
        return redirect()->back()->with('message','product deleted successfuly');
        }
        else{
            return redirect('login');
        }

    }
    public function update_product($id){
        if(Auth::id()){
        $product=Product::find($id);
        $category=Category::all();
        return view('admin.update_product',compact('product','category'));
        }
        else{
            return redirect('login');
        }
    }

    public function update_product_confirm(Request $request,$id){
        if(Auth::id()){
        $product=Product::find($id);
        $product->title=$request->title;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->quantity=$request->quantity;
        $product->discount_price=$request->dis_price;
        $product->category=$request->category;
        $image=$request->image;
        if($image){
            // لو مافيش صوره
            $imagename=time().'.'.$image->getClientOriginalExtension();
        $request->image->move('product',$imagename);
         //  store image in data base  
         $product->image=$imagename;

        }
        
         $product->save();
        return redirect()->back()->with('message','product updated successfuly');
    }

        else{
            return redirect('login');
        }
   
    }

    public function order(){
        if(Auth::id()){
        // send order data and order var to view using compact
        $order=order::all();
        return view('admin.order',compact('order'));
        }
        else{
            return redirect('login');
        }
    }
    public function delivered($id){
        if(Auth::id()){
        $order=order::find($id);
        $order->delivery_status="delivered";
        $order->payment_status="paid";
        $order->save();
        return redirect()->back();
        }
        else{
            return redirect('login');
        } 
    }
    public function print_pdf($id){
        if(Auth::id()){
        $order=order::find($id);
        $pdf=PDF::loadView('admin.pdf', compact('order'));
        return $pdf->download('order_details.pdf');
        }
        else{
            return redirect('login');
        }
    }
    public function send_email($id){
        if(Auth::id()){
        $order=order::find($id);
        return view('admin.email_info',compact('order'));
        }
        else{
            return redirect('login');
        }

    }
    // $requestto get data من form name
    public function send_user_email(Request $request,$id){
        if(Auth::id()){
        $order=order::find($id);
        // every input data will be stored in this var
         $details=[
            'greeting'=>$request->greeting,
            'firstline'=>$request->firstline,
            'body'=>$request->body,
            'button'=>$request->button,
            'url'=>$request->url,
            'lastline'=>$request->lastline,

        ];
        // whan i submit buttn email wil be send from
        Notification::send($order,new SendEmailNotification($details));
        return redirect()->back();
        }
        else{
            return redirect('login');
        }
        
    }
   

    // color///////////////////////////
    public function view_color(){
        if(Auth::id()){
        // getting data from color table using act model بعدين نبعتها لادمن فيو color
        $data=Color::all();
        return view('admin.color',compact('data'));
        }
        else{
            return redirect('login');
        }
    }

    public function add_color(Request $request){
        if(Auth::id()){
        // cat data come from data base
        $data= new Color;
        $data->color_name=$request->color;
        $data->save();
        return redirect()->back()->with('message','colors added successfuly');
        }
        else{
            return redirect('login');
        }
    }
    public function delete_color($id){
        if(Auth::id()){
        $data=Color::find($id);
        $data->delete();
        return redirect()->back()->with('message','colors deleted successfuly');
        }
        else{
            return redirect('login');
        }

    }
    // search for showing data from order.blade page
    public function searchdata(Request $request){
        if(Auth::id()){
        // from search form input name
        $searchText=$request->search;
        // =order(table name)
        $order=order::where('name','LIKE',"%$searchText%")->orWhere('phone','LIKE',"%$searchText%")
        ->orWhere('product_title','LIKE',"%$searchText%")->get();
        return view('admin.order',compact('order'));

        }
        else{
            return redirect('login');
        }
    }
    
}
