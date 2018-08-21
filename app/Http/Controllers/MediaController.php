<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sian;
use Illuminate\Support\Facades\Auth;
use App\UserPassword;

class MediaController extends Controller
{
		public function media(Request $request){
			$sian = new Sian();
			$user_id = Auth::id();
			$userpassword = UserPassword::where('user_id', $user_id)->first();
			$sian->clearCoockie();
			$sian->connect($userpassword->user, $userpassword->password);
			 $cliente = [];
			 $cliente['media'] = null;
			 if($request->isMethod('post')){
					 $id = $request->input('cliente_id');
					 $cliente['media'] = $sian->metaPromo($sian->media($id));
					 $cliente['cliente_id'] = $id;
					 //dd($cliente['media']);
					 return view('sian.media', compact('cliente'));
			 }elseif($request->isMethod('get')){
					 return view('sian.media', compact('cliente'));
			 }
			 
		}

		public function zeraCombo($id, $combo, $retira){
			$sian = new Sian();
			$user_id = Auth::id();
			$userpassword = UserPassword::where('user_id', $user_id)->first();
			$sian->clearCoockie();
			$sian->connect($userpassword->user, $userpassword->password);
			
			$lista = $sian->editarPedido($id, $combo, $retira);
			return redirect(route('sian', ['id' => $id]));
		}
}
