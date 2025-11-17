# Task Breakdown: Filament Resources Implementation

## Overview
Total Resources: 17
Total Task Groups: 6
Estimated Timeline: 2-3 days
Estimated Time Per Resource: 30-60 minutes

## Task List

### Task Group 1: Content Management Resources
**Dependencies:** Phase 1 complete (models, migrations, seeders)
**Navigation Group:** Content Management
**Estimated Time:** 6-8 hours
**Resources:** 7

#### 1.1 ServiceCategoryResource - Service Category Management
**Reference:** spec.md lines 15-22

- [x] 1.1.1 Generate ServiceCategory resource
  - Run: `php artisan make:filament-resource ServiceCategory --generate`
  - Verify resource created in app/Filament/Resources/
- [x] 1.1.2 Configure form schema
  - Add name field (TextInput, required)
  - Add slug field (TextInput, auto-generated from name using Str::slug)
  - Add description field (Textarea)
  - Add icon field (FileUpload, image, max 2MB)
  - Add sort_order field (TextInput, numeric, default 0)
  - Add is_active toggle (Toggle, default true)
  - Add SEO section (Section with meta_title and meta_description)
- [x] 1.1.3 Configure table columns
  - Add TextColumn for name (sortable, searchable)
  - Add TextColumn for slug
  - Add IconColumn for is_active (boolean)
  - Add TextColumn for services count (counts relationship)
  - Add TextColumn for sort_order (sortable)
- [x] 1.1.4 Add filters
  - Add TernaryFilter for is_active
- [x] 1.1.5 Add bulk actions
  - Add BulkAction to activate selected
  - Add BulkAction to deactivate selected
  - Add DeleteBulkAction with soft delete support
- [x] 1.1.6 Configure navigation
  - Set navigation group: 'Content Management'
  - Set icon: 'heroicon-o-rectangle-stack'
  - Set sort order: 1
- [x] 1.1.7 Test in admin panel
  - Create new service category
  - Edit existing category
  - Test slug auto-generation
  - Test soft delete and restore
  - Test bulk actions

**Acceptance Criteria:**
- ServiceCategoryResource accessible in Content Management nav group
- All CRUD operations work correctly
- Services count badge displays relationship count
- Soft delete with restoration works
- Bulk activate/deactivate works

#### 1.2 ServiceResource - Individual Service Management
**Reference:** spec.md lines 24-30

- [x] 1.2.1 Generate Service resource
  - Run: `php artisan make:filament-resource Service --generate`
- [x] 1.2.2 Configure form schema
  - Add service_category_id select (relationship to ServiceCategory)
  - Add name field (TextInput, required)
  - Add slug field (TextInput, auto-generated)
  - Add short_description field (Textarea, maxLength 255)
  - Add full_description field (RichEditor)
  - Add icon field (FileUpload, image)
  - Add sort_order field (TextInput, numeric)
  - Add is_active toggle (Toggle)
  - Add is_featured toggle (Toggle)
  - Add SEO section (meta_title, meta_description)
- [x] 1.2.3 Configure table columns
  - Add TextColumn for name (sortable, searchable)
  - Add TextColumn for category name (from relationship)
  - Add IconColumn for is_featured
  - Add IconColumn for is_active
  - Add TextColumn for sort_order (sortable)
- [x] 1.2.4 Add filters
  - Add SelectFilter for service_category_id
  - Add TernaryFilter for is_featured
  - Add TernaryFilter for is_active
- [x] 1.2.5 Add custom duplicate action
  - Create custom Action to duplicate service
  - Clone all fields except slug
  - Append "Copy" to name
- [x] 1.2.6 Configure navigation
  - Set navigation group: 'Content Management'
  - Set icon: 'heroicon-o-wrench-screwdriver'
  - Set sort order: 2
- [x] 1.2.7 Test in admin panel
  - Create service with category relationship
  - Test duplicate action
  - Test filters
  - Verify category relationship displays

**Acceptance Criteria:**
- Service resource works with category relationship
- Duplicate action creates copy successfully
- Featured and active filters work
- Sort order functions correctly

#### 1.3 TeamMemberResource - Team Member Profiles
**Reference:** spec.md lines 32-37

- [x] 1.3.1 Generate TeamMember resource
  - Run: `php artisan make:filament-resource TeamMember --generate`
- [x] 1.3.2 Configure form schema
  - Add Grid layout (2 columns) for name, title, email, phone
  - Add photo field (FileUpload, image, max 2MB, circular preview)
  - Add bio field (RichEditor)
  - Add qualifications field (Textarea)
  - Add professional_registrations repeater with:
    - organization field (TextInput)
    - registration_number field (TextInput)
    - valid_until field (DatePicker)
  - Add sort_order field (TextInput, numeric)
  - Add is_active toggle
