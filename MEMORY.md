**Purpose**: AI's persistent knowledge base for project context and learnings
**Last Updated**: 2025-10-30

## Memory Maintenance Guidelines

### Structure Standards

- Entry Format: ### [ID] [Title (YYYY-MM-DD)] ✅ STATUS
- Required Fields: Date, Challenge/Decision, Solution, Key Learning
- Length Limit: 3-6 lines per entry (excluding sub-bullets)
- Status Indicators: ✅ COMPLETE, ⚠️ PARTIAL, ❌ BLOCKED, 🔴 CRITICAL

### Content Guidelines

- Focus: Architecture decisions, critical bugs, security fixes, major technical challenges
- Exclude: Routine features, minor bug fixes, documentation updates
- Learning: Each entry must include actionable learning or decision rationale
- Redundancy: Remove duplicate information, consolidate similar issues

### File Management

- Archive Trigger: When file exceeds 500 lines or 6 months old
- Archive Format: `memory-YYYY-MM.md` (e.g., `memory-2025-01.md`)
- New File: Start fresh with current date and carry forward only active decisions

---

## Project Memory Entries

### [001] Database Mismatch - Critical Configuration Issue (2025-10-30) 🔴 CRITICAL

**Challenge**: Discovered severe database configuration mismatch between codebase and runtime environment.

**Details**:
- **Codebase Expected**: `arkfleet_db` database with equipment management schema (equipments, movings, documents, projects tables)
- **Actual Connection**: `genaf_db` database with completely different schema (assets, vehicles, rooms, supplies, reservations)
- **Impact**: Application cannot function - all queries will fail, migrations not run, data layer completely broken

**Root Cause**:
- `.env` file likely points to wrong database
- GENAF DB appears to be a General Affairs/Facilities Management system
- ARKFleet is Equipment Fleet Management system
- Two completely different applications

**Solution Needed**:
1. Create `arkfleet_db` database
2. Update `.env` file: `DB_DATABASE=arkfleet_db`
3. Run migrations: `php artisan migrate`
4. Run seeders: `php artisan db:seed`

**Key Learning**: Always verify database connection matches application schema before deployment. Check actual database tables vs expected migrations during initial codebase analysis.

---

### [002] Application Identity - ARKFleet v.10 (2025-10-30) ✅ COMPLETE

**Decision**: Confirmed application identity and purpose through comprehensive code analysis.

**Details**:
- **Name**: ARKFleet v.10
- **Purpose**: Equipment Fleet Management System for heavy equipment and construction machinery
- **Primary Users**: Project managers, equipment coordinators, fleet administrators
- **Key Domains**: Equipment tracking, inter-project transfers (IPA), document compliance, fleet reporting

**Architecture**:
- Laravel 10.x backend with AdminLTE frontend
- Server-side DataTables for all list views
- Role-based access control (Spatie Permission)
- Excel/PDF export capabilities
- Session-based authentication

**Key Learning**: Application naming and branding found in sidebar template (`resources/views/templates/partials/sidebar.blade.php` line 5) - always check view templates for application identity when documentation is missing.

---

### [003] Technology Stack Decisions (2025-10-30) ✅ COMPLETE

**Decision**: Application built on mature, stable technology stack suitable for enterprise use.

**Stack Analysis**:
- **Backend**: Laravel 10 (not 11/12 despite user memory preference for Laravel 12)
- **Frontend**: AdminLTE (jQuery-based, not modern SPA) - deliberate choice for simplicity
- **DataTables**: Yajra DataTables for server-side processing - good for large datasets
- **Permissions**: Spatie Laravel Permission - industry standard
- **No API-first architecture** - traditional server-side rendering

**Rationale**:
- Chosen for stability and maintainability over cutting-edge features
- AdminLTE provides consistent, professional UI out of the box
- Server-side rendering reduces frontend complexity
- jQuery stack means lower barrier to entry for junior developers

