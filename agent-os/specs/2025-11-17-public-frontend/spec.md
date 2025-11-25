# Phase 3: Public Frontend Specification

**Project:** KMG Environmental Solutions - Laravel CMS
**Phase:** 3 - Public Frontend
**Created:** 2025-11-17
**Status:** Planning

---

## 1. Overview

Build a complete, modern, responsive public-facing website for KMG Environmental Solutions. The frontend will display all content managed through the Filament admin panel (Phase 2) and provide interactive features for visitors to engage with KMG's services, training, and equipment rental offerings.

### Goals
- Create professional, SEO-optimized public pages
- Showcase KMG's environmental consultancy expertise
- Enable visitors to browse services, projects, team, and blog content
- Provide interactive forms for contact, training bookings, and equipment quotes
- Ensure mobile-first responsive design
- Maintain fast performance and accessibility

### Technology Stack
- **Backend:** Laravel 12, Livewire 3 + Volt
- **Frontend:** Flux UI (free edition), Tailwind CSS 4, Alpine.js
- **Typography:** Inter variable font
- **Brand Colors:** Green #1e7e34 (primary), supporting palette
- **Architecture:** Server-driven UI with minimal JavaScript

---

## 2. Site Structure

### 2.1 Main Navigation
```
Home
About
  ├─ Our Team
  └─ Accreditations
Services
  └─ [Individual Service Pages]
Sectors
  └─ [Individual Sector Pages]
Projects
Training
  └─ [Individual Course Pages]
Equipment
  └─ [Individual Equipment Pages]
Blog
  └─ [Individual Post Pages]
Resources (Downloads)
Contact
```

### 2.2 Footer Navigation
```
Quick Links:
- Home
- Services
- Training
- Equipment
- Contact

Services (top 5 categories):
- [Dynamic from ServiceCategory]

Company:
- About Us
- Our Team
- Accreditations
- Projects
- Blog

Contact Info:
- Address
- Phone
- Email
- Social Media Links

Legal:
- Privacy Policy
- Terms of Service
```

---

## 3. Page Specifications

### 3.1 Homepage (`/`)

**Purpose:** First impression, showcase KMG's expertise, drive conversions

**Volt Component:** `resources/views/pages/home.blade.php`

**Sections:**
1. **Hero Section**
   - Full-width background image (environmental/consultancy theme)
   - Headline: "Environmental Solutions for Sustainable Growth"
   - Subheadline: Brief value proposition
   - CTA buttons: "Our Services" + "Get a Quote"
   - Overlay with KMG green gradient

2. **Services Overview**
   - Grid of service categories (max 6)
   - Category icon, name, short description
   - "View All Services" link
   - Data: `ServiceCategory::where('active', true)->limit(6)->get()`

3. **Why Choose KMG**
   - 3-column features grid:
     - Expert Team (with team member count)
     - Accredited & Certified (with accreditation badges)
     - Proven Track Record (with project count)
   - Icons, headlines, descriptions

4. **Featured Projects**
   - 3-card carousel or grid
   - Project featured image, name, sector, province
   - "View All Projects" link
   - Data: `Project::where('featured', true)->latest()->limit(3)->get()`

5. **Client Logos**
   - Scrolling marquee or grid of client logos
   - Data: `ClientLogo::where('active', true)->orderBy('display_order')->get()`

6. **Training & Equipment CTA**
   - 2-column split section:
     - Left: Training courses promo
     - Right: Equipment rental promo
   - CTAs to respective pages

7. **Latest Blog Posts**
   - 3-card grid of recent posts
   - Post featured image, title, excerpt, date
   - "Read More" links
   - Data: `BlogPost::where('published', true)->latest('published_at')->limit(3)->get()`

8. **Contact CTA Section**
   - Background with KMG green
   - "Ready to Get Started?" headline
   - Contact form or "Contact Us" button

**SEO:**
- Title: "KMG Environmental Solutions | Environmental Consultancy South Africa"
- Meta description: Custom site-wide description
- Schema: Organization, LocalBusiness

---

### 3.2 About Pages

#### 3.2.1 About Us (`/about`)

