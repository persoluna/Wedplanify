# Wedplanify Platform - User Logic, Authority & Authentication Specifications

This document thoroughly maps the permission boundaries, authorization routes, and isolation principles driving the `wedding-platform-backend`. High-stakes platforms holding deposits and bookings require bulletproof scopes. Below is exactly how this is achieved.

## 1. User Types & Fundamental Architecture
There is a single `users` table configured via `app/Models/User.php` with a definitive enum/string `type` column. This `type` orchestrates nearly all routing and panel delegation.

**The 4 User Personas:**
- **`admin`**: Global operations staff. High authority. 
- **`agency`**: Business umbrellas capable of managing multiple vendors and broad inquiries.
- **`vendor`**: Singular professionals or service operators (e.g., specific photographers).
- **`client`**: The front-facing customers (engaged couples) generating inquiries and purchases.

**Registry Applications (The Pre-User State)**:
Rather than exposing default web registration routes for Vendors (which could lead to spam), the system uses `ProfessionalApplications` captured on the `/join` page. An admin explicitly triggers the `convert to User -> ->assignRole()` pipeline within the administrative interface.

**Extensibility**: The user entity utilizes traits for deep features:
- `HasRoles` (via `Spatie\Permission` & `Filament Shield`) allows granular, dynamic permissions assigned beyond default "types."
- `InteractsWithMedia` (via Spatie) for profile avatars.

---

## 2. Authentication Flow & Redirection Logic

### A. Professional Panels (Filament)
Instead of a crowded generic portal with complex navigation hiding, the app literally boots different Filament panels for different user scopes via `User::canAccessPanel(Panel $panel)`.
- `/admin` path: Accessible strictly if `type === 'admin'`.
- `/agency` path: Accessible strictly if `type === 'agency'` **AND** `$user->active === true`. *(This requires manual Admin approval/activation to prevent spam agencies).*
- `/vendor` path: Accessible strictly if `type === 'vendor'` **AND** `$user->active === true`.

Each Filament Panel (`AdminPanelProvider`, `AgencyPanelProvider`, `VendorPanelProvider`) runs its own unique set of UI components, brand colors, and accessible `Resources`.

### B. Client Access (Standard Web)
Clients use native Laravel authentication (`AuthController`), mostly routed via web controllers. 
- **Registration**: Captures standard credentials plus custom metadata (`partner_name`, `wedding_date`, `wedding_city`), and saves a correlating `Client` model.
- **Redirection Rule**: Upon successful login, `$user->isClient()` redirects safely to `/dashboard`, isolating them completely from backend Filament domains. Admin/professionals logging in via the web route are forcefully redirected to their respective (`/admin`, `/vendor`, `/agency`) prefixes.

---

## 3. Authorization, Policies & Restrictions (The "Why" & "How")
Policies dictating data isolation exist in `/app/Policies/*`. The underlying philosophy is **Strict Ownership Isolation**.

**Super Admin Override:** 
Via `AppServiceProvider.php`, the system calls `Gate::before(...)`. If the user `$user->hasRole('super_admin')`, it yields a `true` return. This tells Laravel to universally bypass checking specific permissions strings, ensuring a Super Admin never accidentally locks themselves out. 

### A. Agency Restrictions (`AgencyPolicy.php`)
- **How**: Evaluated via `canAccessAgency()`.
- **Logic**: If an Agency user attempts to read, update, or edit an Agency resource, the policy checks `(int) $agency->user_id === (int) $authUser->id`.
- **Why**: Prevents Agency A from accessing Agency B's packages or bank info via URL ID tampering.

### B. Vendor Scope Rules (`VendorPolicy.php`)
- **How**: Evaluated via `canAccessVendor()`.
- **Logic Level 1 (Direct)**: If a Vendor views a profile, they must be the direct owner.
- **Logic Level 2 (Agency Overflow)**: *This is crucial.* Because Agencies manage Vendors, an Agency user *can* access a Vendor profile IF:
  1. The vendor's `owning_agency_id` matches the Agency.
  2. Or, the vendor is attached to the agency via the Many-to-Many `$agency->vendors()` pivot. 
- **Why**: Allows parent firms to alter pricing or update calendars for their subcontracted talent without requiring the vendor's explicit login credentials.

### C. Inquiry Safety (`InquiryPolicy.php`)
- **How**: Evaluated via `canAccessInquiry()`.
- **Restriction**:
  - `Agency`: Can view inquiry if `$inquiry->agency_id === $authUser->agency->id`.
  - `Vendor`: Can view inquiry if `$inquiry->vendor_id === $authUser->vendor->id`.
- **Consequence**: This guarantees that private messages, budgets, and phone numbers given by Clients to one specific photographer are hermetically sealed from competitors on the platform.

---

## 4. Feature Execution logic & UI Triggers
- **Inquiry Submission Restrictions**: In `InquiryController@store`, before a client can message a vendor, the system explicitly queries if an active (`new`, `responded`) inquiry exists between that exact pair.
  - **Reason**: Wedding planning involves highly anxious repetitive actions. Halting duplicate inquiry emails protects the API from spam and protects the Vendor from receiving identical redundant contract requests. 
- **Notifications Engine**: When inquiries successfully pass restriction checks, the backend automatically resolves the correct owning entity (`Vendor::find()->user` vs `Agency::find()->user`) and fires a `Filament\Notifications\Notification` to populate their notification bells in the private portals alerting them immediately without page refreshes.

## Summary 
The architectural decision to completely sever the User Experience into `4 distinct environments` (Admin Panel, Agency Panel, Vendor Panel, Public Website/Dashboard) heavily reduces authorization bugs. Because the routing fundamentally locks environments by `$user->type`, cross-pollination errors are syntactically impossible before basic Eloquent policies are even evaluated.
