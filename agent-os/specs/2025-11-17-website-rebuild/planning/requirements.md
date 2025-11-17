# Spec Requirements: KMG Environmental Website Rebuild - Phase 1

## Initial Description

Rebuild the KMG Environmental Solutions website from WordPress to Laravel 12 with Filament CMS. This is a complete rebuild giving the client full content management control.

Phase 1 focuses on establishing the foundation: database schema, models, relationships, Filament admin panel installation and configuration, basic seeders, and comprehensive testing.

---

## Requirements Discussion

### First Round Questions

**Q1: Filament Admin Panel Branding - Color Scheme**
Should we use the existing brand colors from your logo (blues and greens) or would you prefer a specific color for the admin panel primary color?

**Answer:** Option A - Use green #1e7e34 as primary color for Filament admin panel

**Q2: Logo Configuration**
I see you have kmg-logo-primary.png. For the Filament admin panel, we'll need:
- Main logo for the admin panel header
- Possibly a square/icon version for compact views or mobile
- A white/inverted version for dark mode (if enabled)

Should I create all three variations, or do you have existing versions?

**Answer:** Create all suggested logo variations:
- Use kmg-logo-primary.png for main admin panel logo
- Create square icon version for compact views/mobile
- Create white/inverted version for dark mode support

**Q3: Database Configuration**
What database name, username, and password should we use for local development? I'll need to verify the connection before running migrations.

**Answer:**
- Database name: `kmgenviro`
- User: `root`
- Password: (no password)
- Action: Verify connection before proceeding with migrations

**Q4: Phase 1 Seeders - How Much Real Data?**
For Phase 1, should I create comprehensive seeders with all real data, or start with foundation-level seeders (e.g., 10 service categories, main accreditations) and we add more detailed content in Phase 2?

**Answer:** Foundation level
- 10 service categories (Environmental Monitoring, Impact Studies, Permitting, Waste Management, ESG, Occupational Hygiene, Training, Equipment Rental, Auditing, etc.)
- Main accreditations (DoEL, SACNASP, EAPASA, GBCSA, WISA, SAIOH, IIAV, IAIAsa)

**Q5: Admin Users**
How many admin users should I create initially, and what email addresses should they use?

**Answer:** Create TWO admin users:
1. Email: jvw679@gmail.com (developer/Jacques)
2. Email: marabekg@kmgenviro.co.za (client/Khumbelo)

**Q6: Typography Decisions**
The old WordPress site uses Playfair Display and Roboto. Do you want to keep these fonts, or would you prefer a more modern font pairing for the new site?

**Answer:** Use modern fonts (NOT Playfair Display/Roboto from old site)
- Suggest modern font pairings for headings and body text
- Configure in Tailwind CSS during Phase 1

**Q7: Testing Scope for Phase 1**
Should we write comprehensive tests for all models and relationships, or keep Phase 1 testing minimal (just ensuring migrations run and basic CRUD works)?

**Answer:** Comprehensive testing
- Test all model relationships
- Test all factories
- Test basic CRUD operations
- Ensure Blueprint-generated tests pass

**Q8: Git Workflow**
Should I commit changes automatically as we progress, or would you prefer to review before each commit?

**Answer:** Review-first approach
- Do NOT commit automatically
- Always ask user to review before committing
- User will review and commit manually

---

## Visual Assets

### Files Provided:
- `kmg-logo-primary.png`: Horizontal logo with earth/leaf icon on left, company name on right. Dimensions approximately 1216x438px. Features blue and green earth icon with tan/gold element, navy blue "KMG" text and company name. This is suitable for main admin panel header.

