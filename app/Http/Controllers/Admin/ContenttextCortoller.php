<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contenttext;
use App\Models\Lang;
use App\Services\ContentTextService;
use Illuminate\Http\Request;

class ContenttextCortoller extends Controller
{
    protected $contenttextserive;
    protected $langs;

    public function __construct()
    {
        $this->contenttextserive = new ContentTextService();
        view()->share('langs', Lang::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.content_text.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new ContentText();

        return view('admin.pages.content_text.create', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //   return  $request->all();
        $response = $this->contenttextserive->create($request);
        if ($response != 'success') {
            return redirect()->back()->with('error', $response );
        } else {
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Contenttext::find($id);

        return view('admin.pages.content_text.edit', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Contenttext $contentText)
    {
        $item = $contentText;
        //    $item = ContentText::find($id);

        return view('admin.pages.content_text.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = $this->contenttextserive->update($request, $id);
        if ($response != 'success') {
            return redirect()->back()->with('error', 'Translation failed');
        } else {
            return redirect()->back();
        }
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
