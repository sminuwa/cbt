# CBT System - Project Structure

This document outlines the improved folder structure and organization of the CBT (Computer-Based Testing) system following Laravel best practices.

## Directory Structure

### Controllers (`app/Http/Controllers/`)

Controllers are now organized by domain functionality:

```
app/Http/Controllers/
├── Admin/              # Administrative controllers
├── Api/                # API controllers
│   └── V1/            # API version 1
├── Auth/              # Authentication controllers
├── Candidate/         # Candidate-related controllers
│   └── Auth/         # Candidate authentication
├── Dashboard/         # Dashboard controllers
├── Exam/              # Exam management controllers
├── Question/          # Question management controllers
├── Report/            # Reporting controllers
└── Setup/             # System setup controllers
```

#### Key Controllers:
- **Dashboard/DashboardController**: Main admin dashboard
- **Exam/TestConfigController**: Test configuration management
- **Question/QuestionController**: Question authoring and management
- **Report/ReportController**: Report generation and analysis
- **Setup/SetupController**: System configuration and data synchronization

### Models (`app/Models/`)

Models are organized by business domain:

```
app/Models/
├── Candidate/         # Candidate-related models
│   ├── Candidate.php
│   └── CandidateSubject.php
├── Exam/              # Exam-related models
│   ├── ExamType.php
│   ├── TestConfig.php
│   ├── TestSection.php
│   ├── Scheduling.php
│   └── ScheduledCandidate.php
├── Question/          # Question-related models
│   ├── QuestionBank.php
│   ├── AnswerOption.php
│   └── QuestionPreviewer.php
├── System/            # System configuration models
│   ├── Centre.php
│   ├── Venue.php
│   ├── Subject.php
│   └── Topic.php
├── User/              # User and permission models
│   ├── User.php
│   ├── Role.php
│   └── Permission.php
└── [Other models...]  # Remaining models to be organized
```

### Services (`app/Services/`)

Business logic is extracted into service classes:

```
app/Services/
├── BaseService.php           # Base service with common functionality
├── Auth/                     # Authentication services
├── Candidate/                # Candidate management services
├── Dashboard/                # Dashboard data services
├── Exam/                     # Exam management services
│   └── ExamService.php      # Main exam service
├── Question/                 # Question management services
└── Report/                   # Report generation services
```

### Repositories (`app/Repositories/`)

Data access layer following the Repository pattern:

```
app/Repositories/
├── Interfaces/
│   └── RepositoryInterface.php
└── Eloquent/
    ├── BaseRepository.php
    ├── ExamRepository.php
    ├── QuestionRepository.php
    └── CandidateRepository.php
```

### HTTP Layer (`app/Http/`)

Organized HTTP-related classes:

```
app/Http/
├── Controllers/      # Controllers (as described above)
├── Middleware/       # Custom middleware
├── Requests/         # Form request validation classes
│   ├── Admin/
│   ├── Candidate/
│   ├── Exam/
│   └── Question/
├── Resources/        # API resources for data transformation
│   ├── Admin/
│   ├── Candidate/
│   ├── Exam/
│   └── Question/
└── [Other directories...]
```

### Events and Listeners (`app/Events/`, `app/Listeners/`)

Event-driven architecture support:

```
app/Events/
├── Exam/
│   ├── ExamStarted.php
│   ├── ExamCompleted.php
│   └── QuestionAnswered.php
├── Candidate/
│   └── CandidateRegistered.php
└── Question/
    └── QuestionCreated.php

app/Listeners/
├── Exam/
├── Candidate/
└── Question/
```

### Jobs (`app/Jobs/`)

Queue jobs for asynchronous processing:

```
app/Jobs/
├── Exam/
│   ├── ProcessExamResults.php
│   └── GenerateExamReport.php
├── Question/
│   └── ImportQuestions.php
└── Report/
    └── GenerateReport.php
```

### Traits (`app/Traits/`)

Reusable functionality:

```
app/Traits/
├── Exam/
│   └── ExamHelpers.php
├── Question/
│   └── QuestionHelpers.php
└── Candidate/
    └── CandidateHelpers.php
```

## Key Improvements

### 1. Domain-Driven Organization
- Controllers, models, and services are grouped by business domain
- Related functionality is co-located for better maintainability
- Clear separation of concerns

### 2. Service Layer
- Business logic extracted from controllers
- Reusable service classes with proper error handling
- Database transactions handled consistently

### 3. Repository Pattern
- Data access abstraction
- Easier testing and mocking
- Consistent query interfaces

### 4. Proper Namespacing
- All classes use appropriate namespaces
- Import statements updated throughout the application
- PSR-4 autoloading compliance

### 5. Event-Driven Architecture
- Support for events and listeners
- Decoupled components
- Better extensibility

### 6. Queue Support
- Background job processing
- Improved performance for heavy operations
- Better user experience

## Migration Notes

### Controller Updates
- All controller namespaces have been updated
- Route definitions updated to reflect new namespaces
- Import statements corrected throughout

### Model Organization
- Models moved to domain-specific folders
- Namespaces updated but class names remain the same
- Database relationships preserved

### Service Integration
- ExamService created with core exam functionality
- BaseService provides common utilities
- Error handling and transaction management standardized

## Future Enhancements

### Planned Additions
1. **Complete Repository Implementation**: Full repository pattern for all models
2. **Event System**: Complete event/listener implementation
3. **Job Queue**: Background processing for heavy operations
4. **API Resources**: Standardized API response formatting
5. **Form Requests**: Validation layer for all forms
6. **Middleware**: Additional security and validation middleware

### Performance Optimizations
1. **Eager Loading**: Optimize database queries
2. **Caching**: Implement Redis/database caching
3. **Queue Workers**: Background processing
4. **Database Indexing**: Optimize database performance

## Development Guidelines

### Adding New Features
1. Create appropriate controller in domain folder
2. Implement service layer for business logic
3. Use repository pattern for data access
4. Add events/listeners for decoupled functionality
5. Create form requests for validation
6. Add appropriate tests

### Code Organization
- Keep controllers thin (only HTTP concerns)
- Put business logic in services
- Use repositories for data access
- Leverage events for cross-cutting concerns
- Write comprehensive tests

This structure provides a solid foundation for scaling the CBT system while maintaining clean, maintainable code that follows Laravel and PHP best practices.

