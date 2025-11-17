# Filament Admin Panel Structure

## Overview

This document outlines the Filament admin panel structure for KMG Environmental Solutions, giving the client full control over content management.

## Navigation Structure

```
Dashboard
├── Content Management
│   ├── Services
│   │   ├── Service Categories
│   │   └── Services
│   ├── Team Members
│   ├── Projects
│   │   ├── Sectors
│   │   └── Projects
│   ├── Blog Posts
│   └── Resources
│
├── Training & Bookings
│   ├── Training Courses
│   ├── Training Schedules
│   └── Training Bookings
│
├── Equipment Rental
│   ├── Equipment Categories
│   ├── Equipment
│   └── Rental Quotes
│
├── Marketing
│   ├── Client Logos
│   └── Accreditations
│
├── Inquiries
│   ├── Contact Submissions
│   └── Lead Captures
│
└── Settings
    └── Users
```

## Filament Resources to Create

### 1. ServiceCategoryResource

**Location**: `app/Filament/Resources/ServiceCategoryResource.php`

**Form Fields**:
- Text: Name
- Text: Slug (auto-generated from name)
- Textarea: Description
- FileUpload: Icon
- TextInput (number): Sort Order
- Toggle: Is Active
- Section: SEO
  - Text: Meta Title
  - Textarea: Meta Description

**Table Columns**:
- Text: Name
- Text: Slug
- IconColumn: Is Active
- Badge: Services Count (relationship count)
- Text: Sort Order

**Filters**:
- TernaryFilter: Active/Inactive

**Actions**:
- Edit
- Delete (with soft delete)
- View (modal)

**Bulk Actions**:
- Activate/Deactivate
- Delete selected

---

### 2. ServiceResource

**Location**: `app/Filament/Resources/ServiceResource.php`

**Form Fields**:
- Select: Service Category
- Text: Name
- Text: Slug (auto-generated)
- Textarea: Short Description
- RichEditor: Full Description
- FileUpload: Icon
- TextInput (number): Sort Order
- Toggle: Is Active
- Toggle: Is Featured
- Section: SEO
  - Text: Meta Title
  - Textarea: Meta Description

**Table Columns**:
- Text: Name
- Text: Category Name (relationship)
- IconColumn: Is Featured
- IconColumn: Is Active
- Text: Sort Order

**Filters**:
- SelectFilter: Service Category
- TernaryFilter: Featured
- TernaryFilter: Active

**Actions**:
- Edit
- Delete
- Duplicate
- View on Website (external link)

---

### 3. TeamMemberResource

**Location**: `app/Filament/Resources/TeamMemberResource.php`

**Form Fields**:
- Grid (2 columns):
  - Text: Name
  - Text: Title
- Grid (2 columns):
  - Text: Email
  - Text: Phone
- FileUpload: Photo (image, max 2MB)
- RichEditor: Bio
- Textarea: Qualifications
- Repeater: Professional Registrations
  - Text: Organization (e.g., SACNASP, EAPASA)
  - Text: Registration Number
  - Date: Valid Until
- TextInput (number): Sort Order
- Toggle: Is Active

**Table Columns**:
- ImageColumn: Photo (circular)
- Text: Name
- Text: Title
- TextColumn: Registrations Count
- IconColumn: Is Active

**Filters**:
- TernaryFilter: Active

---

### 4. SectorResource

**Location**: `app/Filament/Resources/SectorResource.php`

**Form Fields**:
- Text: Name
- Text: Slug
- RichEditor: Description
- FileUpload: Icon
- TextInput (number): Sort Order
- Toggle: Is Active
- Section: SEO
  - Text: Meta Title
  - Textarea: Meta Description

**Table Columns**:
- Text: Name
- Badge: Projects Count
- IconColumn: Is Active
- Text: Sort Order

---

### 5. ProjectResource

**Location**: `app/Filament/Resources/ProjectResource.php`

