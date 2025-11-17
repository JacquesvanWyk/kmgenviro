# Tech Stack

## Backend Framework

### Laravel 12
- **Version:** 12.x (latest stable)
- **PHP Version:** 8.3.27
- **Purpose:** Core application framework providing routing, database ORM, authentication, validation, and business logic
- **Key Features Used:**
  - Eloquent ORM for database relationships and queries
  - Form Request validation for all user inputs
  - Queued jobs for email notifications and background processing
  - Laravel Fortify for authentication (admin users)
  - Task scheduling for automated reminders and cleanup
  - File storage with local and cloud driver support

### Filament Admin Panel
- **Version:** 3.x (latest stable)
- **Purpose:** Content management system providing elegant admin interface for KMG staff to manage all website content
- **Resources Implemented:**
  - Service categories and services (nested relationship)
  - Team member profiles
  - Project portfolio/case studies
  - Training courses and schedules
  - Equipment rental inventory
  - Blog posts and news articles
  - Client logos
  - Lead submissions and bookings
- **Features Used:**
  - Rich text editor (TipTap or similar)
  - File uploads with image optimization
  - Relationship manager for nested data
  - Custom actions and bulk operations
  - User roles and permissions (Filament Shield)
  - Form wizard for multi-step processes
  - Dashboard widgets for analytics

## Frontend Architecture

### Livewire 3
- **Version:** 3.x
- **Purpose:** Full-stack framework enabling reactive interfaces without JavaScript frameworks
- **Key Components:**
  - Contact forms with real-time validation
  - Course booking multi-step wizard
  - Equipment rental quote builder
  - Search functionality with live results
  - Lead submission forms
  - Interactive calendars for course schedules

### Livewire Volt
- **Version:** 1.x
- **Style:** Class-based components (based on existing project conventions in CLAUDE.md)
- **Purpose:** Single-file component structure for simpler Livewire components
- **Use Cases:**
  - Service category cards on homepage
  - Team member grid filtering
  - Project portfolio filters
  - Blog post listing with pagination
  - Resource download cards
  - WhatsApp integration button

### Flux UI (Free Edition)
- **Version:** 2.x
- **Purpose:** Tailwind CSS component library for Livewire applications
- **Components Used:**
  - Buttons (primary, secondary, outline variants)
  - Form inputs (text, email, tel, textarea, select, checkbox, radio)
  - Modals for confirmations and detail views
  - Dropdowns for navigation and filters
  - Badges for accreditation display
  - Cards for service/course/equipment listings
  - Tooltips for additional information
  - Avatars for team member photos
  - Breadcrumbs for navigation hierarchy
- **Note:** Using free edition only; no Pro components available

### Alpine.js
- **Version:** Included with Livewire 3
- **Purpose:** Lightweight JavaScript for UI interactions that don't require server round-trips
- **Use Cases:**
  - Mobile menu toggle
  - Dropdown menus
  - Accordion panels in FAQ sections
  - Image gallery lightbox
  - Scroll-triggered animations
  - Form input masking

### Tailwind CSS
- **Version:** 4.x
- **Purpose:** Utility-first CSS framework for responsive design
- **Configuration:**
  - Theme extended via `@theme` directive in CSS (v4 approach)
  - Custom color palette matching KMG brand (blues, greens)
  - Custom spacing and typography scales
  - Dark mode support via `dark:` variants
- **Approach:**
  - Mobile-first responsive design
  - Component extraction for repeated patterns
  - Minimal custom CSS, favor utility classes

## Database

### MySQL
- **Version:** 8.x
- **Management:** DBngin (local development)
- **Key Schema Components:**
  - **service_categories:** Top-level service groupings (10 categories)
  - **services:** Individual services with category relationship
  - **team_members:** Staff profiles with professional registrations
  - **projects:** Case studies with sector and service relationships
  - **courses:** Training offerings with scheduling data
  - **course_schedules:** Specific course dates/times/locations
  - **equipment:** Rental inventory with specifications
  - **leads:** All contact/quote/booking submissions
  - **bookings:** Training course enrollments with attendee details
  - **blog_posts:** Articles with category/tag taxonomy
  - **clients:** Client logo directory
  - **downloads:** Resource library items
  - **users:** Admin users with Filament access
- **Relationships:**
  - Services belongsTo ServiceCategory
  - Projects belongsToMany Services (pivot table)
  - Courses hasMany CourseSchedules
  - Bookings belongsTo Course and CourseSchedule
  - Leads morphTo (polymorphic for different form types)
  - BlogPosts belongsTo User (author)

## Development Tools

### Blueprint
- **Purpose:** Laravel schema definition and code generation tool
- **Usage:** Define entire database schema in YAML/DSL format, generate migrations, models, factories, controllers, and form requests in single command
- **Benefits:** Accelerates initial model creation, ensures consistent model structure, reduces boilerplate coding
- **Workflow:**
  1. Define schema in `draft.yaml` or inline CLI
  2. Run `php artisan blueprint:build`
  3. Review generated code and customize as needed
  4. Add business logic to generated model methods

### Laravel Pint
- **Version:** 1.x
- **Purpose:** Opinionated PHP code formatter based on PHP-CS-Fixer
- **Usage:** Run `vendor/bin/pint --dirty` before commits to ensure consistent code style
- **Configuration:** Uses Laravel preset by default

### Pest
- **Version:** 4.x
- **Purpose:** Testing framework with browser testing capabilities
- **Test Coverage:**
  - **Feature Tests:** Course booking flow, equipment quote submission, contact form validation, search functionality, lead creation
  - **Browser Tests:** Multi-step booking wizard, service navigation, mobile responsive behavior, WhatsApp integration
  - **Unit Tests:** Model relationships, helper functions, data transformations
