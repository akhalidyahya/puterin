<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Support\Facades\Auth; 
use App\Transaksi;
use App\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function getAll(){
        $transaksi = Transaksi::all();
        return response()->json($transaksi,200);
    }

    public function getByUser() {
        $user = Auth::user();
        $transaksi = Transaksi::where('user_id',$user->id)->orderBy('created_at','DESC')->get();
        
        for ($i=0; $i <$transaksi->count() ; $i++) { 
            $date = $transaksi[$i]->created_at;
            $date_batas = $transaksi[$i]->created_at;
            $date_batas->addDays(1);
            $res = $date->format('l, d F Y H:i');
            $transaksi[$i]['tanggal'] = $res;
            $transaksi[$i]['tanggal_batas'] = $date_batas->format('l, d F Y H:i');
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved succesfully',
            'data' => $transaksi,
        ],200);
    }

    public function getById($id) {
        $transaksi = Transaksi::find($id);
        if($transaksi->count() < 1) {
            return response()->json([
                'status' => 'no data',
                'message' => 'Data not found',
            ],200);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved succesfully',
            'data' => $transaksi,
        ],200);
    }

    public function store(Request $request){
        $user = Auth::user();
        $kode = str_replace('-','',Carbon::now()->format('Y-m-d-H-i-s')) . $user->id;
        $money = str_replace('.', '', $request->nominal);
        $money = str_replace(',', '', $money);

        $data = [
            'kode' => $kode,
            'no_pengirim' => $request->no_pengirim,
            'no_tujuan' => $request->no_tujuan,
            'fintech_pengirim' => $request->fintech_pengirim,
            'fintech_tujuan' => $request->fintech_tujuan,
            'nominal' => $money + rand(10,99),
            'user_id' => $user->id
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

        $a = Transaksi::find($transaksi->id);
        $a->assigned_to = $admin_id;
        $a->save();

        $res = $transaksi->created_at;
        $res2 = $transaksi->created_at;
        $res2->addDays(1);
        
        $transaksi['tanggal'] = $res->format('l, d F Y H:i');

        
        
        $a['tanggal'] = $res->format('l, d F Y H:i');
        $a['tanggal_batas'] = $res2->format('l, d F Y H:i');

        return response()->json([
            'status' => 'success',
            'message' => 'Data created succesfully',
            'data' => $a,
        ],201);
    }

    public function updateBukti(Request $request,$id){
        $transaksi = Transaksi::find($id);

        if(!$request->hasFile('bukti')) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No Photo Uploaded',
            ],412);
        }
        
        $file = $request->file('bukti');
        
        $path = public_path() . '/uploads';
        $fileName = str_replace(" ",'',$file->getClientOriginalName());

        $file->move($path, $fileName);

        $transaksi->bukti = $fileName;
        $transaksi->status = '1';
        $transaksi->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data updated succesfully',
            'data'=>$transaksi,
        ],200);

    }

    public function updateStatus(Request $request,$id){
        $transaksi = Transaksi::find($id);
        $transaksi->status = $request->status;
        $transaksi->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data updated succesfully',
            'data'=>$transaksi,
        ],200);
    }

    public function index(){
        // return Transaksi::where('assigned_to',Session::get('id'))->get();
        $sidebar = 'all';
        $bigmenu = 'transaksi';
        
        return view('pages.transaction',[
            'sidebar'=>$sidebar,
            'bigmenu'=>$bigmenu
        ]);
    }
    public function indexUploadedBukti(){
        $sidebar = 'bukti';
        $bigmenu = 'transaksi';
        return view('pages.transactionbukti',[
            'sidebar'=>$sidebar,
            'bigmenu'=>$bigmenu
        ]);
    }
    public function indexReady(){
        $sidebar = 'ready';
        $bigmenu = 'transaksi';
        return view('pages.transactionReady',[
            'sidebar'=>$sidebar,
            'bigmenu'=>$bigmenu
        ]);
    }
    public function indexDone(){
        $sidebar = 'done';
        $bigmenu = 'transaksi';
        return view('pages.transactionDone',[
            'sidebar'=>$sidebar,
            'bigmenu'=>$bigmenu
        ]);
    }

    public function dataTransaksi($keyword){
        switch ($keyword) {
            case 'all':
                $transaksi = Transaksi::orderBy('created_at','desc')->get();
            break;

            case 'bukti':
                $transaksi = Transaksi::where('bukti','<>',null)->where('status','=','1')->orderBy('created_at','desc')->get();
            break;
            
            case 'ready':
                $transaksi = Transaksi::where('status','=','2')->orderBy('created_at','desc')->get();
            break;

            case 'done':
                $transaksi = Transaksi::where('status','=','3')->orderBy('created_at','desc')->get();
            break;
        }
        return DataTables::of($transaksi)
                ->addColumn('status',function($transaksi){
                    $color = '';
                    $text = '';
                    switch ($transaksi->status) {
                        case '0':
                            $color = 'grey';
                            $text = 'menunggu bukti';
                            break;
                        case '1':
                            $color = 'black';
                            $text = 'bukti diupload';
                            break;
                        case '2':
                            $color = 'blue';
                            $text = 'bukti valid';
                            break;
                        case '3':
                            $color = 'green';
                            $text = 'selesai';
                            break;
                        case '4':
                            $color = 'grey';
                            $text = 'dibatalkan';
                            break;
                        case '5':
                            $color = 'red';
                            $text = 'bukti invalid';
                            break;
                    }
                    return '<i class="fa fa-circle" style="color:'.$color.';"></i> '.$text.'';
                })
                ->addColumn('aksiBukti',function($transaksi){
                    return '<div class="btn-group">'.
                    '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.
                    '</button>'.
                    '<ul class="dropdown-menu" style="">'.
                      '<li><a onclick="setStatus('.$transaksi->id.',2)" class="dropdown-item" href="javascript:;">Aprove Bukti</a></li>'.
                      '<li><a onclick="setStatus('.$transaksi->id.',5)" class="dropdown-item" href="javascript:;">Tolak Bukti</a></li>'.
                    '</ul>'.
                    '</div>';
                })
                ->addColumn('aksiProses',function($transaksi){
                    return '<button onclick="setStatus('.$transaksi->id.',3)" type="button" class="btn btn-block btn-primary">Proses</button>';
                })
                ->addColumn('pengguna',function($transaksi){
                    return $transaksi->user->name;
                })
                ->addColumn('buktiImg',function($transaksi){
                    if ($transaksi->bukti != null) { return '<img src="'.asset('uploads').'/'.$transaksi->bukti.'" width="100%"/>'; } else{ return 'no photo yet';}
                })->escapeColumns([])->make(true);
    }

    public function updateStatusTransaksi($id,$status){
        $transaksi = Transaksi::find($id);
        $transaksi->status = $status;
        $transaksi->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data updated succesfully',
            'data'=>$transaksi,
        ],200);
    }
}
