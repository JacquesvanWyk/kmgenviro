# KMG Environmental Solutions - Implementation Guide

## Complete Step-by-Step Rebuild Plan

This guide provides the exact sequence to rebuild the KMG website from WordPress to Laravel with Filament CMS.

---

## Prerequisites Checklist

- [x] Fresh Laravel 12 installation
- [x] PHP 8.3.27
- [x] MySQL via DBngin
- [x] Node.js & npm installed
- [x] Git initialized
- [ ] Blueprint installed
- [ ] Filament installed

---

## Phase 1: Foundation Setup (Week 1)

### Step 1.1: Install Blueprint

```bash
composer require -W --dev laravel-shift/blueprint
php artisan vendor:publish --tag=blueprint-config
```

**Verify**: `php artisan blueprint:build --help`

### Step 1.2: Generate Models from Blueprint Schema

```bash
# Copy the blueprint-schema.yaml to project root
cp agent-os/product/blueprint-schema.yaml draft.yaml

# Generate models, migrations, factories, controllers
php artisan blueprint:build

# Review generated files
# Models: app/Models/
# Migrations: database/migrations/
# Factories: database/factories/
# Controllers: app/Http/Controllers/
```

**Important**: Review each generated file. Blueprint creates:
- ✅ Models with relationships
- ✅ Migrations with foreign keys
- ✅ Factories with fake data
- ✅ Basic controllers

### Step 1.3: Run Migrations

```bash
php artisan migrate
```

**Verify database tables created**: Check DBngin or use:
```bash
php artisan db:show
php artisan db:table services
```

### Step 1.4: Install Filament

```bash
composer require filament/filament:"^3.2" -W

# Install admin panel
php artisan filament:install --panels

# Create admin user
php artisan make:filament-user
# Email: admin@kmgenviro.co.za
# Password: (secure password)
```

**Verify**: Visit `/admin` in browser

### Step 1.5: Configure Filament

Edit `app/Providers/Filament/AdminPanelProvider.php`:

```php
use Filament\Support\Colors\Color;

public function panel(Panel $panel): Panel
{
    return $panel
        ->default()
        ->id('admin')
        ->path('admin')
        ->login()
        ->colors([
            'primary' => Color::hex('#1e7e34'), // KMG brand green
        ])
        ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
        ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
        ->pages([
            Pages\Dashboard::class,
        ])
        ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
        ->widgets([
            Widgets\AccountWidget::class,
        ])
        ->middleware([
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            DisableBladeIconComponents::class,
            DispatchServingFilamentEvent::class,
        ])
        ->authMiddleware([
            Authenticate::class,
        ])
        ->brandName('KMG Environmental')
        ->favicon(asset('images/favicon.png'))
        ->navigationGroups([
            'Content Management',
            'Training & Bookings',
            'Equipment Rental',
            'Marketing',
            'Inquiries',
        ]);
}
```

---

## Phase 2: Create Filament Resources (Week 2-3)

Follow the order in `filament-structure.md`. For each resource:

### Example: ServiceCategoryResource

```bash
php artisan make:filament-resource ServiceCategory --generate
```

This creates:
- `app/Filament/Resources/ServiceCategoryResource.php`
- `app/Filament/Resources/ServiceCategoryResource/Pages/`

**Customize the resource** (see filament-structure.md for exact field definitions):

```php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

            Forms\Components\TextInput::make('slug')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),

            Forms\Components\Textarea::make('description')
                ->rows(3),

            Forms\Components\FileUpload::make('icon')
                ->image()
                ->directory('service-icons'),

            Forms\Components\TextInput::make('sort_order')
                ->numeric()
                ->default(0),

            Forms\Components\Toggle::make('is_active')
                ->default(true),

            Forms\Components\Section::make('SEO')
                ->schema([
                    Forms\Components\TextInput::make('meta_title')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('meta_description')
                        ->rows(2),
                ]),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('slug'),
            Tables\Columns\IconColumn::make('is_active')
                ->boolean(),
            Tables\Columns\TextColumn::make('services_count')
                ->counts('services')
                ->label('Services'),
            Tables\Columns\TextColumn::make('sort_order')
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\TernaryFilter::make('is_active')
                ->label('Active'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ])
        ->defaultSort('sort_order');
}

public static function getNavigationGroup(): ?string
{
    return 'Content Management';
}

public static function getNavigationSort(): ?int
{
    return 1;
}
```