- [x] 1.3.3 Configure table columns
  - Add ImageColumn for photo (circular)
  - Add TextColumn for name (sortable, searchable)
  - Add TextColumn for title
  - Add TextColumn for registrations count (counted from JSON)
  - Add IconColumn for is_active
- [x] 1.3.4 Add filters
  - Add TernaryFilter for is_active
- [x] 1.3.5 Configure navigation
  - Set navigation group: 'Content Management'
  - Set icon: 'heroicon-o-user-group'
  - Set sort order: 3
- [x] 1.3.6 Test in admin panel
  - Create team member with photo
  - Test repeater for professional registrations
  - Verify circular photo preview
  - Test registrations count

**Acceptance Criteria:**
- Photo upload with circular preview works
- Professional registrations repeater functions
- Registrations count displays correctly
- Grid layout displays properly

#### 1.4 SectorResource - Industry Sector Categories
**Reference:** spec.md lines 39-44

- [x] 1.4.1 Generate Sector resource
  - Run: `php artisan make:filament-resource Sector --generate`
- [x] 1.4.2 Configure form schema
  - Add name field (TextInput, required)
  - Add slug field (TextInput, auto-generated)
  - Add description field (RichEditor)
  - Add icon field (FileUpload, image)
  - Add sort_order field (TextInput, numeric)
  - Add is_active toggle
  - Add SEO section
- [x] 1.4.3 Configure table columns
  - Add TextColumn for name (sortable, searchable)
  - Add TextColumn for projects count badge (relationship)
  - Add IconColumn for is_active
  - Add TextColumn for sort_order (sortable)
- [x] 1.4.4 Add filters
  - Add TernaryFilter for is_active
- [x] 1.4.5 Configure navigation
  - Set navigation group: 'Content Management'
  - Set icon: 'heroicon-o-building-office-2'
  - Set sort order: 4
- [x] 1.4.6 Test in admin panel
  - Create sector
  - Verify projects count badge
  - Test sorting

**Acceptance Criteria:**
- Sector resource fully functional
- Projects count displays relationship count
- SEO fields accessible

#### 1.5 ProjectResource - Project Portfolio Items
**Reference:** spec.md lines 46-51

- [x] 1.5.1 Generate Project resource
  - Run: `php artisan make:filament-resource Project --generate`
- [x] 1.5.2 Configure form schema
  - Add sector_id select (relationship)
  - Add title field (TextInput, required)
  - Add slug field (TextInput, auto-generated)
  - Add client_name field (TextInput)
  - Add location field (TextInput)
  - Add province select (options: Eastern Cape, Free State, Gauteng, KwaZulu-Natal, Limpopo, Mpumalanga, Northern Cape, North West, Western Cape)
  - Add short_description field (Textarea)
  - Add full_description field (RichEditor)
  - Add services_provided field (TagsInput)
  - Add outcomes field (Textarea)
  - Add featured_image field (FileUpload, image, max 5MB)
  - Add gallery_images field (FileUpload, multiple, image, max 10 images)
  - Add completion_date field (DatePicker)
  - Add is_featured toggle
  - Add is_active toggle
  - Add sort_order field (TextInput, numeric)
  - Add SEO section
- [x] 1.5.3 Configure table columns
  - Add ImageColumn for featured_image (thumbnail)
  - Add TextColumn for title (sortable, searchable)
  - Add TextColumn for sector name (relationship)
  - Add TextColumn for province
  - Add IconColumn for is_featured
  - Add IconColumn for is_active
- [x] 1.5.4 Add filters
  - Add SelectFilter for sector_id
  - Add SelectFilter for province
  - Add TernaryFilter for is_featured
  - Add TernaryFilter for is_active
  - Add DateFilter for completion_date
- [x] 1.5.5 Configure navigation
  - Set navigation group: 'Content Management'
  - Set icon: 'heroicon-o-briefcase'
  - Set sort order: 5
- [x] 1.5.6 Test in admin panel
  - Create project with images
  - Test gallery upload (multiple images)
  - Test province filter
  - Test tags input

**Acceptance Criteria:**
- Project resource handles complex form with images
- Gallery upload accepts multiple images
- Province select shows SA provinces
- All filters work correctly

#### 1.6 BlogPostResource - Blog Content Management
**Reference:** spec.md lines 53-58

- [x] 1.6.1 Generate BlogPost resource
  - Run: `php artisan make:filament-resource BlogPost --generate`
