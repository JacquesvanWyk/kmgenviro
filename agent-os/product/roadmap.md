# Product Roadmap

1. [ ] **Filament Installation & Configuration** — Install Filament admin panel package, configure authentication guards, set up admin routes and middleware, create initial admin user, and establish branding (logo, colors) for admin interface. `S`

2. [ ] **Database Schema Design with Blueprint** — Design complete database schema covering services hierarchy, team members, projects, training courses, equipment inventory, leads, and bookings. Use Blueprint DSL to generate migrations, models, factories, and controllers in single command. `M`

3. [ ] **Core Models & Relationships** — Implement Eloquent models for Service, ServiceCategory, TeamMember, Project, Course, Equipment, Lead, and Booking with proper relationships (belongsTo, hasMany, belongsToMany), casts, and accessors. Include comprehensive factories for testing and seeding. `M`

4. [ ] **Service Management Resource** — Create Filament resource for managing service categories and services with nested relationship support, rich text editor for descriptions, multi-select for accreditations, sector tagging, and file uploads for service brochures. `M`

5. [ ] **Team Member Management Resource** — Build Filament resource for team profiles including profile photo upload, qualifications, professional registrations (checkboxes for SACNASP, EAPASA, SAIOH), specializations, and biography with rich text editor. `S`

6. [ ] **Project Portfolio Management Resource** — Develop Filament resource for case studies with sector categorization, client name (optional), project description, challenges/solutions/outcomes sections, image gallery uploads, and publish status. `S`

7. [ ] **Training Course Management Resource** — Create Filament resource for managing courses with course details, accreditation information, learning outcomes, prerequisites, pricing, course schedule calendar integration, and enrollment capacity tracking. `M`

8. [ ] **Equipment Rental Catalogue Resource** — Build Filament resource for equipment inventory with specifications (structured JSON), rental rates (daily/weekly/monthly), availability status, equipment photos, and category organization. `S`

9. [ ] **Blog & News Management Resource** — Develop Filament resource for articles with rich text editor, featured image upload, category/tag taxonomy, SEO fields (meta title/description), author assignment, and publish scheduling. `S`

10. [ ] **Lead & Enquiry Management System** — Create Filament resource displaying all contact form submissions, quote requests, and consultation bookings with status workflow (new, contacted, quoted, won, lost), assignment to team members, internal notes, and email integration. `M`

11. [ ] **Homepage Design & Implementation** — Build homepage with hero section (company tagline, primary CTA), service category cards (10 categories with icons and descriptions), client logo carousel, statistics section (years experience, projects completed, accreditations), latest news/blog posts, and trust indicators (accreditation badges). `M`

12. [ ] **Service Pages Architecture** — Create service category index pages listing all services within category, individual service detail pages with full description, relevant accreditations, sector applications, typical deliverables, related case studies, team members specializing in service, and contextual quote request form. `L`

13. [ ] **About & Team Pages** — Develop about page with company history, mission/values, accreditations showcase with verification documents, and team directory page with filterable grid of team members linking to individual profiles displaying full qualifications and expertise. `M`

14. [ ] **Sectors & Projects Portfolio** — Build sector overview pages (mining, infrastructure, municipal, renewable energy, commercial) with sector-specific challenges and solutions, followed by filterable project portfolio displaying case studies with sector/service filters and detailed project pages. `M`

15. [ ] **Resources & Downloads Center** — Create resources page organizing downloadable content (company profile, service brochures, technical guides, compliance templates) with category filters, search functionality, and download tracking analytics. `S`

16. [ ] **Training Course Public Pages** — Develop training landing page explaining accreditations and benefits, course catalogue with filtering by category/accreditation type, individual course detail pages with full syllabus, pricing, dates, and enrollment CTA leading to booking form. `M`

17. [ ] **Equipment Rental Public Pages** — Build equipment rental landing page, searchable/filterable equipment catalogue with specifications and pricing, individual equipment detail pages with technical specs and availability calendar, and quote request form pre-populated with equipment selection. `M`