**Repeat for all 17 resources** listed in filament-structure.md.

**Testing each resource**:
```bash
# Create sample data using tinker
php artisan tinker

>>> App\Models\ServiceCategory::factory()->create(['name' => 'Environmental Monitoring'])
>>> App\Models\Service::factory(5)->create()
```

Visit `/admin` and test CRUD operations.

---

## Phase 3: Seed Data from Client Documents (Week 3)

### Step 3.1: Create Seeders

```bash
php artisan make:seeder ServiceCategorySeeder
php artisan make:seeder ServiceSeeder
php artisan make:seeder TeamMemberSeeder
php artisan make:seeder SectorSeeder
php artisan make:seeder AccreditationSeeder
```

### Step 3.2: Populate ServiceCategorySeeder

Edit `database/seeders/ServiceCategorySeeder.php`:

```php
public function run(): void
{
    $categories = [
        [
            'name' => 'Environmental Monitoring Services',
            'slug' => 'environmental-monitoring-services',
            'description' => 'KMG provides scientifically robust monitoring campaigns...',
            'sort_order' => 1,
        ],
        [
            'name' => 'Environmental Impact & Specialist Studies',
            'slug' => 'environmental-impact-specialist-studies',
            'description' => 'KMG's professionally registered specialists...',
            'sort_order' => 2,
        ],
        // Add all 10 categories from company profile doc
    ];

    foreach ($categories as $category) {
        ServiceCategory::create($category);
    }
}
```

### Step 3.3: Populate ServiceSeeder

Extract services from company profile document:

```php
public function run(): void
{
    $monitoringCategory = ServiceCategory::where('slug', 'environmental-monitoring-services')->first();

    $services = [
        [
            'service_category_id' => $monitoringCategory->id,
            'name' => 'Air Quality Monitoring',
            'slug' => 'air-quality-monitoring',
            'short_description' => 'Ambient air monitoring (PM₁₀, PM₂.₅, SO₂, NO₂, CO, H₂S, VOCs)',
            'full_description' => '<p>Comprehensive air quality monitoring...</p>',
            'sort_order' => 1,
        ],
        // Continue for all services
    ];

    foreach ($services as $service) {
        Service::create($service);
    }
}
```

### Step 3.4: Populate TeamMemberSeeder

```php
public function run(): void
{
    $team = [
        [
            'name' => 'Khumbelo Given Marabe',
            'slug' => 'khumbelo-given-marabe',
            'title' => 'Director & Principal Environmental / HSE Consultant',
            'bio' => '<p>...</p>',
            'registrations' => json_encode([
                ['organization' => 'SACNASP', 'number' => '...'],
                ['organization' => 'WISA', 'number' => 'Member'],
                ['organization' => 'EAPASA', 'number' => 'Affiliated'],
            ]),
            'sort_order' => 1,
        ],
        // Add all team members
    ];

    foreach ($team as $member) {
        TeamMember::create($member);
    }
}
```

### Step 3.5: Run Seeders

```bash
php artisan db:seed --class=ServiceCategorySeeder
php artisan db:seed --class=ServiceSeeder
php artisan db:seed --class=TeamMemberSeeder
php artisan db:seed --class=SectorSeeder
php artisan db:seed --class=AccreditationSeeder
```

**Verify in Filament**: Check `/admin` to see populated data.

---

## Phase 4: Public Frontend - Volt Components (Week 4-5)

### Step 4.1: Install Livewire Volt

```bash
composer require livewire/volt
php artisan volt:install
```

### Step 4.2: Create Layout