- [x] 1.6.2 Configure form schema
  - Add title field (TextInput, required)
  - Add slug field (TextInput, auto-generated)
  - Add excerpt field (Textarea)
  - Add content field (RichEditor)
  - Add featured_image field (FileUpload, image)
  - Add author field (TextInput)
  - Add published_at field (DateTimePicker)
  - Add is_published toggle
  - Add is_featured toggle
  - Add SEO section
- [x] 1.6.3 Configure table columns
  - Add ImageColumn for featured_image
  - Add TextColumn for title (sortable, searchable)
  - Add TextColumn for author
  - Add TextColumn for published_at (datetime, sortable)
  - Add IconColumn for is_published
  - Add IconColumn for is_featured
- [x] 1.6.4 Add filters
  - Add TernaryFilter for is_published
  - Add TernaryFilter for is_featured
  - Add DateFilter for published_at
- [x] 1.6.5 Configure navigation
  - Set navigation group: 'Content Management'
  - Set icon: 'heroicon-o-newspaper'
  - Set sort order: 6
- [x] 1.6.6 Test in admin panel
  - Create blog post
  - Test published_at datetime picker
  - Test published filter
  - Verify datetime display

**Acceptance Criteria:**
- Blog post resource fully functional
- DateTime fields work correctly
- Published filter shows correct posts

#### 1.7 ResourceResource - Downloadable Resources
**Reference:** spec.md lines 60-66

- [x] 1.7.1 Generate Resource resource (note: model is named Resource)
  - Run: `php artisan make:filament-resource Resource --generate`
- [x] 1.7.2 Configure form schema
  - Add title field (TextInput, required)
  - Add slug field (TextInput, auto-generated)
  - Add description field (Textarea)
  - Add file field (FileUpload, accept: .pdf,.docx,.xlsx)
  - Add category select (options: Company Profile, Brochure, Technical Guide, Case Study, Compliance Document)
  - Add requires_details toggle (for lead capture)
  - Add is_active toggle
  - Add sort_order field (TextInput, numeric)
- [x] 1.7.3 Configure table columns
  - Add TextColumn for title (sortable, searchable)
  - Add BadgeColumn for category
  - Add TextColumn for file type (extracted from file_path)
  - Add TextColumn for file size (formatted KB/MB)
  - Add TextColumn for download_count
  - Add IconColumn for requires_details
  - Add IconColumn for is_active
- [x] 1.7.4 Add filters
  - Add SelectFilter for category
  - Add TernaryFilter for requires_details
  - Add TernaryFilter for is_active
- [x] 1.7.5 Add custom download action
  - Create Action to download file
  - Track download count increment
- [x] 1.7.6 Configure navigation
  - Set navigation group: 'Content Management'
  - Set icon: 'heroicon-o-document-arrow-down'
  - Set sort order: 7
- [x] 1.7.7 Test in admin panel
  - Upload PDF file
  - Test download action
  - Verify file size formatting
  - Test category filter

**Acceptance Criteria:**
- File upload accepts PDF, DOCX, XLSX
- Download action works and increments count
- File size displays formatted
- Category filter functions

---

### Task Group 2: Training & Bookings Resources
**Dependencies:** Task Group 1 complete
**Navigation Group:** Training & Bookings
**Estimated Time:** 3-4 hours
**Resources:** 3

#### 2.1 TrainingCourseResource - Training Course Catalog
**Reference:** spec.md lines 68-75

- [x] 2.1.1 Generate TrainingCourse resource
  - Run: `php artisan make:filament-resource TrainingCourse --generate`
- [x] 2.1.2 Configure form schema
  - Add name field (TextInput, required)
  - Add slug field (TextInput, auto-generated)
  - Add short_description field (Textarea)
  - Add full_description field (RichEditor)
  - Add duration field (TextInput)
  - Add accreditation field (TextInput)
  - Add price field (TextInput, numeric, prefix: R, formatted as ZAR)
  - Add max_delegates field (TextInput, numeric)
  - Add course_outline field (RichEditor)
  - Add target_audience field (Textarea)
  - Add prerequisites field (Textarea)
  - Add thumbnail field (FileUpload, image)
  - Add is_active toggle
  - Add is_featured toggle
  - Add sort_order field (TextInput, numeric)
  - Add SEO section
- [x] 2.1.3 Configure table columns
  - Add ImageColumn for thumbnail
  - Add TextColumn for name (sortable, searchable)
  - Add TextColumn for duration
  - Add TextColumn for price (formatted as ZAR with R prefix)
  - Add TextColumn for upcoming schedules count badge
  - Add IconColumn for is_active
- [x] 2.1.4 Add filters
  - Add TernaryFilter for is_active
  - Add TernaryFilter for is_featured
