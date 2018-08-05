<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User as UserMod;
use App\Model\Shop as ShopMod; // ตั้งชื่อว่า  shopmod
use App\Model\Product as ProductMod;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        /*$mods = UserMod::where('active', 1)
               ->where('city', 'bangkok')
               ->orderBy('name', 'desc')
               //->take(10)
               ->get();
        */
       // $mods = UserMod::find([1, 2, 3]);
        //ods = UserMod::all(); 
         /*foreach ($mods as $item) {
            echo $item->name. "  " .$item->surname . "  ". $item->email." ".  $item->city."<br />";

        //return "Hello";
        }*/

        /*$count = UserMod::where('active', 1)->count();
        echo "total rows : ".$count;
        */

         /*return view('test')
            ->with('name', 'My Name is Lookpad')
            ->with('email','patamaporn3343@gmail.com')
         ;*/

         /*$data = [
            'name' => 'My Name',
            'surname' => 'My SurName',
            'email' => 'myemail@gmail.com'
        ];

        $item = [
            'item1' => 'My Value1',
            'item2' => 'My Value2'
        ];

        $results = [
            'data' => $data,
            'item' => $item
        ];

        return view('test', $results);
        */
        /* $data = [
           'name' => 'My Name',
           'surname' => 'My SurName',
           'email' => 'myemail@gmail.com'
       ];

        $user = UserMod::find(1);

        $mods = UserMod::all();
        return view('test', compact('data', 'user', 'mods'));
        */
        $mods = UserMod::orderby('id','desc')->paginate(10);
        return view('admin.user.lists' , compact('mods'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($raquest); exit;
        /*$mod = new UserMod;
        $mod->name = $request->name;
        $mod->email = $request->email;
        $mod->password = bcrypt($request->password);
        $mod->save();
        echo "Success";*/
        //echo "Save New data to table";

        
        

        request()->validate([
            'name' => 'required|min:2|max:50',
            'surname' => 'required|min:2|max:50',
            'mobile' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'age' => 'required|numeric',
            'confirm_password' => 'required|min:6|max:20|same:password',
        ], [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 2 characters.',
            'name.max' => 'Name should not be greater than 50 characters.',
        ]);
       // echo "Success";

        $mod = new UserMod;
        $mod->email    = $request->email;
        $mod->password = bcrypt($request->password);
        $mod->name     = $request->name;
        $mod->surname  = $request->surname;
        $mod->mobile   = $request->mobile;
        $mod->age      = $request->age;
        $mod->address  = $request->address;
        $mod->city     = $request->city;
        $mod->save();

        return redirect('admin/users')
                ->with('success', 'User ['.$request->name.'] created successfully.');








    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        /*$shop = UserMod::find(1)->shop;
        echo $shop->name;*/
        /*echo "<br />";
        $mod = UserMod::find($id);

        echo $mod->name ." ".$mod->surname. " => is owner Shop : ".$mod->shop->name;
        echo "<br />";
        $shop = UserMod::find(1)->shop;
        echo $shop->name;*/

        /*$mod = ShopMod::find($id);
        echo  $mod->name;*/


        /*$mod = UserMod::find($id);
        echo $mod->name . " " . $mod->city;*/

        /*$products = ShopMod::find($id)->products;
 
        foreach ($products as $product) {
            echo $product->name;
            echo "<br />";
        }*/

        $products = ProductMod::find($id);
            echo $products->name;
            echo "<br /><br />";
            echo $products->shop->name;



        /*echo "OR <br /><br /> "

        $shop = ShopMod::find($id);
        echo $shop->name;
        echo "<br />";

        foreach ($shop->products as $product) {
            echo $product->name;
            echo "<br />";
        }*/

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //echo "edit";
        $item = UserMod::find($id);
        return view('admin.user.edit' , compact('item'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'name' => 'required|min:2|max:50',
            'surname' => 'required|min:2|max:50',
            'mobile' => 'required|numeric',
            'age' => 'required|numeric',
        ], [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 2 characters.',
            'name.max' => 'Name should not be greater than 50 characters.',
        ]);


        $mod = UserMod::find($id);
        $mod->name     = $request->name;
        $mod->surname  = $request->surname;
        //$mod->email    = $request->email;
        $mod->mobile   = $request->mobile;
        $mod->surname  = $request->surname;
        $mod->age      = $request->age;
        $mod->address  = $request->address;
        $mod->city     = $request->city;
        $mod->save();

        return redirect('admin/users')
                    ->with('success', 'User ['.$request->name.'] updated successfully.');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*$mod = UserMod::find($id);
        $mod->delete();
        echo "Delete Success";*/


        
        
    }
}