**Purpose:** Company background, mission, values

**Volt Component:** `resources/views/pages/about.blade.php`

**Sections:**
1. Hero breadcrumb
2. Company overview (static content or manageable via CMS later)
3. Mission & Vision
4. Core Values
5. Accreditations preview (link to full accreditations page)
6. CTA to view team or contact

**SEO:**
- Title: "About KMG Environmental Solutions | Who We Are"
- Meta description: Company overview

---

#### 3.2.2 Our Team (`/team`)

**Purpose:** Showcase team members and expertise

**Volt Component:** `resources/views/pages/team.blade.php`

**Content:**
1. Hero breadcrumb
2. Team introduction text
3. Grid of team members (4 columns desktop, 2 tablet, 1 mobile)
   - Circular photo
   - Name, position
   - Short bio excerpt
   - Professional registrations displayed
   - LinkedIn link (if provided)
4. Pagination if > 12 members

**Data:** `TeamMember::where('active', true)->orderBy('display_order')->paginate(12)`

**SEO:**
- Title: "Our Team | KMG Environmental Solutions"
- Meta description: Team expertise overview

---

#### 3.2.3 Accreditations (`/accreditations`)

**Purpose:** Display certifications and accreditations

**Volt Component:** `resources/views/pages/accreditations.blade.php`

**Content:**
1. Hero breadcrumb
2. Introduction text about quality standards
3. Grid of accreditations (3-4 columns)
   - Certificate/logo image
   - Name, issuing organization
   - Certificate number
   - Valid until date
   - Display "Valid" or "Expired" badge
4. Filter: Show only valid accreditations (default)

**Data:** `Accreditation::where('active', true)->orderBy('display_order')->get()`

**SEO:**
- Title: "Accreditations & Certifications | KMG Environmental Solutions"
- Meta description: List of accreditations

---

### 3.3 Services Pages

#### 3.3.1 Services Listing (`/services`)

**Purpose:** Browse all service categories and services

**Volt Component:** `resources/views/pages/services/index.blade.php`

**Content:**
1. Hero breadcrumb
2. Services introduction
3. Accordion or tabbed interface:
   - Each service category is a section
   - Clicking category expands to show services within
   - Service: icon, name, short description excerpt
   - "Learn More" link to individual service page
4. Alternative: Grid of service categories, each linking to category page

**Data:**
```php
$categories = ServiceCategory::where('active', true)
    ->with(['services' => function($q) {
        $q->where('active', true)->orderBy('display_order');
    }])
    ->orderBy('display_order')
    ->get();
```

**SEO:**
- Title: "Our Services | Environmental Consultancy | KMG"
- Meta description: Overview of all services

---

#### 3.3.2 Individual Service (`/services/{slug}`)

**Purpose:** Detailed information about a specific service

**Volt Component:** `resources/views/pages/services/show.blade.php`

**Route:** `Route::get('/services/{service:slug}', ShowService::class)`

**Content:**
1. Breadcrumb: Home > Services > [Service Name]
2. Service icon and name (h1)
3. Full description (rich text)
4. Related information:
   - Service category
   - Relevant sectors (if applicable)
5. Call-to-action: "Request a Quote" or "Contact Us"
6. Related services from same category (2-3 cards)

**Data:** `Service::where('slug', $slug)->where('active', true)->firstOrFail()`

**SEO:**
- Title: From `meta_title` or fallback to `{name} | KMG Environmental Solutions`
- Meta description: From `meta_description` or excerpt from description
- Meta keywords: From `meta_keywords`
- Schema: Service

---

### 3.4 Sectors & Projects

#### 3.4.1 Sectors Listing (`/sectors`)

**Purpose:** Browse sectors KMG serves

**Volt Component:** `resources/views/pages/sectors/index.blade.php`

**Content:**
1. Hero breadcrumb
2. Introduction to sectors
3. Grid of sectors (3 columns)
   - Sector icon
   - Name
   - Description excerpt
   - Project count badge
   - "View Projects" link

**Data:** `Sector::withCount('projects')->orderBy('display_order')->get()`

