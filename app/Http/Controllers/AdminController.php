<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Transaksi;
use App\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function logout(){
        Session::flush();
        return redirect('login')->with('alert','Kamu sudah logout');
    }

    public function login(){
        return view('/login');
    }

    public function loginPost(Request $request){

        $email = $request->email;
        $password = $request->password;

        $data = Admin::where('email',$email)->first();
        if($data){ //apakah email tersebut ada atau tidak
            if(Hash::check($password,$data->password)){
                Session::put('name',$data->name);
                Session::put('email',$data->email);
                Session::put('id',$data->id);
                Session::put('login',TRUE);
                return redirect()->route('dashboard.index');
            }
            else{
                return redirect()->route('login-page')->with('alert','Password atau Email, Salah !');
            }
        }
        else{
            return redirect()->route('login-page')->with('alert','Password atau Email, Salah!');
        }
    }

    public function tes(){
        return view('tes');
    }

    public function tespost(Request $request){
        $user = 2;
        $kode = str_replace('-','',Carbon::now()->format('Y-m-d-H-i-s')) . $user;
        $money = str_replace('.', '', $request->nominal);
        $money = str_replace(',', '', $money);

        $data = [
            'kode' => $kode,
            'no_pengirim' => $request->nomorasal,
            'no_tujuan' => $request->nomortujuan,
            'fintech_pengirim' => $request->fintechasal,
            'fintech_tujuan' => $request->fintechtujuan,
            'nominal' => $money + rand(10,99),
            'user_id' => $user
        ];
        // $data['status'] = '0';
        
        $transaksi = Transaksi::create($data);

        $admin = Admin::all();
        $admin_list = [];
        foreach ($admin as $value) {
            array_push($admin_list,$value->id);
        }

        $value_list = [];

        for ($i=0; $i < count($admin_list); $i++) { 
            $jml = Transaksi::where('assigned_to',$admin_list[$i])->count();
            array_push($value_list,$jml);
        }
        
        $highest_value = min($value_list);

        $key = array_search($highest_value,$value_list);

        $admin_id = $admin_list[$key];

        $res = $transaksi->created_at;
        
        $transaksi['tanggal'] = $res->format('l, d F Y H:i');

        $a = Transaksi::find($transaksi->id);
        $a->assigned_to = $admin_id;
        $a->save();
        
        $a['tanggal'] = $res->format('l, d F Y H:i');

        return response()->json([
            'status' => 'success',
            'message' => 'Data created succesfully',
            'data' => $a,
        ],201);
    }
}
