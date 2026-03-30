<?php

namespace App\Livewire;

use App\Models\ProfessionalApplication;
use Livewire\Component;

class JoinRegistry extends Component
{
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $business_name = '';
    public $business_type = 'vendor';
    public $location = '';
    public $website_url = '';
    public $instagram_handle = '';
    public $additional_notes = '';

    public $submitted = false;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email|unique:professional_applications,email',
        'phone' => 'required|string|max:20',
        'business_name' => 'required|string|max:255',
        'business_type' => 'required|in:vendor,agency',
        'location' => 'required|string|max:255',
        'website_url' => 'nullable|url|max:255',
        'instagram_handle' => 'nullable|string|max:255',
        'additional_notes' => 'nullable|string|max:1000',
    ];

    public function submit()
    {
        $validatedData = $this->validate();

        ProfessionalApplication::create($validatedData);

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.join-registry')->layout('components.layouts.app', ['transparentNav' => false]);
    }
}
