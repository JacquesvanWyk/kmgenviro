# Specification: KMG Environmental Website Rebuild - Phase 1 Foundation & Setup

## Goal

Establish the complete technical foundation for the KMG Environmental Solutions website rebuild by generating all database models from Blueprint schema, installing and configuring Filament admin panel with KMG branding, creating foundation-level seeders with real company data, and implementing comprehensive testing to verify all relationships and functionality work correctly.

## User Stories

- As a developer, I want all 16 models with proper relationships generated from Blueprint so I can immediately start building Filament resources without manual model creation
- As the client, I want to access a fully branded admin panel at /admin with KMG logos and green color scheme so the CMS feels like our own system from day one
- As a project stakeholder, I want 10 service categories and 8 accreditations seeded with real company data so we can verify content structure matches our business needs before building public pages

## Specific Requirements

### Database Setup & Configuration

- Create database named `kmgenviro` in DBngin with user `root` and no password
- Verify MySQL connection before running any migrations using `php artisan db:show`
- Execute Blueprint schema from `/agent-os/product/blueprint-schema.yaml` to generate all 16 models with migrations, factories, and controllers
- Run migrations with `php artisan migrate` (never use migrate:fresh to preserve existing database)
- Verify all tables created successfully with proper foreign keys, indexes, and default values
- Check that soft deletes are enabled on models that specify it in the Blueprint schema
- Ensure all slug fields have unique indexes for SEO-friendly URLs
- Verify JSON cast fields (services_provided, gallery_images, delegate_names) are properly configured in models

### Models & Relationships Structure

- Generate ServiceCategory model with hasMany relationship to Service
- Generate Service model with belongsTo relationship to ServiceCategory
- Generate Sector model with hasMany relationship to Project
- Generate Project model with belongsTo relationship to Sector
- Generate TrainingCourse model with hasMany relationships to both TrainingSchedule and TrainingBooking
- Generate TrainingSchedule model with belongsTo TrainingCourse and hasMany TrainingBooking
- Generate TrainingBooking model with belongsTo relationships to both TrainingCourse and TrainingSchedule
- Generate EquipmentCategory model with hasMany relationship to Equipment
- Generate Equipment model with belongsTo EquipmentCategory and hasMany EquipmentRentalQuote
- Generate EquipmentRentalQuote model with belongsTo Equipment
- Generate Resource model with hasMany relationship to LeadCapture
- Generate LeadCapture model with belongsTo Resource
- Generate standalone models (TeamMember, BlogPost, ClientLogo, Accreditation, ContactSubmission) without relationships
- Ensure all models use constructor property promotion (PHP 8.3 feature)
- Add explicit return type declarations on all relationship methods
- Configure $fillable or $guarded properties on all models based on security requirements

### Filament Installation & Admin Panel Configuration

- Install Filament 3.x via `composer require filament/filament:"^3.2" -W`
- Run `php artisan filament:install --panels` to create admin panel structure
- Configure admin panel path as `/admin` in AdminPanelProvider
- Set brand name to "KMG Environmental" in panel configuration
- Set primary color to green `#1e7e34` using Filament's Color helper
- Configure main logo to use `/public/images/logo.png` (kmg-logo-primary.png)
- Configure dark mode logo to use `/public/images/logo-white.png`
- Set favicon to `/public/favicon.ico`
- Configure navigation groups in this order: Content Management, Training & Bookings, Equipment Rental, Marketing, Inquiries
- Verify admin panel loads at `/admin` route with login page displaying KMG branding

### Logo Assets Creation & Configuration

- Copy `planning/visuals/kmg-logo-primary.png` to `public/images/logo.png` for main admin header logo
- Create square icon version by cropping just the earth/leaf icon from main logo to 200x200px, save as `public/images/icon.png`
- Create white/inverted version of full logo for dark mode support, save as `public/images/logo-white.png`
- Generate favicon set using realfavicongenerator.net or similar from the square icon
- Create `favicon.ico` (multi-resolution: 16x16, 32x32, 48x48) in `public/`
- Create `favicon-16x16.png` and `favicon-32x32.png` in `public/`
- Create `apple-touch-icon.png` (180x180) for iOS home screen in `public/`
- Create `android-chrome-192x192.png` and `android-chrome-512x512.png` for Android
- Create `site.webmanifest` with app name "KMG Environmental Solutions", theme color `#1e7e34`
- Verify all logos display correctly in admin panel header and browser tabs

### Typography Configuration