**Form Fields**:
- Select: Sector
- Text: Title
- Text: Slug
- Grid (2 columns):
  - Text: Client Name
  - Text: Location
- Select: Province (dropdown with SA provinces)
- Textarea: Short Description
- RichEditor: Full Description
- TagsInput: Services Provided
- Textarea: Outcomes
- FileUpload: Featured Image (image, max 5MB)
- FileUpload: Gallery Images (multiple, max 10 images)
- DatePicker: Completion Date
- Toggle: Is Featured
- Toggle: Is Active
- TextInput (number): Sort Order
- Section: SEO
  - Text: Meta Title
  - Textarea: Meta Description

**Table Columns**:
- ImageColumn: Featured Image
- Text: Title
- Text: Sector
- Text: Province
- IconColumn: Is Featured
- IconColumn: Is Active

**Filters**:
- SelectFilter: Sector
- SelectFilter: Province
- TernaryFilter: Featured
- TernaryFilter: Active
- DateFilter: Completion Date

---

### 6. TrainingCourseResource

**Location**: `app/Filament/Resources/TrainingCourseResource.php`

**Form Fields**:
- Text: Name
- Text: Slug
- Textarea: Short Description
- RichEditor: Full Description
- Grid (3 columns):
  - Text: Duration
  - Text: Accreditation
  - TextInput (number): Price
- TextInput (number): Max Delegates
- RichEditor: Course Outline
- Textarea: Target Audience
- Textarea: Prerequisites
- FileUpload: Thumbnail
- Toggle: Is Active
- Toggle: Is Featured
- TextInput (number): Sort Order
- Section: SEO
  - Text: Meta Title
  - Textarea: Meta Description

**Table Columns**:
- ImageColumn: Thumbnail
- Text: Name
- Text: Duration
- Money: Price (formatted)
- Badge: Upcoming Schedules Count
- IconColumn: Is Active

**Actions**:
- Edit
- Manage Schedules (custom action)

**Relation Managers**:
- SchedulesRelationManager
- BookingsRelationManager

---

### 7. TrainingScheduleResource

**Location**: `app/Filament/Resources/TrainingScheduleResource.php`

**Form Fields**:
- Select: Training Course
- Grid (2 columns):
  - DateTimePicker: Start Date
  - DateTimePicker: End Date
- Grid (2 columns):
  - Text: Location
  - Toggle: Is Online
- TextInput (number): Available Seats
- TextInput (number): Price Override (optional)
- Textarea: Notes
- Toggle: Is Active

**Table Columns**:
- Text: Course Name
- DateTime: Start Date
- DateTime: End Date
- Text: Location
- Badge: Available Seats
- Badge: Bookings Count
- IconColumn: Is Active

**Filters**:
- SelectFilter: Course
- DateFilter: Start Date
- TernaryFilter: Online/In-person

---

### 8. TrainingBookingResource

**Location**: `app/Filament/Resources/TrainingBookingResource.php`

**Form Fields** (mostly read-only, admin can update status):
- Select: Training Course (disabled)
- Select: Training Schedule (disabled)
- Grid (2 columns):
  - Text: Name (disabled)
  - Text: Email (disabled)
- Grid (2 columns):
  - Text: Phone (disabled)
  - Text: Company (disabled)
- TextInput (number): Number of Delegates (disabled)
- Repeater: Delegate Names (disabled)
- Textarea: Special Requirements (disabled)
- DatePicker: Preferred Date (disabled)
- Select: Status (editable) - pending, confirmed, cancelled, completed
- Textarea: Admin Notes (editable)

**Table Columns**:
- Text: Name
- Text: Course Name
- DateTime: Schedule Start
- Text: Number of Delegates
- Badge: Status (colored based on status)
- DateTime: Submitted At

**Filters**:
- SelectFilter: Course
- SelectFilter: Status
- DateFilter: Submitted At

**Actions**:
- View (modal)
- Confirm Booking (custom action)
- Cancel Booking (custom action)
- Send Email (custom action)

---

