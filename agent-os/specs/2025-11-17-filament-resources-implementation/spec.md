# Specification: Filament Resources Implementation

## Goal
Create 17 comprehensive Filament resources that provide KMG Environmental Solutions staff with complete content management capabilities for services, training, equipment rental, marketing materials, and customer inquiries.

## User Stories
- As a KMG admin, I want to manage service categories and services with SEO fields so I can control website content
- As a KMG admin, I want to manage team members with photos and professional registrations so the team page stays current
- As a KMG admin, I want to manage training courses, schedules, and bookings so I can coordinate training operations
- As a KMG admin, I want to manage equipment rental items and quote requests so I can respond to rental inquiries
- As a KMG admin, I want to view contact submissions and lead captures so I can follow up with potential clients

## Specific Requirements

**ServiceCategoryResource - Service Category Management**
- Form with name, slug (auto-generated), description, icon upload, sort order, is_active toggle, and SEO section (meta_title, meta_description)
- Table showing name, slug, active status icon, services count badge (from relationship), and sort order
- TernaryFilter for active/inactive status
- Bulk actions to activate/deactivate and delete selected categories
- Soft delete support with restoration capability
- Navigation group: Content Management
- Icon: heroicon-o-rectangle-stack

**ServiceResource - Individual Service Management**
- Form with service_category_id select (relationship), name, slug, short_description textarea, full_description rich editor, icon upload, sort order, is_active toggle, is_featured toggle, and SEO section
- Table showing name, category name (from relationship), featured icon, active icon, sort order
- SelectFilter for service category, TernaryFilter for featured and active status
- Custom duplicate action to clone services
- Navigation group: Content Management, sort order: 2
- Icon: heroicon-o-wrench-screwdriver

**TeamMemberResource - Team Member Profiles**
- Form with name, title, email, phone in grid layout, photo upload (image, max 2MB, circular preview), bio rich editor, qualifications textarea, professional_registrations repeater (organization, registration_number, valid_until date), sort_order, is_active toggle
- Table showing circular photo, name, title, registrations count, active icon
- TernaryFilter for active status
- Navigation group: Content Management, sort order: 3
- Icon: heroicon-o-user-group

**SectorResource - Industry Sector Categories**
- Form with name, slug, description rich editor, icon upload, sort_order, is_active toggle, SEO section
- Table showing name, projects count badge, active icon, sort order
- TernaryFilter for active status
- Navigation group: Content Management, sort order: 4
- Icon: heroicon-o-building-office-2

**ProjectResource - Project Portfolio Items**
- Form with sector_id select, title, slug, client_name, location, province select (SA provinces: Eastern Cape, Free State, Gauteng, KwaZulu-Natal, Limpopo, Mpumalanga, Northern Cape, North West, Western Cape), short_description, full_description rich editor, services_provided tags input, outcomes textarea, featured_image upload (max 5MB), gallery_images upload (multiple, max 10), completion_date picker, is_featured toggle, is_active toggle, sort_order, SEO section
- Table showing featured image thumbnail, title, sector name, province, featured icon, active icon
- SelectFilter for sector and province, TernaryFilter for featured and active, DateFilter for completion date
- Navigation group: Content Management, sort order: 5
- Icon: heroicon-o-briefcase

**BlogPostResource - Blog Content Management**
- Form with title, slug, excerpt textarea, content rich editor, featured_image upload, author text, published_at datetime picker, is_published toggle, is_featured toggle, SEO section
- Table showing featured image, title, author, published_at datetime, published icon, featured icon
- TernaryFilter for published and featured, DateFilter for published_at
- Navigation group: Content Management, sort order: 6
- Icon: heroicon-o-newspaper

**ResourceResource - Downloadable Resources**
- Form with title, slug, description textarea, file upload (PDF, DOCX, XLSX accepted), category select (Company Profile, Brochure, Technical Guide, Case Study, Compliance Document), requires_details toggle (for lead capture), is_active toggle, sort_order
- Table showing title, category, file type badge, file size (formatted), download count, requires details icon, active icon
- SelectFilter for category, TernaryFilter for requires_details and active
- Custom download file action
- Navigation group: Content Management, sort order: 7
- Icon: heroicon-o-document-arrow-down