**Trade-offs**:
- ✅ Faster development, easier maintenance
- ✅ Less frontend build complexity
- ❌ Less interactive UX compared to modern SPAs
- ❌ Harder to build mobile apps (no API-first design)

**Key Learning**: Stack choices reflect pragmatic enterprise priorities (stability, maintainability) over modern trends. Valid for internal tools where UI complexity isn't critical.

---

### [004] Model Event Pattern for Audit Trail (2025-10-30) ✅ COMPLETE

**Pattern**: Auto-tracking of creators and updaters using Eloquent model events.

**Implementation**:
```php
protected static function boot() {
    parent::boot();
    static::creating(function ($model) {
        if (!$model->isDirty('created_by')) {
            $model->created_by = auth()->user()->id;
        }
        if (!$model->isDirty('updated_by')) {
            $model->updated_by = auth()->user()->id;
        }
    });
    static::updating(function ($model) {
        if (!$model->isDirty('updated_by')) {
            $model->updated_by = auth()->user()->id;
        }
    });
}
```

**Used In**: Equipment, Moving models (likely others)

**Benefits**:
- Automatic audit trail without manual code in controllers
- Consistent tracking across application
- `isDirty()` check allows manual override when needed

**Key Learning**: Use model events for cross-cutting concerns like audit trails. Prevents forgetting to set these fields in controllers.

---

### [005] Document Expiration Monitoring System (2025-10-30) ✅ COMPLETE

**Feature**: Proactive compliance monitoring for equipment documents.

**Implementation**:
- Dashboard queries documents with `due_date` approaching or past
- Two categories:
  - **Will Expire**: `due_date` between NOW and +2 months
  - **Expired**: `due_date` <= NOW
- Uses `whereNull('extended_doc_id')` to exclude superseded documents
- Document extension/renewal creates new document linked via `extended_doc_id`

**Business Logic**:
```php
$documents_will_expired = Document::whereNull('extended_doc_id')
    ->whereBetween('due_date', [Carbon::now(), Carbon::now()->addMonths(2)])
    ->get()->count();

$documents_expired = Document::whereNull('extended_doc_id')
    ->where('due_date', '<=', Carbon::now())
    ->get()->count();
```

**Key Learning**: Document renewal pattern using self-referencing foreign key (`extended_doc_id`) is elegant way to maintain history while tracking only current documents. The `whereNull('extended_doc_id')` filter is critical - missing it would count all historical documents.

---

### [006] Transfer Cart Pattern for Batch Operations (2025-10-30) ✅ COMPLETE

**Pattern**: Shopping cart-style equipment selection for inter-project transfers.

**Implementation**:
- Equipment table has `cart_flag` field (nullable string)
- During transfer creation, user can add/remove equipment to cart
- Cart session tied to current moving transaction
- PATCH endpoints: `add_tocart` and `remove_fromcart`
- On transfer submission, all cart items become `moving_details` records

**Benefits**:
- Better UX for selecting multiple equipment
- Review before final submission
- Undo capability during selection
- Batch operation without complex multi-step wizards

**Limitations**:
- `cart_flag` in equipment table creates coupling
- Concurrent users might interfere (no user-specific cart isolation visible)
- Should potentially use session-based cart instead

**Key Learning**: Cart pattern works well for batch operations but implementation needs user isolation. Consider session-based cart or cart table with user_id instead of flag on main entity table.

---

### [007] withDefault() Pattern for Graceful Degradation (2025-10-30) ✅ COMPLETE

**Pattern**: Laravel's `withDefault()` on BelongsTo relationships to prevent null reference errors.

**Example**:
```php
public function unitmodel() {
    return $this->belongsTo(Unitmodel::class)->withDefault([
        'model_no' => 'n/a'
    ]);
}

public function creator() {
    return $this->belongsTo(User::class, 'created_by', 'id')->withDefault([
        'name' => 'System Admin'
    ]);
}
```