**SEO:**
- Title: "Industry Sectors We Serve | KMG Environmental Solutions"
- Meta description: Sectors overview

---

#### 3.4.2 Projects Portfolio (`/projects`)

**Purpose:** Showcase completed projects with filtering

**Volt Component:** `resources/views/pages/projects/index.blade.php`

**Content:**
1. Hero breadcrumb
2. Filter controls:
   - Filter by sector (dropdown or pills)
   - Filter by province (dropdown)
   - Filter by featured (toggle)
   - Search by name
3. Grid of project cards (3 columns desktop, 2 tablet, 1 mobile)
   - Featured image
   - Project name
   - Sector badge
   - Province
   - Completion date
   - "View Details" link
4. Pagination

**Data:**
```php
$projects = Project::query()
    ->when($sector, fn($q) => $q->where('sector_id', $sector))
    ->when($province, fn($q) => $q->where('province', $province))
    ->when($featured, fn($q) => $q->where('featured', true))
    ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
    ->latest('completion_date')
    ->paginate(9);
```

**SEO:**
- Title: "Our Projects | Environmental Consultancy Portfolio | KMG"
- Meta description: Project portfolio overview

---

#### 3.4.3 Individual Project (`/projects/{slug}`)

**Purpose:** Detailed project case study

**Volt Component:** `resources/views/pages/projects/show.blade.php`

**Content:**
1. Breadcrumb: Home > Projects > [Project Name]
2. Project name (h1)
3. Metadata: Sector, Province, Completion Date
4. Featured image (large)
5. Full description (rich text)
6. Gallery images (if any) - lightbox gallery
7. Related projects from same sector (2-3 cards)

**Data:** `Project::where('slug', $slug)->with('sector')->firstOrFail()`

**SEO:**
- Title: From `meta_title` or `{name} | KMG Projects`
- Meta description: From `meta_description` or description excerpt
- Schema: Article or Project

---

### 3.5 Training Pages

#### 3.5.1 Training Courses (`/training`)

**Purpose:** Browse available training courses

**Volt Component:** `resources/views/pages/training/index.blade.php`

**Content:**
1. Hero breadcrumb
2. Training introduction
3. Grid of course cards (3 columns)
   - Featured image
   - Course name
   - Duration
   - Price (ZAR)
   - "View Details & Book" button
4. Filter: Show only active courses

**Data:** `TrainingCourse::where('active', true)->orderBy('name')->get()`

**SEO:**
- Title: "Training Courses | Environmental Training | KMG"
- Meta description: Training offerings overview

---

#### 3.5.2 Individual Training Course (`/training/{slug}`)

**Purpose:** Course details with upcoming schedules and booking

**Volt Component:** `resources/views/pages/training/show.blade.php`

**Content:**
1. Breadcrumb: Home > Training > [Course Name]
2. Course name (h1)
3. Course details:
   - Featured image
   - Full description
   - Duration
   - Max participants
   - Price (prominently displayed in ZAR)
4. **Upcoming Schedules Section:**
   - Table/cards of upcoming schedules
   - Columns: Date, Location, Available Seats
   - Color-coded availability (green/orange/red)
   - "Book Now" button per schedule
5. **Booking Modal/Form:**
   - Opens when "Book Now" clicked
   - Fields: Name, Email, Phone, Company (optional)
   - Selected schedule (pre-filled)
   - Validation
   - Creates `TrainingBooking` with status 'pending'
   - Success message: "Booking request submitted! We'll contact you shortly."

**Data:**
```php
$course = TrainingCourse::where('slug', $slug)->where('active', true)->firstOrFail();
$schedules = TrainingSchedule::where('training_course_id', $course->id)
    ->where('start_datetime', '>=', now())
    ->orderBy('start_datetime')
    ->get();
```

**SEO:**
- Title: From `meta_title` or `{name} | Training | KMG`
- Meta description: From `meta_description` or description excerpt
- Schema: Course, Event

---

### 3.6 Equipment Pages

#### 3.6.1 Equipment Catalog (`/equipment`)

**Purpose:** Browse available equipment for rental

**Volt Component:** `resources/views/pages/equipment/index.blade.php`

