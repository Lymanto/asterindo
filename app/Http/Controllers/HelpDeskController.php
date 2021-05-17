<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HelpDesk;
use App\GolonganHelpDesk;
class HelpDeskController extends Controller
{
    public function index(Request $request)
    {
        $golongan = GolonganHelpDesk::all();
        return view('helpdesk',['golongan'=>$golongan]);
    }
    public function input(Request $request)
    {
        $input = HelpDesk::insert([
            'no_hp' => $request->no_hp,
            'nama' => $request->nama,
            'berita' => $request->berita,
            'golongan' => $request->golongan,
            'golongan_dll' => $request->golongan_dll,
        ]);
        return response()->json($input);
    }
    public function list_helpdesk(Request $request)
    {
        $helpdesk = HelpDesk::join('tbstatus_helpdesk','tbstatus_helpdesk.id','=','tbhelpdesk.status')
                            ->leftjoin('tbgolongan_helpdesk','tbgolongan_helpdesk.id','=','tbhelpdesk.golongan')
                            ->select('tbhelpdesk.id','tbstatus_helpdesk.status','tbhelpdesk.no_urut','tbhelpdesk.no_hp','tbhelpdesk.nama','tbhelpdesk.berita','tbhelpdesk.note','tbstatus_helpdesk.status','tbgolongan_helpdesk.golongan','tbhelpdesk.golongan_dll','tbhelpdesk.created_at')
                            ->orderBy('tbhelpdesk.id','DESC')->get();
        return view('list_helpdesk',['helpdesk'=>$helpdesk]);
    }
}