**Benefits**:
- No need for `if ($equipment->unitmodel)` checks in views
- Blade templates can safely use `$equipment->unitmodel->model_no`
- Graceful handling of orphaned records or missing relationships
- "n/a" and "System Admin" are sensible defaults

**Used Extensively In**: Equipment, Moving, Document models

**Key Learning**: `withDefault()` is underutilized Laravel feature that significantly reduces defensive coding in views. Especially valuable in equipment management where optional relationships are common.

---

### [008] Export Classes Pattern (2025-10-30) ✅ COMPLETE

**Pattern**: Dedicated export classes using Maatwebsite Excel for report generation.

**Implementation**:
- `app/Exports/EquipmentsExport.php`
- `app/Exports/SummaryIpaExport.php`
- `app/Exports/UnitStatusExport.php`

**Usage**:
```php
return Excel::download(new EquipmentsExport($filters), 'equipments.xlsx');
```

**Benefits**:
- Separation of concerns (export logic separate from controllers)
- Reusable export definitions
- Easy to customize columns, formatting, styles
- Support for collections, queries, or views

**Key Learning**: Export classes pattern scales better than inline export code. When reports need customization (logos, multiple sheets, calculations), export classes provide structure.

---

### [009] Activity Logging Strategy (2025-10-30) ✅ COMPLETE

**Implementation**: Two-table logging strategy for different purposes.

**Tables**:
1. **activities**: User-initiated actions (likely meant for user activity feed)
2. **loggers**: System-wide events and automated processes

**Logger Usage Pattern**:
```php
$logger = app(LoggerController::class);
$description = auth()->user()->name . ' created new equipment ' . $equipment->unit_no;
$logger->store($description);
```

**Observations**:
- LoggerController instantiated via `app()` helper
- String-based descriptions (not structured data)
- No event system - manual logging in controllers
- Dashboard shows last 10 log entries

**Limitations**:
- Manual logging can be forgotten
- No standardized log format
- Hard to query/filter logs programmatically
- Could benefit from Laravel Events/Listeners

**Key Learning**: Manual logging is error-prone. Consider Laravel event system for automatic logging of model changes. Current pattern works but doesn't scale well.

---

### [010] Migration Naming Conventions (2025-10-30) ✅ COMPLETE

**Observation**: Migrations follow clear chronological and functional naming.

**Pattern**:
```
2022_11_14_HHMMSS_create_[entity]_table.php
2023_04_03_HHMMSS_add_[field]_to_[table]_table.php
```

**Migration History**:
- Nov 2022: Initial tables (core domain)
- Feb 2023: Spatie permissions + departments
- Mar 2023: Asset categories, activities
- Apr 2023: Document filename, equipment photos
- Apr 2023: RFU field addition
- Jun 2023: Loggers table

**Evolution Insight**: 
- Core system built Nov 2022
- Permissions added Feb 2023 (multi-user need emerged)
- Photo support added Apr 2023 (visual documentation need)
- RFU field added Apr 2023 (equipment readiness tracking)

**Key Learning**: Migration dates tell product evolution story. Gap between Feb-Mar 2023 and Apr 2023 suggests iterative deployment with user feedback driving features like photos and RFU status.

---

### [011] Route Organization Strategy (2025-10-30) ✅ COMPLETE

**Pattern**: Prefix/name grouping with resource routes + custom routes.

**Implementation**:
```php
Route::prefix('equipments')->name('equipments.')->group(function () {
    Route::get('/data', [EquipmentController::class, 'index_data'])->name('index.data');
    Route::get('/{equipment}/movings/data', ...)->name('movings.data');
    // ... custom routes
});
Route::resource('equipments', EquipmentController::class);
```

**Benefits**:
- RESTful resource routes for standard CRUD
- Custom routes for DataTables AJAX (`/data` endpoints)
- Custom routes for specialized actions (PDF, export, photos)
- Consistent naming: `equipments.index.data`, `equipments.movings.data`

**DataTables Pattern**: Every module has `/data` endpoint for server-side processing.

