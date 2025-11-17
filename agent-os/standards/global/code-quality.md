# Code Quality Standards

## Git Standards

### Commit Messages
- **Clear, Descriptive**: Write commit messages that clearly describe what changed and why
- **Imperative Mood**: Use imperative mood ("Add feature" not "Added feature")
- **No Claude Attribution**: Do not add "🤖 Generated with Claude Code" or similar attributions
- **No Co-Authored-By**: Do not add "Co-Authored-By: Claude" attributions

### Branch Strategy
- **Feature Branches**: Use feature branches for new development
- **Clear Naming**: Use descriptive branch names (feature/user-management, fix/api-validation)
- **Short-lived**: Keep branches small and merge frequently

## Code Style & Formatting

### Laravel/PHP Standards
- **PHP CS Fixer**: Use PHP CS Fixer for consistent code formatting
- **PSR Standards**: Follow PSR-1, PSR-2, and PSR-4 standards
- **Type Declarations**: Use strict typing and declare return types
- **Documentation**: Document complex methods with PHPDoc

### Nuxt/JavaScript Standards
- **Prettier**: Use Prettier for consistent code formatting
- **ESLint**: Use ESLint with strict rules for code quality
- **TypeScript**: Use TypeScript throughout the application
- **Import Organization**: Organize imports logically and remove unused imports

### Flutter/Dart Standards
- **Dart Format**: Use `dart format` for consistent formatting
- **Strict Analysis**: Use strict analysis options
- **Linting**: Enable and follow Flutter linting rules
- **Documentation**: Document public APIs with DartDoc

## Code Organization

### File Naming
- **Consistent Patterns**: Use consistent naming patterns across the project
- **Descriptive Names**: Use descriptive names that indicate purpose
- **Framework Conventions**: Follow framework-specific naming conventions

### Class/Function Organization
- **Single Responsibility**: Each class/function should have one clear purpose
- **Logical Grouping**: Group related functionality together
- **Dependency Direction**: Dependencies should point inward, not circular

### Comments & Documentation
- **Why, Not What**: Comment why something is done, not what is done
- **Complex Logic**: Document complex business logic and algorithms
- **Public APIs**: Document all public interfaces and their usage

## Error Handling

### Graceful Degradation
- **User-Friendly Messages**: Display clear, user-friendly error messages
- **Logging**: Log technical errors for debugging
- **Fallbacks**: Provide fallback behavior when possible
- **Recovery**: Allow users to recover from error states

### Exception Handling
- **Specific Exceptions**: Use specific exception types
- **Proper Catching**: Catch exceptions at appropriate levels
- **Resource Cleanup**: Ensure proper cleanup of resources
- **Error Context**: Include relevant context in error messages

## Performance Standards

### Database Optimization
- **Query Efficiency**: Write efficient database queries
- **Indexing**: Add appropriate indexes for performance
- **N+1 Prevention**: Prevent N+1 query problems
- **Connection Management**: Manage database connections properly

### Frontend Performance
- **Bundle Optimization**: Optimize bundle sizes and code splitting
- **Image Optimization**: Use optimized images and lazy loading
- **Caching**: Implement appropriate caching strategies
- **Network Optimization**: Minimize network requests and optimize payloads

### Mobile Performance
- **Memory Management**: Manage memory usage carefully
- **Battery Usage**: Optimize for battery efficiency
- **Startup Time**: Minimize app startup time
- **Smooth UI**: Maintain 60fps UI animations

## Security Standards

### Input Validation
- **Server-Side Validation**: Never trust client input, validate on server
- **Sanitization**: Sanitize all user inputs
- **Type Checking**: Validate input types and formats
- **Length Limits**: Enforce appropriate length limits

### Authentication & Authorization
- **Secure Storage**: Store authentication tokens securely
- **Proper Authorization**: Implement proper role-based access control
- **Session Management**: Manage sessions securely
- **Logout Security**: Implement proper logout functionality

### Data Protection
- **Encryption**: Encrypt sensitive data at rest and in transit
- **PII Handling**: Handle personally identifiable information carefully
- **API Security**: Secure API endpoints with proper authentication
- **Environment Variables**: Never commit secrets to version control

## Testing Quality

### Test Maintenance
- **Updating Tests**: Keep tests updated with code changes
- **Test Coverage**: Maintain adequate test coverage
- **Test Organization**: Organize tests logically
- **Test Data**: Use realistic test data

### CI/CD Integration
- **Automated Testing**: Run tests automatically on commits
- **Quality Gates**: Set quality gates for code merging
- **Deployment Testing**: Test in staging environments
- **Monitoring**: Monitor application health in production

## Code Review Standards

### Review Process
- **Peer Review**: All code changes require peer review
- **Automated Checks**: Require passing automated checks
- **Review Checklist**: Use review checklists for consistency
- **Knowledge Sharing**: Use reviews as knowledge sharing opportunities

### Review Focus Areas
- **Functionality**: Does the code work as intended?
- **Performance**: Is the code performant?
- **Security**: Is the code secure?
- **Maintainability**: Is the code maintainable?
- **Testing**: Are tests adequate and appropriate?

## Tool Configuration

### Required Tools
- **Laravel**: PHPStan, Pest, PHP CS Fixer
- **Nuxt**: ESLint, Prettier, Vitest, TypeScript compiler
- **Flutter**: Dart analyzer, flutter_test, dart format
- **Git**: Pre-commit hooks, automated formatting

### Configuration Files
- Maintain consistent configuration across projects
- Use strict settings for quality enforcement
- Include all team members in configuration decisions
- Document tool choices and configurations

## Continuous Improvement

### Regular Assessment
- **Code Quality Metrics**: Track and improve quality metrics
- **Technical Debt**: Identify and address technical debt
- **Performance Monitoring**: Monitor and improve performance
- **Security Audits**: Conduct regular security audits

### Learning & Development
- **Stay Updated**: Keep up with best practices and new tools
- **Knowledge Sharing**: Share knowledge within the team
- **Refactoring**: Regularly refactor and improve code
- **Documentation**: Maintain and improve documentation