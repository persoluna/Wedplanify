# Wedplanify Backend

> 📸 **[View Screenshots & Feature Showcase →](SHOWCASE.md)**

A Laravel 12 + Livewire 3 + Filament 4 backend that powers a curated luxury wedding marketplace. The system lets administrators, agencies, and vendors collaborate on inquiries, bookings, and marketing assets while exposing a clean public explore page with real-time reactive filtering, AI-powered search, and a beautiful booking pipeline in INR.

---

## 1. Mission & Scope

| Goal | Description |
| --- | --- |
| Centralize supply | Capture all agencies, vendors, services, and media in one authoritative database with soft-delete safety rails. |
| Empower operations | Provide Filament panels tailored for admins, agencies, and vendors, so each role can act on inquiries, availability, and promotions. |
| Feed the frontend | Deliver fast, Livewire-driven exploration endpoints with interactive AI Search and Booking Calendars. |

---

## 2. Architecture Snapshot

| Layer | Implementation | Reasoning |
| --- | --- | --- |
| Framework | Laravel 12 (PHP 8.3) | Modern routing, queues, Eloquent ORM, first-class Sail support. |
| Admin UI | Filament 4 multi-panel (`/admin`, `/agency`, `/vendor`) with Filament Shield | Accelerates CRUD, enforces role-aware permissions, gives widgets/dashboards out of the box. |
| Domain layer | `app/Domain/*` namespaces plus Eloquent models in `app/Models` | Keeps business logic close to domain language while still leveraging Eloquent relations. |
| Database | PostgreSQL via Sail | Reliable relational storage with JSON support for flexible attributes. |
| Media | Spatie Laravel Media Library (`media` table) | Unified handling for logos, banners, galleries; enforces single-file/logo collections. |
| APIs | Versioned read-only endpoints under `routes/api.php` (currently `v1`) | Decouples public site needs from Filament; makes it easy to evolve versions later. |
| Auth | Panel auth today; Sanctum-ready for future API auth | Keeps options open for token-based access without over-engineering now. |

---

## 3. Feature Map

| Area | Highlights | Key Files |
| --- | --- | --- |
| Users & Roles | Soft-deletable users with dependency-aware deletion, role assignments, login tracking. Super admin gate intercept bypass logic for unconditional dashboard overrides. | `app/Models/User.php`, `app/Filament/Resources/Users/Tables/UsersTable.php`, `app/Providers/AppServiceProvider.php` |
| Agencies | Rich profile fields, media attachments, vendor relationships, rating metrics. | `app/Models/Agency.php`, `app/Filament/Resources/Agencies/*` |
| Vendors | Category + pricing info in INR, services, availability calendar, agency partnerships. | `app/Models/Vendor.php`, `app/Filament/Resources/Vendors/*` |
| Clients & Inquiries | Inquiry lifecycle (new → responded → booked), duplicate inquiry interception, urgency flags, follow-up tracking, database push notifications. | `app/Models/Client.php`, `app/Models/Inquiry.php`, `app/Filament/Resources/Inquiries/*` |
| Matching & Bookings | Morph relationships for packages, bookings, reviews, FAQs that attach to agencies or vendors. Full booking pipeline. | `app/Models/Booking.php`, `app/Models/Package.php`, etc. |
| AI Search & UX | Gemini-powered semantic search integration overriding standard keyword logic, real-time Livewire reactive pagination, LocalStorage saved listings. | `app/Livewire/ExploreListings.php`, `resources/views/livewire/join-registry.blade.php` |
| Professional Registry | Frontend vendor onboarding form (`/join`) transitioning into the Filament Professional Application Approval workflow. | `app/Filament/Resources/ProfessionalApplications/*` |

---

## 4. Domain Logic Highlights

### 4.1 Users & Roles
- Users cover admins, agencies, vendors, and clients; role logic flows through Filament resources and policies.
- **Super Admin Intercept**: Configured `Gate::before` intercept so those with the `super_admin` role have automatic absolute bypass permissions on all models.
- Soft deletes are enforced everywhere, with guardrails in `UsersTable` that hide delete buttons when dependencies exist and deliver persistent warnings before force deletes.
- Spatie Media Library allows avatars/documents to attach just like vendor logos.