**Content:**
1. Hero breadcrumb
2. Equipment introduction
3. Filter by category (dropdown or pills)
4. Grid of equipment cards (3 columns)
   - Featured image
   - Equipment name
   - Category
   - Rental rates (daily/weekly/monthly in ZAR)
   - "View Details & Request Quote" button
5. Filter: Show only available equipment

**Data:**
```php
$equipment = Equipment::where('available', true)
    ->when($category, fn($q) => $q->where('equipment_category_id', $category))
    ->orderBy('name')
    ->paginate(12);
```

**SEO:**
- Title: "Equipment Rental | Environmental Equipment | KMG"
- Meta description: Equipment rental overview

---

#### 3.6.2 Individual Equipment (`/equipment/{slug}`)

**Purpose:** Equipment details with quote request

**Volt Component:** `resources/views/pages/equipment/show.blade.php`

**Content:**
1. Breadcrumb: Home > Equipment > [Equipment Name]
2. Equipment name (h1)
3. Equipment details:
   - Featured image
   - Gallery images (lightbox)
   - Full description
   - Category
   - Rental rates table:
     - Daily Rate: R X
     - Weekly Rate: R X
     - Monthly Rate: R X
4. **Quote Request Form:**
   - Fields: Name, Email, Phone, Company
   - Rental period: Start Date, End Date
   - Additional notes (textarea)
   - Equipment (pre-filled)
   - Validation
   - Creates `EquipmentRentalQuote` with status 'pending'
   - Auto-calculate: duration in days, estimated total
   - Success message: "Quote request submitted! We'll respond within 24 hours."

**Data:** `Equipment::where('slug', $slug)->where('available', true)->with('equipmentCategory')->firstOrFail()`

**SEO:**
- Title: From `meta_title` or `{name} | Equipment Rental | KMG`
- Meta description: From `meta_description` or description excerpt
- Schema: Product, Offer

---

### 3.7 Blog Pages

#### 3.7.1 Blog Listing (`/blog`)

**Purpose:** Browse all blog posts

**Volt Component:** `resources/views/pages/blog/index.blade.php`

**Content:**
1. Hero breadcrumb
2. Blog introduction
3. Grid of blog post cards (3 columns desktop, 2 tablet, 1 mobile)
   - Featured image
   - Title
   - Excerpt
   - Published date
   - Author
   - "Read More" link
4. Pagination (10 posts per page)

**Data:**
```php
$posts = BlogPost::where('published', true)
    ->latest('published_at')
    ->paginate(10);
```

**SEO:**
- Title: "Blog | Environmental Insights | KMG Environmental Solutions"
- Meta description: Blog overview

---

#### 3.7.2 Individual Blog Post (`/blog/{slug}`)

**Purpose:** Read full blog post

**Volt Component:** `resources/views/pages/blog/show.blade.php`

**Content:**
1. Breadcrumb: Home > Blog > [Post Title]
2. Post title (h1)
3. Metadata: Author, Published Date
4. Featured image (large)
5. Full content (rich text)
6. Related posts section (2-3 recent posts)
7. CTA: "Contact us for more information"

**Data:** `BlogPost::where('slug', $slug)->where('published', true)->firstOrFail()`

**SEO:**
- Title: From `meta_title` or `{title} | KMG Blog`
- Meta description: From `meta_description` or excerpt
- Schema: Article, BlogPosting

---

### 3.8 Resources (Downloads)

**Purpose:** Browse and download resources

**Volt Component:** `resources/views/pages/resources.blade.php`

**Route:** `Route::get('/resources', Resources::class)`

**Content:**
1. Hero breadcrumb
2. Introduction to downloadable resources
3. Filter by category (All, Guide, Report, Brochure, Form, Template, Other)
4. Table or cards of resources:
   - Name
   - Category
   - File size
   - Download count
   - "Download" button (opens file, increments counter)
5. Optional: Create `LeadCapture` when user downloads (email gate)

**Data:** `Resource::where('active', true)->orderBy('name')->get()`

**SEO:**
- Title: "Resources & Downloads | KMG Environmental Solutions"
- Meta description: Downloadable resources overview

