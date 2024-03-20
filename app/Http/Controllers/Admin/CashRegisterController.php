<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;

class CashRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            ['url' => '/home', 'label' => 'Home'],
            ['url' => '/home/cash-registers', 'label' => 'Cash Registers'],
        ];

        return view('pages.admin.cash_registers.index',compact('breadcrumb'));
    }

    public function data()
    {
        $cashRegistersArray = \App\Models\CashRegister::orderBy('id','Desc')->get();
        $cash_registers = [];

        foreach ($cashRegistersArray as $value) {
            $data['id'] = $value->id;
            $data['warehouse'] = $value->warehouse->name;
            $data['user'] = $value->user->name. '' .$value->user->lastname;
            $data['name'] = $value->name;
            $data['status'] = $value->status;
            $data['balance'] = $value->balance;
            $data['opening_balance'] = $value->opening_balance;
            $data['closing_balance'] = $value->closing_balance;
            $data['created_at'] = Carbon::parse($value->created_at)->locale('es')->isoFormat('DD/MM/YYYY');
            $data['updated_at'] = Carbon::parse($value->updated_at)->locale('es')->isoFormat('DD/MM/YYYY');
            $cash_registers[] = $data;
        }

        return Datatables::of($cash_registers)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