### 4.2 Agencies
- Attributes (business name, slug, location, contact, specialties, years in business) live in `app/Models/Agency`.
- Relationships: vendors (approved/pending/rejected), inquiries, portfolio images, packages, reviews, FAQs, bookings, tags.
- Helpers such as `incrementViewsCount()` and `updateRatingStats()` keep dashboard metrics accurate.
- Filament resources provide search, Trashed filters, toggled columns, and scoped delete/restore/force actions.

### 4.3 Vendors & The Registry Pipeline
- **Join Registry**: Prospective professionals do not instantly become vendors. They enroll via the `/join` Livewire route to create a `ProfessionalApplication`.
- **Admin Approval**: Admins review `ProfessionalApplications` inside Filament and trigger an Action mapping to `options()` approval hooks, converting them into active user records.
- Vendors include pricing ranges (`min_price`, `max_price`, `price_unit`) based globally around INR, service areas, social links, arbitrary JSON `attributes`.
- Connected to categories, owning agencies, services, event types, tags, availability slots.
- **Availability & Bookings**: `isAvailableOn()` natively prevents double-booking logic on the public UI Calendar view.

### 4.4 Clients, Interception & Inquiries
- Inquiries capture event metadata, budget, urgency, multiple note channels, and timestamps for response/follow-up/closure.
- **Spam / Duplicate Block**: Livewire inquiry modal checks for existing unresolved vendor-client pairs to prevent double-messaging.
- Convenience methods (`markAsResponded`, `recordFollowUp`, `close`) prevent inconsistent status transitions.
- **Database Push Notifications**: Emitted natively when Inquiry statuses transition so users get Filament UI alerts immediately.

### 4.5 Matching, Services, Packages
- Services, packages, reviews, FAQs, and bookings rely on morph relationships so they can belong to either agencies or vendors.
- Tags offer cross-cutting categorization ("Luxury", "Destination", etc.).
- These abstractions keep the schema DRY yet flexible for future asset types.

### 4.6 Media Handling
- `registerMediaCollections()` defines single-file vs. multi-file collections per model.
- API resources expose `logo`, `banner`, `gallery` URLs via Spatie helpers.
- The `media` table migration mirrors the official schema so conversions/responsive images can be enabled later without changes.

---

## 5. Admin & Partner Panels (Filament)

| Panel | Path | Purpose | Notable Logic |
| --- | --- | --- | --- |
| Admin | `/admin` | Full CRUD across users, agencies, vendors, clients, inquiries, bookings. | Filament Shield permissions, soft-delete filters, dependency-aware deletes, dashboard widgets. |
| Agency | `/agency` | Agency staff manage their vendors, respond to inquiries, maintain portfolios. | Custom `AgencyPanelProvider` scopes resources and branding. |
| Vendor | `/vendor` | Vendors update profiles, services, availability, respond to leads. | Mirrors agency panel with vendor-specific navigation/resources. |

Why Filament?
- Rapid scaffolding with consistent UI components (tables, forms, infolists, dashboards).
- Built-in filters (search, column toggles, trashed) reduce bespoke UI work.
- Widgets put KPIs (e.g., inquiries per week) directly on panel dashboards.

Safety nets:
- Delete/force-delete actions only appear when the record lacks blocking dependencies (e.g., users tied to vendors/agencies).
- Confirmation copy explains consequences plainly and requires explicit admin confirmation.

---

## 6. Public API (v1)

Base URL: `https://your-domain.test/api/v1`

| Resource | Endpoint | Description |
| --- | --- | --- |
| Agencies | `GET /agencies` | Paginated list with filters (search, city, country, state, verified, featured, premium). |
| Agencies | `GET /agencies/{slug}` | Single agency by slug; increments view count unless `track_views=false`. |
| Vendors | `GET /vendors` | Paginated list; supports category + price filters, availability date, boolean flags. |
| Vendors | `GET /vendors/{slug}` | Single vendor by slug; returns category, services, tags, media, stats. |

