<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Province;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['emps'] = Employee::get();
        return view('emps.index', $data);
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
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required|numeric',
            'ktp_number' => 'required|numeric',
            'ktp_files' => 'required|mimes:jpg,jpeg,png',
            'email' => 'nullable|email:filter',
            'date_of_birth' => 'nullable|date',
            'current_position' => 'nullable',
            'bank_account' => 'nullable',
            'bank_account_number' => 'nullable|required_with:bank_account|numeric',
            'zip_code' => 'nullable',
            'street_address' => 'nullable',
            'province_address' => 'nullable',
            'city_address' => 'nullable',
        ]);

        // dd($request->file('ktp_files'));
        $requestData = $request->all();
        if ($request->hasFile('ktp_files')) {
            $imageName = time() . '.' . $request->file('ktp_files')->getClientOriginalExtension();
            $path = $request->file('ktp_files')->storeAs('public/uploads', $imageName);
            $requestData['ktp_files'] = $imageName;
        }
        Employee::create($requestData);

        return redirect()->route('employees.index')->with(['success' => 'New employee has been saved.']);
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
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required|numeric',
            'ktp_number' => 'required|numeric',
            'ktp_files' => 'nullable|mimes:jpg,jpeg,png',
            'email' => 'nullable|email:filter',
            'date_of_birth' => 'nullable|date',
            'current_position' => 'nullable',
            'bank_account' => 'nullable',
            'bank_account_number' => 'nullable|required_with:bank_account|numeric',
            'zip_code' => 'nullable',
            'street_address' => 'nullable',
            'province_address' => 'nullable',
            'city_address' => 'nullable',
        ]);

        $empExist = Employee::findOrFail($id)->first();
        // dd($request->file('ktp_files'));
        $requestData = $request->all();
        if ($request->hasFile('ktp_files')) {
            if (file_exists(public_path('storage/uploads/' . $empExist->ktp_files))) {
                unlink(public_path('storage/uploads/' . $empExist->ktp_files));
            }
            $imageName = time() . '.' . $request->file('ktp_files')->getClientOriginalExtension();
            $path = $request->file('ktp_files')->storeAs('public/uploads', $imageName);
            $requestData['ktp_files'] = $imageName;
        }
        $empExist->update($requestData);

        return redirect()->route('employees.index')->with(['success' => 'Employee information has been updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emp = Employee::findOrFail($id);
        if (file_exists(public_path('storage/uploads/' . $emp->ktp_files))) {
            unlink(public_path('storage/uploads/' . $emp->ktp_files));
        }
        $emp->delete();

        return redirect()->route('employees.index')->with(['success' => 'Employee has been deleted.']);
    }

    // ----
    public function jsonEmployee(Request $request)
    {
        $emps = Employee::findOrFail($request->id);
        $res['status'] = true;
        $res['data'] = $emps->first();
        $res['data']['city_name'] = $emps->getCity->name;
        if (!$res['data']) {
            $res = [
                'status' => false,
                'message' => 'data not found',
            ];
        }
        echo json_encode($res);
    }

    public function jsonProvinces()
    {
        $res['status'] = true;
        $res['data'] = Province::query()->orderBy('name', 'ASC')->get();
        echo json_encode($res);
    }

    public function jsonRegencies(Request $request)
    {
        $res['status'] = true;
        $res['data'] = Province::findOrFail($request->id)->regencies;
        echo json_encode($res);
    }
}