- [x] 2.1.5 Add RelationManagers
  - Create SchedulesRelationManager for schedules relationship
  - Create BookingsRelationManager for bookings (through schedules)
- [x] 2.1.6 Configure navigation
  - Set navigation group: 'Training & Bookings'
  - Set icon: 'heroicon-o-academic-cap'
  - Set sort order: 1
- [x] 2.1.7 Test in admin panel
  - Create training course
  - Test ZAR currency formatting
  - Verify schedules relation manager
  - Test upcoming schedules count

**Acceptance Criteria:**
- Training course resource fully functional
- Price formatted as ZAR currency
- RelationManagers display correctly
- Upcoming schedules count accurate

#### 2.2 TrainingScheduleResource - Course Schedule Management
**Reference:** spec.md lines 77-83

- [x] 2.2.1 Generate TrainingSchedule resource
  - Run: `php artisan make:filament-resource TrainingSchedule --generate`
- [x] 2.2.2 Configure form schema
  - Add training_course_id select (relationship)
  - Add start_date field (DateTimePicker)
  - Add end_date field (DateTimePicker)
  - Add location field (TextInput)
  - Add is_online toggle
  - Add available_seats field (TextInput, numeric)
  - Add price_override field (TextInput, numeric, nullable, prefix: R)
  - Add notes field (Textarea)
  - Add is_active toggle
- [x] 2.2.3 Configure table columns
  - Add TextColumn for course name (relationship)
  - Add TextColumn for start_date (datetime, sortable)
  - Add TextColumn for end_date (datetime)
  - Add TextColumn for location
  - Add BadgeColumn for available_seats (colored: green if >5, yellow if 1-5, red if 0)
  - Add TextColumn for bookings count badge
  - Add IconColumn for is_active
- [x] 2.2.4 Add filters
  - Add SelectFilter for training_course_id
  - Add DateFilter for start_date
  - Add TernaryFilter for is_online
- [x] 2.2.5 Add custom duplicate action
  - Create Action to duplicate schedule
  - Allow user to set new start_date and end_date
  - Clone all other fields
- [x] 2.2.6 Configure navigation
  - Set navigation group: 'Training & Bookings'
  - Set icon: 'heroicon-o-calendar-days'
  - Set sort order: 2
- [x] 2.2.7 Test in admin panel
  - Create schedule with course relationship
  - Test available seats badge colors
  - Test duplicate action
  - Verify bookings count

**Acceptance Criteria:**
- Schedule resource works with course relationship
- Available seats badge shows correct colors
- Duplicate action allows date changes
- DateTime pickers function correctly

#### 2.3 TrainingBookingResource - Training Booking Submissions
**Reference:** spec.md lines 85-91

- [x] 2.3.1 Generate TrainingBooking resource
  - Run: `php artisan make:filament-resource TrainingBooking --generate`
- [x] 2.3.2 Configure form schema (most fields disabled/read-only)
  - Add training_course_id select (disabled)
  - Add training_schedule_id select (disabled)
  - Add name field (TextInput, disabled)
  - Add email field (TextInput, disabled)
  - Add phone field (TextInput, disabled)
  - Add company field (TextInput, disabled)
  - Add number_of_delegates field (TextInput, numeric, disabled)
  - Add delegate_names repeater (disabled)
  - Add special_requirements field (Textarea, disabled)
  - Add preferred_date field (DatePicker, disabled)
  - Add status select (editable: pending, confirmed, cancelled, completed)
  - Add admin_notes field (Textarea, editable)
- [x] 2.3.3 Configure table columns
  - Add TextColumn for name (searchable)
  - Add TextColumn for course name (relationship)
  - Add TextColumn for schedule start_date (datetime)
  - Add TextColumn for number_of_delegates
  - Add BadgeColumn for status (colored: blue=pending, green=confirmed, red=cancelled, gray=completed)
  - Add TextColumn for submitted_at (datetime, sortable)
- [x] 2.3.4 Add filters
  - Add SelectFilter for training_course_id
  - Add SelectFilter for status
  - Add DateFilter for submitted_at
- [x] 2.3.5 Add custom actions
  - Create Action to confirm booking (sets status to confirmed)
  - Create Action to cancel booking (sets status to cancelled)
  - Create Action to send email notification (placeholder)
- [x] 2.3.6 Configure navigation
  - Set navigation group: 'Training & Bookings'
  - Set icon: 'heroicon-o-clipboard-document-check'
  - Set sort order: 3
- [x] 2.3.7 Test in admin panel
  - View booking (all fields disabled except status and admin_notes)
  - Test status change actions
  - Test status badge colors
  - Verify relationships display

