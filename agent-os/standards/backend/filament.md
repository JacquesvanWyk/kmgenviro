# FilamentPHP Admin Panel Standards

## Resource Conventions

### Resource Structure
- **Resource Classes**: One resource class per Eloquent model
- **Naming**: Use `{Model}Resource.php` naming convention
- **Forms**: Define form schemas using `form()` method with proper field types
- **Tables**: Define table configurations using `table()` method with appropriate columns
- **Pages**: Use Filament pages for custom admin pages

### Form Standards
- **Field Types**: Use appropriate field types for data (TextInput, Select, DatePicker, etc.)
- **Validation**: Implement proper validation rules for all form fields
- **Relationships**: Use relationship managers for related model forms
- **File Uploads**: Use proper file upload fields with validation and storage configuration
- **Required Fields**: Clearly mark required fields with proper validation

### Table Standards
- **Columns**: Display relevant columns with proper formatting
- **Search**: Implement search functionality for searchable columns
- **Filters**: Add appropriate filters for common filtering needs
- **Actions**: Include standard table actions (edit, delete) and custom actions as needed
- **Bulk Actions**: Implement bulk actions where appropriate

### Navigation & Organization
- **Navigation Groups**: Organize resources into logical navigation groups
- **Menu Order**: Arrange menu items logically with frequently used items first
- **Icons**: Use consistent and meaningful icons for navigation items
- **Permissions**: Implement proper role-based access control for all resources

### Custom Actions & Widgets
- **Custom Actions**: Create custom actions for complex business operations
- **Widgets**: Use dashboard widgets for relevant metrics and quick actions
- **Pages**: Create custom pages for complex administrative interfaces
- **Modals**: Use modals for quick operations without page navigation

### Integration with Laravel Standards
- **Business Logic**: Delegate to existing Laravel services/actions, don't duplicate logic
- **Validation**: Use Laravel form requests or validation rules consistently
- **Policies**: Respect Laravel authorization policies
- **Events**: Fire Laravel events for significant admin operations

### Security & Permissions
- **Gate Policies**: Integrate with Laravel's authorization system
- **Role-based Access**: Implement proper role-based permissions
- **Resource Scoping**: Scope resources based on user permissions
- **Audit Logging**: Log important admin operations for audit trails

### User Experience
- **Responsive Design**: Ensure admin panel works on mobile and desktop
- **Loading States**: Provide proper loading indicators for operations
- **Error Handling**: Display user-friendly error messages
- **Success Messages**: Show clear success feedback for operations

### Performance
- **Lazy Loading**: Use lazy loading for large datasets
- **Caching**: Implement caching where appropriate
- **Database Optimization**: Optimize queries for admin operations
- **Asset Optimization**: Minimize and optimize frontend assets

## Required Dependencies
- FilamentPHP 3.x or higher
- Proper Laravel integration
- Appropriate Filament plugins for additional functionality