---

### 3.9 Contact Page (`/contact`)

**Purpose:** Main contact form and information

**Volt Component:** `resources/views/pages/contact.blade.php`

**Content:**
1. Hero breadcrumb
2. Contact introduction
3. **Contact Form:**
   - Name (required)
   - Email (required)
   - Phone (required)
   - Company (optional)
   - Subject Type: General Inquiry, Service Inquiry, Training Inquiry, Equipment Inquiry, Quote Request
   - Message (required, textarea)
   - Validation
   - Creates `ContactSubmission` with status 'new'
   - Success message: "Thank you! We'll respond within 24 hours."
   - Email notification to KMG admins
4. **Contact Information:**
   - Physical address
   - Phone number
   - Email address
   - Business hours
5. **Google Map Embed** (optional if address available)
6. **Social Media Links**

**SEO:**
- Title: "Contact Us | KMG Environmental Solutions"
- Meta description: Contact information and form

---

## 4. Shared Components

### 4.1 Layout (`resources/views/components/layouts/app.blade.php`)

**Features:**
- Meta tags (title, description, keywords, og tags)
- Google Analytics (if configured)
- Favicon links
- CSS (compiled Tailwind)
- Header component
- Main content area (slot)
- Footer component
- JS (compiled Alpine/Livewire)

---

### 4.2 Header Component (`resources/views/components/header.blade.php`)

**Features:**
- KMG logo (links to homepage)
- Main navigation (desktop)
- Mobile menu toggle
- Mobile navigation drawer
- Active state highlighting
- Sticky header on scroll (optional)

**Navigation Items:**
```php
[
    ['label' => 'Home', 'url' => '/', 'active' => request()->is('/')],
    ['label' => 'About', 'url' => '/about', 'children' => [
        ['label' => 'Our Team', 'url' => '/team'],
        ['label' => 'Accreditations', 'url' => '/accreditations'],
    ]],
    ['label' => 'Services', 'url' => '/services'],
    ['label' => 'Projects', 'url' => '/projects'],
    ['label' => 'Training', 'url' => '/training'],
    ['label' => 'Equipment', 'url' => '/equipment'],
    ['label' => 'Blog', 'url' => '/blog'],
    ['label' => 'Contact', 'url' => '/contact'],
]
```

---

### 4.3 Footer Component (`resources/views/components/footer.blade.php`)

**Sections:**
- KMG logo and tagline
- Quick links navigation
- Top services (dynamic from ServiceCategory)
- Company links (About, Team, Accreditations, etc.)
- Contact information
- Social media icons
- Copyright notice
- Legal links (Privacy Policy, Terms)

---

### 4.4 Breadcrumb Component (`resources/views/components/breadcrumb.blade.php`)

**Usage:**
```blade
<x-breadcrumb :items="[
    ['label' => 'Home', 'url' => '/'],
    ['label' => 'Services', 'url' => '/services'],
    ['label' => $service->name],
]" />
```

---

### 4.5 Service Card Component (`resources/views/components/service-card.blade.php`)

**Props:** `$service` (Service model)

**Display:**
- Service icon
- Service name
- Short description (excerpt)
- "Learn More" button

---

### 4.6 Project Card Component (`resources/views/components/project-card.blade.php`)

**Props:** `$project` (Project model)

**Display:**
- Featured image
- Project name
- Sector badge
- Province
- Completion date
- "View Details" link

---

### 4.7 Blog Post Card Component (`resources/views/components/blog-post-card.blade.php`)

**Props:** `$post` (BlogPost model)

**Display:**
- Featured image
- Title
- Excerpt
- Author
- Published date
- "Read More" link

---

### 4.8 Team Member Card Component (`resources/views/components/team-member-card.blade.php`)

**Props:** `$member` (TeamMember model)

**Display:**
- Circular photo
- Name
- Position
- Bio excerpt
- Professional registrations (collapsed/expandable)
- LinkedIn link icon

---

## 5. Interactive Features (Livewire Volt)

### 5.1 Training Booking Form

**Component:** `resources/views/livewire/training-booking-form.blade.php`