**Acceptance Criteria:**
- Booking resource is mostly read-only
- Status and admin_notes are editable
- Status badges show correct colors
- Custom actions work correctly

---

### Task Group 3: Equipment Rental Resources
**Dependencies:** Task Groups 1-2 complete
**Navigation Group:** Equipment Rental
**Estimated Time:** 3-4 hours
**Resources:** 3

#### 3.1 EquipmentCategoryResource - Equipment Category Management
**Reference:** spec.md lines 93-99

- [x] 3.1.1 Generate EquipmentCategory resource
  - Run: `php artisan make:filament-resource EquipmentCategory --generate`
- [x] 3.1.2 Configure form schema
  - Add name field (TextInput, required)
  - Add slug field (TextInput, auto-generated)
  - Add description field (Textarea)
  - Add icon field (FileUpload, image)
  - Add sort_order field (TextInput, numeric)
  - Add is_active toggle
- [x] 3.1.3 Configure table columns
  - Add TextColumn for name (sortable, searchable)
  - Add TextColumn for slug
  - Add IconColumn for is_active
  - Add TextColumn for equipment count badge (relationship)
  - Add TextColumn for sort_order (sortable)
- [x] 3.1.4 Add filters
  - Add TernaryFilter for is_active
- [x] 3.1.5 Add bulk actions
  - Add BulkAction to activate selected
  - Add BulkAction to deactivate selected
- [x] 3.1.6 Configure navigation
  - Set navigation group: 'Equipment Rental'
  - Set icon: 'heroicon-o-rectangle-stack'
  - Set sort order: 1
- [x] 3.1.7 Test in admin panel
  - Create equipment category
  - Test equipment count badge
  - Test bulk actions
  - Verify sorting

**Acceptance Criteria:**
- Equipment category resource fully functional
- Equipment count displays relationship
- Bulk activate/deactivate works

#### 3.2 EquipmentResource - Equipment Rental Catalog
**Reference:** spec.md lines 101-106

- [x] 3.2.1 Generate Equipment resource
  - Run: `php artisan make:filament-resource Equipment --generate`
- [x] 3.2.2 Configure form schema
  - Add equipment_category_id select (relationship)
  - Add name field (TextInput, required)
  - Add slug field (TextInput, auto-generated)
  - Add description field (RichEditor)
  - Add specifications field (Textarea)
  - Add typical_uses field (Textarea)
  - Add photo field (FileUpload, image)
  - Add gallery_images field (FileUpload, multiple, image)
  - Add daily_rate field (TextInput, numeric, prefix: R)
  - Add weekly_rate field (TextInput, numeric, prefix: R)
  - Add monthly_rate field (TextInput, numeric, prefix: R)
  - Add is_available toggle
  - Add is_featured toggle
  - Add sort_order field (TextInput, numeric)
- [x] 3.2.3 Configure table columns
  - Add ImageColumn for photo (thumbnail)
  - Add TextColumn for name (sortable, searchable)
  - Add TextColumn for category name (relationship)
  - Add TextColumn for daily_rate (formatted ZAR)
  - Add IconColumn for is_available
  - Add IconColumn for is_featured
- [x] 3.2.4 Add filters
  - Add SelectFilter for equipment_category_id
  - Add TernaryFilter for is_available
  - Add TernaryFilter for is_featured
- [x] 3.2.5 Configure navigation
  - Set navigation group: 'Equipment Rental'
  - Set icon: 'heroicon-o-wrench'
  - Set sort order: 2
- [x] 3.2.6 Test in admin panel
  - Create equipment with category
  - Test gallery upload
  - Verify rate formatting (ZAR)
  - Test availability filter

**Acceptance Criteria:**
- Equipment resource handles multiple rates
- Gallery upload works for multiple images
- Rates formatted as ZAR currency
- Category relationship displays correctly

#### 3.3 EquipmentRentalQuoteResource - Rental Quote Requests
**Reference:** spec.md lines 108-114

- [x] 3.3.1 Generate EquipmentRentalQuote resource
  - Run: `php artisan make:filament-resource EquipmentRentalQuote --generate`
- [x] 3.3.2 Configure form schema (most fields disabled)
  - Add equipment_id select (disabled, relationship)
  - Add name field (TextInput, disabled)
  - Add company field (TextInput, disabled)
  - Add email field (TextInput, disabled)
  - Add phone field (TextInput, disabled)
  - Add equipment_requested field (Textarea, disabled)
  - Add rental_duration field (TextInput, disabled)
  - Add start_date field (DatePicker, disabled)
  - Add location field (TextInput, disabled)
  - Add delivery_required toggle (disabled)
  - Add message field (Textarea, disabled)
  - Add status select (editable: pending, quoted, confirmed, completed, cancelled)
  - Add notes field (Textarea, editable)