### 9. EquipmentCategoryResource

**Location**: `app/Filament/Resources/EquipmentCategoryResource.php`

Similar structure to ServiceCategoryResource.

---

### 10. EquipmentResource

**Location**: `app/Filament/Resources/EquipmentResource.php`

**Form Fields**:
- Select: Equipment Category
- Text: Name
- Text: Slug
- RichEditor: Description
- Textarea: Specifications
- Textarea: Typical Uses
- FileUpload: Photo
- FileUpload: Gallery Images (multiple)
- Grid (3 columns):
  - TextInput (number): Daily Rate
  - TextInput (number): Weekly Rate
  - TextInput (number): Monthly Rate
- Toggle: Is Available
- Toggle: Is Featured
- TextInput (number): Sort Order

**Table Columns**:
- ImageColumn: Photo
- Text: Name
- Text: Category
- Money: Daily Rate
- IconColumn: Is Available
- IconColumn: Is Featured

**Filters**:
- SelectFilter: Category
- TernaryFilter: Available
- TernaryFilter: Featured

---

### 11. EquipmentRentalQuoteResource

**Location**: `app/Filament/Resources/EquipmentRentalQuoteResource.php`

**Form Fields** (mostly read-only):
- Select: Equipment (disabled)
- Grid (2 columns):
  - Text: Name (disabled)
  - Text: Company (disabled)
- Grid (2 columns):
  - Text: Email (disabled)
  - Text: Phone (disabled)
- TagsInput: Equipment Requested (disabled)
- Grid (2 columns):
  - Text: Rental Duration (disabled)
  - DatePicker: Start Date (disabled)
- Text: Location (disabled)
- Toggle: Delivery Required (disabled)
- Textarea: Message (disabled)
- Select: Status (editable)
- Textarea: Admin Notes (editable)

**Table Columns**:
- Text: Name
- Text: Company
- Text: Equipment
- Text: Duration
- Badge: Status
- DateTime: Submitted At

**Filters**:
- SelectFilter: Equipment
- SelectFilter: Status
- TernaryFilter: Delivery Required
- DateFilter: Submitted At

---

### 12. BlogPostResource

**Location**: `app/Filament/Resources/BlogPostResource.php`

**Form Fields**:
- Text: Title
- Text: Slug
- Textarea: Excerpt
- RichEditor: Content
- FileUpload: Featured Image
- Text: Author
- DateTimePicker: Published At
- Toggle: Is Published
- Toggle: Is Featured
- Section: SEO
  - Text: Meta Title
  - Textarea: Meta Description

**Table Columns**:
- ImageColumn: Featured Image
- Text: Title
- Text: Author
- DateTime: Published At
- IconColumn: Is Published
- IconColumn: Is Featured

**Filters**:
- TernaryFilter: Published
- TernaryFilter: Featured
- DateFilter: Published At

---

### 13. ResourceResource

**Location**: `app/Filament/Resources/ResourceResource.php`

**Form Fields**:
- Text: Title
- Text: Slug
- Textarea: Description
- FileUpload: File (PDF, DOCX, etc.)
- Select: Category (Company Profile, Brochure, Guide, etc.)
- Toggle: Requires Details (lead capture)
- Toggle: Is Active
- TextInput (number): Sort Order

**Table Columns**:
- Text: Title
- Text: Category
- Text: File Type
- Text: File Size (formatted)
- Text: Download Count
- IconColumn: Requires Details
- IconColumn: Is Active

**Actions**:
- Download File

---

### 14. ClientLogoResource

**Location**: `app/Filament/Resources/ClientLogoResource.php`

**Form Fields**:
- Text: Name
- FileUpload: Logo (image)
- Text: Website (URL)
- TextInput (number): Sort Order
- Toggle: Is Active

**Table Columns**:
- ImageColumn: Logo
- Text: Name
- Text: Website
- IconColumn: Is Active

**Table Layout**: Grid view (showing logos as cards)

---

