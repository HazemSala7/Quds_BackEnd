<?php

namespace App\Http\Controllers;

use App\Models\Account_Statement;
use App\Models\CatchReceipt;
use App\Models\Chks;
use App\Models\Customer;
use App\Models\Category;
use App\Models\FatoraProduct;
use App\Models\Catches;
use App\Models\Fawater;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Prices;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;


class CustomerController extends Controller
{
    public function filter_orders($company_id, $salesman_id,Request $request)
{
  $start = Carbon::parse($request->start_date);
  $end = Carbon::parse($request->end_date);
  $get_all_user = Fawater::whereDate('created_at','<=',$end->format('Y-m-d'))
  ->whereDate('created_at','>=',$start->format('Y-m-d'))->where("company_id", $company_id)->where("salesman_id", $salesman_id)->get();
  foreach ($get_all_user as $s) {
            $s->customer = Customer::where("id", $s->customer_id)->where("company_id", $company_id)->where("salesman_id", $salesman_id)->get();
        }
  return ["orders" => $get_all_user];
}
    public function filter_qabds($company_id, $salesman_id,Request $request)
{
  $start = Carbon::parse($request->start_date);
  $end = Carbon::parse($request->end_date);
  if($salesman_id=="999"){
      $get_all_user = Catches::whereDate('q_date','<=',$end->format('Y-m-d'))
  ->whereDate('q_date','>=',$start->format('Y-m-d'))->where("company_id", $company_id)->where("q_type", "sarf")->with('Customer')->get();
  }else {
      $get_all_user = Catches::whereDate('q_date','<=',$end->format('Y-m-d'))
  ->whereDate('q_date','>=',$start->format('Y-m-d'))->where("company_id", $company_id)->where("salesman_id", $salesman_id)->where("q_type", "sarf")->with('Customer')->get();
  }
  
  return ["qabds" => $get_all_user];
}
    public function filter_sarfs($company_id, $salesman_id,Request $request)
{
  $start = Carbon::parse($request->start_date);
  $end = Carbon::parse($request->end_date);
  $get_all_user = Catches::whereDate('q_date','<=',$end->format('Y-m-d'))
  ->whereDate('q_date','>=',$start->format('Y-m-d'))->where("company_id", $company_id)->where("salesman_id", $salesman_id)->where("q_type", "sarf")->with('Customer')->get();
  return ["qabds" => $get_all_user];
}

public function getKashfRedirect($cust_id,$comp_id){
    
return redirect()->to('https://jerusalemaccounting.yaghco.website/kashf/test.php?cust=${cust_id}&comp=${comp_id}');
}
public function addProductImage(Request $request)
    {
        $image_path = $request->file('images')->storeAs('public', "$request->company_id'_'$request->id.jpg");
        $fatora = Product::where('id',$request->id)->where("company_id", $request->company_id)->first();
        // $fatora->p_name = $request->p_name;
        // $fatora->company_id = $request->company_id;
        // $fatora->description = $request->description;
        // $fatora->category_id = $request->category_id;
        // $fatora->product_barcode = $request->product_barcode;
        $fatora->images = $image_path;
        $save = $fatora->save();
        if ($save) {
            $fatora->save();
            return ["status" => "true"];
        } else {
            return ["status" => "false"];
        }
    }

    
    
         
    public function delete_user($token){
    
    $count = User::where('device_id',$token)->delete();

    if($count > 0 ){
        return response()->json(['status'=>'true']);
    }
    else{
        return response()->json(['status'=>'false']);
    }
}
    public function edit_user(Request $request)
    {
        $validation = $request->validate([
            'device_id' => 'required',
        ]);
        $post = User::where('device_id', $request->device_id)->first();
        $post->name = $request->name;
        
        $post->company_id = $request->company_id;
        $post->salesman_id = $request->salesman_id;
        $save = $post->save();
        if ($save) {
            return ["status" => "true"];
        } else {
            return ["status" => "false"];
        }
    }
    function customers($company_id, $salesman_id)
    {
        // TODO: ACTIVE
        if($salesman_id=="999"){
          $customers = Customer::where("company_id", $company_id)->groupBy('id')->get();  
        }else {
            $customers = Customer::where("company_id", $company_id)->where("salesman_id", $salesman_id)->groupBy('id')->get();
        }
        return response([
            'customers' => $customers,
        ], 200);
    }
    function search($name, $company_id, $salesman_id)
    {
         if($salesman_id=="999"){
          $customers = Customer::where("company_id", $company_id)->where('c_name', 'LIKE', '%' . $name . '%')->get(); 
        }else {
            $customers = Customer::where("company_id", $company_id)->where("salesman_id", $salesman_id)->where('c_name', 'LIKE', '%' . $name . '%')->get();
        }

        if (count($customers)) {
            return  response([
                'customers' => $customers,
            ], 200);
        } else {
            return response([
                'customers' => $customers,
            ], 200);
        }
    }
    function search_products_barcode($company_id,$product_barcode)
    {

          $products = Product::where("company_id", $company_id)->where('product_barcode', $product_barcode)->get();
          foreach ($products as $z) {
            $z->product = Prices::where("company_id", $company_id)->where("product_id", $z->id)->get();
           
        }
        
 

        return response([
                'prodcuts' => $products,
            ], 200);
    }
    function categories($company_id)
    {
        // TODO: ACTIVE
       
          $customers = Category::where("company_id", $company_id)->get();  
       
        return response([
            'categories' => $customers,
        ], 200);
    }
    function qabds($company_id, $salesman_id)
    {
        // TODO: ACTIVE
        if($salesman_id=="999"){
          $qabds = Catches::where("company_id", $company_id)->where("q_type", "qabd")->get();  
        }else {
            $qabds = Catches::where("company_id", $company_id)->where("salesman_id", $salesman_id)->where("q_type", "qabd")->get();
        }
        foreach ($qabds as $s) {
            $s->customer = Customer::where("id", $s->customer_id)->where("company_id", $company_id)->get()[0];
        }
        
        return response([
            'qabds' => $qabds,
        ], 200);
    }
    function sarfs($company_id, $salesman_id)
    {
        // TODO: ACTIVE
        if($salesman_id=="999"){
          $qabds = Catches::where("company_id", $company_id)->where("q_type", "sarf")->get();  
        }else {
            $qabds = Catches::where("company_id", $company_id)->where("salesman_id", $salesman_id)->where("q_type", "sarf")->get();
        }
        foreach ($qabds as $s) {
            $s->customer = Customer::where("id", $s->customer_id)->where("company_id", $company_id)->get()[0];
        }
        return response([
            'qabds' => $qabds,
        ], 200);
    }
    function check_invoiceproducts($company_id, $salesman_id,$customer_id , $product_id)    
    {
        // TODO: ACTIVE
        $product=Product::where("id", $product_id)->get();
        $invoiceproducts = InvoiceProduct::where("company_id", $company_id)->where("salesman_id", $salesman_id)->where("customer_id", $customer_id)->where("product_id", $product_id)->latest()->get();
        

        return response([
            'invoiceproducts' => $invoiceproducts,
            'product' => $product,
            
        ], 200);
    }
    function getPriceBarcode($company_id, $salesman_id,$customer_id , $product_id)    
    {
        // TODO: ACTIVE
        $product=Product::where("product_barcode", $product_id)->get();
        $invoiceproducts = InvoiceProduct::where("company_id", $company_id)->where("salesman_id", $salesman_id)->where("customer_id", $customer_id)->where("product_id", $product_id)->latest()->get();
        

        return response([
            'invoiceproducts' => $invoiceproducts,
            'product' => $product,
            
        ], 200);
    }
    function products($company_id , $category_id, $salesman_id,$customer_id,$price_code)
    {
        // TODO: ACTIVE
        
        
        $products = Product::where("company_id", $company_id)->where("category_id", $category_id)->paginate(10);
        foreach ($products as $z) {
            $prices = Prices::where("company_id", $company_id)->where("product_id", $z->id)->get();
            $check = InvoiceProduct::where("company_id", $company_id)->where("salesman_id", $salesman_id)->where("customer_id", $customer_id)->where("product_id", $z->id)->latest()->get();
            $checkLength=$check->count();
            if($checkLength==0){
                if ($prices->count() == 0) {
                                      // return static price
                                      $z->price = "0";
                                    } else if ($prices->count() == 1) {
                                      $z->price = $prices[0]["price"];
                                    } else {
                                       $z->price = Prices::where("company_id", $company_id)->where("product_id", $z->id)->where("price_code",$price_code)->get()[0]["price"];

                                    //   $z->price =
                                    //       _price == "5" ? "0" : $_price["price"];
                                    }
            }else {
                $z->price=$check[0]["p_price"];
            }
        }
        foreach ($products as $s) {
            $s->images = "https://yaghco.website/quds_laravel/public/storage/$s->images";
            // $s->images = url('/') . '/storage/' . $s->images;
        }
        
        return response([
            'products' => $products,
        ], 200);
    }
    function get_specefic_product($id , $company_id)
    {
        // TODO: ACTIVE
        
        
        $products = Product::where("id", $id)->where("company_id", $company_id)->get();
         foreach ($products as $z) {
            $z->product = Prices::where("product_id", $z->id)->get();
        }
        
        return response([
            'products' => $products,
        ], 200);
    }
    function allProducts($company_id,$salesman_id,$customer_id,$price_code)
    {
        // TODO: ACTIVE
        
        $products = Product::where("company_id", $company_id)->paginate(10);
        foreach ($products as $z) {
            $prices = Prices::where("company_id", $company_id)->where("product_id", $z->id)->get();
            $check = InvoiceProduct::where("company_id", $company_id)->where("salesman_id", $salesman_id)->where("customer_id", $customer_id)->where("product_id", $z->id)->latest()->get();
            $checkLength=$check->count();
            if($checkLength==0){
                if ($prices->count() == 0) {
                                      // return static price
                                      $z->price = "0";
                                    } else if ($prices->count() == 1) {
                                      $z->price = $prices[0]["price"];
                                    } else {
                                       $z->price = Prices::where("company_id", $company_id)->where("product_id", $z->id)->where("price_code",$price_code)->get()[0]["price"];

                                    //   $z->price =
                                    //       _price == "5" ? "0" : $_price["price"];
                                    }
            }else {
                $z->price=$check[0]["p_price"];
            }
        }
        foreach ($products as $s) {
            $str2 = substr($s->images, 7);
            $s->images = "https://yaghco.website/quds_laravel/public/storage/$str2";
            // $s->images = $s->images;
        }
        return response([
            'products' => $products,
        ], 200);
    }
    function search_products($name, $company_id,$salesman_id,$customer_id,$price_code )
    {
        $products = Product::where("company_id", $company_id)->where('p_name', 'LIKE', '%' . $name . '%')->get();
        foreach ($products as $z) {
            $prices = Prices::where("company_id", $company_id)->where("product_id", $z->id)->get();
            $check = InvoiceProduct::where("company_id", $company_id)->where("salesman_id", $salesman_id)->where("customer_id", $customer_id)->where("product_id", $z->id)->latest()->get();
            $checkLength=$check->count();
            if($checkLength==0){
                if ($prices->count() == 0) {
                                      // return static price
                                      $z->price = "0";
                                    } else if ($prices->count() == 1) {
                                      $z->price = $prices[0]["price"];
                                    } else {
                                       $z->price = Prices::where("company_id", $company_id)->where("product_id", $z->id)->where("price_code",$price_code)->get()[0]["price"];

                                    //   $z->price =
                                    //       _price == "5" ? "0" : $_price["price"];
                                    }
            }else {
                $z->price=$check[0]["p_price"];
            }
        }
        if (count($products)) {
            return  response([
                'products' => $products,
            ], 200);
        } else {
            return response([
                'products' => $products,
            ], 200);
        }
    }
    function orders($company_id, $salesman_id)
    {
        // TODO: ACTIVE
        if($salesman_id=="999"){
          $orders = Fawater::where("company_id", $company_id)->get(); 
          foreach ($orders as $s) {
            $s->customer = Customer::where("id", $s->customer_id)->where("company_id", $company_id)->get();
        }
        }else {
            $orders = Fawater::where("company_id", $company_id)->where("salesman_id", $salesman_id)->get();
            foreach ($orders as $s) {
            $s->customer = Customer::where("id", $s->customer_id)->where("company_id", $company_id)->where("salesman_id", $salesman_id)->get();
        }
        }
        
        
        return response([
            'orders' => $orders,
        ], 200);
    }
    function getkashfs($id , $company_id, $salesman_id)
    {
        // TODO: ACTIVE
        if($salesman_id=="999"){
          $orders = FatoraProduct::where("company_id", $company_id)->where("fatora_id", $id)->where("f_code", 2)->get();  
        }else {
            $orders = FatoraProduct::where("fatora_id", $id)->where("company_id", $company_id)->where("f_code", 2)->with('product')->with('customers')->get();
        }
        
        return response([
            'orders_details' => $orders,
        ], 200);
    }
    function orderdetails($id , $company_id, $salesman_id)
    {
        // TODO: ACTIVE
        $orders = FatoraProduct::where("fatora_id", $id)->where("company_id", $company_id)->where("salesman_id", $salesman_id)->with('customers')->get();
         foreach ($orders as $s) {
            $s->product = Product::where("id", $s->product_id)->where("company_id",$company_id)->get()[0];
        }
        return response([
            'orders_details' => $orders,
        ], 200);
    }
    function statments($company_id ,$customer_id )
    {
        // TODO: ACTIVE
        
        $statments = Account_Statement::where("company_id", $company_id)->where("customer_id", $customer_id)->orderBy('action_date', 'asc')->get();
        foreach ($statments as $s) {
            if($s->action_type=="مبيعات"){
           $s->action = FatoraProduct::where("company_id", $company_id)->where("fatora_id", $s->action_id)->where("f_code", 2)->with('customers')->get(); 
           foreach ($s->action as $z) {
            $z->product = Product::where("id", $z->product_id)->where("company_id",$company_id)->get();
        }
        }else {
             $s->action =[];
        }
            
        }
         
        return response([
            'statments' => $statments,
        ], 200);
    }
    function invoices()
    {
        // TODO: ACTIVE
        $invoices = Invoice::all();
        return response([
            'invoices' => $invoices,
        ], 200);
    }
    function receipts($company_id, $salesman_id)
    {
        // TODO: ACTIVE
        if($salesman_id=="999"){
          $receipts = CatchReceipt::where("company_id", $company_id)->get();  
        }else {
            $receipts = CatchReceipt::where("company_id", $company_id)->where("salesman_id", $salesman_id)->get();
        }
        
        return response([
            'receipts' => $receipts,
        ], 200);
    }
    function invoiceproducts($company_id, $salesman_id)
    {
        // TODO: ACTIVE
        $invoiceproducts = InvoiceProduct::where("company_id", $company_id)->where("salesman_id", $salesman_id)->where("active", "true")->get();
        $total = InvoiceProduct::where("company_id", $company_id)->where("salesman_id", $salesman_id)->where("active", "true")->sum('total');

        foreach ($invoiceproducts as $s) {
            $s->product=Product::where("company_id",$company_id)->where("id",$s->product_id)->get()[0];
        }
        return response([
            'invoiceproducts' => $invoiceproducts,
            'total' => $total,
        ], 200);
    }
    
