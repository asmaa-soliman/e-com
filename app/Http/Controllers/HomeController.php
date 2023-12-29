<?php

namespace App\Http\Controllers;
// to get data of usr from data base
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Color;
use App\Models\Order;
use App\Models\User;
use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Stripe;
use RealRashid\SweetAlert\Facades\Alert;
// use Illuminate\Support\Facades\stripe;
// use Session;
// use Illuminate\Contracts\Session\Session as SessionSession;


class HomeController extends Controller
{
    // وهنستخدم كومباكت ع لما تجيبو ترجعو لنفس الفيو  get باستخجام مودل اليوزرداخل الداله دي هنجيب كل البروداكت داتا وهتبعتها لفيو اليوزر 
    public function index(){
        // بستخدمها لو عاوز احدد هعرض اد ايه من الداتا بيز
        // $product=Product::all();
        $product=Product::paginate(10);
        $comment=Comment::orderby('id','desc')->get(); 
        $reply=reply::all();
        return view('home.userpage',compact('product','comment','reply'));
        
    }
    public function redirect(){
        // when user try login
        $usertype=Auth::user()->usertype;
        if($usertype=='1'){
            // count data in dashboard card
            $total_product=product::all()->count();
            $total_order=order::all()->count();
            $total_user=user::all()->count();
            $order=order::all();
            $total_reveune=0;
            foreach($order as $order)
            {
                $total_reveune=$total_reveune+$order->price;
            }
            // compare between them and avg
            $avg_revenue = order::avg('price');
            if($total_reveune>$avg_revenue){
                $arrow_color = 'icon icon-box-success';
                $arrow_direction = 'mdi mdi-arrow-top-right';
            }else{
                $arrow_color = 'icon icon-box-danger';
                $arrow_direction = 'mdi mdi-arrow-bottom-left';
            }

            $total_delivered=order::where('delivery_status','=','delivered')->get()->count();
            $total_Processing=order::where('delivery_status','=','processing')->get()->count();
            return view('admin.home',compact('total_product','total_order','total_user','total_reveune','arrow_color','arrow_direction','avg_revenue','total_delivered','total_Processing'));
        }
        else{
            // return view('home.userpage');
            // get prod and then sending to
            $product=Product::paginate(10); 
            // get all comment
            $comment=comment::all();
            // get all reply
            $reply=reply::all();
            return view('home.userpage',compact('product','comment','reply'));
        }
    }

    public function product_details($id){
        $product=Product::find($id); 
        $color=Color::all();
        return view('home.product_details',compact('product','color'));

    }
    public function add_cart(Request $request, $id){
        if(Auth::id())
        {
            $user=Auth::user();
            $userid=$user->id;
            // get user data
            // dd($user);
            $product=product::find($id);
            // if productid = userid in carts table then increse product dont repeat itbelongs to any user id or not
            $product_exist_id=cart::where('product_id','=',$id)->where('user_id','=',$userid)->get('id')->first();
            if($product_exist_id){
                $cart=cart::find($product_exist_id)->first();
                $quantity=$cart->quantity;
                // upload quantity to cart table
                $cart->quantity=$quantity+$request->quantity;
                if($product->discount_price!=null){
                    $cart->price=$product->discount_price * $cart->quantity;
    
                }else{
                    $cart->price=$product->price*$cart->quantity;
                }
                $cart->save();
                Alert::success('Product Added Successfully','we have adde product to the cart');
                return redirect()->back();
                // return redirect()->back()->with('message','Product added successfully!');
            }
            else{
                $color=color::find($id);
            $cart=new cart;
            $cart->name=$user->name;
            $cart->email=$user->email;
            $cart->phone=$user->phone;
            $cart->address=$user->address;
            $cart->user_id=$user->id;
            $cart->product_title=$product->title;
            if($product->discount_price!=null){
                $cart->price=$product->discount_price * $request->quantity;

            }else{
                $cart->price=$product->price*$request->quantity;
            }
            
            $cart->image=$product->image;
            $cart->product_id=$product->id;
            $cart->quantity=$request->quantity;
            $cart->color_id=$color->color_name;
            // $cart->color->color_id=$color->color_name;
            $cart->save();
            return redirect()->back()->with('message','Product added successfully!');
        }
                
            }
            else
        {
            return redirect('login');
        }
    }
    public function show_cart(){
        if(Auth::id()){
        // get user ioggin id
        $id=Auth::user()->id;
        $cart=cart::where('user_id','=',$id)->get();
        $color=color::find($id);
        return view('home.showcart',compact('cart','color'));
        }
        else{
            return redirect('login');
        }
    }
    public function remove_cart($id){
        $cart=cart::find($id);
        $cart->delete();
        return redirect()->back();

    }
    public function cash_order(){
        // auth to get logged in user data then delete from cart
        $user=Auth::user();
        $userid=$user->id;
        $data=Cart::where('user_id','=',$userid)->get();
        // dd($data);this is multiple data so we use foreah
        foreach($data as $data){
            $order=new order;
            $order->name=$data->name;
            $order->email=$data->email;
            $order->phone=$data->phone;
            $order->address=$data->address;
            $order->user_id=$data->user_id;
            $order->product_title=$data->product_title;
            $order->price=$data->price;
            $order->quantity=$data->quantity;
            $order->image=$data->image;
            $order->product_id=$data->product_id;
            $order->payment_status='cash on delivery';
            $order->delivery_status='processing';
            $order->save();

            $cart_id=$data->id;
            $cart=cart::find($cart_id);
            $cart->delete();
        }

        return redirect()->back()->with('message','we have recived your order.we will connect with you soon.'); 
    }