### 15. AccreditationResource

**Location**: `app/Filament/Resources/AccreditationResource.php`

**Form Fields**:
- Text: Name
- Text: Acronym
- FileUpload: Logo
- Textarea: Description
- Text: Certificate Number
- DatePicker: Valid Until
- TextInput (number): Sort Order
- Toggle: Is Active

**Table Columns**:
- ImageColumn: Logo
- Text: Name
- Text: Acronym
- Text: Certificate Number
- Date: Valid Until
- IconColumn: Is Active

---

### 16. ContactSubmissionResource

**Location**: `app/Filament/Resources/ContactSubmissionResource.php`

**Form Fields** (all disabled except status and notes):
- Select: Type (disabled)
- Grid (2 columns):
  - Text: Name (disabled)
  - Text: Email (disabled)
- Grid (2 columns):
  - Text: Phone (disabled)
  - Text: Company (disabled)
- Text: Subject (disabled)
- Textarea: Message (disabled)
- Grid fields for quote-specific data if applicable
- Select: Status (editable)
- Textarea: Admin Notes (editable)

**Table Columns**:
- Text: Name
- Text: Email
- Text: Type
- Text: Subject
- Badge: Status
- DateTime: Submitted At

**Filters**:
- SelectFilter: Type
- SelectFilter: Status
- DateFilter: Submitted At

**Actions**:
- View (modal)
- Mark as Contacted
- Send Email

---

### 17. LeadCaptureResource

**Location**: `app/Filament/Resources/LeadCaptureResource.php`

**Form Fields** (all read-only):
- Text: Name
- Text: Email
- Text: Phone
- Text: Company
- Text: Province
- Text: Source
- Select: Resource (relationship)

**Table Columns**:
- Text: Name
- Text: Email
- Text: Company
- Text: Source
- DateTime: Captured At

**Filters**:
- SelectFilter: Source
- SelectFilter: Province
- DateFilter: Captured At

**Actions**:
- Export to CSV

---

## Dashboard Widgets

### 1. StatsOverviewWidget
- Total Active Services
- Total Team Members
- Pending Contact Submissions
- Pending Training Bookings

### 2. RecentBookingsWidget
- Latest 5 training bookings
- Quick actions: Confirm, View details

### 3. RecentContactsWidget
- Latest 5 contact submissions
- Quick actions: Mark contacted, View details

### 4. UpcomingTrainingWidget
- Upcoming training schedules (next 30 days)
- Shows available seats

## User Roles & Permissions (Future Phase)

When you need granular control, implement roles:

**Super Admin**:
- Full access to everything

**Content Manager**:
- Manage: Services, Team, Projects, Blog, Resources
- View: Bookings, Contacts, Quotes

**Training Coordinator**:
- Manage: Training Courses, Schedules, Bookings
- View: Everything else

**Marketing**:
- Manage: Blog, Client Logos, Accreditations
- View: All inquiries for lead tracking

## Email Notifications

Configure notifications for:
- New Contact Submission → Admin
- New Training Booking → Training Coordinator
- New Equipment Rental Quote → Admin
- Booking Confirmed → Customer
- Quote Received → Customer

## Implementation Order

1. Install Filament
2. Create Resources in this order:
   - ServiceCategory, Service
   - TeamMember
   - Sector, Project
   - ClientLogo, Accreditation
   - BlogPost
   - Resource
   - TrainingCourse, TrainingSchedule, TrainingBooking
   - EquipmentCategory, Equipment, EquipmentRentalQuote
   - ContactSubmission
   - LeadCapture

3. Create Dashboard Widgets
4. Customize navigation
5. Add custom actions where needed
6. Configure email notifications

## Filament Customization

### Brand Colors
Update `app/Providers/Filament/AdminPanelProvider.php`:
```php
->colors([
    'primary' => Color::hex('#1e7e34'), // KMG green
])
```

### Logo
Add company logo in panel configuration.

### Dark Mode
Enable/disable based on client preference.