    public function add_catch_receipt(Request $request)
    {
        $catch = new CatchReceipt;
        $catch->store_id = $request->store_id;
        $catch->customer_id = $request->customer_id;
        $catch->company_id = $request->company_id;
        $catch->salesman_id = $request->salesman_id;
        $catch->discount = $request->discount;
        $catch->cash = $request->cash;
        $catch->notes = $request->notes;
        $catch->q_date = $request->q_date;
        $catch->q_time = $request->q_time;
        $catch->downloaded = $request->downloaded;
        $catch->q_type = $request->q_type;
        $catch->chks = "0";
        $catch->save();
        $total_amount = 0;
        if ($request->has("chk_no")) {
            foreach ($request->chk_no as $c => $k) {
                $chek = new Chks();
                $chek->qabd_id = $catch->id;
                $chek->q_type = $request->q_type;
                $chek->chk_no = $k;
                $chek->company_id = $request->company_id;
                $chek->chk_value = @$request->chk_value[$c];
                $chek->chk_date = @$request->chk_date[$c];
                $chek->account_no = @$request->account_no[$c];
                $chek->bank_no = @$request->bank_no[$c];
                $chek->bank_branch = @$request->bank_branch[$c];
                $chek->save();
                $total_amount += $request->chk_value[$c];
            }
            $catch->chks = $total_amount;
            $catch->save();
        } else {
            return "hhhh";
        }

        return response()->json([
            'message' => 'Catch Receipt created successfully',
        ], 201);
    }
    public function addcheek(Request $request)
    {
        $catch = new Chks();
        $qabd_id = CatchReceipt::where('id', $request->id);
        // $catch->qabd_id = $request->qabd_id;
        $catch->chk_no = $request->chk_no;
        $catch->chk_value = $request->chk_value;
        $catch->chk_date = $request->chk_date;
        $catch->account_no = $request->account_no;
        $catch->bank_no = $request->bank_no;
        $catch->bank_branch = $request->bank_branch;


        $catch->save();

        return response()->json([
            'status' => 'true',
        ], 201);
    }
    function get_orders(Request $request)
    {

        $user = $request->user()->id;
        $orders = Fawater::where('salesman_id', $request->salesman_id)->where('company_id', $request->company_id)->where('f_code', 1)->get();
        return response([
            'orders' => $orders,
        ], 200);
    }
    public function addFatora(Request $request)
    {
       $count_fatora_id = FatoraProduct::where('salesman_id', $request->salesman_id)->where('company_id', $request->company_id)->where('active', "true")->get()->count();
       
      


        if ($count_fatora_id == 0) {
            $max = FatoraProduct::where('salesman_id', $request->salesman_id)->where('company_id', $request->company_id)->where('active', "false")->orderby('fatora_id', 'desc')->first();
            
            
if (!$max) {
   $catch = new FatoraProduct();
            $catch->fatora_id = 0;
            $catch->salesman_id = $request->salesman_id;
            $catch->f_code = $request->f_code;
            $catch->customer_id = $request->customer_id;
            $catch->company_id = $request->company_id;
            $catch->product_id = $request->product_id;
            $catch->product_name = $request->product_name;
            $catch->p_quantity = $request->p_quantity;
            $catch->p_price = $request->p_price;
            $catch->bonus1 = $request->bonus1;
            $catch->bonus2 = $request->bonus2;
            $catch->discount = $request->discount;
            $catch->total = $request->total;
            $catch->notes = $request->notes;
            $catch->active = "true";
            $catch->save();
}else {$catch = new FatoraProduct();
            $catch->fatora_id = $max->fatora_id + 1;
            $catch->customer_id = $request->customer_id;
            $catch->f_code = $request->f_code;
            $catch->salesman_id = $request->salesman_id;
            $catch->company_id = $request->company_id;
            $catch->product_id = $request->product_id;
            $catch->product_name = $request->product_name;
            $catch->p_quantity = $request->p_quantity;
            $catch->p_price = $request->p_price;
            $catch->bonus1 = $request->bonus1;
            $catch->bonus2 = $request->bonus2;
            $catch->discount = $request->discount;
            $catch->total = $request->total;
            $catch->notes = $request->notes;
            $catch->active = "true";
            $catch->save();}
            
        } else {
            
            $count = FatoraProduct::where('product_id', $request->product_id)->where('company_id', $request->company_id)->where("active", "true")->where('salesman_id', $request->salesman_id)->get()->count();
            
            if ($count == 0) {
                $max = FatoraProduct::where('salesman_id', $request->salesman_id)->where('company_id', $request->company_id)->where('active', "true")->orderby('fatora_id', 'desc')->first();

                $catch = new FatoraProduct();
                $catch->fatora_id = $max->fatora_id;
                $catch->customer_id = $request->customer_id;
                $catch->f_code = $request->f_code;
                $catch->product_id = $request->product_id;
                $catch->product_name = $request->product_name;
                $catch->salesman_id = $request->salesman_id;
                $catch->company_id = $request->company_id;
                $catch->p_quantity = $request->p_quantity;
                $catch->p_price = $request->p_price;
                $catch->bonus1 = $request->bonus1;
                $catch->bonus2 = $request->bonus2;
                $catch->discount = $request->discount;
                $catch->total = $request->total;
                $catch->notes = $request->notes;
                $catch->active = "true";
                $catch->save();
            } else {
                $max = FatoraProduct::where('salesman_id', $request->salesman_id)->where('company_id', $request->company_id)->where('active', "true")->orderby('fatora_id', 'desc')->first();
                $catch = FatoraProduct::where('product_id', $request->product_id)->where("active", "true")->where('salesman_id', $request->salesman_id)->first();
                $catch->fatora_id = $max->fatora_id;
                $catch->f_code = $request->f_code;
                $catch->product_id = $request->product_id;
                $catch->product_name = $request->product_name;
                $catch->customer_id = $request->customer_id;
                $catch->salesman_id = $request->salesman_id;
                $catch->company_id = $request->company_id;
                $catch->p_quantity = $catch->p_quantity + $request->p_quantity;
                $catch->p_price = $request->p_price;
                $catch->bonus1 = $request->bonus1;
                $catch->bonus2 = $request->bonus2;
                $catch->discount = $request->discount;
                $catch->total = $catch->total + $request->total;
                $catch->notes = $request->notes;
                $catch->active = "true";
                $catch->save();
            }
        }


        return response()->json([
            'message' => 'Fatora created successfully',
        ], 201);
    }
    public function edit_fatora(Request $request)
    {

        $catch = FatoraProduct::find($request->id);
        $catch->fatora_id = $request->fatora_id;
        $catch->company_id = $request->company_id;
        $catch->f_code = $request->f_code;
        $catch->product_id = $request->product_id;
        $catch->p_quantity = $request->p_quantity;
        $catch->p_price = $request->p_price;
        $catch->bonus1 = $request->bonus1;
        $catch->bonus2 = $request->bonus2;
        $catch->discount = $request->discount;
        $catch->total = $request->total;
        $catch->notes = $request->notes;
        $catch->active = "true";
        $save = $catch->save();
        if ($save) {
            return ["status" => "true"];
        } else {
            return ["status" => "false"];
        }
    }
    function remove_fatora(Request $request)
    {
        // TODO: ACTIVE
        // $carts = Cart::all();
        $save1 = FatoraProduct::where('id', $request->id)->delete();
        if ($save1 == 1) {
            return ["status" => "true"];
        } else {
            return ["status" => "false"];
        }
    }
    
    


