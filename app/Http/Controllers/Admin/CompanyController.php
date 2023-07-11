<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    use FileUploader;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.company.index');
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data['name'] = $request->company;
        $data['slug'] = Str::slug($request->post('company'));

        if ($request->hasFile('file')) {
            $image = $this->upload($request, name: 'file', dir: 'company');
            $data['image'] = $image;
        }
        Company::create($data);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $view = view('admin.pages.company.partials.render', compact('company'))->render();

        return response()->json([
            'code' => 200,
            'view' => $view,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $data['name'] = $request->company;
        $data['slug'] = Str::slug($request->post('company'));

        if ($request->hasFile('file')) {
            $image = $this->upload($request, name: 'file', dir: 'company');
            $data['image'] = $image;
        }

        $company->update($data);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('admin.company.index');
    }
}
