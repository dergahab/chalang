<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioUpdate;
use App\Models\Lang;
use App\Models\Pcategory;
use App\Models\Portfolio;
use App\Models\Company;
use App\Models\PortfolioTranslation;
use App\Services\PortfolioSerice;
use App\Traits\FileUploader;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PortfolioController extends Controller
{
    use FileUploader;
    protected $langs;
    protected $portfolioService;
    public function __construct(){
        view()->share('categories', Pcategory::all());
        view()->share('companies', Company::all() );
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
        return view('admin.pages.portfolio.create',compact('item'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        // return $request->all();
        $data = [];
        if($request->image){
            $image = $this->upload($request ,name:'image',dir:'company');
            $data['image'] = $image ;
        }
        $data['slug'] = Str::slug($request->post('name')['az']); 
        $data['company_id'] = $request->post('company_id');

        DB::beginTransaction();
        try {
           
            $portfolio = Portfolio::create($data);
            $portfolio->attachCategories($request->pcategory_id);
            foreach($this->langs as $lang){
                if($request->post('name')[$lang->lang]){
                    PortfolioTranslation::insert([
                        'title' =>$request->post('name')[$lang->lang],
                        'description' =>$request->post('description')[$lang->lang],
                        'slug'   =>  Str::slug($request->post('name')[$lang->lang]),
                        'locale' => $lang->lang,
                        'portfolio_id' => $portfolio->id,
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
           DB::rollback();
        //    throw  $e;
           return response()->json([
                'code' => 401,
                'error' =>  $e->getMessage()    
             ]);
        }

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
        Pcategory::where('id',$id)->delete();

        return redirect()->route('admin.portfolio.index');
    }

    public function in_main(Request $request){
        $item = Portfolio::find($request->id);
        $item->in_main = !$item->in_main;
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
    
    return  'images/' . $filename;
    
    }
}