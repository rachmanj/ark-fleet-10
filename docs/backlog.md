**Purpose**: Future features and improvements prioritized by value
**Last Updated**: 2025-10-30

# ARKFleet Feature Backlog

## Next Sprint (High Priority)

### Email Notifications for Document Expiry

-   **Description**: Automated email alerts when equipment documents (BPKB, STNK, insurance) are approaching expiration
-   **User Value**: Proactive compliance management, reduces risk of expired documents
-   **Current State**: Dashboard shows expiring documents only when user visits
-   **Effort**: Medium (2-3 days)
-   **Dependencies**: Mail server configuration, Laravel Mail setup
-   **Files Affected**:
    -   `app/Mail/DocumentExpiryNotification.php` (new)
    -   `app/Console/Commands/CheckDocumentExpiry.php` (new scheduled command)
    -   `config/mail.php`
    -   Task scheduler in `app/Console/Kernel.php`
-   **Implementation Notes**:
    -   Daily cron job checking documents expiring in 30/15/7 days
    -   Email to equipment PIC and department head
    -   Include document details and renewal instructions

### Equipment Maintenance Schedule Module

-   **Description**: Track scheduled maintenance, service history, and preventive maintenance for equipment
-   **User Value**: Reduces downtime, extends equipment life, compliance with maintenance schedules
-   **Current State**: No maintenance tracking (only documents)
-   **Effort**: Large (1-2 weeks)
-   **Dependencies**: None
-   **Database Changes**:
    -   `maintenance_schedules` table (equipment_id, maintenance_type, interval_km/hours, last_maintenance_date)
    -   `maintenance_records` table (equipment_id, schedule_id, date, cost, supplier_id, notes, attachments)
-   **Files Affected**:
    -   Migrations for new tables
    -   Models: MaintenanceSchedule, MaintenanceRecord
    -   Controllers: MaintenanceController
    -   Views: maintenance index, create, edit, history
    -   Reports: upcoming maintenance, overdue maintenance