Create `resources/views/components/layouts/app.blade.php`:

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KMG Environmental Solutions' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased">
    <x-navbar />

    <main>
        {{ $slot }}
    </main>

    <x-footer />

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/27725463191"
       class="fixed bottom-4 right-4 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <!-- WhatsApp icon -->
        </svg>
    </a>

    <!-- Floating Quote Button -->
    <button
        wire:click="$dispatch('openModal', { component: 'quote-modal' })"
        class="fixed bottom-20 right-4 bg-blue-600 text-white px-6 py-3 rounded-full shadow-lg hover:bg-blue-700">
        Request a Quote
    </button>

    @livewireScripts
</body>
</html>
```

### Step 4.3: Create Homepage (Volt Class-based)

```bash
php artisan make:volt pages/home --class
```

Edit `resources/views/livewire/pages/home.blade.php`:

```blade
<?php

use Livewire\Volt\Component;
use App\Models\ServiceCategory;
use App\Models\Accreditation;
use App\Models\ClientLogo;
use App\Models\Project;

new class extends Component {
    public function with(): array
    {
        return [
            'serviceCategories' => ServiceCategory::where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
            'accreditations' => Accreditation::where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
            'featuredProjects' => Project::where('is_featured', true)
                ->where('is_active', true)
                ->take(4)
                ->get(),
            'clients' => ClientLogo::where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
        ];
    }
}; ?>

<div>
    {{-- Hero Section --}}
    <section class="bg-gradient-to-r from-green-700 to-green-900 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl">
                <h1 class="text-5xl font-bold mb-4">
                    Accredited Environmental, ESG, Waste & Occupational Hygiene Consultants
                </h1>
                <p class="text-xl mb-8">
                    DoEL asbestos approved | SACNASP/EAPASA training provider | GBCSA member
                </p>
                <div class="flex gap-4">
                    <flux:button size="lg" href="/contact">Request a Quote</flux:button>
                    <flux:button variant="outline" size="lg" href="/contact">Book a Consultation</flux:button>
                </div>
            </div>
        </div>
    </section>

    {{-- Who We Are --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-6">Who We Are</h2>
                <p class="text-lg text-gray-700 mb-4">
                    KMG Environmental Solutions Services (Pty) Ltd is a fully accredited and multidisciplinary
                    consultancy specialising in environmental management, ESG advisory, waste and asbestos
                    compliance, and occupational hygiene services.
                </p>
                <a href="/about" class="text-green-700 font-semibold hover:underline">Read more →</a>
            </div>
        </div>
    </section>

    {{-- Service Categories Grid --}}
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Our Core Services</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($serviceCategories as $category)
                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
                        @if($category->icon)
                            <img src="{{ Storage::url($category->icon) }}" class="w-16 h-16 mb-4" />
                        @endif
                        <h3 class="text-xl font-bold mb-3">{{ $category->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($category->description, 120) }}</p>
                        <a href="/services/{{ $category->slug }}" class="text-green-700 font-semibold hover:underline">
                            View Services →
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Accreditations --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Accreditations & Memberships</h2>
            <div class="flex flex-wrap justify-center items-center gap-8">
                @foreach($accreditations as $accreditation)
                    <div class="text-center">
                        <img src="{{ Storage::url($accreditation->logo) }}"
                             alt="{{ $accreditation->name }}"
                             class="h-20 mx-auto mb-2" />
                        <p class="text-sm text-gray-600">{{ $accreditation->acronym }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured Projects --}}
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Featured Projects</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProjects as $project)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                        @if($project->featured_image)
                            <img src="{{ Storage::url($project->featured_image) }}"
                                 class="w-full h-48 object-cover" />
                        @endif
                        <div class="p-4">
                            <h4 class="font-bold mb-2">{{ $project->title }}</h4>
                            <p class="text-sm text-gray-600 mb-2">{{ $project->province }}</p>
                            <a href="/projects/{{ $project->slug }}" class="text-green-700 text-sm hover:underline">
                                View Case Study →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 bg-green-700 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Need support with a licence, EIA, or compliance audit?</h2>
            <flux:button size="lg" variant="outline" href="/contact">Talk to an Expert</flux:button>
        </div>
    </section>
</div>
```

### Step 4.4: Create Route

Edit `routes/web.php`:

```php
use Livewire\Volt\Volt;

