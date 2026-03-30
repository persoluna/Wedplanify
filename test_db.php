<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$fallback = App\Models\Vendor::with(['category'])->where('verified', true)->inRandomOrder()->take(6)->get();
echo "Count: " . $fallback->count() . "\n";
foreach($fallback as $v) {
    echo "- " . $v->business_name . " (City: " . $v->city . ", Cat: " . ($v->category->name ?? 'none') . ")\n";
}
