<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Models\Customisation;
use App\Models\Storage;
use Illuminate\Support\Facades\DB;

Route::get('get_token', function() {
  return csrf_token();
});

Route::post('/user/get', function (Request $request) {

  if (empty($request->Username)) return response()->json([ 'code' => 1, 'message' => "Username cannot be empty" ]);
  if (empty($request->Password)) return response()->json([ 'code' => 2, 'message' => "Password cannot be empty" ]);

  if ( Auth::attempt( ['username' => $request->Username, 'password' => $request->Password] ) ) {
    $user = Auth::user();
    return response()->json([ 'user' => $user, 'code' => 4, 'message' => "Login Successful, welcome back" ]);
  } else {
    return response()->json([ 'code' => 5, 'message' => "Account not found" ]);
  }

});

Route::post('/user/create', function (Request $request) {

  if (empty($request->Username)) return response()->json([ 'code' => 1, 'message' => "Username cannot be empty" ]);
  if (empty($request->Password)) return response()->json([ 'code' => 2, 'message' => "Password cannot be empty" ]);

  $existing = User::where('username', $request->Username)->get()->first();
  if ( $existing ) return response()->json([ 'code' => 6, 'message' => "Username already exists" ]);

  $user = User::create([
    'username' => $request->Username,
    'password' => bcrypt($request->Password),
    'credits' => 1000,
    'experience' => 0,
    'chest_rig' => "",
    'backpack' => "",
    'primary_weapon' => "",
    'secondary_weapon' => "",
    'inventory' => "",
    'char_skin' => "head1",
    'char_head' => "",
    'char_shirt' => "shirt1",
    'char_pants' => "pants1",
    'char_boots' => "boots1",
  ]);

  return response()->json([ 'code' => 3, 'message' => "Account created, you may now login" ]);

});

Route::get('/test', function () {

  $shop = Shop::all();
  $customisation = Customisation::all();

  $storage = DB::table('item_user')
            ->where('user_id', '=', 1)
            ->leftJoin('shop', 'item_user.item_id', '=', 'shop.id')
            ->select('item_user.id AS unique_id', 'shop.id AS item_id', 'shop.type', 'shop.price', 'shop.name')
            ->get();

  return response()->json([
    'code' => 9,
    'shop' => $shop,
    'customisation' => $customisation,
    'storage' => $storage,
    'message' => "Data Initialised"
  ]);

});

Route::post('/startup', function (Request $request) {

  if ( empty($request->user_id) ) return response()->json([ 'code' => 7, 'message' => "User is not logged in" ]);

  $shop = Shop::all();
  $customisation = Customisation::all();

  $storage = DB::table('item_user')
            ->where('user_id', '=', $request->user_id)
            ->leftJoin('shop', 'item_user.item_id', '=', 'shop.id')
            ->select('item_user.id AS unique_id', 'shop.id AS item_id', 'shop.type', 'shop.price', 'shop.name')
            ->get();

  return response()->json([
    'code' => 9,
    'shop' => $shop,
    'customisation' => $customisation,
    'storage' => $storage,
    'message' => "Data Initialised"
  ]);
});

Route::post('/buy', function (Request $request) {

  if ( empty($request->user_id) ) return response()->json([ 'code' => 7, 'message' => "User not found" ]);
  if ( empty($request->item_id) ) return response()->json([ 'code' => 8, 'message' => "item id is not specified" ]);

  $user = User::where('id', $request->user_id)->get()->first();
  if ( !$user ) return response()->json([ 'code' => 7, 'message' => "User not found" ]);

  $item = Shop::where('id', $request->item_id)->get()->first();
  if ( !$item ) return response()->json([ 'code' => 11, 'message' => "Item not found" ]);

  if ( $user->credits < $item->price ) return response()->json([ 'code' => 12, 'message' => "Player does not have enough credits" ]);

  $instance = Storage::create([
    'user_id' => $request->user_id,
    'item_id' => $request->item_id,
  ]);

  $user->credits -= $item->price;
  $user->save();

  return response()->json([ 'code' => 13, 'message' => 'Purchase Successful', 'credits' => $user->credits ]);

});


Route::get('/buy/{user_id}/{item_id}', function (Request $request) {

  if ( empty($request->user_id) ) return response()->json([ 'code' => 7, 'message' => "User not found" ]);
  if ( empty($request->item_id) ) return response()->json([ 'code' => 8, 'message' => "item id is not specified" ]);

  $user = User::where('id', $request->user_id)->get()->first();
  if ( !$user ) return response()->json([ 'code' => 7, 'message' => "User not found" ]);

  $item = Shop::where('id', $request->item_id)->get()->first();
  if ( !$item ) return response()->json([ 'code' => 11, 'message' => "Item not found" ]);

  if ( $user->credits < $item->price ) return response()->json([ 'code' => 12, 'message' => "Player does not have enough credits" ]);

  $instance = Storage::create([
    'user_id' => $request->user_id,
    'item_id' => $request->item_id,
  ]);

  $user->credits -= $item->price;
  $user->save();

  return response()->json([ 'code' => 13, 'message' => 'Purchase Successful', 'credits' => $user->credits, 'item' => $item ]);

});
