# Wedding Platform Backend - Context Note

## Overview
This is a Laravel 12 application acting primarily as a backend and admin interface for a curated wedding marketplace. It manages users (admins, agencies, vendors, clients), assets, inquiries, bookings, and services. 

## Key Technologies
- **Core Framework**: Laravel 12 on PHP 8.3
- **Admin Interface/Panels**: Filament 4 with `filament-shield` for role management.
- **Media Management**: Spatie Media Library (used for logos, banners, documents, etc.).
- **Permissions**: Spatie Laravel Permission.
- **Frontend Views**: Laravel Blade + Livewire 3 (for explore listings).
- **Docker**: Laravel Sail environment running PostgreSQL (`pgsql`).

## Core Domains / Models (`app/Models/*`)
The project utilizes standard Eloquent models with rich relationships and Spatie Media Library integrations:
- `Agency`: Wedding planning agencies, possessing multiple vendors.
- `Vendor`: Specific services with pricing, working hours, locations. Includes categories and tags. Supports polymorphic relations for generic structures.
- `Client`: General profiles for the end users.
- `Inquiry` & `Booking`: Life cycle elements linking a `Client` to a `Vendor` or `Agency`.
- **Polymorphism**: Features like `Review`, `Booking`, `Faq`, `Package`, `PortfolioImage` are morphable to both `Agency` and `Vendor`. 

## Architecture & Logic
- **Admin & Portals**: Uses Filament panels separately located at `/admin`, `/agency`, and `/vendor`.
- **API**: Read-only API accessible via `api/v1` for `Agencies` and `Vendors` (for external frontend integration).
- **Web App**: Basic web endpoints in `routes/web.php` serving traditional Blade Views (`/`), Livewire Components (`/explore`), and generic Authentication.

## Observations
- It implements Soft Deletes across models and handles cleanup gracefully using Model boot methods (e.g. deleting uploaded media from Spatie upon deletion).
- Domain folder structure `app/Domain/*` suggests preparations for Domain-Driven Design layout for deeper logic mapping if necessary later on.

## Development Constraints
- Use Composer dependencies to deduce available packages before making architecture-level implementations.
- Standard PSR-4 autoloading with specific namespaces inside the core application folder (`app/`).

## Architectural Deep Dive

### 1. Filament Structure (`app/Filament/*`)
- **Admin Panel (`app/Filament/Admin/`)**: Extensive CRUD interface for managing standard resources like `Users`. Features various dashboard widgets for `InquiriesTrendChart`, `InquiryStatusBreakdown`, `RecentInquiriesTable`, and `TopMarketsChart`. Follows strict separated schemas (`UserForm.php`, `UserInfolist.php`, `UsersTable.php`) to keep controllers lean.
- **Agency Panel (`app/Filament/Agency/`)**: Has dedicated endpoints/pages for Agencies (`AgencyDashboard`, `EditAgencyProfile`) and specific widgets to visualize inquiries.
- **Vendor Panel (`app/Filament/Vendor/`)**: Handles vendor metrics like `VendorStatsOverview` and `LatestVendorInquiries` and individual profiling through `EditVendorProfile`.
- **Shared Resources (`app/Filament/Resources/`)**: Contains shared CRUD configurations for `Agencies`, `Bookings`, `Clients`, `Inquiries`, `Users`, `VendorAvailabilities`, and `Vendors`. This allows these core entities to be managed consistently across portals. Each namespace has explicitly delineated `Pages`, `Schemas`, and `Tables`.

### 2. HTTP Layer & API (`app/Http/*`)
- **Web Controllers**: Typical Laravel Controllers like `AuthController.php`, `ClientController.php`, `InquiryController.php`, `ListingController.php`, `ReviewController.php` handling HTML-based incoming traffic and logic parsing.
- **API Controllers (`Api/V1`)**: Clean segregation inside `AgencyController.php` and `VendorController.php` for fetching data for decoupled frontends.
- **API Resources (`Http/Resources/`)**: Transformation layers such as `VendorResource`. Shapes the model outputs precisely (e.g. nested objects returning `pricing`, `location`, `contact`, `social`, `stats`, `media` resolving Spatie media URLs, and relationships).

### 3. Database Layer (`database/migrations/`)
- Demonstrates an evolved schema built iteratively between Oct 2025 and March 2026.
- Distinct table setups for: `users`, `categories`, `agencies`, `vendors`, `clients`, `services`, `tags`, `event_types`, `portfolio_images`, `vendor_availabilities`, `packages`, `faqs`, `inquiries`, `messages`, `reviews`, `bookings`.
- **Pivot Tables**: Notable usage of Many-to-Many configurations (e.g., `agency_vendor_table`, `event_type_vendor_table`).
- Uses Spatie roles table generation (`2025_11_05_000000_create_permission_tables`) and Media handling (`2025_11_23_000001_create_media_table`).

### 4. Frontend Ecosystem (`resources/views/`)
- Implements traditional blade component scaffolding.
- `resources/views/layouts/` holds structure (`app`, `footer`, `navbar`).
- Auth-specific views (`login`, `register`).
- Dedicated Client module (`client/dashboard`, `client/review_create`, `client/saved`).
- Integration of **Livewire v3** notably in `livewire/explore-listings.blade.php` and a custom pagination view `luxury-pagination.blade.php` to run the dynamic component routing specified in `routes/web.php`.