- Choose Inter as the recommended font family (modern, professional, excellent readability for technical content)
- Add Google Fonts import for Inter variable font in `resources/css/app.css`
- Configure `@theme` directive in Tailwind CSS 4 with `--font-family-sans` set to Inter with system font fallback
- Define custom font size scale from xs (12px) to 6xl (60px) in theme variables
- Set custom line heights: tight (1.25), snug (1.375), normal (1.5), relaxed (1.625), loose (2)
- Configure letter spacing for headings: tight (-0.025em) for better large text rendering
- Apply global body styles with antialiasing enabled
- Set heading styles (h1-h6) with appropriate font weights (700-800) and tight line-height
- Configure Filament panel to use Inter font family via `->font('Inter')` method
- Verify fonts load correctly without FOIT (Flash of Invisible Text) using `font-display: swap`

### Seeders Implementation

- Create ServiceCategorySeeder with 10 real categories: Environmental Monitoring Services, Environmental Impact & Specialist Studies, Permitting Services & Applications, Waste Management Services, ESG Advisory & Reporting, Occupational Hygiene Services, Training Courses & CPD, Equipment Rental Services, Environmental Auditing & Compliance, Asbestos Management Services
- For each service category include: name, slug, 2-3 sentence description from company profile, meta_title, meta_description, sort_order (1-10), is_active set to true
- Create AccreditationSeeder with 8 accreditations: DoEL, SACNASP, EAPASA, GBCSA, WISA, SAIOH, IIAV, IAIAsa
- For each accreditation include: full name, acronym, 1-2 sentence description, sort_order, is_active set to true (logo and certificate_number left null for Phase 2)
- Create UserSeeder generating two admin users: Jacques van Wyk (jvw679@gmail.com) and Khumbelo Marabe (marabekg@kmgenviro.co.za)
- Generate random secure 16-character password for each user using `Str::random(16)` and hash with `Hash::make()`
- Output generated passwords to console during seeding with clear warnings to save them securely
- Set email_verified_at to now() for both users so they can log in immediately
- Configure DatabaseSeeder to call all three seeders in order: ServiceCategorySeeder, AccreditationSeeder, UserSeeder
- Verify seeded data appears correctly in database using `php artisan tinker` with count queries

### Testing Requirements

- Create `tests/Feature/ModelRelationshipsTest.php` to test all 8 one-to-many and 8 belongs-to relationships
- Test ServiceCategory → Services relationship creates and retrieves related services correctly
- Test Sector → Projects, TrainingCourse → TrainingSchedules, TrainingCourse → TrainingBookings relationships
- Test TrainingSchedule → TrainingBookings, EquipmentCategory → Equipment, Equipment → EquipmentRentalQuotes relationships
- Test Resource → LeadCaptures relationship and all inverse belongsTo relationships
- Create `tests/Feature/FactoryTest.php` to verify all 16 model factories generate valid, realistic data
- Test each factory creates models with non-null required fields, proper data types, and valid default values
- Create `tests/Feature/CrudOperationsTest.php` for top 5 models (ServiceCategory, Service, TeamMember, TrainingCourse, Equipment)
- Test complete CRUD cycle: create record, read/find by ID, update attributes, soft delete, verify withTrashed finds deleted record
- Run full test suite with `php artisan test` and verify all tests pass before Phase 1 completion
- Run specific test files with filter when debugging: `php artisan test --filter=relationship`

### Git Workflow & Commit Strategy

- DO NOT commit changes automatically - always ask for user review first
- DO NOT add Claude Code attribution footers to any commits
- DO NOT use "🤖 Generated with Claude Code" or "Co-Authored-By: Claude" in commit messages
- Suggest clear, concise commit messages in format: "Add [feature]" with bullet points of key changes
- Provide summary of all changes made before suggesting commit
- Let user execute all git commands manually after reviewing changes
- Suggest review/commit checkpoints after: Blueprint generation, Filament installation, seeders completion, test suite completion
- Verify no sensitive data (passwords, env files) included in commits before user commits

### Code Quality Standards

- Run `vendor/bin/pint --dirty` on all PHP files before suggesting commit to ensure Laravel code style
- Use PHP 8.3 constructor property promotion in all new classes: `public function __construct(public GitHub $github) {}`
- Always use explicit return type declarations on methods: `public function index(): View`
- Use proper type hints for parameters: `protected function isAccessible(User $user, ?string $path = null): bool`
- Prefer PHPDoc blocks over inline comments - only add comments for very complex logic
- Keep code simple and minimal - avoid over-engineering or unnecessary abstractions
- Follow Laravel 12 conventions: use Eloquent over raw queries, Form Requests for validation, named routes
- Use Pest test syntax with `it()` and `expect()` assertions, not PHPUnit style

## Visual Design

### planning/visuals/kmg-logo-primary.png

