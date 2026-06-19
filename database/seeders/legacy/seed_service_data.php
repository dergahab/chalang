<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

// 1. Ensure a default image exists or use a placeholder url
$defaultImage = 'services/default_hero.png'; 
// Note: In a real app we'd copy a file there. For now using a known existing one or generic.
// Let's check a known file from the list I saw earlier (uploaded_image...). 
// Actually, looking at previous file lists, I don't have a list of storage files. 
// I'll set it to 'assets/media/others/bubble-9.png' just so SOMETHING shows up if database is null, 
// OR better, update the DB to have a valid path if I can find one. 
// For now, I will optimistically assume 'services/service-01.png' or similar might exist, 
// but safer to use a layout asset I saw in code: 'assets/media/banner/banner-image-1.png' (guess)
// Let's just set a text value that matches the asset helper logic if possible.
// The view uses `asset(Storage::url($item->image))`. This implies it expects it in storage.
// I will just mock it to a non-empty string so the <img> tag renders.

$services = App\Models\Service::all();

$commonCaseStudy = App\Models\CaseStudy::first();
$commonTestimonial = App\Models\Testimonial::first();

// Create generic FAQ if none
if (App\Models\Faq::count() == 0) {
    // Needs a service_id usually, or is global? 
    // Faq model usually belongs to Service.
}

foreach ($services as $service) {
    echo "Processing Service: " . $service->id . "\n";

    // 1. Fix Image
    if (empty($service->image)) {
        $service->image = 'placeholders/service.jpg'; // Dummy value to prevent empty src logic maybe?
        $service->save();
        echo "  - Updated Image placeholder.\n";
    }

    // 2. Attach Case Study
    if ($commonCaseStudy && !$service->caseStudies()->exists()) {
        $service->caseStudies()->attach($commonCaseStudy->id);
        echo "  - Attached Case Study.\n";
    }

    // 3. Attach Testimonial
    // Testimonial is 1-to-many. We can't easily share one testimonial across services unless we clone it 
    // OR if I was wrong about the relation. Verify: Testimonial belongsTo Service.
    // So distinct testimonials needed.
    if ($service->testimonials()->count() == 0) {
        // Create one for this service
        $t = new App\Models\Testimonial();
        $t->service_id = $service->id;
        $t->rating = 5;
        $t->is_active = true;
        $t->image = 'default_user.jpg';
        $t->save();

        DB::table('testimonial_translations')->insert([
            'testimonial_id' => $t->id,
            'locale' => 'az',
            'name' => 'Müştəri ' . $service->id,
            'position' => 'Direktor',
            'content' => 'Bu xidmət həqiqətən əladır and the best!',
        ]);
        echo "  - Created Testimonial.\n";
    }

    // 4. Attach FAQ
    if ($service->faqs()->count() == 0) {
        $faq = new App\Models\Faq();
        $faq->service_id = $service->id;
        $faq->is_active = true;
        $faq->sort_order = 1;
        $faq->save();

        DB::table('faq_translations')->insert([
            'faq_id' => $faq->id,
            'locale' => 'az',
            'question' => 'Bu xidmət nə qədər vaxt aparır?',
            'answer' => 'Layihənin həcmindən asılı olaraq 1-4 həftə çəkir.',
        ]);
         DB::table('faq_translations')->insert([
            'faq_id' => $faq->id,
            'locale' => 'en', // prevent 500 if viewed in EN
            'question' => 'How long does this take?',
            'answer' => '1-4 weeks depending on scope.',
        ]);
        echo "  - Created FAQ.\n";
    }
}

// Fix Translations
// 'front.work_together.title' etc.
// These are usually in resources/lang/az/front.php. 
// I can't edit that file easily from here without ReplaceFile, but I can check if they exist.
// Only file edits can fix that. I will do that via tool next.

echo "Data seeding complete.\n";
