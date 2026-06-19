<?php

use App\Models\TeamMember;
use App\Models\Partner;
use App\Models\Blog;
use App\Models\Faq;
use Illuminate\Support\Str;

echo "Starting DB population...\n";

// 1. TEAM MEMBERS
TeamMember::query()->delete();
$teamMembers = [
    [
        'is_featured' => 1,
        'az' => ['name' => 'Elvin Qasımov', 'position' => 'Senior Developer', 'specialties' => 'React, Laravel, Vue'],
        'en' => ['name' => 'Elvin Gasimov', 'position' => 'Senior Developer', 'specialties' => 'React, Laravel, Vue'],
        'ru' => ['name' => 'Эльвин Гасымов', 'position' => 'Senior Developer', 'specialties' => 'React, Laravel, Vue'],
    ],
    [
        'is_featured' => 1,
        'az' => ['name' => 'Aysel Nəsibova', 'position' => 'UI/UX Dizayner', 'specialties' => 'Figma, Adobe XD'],
        'en' => ['name' => 'Aysel Nasibova', 'position' => 'UI/UX Designer', 'specialties' => 'Figma, Adobe XD'],
        'ru' => ['name' => 'Айсель Насибова', 'position' => 'UI/UX Дизайнер', 'specialties' => 'Figma, Adobe XD'],
    ],
    [
        'is_featured' => 1,
        'az' => ['name' => 'Rəşad Əliyev', 'position' => 'Layihə Meneceri', 'specialties' => 'Agile, Scrum, Jira'],
        'en' => ['name' => 'Rashad Aliyev', 'position' => 'Project Manager', 'specialties' => 'Agile, Scrum, Jira'],
        'ru' => ['name' => 'Рашад Алиев', 'position' => 'Project Manager', 'specialties' => 'Agile, Scrum, Jira'],
    ],
    [
        'is_featured' => 1,
        'az' => ['name' => 'Nigar Məmmədova', 'position' => 'Marketinq Rəhbəri', 'specialties' => 'SEO, SMM, Google Ads'],
        'en' => ['name' => 'Nigar Mammadova', 'position' => 'Head of Marketing', 'specialties' => 'SEO, SMM, Google Ads'],
        'ru' => ['name' => 'Нигяр Мамедова', 'position' => 'Head of Marketing', 'specialties' => 'SEO, SMM, Google Ads'],
    ]
];

foreach ($teamMembers as $data) {
    TeamMember::create($data);
}
echo "Team members created.\n";

// 2. PARTNERS
Partner::query()->delete();
$partners = ['Google', 'Spotify', 'Amazon', 'Microsoft', 'Apple', 'Meta'];
foreach ($partners as $p) {
    Partner::create([
        'name' => $p,
        'is_active' => 1,
        'az' => ['description' => $p . ' tərəfdaşı'],
        'en' => ['description' => $p . ' partner'],
        'ru' => ['description' => 'Партнер ' . $p],
    ]);
}
echo "Partners created.\n";

// 3. BLOGS
Blog::query()->delete();
for ($i=1; $i<=3; $i++) {
    Blog::create([
        'status' => 1,
        'user_id' => 1,
        'image' => 'placeholder.jpg',
        'big_image' => 'placeholder_big.jpg',
        'az' => ['title' => "Test Məqalə $i", 'slug' => "test-meqale-$i", 'content' => "Bu bir test məqaləsidir."],
        'en' => ['title' => "Test Article $i", 'slug' => "test-article-$i", 'content' => "This is a test article."],
        'ru' => ['title' => "Тестовая Статья $i", 'slug' => "test-statya-$i", 'content' => "Это тестовая статья."],
    ]);
}
echo "Blogs created.\n";

// 4. FAQS
Faq::query()->delete();
$faqs = [
    [
        'az' => ['question' => 'Hansı xidmətləri təqdim edirsiniz?', 'answer' => 'Biz veb, mobil tətbiqlər və marketinq xidmətləri təqdim edirik.'],
        'en' => ['question' => 'What services do you provide?', 'answer' => 'We provide web, mobile apps, and marketing services.'],
        'ru' => ['question' => 'Какие услуги вы предоставляете?', 'answer' => 'Мы предоставляем услуги веб, мобильных приложений и маркетинга.'],
    ],
    [
        'az' => ['question' => 'Layihə nə qədər vaxt aparır?', 'answer' => 'Layihənin həcmindən asılı olaraq 2-6 həftə çəkə bilər.'],
        'en' => ['question' => 'How long does a project take?', 'answer' => 'Depending on the scale, it can take 2-6 weeks.'],
        'ru' => ['question' => 'Сколько времени занимает проект?', 'answer' => 'В зависимости от масштаба это может занять 2-6 недель.'],
    ],
    [
        'az' => ['question' => 'Texniki dəstək verirsinizmi?', 'answer' => 'Bəli, layihə təhvil verildikdən sonra 1 il pulsuz dəstək veririk.'],
        'en' => ['question' => 'Do you offer technical support?', 'answer' => 'Yes, we provide 1 year of free support after delivery.'],
        'ru' => ['question' => 'Вы предоставляете техническую поддержку?', 'answer' => 'Да, мы предоставляем 1 год бесплатной поддержки после сдачи.'],
    ]
];

foreach ($faqs as $f) {
    Faq::create(array_merge(['is_active' => 1, 'category' => 'general'], $f));
}
echo "FAQs created.\n";

echo "Done.\n";
