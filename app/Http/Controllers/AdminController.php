<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Hash;

class AdminController extends Controller
{
    

    public function home()
    {

        if(!Auth::user())
        {

            return redirect()->route('login');
        }

        $usertype= Auth::user()->usertype;
        if($usertype!='1')
    	{
    		return redirect('/');
    	}

        return redirect('redirects');
    }

    public function food_menu()
    {

        if(!Auth::user())
        {
            return redirect()->route('login');

        }
        $usertype= Auth::user()->usertype;
        if($usertype!='1')
    	{
    		return redirect('/');
    	}


        $total_products=DB::table('products')->count();

        $fraction=$total_products % 3;

        $products=DB::table('products')->get();


        $fraction_products=DB::table('products')->latest()->get();

 
        return view('admin.menu',compact('products','fraction','total_products','fraction_products'));
    }
    
    public function chefs()
    {
        if(!Auth::user())
        {
            return redirect()->route('login');
        }
     
        $usertype= Auth::user()->usertype;
        if($usertype!='1')
    	{
    		return redirect('/');
    	}

        $total_chefs=DB::table('chefs')->count();

        $fraction=$total_chefs % 3;

        $chefs=DB::table('chefs')->get();

        $fraction_chefs=DB::table('chefs')->latest()->get();
 
        return view('admin.chefs',compact('chefs','fraction','total_chefs','fraction_chefs'));
    }

    public function order_incomplete()
    {
       // dd($orders);

       $orders=DB::table('carts')->where('product_order','yes')->orderBy('id', 'desc')
       ->groupBy('invoice_no')
       ->paginate(10);

        return view('admin.incomplete-orders',compact('orders'));
    }

    public function order_complete()
    {
       // dd($orders);

       $orders=DB::table('carts')->where('product_order','delivery')
       ->groupBy('invoice_no')
       ->paginate(10);

        return view('admin.complete_orders',compact('orders'));
    }

    public function reservation()
    {
        $reservations=DB::table('reservations')->orderBy('id', 'desc')->paginate(15);
 
        return view('admin.reservations',compact('reservations'));
    }
    
    public function add_menu()
    {
        return view('admin.add_menu');
    }

    public function add_chef()
    {
        return view('admin.add_chef');
    }

    public function coupon_show()
    {
        $coupons=DB::table('coupons')->get();

        return view('admin.coupons',compact('coupons'));
    }

    public function admin_show()
    {
        $admins=DB::table('users')->where('usertype','1')->orWhere('usertype','3')->get();

        return view('admin.admins',compact('admins'));
    }

    public function user_show()
    {
        $users=DB::table('users')->where('usertype','=','0')->get();

        return view('admin.users',compact('users'));
    }

    public function charge()
    {

        $charges=DB::table('charges')->get();


        return view('admin.charges',compact('charges'));


    }
    public function banner()
    {

        $banners=DB::table('banners')->get();


        return view('admin.banners',compact('banners'));


    }
    public function customize()
    {

        $customize=DB::table('about_us')->get();


        return view('admin.customize',compact('customize'));


    }
    public function banner_add()
    {

        return view('admin.add_banner');
    }

    public function menu_add_process(Request $req)
    {


        if($req->price < 0)
        {
            session()->flash('wrong','Valor de precio negativo no se acepta!');
            return back();
        }


        $this->validate(request(),[
            'name' => 'required',
            'image'=>'mimes:jpeg,jpg,png',
        ]);
     
     
        $uploadedfile=$req->file('image');
        $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/assets/images/'),$new_image);

        $data=array();
        $data['name']=$req->name;
        $data['description']=$req->description;
        $data['price']=$req->price;
        $data['catagory']=$req->catagory;
        $data['session']=$req->session;
        $data['available']=$req->available;
        $data['image']=$new_image;


        $insert=DB::table('products')->Insert($data);


        session()->flash('success','Menu agregado !');
        return back();



    }
    public function chef_add_process(Request $req)
    {
        $this->validate(request(),[
            'name' => 'required',
            'job_title' => 'required',
            'image'=>'mimes:jpeg,jpg,png',
        ]);
     
        $uploadedfile=$req->file('image');
        $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/assets/images/'),$new_image);

        $data=array();
        $data['name']=$req->name;
        $data['job_title']=$req->job;
        $data['facebook_link']=$req->fb;
        $data['twitter_link']=$req->twitter;
        $data['instragram_link']=$req->instagram;
        $data['image']=$new_image;


        $insert=DB::table('chefs')->Insert($data);

        session()->flash('success','Chef agregado !');
        return back();
    }

