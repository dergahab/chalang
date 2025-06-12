<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\AboutTranslation;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the main about record
        $about = About::create([
            'image' => 'about/default.jpg',
            'video' => null
        ]);

        // Create translations for each language
        $translations = [
            [
                'locale' => 'az',
                'title' => 'Haqqımızda',
                'description' => 'Biz müasir texnologiyalar və innovativ həllər təklif edən peşəkar komandayıq. 10 ildən artıq təcrübəmizlə müştərilərimizə ən yaxşı xidməti göstərməyə çalışırıq.'
            ],
            [
                'locale' => 'en',
                'title' => 'About Us',
                'description' => 'We are a professional team offering modern technologies and innovative solutions. With over 10 years of experience, we strive to provide the best service to our clients.'
            ],
            [
                'locale' => 'ru',
                'title' => 'О Нас',
                'description' => 'Мы профессиональная команда, предлагающая современные технологии и инновационные решения. Имея более 10 лет опыта, мы стремимся предоставить нашим клиентам лучший сервис.'
            ]
        ];

        foreach ($translations as $translation) {
            AboutTranslation::create([
                'about_id' => $about->id,
                'locale' => $translation['locale'],
                'title' => $translation['title'],
                'description' => $translation['description']
            ]);
        }
    }
}
