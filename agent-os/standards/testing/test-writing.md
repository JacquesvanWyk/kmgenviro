# Test-Driven Development (TDD) Standards

## Core TDD Mandate

**TDD IS REQUIRED FOR ALL FEATURES**: Every feature must follow Test-Driven Development methodology. This is not optional - tests are written BEFORE implementation, not after.

## TDD Workflow

### 1. Red-Green-Refactor Cycle
- **Red**: Write a failing test for the desired functionality
- **Green**: Write the minimum code needed to make the test pass
- **Refactor**: Improve the code while keeping the test green

### 2. Task Creation Order
When using Agent OS `create-tasks` command, ALWAYS create test tasks BEFORE implementation tasks:
```
Write [Test Type] Tests for [Feature]
Implement [Feature]
```

### 3. Verification Requirement
**No feature is complete until all tests pass**. The Agent OS verification step MUST run all relevant tests, and any feature with failing tests cannot be marked as complete.

## Technology-Specific Testing Standards

### Laravel/Pest Testing Standards

#### Unit Tests
- **Business Logic**: All service classes, action classes, and complex model methods must have unit tests
- **Isolation**: Use mocking for all external dependencies (APIs, databases, third-party packages)
- **Test Structure**: Use Pest's `it()` closures with descriptive test names
- **Assertions**: Test behavior, not implementation details

#### Feature Tests
- **API Endpoints**: All API endpoints must have feature tests
- **HTTP Methods**: Test all HTTP methods (GET, POST, PUT/PATCH, DELETE)
- **Status Codes**: Assert correct HTTP status codes (200, 201, 400, 401, 403, 404, 422, 500)
- **Response Structure**: Validate JSON response structure and data
- **Authentication/Authorization**: Test protected endpoints with and without proper permissions

#### Example Pest Test Structure
```php
// tests/Feature/UserApiTest.php
it('can create a new user', function () {
    $userData = User::factory()->raw();

    $response = $this->postJson('/api/v1/users', $userData)
        ->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'data' => ['id', 'name', 'email'],
            'message'
        ]);

    $this->assertDatabaseHas('users', ['email' => $userData['email']]);
});
```

### Nuxt/Vitest Testing Standards

#### Unit Tests
- **Composables**: Test all custom composables (`useAuth`, `useApi`, etc.)
- **Utilities**: Test utility functions and helpers
- **Stores**: Test Pinia store actions and getters
- **Business Logic**: Test isolated business logic

#### Component Tests
- **Component Rendering**: Test component rendering with different props
- **User Interactions**: Test button clicks, form submissions, etc.
- **State Changes**: Test component state changes
- **Mounting**: Use `mountSuspended` for proper Nuxt environment

#### Example Component Test
```typescript
// tests/components/UserForm.spec.ts
import { mountSuspended } from '@nuxt/test-utils/runtime'
import { describe, it, expect } from 'vitest'
import UserForm from '~/components/molecules/UserForm.vue'

describe('UserForm', () => {
  it('renders form fields correctly', async () => {
    const wrapper = await mountSuspended(UserForm)

    expect(wrapper.find('input[name="name"]').exists()).toBe(true)
    expect(wrapper.find('input[name="email"]').exists()).toBe(true)
  })

  it('emits submit event with form data', async () => {
    const wrapper = await mountSuspended(UserForm)

    await wrapper.find('input[name="name"]').setValue('John Doe')
    await wrapper.find('form').trigger('submit')

    expect(wrapper.emitted('submit')).toBeTruthy()
    expect(wrapper.emitted('submit')[0][0]).toEqual({
      name: 'John Doe',
      email: ''
    })
  })
})
```

### Flutter Testing Standards

#### Unit Tests
- **Business Logic**: Test all business logic and pure Dart functions
- **Use Cases**: Test domain layer use cases
- **Repository Logic**: Test repository implementations
- **Mocking**: Use `mockito` or `mocktail` for mocking dependencies

#### Widget Tests
- **UI Rendering**: Test widget rendering with different data
- **User Interactions**: Test button taps, form submissions, scrolling
- **State Changes**: Test widget state changes and rebuilds
- **Accessibility**: Test widget accessibility

#### Integration Tests
- **User Flows**: Test complete user journeys
- **API Integration**: Test real API communication
- **Navigation**: Test app navigation and routing

## Cross-Platform Testing Integration

### API Contract Testing
- **Contract Tests**: Write contract tests to ensure frontend and backend API compatibility
- **Mock Services**: Create mock services for frontend development
- **API Documentation**: Maintain API documentation with examples

### End-to-End Testing
- **User Workflows**: Test complete user workflows across all platforms
- **Data Flow**: Test data flow from mobile/web frontend through API to database
- **Error Scenarios**: Test error handling across the entire stack

## Test Organization

### File Structure
```
tests/
├── Unit/                   # Unit tests for all platforms
│   ├── Laravel/
│   ├── Nuxt/
│   └── Flutter/
├── Feature/               # Feature/integration tests
│   ├── API/
│   ├── Web/
│   └── Mobile/
├── E2E/                   # End-to-end tests
└── fixtures/              # Test data and utilities
```

### Test Data Management
- **Factories**: Use factories for creating test data
- **Fixtures**: Maintain reusable test fixtures
- **Database**: Use in-memory or test databases
- **Cleanup**: Clean up test data after each test

## Quality Standards

### Test Coverage
- **Minimum Coverage**: Maintain at least 80% code coverage
- **Critical Path Coverage**: 100% coverage for critical business logic
- **Integration Coverage**: Test all major integration points

### Test Performance
- **Fast Execution**: Keep unit tests under 1 second
- **Parallel Execution**: Run tests in parallel where possible
- **Test Isolation**: Tests should not depend on each other

### Continuous Integration
- **Automated Testing**: Run tests automatically on every commit
- **Pull Request Testing**: Require passing tests for merge
- **Coverage Reporting**: Generate and track coverage reports

## Required Testing Dependencies

### Laravel
- **Pest**: PHP testing framework
- **Laravel Dusk**: For browser testing (if needed)
- **Faker**: For generating test data
- **Mockery**: For mocking dependencies

### Nuxt
- **Vitest**: JavaScript testing framework
- **@nuxt/test-utils**: Nuxt testing utilities
- **@vue/test-utils**: Vue component testing
- **Playwright/Cypress**: For E2E testing

### Flutter
- **flutter_test**: Flutter's testing framework
- **mockito/mocktail**: For mocking dependencies
- **integration_test**: For integration testing
- **golden_toolkit**: For golden testing

This TDD approach ensures reliable, maintainable code across your entire tech stack while following professional development practices.