**Props:**
- `$schedule` (TrainingSchedule model)
- `$course` (TrainingCourse model)

**State:**
```php
state([
    'name' => '',
    'email' => '',
    'phone' => '',
    'company' => '',
]);
```

**Validation:**
```php
$rules = [
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'phone' => 'required|string|max:20',
    'company' => 'nullable|string|max:255',
];
```

**Actions:**
```php
$submit = function() {
    $validated = $this->validate();

    TrainingBooking::create([
        'training_schedule_id' => $this->schedule->id,
        'name' => $this->name,
        'email' => $this->email,
        'phone' => $this->phone,
        'company' => $this->company,
        'status' => 'pending',
    ]);

    // Send notification email
    // Reset form
    // Show success message
};
```

---

### 5.2 Equipment Quote Form

**Component:** `resources/views/livewire/equipment-quote-form.blade.php`

**Props:**
- `$equipment` (Equipment model)

**State:**
```php
state([
    'name' => '',
    'email' => '',
    'phone' => '',
    'company' => '',
    'start_date' => '',
    'end_date' => '',
    'notes' => '',
]);

$total = computed(function() {
    if (!$this->start_date || !$this->end_date) return null;

    $days = Carbon::parse($this->end_date)->diffInDays($this->start_date);
    // Calculate based on daily/weekly/monthly rates
    return $calculatedTotal;
});
```

**Validation:**
```php
$rules = [
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'phone' => 'required|string|max:20',
    'company' => 'nullable|string|max:255',
    'start_date' => 'required|date|after:today',
    'end_date' => 'required|date|after:start_date',
    'notes' => 'nullable|string|max:1000',
];
```

**Actions:**
```php
$submit = function() {
    $validated = $this->validate();

    $days = Carbon::parse($this->end_date)->diffInDays($this->start_date);

    EquipmentRentalQuote::create([
        'equipment_id' => $this->equipment->id,
        'name' => $this->name,
        'email' => $this->email,
        'phone' => $this->phone,
        'company' => $this->company,
        'start_date' => $this->start_date,
        'end_date' => $this->end_date,
        'duration_days' => $days,
        'total_price' => $this->total,
        'notes' => $this->notes,
        'status' => 'pending',
    ]);

    // Send notification
    // Reset form
    // Show success
};
```

---

### 5.3 Contact Form

**Component:** `resources/views/livewire/contact-form.blade.php`

**State:**
```php
state([
    'name' => '',
    'email' => '',
    'phone' => '',
    'company' => '',
    'subject_type' => 'general_inquiry',
    'message' => '',
]);
```

**Validation:**
```php
$rules = [
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'phone' => 'required|string|max:20',
    'company' => 'nullable|string|max:255',
    'subject_type' => 'required|in:general_inquiry,service_inquiry,training_inquiry,equipment_inquiry,quote_request',
    'message' => 'required|string|max:2000',
];
```

**Actions:**
```php
$submit = function() {
    $validated = $this->validate();

    ContactSubmission::create([
        ...$validated,
        'status' => 'new',
    ]);

    // Send email to admins
    // Reset form
    // Show success message
};
```

---

### 5.4 Project Filter

**Component:** `resources/views/livewire/project-filter.blade.php`

**State:**
```php
state([
    'sector' => '',
    'province' => '',
    'search' => '',
    'featured' => false,
]);

$projects = computed(function() {
    return Project::query()
        ->when($this->sector, fn($q) => $q->where('sector_id', $this->sector))
        ->when($this->province, fn($q) => $q->where('province', $this->province))
        ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
        ->when($this->featured, fn($q) => $q->where('featured', true))
        ->latest('completion_date')
        ->paginate(9);
});
```

**UI:**
- Dropdowns for sector and province
- Search input with `wire:model.live.debounce.300ms`
- Featured toggle
- Results update in real-time

---

## 6. Design Specifications

### 6.1 Color Palette

**Primary:**
- Green: `#1e7e34` (KMG brand color)
- Dark Green: `#165a26` (hover states)
- Light Green: `#28a745` (accents)

**Neutrals:**
- Dark: `#1a202c`
- Gray: `#718096`
- Light Gray: `#e2e8f0`
- White: `#ffffff`

