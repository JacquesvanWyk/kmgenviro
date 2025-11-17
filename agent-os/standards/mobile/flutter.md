# Flutter Mobile Standards

## Architecture & Design Patterns

### State Management
- **Preferred State Management**: Use Riverpod or BLoC for complex state management
- **Simple State**: Use `StatefulWidget` with `setState()` for simple local state
- **Repository Pattern**: Use repository pattern for data layer abstraction
- **Dependency Injection**: Use `get_it` or `riverpod` for dependency injection

### Project Structure
```
lib/
├── core/                    # Core utilities and constants
│   ├── constants/          # App constants
│   ├── errors/             # Error handling
│   ├── network/            # Network configuration
│   └── utils/              # Utility functions
├── data/                   # Data layer
│   ├── datasources/        # Data sources (API, local)
│   ├── models/             # Data models
│   └── repositories/       # Repository implementations
├── domain/                 # Domain layer
│   ├── entities/           # Business entities
│   ├── repositories/       # Repository interfaces
│   └── usecases/           # Business logic use cases
├── presentation/           # Presentation layer
│   ├── pages/              # Screens/pages
│   ├── widgets/            # Reusable widgets
│   ├── providers/          # State management providers
│   └── themes/             # App theming
└── main.dart              # App entry point
```

### Widget Standards
- **Composition over Inheritance**: Prefer widget composition over complex inheritance
- **Stateless vs Stateful**: Use `StatelessWidget` when possible, `StatefulWidget` only when needed
- **Const Constructors**: Use const constructors for widgets that don't change
- **Small Widgets**: Keep widgets small and focused on single responsibility
- **Reusable Widgets**: Create reusable widgets for common UI patterns

### Navigation Standards
- **Navigator 2.0**: Use Navigator 2.0 for complex routing scenarios
- **Named Routes**: Use named routes for simple navigation
- **Route Guards**: Implement route guards for authentication
- **Deep Linking**: Support deep linking where appropriate
- **Navigation State**: Maintain navigation state properly

### API Integration
- **HTTP Client**: Use `dio` or `http` package for API communication
- **Dart Models**: Create Dart models for API responses with proper serialization
- **Error Handling**: Implement comprehensive error handling for API calls
- **Authentication**: Handle token-based authentication with proper storage
- **Offline Support**: Consider offline functionality where appropriate

### Theming & Design
- **Material Design 3**: Use Material Design 3 components and guidelines
- **Consistent Theming**: Implement consistent theming using `ThemeData`
- **Custom Colors**: Define custom color schemes in app themes
- **Typography**: Use consistent typography scales
- **Dark Mode**: Support dark mode with proper theme switching

### Performance Optimization
- **Widget Rebuilding**: Minimize unnecessary widget rebuilds
- **Image Optimization**: Use optimized images and proper caching
- **Memory Management**: Properly dispose of resources and controllers
- **Build Optimization**: Use `--release` builds for production
- **Lazy Loading**: Implement lazy loading for large lists

### Platform Integration
- **Platform Channels**: Use platform channels for native functionality
- **Permissions**: Handle app permissions properly
- **Background Processing**: Implement background tasks where needed
- **Push Notifications**: Integrate push notifications using `firebase_messaging`
- **Local Storage**: Use appropriate local storage solutions (SharedPreferences, Hive)

### Testing Strategy
- **Unit Tests**: Test business logic and pure Dart functions
- **Widget Tests**: Test individual widgets and user interactions
- **Integration Tests**: Test complete user flows
- **Golden Tests**: Use golden tests for UI consistency
- **Mock Dependencies**: Mock external dependencies in tests

### Code Quality
- **Dart Style**: Follow official Dart style guidelines
- **Linting**: Use strict linting rules (`flutter analyze`)
- **Documentation**: Document complex logic and public APIs
- **Constants**: Use constants for magic strings and numbers
- **Null Safety**: Use null safety throughout the codebase

### Security Best Practices
- **API Keys**: Store API keys securely using `.env` files
- **Certificate Pinning**: Implement certificate pinning for API security
- **Data Encryption**: Encrypt sensitive data stored locally
- **Authentication**: Secure authentication token storage
- **Root Detection**: Consider root/jailbreak detection for sensitive apps

### Accessibility
- **Semantics**: Use proper semantics widgets for screen readers
- **Font Scaling**: Support dynamic font scaling
- **High Contrast**: Support high contrast mode
- **Focus Management**: Implement proper focus management
- **VoiceOver/TalkBack**: Ensure compatibility with screen readers

## Required Dependencies
- Flutter SDK (latest stable)
- Riverpod or BLoC for state management
- Dio for HTTP client
- GoRouter for navigation
- JSON Annotation for model serialization
- Retrofit for type-safe API calls
- Hive for local storage
- Firebase for push notifications (if needed)