**Key Learning**: Combining resource routes with custom routes in prefix groups provides REST compliance while supporting custom actions. DataTables `/data` convention is consistent and predictable.

---

### [012] No API-First Design (2025-10-30) ⚠️ PARTIAL

**Observation**: Minimal API routes, mostly web routes with server-side rendering.

**Current API Routes** (`routes/api.php`):
```php
GET /api/equipments
GET /api/projects
```

**Implications**:
- Application is web-first, not API-first
- Mobile app development would require building API layer
- Frontend JavaScript uses AJAX but not JSON API (uses DataTables server-side)
- No API versioning, no API documentation

**Trade-off Analysis**:
- ✅ Simpler architecture for web-only deployment
- ✅ No need for API authentication complexity
- ❌ Future mobile app would require significant refactoring
- ❌ Third-party integrations harder
- ❌ Can't easily build SPA frontend later

**Key Learning**: Decision to not build API-first was probably deliberate for internal tool. If product needs expand (mobile, integrations), this becomes technical debt. Document as architectural limitation.

---

### [013] Soft Deletes Only on Documents (2025-10-30) ✅ COMPLETE

**Observation**: Selective use of soft deletes - only `documents` table uses it.

**Analysis**:
- **Documents**: Use `soft_deletes` - makes sense for compliance/audit trail
- **Equipment**: No soft delete - deliberate choice
- **Movings**: No soft delete
- **Users**: No soft delete but has `is_active` flag

**Rationale**:
- Documents need audit trail (regulatory compliance for BPKB, STNK, insurance)
- Equipment deletion is rare, can use `is_active` or status instead
- Movings are historical records, shouldn't be deleted
- User deactivation better than deletion for employment records

**Key Learning**: Soft deletes should be used judiciously, only where compliance or audit trail required. Overusing soft deletes complicates queries (`withTrashed()` everywhere). This application made smart, selective choices.

---

### [014] Dashboard UI/UX Modernization (2025-10-30) ✅ COMPLETE

**Feature**: Comprehensive dashboard enhancement with 14+ interactive features for better data visualization and user experience.

**Implementations**:

1. **Dark Mode System**:
   - Toggle button in navbar with moon/sun icon
   - LocalStorage persistence (`darkMode` key)
   - JavaScript file: `public/js/darkmode.js`
   - Applies `dark-mode` class to `body` element
   - Sidebar and navbar always dark (even in light mode)
   
2. **Count-Up Animation**:
   ```javascript
   // Numbers animate from 0 to target over 2 seconds
   <h3 class="count-up" data-target="668">0</h3>
   animateCountUp(element, target, duration = 2000);
   ```

3. **Mini Sparkline Charts**:
   - 100x30px Chart.js line charts in each stat card
   - Shows 7-day trends (mock data currently)
   - White line on transparent background
   - Tooltip on hover showing count values

4. **Quick Stats Summary**:
   - Fleet Utilization: (RFU / Total) × 100
   - Average Age: Average months since `active_date`
   - Controller method: `DashboardController::getQuickStats()`
   - Real-time calculation from database

5. **Interactive Features**:
   - Pie chart click-to-filter equipment table
   - Activity feed with clickable links to equipment/IPA details
   - RFU table fullscreen mode using Fullscreen API
   - Activity type filter dropdown (client-side filtering)

**Files Modified**:
- `resources/views/dashboard/index.blade.php` (1170 lines)
- `app/Http/Controllers/DashboardController.php` (+32 lines)
- `public/js/darkmode.js` (new file, ~80 lines)
- `resources/views/templates/partials/head.blade.php` (CSS overrides)
- `resources/views/templates/partials/navbar.blade.php` (dark mode toggle)

**Key Patterns Used**:
- **LocalStorage API** for theme persistence
- **Chart.js** for sparklines and gauges
- **Fullscreen API** for table expansion
- **CSS Gradients** for modern card styling
- **setInterval** for smooth count-up animation (60fps)
- **preg_replace_callback** for making text clickable in activity descriptions