- [x] 3.3.3 Configure table columns
  - Add TextColumn for name (searchable)
  - Add TextColumn for company
  - Add TextColumn for equipment name (relationship)
  - Add TextColumn for rental_duration
  - Add BadgeColumn for status (colored)
  - Add TextColumn for submitted_at (datetime, sortable)
- [x] 3.3.4 Add filters
  - Add SelectFilter for equipment_id
  - Add SelectFilter for status
  - Add TernaryFilter for delivery_required
  - Add DateFilter for submitted_at
- [x] 3.3.5 Add custom actions
  - Create Action to mark as quoted (sets status to quoted)
  - Create Action to mark as confirmed (sets status to confirmed)
  - Create Action to send quote email (placeholder)
- [x] 3.3.6 Configure navigation
  - Set navigation group: 'Equipment Rental'
  - Set icon: 'heroicon-o-document-text'
  - Set sort order: 3
- [x] 3.3.7 Test in admin panel
  - View quote request
  - Test status changes
  - Test filters
  - Verify relationship display

**Acceptance Criteria:**
- Quote resource is mostly read-only
- Status and admin_notes are editable
- Status badges show correct colors
- Equipment relationship displays

---

### Task Group 4: Marketing Resources
**Dependencies:** Task Groups 1-3 complete
**Navigation Group:** Marketing
**Estimated Time:** 2-3 hours
**Resources:** 2

#### 4.1 ClientLogoResource - Client Logo Management
**Reference:** spec.md lines 116-122

- [x] 4.1.1 Generate ClientLogo resource
  - Run: `php artisan make:filament-resource ClientLogo --generate`
- [x] 4.1.2 Configure form schema
  - Add name field (TextInput, required)
  - Add logo field (FileUpload, image, max 1MB)
  - Add website_url field (TextInput, url validation)
  - Add sort_order field (TextInput, numeric)
  - Add is_active toggle
- [x] 4.1.3 Configure table with grid layout
  - Set table layout to grid
  - Add ImageColumn for logo (large, card view)
  - Add TextColumn for name
  - Add TextColumn for website_url (url, opens in new tab)
  - Add IconColumn for is_active
- [x] 4.1.4 Add filters
  - Add TernaryFilter for is_active
- [x] 4.1.5 Configure navigation
  - Set navigation group: 'Marketing'
  - Set icon: 'heroicon-o-photo'
  - Set sort order: 1
- [x] 4.1.6 Test in admin panel
  - Create client logo
  - Verify grid layout displays logos nicely
  - Test website URL link
  - Test logo size limit (1MB)

**Acceptance Criteria:**
- Client logo resource uses grid layout
- Logos display in card view
- Website URL opens in new tab
- Logo file size limit enforced

#### 4.2 AccreditationResource - Accreditation Management
**Reference:** spec.md lines 124-131

- [x] 4.2.1 Generate Accreditation resource
  - Run: `php artisan make:filament-resource Accreditation --generate`
- [x] 4.2.2 Configure form schema
  - Add name field (TextInput, required)
  - Add acronym field (TextInput)
  - Add logo field (FileUpload, image)
  - Add description field (Textarea)
  - Add certificate_number field (TextInput)
  - Add valid_until field (DatePicker)
  - Add sort_order field (TextInput, numeric)
  - Add is_active toggle
- [x] 4.2.3 Configure table columns
  - Add ImageColumn for logo
  - Add TextColumn for name (sortable, searchable)
  - Add TextColumn for acronym
  - Add TextColumn for certificate_number
  - Add TextColumn for valid_until (date, colored red if expired)
  - Add IconColumn for is_active
- [x] 4.2.4 Add filters
  - Add TernaryFilter for is_active
  - Add DateFilter for valid_until
- [x] 4.2.5 Add expired accreditation indicator
  - Use color() method on valid_until column to show red if past today
- [x] 4.2.6 Configure navigation
  - Set navigation group: 'Marketing'
  - Set icon: 'heroicon-o-shield-check'
  - Set sort order: 2
- [x] 4.2.7 Test in admin panel
  - Create accreditation
  - Test expired date display (red color)
  - Test valid_until filter
  - Verify logo upload

**Acceptance Criteria:**
- Accreditation resource fully functional
- Expired dates show in red
- Date filter works correctly
- Logo displays properly

---

### Task Group 5: Inquiries Resources
**Dependencies:** Task Groups 1-4 complete
**Navigation Group:** Inquiries
**Estimated Time:** 2-3 hours
**Resources:** 2

