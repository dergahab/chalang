<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioStore;
use App\Http\Requests\PortfolioUpdate;
use App\Models\Company;
use App\Models\Lang;
use App\Models\Pcategory;
use App\Models\Portfolio;
use App\Services\PortfolioSerice;
use App\Traits\FileUploader;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    use FileUploader;

    protected $langs;

    protected $portfolioService;

    public function __construct()
    {
        view()->share('categories', Pcategory::all());
        view()->share('companies', Company::all());
        $this->langs = Lang::all();
        $this->portfolioService = new PortfolioSerice();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.portfolio.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new Portfolio();

        return view('admin.pages.portfolio.create', compact('item'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PortfolioStore $request)
    {
        $this->portfolioService->store($request->validated());

        return redirect()->route('admin.portfolio.index');
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
        $item = Portfolio::find($id);

        return view('admin.pages.portfolio.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PortfolioUpdate $request, Portfolio $portfolio)
    {

        $this->portfolioService->update($request->validated(), $portfolio);
        $this->flashAlert('jndlaskdjlajksdlkajsdlkajsd', 'success');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Portfolio::where('id', $id)->delete();

        return redirect()->route('admin.portfolio.index');
    }

    public function in_main(Request $request)
    {
        $item = Portfolio::find($request->id);
        $item->in_main = ! $item->in_main;
        $item->save();
    }

    public function uploadImage(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image',
        ]);

        $file = $request->file('image');
        $filename = $file->store('uploads');
        $filename = $file->storePubliclyAs('images', $filename, 'public');

        return 'images/'.$filename;

    }
}