- Horizontal logo with earth/leaf icon on left, company name on right
- Earth icon features blue globe with lime green leaf element and gold/tan accent
- "KMG" text in navy blue italic font
- "Environmental Solutions Services" subtitle in medium blue
- Dimensions approximately 1216x438px with transparent background
- Use as-is for main admin panel header logo at `/public/images/logo.png`
- Crop left portion (just earth icon) to create 200x200px square icon for compact views
- Invert colors to white for dark mode logo version

## Existing Code to Leverage

### Blueprint Schema YAML (agent-os/product/blueprint-schema.yaml)

- Complete database schema already defined for all 16 models with exact field types, indexes, and relationships
- Use `php artisan blueprint:build` to auto-generate models, migrations, factories, and controllers
- Blueprint generates proper foreign key constraints, soft deletes, unique indexes, and default values automatically
- Generates factories with faker data - review and customize factory definitions to use realistic environmental industry data
- Saves hours of manual model creation and ensures consistency across all model definitions

### Laravel 12 & Filament Best Practices (CLAUDE.md laravel-boost-guidelines)

- Use `php artisan make:` commands for all file creation (migrations, models, controllers, seeders)
- Never use `env()` function directly - always access config via `config('app.name')`
- Use named routes with `route()` function for URL generation in views
- Filament panels configured via AdminPanelProvider with fluent chain methods
- Set colors using `Color::hex('#1e7e34')` helper method, not raw hex strings
- Configure brand assets (logo, favicon) via panel configuration methods `->brandLogo()`, `->favicon()`

### Tailwind CSS 4 Configuration (@theme directive)

- Use `@theme` directive in CSS instead of tailwind.config.js for theme customization
- Define custom properties like `--color-brand-green: #1e7e34` inside @theme block
- Import Tailwind using `@import "tailwindcss";` not old @tailwind directives
- Use utility classes directly - avoid creating custom CSS classes unless truly reusable component
- Responsive design with mobile-first breakpoints: sm, md, lg, xl
- Dark mode via `dark:` variant classes

### Inter Font from Google Fonts

- Single versatile font family works for all text (headings and body)
- Variable font option loads all weights in one file for better performance
- Specifically designed for computer screens with excellent readability
- Used by major tech companies and scientific organizations
- Free and open-source with wide browser support
- Include via Google Fonts CDN with `font-display: swap` to prevent FOIT

### Real Company Data from Requirements (planning/seeders-data.md)

- All 10 service category names, descriptions, and meta tags already written with real KMG services
- All 8 accreditation names, acronyms, and descriptions match actual KMG credentials
- Copy exact data from seeders-data.md into seeder classes - no need to write new descriptions
- Two admin user emails provided: jvw679@gmail.com (developer) and marabekg@kmgenviro.co.za (client)
- ServiceCategory descriptions include technical details (SACNASP, NEMA, DoEL approvals) showing expertise

## Out of Scope

### Filament Resources - Phase 2 Only

- Creating Filament Resource classes for any of the 16 models - this happens in Phase 2
- Form field definitions, table columns, filters, or actions for resources
- Relationship managers to edit related records within parent resource
- Custom Filament actions or bulk operations
- Dashboard widgets showing statistics or recent activity

### Public Frontend Pages - Phase 3 Only

- Homepage with hero section, service cards, and featured projects
- Service category and individual service detail pages
- Team member directory and individual profile pages
- Project portfolio listing and case study detail pages
- About page with company mission, vision, and team info
- Contact page with contact form

### Interactive Forms & Bookings - Phase 4 Only

- Training course booking wizard with multi-step form
- Equipment rental quote request form with delivery options
- Contact form with service type selection
- Lead capture forms for resource downloads
- Email notifications for form submissions

### Content Migration from WordPress - Phase 5 Only

- Exporting blog posts and media from existing WordPress site
- Importing WordPress content into Laravel BlogPost model
- Migrating team member content and photos
- Transferring service descriptions from old site
- Moving project case studies and images

### Advanced Features - Future Phases

- Search functionality across services, projects, and blog posts
- WhatsApp integration with floating button
- Email marketing integration (Mailchimp or similar)
- Google Analytics 4 tracking and conversion goals
- User roles and permissions in Filament (Shield plugin)
- Performance optimization (Redis caching, CDN setup)
- SEO optimization (XML sitemap, schema markup)
- Security hardening (2FA, rate limiting)
- Deployment to production hosting
- SSL certificate configuration
- Domain DNS setup

### Testing Beyond Foundation - Future Phases

- Browser tests with Pest 4 for user flows
- Visual regression testing
- Performance testing and optimization
- Accessibility testing (WCAG compliance)
- Cross-browser compatibility testing
- Mobile device testing on real devices

### Third-Party Integrations - Future Phases

- Email service provider (Mailgun, Postmark, or SES)
- File storage service (S3 or Cloudflare R2)
- Error tracking (Flare or Sentry)
- Uptime monitoring
- Backup automation
