# Tech Stack Standards

This document outlines the complete technology stack used across our multi-platform development approach.

## Architecture Overview

We build full-stack applications with four main components:
1. **Laravel API** - Backend RESTful API
2. **Filament Admin** - Administrative interface
3. **Nuxt Frontend** - Web application
4. **Flutter Mobile** - Mobile applications

## Backend Stack

### Core Framework
- **Laravel 9.x+**: PHP web framework for API development
- **PHP 8.x+**: Programming language with strict typing

### Database & ORM
- **MySQL**: Primary database (via DBngin for local development)
- **Eloquent ORM**: Laravel's database ORM
- **Migrations**: Database schema management
- **Factories & Seeders**: Test data generation

### API Development
- **RESTful APIs**: Following REST principles
- **Laravel Sanctum**: API authentication
- **Resource Classes**: API response formatting
- **Form Request Validation**: Input validation

### Admin Panel
- **FilamentPHP 3.x+**: Admin panel framework
- **Laravel Integration**: Seamless integration with Laravel backend
- **Custom Resources**: Tailored admin interfaces

### Testing
- **Pest**: PHP testing framework with modern syntax
- **Feature Tests**: API endpoint testing
- **Unit Tests**: Business logic testing
- **Database Testing**: Database interaction testing

### Development Tools
- **PHPStan**: Static analysis tool
- **PHP CS Fixer**: Code formatting
- **Composer**: Dependency management

## Frontend Stack

### Core Framework
- **Nuxt 3.x+**: Vue.js meta-framework
- **Vue 3.x+**: Progressive JavaScript framework
- **TypeScript**: Type-safe JavaScript

### State Management
- **Pinia**: Official Vue state management
- **Reactive State**: Composition API-based state

### Styling
- **Tailwind CSS**: Utility-first CSS framework
- **Responsive Design**: Mobile-first approach
- **CSS Variables**: Design token management

### Data Fetching
- **useFetch**: Nuxt's data fetching composable
- **$fetch**: Lower-level data fetching
- **Axios**: HTTP client (if needed)

### Testing
- **Vitest**: Fast unit testing framework
- **@nuxt/test-utils**: Nuxt testing utilities
- **@vue/test-utils**: Vue component testing
- **mountSuspended**: Proper Nuxt component mounting

### Development Tools
- **ESLint**: JavaScript/TypeScript linting
- **Prettier**: Code formatting
- **TypeScript Compiler**: Type checking
- **Vite**: Build tool and dev server

## Mobile Stack

### Core Framework
- **Flutter**: Cross-platform mobile development framework
- **Dart**: Programming language for Flutter

### State Management
- **Riverpod**: Modern state management (preferred)
- **BLoC**: Alternative state management pattern
- **Provider**: Simple state management

### Architecture
- **Clean Architecture**: Separation of concerns
- **Repository Pattern**: Data layer abstraction
- **Domain-Driven Design**: Business logic focus

### Navigation
- **GoRouter**: Declarative routing
- **Named Routes**: Route-based navigation

### Testing
- **flutter_test**: Flutter's testing framework
- **mockito/mocktail**: Mocking framework
- **integration_test**: End-to-end testing
- **golden_toolkit**: UI consistency testing

### Development Tools
- **Dart Analyzer**: Static analysis
- **Dart Format**: Code formatting
- **Flutter CLI**: Development and build tools

## Development Workflow

### Version Control
- **Git**: Version control system
- **Feature Branches**: Isolated feature development
- **Pull Requests**: Code review process

### Code Quality
- **Test-Driven Development**: TDD methodology required
- **Code Reviews**: Peer review process
- **Automated Testing**: CI/CD integration
- **Static Analysis**: Multiple tools for quality assurance

### Local Development
- **DBngin**: Local MySQL database management
- **Docker** (optional): Containerized development environment
- **Hot Reload**: Fast development iteration

## Integration Standards

### API Communication
- **RESTful Design**: Standard HTTP methods and status codes
- **JSON Format**: Consistent data exchange format
- **Authentication**: Token-based authentication across all platforms
- **Error Handling**: Consistent error response format

### Cross-Platform Consistency
- **Data Models**: Consistent data structures across platforms
- **Business Logic**: Shared validation rules and business logic
- **User Experience**: Consistent UX patterns where applicable
- **Testing Strategy**: Comprehensive testing across all platforms

## Deployment & DevOps

### Backend
- **Laravel Forge**: Server management
- **DigitalOcean/Vultr**: Cloud hosting
- **SSL Certificates**: HTTPS security
- **Database Backups**: Automated backup strategy

### Frontend
- **Vercel/Netlify**: Static site hosting
- **Cloudflare Pages**: Alternative hosting option
- **CDN**: Content delivery network
- **CI/CD**: Automated deployment

### Mobile
- **App Store**: iOS distribution
- **Google Play**: Android distribution
- **Firebase**: Mobile backend services
- **CodePush**: OTA updates (if needed)

This tech stack provides a robust, scalable foundation for building modern full-stack applications with comprehensive testing and high code quality standards.