#### 5.1 ContactSubmissionResource - Contact Form Submissions
**Reference:** spec.md lines 133-140

- [x] 5.1.1 Generate ContactSubmission resource
  - Run: `php artisan make:filament-resource ContactSubmission --generate`
- [x] 5.1.2 Configure form schema (most fields disabled)
  - Add type select (disabled: general_inquiry, quote_request, training_inquiry, equipment_rental)
  - Add name field (TextInput, disabled)
  - Add email field (TextInput, disabled)
  - Add phone field (TextInput, disabled)
  - Add company field (TextInput, disabled)
  - Add subject field (TextInput, disabled)
  - Add message field (Textarea, disabled)
  - Add status select (editable: new, contacted, converted, closed)
  - Add admin_notes field (Textarea, editable)
- [x] 5.1.3 Configure table columns
  - Add TextColumn for name (searchable)
  - Add TextColumn for email
  - Add BadgeColumn for type
  - Add TextColumn for subject
  - Add BadgeColumn for status (colored)
  - Add TextColumn for submitted_at (datetime, sortable)
- [x] 5.1.4 Add filters
  - Add SelectFilter for type
  - Add SelectFilter for status
  - Add DateFilter for submitted_at
- [x] 5.1.5 Add custom actions
  - Create Action to mark as contacted (sets status)
  - Create Action to send email reply (placeholder)
- [x] 5.1.6 Add view-only modal
  - Configure resource to show view modal for quick review
- [x] 5.1.7 Configure navigation
  - Set navigation group: 'Inquiries'
  - Set icon: 'heroicon-o-envelope'
  - Set sort order: 1
- [x] 5.1.8 Test in admin panel
  - View contact submission
  - Test status changes
  - Test view modal
  - Test filters

**Acceptance Criteria:**
- Contact submission resource is mostly read-only
- Status and admin_notes are editable
- View modal displays all information
- Custom actions work correctly

#### 5.2 LeadCaptureResource - Marketing Lead Captures
**Reference:** spec.md lines 142-148

- [x] 5.2.1 Generate LeadCapture resource
  - Run: `php artisan make:filament-resource LeadCapture --generate`
- [x] 5.2.2 Configure form schema (all fields read-only)
  - Add name field (TextInput, disabled)
  - Add email field (TextInput, disabled)
  - Add phone field (TextInput, disabled)
  - Add company field (TextInput, disabled)
  - Add province field (TextInput, disabled)
  - Add source field (TextInput, disabled: resource_download, newsletter, contact_form)
  - Add resource_id relationship (nullable, disabled)
- [x] 5.2.3 Configure table columns
  - Add TextColumn for name (searchable)
  - Add TextColumn for email
  - Add TextColumn for company
  - Add BadgeColumn for source
  - Add TextColumn for captured_at (datetime, sortable)
- [x] 5.2.4 Add filters
  - Add SelectFilter for source
  - Add SelectFilter for province
  - Add DateFilter for captured_at
- [x] 5.2.5 Add bulk export to CSV action
  - Create BulkAction to export selected leads to CSV
  - Include all lead fields in export
- [x] 5.2.6 Configure navigation
  - Set navigation group: 'Inquiries'
  - Set icon: 'heroicon-o-user-plus'
  - Set sort order: 2
- [x] 5.2.7 Test in admin panel
  - View lead capture (all read-only)
  - Test filters
  - Test CSV export
  - Verify source badges

**Acceptance Criteria:**
- Lead capture resource is completely read-only
- CSV export includes all selected leads
- Source and province filters work
- Resource relationship displays when present

---

### Task Group 6: Testing & Verification
**Dependencies:** Task Groups 1-5 complete
**Estimated Time:** 2-3 hours

#### 6.1 Admin Panel Testing
- [ ] 6.1.1 Test all Content Management resources
  - Navigate to each resource in Content Management group
  - Create at least one record in each resource
  - Test search functionality
  - Test filters
  - Test sorting
- [ ] 6.1.2 Test all Training & Bookings resources
  - Create training course
  - Create training schedule linked to course
  - View training booking
  - Test relationship managers
  - Test custom actions
- [ ] 6.1.3 Test all Equipment Rental resources
  - Create equipment category
  - Create equipment linked to category
  - View equipment rental quote
  - Test status changes
- [ ] 6.1.4 Test all Marketing resources
  - Upload client logos
  - Verify grid layout
  - Create accreditation
  - Test expired date display
- [ ] 6.1.5 Test all Inquiries resources
  - View contact submissions
  - Test status changes
  - View lead captures
  - Test CSV export

#### 6.2 Relationship Testing
- [ ] 6.2.1 Test ServiceCategory → Service relationship
  - Verify services count badge
  - Test filtering services by category