Volt::route('/', 'pages.home')->name('home');
Volt::route('/about', 'pages.about')->name('about');
Volt::route('/services/{category:slug}', 'pages.services.show')->name('services.show');
// Add more routes
```

### Step 4.5: Create More Pages

Follow the same pattern for:
- `/about` - Company info, team, mission, vision
- `/services/{category}` - Service category with list of services
- `/services/{category}/{service}` - Individual service details
- `/team` - Team members grid
- `/sectors` - Sectors overview
- `/sectors/{sector}` - Sector detail with projects
- `/projects` - All projects
- `/projects/{project}` - Project detail
- `/training` - Training courses with calendar
- `/equipment` - Equipment rental catalogue
- `/resources` - Downloadable resources
- `/blog` - Blog posts
- `/contact` - Contact form

---

## Phase 5: Interactive Features (Week 6)

### Step 5.1: Training Booking Form

```bash
php artisan make:volt forms/training-booking --class
```

```php
<?php

use Livewire\Volt\Component;
use App\Models\TrainingBooking;
use App\Models\TrainingCourse;
use App\Models\TrainingSchedule;

new class extends Component {
    public $course_id;
    public $schedule_id;
    public $name = '';
    public $email = '';
    public $phone = '';
    public $company = '';
    public $number_of_delegates = 1;
    public $delegate_names = [];
    public $special_requirements = '';

    public function mount($courseId = null, $scheduleId = null)
    {
        $this->course_id = $courseId;
        $this->schedule_id = $scheduleId;
    }

    public function submit()
    {
        $validated = $this->validate([
            'course_id' => 'required|exists:training_courses,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'company' => 'nullable|string',
            'number_of_delegates' => 'required|integer|min:1',
        ]);

        $booking = TrainingBooking::create([
            ...$validated,
            'schedule_id' => $this->schedule_id,
            'delegate_names' => json_encode($this->delegate_names),
            'special_requirements' => $this->special_requirements,
            'status' => 'pending',
        ]);

        // Send email notification
        // Mail::to('info@kmgenviro.co.za')->send(new NewTrainingBooking($booking));
        // Mail::to($this->email)->send(new BookingConfirmation($booking));

        session()->flash('success', 'Your booking has been submitted! We will contact you shortly.');

        return redirect()->route('training.index');
    }
}; ?>