18. [ ] **Training Course Booking System** — Implement multi-step booking form (course selection, attendee details, company information, special requirements), calendar integration showing available sessions with capacity, automated confirmation emails with payment instructions and pre-course materials, and admin booking management dashboard. `L`

19. [ ] **Equipment Rental Quote System** — Create structured quote request form capturing equipment selection (multiple items), rental period (start/end dates), delivery address, project context, and contact details. Send automated acknowledgment email and create lead in Filament admin with quote workflow. `M`

20. [ ] **Contact Forms & Lead Capture** — Build general contact form, service-specific quote request forms (embedded on service pages), consultation booking form, and implement intelligent routing to appropriate staff based on service category or enquiry type with automated email notifications. `M`

21. [ ] **WhatsApp Chat Integration** — Add floating WhatsApp button with contextual pre-filled messages based on current page (e.g., visiting Asbestos Compliance service page pre-fills "I'm interested in asbestos compliance services"), implement on all service pages, course pages, and equipment pages. `XS`

22. [ ] **Search Functionality** — Implement site-wide search using Laravel Scout (or database search for MVP) covering services, team members, courses, equipment, projects, and blog posts with relevant result previews and filtering by content type. `M`

23. [ ] **Blog & News Section** — Create blog index page with category filters and search, article detail pages with related posts, social sharing buttons, and author bio. Implement RSS feed for blog subscribers. `S`

24. [ ] **SEO Optimization** — Add meta title/description management in Filament for all content types, implement structured data markup (Organization, LocalBusiness, Course, Article schemas), generate XML sitemap, create robots.txt, implement canonical URLs, and add Open Graph tags for social sharing. `M`

25. [ ] **Performance Optimization** — Implement query optimization with eager loading to prevent N+1 queries, add Redis caching for service listings and course schedules, optimize images with responsive sizes and lazy loading, minimize CSS/JS bundles, and implement CDN for static assets. `M`

26. [ ] **Email Notification System** — Configure transactional emails for booking confirmations, quote acknowledgments, lead notifications to staff, and contact form submissions. Design email templates matching brand identity with proper formatting and actionable CTAs. `S`

27. [ ] **User Roles & Permissions** — Define Filament user roles (Super Admin, Marketing Manager, Course Coordinator, Sales) with granular permissions controlling access to specific resources and actions. Implement in Filament Shield or custom policy classes. `S`

28. [ ] **Analytics & Tracking** — Integrate Google Analytics 4, implement event tracking for key actions (quote requests, bookings, downloads, WhatsApp clicks), create custom dashboard in Filament showing lead sources, conversion metrics, and popular content. `M`

29. [ ] **Content Migration from WordPress** — Export content from current WordPress site (services, team members, projects, blog posts, courses, equipment), transform data to match new schema, import into Laravel application using seeders, verify all images and documents migrated correctly. `L`

30. [ ] **Testing & QA** — Write feature tests for all booking flows, quote request submissions, contact forms, and search functionality. Browser test critical user journeys (course booking, equipment quote, service enquiry). Test responsive layouts on mobile devices. Fix identified bugs. `L`

31. [ ] **Deployment & Launch** — Configure production environment (likely Forge or Cloudflare Pages), set up SSL certificate, configure database backups, implement monitoring/logging (Sentry or Flare), perform final content review, train KMG staff on Filament admin, and execute launch with DNS cutover. `M`

> Notes
> - Order prioritizes establishing content management foundation first (items 1-10), then building public-facing pages (items 11-17), followed by interactive features (items 18-22), and finishing with optimization and launch (items 23-31)
> - Blueprint DSL (item 2) will significantly accelerate development by generating models, migrations, factories, and controllers from YAML schema
> - Each item represents end-to-end functionality with both Filament admin management and public frontend display
> - Training booking system (item 18) and equipment quote system (item 19) are most complex features requiring calendar integration and workflow management
> - Content migration (item 29) should be done late to avoid re-work as schema evolves during development
> - Testing (item 30) covers critical business flows but aims for reasonable coverage, not perfectionist 100% coverage
