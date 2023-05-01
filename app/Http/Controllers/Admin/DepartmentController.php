<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeparatementStore;
use App\Http\Requests\DepartmantUdate;
use App\Models\Department;
use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;
use Nette\Utils\Json;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.department.index');
    }

    public function list()
    {
        $items = Department::get();

        return response()->json([
            'code' => 200,
            'data' => $items,
        ]);
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
    public function store(DeparatementStore $request)
    {
        Department::create($request->validated());
        return response()->json([
            'code' =>  200,
            'item' => $request->all()
        ]);
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
        $item = Department::find($id);
        return response()->json([
            'code' => 200,
            'data' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmantUdate $request, $id)
    {
        Department::where('id', $request->post('id'))->update($request->validated());

        return response()->json([
            'code' => 200,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Department::where('id', $id)->delete();
        return response()->json([
            'code' => 200,
        ]);
    }

    public function findUsersByDepartment(int $id)
    {
        try {
            $department = Department::findOrFail($id);
            return Json::encode($department->users);
        } catch (\Exception $e) {
            return response(['status' => 0, 'message' => $e->getMessage()]);
        }
    }
}