### Visual Insights:
- Brand colors identified: Navy blue (#2E5090 approx), Medium blue (#4A90C8 approx), Lime green (#A4C639 approx), Gold/Tan (#C9A35E approx)
- Primary color for admin panel will be green #1e7e34 (darker than logo green for better UI contrast)
- Logo is horizontal orientation - will need square icon version for compact admin panel views
- Will need white/inverted version for dark mode support
- Fidelity level: High-fidelity production logo

---

## Requirements Summary

### Phase 1 Scope Overview

Phase 1 establishes the complete foundation for the KMG Environmental website rebuild:

**Timeline:** Week 1 (5-7 working days)

**Success Criteria:**
- All 16 models generated from Blueprint schema with proper relationships
- Filament admin panel accessible at `/admin` with KMG branding
- Both admin users can log in and access dashboard
- Foundation seeders populate service categories and accreditations
- All model relationship tests pass
- All factories generate realistic test data
- Database migrations run successfully without errors
- Logo assets created and configured

---

### Functional Requirements

#### 1. Database Setup & Schema

**Connection Configuration:**
- Database: MySQL 8.x via DBngin
- Database name: `kmgenviro`
- User: `root`
- Password: (empty)
- Verify connection before proceeding

**Blueprint Schema Execution:**
- Use existing `blueprint-schema.yaml` from product documentation
- Generate 16 models with full relationship definitions
- Generate migrations with foreign keys and indexes
- Generate factories with realistic fake data
- Generate basic controllers for future use

**Models to Generate:**
1. ServiceCategory (hasMany Service)
2. Service (belongsTo ServiceCategory)
3. TeamMember
4. Sector (hasMany Project)
5. Project (belongsTo Sector)
6. TrainingCourse (hasMany TrainingSchedule, TrainingBooking)
7. TrainingSchedule (belongsTo TrainingCourse, hasMany TrainingBooking)
8. TrainingBooking (belongsTo TrainingCourse, TrainingSchedule)
9. EquipmentCategory (hasMany Equipment)
10. Equipment (belongsTo EquipmentCategory, hasMany EquipmentRentalQuote)
11. EquipmentRentalQuote (belongsTo Equipment)
12. BlogPost
13. ClientLogo
14. Accreditation
15. Resource
16. ContactSubmission
17. LeadCapture (belongsTo Resource)

**Migration Strategy:**
- Run `php artisan migrate` on clean database
- Do NOT use `migrate:fresh` or `migrate:refresh` (preserve database)
- Verify all tables created successfully
- Check foreign key constraints established correctly

#### 2. Filament Installation & Configuration

**Installation:**
- Install Filament 3.x via Composer
- Run `php artisan filament:install --panels`
- Verify installation at `/admin` route

**Brand Configuration:**
- Primary color: `#1e7e34` (green)
- Brand name: "KMG Environmental"
- Admin panel path: `/admin`
- Login required for access

**Logo Setup:**
- Main logo: `kmg-logo-primary.png` in admin panel header
- Square icon: Create 200x200px version from main logo (just the earth icon)
- Dark mode logo: White/inverted version for dark mode support
- Store in `public/images/` directory

**Navigation Groups:**
Configure navigation with these groups (in order):
1. Content Management
2. Training & Bookings
3. Equipment Rental
4. Marketing
5. Inquiries

**Dashboard Configuration:**
- Default dashboard at `/admin`
- Welcome message for logged-in admin users
- No widgets in Phase 1 (widgets planned for Phase 2)

#### 3. Logo Assets to Create

**Source File:** `kmg-logo-primary.png` (1216×438px)

**Required Variations:**

**Main Admin Logo:**
- File: `kmg-logo-primary.png` (use existing)
- Usage: Admin panel header, login page
- Location: `public/images/logo.png`

**Square Icon Version:**
- File: `kmg-icon-square.png`
- Dimensions: 200×200px (square crop)
- Content: Just the earth/leaf icon from main logo (left portion)
- Usage: Compact admin panel views, mobile navigation, favicon base
- Location: `public/images/icon.png`

**Dark Mode Version:**
- File: `kmg-logo-white.png`
- Dimensions: Same as primary (1216×438px)
- Content: White/inverted version of full logo
- Usage: Dark mode admin panel (if enabled)
- Location: `public/images/logo-white.png`

**Favicon:**
- File: `favicon.png` and `favicon.ico`
- Dimensions: 32×32px and 16×16px
- Generated from square icon
- Location: `public/`

#### 4. Typography Configuration

**Font Selection:**
Recommend modern, professional font pairings suitable for environmental consultancy:

**Option 1 (Recommended): Inter + System Stack**
- Headings: Inter (weights: 600, 700, 800)
- Body: Inter (weights: 400, 500)
- Code/Numbers: SF Mono, Consolas, monospace
- Benefits: Excellent readability, professional, fast loading, works well for technical content

**Option 2: Outfit + Geist**
- Headings: Outfit (weights: 600, 700)
- Body: Geist Sans (weights: 400, 500)
- Benefits: Modern, slightly more distinctive, still highly professional

**Option 3: DM Sans + System Stack**
- Headings: DM Sans (weights: 500, 700)
- Body: DM Sans (weights: 400, 500)
- Benefits: Geometric, clean, excellent for environmental/scientific content

**Implementation:**
- Install via Google Fonts (for Options 1 & 3) or bundle locally
- Configure in Tailwind CSS during Phase 1
- Apply to both admin panel and public frontend (future phases)

#### 5. Seeders Implementation

**Required Seeders:**

**ServiceCategorySeeder:**
Create 10 foundation service categories with real names from company services:

1. Environmental Monitoring Services
2. Environmental Impact & Specialist Studies
3. Permitting Services & Applications
4. Waste Management Services
5. ESG Advisory & Reporting
6. Occupational Hygiene Services
7. Training Courses & CPD
8. Equipment Rental Services
9. Environmental Auditing & Compliance
10. Asbestos Management Services

Each category should include:
- Name (string)
- Slug (auto-generated from name)
- Description (2-3 sentences about the category)
- Icon (placeholder or simple SVG reference)
- Sort order (1-10)
- is_active: true

**AccreditationSeeder:**
Create 8 main accreditations:

1. DoEL (Department of Employment and Labour)
   - Acronym: DoEL
   - Description: Asbestos inspection and assessment approval

2. SACNASP (South African Council for Natural Scientific Professions)
   - Acronym: SACNASP
   - Description: Professional registration and accredited training provider

3. EAPASA (Environmental Assessment Practitioners Association of South Africa)
   - Acronym: EAPASA
   - Description: Environmental assessment practitioner registration

4. GBCSA (Green Building Council South Africa)
   - Acronym: GBCSA
   - Description: Member organization for sustainable building practices

5. WISA (Water Institute of Southern Africa)
   - Acronym: WISA
   - Description: Professional association for water sector

6. SAIOH (Southern African Institute for Occupational Hygiene)
   - Acronym: SAIOH
   - Description: Occupational hygiene professional membership

7. IIAV (International Institute of Acoustics and Vibration)
   - Acronym: IIAV
   - Description: Acoustics and vibration professional association

8. IAIAsa (International Association for Impact Assessment SA)
   - Acronym: IAIAsa
   - Description: Impact assessment professional network

Each accreditation should include:
- Name (full name)
- Acronym (short version)
- Description (1-2 sentences)
- Logo (placeholder for now, real logos in Phase 2)
- Sort order
- is_active: true

**UserSeeder:**
Create TWO admin users:

1. Developer Admin:
   - Name: Jacques van Wyk
   - Email: jvw679@gmail.com
   - Password: (generate secure password, output to console during seeding)

2. Client Admin:
   - Name: Khumbelo Marabe
   - Email: marabekg@kmgenviro.co.za
   - Password: (generate secure password, output to console during seeding)

**Execution Order:**
```bash
php artisan db:seed --class=ServiceCategorySeeder
php artisan db:seed --class=AccreditationSeeder
php artisan db:seed --class=UserSeeder
```

#### 6. Models & Relationships Verification

**Relationship Testing Checklist:**

**One-to-Many Relationships:**
- [ ] ServiceCategory → Services
- [ ] Sector → Projects
- [ ] TrainingCourse → TrainingSchedules
- [ ] TrainingCourse → TrainingBookings
- [ ] TrainingSchedule → TrainingBookings
- [ ] EquipmentCategory → Equipment
- [ ] Equipment → EquipmentRentalQuotes
- [ ] Resource → LeadCaptures

**Belongs-To Relationships (Inverse):**
- [ ] Service → ServiceCategory
- [ ] Project → Sector
- [ ] TrainingSchedule → TrainingCourse
- [ ] TrainingBooking → TrainingCourse
- [ ] TrainingBooking → TrainingSchedule
- [ ] Equipment → EquipmentCategory
- [ ] EquipmentRentalQuote → Equipment
- [ ] LeadCapture → Resource

**Model Features:**
- [ ] All models use proper casts for JSON fields
- [ ] All models have appropriate fillable/guarded properties
- [ ] Soft deletes enabled where specified in schema
- [ ] Slug fields have unique indexes
- [ ] Timestamp fields configured correctly
- [ ] Default values set for boolean and integer fields

#### 7. Testing Requirements

**Model Relationship Tests:**

Create `tests/Feature/ModelRelationshipsTest.php`:

```php
// Test each relationship defined above
it('service category has many services', function () {
    $category = ServiceCategory::factory()->create();
    $services = Service::factory()->count(3)->create([
        'service_category_id' => $category->id
    ]);

    expect($category->services)->toHaveCount(3);
    expect($category->services->first())->toBeInstanceOf(Service::class);
});

// Repeat for all relationships
```

**Factory Tests:**

Create `tests/Feature/FactoryTest.php`:

```php
// Test each factory generates realistic data
it('service category factory creates valid data', function () {
    $category = ServiceCategory::factory()->create();

    expect($category->name)->not->toBeNull();
    expect($category->slug)->not->toBeNull();
    expect($category->is_active)->toBeTrue();
    expect($category->sort_order)->toBeInt();
});

// Repeat for all 16+ models
```

**CRUD Operation Tests:**

Create `tests/Feature/CrudOperationsTest.php`:

```php
// Test basic CRUD for key models
it('can create, read, update, and delete service category', function () {
    // Create
    $category = ServiceCategory::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
    ]);

    // Read
    $found = ServiceCategory::find($category->id);
    expect($found->name)->toBe('Test Category');

    // Update
    $category->update(['name' => 'Updated Category']);
    expect($category->fresh()->name)->toBe('Updated Category');

    // Delete (soft delete)
    $category->delete();
    expect(ServiceCategory::find($category->id))->toBeNull();
    expect(ServiceCategory::withTrashed()->find($category->id))->not->toBeNull();
});

// Repeat for Service, TeamMember, Project, TrainingCourse, Equipment
```

**Blueprint-Generated Tests:**

Blueprint may generate basic tests - ensure these pass:
```bash
php artisan test --filter=BlueprintGeneratedTest
```

**Test Execution Strategy:**
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ModelRelationshipsTest.php

# Run with filter
php artisan test --filter=relationship
```

**Coverage Requirements:**
- All 16 models have relationship tests
- All 16 models have factory tests
- Top 5 models (ServiceCategory, Service, TeamMember, TrainingCourse, Equipment) have CRUD tests
- All tests pass before Phase 1 completion

#### 8. Git Strategy

**Review-First Workflow:**

**DO NOT:**
- Commit automatically
- Use git commands without explicit approval
- Add Claude Code attribution to commits

**DO:**
- Ask user to review all changes before committing
- Provide clear summary of changes made
- Suggest commit messages (without Claude attribution)
- Let user execute git commands manually

**Suggested Commit Message Format:**
```
Add [feature/component]

- [Change 1]
- [Change 2]
- [Change 3]
```

**What to Review Before Committing:**

1. **Database Changes:**
   - Migration files generated correctly
   - No conflicts with existing migrations
   - Foreign keys properly defined

2. **Model Changes:**
   - Relationships defined correctly
   - Casts configured for JSON fields
   - Fillable/guarded properties set appropriately

3. **Filament Configuration:**
   - Admin panel accessible
   - Branding applied correctly
   - Navigation groups configured

4. **Seeder Data:**
   - Real company data used (not lorem ipsum)
   - All required records created
   - Passwords output to console for admin users

5. **Tests:**
   - All tests passing
   - No failing assertions
   - Realistic test data

**Review Checkpoints:**

Suggest review/commit at these milestones:
1. After Blueprint schema generation
2. After Filament installation and configuration
3. After seeders implementation
4. After test suite completion

---

### Success Criteria

Phase 1 is complete when ALL of the following are verified:

**Database & Models:**
- [ ] All 16 models generated with correct relationships
- [ ] All migrations run successfully without errors
- [ ] Database tables created with proper foreign keys and indexes
- [ ] All model factories generate realistic test data

**Filament Admin:**
- [ ] Admin panel accessible at `/admin`
- [ ] Login page displays correctly with KMG branding
- [ ] Both admin users (jvw679@gmail.com and marabekg@kmgenviro.co.za) can log in
- [ ] Dashboard displays with correct brand color (#1e7e34)
- [ ] KMG logo displays in admin panel header
- [ ] Navigation groups configured correctly

**Seeders:**
- [ ] ServiceCategorySeeder creates 10 service categories
- [ ] AccreditationSeeder creates 8 accreditations
- [ ] UserSeeder creates 2 admin users with passwords output to console
- [ ] All seeded data visible in Filament admin (once resources created in Phase 2)

**Testing:**
- [ ] All relationship tests pass
- [ ] All factory tests pass
- [ ] All CRUD operation tests pass
- [ ] Full test suite runs without failures: `php artisan test`

**Logo Assets:**
- [ ] Main logo (`logo.png`) configured in Filament
- [ ] Square icon (`icon.png`) created from main logo
- [ ] Dark mode logo (`logo-white.png`) created
- [ ] Favicon generated and placed in public directory

**Typography:**
- [ ] Font pairing selected (Inter recommended)
- [ ] Tailwind CSS configured with chosen fonts
- [ ] Fonts loading correctly in admin panel

**Code Quality:**
- [ ] Laravel Pint run on all PHP files: `vendor/bin/pint --dirty`
- [ ] No linting errors
- [ ] Code follows Laravel conventions

**Documentation:**
- [ ] Admin user credentials documented (not in git)
- [ ] Database setup documented
- [ ] Seeder execution order documented

---

### Out of Scope for Phase 1

The following are explicitly NOT included in Phase 1 and will be addressed in future phases:

**Phase 2 (Filament Resources):**
- Creating Filament resources for each model
- Resource form fields and table columns
- Custom actions and bulk operations
- Relationship managers
- Dashboard widgets

**Phase 3 (Public Frontend Pages):**
- Homepage design and implementation
- Service pages (category and detail)
- Team member pages
- Project portfolio pages
- About page
- Contact page

**Phase 4 (Interactive Forms):**
- Training booking system
- Equipment rental quote system
- Contact forms
- Lead capture forms

**Phase 5 (Content Migration):**
- WordPress content export
- Blog post migration
- Media library migration
- Team member content population
- Service content population

**Future Phases:**
- Email notification system
- WhatsApp integration
- Search functionality
- SEO optimization
- Analytics integration
- Performance optimization
- Deployment and launch

---

### References

**Product Documentation:**
- Blueprint Schema: `/agent-os/product/blueprint-schema.yaml`
- Implementation Guide Phase 1: `/agent-os/product/implementation-guide.md` (lines 21-133)
- Filament Structure: `/agent-os/product/filament-structure.md`
- Tech Stack: `/agent-os/product/tech-stack.md`
- Product Mission: `/agent-os/product/mission.md`
- Product Roadmap: `/agent-os/product/roadmap.md`

**Spec Documentation:**
- Logo Variants Specification: `planning/logo-variants.md`
- Typography Specification: `planning/typography.md`
- Seeders Data Template: `planning/seeders-data.md`

**Visual Assets:**
- Main Logo: `planning/visuals/kmg-logo-primary.png`

---

## Implementation Notes

**Estimated Timeline:**
- Day 1: Blueprint schema execution, database setup, migrations
- Day 2: Filament installation and configuration, logo setup
- Day 3: Seeders implementation and execution
- Day 4: Typography configuration, comprehensive testing
- Day 5: Code quality review, documentation, final verification

**Dependencies:**
- Blueprint installed: `composer require -W --dev laravel-shift/blueprint`
- Filament installed: `composer require filament/filament:"^3.2" -W`
- DBngin running with MySQL 8.x
- Node.js for asset compilation if needed

**Risk Mitigation:**
- Verify database connection before running migrations
- Test each seeder individually before running all together
- Keep backups of database after successful migration
- Run tests frequently during development

**Next Phase Preview:**
Phase 2 will focus on creating all 17 Filament resources to allow full content management of the foundation data created in Phase 1.