-   **Features**:
    -   Define maintenance schedules (oil change every 200 hours, inspection every 6 months)
    -   Record completed maintenance
    -   Alert for overdue maintenance
    -   Maintenance cost tracking
    -   Integration with equipment status (can't transfer equipment due for maintenance)

### Equipment GPS Tracking Integration

-   **Description**: Integrate with GPS tracking devices to show real-time equipment location
-   **User Value**: Verify equipment is at assigned project, prevent theft, optimize utilization
-   **Effort**: Large (2-3 weeks including vendor integration)
-   **Dependencies**: GPS hardware vendor, API access
-   **Files Affected**:
    -   `app/Services/GpsTrackingService.php` (new)
    -   Equipment model (add lat/long, last_location_update fields)
    -   Dashboard map view (new)
    -   Equipment show page (map widget)
-   **Technical Considerations**:
    -   Third-party GPS API integration
    -   Database fields for coordinates
    -   Real-time vs periodic updates
    -   Map display (Google Maps, Leaflet, etc.)

---

## Upcoming Features (Medium Priority)

### Mobile Application for Field Workers

-   **Description**: Mobile app (iOS/Android) for field workers to report equipment status, submit photos, log issues
-   **User Value**: Real-time updates from field, reduce paperwork, faster issue reporting
-   **Effort**: Very Large (2-3 months)
-   **Dependencies**: Requires API development (see Technical Improvements section)
-   **Features**:
    -   View assigned equipment
    -   Update equipment status
    -   Upload photos from field
    -   Report breakdowns
    -   View equipment documents
    -   Offline mode for remote locations
-   **Technology Options**:
    -   React Native (cross-platform)
    -   Flutter (cross-platform)
    -   Native iOS/Android apps
-   **Prerequisites**:
    -   Complete API development first
    -   API authentication (Sanctum tokens)
    -   Image upload API
    -   Offline sync strategy

### Advanced Reporting & Analytics Dashboard

-   **Description**: Executive dashboard with KPIs, charts, trends for fleet management
-   **User Value**: Data-driven decisions, identify underutilized equipment, cost optimization
-   **Effort**: Medium (1 week)
-   **Charts/Metrics**:
    -   Equipment utilization rate by project
    -   Equipment downtime analysis
    -   Maintenance cost trends
    -   Document compliance rate
    -   Equipment age distribution
    -   Transfer frequency heatmap
    -   Cost per equipment hour
-   **Files Affected**:
    -   `app/Http/Controllers/AnalyticsController.php` (new)
    -   Dashboard view enhancements
    -   JavaScript charting library (Chart.js or similar)
-   **Database**: Aggregation queries on existing data (no schema changes)

### Equipment Reservation System

-   **Description**: Allow project managers to reserve equipment for future projects before transfer
-   **User Value**: Better resource planning, prevent double-booking, optimize equipment allocation
-   **Effort**: Medium (4-5 days)
-   **Database Changes**:
    -   `equipment_reservations` table (equipment_id, project_id, reserved_by, start_date, end_date, status)
-   **Features**:
    -   Reserve equipment for date range
    -   Approval workflow for reservations
    -   Calendar view of equipment availability
    -   Prevent transfers during reservation period
    -   Email notifications for reservation requests

### Equipment Photos Gallery Enhancement

-   **Description**: Improve equipment photo management with albums, tags, condition tracking
-   **Current State**: Basic photo upload/delete functionality exists
-   **User Value**: Better visual documentation, condition history, insurance claims support
-   **Effort**: Small (2-3 days)
-   **Enhancements**:
    -   Photo albums by date or event (acquisition, maintenance, damage)
    -   Tags for photo categorization (before/after, damage, routine)
    -   Photo comparison tool (condition changes over time)
    -   Thumbnail generation for faster loading
    -   Bulk upload capability
    -   Export photos to PDF for reports

### Document OCR and Auto-Fill

-   **Description**: Scan document images (BPKB, STNK) and auto-extract data using OCR
-   **User Value**: Reduce data entry time, minimize errors, faster document processing
-   **Effort**: Medium-Large (1-2 weeks)
-   **Dependencies**: OCR service (Google Vision API, Tesseract, AWS Textract)
-   **Features**:
    -   Upload document scan/photo
    -   OCR extracts: document number, issue date, expiry date, issuing authority
    -   Pre-fill document form with extracted data
    -   User review and correct before saving
-   **Technical Considerations**:
    -   External API costs
    -   Accuracy verification
    -   Support for Indonesian documents

---

## Ideas & Future Considerations (Low Priority)

### Equipment Depreciation Tracking

-   **Concept**: Calculate and track equipment depreciation for accounting purposes
-   **Potential Value**: Financial reporting, asset valuation, tax compliance
-   **Complexity**: Medium
-   **Requirements**:
    -   Depreciation method configuration (straight-line, declining balance)
    -   Acquisition cost and date tracking
    -   Salvage value estimation
    -   Monthly/yearly depreciation calculation
    -   Integration with accounting system (if any)

### Fuel Consumption Tracking

-   **Concept**: Log fuel consumption per equipment for cost tracking and efficiency analysis
-   **Potential Value**: Identify fuel-inefficient equipment, detect theft/wastage, budget forecasting
-   **Complexity**: Medium
-   **Requirements**:
    -   `fuel_records` table (equipment_id, date, liters, cost, odometer/hours, project_id)
    -   Fuel consumption reports (cost per hour, efficiency trends)
    -   Integration with project cost allocation
    -   Anomaly detection for unusual consumption

### Integration with Accounting System

-   **Concept**: Sync equipment costs (purchase, maintenance, documents) with accounting software
-   **Potential Value**: Automated financial reporting, eliminate duplicate entry
-   **Complexity**: Large
-   **Options**:
    -   Export to Excel for manual import
    -   Direct API integration with accounting software (if available)
    -   Generate journal entries for accountant

### Equipment QR Code System

-   **Concept**: Generate QR codes for each equipment, scan to view details or report issues
-   **Potential Value**: Faster equipment lookup, mobile-friendly, reduce manual data entry
-   **Complexity**: Small-Medium
-   **Features**:
    -   Generate unique QR code per equipment
    -   Print QR stickers for equipment
    -   Mobile scan to view equipment page
    -   Scan to log maintenance or report issue
    -   QR code inventory management

### Multi-Language Support (Bahasa + English)

-   **Concept**: Support both Indonesian and English interface
-   **Potential Value**: Accessibility for international staff, global expansion
-   **Complexity**: Medium
-   **Implementation**: Laravel localization, translation files
-   **Effort**: 1 week + ongoing translation

### Equipment Utilization Heat Map

-   **Concept**: Visual map showing which projects have high/low equipment density
-   **Potential Value**: Identify over/under-resourced projects, optimize allocation
-   **Complexity**: Medium
-   **Technology**: Interactive map (Google Maps, Leaflet) with equipment markers colored by density

---

## Technical Improvements

### Performance & Code Quality

#### API Development & Documentation

-   **Priority**: High (if mobile app planned)
-   **Effort**: Large (2-3 weeks)
-   **Impact**: High (enables mobile, third-party integrations)
-   **Tasks**:
    -   Create API Resources for all models
    -   RESTful endpoints for Equipment, Moving, Document, Project
    -   API authentication (Sanctum tokens)
    -   Rate limiting
    -   API versioning (v1)
    -   OpenAPI/Swagger documentation
    -   Postman collection for testing

#### Test Suite Development

-   **Priority**: High
-   **Effort**: Medium (ongoing, 1-2 weeks initial)
-   **Impact**: High (prevents regressions, enables confident refactoring)
-   **Coverage Goals**:
    -   Feature tests: 60%+ coverage of critical paths
    -   Unit tests: Model relationships, business logic
    -   API tests (when API developed)
    -   Browser tests for key workflows (Laravel Dusk)
-   **Areas to Test**:
    -   Equipment CRUD operations
    -   Moving/Transfer creation and validation
    -   Document expiry calculation logic
    -   User authentication and authorization
    -   Data export (Excel, PDF)

#### Database Query Optimization

-   **Priority**: Medium
-   **Effort**: Small (3-4 days)
-   **Impact**: Medium (faster page loads)
-   **Optimizations**:
    -   Review all DataTables queries for N+1 issues
    -   Add eager loading where missing
    -   Database indexing for frequent queries (current_project_id, due_date, etc.)
    -   Cache frequently accessed data (plant types, statuses, etc.)
    -   Query result caching for reports

#### Code Refactoring - Service Layer

-   **Priority**: Medium
-   **Effort**: Medium (1 week)
-   **Impact**: Medium (better organization, testability)
-   **Rationale**: Controllers currently contain business logic, should be extracted to services
-   **Services to Create**:
    -   `EquipmentService` - Equipment business logic
    -   `MovingService` - Transfer workflow logic
    -   `DocumentService` - Document expiry and renewal logic
    -   `ReportService` - Report generation logic
-   **Benefits**:
    -   Reusable business logic
    -   Easier to test (mock services)
    -   Cleaner controllers
    -   Can be used by API and web routes

#### Automated Cart Cleanup Job

-   **Priority**: Medium
-   **Effort**: Small (1 day)
-   **Impact**: Low (prevents orphaned cart flags)
-   **Implementation**:
    -   Scheduled job to clear `cart_flag` older than 24 hours
    -   Run daily at midnight
    -   Log cleanup actions

#### Form Request Validation Extraction

-   **Priority**: Low
-   **Effort**: Small (2-3 days)
-   **Impact**: Low (cleaner code)
-   **Current**: Inline validation in controllers
-   **Goal**: Extract to Form Request classes
-   **Files**: `StoreEquipmentRequest` (exists), create others for Moving, Document, etc.

---

### Infrastructure

#### Automated Database Backups

-   **Priority**: High
-   **Effort**: Small (1 day)
-   **Impact**: High (data protection)
-   **Implementation**:
    -   Laravel Backup package (Spatie)
    -   Daily database + storage backups
    -   Backup to cloud (S3, Dropbox, etc.)
    -   Automated backup health checks
    -   Backup restoration testing procedure

#### CI/CD Pipeline

-   **Priority**: Medium
-   **Effort**: Medium (2-3 days)
-   **Impact**: Medium (faster deployments, fewer errors)
-   **Components**:
    -   GitHub Actions or GitLab CI
    -   Automated testing on push
    -   Code quality checks (Laravel Pint)
    -   Automated deployment to staging
    -   Manual approval for production deployment

#### Docker Containerization

-   **Priority**: Low
-   **Effort**: Medium (3-4 days)
-   **Impact**: Medium (easier deployment, consistency)
-   **Current**: Laravel Sail available but may not be used
-   **Goal**: Production Docker setup
-   **Components**:
    -   PHP-FPM container
    -   Nginx container
    -   MySQL container
    -   Redis container (if caching implemented)
    -   Docker Compose for orchestration

#### Monitoring & Error Tracking

-   **Priority**: Medium
-   **Effort**: Small (1-2 days)
-   **Impact**: High (proactive issue detection)
-   **Tools**:
    -   Sentry for error tracking
    -   Laravel Telescope for local debugging
    -   Server monitoring (CPU, memory, disk)
    -   Application performance monitoring (APM)
    -   Uptime monitoring

#### Laravel Version Upgrade (10 → 11 → 12)

-   **Priority**: Low (deferred until 2025-08)
-   **Effort**: Medium (3-5 days)
-   **Impact**: Low (unless new features needed)
-   **Rationale**: Laravel 10 LTS until August 2025
-   **Blockers**: Need comprehensive test suite first
-   **See**: docs/decisions.md - "Deferred: Laravel Version Upgrade"

---

## User Experience Improvements

### Dashboard Customization

-   **Description**: Allow users to customize dashboard widgets based on role
-   **Effort**: Medium
-   **Features**: Show/hide widgets, rearrange layout, save preferences

### Advanced Search & Filtering

-   **Description**: Global search across equipment, documents, movings with advanced filters
-   **Effort**: Medium
-   **Current**: Basic DataTables filtering
-   **Enhancement**: Full-text search, saved filter presets, export filtered results

### Bulk Operations

-   **Description**: Select multiple equipment items and perform bulk actions
-   **Effort**: Small-Medium
-   **Actions**: Bulk status update, bulk transfer, bulk export, bulk delete

### Equipment Comparison Tool

-   **Description**: Side-by-side comparison of equipment specifications and history
-   **Effort**: Small
-   **Value**: Easier equipment selection for projects

### Dark Mode Theme

-   **Description**: Dark theme option for AdminLTE interface
-   **Effort**: Small (1-2 days)
-   **Value**: User preference, reduced eye strain

### Keyboard Shortcuts

-   **Description**: Keyboard shortcuts for common actions
-   **Effort**: Small
-   **Examples**: Ctrl+N for new equipment, Ctrl+S for save, / for search

---

## Integration Opportunities

### WhatsApp Notifications

-   **Description**: Send document expiry alerts via WhatsApp
-   **Effort**: Medium
-   **Value**: Higher engagement than email (Indonesian market)
-   **Tool**: Twilio WhatsApp API or Fonnte

### Microsoft Excel/Word Templates

-   **Description**: Export documents and reports using custom Excel/Word templates
-   **Effort**: Small-Medium
-   **Tool**: PHPSpreadsheet, PHPWord
-   **Value**: Professional-looking exports matching company branding

### Google Drive Integration

-   **Description**: Store document attachments and photos in Google Drive
-   **Effort**: Medium
-   **Value**: Unlimited storage, better file management

### Equipment Vendor Integration

-   **Description**: Pull equipment specs automatically from manufacturer databases
-   **Effort**: Large
-   **Value**: Accurate data, reduced manual entry
-   **Challenge**: Vendor API availability

---

## Security Enhancements

### Two-Factor Authentication (2FA)

-   **Priority**: Medium
-   **Effort**: Small (2-3 days)
-   **Impact**: High (security improvement)
-   **Implementation**: Laravel Fortify or custom TOTP

### Role-Based Menu Visibility

-   **Priority**: Low
-   **Effort**: Small (1 day)
-   **Impact**: Low (better UX)
-   **Current**: All menu items visible to all users
-   **Goal**: Hide menu items based on permissions

### Audit Log Enhancements

-   **Priority**: Low
-   **Effort**: Small
-   **Impact**: Low (better compliance)
-   **Enhancements**:
    -   Track all model changes (old value → new value)
    -   IP address and user agent logging
    -   Export audit logs to Excel

### File Upload Security

-   **Priority**: Medium
-   **Effort**: Small
-   **Impact**: High (prevent malware)
-   **Enhancements**:
    -   Validate file types strictly
    -   Scan uploaded files for viruses
    -   Limit file sizes
    -   Store files outside public directory

---

## Backlog Management

### Adding New Items

When adding backlog items, include:

1. **Description**: What the feature does
2. **User Value**: Why users want this
3. **Effort**: Small/Medium/Large estimate
4. **Dependencies**: Prerequisites
5. **Files Affected**: Which parts of codebase change

### Prioritization Criteria

Items move up priority based on:

-   **User Requests**: How many users ask for it
-   **Business Value**: Revenue impact or cost savings
-   **Risk Reduction**: Security, compliance, data protection
-   **Effort**: Quick wins (high value, low effort) prioritized
-   **Dependencies**: Blockers for other features

### Grooming Schedule

Review backlog quarterly:

1. Archive completed items
2. Reprioritize based on feedback
3. Add new ideas from user requests
4. Update effort estimates as understanding improves
5. Move deferred items to backlog from decisions.md

---

## Notes

### Quick Wins (High Value, Low Effort)

1. Email notifications for document expiry (Medium effort, High value)
2. Equipment QR codes (Small effort, Medium value)
3. Dashboard dark mode (Small effort, Medium value)
4. Automated database backups (Small effort, High value)
5. 2FA implementation (Small effort, High value)

### Strategic Initiatives (High Value, High Effort)

1. Maintenance tracking module
2. Mobile application
3. GPS tracking integration
4. API development

### Technical Debt Priority

1. Test suite development (enables all other improvements)
2. API layer (enables mobile and integrations)
3. Service layer refactoring (improves maintainability)
4. Cart concurrency fix (see docs/todo.md P2)

### User Feedback Loop

Document user requests here before adding to backlog:

-   [ ] Request: _[Date] - [User/Department] - [Feature request description]_
-   [ ] Request: _[Date] - [User/Department] - [Feature request description]_

When enough users request same feature, prioritize to "Next Sprint"
