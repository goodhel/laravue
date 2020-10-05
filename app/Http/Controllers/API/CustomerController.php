<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerCollection;
use App\Customer;

class CustomerController extends Controller
{
    public function index(){
        //Get customer dengan menggunakan datanya berdasarkan created_at
        $customers = Customer::with(['courier'])->orderBy('created_at', 'DESC');
        if(request()->q != ''){
            //membuat filtering data bersarkan name
            $customers = $customers->where('name', 'LIKE', '%' . request()->q . '%');
        }

        return new CustomerCollection($customers->paginate(10));
    }

    public function store(Request $request)
    {
        //BUAT VALIDASI DATA
        $this->validate($request, [
            'nik' => 'required|string|unique:customers,nik',
            'name' => 'required|string|max:150',
            'address' => 'required|string',
            'phone' => 'required|string|max:15'
        ]);

        $user = $request->user(); //MENGAMBIL USER YANG SEDANG LOGIN
        //DEFAULTNYA POINT DAN DEPOSIT 0
        $request->request->add([
            'point' => 0,
            'deposit' => 0
        ]);
        //JIKA DI INPUT OLEH KURIR
        if ($user->role == 3) {
            //MAKA ID KURIR DITAMBAHKAN
            $request->request->add(['courier_id' => $user->id]);
        }
        $customer = Customer::create($request->all()); //MODIFIKASI BAGIAN INI
        return response()->json(['status' => 'success', 'data' => $customer]); //DAN PASSING DATANYA SEBAGAI RESPONSE
        // Customer::create($request->all());
        // return response()->json(['status' => 'success']);
    }

    public function edit($id)
    {
        $customer = Customer::find($id); //MELAKUKAN QUERY UNTUK MENGAMBIL DATA BERDASARKAN ID
        return response()->json(['status' => 'success', 'data' => $customer]);
    }

    public function update(Request $request, $id)
    {
        //VALIDASI DATA YANG DITERIMA
        $this->validate($request, [
            'name' => 'required|string|max:150',
            'address' => 'required|string',
            'phone' => 'required|string|max:15'
        ]);

        $customer = Customer::find($id); //QUERY UNTUK MENGAMBIL DATA BERDASARKAN ID
        $customer->update($request->all()); //UPDATE DATA BERDASARKAN DATA YANG DITERIMA
        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id); //QUERY DATA BERDASARKAN ID
        $customer->delete(); //KEMUDIAN HAPUS DATA TERSEBUT
        return response()->json(['status' => 'success']);
    }
}
