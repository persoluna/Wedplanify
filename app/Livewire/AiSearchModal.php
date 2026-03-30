<?php

namespace App\Livewire;

use App\Models\Vendor;
use App\Models\Agency;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;

class AiSearchModal extends Component
{
    public $query = '';
    public $isOpen = false;
    public $messages = [];
    public $loadingAi = false;

    // Chat Memory - System Controlled
    public $sessionFilters = [
        'category' => null,
        'city' => null,
        'budget_min' => null,
        'budget_max' => null,
        'guest_count' => null,
        'keywords' => [],
        'intent' => 'search'
    ];

    // Controlled Enums & Mapping System
    private $allowedCategories = [
        "Venue", "Photographer", "Decorator", "Caterer", "DJ", "Makeup Artist", "Agency"
    ];

    private $allowedCities = [
        "Mumbai", "Delhi", "New Delhi", "Bangalore", "Jaipur", "Goa", "Chennai", "Kolkata", "Hyderabad", "Pune", "Varanasi"
    ];

    private $categoryMap = [
        "photos" => "Photographer",
        "camera" => "Photographer",
        "wedding place" => "Venue",
        "venue" => "Venue",
        "vanue" => "Venue",
        "place" => "Venue",
        "hall" => "Venue",
        "banquet" => "Venue",
        "decor" => "Decorator",
        "food" => "Caterer",
        "cater" => "Caterer",
        "makeup" => "Makeup Artist",
        "mua" => "Makeup Artist",
        "music" => "DJ",
        "dj" => "DJ",
        "band" => "DJ",
        "photographer" => "Photographer",
        "decorator" => "Decorator",
        "caterer" => "Caterer",
        "agency" => "Agency",
        "agencies" => "Agency",
        "planner" => "Agency",
        "coordinators" => "Agency",
        "wedding planner" => "Agency"
    ];

    public function submit()
    {
        if (trim($this->query) === '') return;

        $this->isOpen = true;

        // 1. Add User Message
        $this->messages[] = [
            'type' => 'user_message',
            'content' => $this->query
        ];

        $userQuery = $this->query;
        $this->query = '';

        // Render UI with loading state instantly
        $this->loadingAi = true;

        $this->dispatch('call-ai', prompt: $userQuery);
    }

    #[On('call-ai')]
    public function generateAiResponse($prompt)
    {
        $systemPrompt = "You are the exclusive Wedplanify AI Concierge, a luxury wedding planner.
You are ONLY an input parser and response generator for the Wedplanify platform.
You MUST respond with STRICTLY valid JSON ONLY. No markdown wrappers.
RULES FOR REPLY:
- Max 2 sentences.
- NEVER invent or name specific venues, vendors, or places unless they are guaranteed to be on the platform. Speak generally.
- NEVER summarize or give advice that assumes you have searched the database already.
- Always be honest that you are searching the Wedplanify platform.
- No emojis.
- No fluff. Always confident tone.
- When extracting budget, convert words like 'Lakhs' to full numbers (e.g. 5 Lakhs = 500000).
- If the user completely changes their query or asks a broad question (like 'all venues' or 'any city'), explicitly set previous filters to null to drop them.

REQUIRED JSON STRUCTURE:
{
  \"reply\": \"string (Your short elegant reply here)\",
  \"filters\": {
    \"category\": \"string|null\",
    \"city\": \"string|null\",
    \"budget_min\": \"number|null\",
    \"budget_max\": \"number|null\",
    \"guest_count\": \"number|null\",
    \"keywords\": [\"string\"],
    \"intent\": \"search|refine|browse|unknown\"
  }
}

CURRENT ACTIVE FILTERS: " . json_encode($this->sessionFilters);

