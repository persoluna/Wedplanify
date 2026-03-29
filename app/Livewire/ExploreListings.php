<?php

namespace App\Livewire;

use App\Models\Agency;
use App\Models\Category;
use App\Models\Vendor;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class ExploreListings extends Component
{
    use WithPagination;

    #[Url(except: 'all')]
    public $type = 'all';

    #[Url(except: '')]
    public $search = '';

    #[Url(except: '')]
    public $city = '';

    #[Url(except: '')]
    public $category_id = '';

    #[Url(except: null)]
    public $min_price = null;

    #[Url(except: null)]
    public $max_price = null;

    public function updated($property)
    {
        if (in_array($property, ['type', 'search', 'city', 'category_id', 'min_price', 'max_price'])) {
            $this->resetPage();
        }
    }

    public function clearFilters()
    {
        $this->reset(['type', 'search', 'city', 'category_id', 'min_price', 'max_price']);
        $this->resetPage();
    }

    public function render()
    {
        $listings = collect();

        if ($this->type === 'all' || $this->type === 'vendor') {
            $vendorsQuery = Vendor::with(['media', 'category', 'tags'])->whereNull('deleted_at');

            if ($this->city) {
                // Ignore case properly for postgres
                $vendorsQuery->where('city', 'ilike', "%{$this->city}%");
            }
            if ($this->search) {
                $vendorsQuery->where('business_name', 'ilike', "%{$this->search}%");
            }
            if ($this->category_id) {
                $vendorsQuery->where('category_id', $this->category_id);
            }
            if ($this->min_price) {
                $vendorsQuery->where('min_price', '>=', $this->min_price);
            }
            if ($this->max_price) {
                $vendorsQuery->where('max_price', '<=', $this->max_price);
            }

            $vendors = $vendorsQuery->latest()->get()->map(function ($vendor) {
                $vendor->listing_type = 'vendor';
                return $vendor;
            });
            $listings = $listings->concat($vendors);
        }

        if ($this->type === 'all' || $this->type === 'agency') {
            $agenciesQuery = Agency::with(['media', 'tags'])->whereNull('deleted_at');

            if ($this->city) {
                $agenciesQuery->where('city', 'ilike', "%{$this->city}%");
            }
            if ($this->search) {
                $agenciesQuery->where('business_name', 'ilike', "%{$this->search}%");
            }

            $agencies = $agenciesQuery->latest()->get()->map(function ($agency) {
                $agency->listing_type = 'agency';
                return $agency;
            });
            $listings = $listings->concat($agencies);
        }

        $listings = $listings->sortByDesc('created_at')->values();

        // Paginate collection manually
        $page = $this->getPage();
        $perPage = 12;
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $listings->forPage($page, $perPage),
            $listings->count(),
            $perPage,
            $page,
            ['path' => url('/explore')]
        );

        return view('livewire.explore-listings', [
            'listings' => $paginated,
            'categories' => Category::all(),
        ])->layout('components.layouts.app', ['title' => 'Explore - Wedplanify']);
    }
}
