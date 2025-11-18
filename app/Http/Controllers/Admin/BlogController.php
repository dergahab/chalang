<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bcategory;
use App\Models\Blog;
use App\Models\BlogTranslation;
use App\Models\Lang;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use FileUploader;

    protected $langs;

    public function __construct()
    {
        $this->middleware('permission:blog.index')->only(['index', 'show']);
        $this->middleware('permission:blog.create')->only(['create', 'store']);
        $this->middleware('permission:blog.edit')->only(['edit', 'update']);
        $this->middleware('permission:blog.delete')->only(['destroy']);
        
        // Defer data loading to methods (don't load in constructor to avoid blocking artisan commands)
    }

    protected function getLangs()
    {
        if (!$this->langs) {
            $this->langs = Lang::all();
        }
        return $this->langs;
    }

    public function index()
    {
        $this->canOrAbort('blog.index');
        return view('admin.pages.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->canOrAbort('blog.create');
        $item = new Blog();

        return view('admin.pages.blog.create', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->canOrAbort('blog.create');
        $data = [];
        $data['user_id'] = Auth::user()->id;
        if ($request->image) {
            $image = $this->upload($request, name: 'image', dir: 'blog');
            $data['image'] = $image;
        }
        if ($request->big_image) {
            $big_image = $this->upload($request, name: 'big_image', dir: 'blog');
            $data['big_image'] = $big_image;
        }
        $data['slug'] = Str::slug($request->post('name')['az']);
        DB::beginTransaction();
        try {

            $blog = Blog::create($data);
            foreach ($this->getLangs() as $lang) {
                if ($request->post('name')[$lang->lang]) {
                    BlogTranslation::insert([
                        'title' => $request->post('name')[$lang->lang],
                        'content' => $request->post('content')[$lang->lang],
                        'slug' => Str::slug($request->post('name')[$lang->lang]),
                        'locale' => $lang->lang,
                        'blog_id' => $blog->id,
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'code' => 401,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('admin.blog.index');
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
        $this->canOrAbort('blog.edit');
        $item = Blog::find($id);

        return view('admin.pages.blog.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->canOrAbort('blog.edit');
        // return $request->all();
        $data = [];
        if ($request->image) {
            $image = $this->upload($request, name: 'image', dir: 'blog');
            $data['image'] = $image;
        }
        if ($request->big_image) {
            $big_image = $this->upload($request, name: 'big_image', dir: 'blog');
            $data['big_image'] = $big_image;
        }
        $data['slug'] = Str::slug($request->post('name')['az']);
        DB::beginTransaction();
        try {

            $portfolio = Blog::find($id);
            $portfolio->update($data);
            foreach ($this->getLangs() as $lang) {
                if ($request->post('name')[$lang->lang]) {
                    $translation = BlogTranslation::where('blog_id', $id)->where('locale', $lang->lang)->first();
                    if (! $translation) {
                        $translation = new BlogTranslation();
                        $translation->blog_id = $portfolio->id;
                        $translation->locale = $lang->lang;
                    }
                    $translation->title = $request->post('name')[$lang->lang] ?? $translation->title;
                    $translation->content = $request->post('content')[$lang->lang] ?? $translation->content;
                    $translation->slug = Str::slug($request->post('name')[$lang->lang]) ?? $translation->slug;
                    $translation->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'code' => 401,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('admin.blog.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->canOrAbort('blog.delete');
        Blog::where('id', $id)->delete();

        return redirect()->route('admin.blog.index');
    }
}