**TrainingCourseResource - Training Course Catalog**
- Form with name, slug, short_description, full_description rich editor, duration text, accreditation text, price number input (formatted as currency), max_delegates number, course_outline rich editor, target_audience textarea, prerequisites textarea, thumbnail upload, is_active toggle, is_featured toggle, sort_order, SEO section
- Table showing thumbnail, name, duration, price (formatted as ZAR currency), upcoming schedules count badge, active icon
- TernaryFilter for active and featured
- RelationManager for schedules relationship
- RelationManager for bookings relationship (through schedules)
- Navigation group: Training & Bookings
- Icon: heroicon-o-academic-cap

**TrainingScheduleResource - Course Schedule Management**
- Form with training_course_id select (relationship), start_date datetime picker, end_date datetime picker, location text, is_online toggle, available_seats number, price_override number (optional, nullable), notes textarea, is_active toggle
- Table showing course name (relationship), start_date datetime, end_date datetime, location, available seats badge (colored: green if >5, yellow if 1-5, red if 0), bookings count badge, active icon
- SelectFilter for course, DateFilter for start_date, TernaryFilter for is_online
- Custom action to duplicate schedule with new dates
- Navigation group: Training & Bookings, sort order: 2
- Icon: heroicon-o-calendar-days

**TrainingBookingResource - Training Booking Submissions**
- Form with training_course_id select (disabled), training_schedule_id select (disabled), name text (disabled), email text (disabled), phone text (disabled), company text (disabled), number_of_delegates number (disabled), delegate_names repeater (disabled), special_requirements textarea (disabled), preferred_date date (disabled), status select (pending, confirmed, cancelled, completed - editable), admin_notes textarea (editable)
- Table showing name, course name, schedule start datetime, number of delegates, status badge (colored: blue=pending, green=confirmed, red=cancelled, gray=completed), submitted_at datetime
- SelectFilter for course and status, DateFilter for submitted_at
- Custom actions: confirm booking (sets status to confirmed), cancel booking (sets status to cancelled), send email notification
- Navigation group: Training & Bookings, sort order: 3
- Icon: heroicon-o-clipboard-document-check

**EquipmentCategoryResource - Equipment Category Management**
- Form with name, slug, description, icon upload, sort_order, is_active toggle, SEO section
- Table showing name, slug, active icon, equipment count badge, sort order
- TernaryFilter for active status
- Bulk actions for activate/deactivate
- Navigation group: Equipment Rental
- Icon: heroicon-o-rectangle-stack

**EquipmentResource - Equipment Rental Catalog**
- Form with equipment_category_id select, name, slug, description rich editor, specifications textarea, typical_uses textarea, photo upload, gallery_images upload (multiple), daily_rate number, weekly_rate number, monthly_rate number (all formatted as currency), is_available toggle, is_featured toggle, sort_order
- Table showing photo thumbnail, name, category name, daily_rate (formatted ZAR), available icon, featured icon
- SelectFilter for category, TernaryFilter for available and featured
- Navigation group: Equipment Rental, sort order: 2
- Icon: heroicon-o-wrench

**EquipmentRentalQuoteResource - Rental Quote Requests**
- Form with equipment_id select (disabled), name text (disabled), company text (disabled), email text (disabled), phone text (disabled), equipment_requested tags (disabled), rental_duration text (disabled), start_date date (disabled), location text (disabled), delivery_required toggle (disabled), message textarea (disabled), status select (pending, quoted, accepted, declined - editable), admin_notes textarea (editable)
- Table showing name, company, equipment name, duration, status badge (colored), submitted_at datetime
- SelectFilter for equipment and status, TernaryFilter for delivery_required, DateFilter for submitted_at
- Custom action to send quote email
- Navigation group: Equipment Rental, sort order: 3
- Icon: heroicon-o-document-text

**ClientLogoResource - Client Logo Management**
- Form with name, logo upload (image, max 1MB), website URL, sort_order, is_active toggle
- Table in grid layout showing logo image (card view), name, website link, active icon
- TernaryFilter for active status
- Table uses grid layout for visual logo display
- Navigation group: Marketing
- Icon: heroicon-o-photo

