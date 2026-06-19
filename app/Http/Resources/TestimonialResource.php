<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TestimonialResource extends JsonResource
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
            'position' => $trans?->position ?? '',
            'content' => $trans?->content ?? '',
            'image' => $getAbsoluteUrl($this->image),
            'rating' => $this->rating ?? 5,
            'project_type' => $this->project_type ?? null,
            'outcome' => $this->outcome ?? null,
        ];
    }
}
