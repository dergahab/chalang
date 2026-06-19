<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ServiceResource extends JsonResource
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

        return [
            'id' => $this->id,
            'name' => $trans?->name ?? '',
            'description' => $trans?->description ?? '',
            'content' => $trans?->content ?? '',
            'slug' => $trans?->slug ?? '',
            'cta_text' => $trans?->cta_text ?? '',
            'cta_link' => $this->cta_link ?? '',
            'icon' => $getAbsoluteUrl($this->icon),
            'image' => $getAbsoluteUrl($this->image),
            'parent_id' => $this->parent_id,
            'childs' => ServiceResource::collection($this->whenLoaded('childs')),
        ];
    }
}