    public function menu_delete_process($id)
    {
        $delete=DB::table('products')->where('id',$id)->delete();

        session()->flash('success','Menu eliminado !');
        return back();
    }

    public function chef_delete_process($id)
    {

        $delete=DB::table('chefs')->where('id',$id)->delete();

        session()->flash('success','Chef eliminado !');
        return back();

    }

    public function menu_edit($id)
    {



        $products=DB::table('products')->where('id',$id)->get();

        
        return view('admin.menu_edit',compact('products'));



    }
    public function chef_edit($id)
    {



        $chefs=DB::table('chefs')->where('id',$id)->get();

        
        return view('admin.chef_edit',compact('chefs'));



    }
    public function menu_edit_process(Request $req,$id)
    {


        if($req->price < 0)
        {

            session()->flash('wrong','Valor de precio negativo no se acepta !');
            return back();

        }

        $data=array();
        $data['name']=$req->name;
        $data['description']=$req->description;
        $data['price']=$req->price;
        $data['catagory']=$req->catagory;
        $data['session']=$req->session;
        $data['available']=$req->available;

        if($req->image!=NULL)
        {

            $this->validate(request(),[
                'image'=>'mimes:jpeg,jpg,png',
            ]);
         
         
            $uploadedfile=$req->file('image');
            $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image);

            $data['image']=$new_image;

        }
  


        $update=DB::table('products')->where('id',$id)->Update($data);