**Performance Considerations**:
- Sparkline data is mock (7 hardcoded values per chart)
- Count-up animation uses requestAnimationFrame timing
- Activity filter uses client-side JavaScript (no AJAX)
- CSS transitions for smooth theme switching

**Key Learning**: Dashboard enhancements should balance visual appeal with performance. Mock sparkline data is acceptable for initial release; can be made dynamic later when historical data tracking is implemented. Count-up animation adds perceived performance (makes loading feel faster).

---

### [015] Local Assets Migration for Offline Capability (2025-10-30) ✅ COMPLETE

**Decision**: Migrated ionicons from external CDN to local assets for better reliability and offline capability.

**Change**:
```html
<!-- Before -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

<!-- After -->
<link rel="stylesheet" href="{{ asset('adminlte/ionicons/2.0.1/css/ionicons.min.css') }}">
```

**Benefits**:
- No external dependencies or tracking
- Works without internet connection
- Faster loading (no DNS lookup, no SSL handshake)
- No CDN downtime issues
- Privacy - no external requests
- Consistent performance regardless of CDN location

**Files**:
- Ionicons already present in: `public/adminlte/ionicons/2.0.1/`
- Updated in: `resources/views/dashboard/index.blade.php`

**Pattern**: This same approach should be applied to any other external CDN dependencies (Chart.js, Font Awesome, etc.) for production deployment.

**Key Learning**: For enterprise applications, local assets provide better reliability than CDNs. The slight increase in server load is worth the trade-off for offline capability and privacy.

---

### [016] Table Striping Removal for Dark Mode Compatibility (2025-10-30) ✅ COMPLETE

**Challenge**: Default AdminLTE `table-striped` class created poor contrast in dark mode, making tables hard to read.

**Solution**: Global CSS override to disable striped table styling in both light and dark modes.

**Implementation**:
```css
/* Disable table-striped globally */
.table-striped tbody tr:nth-of-type(odd),
.table-striped tbody tr:nth-of-type(even) {
    background-color: transparent !important;
}

/* Dark mode specific overrides */
.dark-mode .table-striped tbody tr:nth-of-type(odd),
.dark-mode .table-striped tbody tr:nth-of-type(even) {
    background-color: transparent !important;
}

/* DataTables specific overrides */
.dark-mode table.dataTable.table-striped tbody tr:nth-of-type(odd),
.dark-mode table.dataTable.table-striped tbody tr:nth-of-type(even) {
    background-color: transparent !important;
}
```

**Location**: `resources/views/templates/partials/head.blade.php`

**Rationale**: 
- Striped tables created visual noise in dark mode
- Clean, single-color tables easier to read
- Row hover effects provide sufficient visual feedback
- Modern design trend favors clean, minimal tables

**Alternative Considered**: Dynamic striping with different colors for dark mode - rejected as too complex and still visually noisy.

**Key Learning**: When implementing dark mode, aggressive use of `!important` is sometimes necessary to override deeply-nested AdminLTE and Bootstrap defaults. This is acceptable for theme-level customizations.

---

### [017] Equipment API Expansion with Human-Readable Parameters (2025-10-30) ✅ COMPLETE

**Feature**: Expanded minimal REST API with filtering capabilities, detailed equipment lookup, and human-readable query parameters.

**Implementation**:

**New Endpoints**:
1. `GET /api/equipments` - Enhanced with human-readable filtering
   - **Recommended filters**: `project_code` (e.g., 000H), `status` (ACTIVE/IN-ACTIVE/SCRAP/SOLD), `plant_group` (name)
   - **Legacy filters**: `current_project_id`, `plant_group_id`, `unitstatus_id` (still supported)
   - Returns 24 fields per equipment (expanded from 6)
   - Example: `/api/equipments?project_code=000H&status=ACTIVE`

