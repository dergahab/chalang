<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PortfolioResource extends JsonResource
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
            'title' => $trans?->title ?? '',
            'description' => $trans?->description ?? '',
            'short_description' => $trans?->description ?? '',
            'slug' => $trans?->slug ?? '',
            'image' => $getAbsoluteUrl($this->image),
            'gif' => isset($this->gif) ? $getAbsoluteUrl($this->gif) : null,
            'pcategories' => $this->pcategories->map(function ($cat) use ($locale) {
                $catTrans = $cat->translate($locale) ?? $cat->translate('en') ?? $cat->translations->first();
                return [
                    'id' => $cat->id,
                    'name' => $catTrans?->name ?? '',
                ];
            }),
        ];
    }
}