        session()->flash('success','Menu actualizado!');
        return back();

    }



    public function chef_edit_process(Request $req,$id)
    {

        $data=array();
        $data['name']=$req->name;
        $data['job_title']=$req->job;
        $data['facebook_link']=$req->fb;
        $data['twitter_link']=$req->twitter;
        $data['instragram_link']=$req->instagram;
       
        if($req->image!=NULL)
        {

            $this->validate(request(),[

                'image'=>'mimes:jpeg,jpg,png',
            ]);
         
         
            $uploadedfile=$req->file('image');
            $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image);

            $data['image']=$new_image;

        }


        $update=DB::table('chefs')->where('id',$id)->Update($data);


        session()->flash('success','Chef actualizado!');
        return back();
    }

    public function invoice_approve(Request $req,$id)
    {
        $data=array();

        $data['product_order']="approve";
    
       // return $req->time;

        $time_set_up=strtotime($req->time);
        $time_set_up=date("F j, Y, G:i:sa", $time_set_up);

        $req->time=$time_set_up;
       // return $req->time;
        $data['delivery_time']=$req->time;


        $details = [
            'title' => 'Mail from RMS Admin',
            'body' => 'Your order approved by RMS.Your order Invoice no - '.$id.' & Delivery Time (approximately) - '.$req->time,
        ];

        $products=DB::table('carts')->where('invoice_no',$id)->get();

        foreach($products as $product)
        {
            $user_id=$product->user_id;
            $status=$product->product_order;
        }
        
        if($status!="approve")
        {
            $details = [
                'title' => 'Mail from RMS Admin',
                'body' => 'Your order Invoice no - '.$id.' Delivery Time (approximately) - '.$req->time,
            ];
            
            $user=DB::table('users')->where('id',$user_id)->first();
        
            \Mail::to($user->email)->send(new \App\Mail\ApproveMail($details));

            $update=DB::table('carts')->where('invoice_no',$id)->Update($data);

            session()->flash('success','Pedido Aprobado !');
            return back();

        }
        else
        {
            $details = [
                'title' => 'Mail from RMS Admin',
                'body' => 'Your order approved by RMS.Your order Invoice no - '.$id.' & Delivery Remaining Time (approximately) - '.$req->time,
            ];

            
            $user=DB::table('users')->where('id',$user_id)->first();
        
            \Mail::to($user->email)->send(new \App\Mail\ApproveMail($details));

            $update=DB::table('carts')->where('invoice_no',$id)->Update($data);

            session()->flash('success','Ubicación del pedido actualizada correctamente!');
            return redirect('/order/location');
        }

    }

    public function invoice_details($id)
    {
       
       $products=DB::table('carts')->where('invoice_no',$id)->get();
       $charges=DB::table('charges')->get();

        $total_price=DB::table('carts')->where('invoice_no',$id)->sum('subtotal');
        $wihout_discount_price=$total_price;
        foreach($products as $product)
        {

            $coupon_code=$product->coupon_id;

        }

        $coupon_code_price=DB::table('coupons')->where('code',$coupon_code)->value('percentage');

        $coupon_code_price=floor($coupon_code_price);

        $discount_price=(($total_price*$coupon_code_price)/100);
        $discount_price=floor($discount_price);

        $extra_charge=DB::table('charges')->get();
        $total_extra_charge=DB::table('charges')->sum('price');


        $total_price = $total_price - $discount_price;

        $total_price=$total_price+$total_extra_charge;
        $wihout_discount_price=$wihout_discount_price+$total_extra_charge;


        return view('admin.invoice_details',compact('total_price','extra_charge','total_extra_charge','discount_price','wihout_discount_price','products'));

    }
    public function invoice_cancel($id)
    {

        $data=array();

        $data['product_order']="cancel";


        $products=DB::table('carts')->where('invoice_no',$id)->get();

        foreach($products as $product)
        {

            $user_id=$product->user_id;
            $pay_method=$product->pay_method;
            $status=$product->product_order;

        }

        if($pay_method=="Online Payment")
        {

            $details = [
                'title' => 'Mail from RMS Admin',
                'body' => 'Sorry Sir.Your order cancelled by RMS for inevitable reason.You will get your money back within 8 working days..Your order Invoice no - '.$id,
            ];


        }
        else
        {


            $details = [
                'title' => 'Mail from RMS Admin',
                'body' => 'Sorry Sir.Your order cancelled by RMS for inevitable reason.Your order Invoice no - '.$id,
            ];


        }
        $user=DB::table('users')->where('id',$user_id)->first();
       
        \Mail::to($user->email)->send(new \App\Mail\ApproveMail($details));


        $update=DB::table('carts')->where('invoice_no',$id)->Update($data);


        if($status!="approve")
        {
            session()->flash('success','Pedido cancelado !');
            return back();

        }
        else
        {

            session()->flash('success','Pedido cancelado !');

            return redirect('/order/location');

        }
    }

    public function order_location()
    {
        return view('admin.order_loaction');

    }

    public function edit_order_location(Request $req)
    {

        $id=$req->id;

        $products=DB::table('carts')->where('invoice_no',$id)->count();


        if($products==0)
        {


            session()->flash('wrong','Invalido Folio !');
            return back();
    


        }

       $products=DB::table('carts')->where('invoice_no',$id)->get();



       foreach($products as $product)
       {


            $status=$product->product_order;


       }
       if($status!="approve")
       {
           session()->flash('wrong','Pedido no Aprobado !');
           return back();

       }

       $charges=DB::table('charges')->get();

        $total_price=DB::table('carts')->where('invoice_no',$id)->sum('subtotal');
        $wihout_discount_price=$total_price;
        foreach($products as $product)
        {
            $coupon_code=$product->coupon_id;
        }

        $coupon_code_price=DB::table('coupons')->where('code',$coupon_code)->value('percentage');

        $coupon_code_price=floor($coupon_code_price);

        $discount_price=(($total_price*$coupon_code_price)/100);
        $discount_price=floor($discount_price);

        $extra_charge=DB::table('charges')->get();
        $total_extra_charge=DB::table('charges')->sum('price');


        $total_price = $total_price - $discount_price;

        $total_price=$total_price+$total_extra_charge;
        $wihout_discount_price=$wihout_discount_price+$total_extra_charge;


        return view('admin.update_order_location',compact('total_price','extra_charge','total_extra_charge','discount_price','wihout_discount_price','products'));

    }

    public function orders_process()
    {
       // dd($orders);

       $orders=DB::table('carts')->where('product_order','approve')
       ->groupBy('invoice_no')
       ->paginate(10);

        return view('admin.process_order',compact('orders'));
    }

    public function orders_cancel()
    {
       // dd($orders);

       $orders=DB::table('carts')->where('product_order','cancel')
       ->groupBy('invoice_no')
       ->paginate(10);

        return view('admin.cancel_order',compact('orders'));
    }

    public function invoice_complete($id)
    {

        $data=array();

        $data['product_order']="delivery";


        $details = [
            'title' => 'Mail from RMS Admin',
            'body' => 'Your order delivered by RMS.Your order Invoice no - '.$id,
        ];

        $products=DB::table('carts')->where('invoice_no',$id)->get();

        foreach($products as $product)
        {


            $user_id=$product->user_id;
            $status=$product->product_order;

        }
            
            $user=DB::table('users')->where('id',$user_id)->first();
            \Mail::to($user->email)->send(new \App\Mail\ApproveMail($details));

            $update=DB::table('carts')->where('invoice_no',$id)->Update($data);

            session()->flash('success','Pedido entregado con éxito !');
            return back();

    }

    public function delivery_boy()
    {

        $delivery_boys=DB::table('users')->where('usertype','2')->get();


        return view('admin.delivery_boys',compact('delivery_boys'));


    }

    public function add_admin()
    {

        return view('admin.add_admin');
    }

    public function add_admin_process(Request $req)
    {

        $salary=$req->salary;

        if($salary < 0)
        {

            session()->flash('wrong','No se aceptan salarios negativos !');
            return back();


        }



        $email=DB::table('users')->where('email',$req->email)->count();


        if($email > 0)
        {

            session()->flash('wrong','Email ya registrado !');
            return back();


        }

        $phone=DB::table('users')->where('phone',$req->phone)->count();


        if($phone > 0)
        {
            session()->flash('wrong','Teléfono ya registrado !');
            return back();

        }
        if(strlen($req->password)<8)
        {
            session()->flash('wrong','La contraseña debe tener al menos 8 palabras!');
            return back();
        }

        if($req->password!=$req->confirm_password)
        {
            session()->flash('wrong','La contraseña no coincide !');
            return back();
        }

        $this->validate(request(),[
            'name' => 'required',
            'image'=>'mimes:jpeg,jpg,png',
        ]);
     
     
        $uploadedfile=$req->file('image');
        $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/assets/images/admin/'),$new_image);

        $data=array();
        $data['name']=$req->name;
        $data['email']=$req->email;
        $data['phone']=$req->phone;
        $data['usertype']=$req->type;
        $data['salary']=$req->salary;
        $data['profile_photo_path']=$new_image;
        $data['password']=Hash::make($req->password);


        if($req->type=='1')
        {


            $usertype="Super Admin";


        }
        else if($req->type=='3')
        {

            $usertype="Sub Admin";
        }

        $insert=DB::table('users')->Insert($data);

        $details = [
            'title' => 'Mail from RMS Admin',
            'body' => 'Congrats ! You are selected as a '.$usertype.' ( Salary - '.$req->salary.'Tk ) of RMS by RMS Admin Panel. Your Email ID - '.$req->email. ' & Password - '.$req->password,
        ];

        \Mail::to($req->email)->send(new \App\Mail\UserAddedMail($details));

        session()->flash('success','Admin agregado !');
        return back();

    }

    public function delete_admin($id)
    {

        $my_id=NULL;

        if(Auth::user()->id==$id)
        {

            $my_id="yes";

        }

        $details = [
            'title' => 'Mail from RMS Admin',
            'body' => 'Sorry ! You have been fired from your job by RMS Admin Panel.So, your account is deleted by RMS Admin Panel.',
        ];

        \Mail::to(Auth::user()->email)->send(new \App\Mail\UserAddedMail($details));

        $delete=DB::table('users')->where('id',$id)->delete();

        if($my_id=="yes")
        {
            return redirect::to('/login');
        }

        session()->flash('success','Admin eliminado !');
        return back();
    }
    
    public function edit_admin($id)
    {

        $admin=DB::table('users')->where('id',$id)->get();


        return view('admin.edit_admin',compact('admin'));


    }
    public function edit_admin_process(Request $req,$id)
    {

        $previous_salary=DB::table('users')->where('id',$id)->value('salary');
        $previous_position=DB::table('users')->where('id',$id)->value('usertype');

        if($req->salary < 0)
        {

            session()->flash('wrong','No se aceptan salarios negativos !');
            return back();
        }

        $email=DB::table('users')->where('email',$req->email)->where('id','!=',$id)->count();

        if($email > 0)
        {

            session()->flash('wrong','Email ya registrado !');
            return back();


        }

        $phone=DB::table('users')->where('phone',$req->phone)->where('id','!=',$id)->count();


        if($phone > 0)
        {

            session()->flash('wrong','Teléfono ya registrado !');
            return back();


        }


        $data=array();
        $data['name']=$req->name;
        $data['email']=$req->email;
        $data['phone']=$req->phone;
        $data['usertype']=$req->type;
        $data['salary']=$req->salary;
     

        if($req->image != NULL)
        {

            $this->validate(request(),[

                'image'=>'mimes:jpeg,jpg,png',
            ]);
         
         
            $uploadedfile=$req->file('image');
            $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/admin/'),$new_image);
            $data['profile_photo_path']=$new_image;


        }
        if($req->type=='1')
        {


            $usertype="Super Admin";


        }
        else if($req->type=='3')
        {


            $usertype="Sub Admin";


        }
   


        $update=DB::table('users')->where('id',$id)->Update($data);

        if($update)
        {
            $details = [
                'title' => 'Mail from RMS Admin',
                'body' => 'Congrats ! Your information is updated by RMS Admin Panel.',
            ];
    
    
            if(($req->salary != NULL && $req->salary > $previous_salary) || ($req->type !=NULL && $req->type < $previous_position))
            {
    
                
                $details = [
                    'title' => 'Mail from RMS Admin',
                    'body' => 'Congrats ! You are promoted for a '.$usertype.' position. ( Now, Your salary - '.$req->salary.'Tk ) of RMS by RMS Admin Panel.',
                ];
    
            }
            else if(($req->salary != NULL && $req->salary < $previous_salary) || ($req->type !=NULL && $req->type > $previous_position))
            {
    
    
                $details = [
                    'title' => 'Mail from RMS Admin',
                    'body' => 'Sorry ! You are depromoted for a '.$usertype.' position. ( Now, Your salary - '.$req->salary.'Tk ) of RMS by RMS Admin Panel.',
                ];
    
    
            }
          
       
            \Mail::to($req->email)->send(new \App\Mail\UserAddedMail($details));
    
    
            session()->flash('success','Admin actualizado!');


        }
        else
        {

            session()->flash('wrong','Ya sale la misma información !');

        }

     
        return back();




    }

    public function add_delivery_boy()
    {

        return view('admin.add_delivery_boy');

    }

    public function add_delivery_boy_process(Request $req)
    {
        $salary=$req->salary;

        if($salary < 0)
        {

            session()->flash('wrong','No se aceptan salarios negativos !');
            return back();

        }

        $email=DB::table('users')->where('email',$req->email)->count();

        if($email > 0)
        {

            session()->flash('wrong','Email ya registrado !');
            return back();


        }

        $phone=DB::table('users')->where('phone',$req->phone)->count();


        if($phone > 0)
        {

            session()->flash('wrong','Teléfono ya registrado !');
            return back();


        }
        if(strlen($req->password)<8)
        {

            session()->flash('wrong','La contraseña debe tener al menos 8 palabras!');
            return back();
        }

        if($req->password!=$req->confirm_password)
        {

            
            session()->flash('wrong','La contraseña no coincide !');
            return back();


        }

        $this->validate(request(),[

            'image'=>'mimes:jpeg,jpg,png',
        ]);
     
     
        $uploadedfile=$req->file('image');
        $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/assets/images/admin/'),$new_image);

        $data=array();
        $data['name']=$req->name;
        $data['email']=$req->email;
        $data['phone']=$req->phone;
        $data['usertype']="2";
        $data['salary']=$req->salary;
        $data['profile_photo_path']=$new_image;
        $data['password']=Hash::make($req->password);

        $insert=DB::table('users')->Insert($data);

        $details = [
            'title' => 'Mail from RMS Admin',
            'body' => 'Congrats ! You are selected as a Delivery Boy position ( Salary - '.$req->salary.'Tk ) of RMS by RMS Admin Panel. Your Email ID - '.$req->email. ' & Password - '.$req->password,
        ];


    
        \Mail::to($req->email)->send(new \App\Mail\UserAddedMail($details));


        session()->flash('success','Repartidor agregado exitosamente!');
        return back();



    }
    public function delete_delivery_boy($id)
    {

        $details = [
            'title' => 'Mail from RMS Admin',
            'body' => 'Sorry ! You have been fired from your job by RMS Admin Panel.So, your account is deleted by RMS Admin Panel.',
        ];

        \Mail::to(Auth::user()->email)->send(new \App\Mail\UserAddedMail($details));

        $delete=DB::table('users')->where('id',$id)->delete();

        session()->flash('success','Repartidor eliminado !');
        return back();
    }

    public function edit_delivery_boy($id)
    {

        $delivery_boys=DB::table('users')->where('id',$id)->get();


        return view('admin.edit_delivery_boy',compact('delivery_boys'));


    }

    public function edit_delivery_boy_process(Request $req,$id)
    {

        $previous_salary=DB::table('users')->where('id',$id)->value('salary');

        if($req->salary < 0)
        {

            session()->flash('wrong','No se aceptan salarios negativos !');
            return back();


        }



        $email=DB::table('users')->where('email',$req->email)->where('id','!=',$id)->count();


        if($email > 0)
        {
            session()->flash('wrong','Email ya registrado!');
            return back();

        }

        $phone=DB::table('users')->where('phone',$req->phone)->where('id','!=',$id)->count();


        if($phone > 0)
        {

            session()->flash('wrong','Teléfono ya registrado !');
            return back();
        }

        $data=array();
        $data['name']=$req->name;
        $data['email']=$req->email;
        $data['phone']=$req->phone;
        $data['salary']=$req->salary;
     

        if($req->image != NULL)
        {

            $this->validate(request(),[

                'image'=>'mimes:jpeg,jpg,png',
            ]);
         
         
            $uploadedfile=$req->file('image');
            $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/admin/'),$new_image);
            $data['profile_photo_path']=$new_image;


        }
     
        $update=DB::table('users')->where('id',$id)->Update($data);

        if($update)
        {
            $details = [
                'title' => 'Mail from RMS Admin',
                'body' => 'Congrats ! Your information is updated by RMS Admin Panel.',
            ];
    
    
            if(($req->salary != NULL && $req->salary > $previous_salary))
            {
    
                
                $details = [
                    'title' => 'Mail from RMS Admin',
                    'body' => 'Congrats ! You are promoted for a  Delivery Boy position. ( Now, Your salary - '.$req->salary.'Tk ) of RMS by RMS Admin Panel.',
                ];
    
    
            }
            else if(($req->salary != NULL && $req->salary < $previous_salary))
            {
    
    
                $details = [
                    'title' => 'Mail from RMS Admin',
                    'body' => 'Sorry ! You are depromoted for a  Delivery Boy position. ( Now, Your salary - '.$req->salary.'Tk ) of RMS by RMS Admin Panel.',
                ];
    
    
            }
          
       
            \Mail::to($req->email)->send(new \App\Mail\UserAddedMail($details));
    
    
            session()->flash('success','Repartidor actualizado con éxito !');


        }
        else
        {

            session()->flash('wrong','Ya sale la misma información !');

        }

        return back();
    }

    public function banner_add_process(Request $req)
    {

        $data=array();

        $this->validate(request(),[

            'image'=>'mimes:jpeg,jpg,png',
        ]);
     
        $uploadedfile=$req->file('image');
        $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/assets/images/'),$new_image);
        $data['image']=$new_image;


        $upload=DB::table('banners')->Insert($data);

        session()->flash('success','Banner agregado !');

        return back();

    }

    public function banner_edit($id)
    {
        $banner=DB::table('banners')->where('id',$id)->get();

        return view('admin.banner_edit',compact('banner'));

    }

    public function banner_edit_process($id,Request $req)
    {


        $data=array();

        $this->validate(request(),[

            'image'=>'mimes:jpeg,jpg,png',
        ]);
     
     
        $uploadedfile=$req->file('image');
        $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/assets/images/'),$new_image);
        $data['image']=$new_image;


        $update=DB::table('banners')->where('id',$id)->Update($data);

        session()->flash('success','Banner actualizado !');

        return back();

    }

    public function banner_delete_process($id)
    {

        $delete=DB::table('banners')->where('id',$id)->delete();

        session()->flash('success','Banner eliminado !');

        return back();
    }

    public function add_coupon()
    {

        return view('admin.add_coupon');

    }

    public function add_coupon_process(Request $req)
    {
        $this->validate(request(),[
            'name'=> 'required',
            'percentage'=> 'required',
            'code'=> 'required',
        ]);

        $data=array();

        $data['name']=$req->name;
        $data['details']=$req->details;
        $data['percentage']=$req->discount_percentage;
        $data['code']=$req->code;
        $data['validate']=$req->vaildation_date;

        $percentage=$req->discount_percentage;

        if($percentage < 0)
        {
            session()->flash('wrong','Porcentaje negativo no aceptado !');
            back();
        }

        $code=DB::table('coupons')->where('code',$req->code)->count();

        if($code > 0)
        {
            session()->flash('wrong','Código ya existe !');
            return back();
        }

        $load=DB::table('coupons')->Insert($data);

        session()->flash('success','Cupón agregado !');

        return back();
    }

    public function delete_coupon($id)
    {

        $delete=DB::table('coupons')->where('id',$id)->delete();

        session()->flash('success','Cupón eliminado exitosamente !');

        return back();
    }

    public function edit_coupon($id)
    {

        $coupon=DB::table('coupons')->where('id',$id)->get();

        return view('admin.edit_coupon',compact('coupon'));
    }


    public function edit_coupon_process($id,Request $req)
    {


        $data=array();

        $data['name']=$req->name;
        $data['details']=$req->details;
        $data['percentage']=$req->discount_percentage;
        $data['code']=$req->code;
        $data['validate']=$req->vaildation_date;



        $percentage=$req->discount_percentage;

        if($percentage < 0)
        {

            session()->flash('wrong','Porcentaje negativo no aceptado !');
            return back();



        }


        $code=DB::table('coupons')->where('code',$req->code)->where('id','!=',$id)->count();


        if($code > 0)
        {

            session()->flash('wrong','Código ya existe !');
            return back();


        }




        
        $load=DB::table('coupons')->where('id',$id)->Update($data);



        session()->flash('success','Cupón actualizado exitosamente !');

        return back();

    }

    public function add_charge()
    {
        return view('admin.add_charge');
    }

    public function add_charge_process(Request $req)
    {
        $data=array();

        $data['name']=$req->name;
        $data['price']=$req->price;
     
        $price=$req->price;

        if($price < 0)
        {
            session()->flash('wrong','No se aceptan precios negativos.!');
            return back();
        }

        $load=DB::table('charges')->Insert($data);

        session()->flash('success','Cargo agregado exitosamente !');

        return back();
    }

    public function delete_charge($id)
    {
        $delete=DB::table('charges')->where('id',$id)->delete();

        session()->flash('success','Cargo eliminado exitosamente !');

        return back();
    }

    public function edit_charge($id)
    {
        $charge=DB::table('charges')->where('id',$id)->get();

        return view('admin.edit_charge',compact('charge'));
    }

    public function edit_charge_process($id,Request $req)
    {
        $data=array();

        $data['name']=$req->name;
        $data['price']=$req->price;

        $price=$req->price;

        if($price < 0)
        {
            session()->flash('wrong','No se aceptan precios negativos. !');
            return back();
        }

        $load=DB::table('charges')->where('id',$id)->Update($data);

        session()->flash('success','Cargo actualizado exitosamente !');

        return back();
    }

    public function customize_edit()
    {
        $customize=DB::table('about_us')->get();

        return view('admin.customize_edit',compact('customize'));
    }

    public function edit_customize_process(Request $req)
    {

        $data=array();

        //return $req->description;

        $data['title']=$req->title;
        $data['description']=$req->description;
        $data['youtube_link']=$req->youtube_video_link;

        if($req->image != NULL)
        {
            $this->validate(request(),[

                'image'=>'mimes:jpeg,jpg,png',
            ]);
         
            $uploadedfile=$req->file('image');
            $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image);
            $data['iamge1']=$new_image;

        }
        
        if($req->image2 != NULL)
        {

            $this->validate(request(),[

                'image'=>'mimes:jpeg,jpg,png',
            ]);
         
            $uploadedfile=$req->file('image');
            $new_image2=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image2);
            $data['iamge2']=$new_image2;


        }
        
        if($req->image3 != NULL)
        {

            $this->validate(request(),[

                'image'=>'mimes:jpeg,jpg,png',
            ]);
         
            $uploadedfile=$req->file('image');
            $new_image3=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image3);
            $data['iamge3']=$new_image3;


        }
        
        if($req->image4 != NULL)
        {
            $this->validate(request(),[

                'image'=>'mimes:jpeg,jpg,png',
            ]);
         
            $uploadedfile=$req->file('image');
            $new_image4=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image4);
            $data['vd_image']=$new_image4;
        }

        $load=DB::table('about_us')->Update($data);

        session()->flash('success','Personalización actualizado con éxito !');

        return back();

    }

}
