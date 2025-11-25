# KMG Environmental Admin Panel Guide

## Overview
The KMG Environmental admin panel provides complete content management for all website content, training operations, equipment rental, and customer inquiries.

## Navigation Groups

### Content Management (7 Resources)
1. **Service Categories** - Organize services into categories with SEO fields
2. **Services** - Individual services with descriptions, icons, and featured flags
3. **Team Members** - Staff profiles with photos, bios, and professional registrations
4. **Sectors** - Industry sector categories for project organization
5. **Projects** - Portfolio items with images, client details, and completion dates
6. **Blog Posts** - Blog content management with featured images and publication dates
7. **Resources** - Downloadable files (PDFs, documents) with lead capture option

### Training & Bookings (3 Resources)
1. **Training Courses** - Course catalog with pricing, duration, and accreditation details
2. **Training Schedules** - Specific course dates and locations with seat availability
3. **Training Bookings** - Customer bookings with status management (pending, confirmed, cancelled, completed)

### Equipment Rental (3 Resources)
1. **Equipment Categories** - Organize rental equipment into categories
2. **Equipment** - Rental items with photos, specifications, and daily/weekly/monthly rates
3. **Equipment Rental Quotes** - Quote requests from customers with status tracking

### Marketing (2 Resources)
1. **Client Logos** - Client/partner logos displayed in grid layout
2. **Accreditations** - Company accreditations with expiry tracking (expired dates show in red)

### Inquiries (2 Resources)
1. **Contact Submissions** - General inquiries with type and status management
2. **Lead Captures** - Marketing leads from resource downloads and newsletter signups (CSV export available)

## Key Features

### Status Workflows

**Training Bookings:**
- New booking: `pending`
- After review: `confirmed` or `cancelled`
- After completion: `completed`

**Contact Submissions:**
- New submission: `new`
- After first contact: `contacted`
- If becomes client: `converted`
- If no longer pursuing: `closed`

**Equipment Rental Quotes:**
- New request: `pending`
- After quote sent: `quoted`
- If customer accepts: `confirmed`
- If order completed: `completed`
- If customer declines: `cancelled`

### Custom Actions

**Services:**
- Duplicate action - Creates a copy of a service with "(Copy)" appended to name

**Training Schedules:**
- Duplicate action - Clone schedule with new dates

### File Uploads

**Accepted File Types:**
- Images: JPG, PNG, SVG (services, team members, projects, equipment, logos, accreditations)
- Documents: PDF, DOCX, XLSX (resources only)

**File Size Limits:**
- Team member photos: 2MB max
- Client logos: 1MB max
- Project featured images: 5MB max
- Gallery images: Standard image limits apply

### Important Fields

**Read-Only Fields:**
Customer-submitted data in bookings, quotes, and submissions are read-only. Only status and admin notes fields are editable.

**Auto-Generated Fields:**
- Slugs are automatically generated from names when creating new records
- Can be manually edited if needed

**SEO Fields:**
Service Categories, Services, Sectors, Projects, Blog Posts, and Training Courses have collapsible SEO sections for meta titles and descriptions.

## Relationship Indicators

**Count Badges:**
- Service Categories show services count
- Sectors show projects count
- Training Courses show upcoming schedules count
- Training Schedules show bookings count
- Equipment Categories show equipment count

**Available Seats Badge Colors:**
- Green: >5 seats available
- Yellow: 1-5 seats available
- Red: 0 seats available

**Status Badge Colors:**
Training Bookings:
- Blue: pending
- Green: confirmed
- Red: cancelled
- Gray: completed

## Search & Filtering

All resources support:
- Search by name/title
- Filtering by status/category
- Sorting by various columns
- Date range filters where applicable

## Tips

1. **Keep content organized** - Use sort_order fields to control display sequence on website
2. **Monitor accreditations** - Check for expiring accreditations (highlighted in red)
3. **Track equipment availability** - Use available seats badges to manage training capacity
4. **Export leads** - Use bulk CSV export for marketing follow-up
5. **Use admin notes** - Document all customer interactions in the notes field
6. **Soft deletes** - Deleted records can be restored from the trash filter

## Testing Coverage

The admin panel includes comprehensive test coverage for:
- Service creation with category relationships
- Service duplication functionality
- Training course relationship counts
- Training booking status updates
- Contact submission status changes
- Equipment category relationships
- Accreditation expiry date handling

All 50 tests pass successfully, ensuring reliable admin operations.
