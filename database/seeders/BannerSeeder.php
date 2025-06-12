<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\BannerTranslation;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banner = Banner::create([
            'image' => 'banner.jpg',
        ]);

        // Create translations for each language
        $translations = [
            [
                'locale' => 'az',
                'title' => 'Şirkətimizə xoş gəlmisiniz',
                'content' => 'Biz sizin biznesiniz üçün ən yaxşı xidmətləri təqdim edirik'
            ],
            [
                'locale' => 'en',
                'title' => 'Welcome to Our Company',
                'content' => 'We provide the best services for your business'
            ],
            [
                'locale' => 'ru',
                'title' => 'Добро пожаловать в нашу компанию',
                'content' => 'Мы предоставляем лучшие услуги для вашего бизнеса'
            ]
        ];

        foreach ($translations as $translation) {
            BannerTranslation::create([
                'banner_id' => $banner->id,
                'locale' => $translation['locale'],
                'title' => $translation['title'],
                'content' => $translation['content']
            ]);
        }
    }
} 