**Semantic:**
- Success: `#28a745`
- Warning: `#ffc107`
- Danger: `#dc3545`
- Info: `#17a2b8`

---

### 6.2 Typography

**Font Family:** Inter (variable font)

**Scale:**
```css
h1: 3rem (48px), font-weight: 700, line-height: 1.2
h2: 2.25rem (36px), font-weight: 700, line-height: 1.3
h3: 1.875rem (30px), font-weight: 600, line-height: 1.4
h4: 1.5rem (24px), font-weight: 600, line-height: 1.5
h5: 1.25rem (20px), font-weight: 600, line-height: 1.5
h6: 1rem (16px), font-weight: 600, line-height: 1.5
body: 1rem (16px), font-weight: 400, line-height: 1.6
small: 0.875rem (14px), font-weight: 400, line-height: 1.5
```

---

### 6.3 Spacing

**Scale (Tailwind CSS 4):**
- 8px increments: 8, 16, 24, 32, 48, 64, 96, 128
- Use `gap-*` for grids and flex layouts
- Consistent padding: sections (py-16), containers (px-4)

---

### 6.4 Responsive Breakpoints

```css
sm: 640px
md: 768px
lg: 1024px
xl: 1280px
2xl: 1536px
```

**Mobile-First Approach:**
- Design for mobile (375px) first
- Enhance for tablet (768px)
- Optimize for desktop (1280px+)

---

### 6.5 Components

**Buttons:**
```blade
<flux:button variant="primary">Primary CTA</flux:button>
<flux:button variant="secondary">Secondary Action</flux:button>
<flux:button variant="ghost">Tertiary Action</flux:button>
```

**Cards:**
```blade
<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
    <!-- Card content -->
</div>
```

**Badges:**
```blade
<flux:badge>Status</flux:badge>
```

---

## 7. SEO & Performance

### 7.1 SEO Requirements

**Every Page:**
- Unique `<title>` tag (max 60 chars)
- Unique meta description (max 160 chars)
- Meta keywords (where applicable)
- Open Graph tags (og:title, og:description, og:image, og:url)
- Twitter Card tags
- Canonical URL
- Structured data (Schema.org JSON-LD)

**Sitemaps:**
- Auto-generated XML sitemap at `/sitemap.xml`
- Includes all public pages
- Updates automatically when content changes

**Robots.txt:**
- Allow all public pages
- Disallow admin panel (`/admin`)

---

### 7.2 Performance

**Image Optimization:**
- All images optimized (WebP format preferred)
- Responsive images with `srcset`
- Lazy loading for below-fold images
- Max image sizes defined

**Caching:**
- Page caching for static content (5 minutes)
- Query result caching for expensive queries
- Browser caching headers

**Minification:**
- CSS minified in production
- JS minified in production
- HTML minification (optional)

**Core Web Vitals Targets:**
- LCP (Largest Contentful Paint): < 2.5s
- FID (First Input Delay): < 100ms
- CLS (Cumulative Layout Shift): < 0.1

---

## 8. Accessibility

**WCAG 2.1 AA Compliance:**
- Semantic HTML5 elements
- ARIA labels where needed
- Keyboard navigation support
- Focus indicators visible
- Color contrast ratios meet standards (4.5:1 for text)
- Alt text for all images
- Form labels properly associated

**Testing:**
- Lighthouse accessibility score > 90
- Axe DevTools validation
- Keyboard-only navigation testing

---

## 9. Routes

**routes/web.php:**