        $apiMessages = [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => $prompt]
        ];

        try {
            $response = Http::withToken('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')
                ->timeout(15)
                ->post('https://integrate.api.nvidia.com/v1/chat/completions', [
                    'model' => 'meta/llama-3.1-70b-instruct',
                    'messages' => $apiMessages,
                    'temperature' => 0.1, // Low temp for deterministic output
                    'max_tokens' => 512,
                    'response_format' => ['type' => 'json_object']
                ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');
                // Clean markdown wrappers if model hallucinates them
                $content = preg_replace('/```json\s*(.*?)\s*```/is', '$1', $content);
                $parsed = json_decode($content, true);

                if (json_last_error() === JSON_ERROR_NONE && isset($parsed['filters'])) {
                    $this->processAIOutput($parsed);
                } else {
                    $this->handleFailure("I couldn't perfectly parse that request. Let me show you some excellent curated options instead.");
                }
            } else {
                $this->handleFailure("Our concierge desk is briefly unavailable. Here are some of our finest professionals.");
            }
        } catch (\Exception $e) {
            Log::error("AI Search Error: " . $e->getMessage());
            $this->handleFailure("Let me refine that for you. Here are some great options to start with.");
        }

        $this->loadingAi = false;
        $this->dispatch('ai-finished');
    }

    private function processAIOutput($parsed)
    {
        $reply = $parsed['reply'] ?? "Here are some elegant options that match your requirements.";
        $aiFilters = $parsed['filters'] ?? [];
        $intent = $aiFilters['intent'] ?? 'unknown';

        $this->sessionFilters['intent'] = $intent;

        // 1. Intent Management & Merging
        // Treat both 'search' and 'browse' as fresh slates to drop stale filters
        if ($intent === 'search' || $intent === 'browse' || empty($this->sessionFilters['category'])) {
            $this->sessionFilters = [
                'category' => null, 'city' => null,
                'budget_min' => null, 'budget_max' => null,
                'guest_count' => null, 'keywords' => [],
                'intent' => $intent
            ];
            $this->mergeFilters($aiFilters);

            if ($intent === 'browse') {
                $reply = "I've gathered some truly exceptional options from our platform for your inspiration.";
            }
        } else {
            // Intent is refine or unknown
            $this->mergeFilters($aiFilters);
        }

        // Add User Debug Message in console so we can prove it's using exact platform data
        Log::info("AI Parsed Context: ", $this->sessionFilters);

        // Add AI message to chat
        $this->messages[] = [
            'type' => 'ai_message',
            'content' => $reply
        ];

        // 2. Map & Normalize Filters strictly
        $this->normalizeFilters();

        // 3. Query DB
        $this->runQuery();
    }

    private function mergeFilters($newOpts)
    {
        foreach (['category', 'city', 'budget_min', 'budget_max', 'guest_count'] as $key) {
            if (array_key_exists($key, $newOpts)) {
                if ($newOpts[$key] === null || $newOpts[$key] === "") {
                    // Explicitly wipe the filter if AI returns null
                    $this->sessionFilters[$key] = null;
                } else {
                    $this->sessionFilters[$key] = $newOpts[$key];
                }
            }
        }
        if (array_key_exists('keywords', $newOpts)) {
            if (is_array($newOpts['keywords'])) {
                // Overwrite keywords instead of endlessly merging them, so new queries forget old irrelevant keywords
                $this->sessionFilters['keywords'] = $newOpts['keywords'];
            } elseif ($newOpts['keywords'] === null) {
                $this->sessionFilters['keywords'] = [];
            }
        }
    }

    private function normalizeFilters()
    {
        // Normalize Category mapping
        if (!empty($this->sessionFilters['category'])) {
            $rawCat = strtolower($this->sessionFilters['category']);
            $mapped = false;
            foreach ($this->categoryMap as $key => $val) {
                if (str_contains($rawCat, $key)) {
                    $this->sessionFilters['category'] = $val;
                    $mapped = true;
                    break;
                }
            }
            if (!$mapped && in_array(ucfirst($this->sessionFilters['category']), $this->allowedCategories)) {
                $this->sessionFilters['category'] = ucfirst($this->sessionFilters['category']);
            } elseif (!$mapped) {
                $this->sessionFilters['category'] = null; // Hallucinated -> Null
            }
        }

        // Normalize City
        if (!empty($this->sessionFilters['city'])) {
            $cityMatch = false;
            $rawCity = strtolower($this->sessionFilters['city']);
            foreach ($this->allowedCities as $ac) {
                if (str_contains($rawCity, strtolower($ac)) || str_contains(strtolower($ac), $rawCity)) {
                    $this->sessionFilters['city'] = $ac;
                    $cityMatch = true;
                    break;
                }
            }
            if (!$cityMatch) $this->sessionFilters['city'] = null;
        }

        // Catch typical AI budget extraction issues where it outputs '5' instead of '500000' for 5 Lakhs
        if (!empty($this->sessionFilters['budget_max']) && is_numeric($this->sessionFilters['budget_max']) && $this->sessionFilters['budget_max'] <= 100) {
            $this->sessionFilters['budget_max'] = $this->sessionFilters['budget_max'] * 100000;
        }
    }

    private function fetchResults()
    {
        $vendors = $this->buildQuery()->inRandomOrder()->take(6)->get()->toBase()->map(function($item) {
            $arr = $item->toArray();
            $arr['listing_type'] = 'vendor';
            return $arr;
        });

        $agencies = $this->buildAgencyQuery()->inRandomOrder()->take(6)->get()->toBase()->map(function($item) {
            $arr = $item->toArray();
            $arr['listing_type'] = 'agency';
            $arr['category'] = ['name' => 'Planning Agency'];
            $arr['min_price'] = null;
            return $arr;
        });

        return $vendors->merge($agencies)->shuffle()->take(6);
    }

    private function runQuery()
    {
        $results = $this->fetchResults();

        $droppedFilters = [];

        // Priority Fallbacks if results == 0
        if ($results->count() == 0 && !empty($this->sessionFilters['keywords'])) {
            $this->sessionFilters['keywords'] = [];
            $results = $this->fetchResults();
            $droppedFilters[] = 'keywords';
        }
        if ($results->count() == 0 && !empty($this->sessionFilters['budget_max'])) {
            $this->sessionFilters['budget_max'] = null;
            $this->sessionFilters['budget_min'] = null;
            $results = $this->fetchResults();
            $droppedFilters[] = 'budget constraints';
        }
        if ($results->count() == 0 && !empty($this->sessionFilters['city'])) {
            $this->sessionFilters['city'] = null;
            $results = $this->fetchResults();
            $droppedFilters[] = 'location';
        }
        if ($results->count() == 0 && !empty($this->sessionFilters['category'])) {
            $this->sessionFilters['category'] = null;
            $results = $this->fetchResults();
            $droppedFilters[] = 'category';
        }

        if (!empty($droppedFilters)) {
            $this->messages[] = [
                'type' => 'ai_message',
                'content' => "I couldn't find exact matches for your specific request, so I had to broaden the search by removing your " . implode(', ', $droppedFilters) . ". Here are some available options."
            ];
        }

        if ($results->count() > 0) {
            $this->messages[] = [
                'type' => 'results_block',
                'items' => collect($results)->values()->toArray() // ensure clean array
            ];
        } else {
            // Absolute Fallback
            $fallbackVendors = Vendor::with(['media', 'category'])->where('verified', true)->inRandomOrder()->take(4)->get()->toBase()->map(function($item) {
                $arr = $item->toArray();
                $arr['listing_type'] = 'vendor';
                return $arr;
            });
            $fallbackAgencies = Agency::with(['media'])->where('verified', true)->inRandomOrder()->take(2)->get()->toBase()->map(function($item) {
                $arr = $item->toArray();
                $arr['listing_type'] = 'agency';
                $arr['category'] = ['name' => 'Planning Agency'];
                $arr['min_price'] = null;
                return $arr;
            });

            $fallback = $fallbackVendors->merge($fallbackAgencies)->shuffle();

            $this->messages[] = [
                'type' => 'ai_message',
                'content' => "I sincerely apologize, but we currently don't have exact matches on our platform for that search. Let me show you some highly-rated professionals instead."
            ];
            $this->messages[] = [
                'type' => 'results_block',
                'items' => collect($fallback)->values()->toArray()
            ];
        }
    }

    private function buildQuery()
    {
        $query = Vendor::with(['media', 'category'])->where('verified', true);

        // 1. Category (Highest)
        // If they specifically ask for "Agency", we should NOT search vendors
        if (!empty($this->sessionFilters['category']) && strtolower($this->sessionFilters['category']) === 'agency') {
            $query->whereRaw('1 = 0');
        } elseif (!empty($this->sessionFilters['category'])) {
            $cat = $this->sessionFilters['category'];
            $query->whereHas('category', function($q) use ($cat) {
                // ILIKE for Postgres, normal LIKE for others if we switch
                $q->where('name', 'ilike', '%' . $cat . '%')
                  ->orWhereHas('parent', function($pq) use ($cat) {
                      $pq->where('name', 'ilike', '%' . $cat . '%');
                  });
            });
        }

        // 2. City
        if (!empty($this->sessionFilters['city'])) {
            $query->where('city', 'ilike', '%' . $this->sessionFilters['city'] . '%');
        }

        // 3. Budget
        if (!empty($this->sessionFilters['budget_max'])) {
            $query->where('min_price', '<=', $this->sessionFilters['budget_max']);
        }
        if (!empty($this->sessionFilters['budget_min'])) {
            $query->where('min_price', '>=', $this->sessionFilters['budget_min']);
        }

        // 4. Keywords
        if (!empty($this->sessionFilters['keywords']) && is_array($this->sessionFilters['keywords'])) {
            $query->where(function($q) {
                foreach ($this->sessionFilters['keywords'] as $kw) {
                    $q->orWhere('business_name', 'ilike', "%{$kw}%")
                      ->orWhere('description', 'ilike', "%{$kw}%");
                }
            });
        }

        return $query;
    }

    private function buildAgencyQuery()
    {
        $query = Agency::with(['media'])->where('verified', true);

        // 1. Category
        // If a specific vendor category like "Venue" is chosen, don't return Agencies
        // Only return Agencies if category is null OR specifically "Agency"
        if (!empty($this->sessionFilters['category']) && strtolower($this->sessionFilters['category']) !== 'agency') {
            $query->whereRaw('1 = 0');
        }

        // 2. City
        if (!empty($this->sessionFilters['city'])) {
            $query->where('city', 'ilike', '%' . $this->sessionFilters['city'] . '%');
        }

        // 3. Keywords
        if (!empty($this->sessionFilters['keywords']) && is_array($this->sessionFilters['keywords'])) {
            $query->where(function($q) {
                foreach ($this->sessionFilters['keywords'] as $kw) {
                    $q->orWhere('business_name', 'ilike', "%{$kw}%")
                      ->orWhere('description', 'ilike', "%{$kw}%");
                }
            });
        }

        return $query;
    }

    private function handleFailure($fallbackMessage)
    {
        $this->messages[] = [
            'type' => 'ai_message',
            'content' => $fallbackMessage
        ];

        // Push top verified vendors
        $fallback = Vendor::with(['media', 'category'])->where('verified', true)->inRandomOrder()->take(6)->get();
        $this->messages[] = [
            'type' => 'results_block',
            'items' => collect($fallback)->values()->toArray()
        ];
    }

    public function loadMorePrompt($topic)
    {
        $this->query = $topic;
        $this->submit();
    }

    public function render()
    {
        return view('livewire.ai-search-modal');
    }
}
