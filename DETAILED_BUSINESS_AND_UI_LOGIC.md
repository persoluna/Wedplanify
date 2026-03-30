# Wedding Platform - Detailed Features, UI/UX & Business Logic

This document dives deep into the underlying business rules, specific features, User Interface logic, and architectural reasons guiding `wedding-platform-backend`. 

## 1. Platform Objectives & Core Principles
**Objective**: Build a curated, high-end marketplace connecting engaged couples (Clients) with Wedding Agencies and individual Vendors. 
**Business Goal**: Serve as an all-in-one centralized management portal for three distinct entities (Admins, Agencies, Vendors) using **Filament PHP** while providing a decoupled, real-time JSON API infrastructure and heavily integrated Livewire frontend for the public/consumers.

### Architectural Philosophy:
- **Resilience via Soft Deletes**: The wedding industry involves massive high-stakes records (budgets, deposits). Therefore, *everything* handles soft deletion (`deleted_at`). A strict rule prevents Hard Deleting any entity that has relational dependencies.
- **Multitenant Separation**: Instead of mixing permissions inside one giant dashboard, the system separates logic heavily by creating `/admin`, `/agency`, and `/vendor` portals.
- **Polymorphism for Shared Offerings**: Bookings, FAQs, Reviews, Portfolio Images, and Packages all function via Eloquent `MorphTo` relationships because both an "Agency" and an individual "Vendor" can offer them. 

---

## 2. In-Depth Feature Breakdown & Business Logic

### A. The Inquiry System (The Core Lead Engine)
**Logic & Flow**:
1. Clients submit inquiries (with budgets, estimated guest count, event data) directed at either an `Agency` or a `Vendor`.
2. **State Machine**: Inquiries pass through strictly governed statuses: `new` -> `responded` -> `booked` / `cancelled` / `unavailable`. 
3. **Follow-Ups**: Admin/Vendors can log notes (`admin_notes`, `internal_notes`, `client_notes`) and urgency flags (`is_urgent`). Helper methods (`markAsResponded()`, `recordFollowUp()`, `close()`) abstract the timestamping away from the controller logic.
4. **Time-To-Reply**: Evaluated via `$inquiry->getDaysSinceCreationAttribute()`.

### B. The Booking System & Financial Transactions
**Financial Rules**: 
- `Booking.php` tracks three distinct monetary values: `amount` (total), `deposit_amount`, and `balance_amount`. 
- Dates heavily track milestones: `deposit_paid_at` and `full_payment_received_at`.
- Validation helper methods natively check: `isDepositPaid()` and `isFullyPaid()`. 
**Why?**: Wedding transactions are rarely paid upfront entirely. A deposit reserves the date, and the balance is usually settled right before the event. This prevents booking collisions while acknowledging pending financial stages.

### C. Listings, Providers, and Availability
**Vendor vs Agency Matrix**:
- **Agency**: Represents a business firm. Has "approved", "rejected", and "pending" vendors under it via `agency_vendor_table` pivot. Agencies manage a roster of multiple micro-vendors and take percentages / handle bookings holistically.
- **Vendor**: A specific service provider (e.g., Catorer, Photographer) linked either directly to the Admin or operating beneath an `owning_agency_id`. 
**Availability Logic**: Vendors record schedules in `VendorAvailability.php` allowing the API to verify capacity via date lookup before clients make an inquiry.

---

## 3. UI / UX Logic & Application Flow

### A. Consumer Frontend (Livewire & Blade)
The primary user-facing tool is found at `/explore` via `App\Livewire\ExploreListings`:
- **State Management**: Uses URL-binding attributes `#[Url(except: '')]` so filters (search, city, category, min/max price, listing type) represent directly in the browser's address bar. This allows easy deep-linking and SEO compatibility.
- **Unified Pagination**: Combines collections of both `Agencies` and `Vendors` simultaneously using manual `LengthAwarePaginator` instantiation to provide 1 unified list to the client, mapped using synthetic `listing_type` properties. Note the use of `ilike` in Postgres for case-insensitive search.
- **Styling**: Relies heavily on a custom `luxury-pagination.blade.php` to project a high-end visual aesthetic fitting the wedding market rather than default UI components.

### B. Filament Dashboards (Admin / Providers UX)
- **Role-Based Menus**: Uses Filament Shield to parse UI elements conditionally based on granular resource permissions.
- **Data Protection Alerts**: Delete confirmation dialogues natively warn users if an entity can't be deleted due to associated dependencies (like an Inquiry pointing to a Vendor). 
- **Dashboards as KPIs**: 
  - Admin gets macros: `InquiriesTrendChart`, `TopMarketsChart`.
  - Vendors get micro-stats: `VendorStatsOverview`, `LatestVendorInquiries` scoped *only* to their own models via Global Scopes or query configurations inside their respective Filament Resource configurations.
- **Themes**: All portals utilize Filament's native light/dark toggle syncing perfectly across `/admin`, `/agency`, and `/vendor`.

---

## 4. Media & Asset Architecture
The system integrates `Spatie\MediaLibrary`. 
- **Business Rule**: Instead of local file path string storage across models, *every* image flows through the Spatie library's polymporphic attachments.
- **Collections**: `logo` and `banner` are explicitly registered as `->singleFile()` to overwrite old avatars safely instead of bloating the disk. Portfolios and Galleries fall gracefully under flexible non-singular collections.
- **Optimization Strategy**: Architecture assumes automatic conversions and API consumption (media strings dynamically yield complete CDN URLs directly within API Resources like `VendorResource`). 

---

## Summary
The system acts essentially as **Shopify for Weddings**. The database creates a watertight contract pipeline (Inquiry -> Deposit -> Booking -> Complete), while the architecture separates High-Security CRUD handling into deeply customized Filament Dashboards, keeping the outward-facing Laravel Blade routes lightweight, fast, and aggressively searchable for leads.