- **Testing Philosophy:** Reasonable coverage focused on critical business flows, not perfectionist 100% coverage
- **Commands:**
  - `php artisan test` - Run all tests
  - `php artisan test --filter=testName` - Run specific test
  - `php artisan test tests/Feature/CourseBookingTest.php` - Run specific file

## Third-Party Integrations

### Email Service
- **Provider:** TBD (Mailgun, Postmark, or SES based on client preference)
- **Purpose:** Transactional emails for booking confirmations, quote acknowledgments, lead notifications
- **Implementation:** Laravel Mail with Markdown templates
- **Queue Processing:** Database queue driver (upgrade to Redis in production if needed)

### WhatsApp Business
- **Integration Method:** Direct WhatsApp Web links with pre-filled messages
- **URL Format:** `https://wa.me/27XXXXXXXXX?text=EncodedMessage`
- **Context Awareness:** Message pre-filled based on current page (service, course, equipment)
- **Implementation:** Livewire Volt component with Alpine.js for floating button

### Analytics
- **Google Analytics 4:** Pageview tracking, event tracking, conversion goals
- **Implementation:** Script in layout header, custom event tracking via JavaScript
- **Events Tracked:** Quote requests, bookings, downloads, WhatsApp clicks, search queries
- **Filament Dashboard:** Custom widgets displaying key metrics from GA4 API or database analytics table

### File Storage
- **Local Development:** Local disk driver
- **Production:** TBD (likely S3 or Cloudflare R2 for scalability)
- **Asset Types:** Service brochures (PDF), team photos (JPG/PNG), project images (JPG/PNG), equipment photos (JPG/PNG), downloadable resources (PDF/DOCX)
- **Optimization:** Image resizing on upload using Intervention Image or similar

## Deployment & Infrastructure

### Hosting
- **Platform:** TBD - likely Laravel Forge with DigitalOcean/Vultr or Cloudflare Pages
- **Rationale:** Based on CLAUDE.md guidelines, medium-sized client uses Laravel + Filament suggesting Forge deployment

### Environment
- **Production:** Ubuntu 22.04 LTS, Nginx, PHP-FPM 8.3, MySQL 8.x, Redis (if needed for caching/queues)
- **SSL:** Let's Encrypt via Certbot or Cloudflare SSL
- **Deployment:** Git-based deployment via Forge or CI/CD pipeline

### Monitoring & Logging
- **Error Tracking:** Laravel Flare or Sentry
- **Application Logs:** Laravel Log with daily rotation
- **Uptime Monitoring:** Forge monitoring or external service (UptimeRobot, Pingdom)
- **Backups:** Daily automated database backups via Forge or cron

### Performance
- **Caching:**
  - Application cache: File driver (or Redis in production)
  - View cache: Blade compiled templates
  - Route cache: Cached route definitions
  - Config cache: Cached configuration
- **Asset Pipeline:**
  - Vite for frontend bundling (CSS/JS)
  - CSS purging via Tailwind built-in optimization
  - Asset versioning for cache busting
- **Database Optimization:**
  - Proper indexing on frequently queried columns
  - Eager loading to prevent N+1 queries
  - Query result caching for expensive operations

## Development Workflow

### Version Control
- **Git:** Repository hosted on GitHub/GitLab/Bitbucket
- **Branching:** Feature branches, main/master for production
- **Commits:** Clean commits without Claude Code attribution (per CLAUDE.md rules)

### Local Development Environment
- **PHP:** 8.3.27 via Homebrew or Laravel Herd
- **Database:** DBngin for MySQL management (not command-line mysql tools)
- **Node:** Latest LTS for Vite asset compilation
- **Commands:**
  - Development server: Manual via `php artisan serve` and `npm run dev` (developer runs in background)
  - Database migrations: `php artisan migrate` (never `php artisan migrate:fresh` to preserve data)
  - Asset compilation: `npm run build` for production, `npm run dev` for development

### Code Quality
- **Linting:** Laravel Pint for PHP formatting
- **Testing:** Pest for feature/browser/unit tests
- **Standards:** Follow conventions in CLAUDE.md and Laravel Boost guidelines
- **Comments:** Minimal - prefer PHPDoc blocks, avoid inline comments unless complex logic

## API Considerations

### Future Extensibility
- **API Versioning:** Not initially required but structure allows for future API endpoints
- **Eloquent Resources:** Can be added if mobile app or external integrations needed
- **Authentication:** Sanctum available if API authentication required

### Data Export
- **Admin Reports:** Filament export functionality for leads, bookings, analytics
- **Format:** CSV/Excel export for importing into CRM or accounting systems

## Security

### Authentication & Authorization
- **Admin Access:** Laravel Fortify for Filament admin users
- **Password Requirements:** Strong password enforcement
- **Two-Factor:** Available via Fortify if required
- **Permissions:** Role-based access control via Filament Shield or custom policies

### Data Protection
- **Form Validation:** All user inputs validated via Form Request classes
- **CSRF Protection:** Laravel default CSRF middleware on all POST routes
- **SQL Injection Prevention:** Eloquent ORM with parameter binding
- **XSS Prevention:** Blade template escaping by default
- **File Uploads:** Validation of file types, sizes, and malware scanning if required

### Compliance
- **GDPR/POPIA:** User consent for contact forms, data retention policies, privacy policy page
- **Data Encryption:** HTTPS enforced, sensitive database fields encrypted if needed
- **Audit Logging:** Track admin actions in Filament if required for compliance