**AccreditationResource - Accreditation Management**
- Form with name, acronym, logo upload, description textarea, certificate_number, valid_until date, sort_order, is_active toggle
- Table showing logo, name, acronym, certificate_number, valid_until date (colored red if expired), active icon
- TernaryFilter for active status
- DateFilter for valid_until
- Visual indicator for expired accreditations
- Navigation group: Marketing, sort order: 2
- Icon: heroicon-o-shield-check

**ContactSubmissionResource - Contact Form Submissions**
- Form with type select (disabled: general_inquiry, quote_request, training_inquiry, equipment_rental), name text (disabled), email text (disabled), phone text (disabled), company text (disabled), subject text (disabled), message textarea (disabled), status select (new, contacted, converted, closed - editable), admin_notes textarea (editable)
- Table showing name, email, type badge, subject, status badge (colored), submitted_at datetime
- SelectFilter for type and status, DateFilter for submitted_at
- Custom actions: mark as contacted, send email reply
- View-only modal for quick review
- Navigation group: Inquiries
- Icon: heroicon-o-envelope

**LeadCaptureResource - Marketing Lead Captures**
- Form with name text (read-only), email text (read-only), phone text (read-only), company text (read-only), province text (read-only), source text (read-only: resource_download, newsletter, contact_form), resource_id relationship (read-only, nullable)
- Table showing name, email, company, source badge, captured_at datetime
- SelectFilter for source and province, DateFilter for captured_at
- Bulk export to CSV action
- Navigation group: Inquiries, sort order: 2
- Icon: heroicon-o-user-plus

**Navigation Groups Configuration**
- Content Management (services, team, projects, blog, resources)
- Training & Bookings (courses, schedules, bookings)
- Equipment Rental (categories, equipment, quotes)
- Marketing (client logos, accreditations)
- Inquiries (contact submissions, lead captures)

**Filament Panel Configuration**
- Panel already configured with KMG branding (green primary color #1e7e34)
- Logo and dark mode logo already set
- Font set to Inter
- Navigation groups already defined in AdminPanelProvider
- Auto-discovery enabled for resources, pages, and widgets

## Existing Code to Leverage

**All 17 Models Created in Phase 1**
- Located in /Users/jacquesvanwyk/Developer/motionstack/kmgenviro/app/Models/
- All models have proper fillable arrays, casts, relationships, and soft deletes where needed
- Use these models as the foundation for each Filament resource
- Reference model fillable arrays for form field names
- Reference model casts for proper field types

**AdminPanelProvider Configuration (lines 39-45)**
- Navigation groups already defined: Content Management, Training & Bookings, Equipment Rental, Marketing, Inquiries
- Use these exact group names when assigning resources to navigation groups
- Primary brand color already set to #1e7e34 (KMG green)

**Relationship Patterns from Models**
- ServiceCategory hasMany services - use for services count badge and relationship manager
- Service belongsTo serviceCategory - use for category select and display
- Project belongsTo sector - use for sector select filter
- TrainingSchedule belongsTo trainingCourse - use for course relationship display
- TrainingBooking belongsTo trainingSchedule and trainingCourse - use for relationship managers
- Equipment belongsTo equipmentCategory - use for category filter and display
- LeadCapture belongsTo resource (nullable) - use for resource relationship display

**Model Fillable Arrays for Form Fields**
- Reference ServiceCategory model (lines 19-28) for standard category resource pattern: name, slug, description, icon, sort_order, is_active, meta fields
- Reference Service model (lines 19-31) for service resource with category relationship and featured flag
- Follow this pattern across all models to ensure form fields match model expectations

**Existing Filament Standards**
- Use Filament 3.x components and patterns
- Forms use Forms\Components namespace
- Tables use Tables\Columns namespace
- Follow fluent method chaining for schema definitions
- Use relationship() method for select fields with relationships
- Use RichEditor for long-form content fields

## Out of Scope
- Public-facing frontend pages and components (Phase 3)
- API endpoints for mobile or external integrations (Phase 4)
- WordPress content migration scripts (Phase 5)
- Email notification templates (separate task)
- User roles and permissions beyond basic authentication (future enhancement)
- Payment processing for training bookings (future enhancement)
- Automated reminder emails for expired accreditations (future enhancement)
- Dashboard widgets for stats and recent activity (separate task after resources)
- Custom validation rules beyond standard Filament validation (implement only if standard validation insufficient)
