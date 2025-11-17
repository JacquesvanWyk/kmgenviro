# Nuxt Frontend Standards

## Architecture & Design Patterns

### Component Architecture (Atomic Design)
- **Atoms**: Basic building blocks (buttons, inputs, labels)
- **Molecules**: Simple combinations of atoms (form groups, search bars)
- **Organisms**: Complex components (headers, sidebars, data tables)
- **Templates**: Page layouts that structure organisms
- **Pages**: Actual page implementations using templates

### Directory Structure
```
components/
├── atoms/          # Basic UI elements
├── molecules/      # Component combinations
├── organisms/      # Complex components
└── layouts/        # Page layout components
composables/        # Reusable composition functions
pages/             # File-based routing
stores/            # Pinia stores
middleware/        # Route middleware
plugins/           # Nuxt plugins
utils/             # Utility functions
```

### State Management with Pinia
- **Stores**: Create stores for different domains (auth, users, products, etc.)
- **State**: Use reactive state with proper TypeScript typing
- **Actions**: Use actions for state mutations and async operations
- **Getters**: Use getters for computed derived state
- **Persistence**: Use `pinia-plugin-persistedstate` for local storage persistence

### Data Fetching Patterns
- **useFetch**: Use Nuxt's `useFetch` for component-level data fetching
- **$fetch**: Use `$fetch` for API calls outside components
- **Composables**: Create custom composables for reusable API logic
- **Error Handling**: Implement proper error handling in all API calls
- **Loading States**: Show loading states during data fetching

### Component Standards
- **Single Responsibility**: Each component should have one clear purpose
- **Props Validation**: Use proper prop validation with TypeScript
- **Emits**: Define clear emit events with proper typing
- **Slots**: Use slots for flexible component composition
- **Composition API**: Use Composition API with `<script setup>` syntax

### Styling & CSS
- **CSS Framework**: Use Tailwind CSS for utility-first styling
- **Component Styling**: Prefer utility classes over custom CSS
- **Responsive Design**: Mobile-first responsive design approach
- **CSS Variables**: Use CSS variables for design tokens
- **Dark Mode**: Support dark mode where appropriate

### Routing & Navigation
- **File-based Routing**: Use Nuxt's file-based routing system
- **Dynamic Routes**: Use dynamic routes with proper parameter validation
- **Route Guards**: Use middleware for authentication and authorization
- **Navigation**: Use `<NuxtLink>` for internal navigation
- **SEO**: Implement proper meta tags and SEO optimization

### TypeScript Integration
- **Type Safety**: Use TypeScript throughout the application
- **Interface Definitions**: Define interfaces for API responses and component props
- **Composition Functions**: Use properly typed composables
- **Configuration**: Configure `nuxt.config.ts` for optimal TypeScript support

### Performance Optimization
- **Code Splitting**: Use Nuxt's automatic code splitting
- **Image Optimization**: Use Nuxt Image for optimized images
- **Lazy Loading**: Implement lazy loading for components and images
- **Bundle Analysis**: Monitor bundle size and optimize accordingly

### Integration with Laravel API
- **API Base URL**: Configure API base URL in `.env` files
- **Authentication**: Implement proper token-based authentication
- **Error Handling**: Handle API errors consistently across the application
- **Request Interceptors**: Use axios interceptors for authentication headers
- **Data Validation**: Validate API responses on the frontend

### Accessibility (a11y)
- **Semantic HTML**: Use proper semantic HTML elements
- **ARIA Labels**: Add appropriate ARIA labels for screen readers
- **Keyboard Navigation**: Ensure keyboard accessibility
- **Color Contrast**: Maintain proper color contrast ratios
- **Focus Management**: Implement proper focus management

### Development Best Practices
- **ESLint/Prettier**: Use ESLint and Prettier for code formatting
- **Environment Variables**: Use `.env` files for environment-specific configuration
- **Logging**: Implement proper error logging
- **Testing**: Write comprehensive tests (covered in testing standards)
- **Documentation**: Document complex components and logic

## Required Dependencies
- Nuxt 3.x or higher
- TypeScript
- Pinia for state management
- Tailwind CSS for styling
- Vitest for testing
- Nuxt Test Utils for component testing
- Axios or useFetch for API communication