### Query Parameters

| Parameter | Applies to | Notes |
| --- | --- | --- |
| `search` | Both | Fuzzy search across business name, description, city, country. |
| `city`, `state`, `country` | Both | Partial match filters for geo searches. |
| `verified`, `featured`, `premium` | Both | Accepts `true`/`false`; parsed into booleans. |
| `category_id` | Vendors | Exact match on the vendor's primary category. |
| `min_price`, `max_price` | Vendors | Numeric filters on price range columns. |
| `available_on` | Vendors | `Y-m-d`; ensures availability shows `available`/`partially_booked`. |
| `sort` | Both | Prefix with `-` for descending. Agencies: `created_at`, `avg_rating`, `review_count`, `views_count`. Vendors add `min_price`, `max_price`. |
| `page`, `per_page` | Both | Pagination (`per_page` capped at 50). |
| `track_views` | Detail endpoints | `false` skips the automatic view counter increment. |

### Example Requests

```http
GET /api/v1/agencies?city=Toronto&verified=true&sort=-avg_rating
Accept: application/json
```

```json
{
	"data": [
		{
			"id": 1,
			"slug": "evergreen-events",
			"business_name": "Evergreen Events",
			"description": "Full-service planning studio...",
			"location": {
				"city": "Toronto",
				"country": "India"
			},
			"stats": {
				"avg_rating": 4.9,
				"review_count": 37,
				"verified": true,
				"featured": true,
				"views_count": 1284
			},
			"media": {
				"logo": "https://cdn.test/storage/.../logo.jpg",
				"banner": "https://cdn.test/storage/.../banner.jpg",
				"gallery": ["https://cdn.test/storage/.../gallery/1.jpg"]
			}
		}
	],
	"links": {
		"first": "https://your-domain.test/api/v1/agencies?page=1"
	},
	"meta": {
		"current_page": 1,
		"per_page": 15,
		"total": 1
	}
}
```

```http
GET /api/v1/vendors/floral-boutique?track_views=false
Accept: application/json
```

```json
{
	"data": {
		"id": 5,
		"slug": "floral-boutique",
		"business_name": "The Floral Boutique",
		"category": {
			"id": 2,
			"name": "Florist"
		},
		"pricing": {
			"min_price": 500,
			"max_price": 3000,
			"price_unit": "event"
		},
		"location": {
			"city": "Vancouver",
			"country": "India"
		},
		"services": [
			{"id": 11, "name": "Bouquet design", "price": 250}
		],
		"media": {
			"logo": "https://cdn.test/.../logo.png",
			"gallery": ["https://cdn.test/.../1.png"]
		},
		"stats": {
			"avg_rating": 4.8,
			"review_count": 22,
			"views_count": 194,
			"verified": true
		}
	}
}
```

### Response Shape & Rate Limiting
- Lists return Laravel pagination payloads (`data`, `links`, `meta`).
- Resources expose nested dictionaries (`location`, `contact`, `social`, `stats`, `media`) so the frontend can read structured data without extra transforms.
- When relationships are eager loaded (`tags`, `services`), the resources automatically append them.
- All API routes share `throttle:120,1`, limiting each IP to 120 requests/minute. Adjust in `routes/api.php` if traffic requires more headroom.

---

## 7. Data & Media Storage
- **Database:** PostgreSQL via Sail. Run `./vendor/bin/sail artisan migrate --seed` to bootstrap data.
- **Media:** Stored via Spatie Media Library under `storage/app/public`, exposed via `public/storage`. Collections include `logo`, `banner`, `gallery`, `portfolio`, `documents`.
- **Caching:** Not enabled yet, but architecture leaves room for query/response caching when the frontend traffic grows.

---

## 8. Local Development

```bash
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail composer install
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
```

### 8.1 Windows Setup (Recommended: WSL2 + Docker Desktop)

This project is easiest to run on Windows through **WSL2**. The repo uses Laravel Sail, Bash-style scripts, and a Docker-based PostgreSQL stack, so running it inside Ubuntu on WSL avoids most Windows path and shell issues.