2. `GET /api/equipments/by-unit/{unit_no}` - Get equipment by unit number
   - Lookup by `unit_no` (e.g., `/api/equipments/by-unit/EX-001`)
   - Returns detailed equipment info with nested relationship objects
   - 404 response if equipment not found

**API Resources Created**:
- `EquipmentResource`: Flat structure with 24 fields (basic info + relationships as names + IDs)
- `EquipmentDetailResource`: Nested structure with relationship objects for detailed view

**Human-Readable Parameters**:
- `project_code`: Filter by project code instead of ID (e.g., `project_code=017C`)
- `status`: Filter by status name (ACTIVE, IN-ACTIVE, SCRAP, SOLD) - case-insensitive
- `plant_group`: Filter by plant group name instead of ID
- Backward compatible: All ID-based parameters still work

**Controller Implementation**:
```php
// Support both human-readable and ID-based parameters
if ($request->has('project_code')) {
    $equipments->whereHas('current_project', function ($query) use ($request) {
        $query->where('project_code', $request->project_code);
    });
} elseif ($request->has('current_project_id')) {
    $equipments->where('current_project_id', $request->current_project_id);
}
```

**Documentation Created**:
- `docs/api-documentation.md` (700+ lines): Complete API reference with code examples
- `docs/API-QUICK-REFERENCE.md`: One-page cheat sheet for developers
- Updated `docs/architecture.md` with API overview
- Updated `docs/DOCUMENTATION-SUMMARY.md` with API documentation entry

**Key Learning**: 
1. Human-readable API parameters significantly improve developer experience and API discoverability
2. Supporting both old and new parameter formats ensures backward compatibility during transition
3. Case-insensitive string matching (using `strtoupper()`) prevents common user errors
4. Using `whereHas()` for filtering through relationships maintains query performance with proper indexing

---

## Technical Debt & Known Issues

### 🔴 CRITICAL: Database Configuration Mismatch
**Status**: BLOCKED
**Severity**: Application non-functional
**Description**: Application expects `arkfleet_db` but connected to `genaf_db` (different system)
**Action Required**: Database creation and configuration update (see Entry #001)

### ⚠️ Cart Flag Implementation
**Status**: PARTIAL
**Severity**: Medium
**Description**: Equipment `cart_flag` field not user-isolated, potential concurrency issues
**Recommendation**: Migrate to session-based cart or separate cart table with user_id

### ⚠️ Manual Activity Logging
**Status**: PARTIAL
**Severity**: Low
**Description**: Manual logging in controllers can be forgotten, no standardization
**Recommendation**: Implement Laravel Events and Listeners for automatic logging

### ⚠️ Minimal Test Coverage
**Status**: PARTIAL
**Severity**: Medium
**Description**: Only example tests exist, no real test coverage
**Recommendation**: Add feature tests for critical paths (equipment CRUD, transfers, document expiry)

### ⚠️ No API Layer
**Status**: PARTIAL
**Severity**: Low (unless mobile app needed)
**Description**: No comprehensive API, limits future extensibility
**Recommendation**: Consider building API resources if mobile/integration needs arise

---

## Architectural Strengths

### ✅ Clean Separation of Concerns
Controllers handle HTTP, Models handle data, Views handle presentation. No business logic in views.

### ✅ Consistent Patterns
DataTables, export classes, route naming, model relationships all follow consistent patterns.

### ✅ Appropriate Technology Choices
Laravel 10 + AdminLTE is proven, stable stack. Good choice for internal enterprise tool.

### ✅ Audit Trail Implementation
Automatic creator/updater tracking, activity logging, document history via extensions.

### ✅ Relationship Modeling
Well-thought-out relationships with sensible `withDefault()` usage for null safety.

---

## Archive Notes

When this file reaches 500 lines or 6 months age:
1. Create `memory-2025-10.md` with entries from this period
2. Carry forward only CRITICAL and BLOCKED items to new `MEMORY.md`
3. Update cross-references in other documentation files
4. Keep archive files in `docs/archive/` directory
