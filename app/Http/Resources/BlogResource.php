<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BlogResource extends JsonResource
{
    public function toArray($request)
    {
        $locale = app()->getLocale();
        $trans = $this->translate($locale) ?? $this->translate('en') ?? $this->translations->first();

        $getAbsoluteUrl = function ($path) {
            if (!$path) return null;
            if (Str::startsWith($path, ['http://', 'https://'])) {
                return $path;
            }
            if (Str::startsWith($path, '/')) {
                return asset($path);
            }
            return asset('storage/' . $path);
        };

        // We use the raw created_at to let JavaScript's formatBlogDate parse it cleanly
        $rawCreatedAt = $this->getRawOriginal('created_at') ?? $this->created_at;

        return [
            'id' => $this->id,
            'title' => $trans?->title ?? '',
            'content' => $trans?->content ?? '',
            'slug' => $trans?->slug ?? '',
            'image' => $getAbsoluteUrl($this->image),
            'big_image' => $getAbsoluteUrl($this->big_image),
            'created_at' => $rawCreatedAt ? date('c', strtotime((string)$rawCreatedAt)) : null,
        ];
    }
}