<div>
    <form wire:submit="submit" class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6">Book Training</h2>

        <div class="space-y-4">
            <flux:field label="Select Course" required>
                <flux:select wire:model="course_id">
                    <option value="">Select a course...</option>
                    @foreach(TrainingCourse::where('is_active', true)->get() as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </flux:select>
            </flux:field>

            <flux:field label="Name" required>
                <flux:input wire:model="name" />
            </flux:field>

            <flux:field label="Email" required>
                <flux:input type="email" wire:model="email" />
            </flux:field>

            <flux:field label="Phone" required>
                <flux:input wire:model="phone" />
            </flux:field>

            <flux:field label="Company">
                <flux:input wire:model="company" />
            </flux:field>

            <flux:field label="Number of Delegates" required>
                <flux:input type="number" wire:model="number_of_delegates" min="1" />
            </flux:field>

            <flux:field label="Special Requirements">
                <flux:textarea wire:model="special_requirements" rows="3" />
            </flux:field>

            <flux:button type="submit" variant="primary">
                Submit Booking
            </flux:button>
        </div>
    </form>
</div>
```

### Step 5.2: Equipment Rental Quote Form

Similar pattern to training booking.

### Step 5.3: Contact Form

Similar pattern with different fields.

---

## Phase 6: WordPress Content Migration (Week 7)

### Step 6.1: Export WordPress Data

Use WordPress plugins:
- **All-in-One WP Migration** for full backup
- **WP All Export** for specific content types

Export:
- Blog posts
- Media library
- Pages (for text content reference)

### Step 6.2: Import Media

```bash
# Download WordPress uploads folder
# Copy to Laravel storage/app/public/

# Create symbolic link
php artisan storage:link
```

### Step 6.3: Migrate Blog Posts

Create import script:

```bash
php artisan make:command ImportWordPressPosts
```

```php
// Parse WordPress XML export
// Create BlogPost records
// Update image paths to new storage
```

---

## Phase 7: Testing & QA (Week 8)

### Step 7.1: Create Feature Tests

```bash
php artisan make:test --pest ServicePageTest
```

```php
it('displays all active service categories on homepage', function () {
    ServiceCategory::factory()->count(5)->create(['is_active' => true]);
    ServiceCategory::factory()->create(['is_active' => false]);

    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee(ServiceCategory::where('is_active', true)->first()->name);
});

it('allows training booking submission', function () {
    $course = TrainingCourse::factory()->create();

    $response = $this->post('/training/book', [
        'course_id' => $course->id,
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '0123456789',
        'number_of_delegates' => 2,
    ]);

    $response->assertRedirect();
    expect(TrainingBooking::count())->toBe(1);
});
```

### Step 7.2: Browser Tests

```bash
php artisan make:test --pest --browser ContactFormTest
```

```php
it('can submit contact form', function () {
    $page = visit('/contact');

    $page->fill('name', 'Test User')
        ->fill('email', 'test@example.com')
        ->fill('phone', '0123456789')
        ->fill('message', 'Test message')
        ->click('Submit')
        ->assertSee('Thank you');
});
```

### Step 7.3: Run Full Test Suite

```bash
php artisan test
```

---

## Phase 8: Deployment (Week 8-9)

### Option A: Laravel Forge

1. Create server on Forge
2. Connect Git repository
3. Configure environment variables
4. Set up database
5. Enable deployment
6. Configure SSL (Let's Encrypt)
7. Set up scheduled tasks (if needed)

### Option B: Cloudflare Pages (for static/SPA)

Not ideal for this Laravel app with database. Use Forge instead.

### Step 8.1: Production Checklist

```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false

# Cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize
php artisan optimize

# Run migrations
php artisan migrate --force

# Seed production data
php artisan db:seed --class=ProductionSeeder
```

### Step 8.2: DNS Configuration

Point domain to server:
- kmgenviro.co.za → Server IP
- www.kmgenviro.co.za → Server IP

### Step 8.3: Email Configuration

Configure in `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=info@kmgenviro.co.za
MAIL_FROM_NAME="KMG Environmental"
```

---

## Post-Launch

### Analytics
- Install Google Analytics 4
- Set up conversion tracking

### Monitoring
- Laravel Telescope (dev)
- Flare or Sentry (production errors)
- Uptime monitoring

### Backups
```bash
# Daily database backups
php artisan backup:run
```

### Maintenance
- Weekly: Review form submissions
- Monthly: Update content, review analytics
- Quarterly: Security updates

---

## Quick Reference Commands

```bash
# Development
npm run dev
php artisan serve

# Clear caches
php artisan optimize:clear

# Run tests
php artisan test --filter=ServiceTest

# Generate Filament resource
php artisan make:filament-resource ModelName --generate

# Create Volt component
php artisan make:volt pages/page-name --class

# Database
php artisan migrate:fresh --seed
php artisan db:show

# Code quality
vendor/bin/pint
```

---

## Troubleshooting

### Filament not loading
```bash
php artisan filament:upgrade
php artisan optimize:clear
```

### Livewire errors
```bash
php artisan livewire:discover
php artisan view:clear
```

### Storage issues
```bash
php artisan storage:link
chmod -R 755 storage bootstrap/cache
```

---

## Next Steps After Basic Build

1. **SEO Optimization**
   - XML sitemap
   - Robots.txt
   - Schema markup

2. **Performance**
   - Image optimization
   - CDN setup
   - Redis caching

3. **Advanced Features**
   - User roles & permissions in Filament
   - Advanced search
   - Multi-language support (if needed)

4. **Marketing Integrations**
   - Google Analytics events
   - Facebook Pixel
   - Email marketing (Mailchimp/SendGrid)

---

This guide should be followed sequentially. Each phase builds on the previous one.
