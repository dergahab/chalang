<?php

namespace App\Services;

use App\Models\Banner;
use App\Models\BannerTranslation;
use App\Models\Lang;
use App\Models\Step;
use App\Models\StepTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerService implements BaseService
{
    public $langs;

    public function __construct()
    {
        $this->langs = Lang::all();
    }

    public function store($data)
    {
        $this->saveTranslatable($data);
        return redirect()->route('admin.banner.index');
    }

    public function update($data, $id)
    {
      return  $this->saveTranslatable($data, $id);
    }

    public function saveTranslatable($request, $id = null)
    {
        $data = [];
        $banner = null;

        // Handle file upload only if a new image is provided
        if (!empty($request['image'])) {
            $filename = (string) \Illuminate\Support\Str::uuid() . '.' . $request['image']->getClientOriginalExtension();
            $path = 'banner/' . $filename;

            // If updating, delete the old image
            if ($id) {
                $banner = Banner::find($id);
                if ($banner && $banner->image && Storage::disk('public')->exists($banner->image)) {
                    Storage::disk('public')->delete($banner->image);
                }
            }

            // Store new image
            try {
                Storage::disk('public')->putFileAs('banner', $request['image'], $filename);
                $data['image'] = $path;
            } catch (\Exception $e) {
                // Handle error (log or throw)
                throw new \Exception('Image upload failed: ' . $e->getMessage());
            }
        }

        if (!empty($request['url'])) {
            $data['url'] = $request['url'];
        }

        // Create or update banner
        $banner = Banner::updateOrCreate(['id' => $id], $data);

        // Handle translations
        foreach ($this->langs as $l) {
            $locale = $l->lang;
            $title = $request['name'][$locale] ?? null;
            $content = $request['content'][$locale] ?? null;
            if ($title || $content) {
                BannerTranslation::updateOrCreate(
                    ['banner_id' => $banner->id, 'locale' => $locale],
                    [
                        'title' => $title,
                        'content' => $content,
                        'locale' => $locale,
                        'banner_id' => $banner->id,
                    ]
                );
            }
        }

        return $banner;
    }
}