```php
use App\Livewire\{
    Home,
    About,
    Team,
    Accreditations,
    Services\Index as ServicesIndex,
    Services\Show as ServiceShow,
    Sectors\Index as SectorsIndex,
    Projects\Index as ProjectsIndex,
    Projects\Show as ProjectShow,
    Training\Index as TrainingIndex,
    Training\Show as TrainingShow,
    Equipment\Index as EquipmentIndex,
    Equipment\Show as EquipmentShow,
    Blog\Index as BlogIndex,
    Blog\Show as BlogShow,
    Resources,
    Contact,
};

// Homepage
Route::get('/', Home::class)->name('home');

// About
Route::get('/about', About::class)->name('about');
Route::get('/team', Team::class)->name('team');
Route::get('/accreditations', Accreditations::class)->name('accreditations');

// Services
Route::get('/services', ServicesIndex::class)->name('services.index');
Route::get('/services/{service:slug}', ServiceShow::class)->name('services.show');

// Sectors & Projects
Route::get('/sectors', SectorsIndex::class)->name('sectors.index');
Route::get('/projects', ProjectsIndex::class)->name('projects.index');
Route::get('/projects/{project:slug}', ProjectShow::class)->name('projects.show');

// Training
Route::get('/training', TrainingIndex::class)->name('training.index');
Route::get('/training/{course:slug}', TrainingShow::class)->name('training.show');

// Equipment
Route::get('/equipment', EquipmentIndex::class)->name('equipment.index');
Route::get('/equipment/{equipment:slug}', EquipmentShow::class)->name('equipment.show');

// Blog
Route::get('/blog', BlogIndex::class)->name('blog.index');
Route::get('/blog/{post:slug}', BlogShow::class)->name('blog.show');

// Resources
Route::get('/resources', Resources::class)->name('resources');

// Contact
Route::get('/contact', Contact::class)->name('contact');

// Admin (already configured in Phase 1/2)
// Filament::routes() handled by FilamentServiceProvider
```

---

## 10. Testing Requirements

**Feature Tests:**
1. Homepage renders correctly
2. All navigation links work
3. Service listing shows active services only
4. Service detail page loads with correct data
5. Project filtering works (sector, province, search)
6. Training booking form validates correctly
7. Training booking creates database record
8. Equipment quote form validates correctly
9. Equipment quote creates database record
10. Contact form validates correctly
11. Contact form creates database record
12. Blog listing shows published posts only
13. SEO meta tags present on all pages
14. Responsive navigation works (mobile menu)

**Browser Tests (Pest v4):**
1. Homepage interaction (click CTAs, navigate)
2. Service browsing end-to-end
3. Training course booking flow
4. Equipment quote request flow
5. Contact form submission
6. Project filtering interaction
7. Mobile navigation drawer

---

## 11. Email Notifications

**Training Booking Notification:**
- **To:** Admin users (jvw679@gmail.com, marabekg@kmgenviro.co.za)
- **Subject:** New Training Booking Request
- **Content:** Booking details (name, email, phone, course, schedule)

**Equipment Quote Notification:**
- **To:** Admin users
- **Subject:** New Equipment Rental Quote Request
- **Content:** Quote details (name, equipment, dates, total)

**Contact Form Notification:**
- **To:** Admin users
- **Subject:** New Contact Form Submission
- **Content:** Contact details and message

**Auto-Responder (Optional):**
- **To:** Customer (who submitted form)
- **Subject:** Thank You - We've Received Your Request
- **Content:** Acknowledgment, expected response time

---

## 12. Success Criteria

Phase 3 is complete when:

- ✅ All 15+ public pages are implemented and functional
- ✅ Homepage showcases KMG's services, projects, and team
- ✅ Services, training, and equipment are browsable with detail pages
- ✅ Interactive forms work (training booking, equipment quote, contact)
- ✅ All forms create database records and send notifications
- ✅ Project filtering works correctly
- ✅ Blog posts display with proper formatting
- ✅ Responsive design works on mobile, tablet, desktop
- ✅ SEO meta tags present on all pages
- ✅ All navigation links work correctly
- ✅ Footer displays dynamic service links
- ✅ Image uploads from admin panel display correctly
- ✅ All tests passing (feature + browser tests)
- ✅ Lighthouse score > 90 (Performance, Accessibility, Best Practices, SEO)
- ✅ Code formatted with Laravel Pint
- ✅ Documentation updated

---

## 13. Out of Scope (Future Phases)

- User authentication on public site (Phase 4)
- Online payment for training bookings (Phase 4)
- WordPress content migration (Phase 5)
- Multi-language support (Future)
- Advanced search functionality (Future)
- Newsletter subscription management (Future)
