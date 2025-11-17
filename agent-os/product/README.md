# KMG Environmental Solutions - WordPress to Laravel Rebuild

## Project Overview

This is a complete rebuild of the KMG Environmental Solutions website from WordPress to **Laravel 12 + Filament CMS**.

**Client**: KMG Environmental Solutions Services (Pty) Ltd
**Current Site**: https://kmgenviro.co.za/
**Goal**: Modern, performant Laravel application with Filament admin for client content management

---

## 📁 Documentation Structure

All planning and implementation documentation is in this directory:

### Core Documents

1. **[mission.md](./mission.md)** - Product vision, user personas, problems solved, key features
2. **[roadmap.md](./roadmap.md)** - Phased development plan with 31 prioritized items
3. **[tech-stack.md](./tech-stack.md)** - Complete technical architecture and tools

### Implementation Documents

4. **[blueprint-schema.yaml](./blueprint-schema.yaml)** - Database schema for rapid model generation
5. **[filament-structure.md](./filament-structure.md)** - All 17 Filament resources with detailed specifications
6. **[implementation-guide.md](./implementation-guide.md)** - Step-by-step build instructions (8 phases)

---

## 🎯 Quick Start

### Immediate Next Steps

1. **Install Blueprint**
   ```bash
   composer require -W --dev laravel-shift/blueprint
   ```

2. **Generate Models & Migrations**
   ```bash
   cp agent-os/product/blueprint-schema.yaml draft.yaml
   php artisan blueprint:build
   php artisan migrate
   ```

3. **Install Filament**
   ```bash
   composer require filament/filament:"^3.2" -W
   php artisan filament:install --panels
   php artisan make:filament-user
   ```

4. **Start Creating Filament Resources**
   ```bash
   php artisan make:filament-resource ServiceCategory --generate
   php artisan make:filament-resource Service --generate
   # Continue for all 17 resources (see filament-structure.md)
   ```

5. **Follow Implementation Guide**
   - See [implementation-guide.md](./implementation-guide.md) for complete step-by-step instructions

---

## 📊 Project Scope Summary

### Content to Migrate from WordPress

**Current WordPress Features**:
- 10 service categories with sub-services
- Team member profiles
- Training courses with booking system (Tutor LMS)
- Equipment rental catalogue
- Project portfolio by sector
- Blog posts
- Client logos
- Downloadable resources
- Contact forms & quote requests

**New Laravel Features**:
- All above + Filament CMS for easy client management
- Modern responsive design with Tailwind 4
- Livewire/Volt for interactive features
- Performance optimized
- Better SEO capabilities

### Database Overview (16 Tables)

From `blueprint-schema.yaml`:

1. **Content**: service_categories, services, team_members, blog_posts, resources
2. **Projects**: sectors, projects
3. **Training**: training_courses, training_schedules, training_bookings
4. **Equipment**: equipment_categories, equipment, equipment_rental_quotes
5. **Marketing**: client_logos, accreditations
6. **Forms**: contact_submissions, lead_captures

---

## 🗓️ Timeline Estimate

Based on roadmap.md:

- **Phase 1 - Foundation** (Week 1): Blueprint, Filament, base setup
- **Phase 2 - CMS Resources** (Week 2-3): All 17 Filament resources
- **Phase 3 - Public Frontend** (Week 4-5): Volt pages for visitors
- **Phase 4 - Interactive Features** (Week 6): Forms, booking, quotes
- **Phase 5 - Content Migration** (Week 7): WordPress data import
- **Phase 6 - Testing & QA** (Week 8): Pest tests, browser tests
- **Phase 7 - Deployment** (Week 8-9): Production launch

**Total**: 8-9 weeks for complete rebuild

---

## 🛠️ Tech Stack

**Backend**:
- PHP 8.3.27
- Laravel 12
- Filament 3.x (admin panel)
- Fortify (authentication)
- MySQL 8.x (DBngin)

**Frontend**:
- Livewire 3 + Volt (class-based components)
- Flux UI Free (component library)
- Tailwind CSS 4
- Alpine.js (included with Livewire)

**Development**:
- Blueprint - Rapid model generation
- Pest 4 - Testing framework
- Laravel Pint - Code formatting

**Deployment**: Laravel Forge (recommended)

---

## 📋 Key Features to Build

### Client-Managed (via Filament)

✅ Services & service categories
✅ Team member profiles
✅ Training courses & schedules
✅ Equipment rental items
✅ Project case studies
✅ Blog posts
✅ Client logos
✅ Downloadable resources
✅ View form submissions (contacts, bookings, quotes)

### Public-Facing Features

✅ Homepage with hero, services, accreditations
✅ Service category & individual service pages
✅ About page with team
✅ Sectors & projects portfolio
✅ Training calendar with booking
✅ Equipment rental catalogue with quotes
✅ Resources/downloads with lead capture
✅ Blog/news
✅ Contact form & quote requests
✅ WhatsApp integration

---

## 🎨 Design References

**Current WordPress Site**: https://kmgenviro.co.za/

**Client Documents**:
- `KMG Company Profile -Website.txt` - Complete service descriptions
- `Website Ideas-.txt` - Detailed page structure requirements

**Brand Colors**:
- Primary: Green (#1e7e34)
- Professional corporate aesthetic
- Emphasis on accreditations & credentials

---

## 📈 Success Metrics (from mission.md)

**Performance**:
- 75% faster page loads vs WordPress
- <2s mobile load time

**User Engagement**:
- 60% reduction in booking abandonment
- 40% increase in quote submissions

**Client Efficiency**:
- Content updates in <5 minutes (vs 5+ hours with developer)
- Real-time booking management

---

## 🔗 Important Links

- **Current Site**: https://kmgenviro.co.za/
- **Blueprint Docs**: https://blueprint.laravelshift.com/
- **Filament Docs**: https://filamentphp.com/docs
- **Livewire Volt Docs**: https://livewire.laravel.com/docs/volt

---

## ⚠️ Important Notes

### Development Guidelines (from CLAUDE.md)

- **NEVER run migrate commands** - always use existing database
- **Never run `php artisan serve` or `npm run dev`** - user runs these in background
- Use **class-based Volt components** (check existing components first)
- Run **Pint before commits**: `vendor/bin/pint --dirty`
- Write **Pest tests** for all features
- **Minimal comments** - focus on clear naming
- All commits **without Claude Code attribution** (per user preference)

### Client Control Philosophy

The entire point of this rebuild is to give KMG staff the ability to:
- Add/edit services without developer help
- Manage training schedules independently
- Update team member information
- Publish blog posts
- View and respond to form submissions

**This means**: Filament resources must be intuitive and comprehensive.

---

## 🚀 Getting Started

1. Read [implementation-guide.md](./implementation-guide.md) for detailed steps
2. Install Blueprint and generate models from [blueprint-schema.yaml](./blueprint-schema.yaml)
3. Install Filament and create admin user
4. Start creating Filament resources using [filament-structure.md](./filament-structure.md) as reference
5. Build public Volt pages following patterns in implementation guide
6. Test thoroughly with Pest
7. Migrate WordPress content
8. Deploy to production

---

## 📞 Support

For questions or clarifications about this project:
- Refer to the detailed docs in this directory
- Check existing Laravel conventions in codebase
- Use Laravel Boost MCP tools for documentation search

---

**Last Updated**: 2025-11-17
**Project Status**: Planning Complete - Ready for Development
