# Laravel Backend Standards

## Architecture & Design Patterns

### Layered Architecture
- **Controllers**: Thin controllers that only handle HTTP requests/responses and delegate to Services/Actions
- **Services/Actions**: Contain business logic. Use Action classes for single operations, Service classes for complex business logic
- **Models**: Eloquent models with only relationships, accessors/mutators, and model-specific logic
- **Repositories**: Optional abstraction layer only when needed for complex queries or testing isolation

### RESTful API Design
- **Resource-based URLs**: Use plural nouns for resources (`/api/v1/users`, `/api/v1/products`)
- **HTTP Methods**: Use appropriate methods (GET, POST, PUT/PATCH, DELETE)
- **Response Format**: Consistent JSON responses with proper structure
- **Status Codes**: Use proper HTTP status codes:
  - `200`: Successful GET/PUT/PATCH
  - `201`: Successful POST creation
  - `204`: Successful DELETE
  - `400`: Bad request/validation errors
  - `401`: Unauthorized
  - `403`: Forbidden
  - `404`: Not found
  - `422`: Validation errors
  - `500`: Server errors

### Eloquent Conventions
- **Relationships**: Define all relationships in models using standard Eloquent methods
- **Mass Assignment**: Use `$fillable` arrays for mass assignment protection
- **Scopes**: Use query scopes for common query logic
- **Factories**: Create database factories for all models
- **Migrations**: Create migrations for all schema changes with proper foreign keys and indexes

### API Response Structure
```json
{
  "success": true,
  "data": {},
  "message": "Operation completed successfully",
  "meta": {
    "pagination": {}
  }
}
```

### Error Handling
- **Validation**: Use Form Request classes for validation with proper error messages
- **Exception Handling**: Centralized exception handling with proper error responses
- **Logging**: Log errors with context for debugging
- **API Errors**: Return consistent error response format

### Security
- **Authentication**: Use Laravel Sanctum or Passport for API authentication
- **Authorization**: Implement proper policies and gates for authorization
- **Validation**: Never trust user input - always validate
- **Rate Limiting**: Implement API rate limiting to prevent abuse

### Code Organization
- **Namespaces**: Use proper PSR-4 namespacing
- **Class Structure**: One class per file following Laravel conventions
- **Dependency Injection**: Use constructor injection for dependencies
- **Interfaces**: Use interfaces for services when multiple implementations exist

### Performance
- **Eager Loading**: Use eager loading to prevent N+1 queries
- **Caching**: Implement caching where appropriate using Laravel's cache system
- **Database Indexing**: Add proper database indexes for frequently queried columns
- **Query Optimization**: Optimize database queries and use appropriate query methods

## Required Dependencies
- Laravel 9.x or higher
- Laravel Sanctum for authentication
- Pest for testing
- Laravel Form Request validation
- Proper CORS configuration for frontend integration