#### Prerequisites
- Install **WSL2** with Ubuntu 24.04 or 22.04.
- Install **Docker Desktop** and enable **WSL Integration** for the Ubuntu distro.
- Install **Git** inside WSL.

#### 1. Open Ubuntu (WSL) and clone the project inside Linux filesystem

Store the repo somewhere under `/home/<your-user>` rather than under `/mnt/c/...` for better performance.

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y git

cd ~
git clone <your-repository-url> wedding-platform
cd wedding-platform/wedding-platform-backend
```

#### 2. Prepare the environment file for Sail + PostgreSQL

```bash
cp .env.example .env
```

Update these values in `.env` before starting the containers:

```dotenv
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=wedding_platform
DB_USERNAME=sail
DB_PASSWORD=password

QUEUE_CONNECTION=database
CACHE_STORE=database
SESSION_DRIVER=database

APP_PORT=80
VITE_PORT=5173
FORWARD_DB_PORT=5432
FORWARD_REDIS_PORT=6379
FORWARD_MAILPIT_PORT=1025
FORWARD_MAILPIT_DASHBOARD_PORT=8025
```

#### 3. Start Docker services and install dependencies

```bash
./vendor/bin/sail up -d
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

#### 4. Initialize the application

```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan storage:link
```

#### 5. Run Vite for frontend assets

Keep this running in a separate WSL terminal:

```bash
cd ~/wedding-platform/wedding-platform-backend
./vendor/bin/sail npm run dev
```

#### 6. Open the app from Windows

- Main app / default URL: `http://localhost`
- Admin panel: `http://localhost/admin`
- Agency panel: `http://localhost/agency`
- Vendor panel: `http://localhost/vendor`
- Mailpit dashboard: `http://localhost:8025`
- Vite dev server: `http://localhost:5173`

#### 7. Useful commands

```bash
./vendor/bin/sail artisan test
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail artisan optimize:clear
./vendor/bin/sail down
```

#### Windows-specific notes
- Run project commands from **WSL Ubuntu**, not PowerShell, for the smoothest experience.
- The helper script in [switch-env.sh](switch-env.sh) is a Bash script and should also be run from WSL.
- If port 80 is already in use on Windows, change `APP_PORT` in `.env`, then reopen the app on that port.
- If Docker volumes or file watching feel slow, confirm the repo is inside the WSL filesystem, not on the Windows drive.
- If Docker commands fail inside WSL, open Docker Desktop and verify **Settings → Resources → WSL Integration** is enabled for the distro.

Helpful commands:
- `./vendor/bin/sail artisan make:filament-resource Vendor` – scaffold additional resources.
- `./vendor/bin/sail artisan migrate:fresh --seed` – reset the DB while iterating quickly.
- `./vendor/bin/sail artisan storage:link` – expose media assets.

---

## 9. Testing

The project includes a comprehensive test suite covering all core models and their relationships, business logic, and edge cases.

### Running Tests

```bash
# Run all tests
./vendor/bin/sail artisan test

# Run with verbose output
./vendor/bin/sail artisan test --verbose

# Run specific test file
./vendor/bin/sail artisan test tests/Unit/Models/VendorTest.php

# Run tests with coverage (requires Xdebug)
./vendor/bin/sail artisan test --coverage
```

### Test Coverage

| Test Suite | Tests | Description |
| --- | --- | --- |
| `AgencyTest` | 17 | Agency relationships, rating stats, view counts, subscriptions, soft deletes |
| `BookingTest` | 20 | Booking lifecycle, payment tracking, status transitions, scopes |
| `ClientTest` | 16 | Client profiles, wedding calculations, planning status, preferences |
| `InquiryTest` | 19 | Inquiry lifecycle, status transitions, messaging, urgency flags |
| `MessageTest` | 12 | Message delivery, read status, attachments, system messages |
| `UserTest` | 12 | User types, relationships, soft deletes, authentication |
| `VendorTest` | 19 | Vendor profiles, availability, pricing, agency relationships |

**Total: 117 tests with 190+ assertions**

### Quality Gates