    // payment method
    public function stripe($totalprice){
        return view('home.stripe',compact('totalprice'));
    }

    // do this func after validation 
    public function stripePost(Request $request,$totalprice)
    {
        // dd($totalprice);can charge this amount to user
        stripe\stripe::setApiKey(env('STRIPE_SECRET'));
         
        // charge the customer
        stripe\Charge::create ([
                "amount" => $totalprice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "thanx for payment." 
        ]);


        // بعد عملية الدفع كل البرودكت هتروح علي الاوردر تيبول
        $user=Auth::user();
        // getting login user id in carts table
        $userid=$user->id;
        $data=Cart::where('user_id','=',$userid)->get();
        // dd($data);this is multiple data so we use foreah
        foreach($data as $data){
            $order=new order;
            $order->name=$data->name;
            $order->email=$data->email;
            $order->phone=$data->phone;
            $order->address=$data->address;
            $order->user_id=$data->user_id;
            $order->product_title=$data->product_title;
            $order->price=$data->price;
            $order->quantity=$data->quantity;
            $order->image=$data->image;
            $order->product_id=$data->product_id;
            $order->payment_status='paid';
            $order->delivery_status='processing';
            $order->save();

            $cart_id=$data->id;
            $cart=cart::find($cart_id);
            $cart->delete();
        }
      
        Session::flash('success', 'Payment successful!');
              
        return back();
    }
    public function show_order(){

        if(Auth::id()){
            // show specific order to specific us
        // get the loged in user
        $user=Auth::user();
        $userid=$user->id;
        $order=order::where('user_id','=',$userid)->get();
        return view('home.order',compact('order'));
    }else
    {
        return redirect('login');
    }
}
public function cancel_order($id){
    $order=order::find($id);
    $order->delivery_status='u canceled this order!';
    $order->save();
    return redirect()->back();

}
public function add_comment(Request $request){
    // insert comment data in comment table(upload)
    if(Auth::id()){
        $comment = new Comment;
        // gwt the user name
        $comment->name=Auth::user()->name; 
        $comment->user_id=Auth::user()->id;  
        // request comment from text area
        $comment->comment=$request->comment;
        $comment->save();
        return redirect()->back();   
    }
    else
    {
        return redirect('login');
    }
}
public function add_reply(Request $request){
    if(Auth::id()){
        $reply=new reply;
        $reply->name=Auth::user()->name; 
        $reply->user_id=Auth::user()->id;
        // name of reply fron name of its text book  
        $reply->comment_id=$request->commentId;
        $reply->reply=$request->reply;
        $reply->save();
        return redirect()->back();
    }
    else
    {
        return ('login');
    }       
}

// request coz we want to get search request from name of input search
public function product_search(Request $request){
    $comment=Comment::orderby('id','desc')->get(); 
    $reply=reply::all();
    $search_text=$request->search;
    $search_by = $request->search_by;
    // first var in foreach loop ;which produ want to search.like معناها سيميلير تو 
    // search by title and category
    // $product=Product::where('title','LIKE',"$search_text")->paginate(10);
    $product = Product::where(function ($query) use ($search_text, $search_by) {
        if ($search_by == 'title') {
            $query->where('title', 'LIKE', "%$search_text%");
        } elseif ($search_by == 'category') {
            $query->where('category', 'LIKE', "$search_text");
        }
    })->paginate(10);

    return view('home.userpage',compact('product','comment','reply'));
}
public function product(){
    // حطينا ال3 دول لانه في داتا بتاجي من الداتا بيز
    $product=Product::paginate(10);
    $comment=Comment::orderby('id','desc')->get(); 
    $reply=reply::all();
    return view('home.all_product',compact('product','comment','reply'));
}
public function search_product(Request $request){
    $comment=Comment::orderby('id','desc')->get(); 
    $reply=reply::all();
    $search_text=$request->search;
    $search_by = $request->search_by;
    // first var in foreach loop ;which produ want to search.like معناها سيميلير تو 
    // search by title and category
    // $product=Product::where('title','LIKE',"$search_text")->paginate(10);
    $product = Product::where(function ($query) use ($search_text, $search_by) {
        if ($search_by == 'title') {
            $query->where('title', 'LIKE', "%$search_text%");
        } elseif ($search_by == 'category') {
            $query->where('category', 'LIKE', "$search_text");
        }
    })->paginate(10);

    return view('home.all_product',compact('product','comment','reply'));
}
}
