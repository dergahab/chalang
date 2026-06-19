<?php
declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CaseStudy;
use App\Models\Testimonial;
use App\Models\Partner;
use App\Models\PricingPlan;
use App\Models\TeamMember;
use App\Models\Faq;

class AbstrakSeeder extends Seeder
{
    public function run()
    {
        // Truncate tables to avoid duplicate errors
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Partner::truncate();
        \App\Models\PartnerTranslation::truncate();
        CaseStudy::truncate();
        \App\Models\CaseStudyTranslation::truncate();
        Testimonial::truncate();
        \App\Models\TestimonialTranslation::truncate();
        PricingPlan::truncate();
        \App\Models\PricingPlanTranslation::truncate();
        TeamMember::truncate();
        \App\Models\TeamMemberTranslation::truncate();
        Faq::truncate();
        \App\Models\FaqTranslation::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Partners
        $partners = [
            ['name' => 'Google', 'logo' => 'partners/google.png'],
            ['name' => 'Amazon', 'logo' => 'partners/amazon.png'],
            ['name' => 'Spotify', 'logo' => 'partners/spotify.png'],
            ['name' => 'Slack', 'logo' => 'partners/slack.png'],
            ['name' => 'LinkedIn', 'logo' => 'partners/linkedin.png'],
        ];

        foreach ($partners as $key => $p) {
            $partner = Partner::create([
                'name' => $p['name'],
                'logo' => $p['logo'],
                'link' => 'https://example.com',
                'is_active' => 1,
                'sort_order' => $key + 1,
            ]);
            $partner->translateOrNew('az')->description = 'Tərəfdaş haqqında məlumat.';
            $partner->translateOrNew('en')->description = 'About the partner.';
            $partner->translateOrNew('ru')->description = 'Информация о партнере.';
            $partner->save();
        }

        // Case Studies
        $cases = [
            [
                'title' => 'Fintech App Rebranding',
                'category' => 'Branding',
                'problem' => 'Köhnəlmiş dizayn və istifadəçi təcrübəsi.',
                'solution' => 'Yeni UI/UX dizayn sistemi və modern rənglər.',
                'result' => 'İstifadəçi məmnuniyyəti 40% artdı.',
            ],
            [
                'title' => 'E-commerce AI Integration',
                'category' => 'Development',
                'problem' => 'Müştərilər məhsul tapmaqda çətinlik çəkirdi.',
                'solution' => 'AI dəstəkli axtarış və tövsiyə sistemi.',
                'result' => 'Satışlar 25% artdı.',
            ],
            [
                'title' => 'SaaS Marketing Strategy',
                'category' => 'Marketing',
                'problem' => 'Aşağı dönüşüm faizi.',
                'solution' => 'Hədəflənmiş reklam kampaniyaları və SEO.',
                'result' => 'Abunəliklər 2 qat artdı.',
            ],
        ];

        foreach ($cases as $key => $c) {
            $case = CaseStudy::create([
                'cover_image' => 'case-studies/case-' . ($key + 1) . '.jpg',
                'in_main' => 1,
                'sort_order' => $key + 1,
            ]);
            
            $case->translateOrNew('az')->title = $c['title'];
            $case->translateOrNew('az')->slug = \Illuminate\Support\Str::slug($c['title'] . '-az');
            $case->translateOrNew('az')->category = $c['category'];
            $case->translateOrNew('az')->problem = $c['problem'];
            $case->translateOrNew('az')->solution = $c['solution'];
            $case->translateOrNew('az')->result = $c['result'];

            $case->translateOrNew('en')->title = $c['title'];
            $case->translateOrNew('en')->slug = \Illuminate\Support\Str::slug($c['title'] . '-en');
            $case->translateOrNew('en')->category = $c['category'];
            $case->translateOrNew('en')->problem = 'Outdated design and UX.';
            $case->translateOrNew('en')->solution = 'New UI/UX design system.';
            $case->translateOrNew('en')->result = 'User satisfaction increased by 40%.';
            
            $case->save();
        }

        // Testimonials
        $testimonials = [
            ['name' => 'Ali Vəliyev', 'position' => 'CEO, TechCorp', 'content' => 'Möhtəşəm iş! Komanda çox peşəkardır.'],
            ['name' => 'Aysel Məmmədova', 'position' => 'Marketing Manager', 'content' => 'Satışlarımız gözləniləndən daha çox artdı.'],
            ['name' => 'John Doe', 'position' => 'Founder, StartupX', 'content' => 'Ən yaxşı tərəfdaşımız oldular.'],
        ];

        foreach ($testimonials as $key => $t) {
            $testimonial = Testimonial::create([
                'image' => 'testimonials/user-' . ($key + 1) . '.jpg',
                'rating' => 5,
                'is_active' => 1,
                'sort_order' => $key + 1,
            ]);

            $testimonial->translateOrNew('az')->name = $t['name'];
            $testimonial->translateOrNew('az')->position = $t['position'];
            $testimonial->translateOrNew('az')->content = $t['content'];

            $testimonial->translateOrNew('en')->name = $t['name'];
            $testimonial->translateOrNew('en')->position = $t['position'];
            $testimonial->translateOrNew('en')->content = 'Great work! The team is very professional.';

            $testimonial->save();
        }

        // Pricing Plans
        $plans = [
            ['name' => 'Başlanğıc', 'price_m' => '99', 'price_y' => '990', 'pop' => 0],
            ['name' => 'Pro', 'price_m' => '199', 'price_y' => '1990', 'pop' => 1],
            ['name' => 'Enterprise', 'price_m' => '499', 'price_y' => '4990', 'pop' => 0],
        ];

        foreach ($plans as $key => $p) {
            $plan = PricingPlan::create([
                'price_monthly' => $p['price_m'],
                'price_yearly' => $p['price_y'],
                'is_popular' => $p['pop'],
                'is_active' => 1,
                'sort_order' => $key + 1,
            ]);

            $plan->translateOrNew('az')->name = $p['name'];
            $plan->translateOrNew('az')->features = ["Tam dəstək", "SEO optimizasiya", "Mobil uyğunluq"];
            $plan->translateOrNew('az')->cta_text = 'İndi Başla';

            $plan->translateOrNew('en')->name = $p['name'] == 'Başlanğıc' ? 'Starter' : $p['name'];
            $plan->translateOrNew('en')->features = ["Full Support", "SEO Optimization", "Mobile Friendly"];
            $plan->translateOrNew('en')->cta_text = 'Get Started';

            $plan->save();
        }

        // Team Members
        $team = [
            ['name' => 'Javidan Dadashov', 'position' => 'Lead Developer', 'bio' => 'Full-stack developer with 10+ years experience.', 'social' => ['linkedin' => 'https://linkedin.com/in/javidan', 'github' => 'https://github.com/javidan'], 'specs' => ['PHP', 'Laravel', 'React']],
            ['name' => 'Leyla Aliyeva', 'position' => 'UI/UX Designer', 'bio' => 'Creative designer passionate about user experience.', 'social' => ['linkedin' => 'https://linkedin.com/in/leyla', 'dribbble' => 'https://dribbble.com/leyla'], 'specs' => ['Figma', 'Adobe XD', 'Prototyping']],
            ['name' => 'Murad Həsənov', 'position' => 'Project Manager', 'bio' => 'Ensuring projects are delivered on time.', 'social' => ['linkedin' => 'https://linkedin.com/in/murad'], 'specs' => ['Agile', 'Scrum', 'Jira']],
        ];

        foreach ($team as $key => $tm) {
            $member = TeamMember::create([
                'image' => 'team/member-' . ($key + 1) . '.jpg',
                'is_featured' => 1,
                'sort_order' => $key + 1,
                'social_links' => $tm['social'],
            ]);

            foreach (['az', 'en', 'ru'] as $locale) {
                $member->translateOrNew($locale)->name = $tm['name'];
                $member->translateOrNew($locale)->position = $tm['position'];
                $member->translateOrNew($locale)->bio = $tm['bio'];
                $member->translateOrNew($locale)->specialties = $tm['specs'];
            }

            $member->save();
        }

        // FAQ
        $faqs = [
            ['q' => 'Xidmətləriniz nələrdir?', 'a' => 'Veb saytların hazırlanması, mobil tətbiqlər və rəqəmsal marketinq.'],
            ['q' => 'Layihə neçəyə başa gəlir?', 'a' => 'Qiymət layihənin həcmindən və tələblərindən asılıdır.'],
            ['q' => 'Dəstək xidməti varmı?', 'a' => 'Bəli, layihə təhvil verildikdən sonra texniki dəstək göstəririk.'],
        ];

        foreach ($faqs as $key => $f) {
            $faq = Faq::create([
                'is_active' => 1,
                'sort_order' => $key + 1,
            ]);

            $faq->translateOrNew('az')->question = $f['q'];
            $faq->translateOrNew('az')->answer = $f['a'];

            $faq->translateOrNew('en')->question = 'What are your services?';
            $faq->translateOrNew('en')->answer = 'Web development, mobile apps, and digital marketing.';

            $faq->save();
        }
    }
}