- [ ] 6.2.2 Test Sector → Project relationship
  - Verify projects count badge
  - Test filtering projects by sector
- [ ] 6.2.3 Test TrainingCourse → TrainingSchedule relationship
  - Verify schedules relation manager
  - Verify upcoming schedules count
- [ ] 6.2.4 Test TrainingSchedule → TrainingBooking relationship
  - Verify bookings count badge
  - Test bookings relation manager
- [ ] 6.2.5 Test EquipmentCategory → Equipment relationship
  - Verify equipment count badge
  - Test filtering equipment by category
- [ ] 6.2.6 Test Equipment → EquipmentRentalQuote relationship
  - Verify equipment name displays in quotes
- [ ] 6.2.7 Test Resource → LeadCapture relationship
  - Verify resource relationship displays when present

#### 6.3 Code Quality
- [ ] 6.3.1 Run Laravel Pint
  - Execute: `vendor/bin/pint`
  - Fix any formatting issues
- [ ] 6.3.2 Run existing tests
  - Execute: `php artisan test`
  - Verify all existing tests pass
  - Address any failures
- [ ] 6.3.3 Write 2-8 focused tests for critical resource operations
  - Test ServiceResource CRUD operations
  - Test TrainingCourseResource with relationships
  - Test resource status changes (ContactSubmission, TrainingBooking)
  - Test file uploads (ClientLogo, Equipment)
  - Test custom actions (duplicate service, confirm booking)
  - Limit to 2-8 strategic tests maximum
- [ ] 6.3.4 Run feature tests
  - Execute: `php artisan test --filter=[test-name]`
  - Verify new tests pass

#### 6.4 Navigation & UX Verification
- [ ] 6.4.1 Verify navigation groups
  - Confirm Content Management group shows 7 resources
  - Confirm Training & Bookings group shows 3 resources
  - Confirm Equipment Rental group shows 3 resources
  - Confirm Marketing group shows 2 resources
  - Confirm Inquiries group shows 2 resources
- [ ] 6.4.2 Verify navigation icons and sort order
  - Check all icons display correctly
  - Verify resources appear in specified sort order
- [ ] 6.4.3 Test search across all resources
  - Test global search finds records
  - Test resource-specific search
- [ ] 6.4.4 Test mobile responsiveness
  - View admin panel on mobile viewport
  - Verify forms work on mobile
  - Verify tables work on mobile

#### 6.5 Documentation
- [ ] 6.5.1 Document any customizations
  - Note any deviations from spec
  - Document custom actions created
  - Document any special configurations
- [ ] 6.5.2 Create admin user guide notes
  - Document key features for KMG staff
  - Note any important workflows
  - Document status meanings and workflows

**Acceptance Criteria:**
- All 17 resources accessible and functional
- All relationships work correctly
- Laravel Pint passes with no errors
- All existing tests pass
- 2-8 new focused tests pass
- Navigation groups organized correctly
- Mobile responsiveness verified
- Basic documentation complete

---

## Execution Order

1. **Task Group 1: Content Management Resources** (6-8 hours)
   - ServiceCategory → Service → TeamMember → Sector → Project → BlogPost → Resource
   - Complete all 7 resources before moving to next group

2. **Task Group 2: Training & Bookings Resources** (3-4 hours)
   - TrainingCourse → TrainingSchedule → TrainingBooking
   - Test relationships between course, schedule, booking

3. **Task Group 3: Equipment Rental Resources** (3-4 hours)
   - EquipmentCategory → Equipment → EquipmentRentalQuote
   - Test category relationships and quote workflow

4. **Task Group 4: Marketing Resources** (2-3 hours)
   - ClientLogo → Accreditation
   - Verify grid layout and expired date indicators

5. **Task Group 5: Inquiries Resources** (2-3 hours)
   - ContactSubmission → LeadCapture
   - Test view-only modes and CSV export

6. **Task Group 6: Testing & Verification** (2-3 hours)
   - Run all tests, verify all relationships
   - Final code quality checks and documentation

**Total Estimated Time: 18-25 hours (2-3 working days)**

## Notes

- Each resource follows a consistent pattern: generate, configure form, configure table, add filters/actions, configure navigation, test
- Use `--generate` flag with make:filament-resource to auto-generate basic CRUD
- Reference model fillable arrays and relationships when configuring forms
- Test each resource immediately after creation before moving to next
- Use Filament's built-in components (relationship(), RichEditor, FileUpload, etc.)
- Follow existing Filament 3 conventions from Laravel Boost guidelines
- Soft delete support already configured in models where needed
- All relationships already defined in Phase 1 models