| Check | Command |
| --- | --- |
| PHPUnit tests | `./vendor/bin/sail artisan test` |
| Pint / code style | `./vendor/bin/sail pint` |
| PHPStan (if enabled) | `./vendor/bin/sail vendor/bin/phpstan analyse` |
| Static analysis / IDE helpers | `./vendor/bin/sail artisan ide-helper:generate` |

Aim to keep builds green before merging; run relevant tests whenever you touch domain logic or Filament resources.

---

## 10. Demo Data & Seeding

The project includes comprehensive seeders that populate the database with realistic Indian wedding platform demo data for development and showcasing.

### Running Seeders

```bash
# Seed demo data (safe to run multiple times - idempotent)
./vendor/bin/sail artisan db:seed

# Fresh database with demo data
./vendor/bin/sail artisan migrate:fresh --seed
```

### Demo Data Summary

| Entity | Count | Description |
| --- | --- | --- |
| Categories | 65 | Wedding service categories with hierarchical structure |
| Event Types | 16 | Indian wedding types (Hindu, Muslim, Sikh, Christian, etc.) |
| Users | 57 | 2 admins, 8 agency owners, 31 vendors, 15 clients |
| Agencies | 8 | Wedding planning agencies across major cities |
| Vendors | 20 | Photographers, caterers, decorators, venues, etc. |
| Clients | 15 | Couples with realistic wedding details and budgets |
| Inquiries | 54 | Realistic conversation threads |
| Bookings | 62 | Various statuses (pending, confirmed, completed) |
| Reviews | 8 | Realistic reviews with ratings |
| Messages | 143 | Inquiry conversation messages |
| Services | 71 | Vendor service offerings |
| Packages | 84 | Agency and vendor packages |

### Demo Login Credentials

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@shaadimandap.com` | `password` |
| Agency | `vikram@dreamshaadi.in` | `password` |
| Vendor | `arjun@pixelperfect.in` | `password` |
| Client | `aarav.gupta@gmail.com` | `password` |

### Seeders Structure

| Seeder | Purpose |
| --- | --- |
| `CategorySeeder` | Wedding vendor categories (Photography, Venues, Catering, etc.) |
| `EventTypeSeeder` | Indian wedding event types |
| `DemoUserSeeder` | Admin, agency, vendor, and client user accounts |
| `DemoAgencySeeder` | Wedding planning agencies with packages and FAQs |
| `DemoVendorSeeder` | Vendors with services, packages, and realistic profiles |
| `DemoClientSeeder` | Couples with wedding details, budgets, and preferences |
| `DemoInquirySeeder` | Inquiry conversations between clients and vendors/agencies |
| `DemoBookingSeeder` | Bookings with payment details and various statuses |
| `DemoReviewSeeder` | Reviews with ratings and detailed feedback |

All seeders are **idempotent** - they check for existing data before inserting, making them safe to run multiple times without creating duplicates.

---

## 11. Deployment & Environment Notes
- Configure DB (`DB_*`), queue (`QUEUE_CONNECTION`), mail (`MAIL_*`), storage (`FILESYSTEM_DISK=public`) in `.env` across environments.
- Always run `./vendor/bin/sail artisan storage:link` after provisioning so media URLs work.
- Queues: inquiries, notifications, and media conversions can move to queues—set `QUEUE_CONNECTION=database` by default.
- Monitoring: Laravel `/up` health route is enabled for uptime checks.

---

## 12. Roadmap / Next Steps
1. **Expand public API** – expose clients, inquiries (read-only), availability calendar endpoints, search suggestions.
2. **Authenticated API** – issue Sanctum tokens so agencies/vendors can use the same endpoints outside Filament.
3. **Caching & performance** – add response caching + ETags once marketing traffic scales.
4. **Analytics** – stream view counts/events to a warehouse or queue for deeper dashboards.
5. **Automations** – schedule follow-up reminders for inquiries that stay unanswered for N days.

---

Built with ❤️ by the Wedding Platform team. Contributions welcome—open an issue or PR with context about the panel or API you’re touching so we can review quickly.