    public function add_order(Request $request)
    {


        $fatora = new Fawater();
        $total = InvoiceProduct::where("active", "true")->sum('total');
        $fatora->f_date = $request->f_date;
        $fatora->f_value = $request->f_value;
        $fatora->customer_id = $request->customer_id;
        $fatora->fatora_id = $request->fatora_id;
        $fatora->f_code = $request->f_code;
        $fatora->company_id = $request->company_id;
        $fatora->salesman_id = $request->salesman_id;
        $fatora->f_discount = $request->f_discount;
        $fatora->store_id = $request->store_id;
        $fatora->notes = $request->notes;
        $fatora->f_time = $request->f_time;
        $save = $fatora->save();
        if ($save) {
            $fatora->save();
            $invoicePros = InvoiceProduct::where('active', "true")->get();
            foreach ($invoicePros as $item) {
                $item->update(['active' => "false"]);
                $item->save();
            }

            return ["status" => "true"];
        } else {
            return ["status" => "false"];
        }
    }
    public function filter($company_id, $salesman_id,Request $filters )
    {
        // if no filters are provided, return an empty array
        if (!$filters->all()) {
            return response()->json([], 404);
        }

        $filters->validate([
            'name' => 'string|max:255',

        ]);

        $users = Customer::query();
        if($salesman_id=="999"){
            if ($filters->has('id')) {
            $users->where('id', $filters['id'])->where("company_id", $company_id);
        }
        }else{
          if ($filters->has('id')) {
            $users->where('id', $filters['id'])->where("company_id", $company_id)->where("salesman_id", $salesman_id);
        }  
        }
        



        if ($users->count()) {
            return response()->json([
                'count' => $users->count(),
                'customers' => $users->get(),
            ], 200);
        } else {
            return response()->json([
                'count' => 0,
                'customers' => [],
            ], 404);
        }
    }
    public function filterCustomersByName($company_id, $salesman_id,$name )
    {
        if($salesman_id=="999"){
            $result = Customer::where("company_id", $company_id)->where('c_name', 'LIKE', '%' . $name . '%')->get();
        }else{
           $result = Customer::where("company_id", $company_id)->where("salesman_id" , $salesman_id)->where('c_name', 'LIKE', '%' . $name . '%')->get(); 
        }
        

        if (count($result)) {
            return  response([
                'customers' => $result,
            ], 200);
        } else {
            return response([
                'customers' => $result,
            ], 200);
        }

    }
}
