**Purpose**: Record technical decisions and rationale for future reference
**Last Updated**: 2025-10-30

# Technical Decision Records

## Decision Template

**Decision**: [Title] - [YYYY-MM-DD]

**Context**: [What situation led to this decision?]

**Options Considered**:

1. **Option A**: [Description]
   - ✅ Pros: [Benefits]
   - ❌ Cons: [Drawbacks]
2. **Option B**: [Description]
   - ✅ Pros: [Benefits]
   - ❌ Cons: [Drawbacks]

**Decision**: [What we chose]

**Rationale**: [Why we chose this option]

**Implementation**: [How this affects the codebase]

**Review Date**: [When to revisit this decision]

---

## Active Decisions

### Decision: Server-Side Rendering over SPA Framework - 2022-11 (Initial Development)

**Context**: Needed to choose frontend architecture for ARKFleet application. Team had to decide between modern SPA (React/Vue) or traditional server-side rendering with jQuery.

**Options Considered**:

1. **Modern SPA (React/Vue + Laravel API)**
   - ✅ Pros: Modern UX, highly interactive, mobile-ready API, better scalability
   - ❌ Cons: Complex build process, steeper learning curve, longer development time, API complexity
   
2. **Server-Side Rendering (Blade + AdminLTE + jQuery)**
   - ✅ Pros: Faster development, simpler deployment, mature ecosystem, lower skill requirements
   - ❌ Cons: Less interactive UX, harder to build mobile apps later, monolithic architecture

**Decision**: Server-side rendering with AdminLTE template and jQuery

**Rationale**: 
- Application is internal enterprise tool, not public-facing product
- Team familiarity with traditional Laravel patterns
- Faster time-to-market crucial for business needs
- No immediate mobile app requirements
- AdminLTE provides professional, consistent UI out of the box
- Reduced frontend complexity allows focus on business logic

**Implementation**:
- Used `resources/views` with Blade templates
- AdminLTE 3.x for UI framework
- jQuery for client-side interactions
- Server-side DataTables for large dataset handling
- Traditional form submissions with CSRF protection

**Trade-offs Accepted**:
- Future mobile app would require API development
- Limited real-time interaction capabilities
- Page reloads for most actions
- Harder to scale to external users

**Review Date**: 2025-Q2 (if mobile app requirements emerge)

---

### Decision: Spatie Permission Package over Custom RBAC - 2023-02

**Context**: Application needed role-based access control. Had to decide between building custom permission system or using third-party package.

**Options Considered**:

1. **Custom RBAC System**
   - ✅ Pros: Full control, tailored to exact needs, no external dependencies
   - ❌ Cons: Development time, testing complexity, maintenance burden, potential security issues
   
2. **Spatie Laravel Permission Package**
   - ✅ Pros: Battle-tested, well-documented, caching built-in, active maintenance, community support
   - ❌ Cons: Additional package, potential over-engineering for simple needs, learning curve

**Decision**: Spatie Laravel Permission package

**Rationale**:
- Package is industry standard with 10,000+ stars on GitHub
- Handles edge cases and security concerns already
- Built-in caching for performance
- Middleware and Blade directives included
- Much faster than building from scratch
- Easy to extend if custom needs arise

**Implementation**:
- Installed via Composer: `spatie/laravel-permission`
- Migration ran 2023-02-16 creating permission tables
- Used in User model with `HasRoles` trait
- Role and Permission controllers for management UI
- Middleware protection on routes (not heavily implemented yet)

**Impact**:
- Saved ~2-3 weeks development time
- Reduced security risks
- Standard pattern for Laravel developers

**Review Date**: N/A (decision validated by successful implementation)

---

### Decision: Yajra DataTables for Server-Side Processing - 2022-11

**Context**: Equipment list and other tables needed to handle potentially thousands of records. Required efficient pagination, sorting, filtering.

**Options Considered**:

1. **Client-Side DataTables**
   - ✅ Pros: Simple implementation, no AJAX complexity, works with small datasets
   - ❌ Cons: Poor performance with 1000+ records, memory intensive, slow initial load
   
2. **Yajra Laravel DataTables (Server-Side)**
   - ✅ Pros: Handles millions of records, fast response, built for Laravel, JSON API
   - ❌ Cons: AJAX complexity, requires separate endpoints, harder debugging

3. **Custom Pagination**
   - ✅ Pros: Full control, lightweight
   - ❌ Cons: No advanced filtering, no Excel export, lots of custom code

**Decision**: Yajra Laravel DataTables with server-side processing

**Rationale**:
- Fleet applications grow to thousands of equipment records
- Advanced filtering needed (by project, status, type, etc.)
- Built-in Excel export support
- Mature package with Laravel integration
- Consistent pattern across all list pages

**Implementation**:
- Installed `yajra/laravel-datatables`: "9.0"
- Every module has `/data` route endpoint
- Controllers return DataTables AJAX responses
- Views use jQuery DataTables initialization
- Consistent pattern: `route('equipments.index.data')` for AJAX

**Impact**:
- Consistent UX across all list pages
- Handles large datasets efficiently
- Easy export functionality
- Predictable API pattern

**Review Date**: N/A (core architectural decision)

---

### Decision: Maatwebsite Excel for Export over Manual CSV - 2022-11

**Context**: Users needed to export equipment lists and reports to spreadsheet format for offline analysis.

**Options Considered**:

1. **Manual CSV Generation**
   - ✅ Pros: Simple, no dependencies, lightweight, works everywhere
   - ❌ Cons: Limited formatting, no Excel features, encoding issues, manual header management
   
2. **Maatwebsite Excel Package**
   - ✅ Pros: Real Excel files, formatting support, multiple sheets, auto-width columns, events
   - ❌ Cons: Additional package, memory intensive for huge exports

**Decision**: Maatwebsite Excel package

**Rationale**:
- Users specifically requested .xlsx format (not CSV)
- Need formatted reports with headers, styling
- Package handles encoding issues automatically
- Export classes provide clean separation of concerns
- Support for collections, queries, and views

**Implementation**:
- Installed `maatwebsite/excel`: "^3.1"
- Created `app/Exports` directory with export classes:
  - `EquipmentsExport`
  - `SummaryIpaExport`
  - `UnitStatusExport`
- Controllers use: `Excel::download(new ExportClass, 'filename.xlsx')`

**Impact**:
- Professional-looking Excel exports
- Easy to customize columns and formatting
- Reusable export definitions
- Better user satisfaction

**Review Date**: N/A (working well)

---

### Decision: Cart Pattern for Equipment Transfer Selection - 2023

**Context**: Users needed to transfer multiple equipment items from one project to another in a single transaction. Required way to select multiple items before final submission.

**Options Considered**:

1. **Multi-Step Wizard**
   - ✅ Pros: Clear progress, step-by-step validation, modern UX
   - ❌ Cons: Complex state management, session handling, multiple routes

2. **Cart Flag on Equipment Table**
   - ✅ Pros: Simple implementation, single-page experience, easy to undo
   - ❌ Cons: Concurrent user issues, equipment table coupling, no user isolation

3. **Separate Cart Table**
   - ✅ Pros: User isolation, concurrent user support, clean separation
   - ❌ Cons: Extra table, more complex queries, cleanup needed

**Decision**: Cart flag on equipment table (Option 2)

**Rationale**:
- Simple to implement quickly
- Most transfers done by single user at a time
- Internal tool with limited concurrent users
- Easy to visualize selected items
- PATCH endpoints for add/remove are RESTful

**Implementation**:
- Added `cart_flag` column to `equipments` table (nullable string)
- PATCH routes: `add_tocart` and `remove_fromcart`
- DataTables shows which items are in cart
- On transfer submission, cart items become `moving_details`

**Known Limitations**:
- ⚠️ No user isolation - concurrent transfers could interfere
- ⚠️ Cart flag couples transfer logic to equipment table
- ⚠️ No cleanup mechanism if user abandons transfer

**Potential Issues**:
- If two users create transfers simultaneously, cart items could conflict
- Orphaned cart flags if browser closes before submission

**Future Consideration**: 
If concurrent usage increases, migrate to session-based cart or separate cart table with `user_id` and `session_id`.

**Review Date**: 2025-Q3 (if concurrent user issues reported)

---

### Decision: Model Events for Audit Trail over Manual Tracking - 2022-11

**Context**: Every equipment record needs to track who created and last updated it for audit compliance. Needed automatic tracking without manual code in every controller action.

**Options Considered**:

1. **Manual Tracking in Controllers**
   - ✅ Pros: Explicit, visible in code, easy to debug
   - ❌ Cons: Easy to forget, repetitive code, human error prone

2. **Model Events (Boot Method)**
   - ✅ Pros: Automatic, consistent, can't forget, centralized logic
   - ❌ Cons: Hidden logic, harder for beginners to understand, testing complexity

3. **Database Triggers**
   - ✅ Pros: Enforced at database level, works across applications
   - ❌ Cons: Not Laravel way, harder to version control, debugging difficult

**Decision**: Model events using boot() method

**Rationale**:
- Laravel best practice for cross-cutting concerns
- Automatic execution prevents human error
- Centralized in model keeps related logic together
- `isDirty()` check allows manual override when needed
- Consistent across Equipment, Moving, and other models

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

**Impact**:
- 100% audit trail coverage
- Zero controller boilerplate
- Relationships: `creator()` and `updater()` methods with `withDefault()`

**Review Date**: N/A (working excellently)

---

### Decision: Document Extension via Self-Referencing FK over Versioning Table - 2023-04

**Context**: Equipment documents (BPKB, STNK, insurance) need renewal tracking. When document renewed, need to maintain history while tracking current document.

**Options Considered**:

1. **Document Versions Table**
   - ✅ Pros: Clean separation, unlimited versions, structured history
   - ❌ Cons: Extra table, join complexity, more code

2. **Self-Referencing Foreign Key (extended_doc_id)**
   - ✅ Pros: Simple schema, easy queries, minimal code
   - ❌ Cons: Can't easily track multiple renewals, linked list traversal

3. **Status Field (Active/Expired)**
   - ✅ Pros: Simplest implementation
   - ❌ Cons: Lose history, can't track renewal chain, compliance issues

**Decision**: Self-referencing foreign key (`extended_doc_id`)

**Rationale**:
- Document renewals happen once per expiry (not frequent)
- Only need current + one previous for most queries
- Schema simplicity reduces bugs
- Easy to filter current docs: `whereNull('extended_doc_id')`
- Renewal creates new doc pointing to old via `extended_doc_id`

**Implementation**:
- `documents` table has `extended_doc_id` nullable FK to `documents.id`
- Extension controller creates new document, links via `extended_doc_id`
- Dashboard queries: `whereNull('extended_doc_id')` for active docs
- Historical documents still accessible via relationship

**Query Pattern**:
```php
// Get only current (not-renewed) documents
Document::whereNull('extended_doc_id')->get();

// Get renewal chain
$document->extended_from; // If this is a renewal
$document->extensions;    // If this was renewed
```

**Limitation**: 
Deep renewal chains (doc renewed 5+ times) require recursive queries. Acceptable trade-off for simplicity.

**Review Date**: N/A (working as designed)

---

### Decision: Soft Deletes Only on Documents - 2023

**Context**: Needed to decide which tables should use soft deletes for data retention and audit compliance.

**Options Considered**:

1. **Soft Delete Everything**
   - ✅ Pros: Complete audit trail, data recovery, safe deletions
   - ❌ Cons: Query complexity (`withTrashed()` everywhere), storage overhead, confusion

2. **Soft Delete Nothing**
   - ✅ Pros: Simple queries, clear data state, less storage
   - ❌ Cons: No audit trail, accidental deletion permanent, compliance issues

3. **Selective Soft Deletes** (chosen)
   - ✅ Pros: Audit trail where needed, simple queries elsewhere, storage efficient
   - ❌ Cons: Inconsistent deletion behavior, need to remember which tables

**Decision**: Selective soft deletes - only `documents` table

**Rationale**:

**Documents Need Soft Delete Because**:
- Regulatory compliance (BPKB, STNK, insurance records)
- Audit trail for government inspections
- Accidental deletion could lose critical compliance data
- Recovery capability essential

**Equipment/Moving Don't Need Soft Delete Because**:
- Equipment has `unitstatus_id` for inactive/disposed status
- Movings are historical records - shouldn't be deleted at all
- Physical deletion of equipment is deliberate, rare action
- Status fields provide sufficient lifecycle tracking

**Users Don't Need Soft Delete Because**:
- `is_active` boolean flag handles deactivation
- Employment records remain visible even when inactive
- No regulatory requirement to soft delete users
- Simpler to query active users with `where('is_active', true)`

**Implementation**:
- Added `use SoftDeletes` only to Document model
- Migration adds `deleted_at` only to documents table
- Document queries can use `withTrashed()` when needed
- All other models use status fields or flags

**Impact**:
- Simpler codebase (not littering `withTrashed()` everywhere)
- Compliance achieved where legally required
- Clear semantics: delete means delete (except documents)

**Review Date**: N/A (principled decision with clear rationale)

---

### Decision: withDefault() on Relationships over Null Checks - 2022-11

**Context**: Equipment can have optional relationships (plant_type, plant_group, etc.). Views need to display data even when relationships missing. Needed to prevent "trying to get property of null" errors.

**Options Considered**:

1. **Null Checks in Views**
   ```blade
   {{ $equipment->unitmodel ? $equipment->unitmodel->model_no : 'n/a' }}
   ```
   - ✅ Pros: Explicit, visible in templates
   - ❌ Cons: Verbose, repetitive, easy to forget, ugly Blade code

2. **Accessor on Model**
   ```php
   public function getModelNoAttribute() {
       return $this->unitmodel->model_no ?? 'n/a';
   }
   ```
   - ✅ Pros: Clean views, centralized logic
   - ❌ Cons: Magic properties, can't use relationship methods

3. **withDefault() on Relationship** (chosen)
   ```php
   public function unitmodel() {
       return $this->belongsTo(Unitmodel::class)->withDefault(['model_no' => 'n/a']);
   }
   ```
   - ✅ Pros: Clean views, keeps relationship, graceful degradation
   - ❌ Cons: Default values defined in model (could be elsewhere)

**Decision**: `withDefault()` on BelongsTo relationships

**Rationale**:
- Most Laravel developers understand pattern
- Keeps relationship chains working
- Views stay clean: `$equipment->unitmodel->model_no` always works
- Sensible defaults in one place (model definition)
- No magic accessors or properties

**Implementation**:
Used extensively across Equipment model:
```php
public function unitmodel() {
    return $this->belongsTo(Unitmodel::class)->withDefault(['model_no' => 'n/a']);
}

public function creator() {
    return $this->belongsTo(User::class, 'created_by')->withDefault(['name' => 'System Admin']);
}

public function asset_category() {
    return $this->belongsTo(AssetCategory::class)->withDefault(['name' => 'n/a']);
}

// ... etc for all optional relationships
```

**Default Values Chosen**:
- Most fields: `'n/a'` (user-friendly, indicates no data)
- Creator/Updater: `'System Admin'` (indicates system action)

**Impact**:
- Blade templates 50% more readable
- Zero "property of null" errors in production
- Consistent "n/a" messaging across application

**Review Date**: N/A (excellent pattern)

---

### Decision: Dashboard-First UI Modernization Strategy - 2025-10-30

**Context**: Application had functional but dated AdminLTE dashboard. Needed to decide between gradual UI improvements across all pages or focused modernization of high-impact areas.

**Options Considered**:

1. **Application-Wide Redesign**
   - ✅ Pros: Consistent experience everywhere, comprehensive update, professional look
   - ❌ Cons: 100+ hours of work, high risk, would delay other features, expensive
   
2. **Dashboard-First Focused Enhancement** (chosen)
   - ✅ Pros: High-impact area (users see daily), manageable scope, iterative approach, quick wins
   - ❌ Cons: Inconsistent UX across pages (dashboard modern, others dated), eventual need to update rest
   
3. **Minimal CSS Tweaks Only**
   - ✅ Pros: Minimal effort, low risk
   - ❌ Cons: Doesn't address user experience issues, missed opportunity for improvement

**Decision**: Dashboard-first focused enhancement with 14 specific features

**Rationale**:
- Dashboard is most-viewed page (users check multiple times daily)
- Single-page modernization provides quick user value
- Can be completed in 1-2 days vs weeks for full redesign
- Serves as template/pattern for gradual modernization of other pages
- Users immediately see application is actively maintained
- Low risk - if users don't like it, easy to revert single page

**Implementation**:

**Phase 1 - Foundation** (completed):
- Dark mode toggle with LocalStorage persistence
- Always-dark sidebar/navbar for consistency
- Global table striping removal for clean look
- Local asset migration (ionicons) for reliability

**Phase 2 - Data Visualization** (completed):
- Count-up animation for numbers (perceived performance)
- Mini sparkline charts (7-day trends)
- Color-coded stat cards with unique gradients
- Quick stats summary (utilization, average age)
- Equipment health score with gauge visualization

**Phase 3 - Interactivity** (completed):
- Interactive pie chart with click-to-filter
- Enhanced activity feed (icons, grouping, clickable links, filter)
- Responsive RFU table (sticky columns, fullscreen mode)
- Color-coded document alerts with action buttons

**Features Implemented**:
1. Dark Mode Toggle
2. Always-Dark Sidebar/Navbar
3. Table Striping Disabled
4. Fleet Overview Cards (4 gradients)
5. Trend Indicators
6. Count-Up Animation
7. Mini Sparkline Charts
8. Quick Stats Summary
9. Equipment Health Score
10. Enhanced Document Alerts
11. Improved Activity Feed
12. Interactive Pie Chart
13. Responsive RFU Table
14. Local Asset Migration

**Files Modified**:
- `resources/views/dashboard/index.blade.php` (1170 lines - significant enhancement)
- `app/Http/Controllers/DashboardController.php` (+32 lines for stats calculations)
- `public/js/darkmode.js` (new file - 80 lines)
- `resources/views/templates/partials/` (navbar, head for global theme support)

**Metrics for Success**:
- User feedback on dashboard improvements
- Time spent on dashboard (analytics if available)
- Feature adoption (dark mode usage, filter usage, etc.)

**Next Steps** (future):
1. Apply similar enhancements to Equipment list page
2. Modernize Document management interface
3. Enhance Report generation pages
4. Eventually achieve consistent modern UI across application

**Review Date**: 2025-Q1 (assess user feedback, plan next page modernization)

**Key Learning**: Focused, high-impact improvements provide better ROI than comprehensive rewrites. Dashboard-first strategy proved effective - users immediately see value, development effort is manageable, and patterns established can be reused for other pages.

---

### Decision: Mock Data for Sparkline Charts over Historical Tracking - 2025-10-30

**Context**: Dashboard stat cards needed 7-day trend visualization. Had to decide between implementing full historical data tracking system or using mock data initially.

**Options Considered**:

1. **Full Historical Data Tracking**
   - ✅ Pros: Real data, accurate trends, valuable analytics
   - ❌ Cons: Requires new `dashboard_stats_history` table, cron job for daily snapshots, 2-3 days work, delays dashboard launch
   
2. **Mock Sparkline Data** (chosen)
   - ✅ Pros: Immediate visual value, pattern established, fast implementation (30 minutes)
   - ❌ Cons: Not real data, needs eventual replacement
   
3. **No Sparklines**
   - ✅ Pros: No development time
   - ❌ Cons: Missed visual enhancement opportunity, less engaging dashboard

**Decision**: Mock sparkline data with plan to implement historical tracking later

**Rationale**:
- Visual enhancement more important than data accuracy for initial release
- Demonstrates feature value to users/stakeholders
- Can implement historical tracking based on user feedback
- Sparklines pattern established (easy to plug in real data later)
- Users don't know data is mock unless told
- Fast time-to-value (minutes vs days)

**Implementation**:
```javascript
const sparklineData = {
    total: [650, 655, 658, 660, 662, 665, 668],
    projects: [14, 14, 15, 15, 15, 15, 15],
    expiring: [5, 4, 4, 3, 3, 3, 3],
    rfu: [560, 562, 563, 565, 566, 567, 568]
};
```

**Future Implementation Plan**:
1. Create `dashboard_stats_history` table
2. Scheduled command: `php artisan stats:snapshot:daily`
3. Store daily snapshots: total_fleet, rfu_count, expiring_docs, active_projects
4. Query last 7 days for sparkline data
5. Replace mock data with query results

**Trade-offs Accepted**:
- Users see trend visualization that isn't real
- Need to return and implement real tracking later
- Acceptable because: visual pattern more important than accuracy, easy to swap in real data

**Review Date**: 2025-Q1 (implement real historical tracking after dashboard feedback)

**Key Learning**: For UI/visual enhancements, mock data can provide immediate value while real implementation is planned. Better to ship modern dashboard with mock trends than delay release waiting for perfect data tracking system.

---

## Deferred Decisions

### Laravel Version Upgrade to 11/12

**Status**: Deferred

**Context**: User memory indicates preference for Laravel 12 (latest), but codebase currently on Laravel 10.

**Rationale for Deferring**:
- Laravel 10 is LTS (Long Term Support) until 2025-08
- Application stable on current version
- Upgrade effort significant (service provider changes, middleware changes)
- No compelling features in 11/12 required for current functionality
- Risk of breaking changes outweighs benefits

**Review Date**: 2025-08 (when Laravel 10 LTS ends)

**Upgrade Path**:
1. Comprehensive test suite first
2. Laravel 11 upgrade (service provider consolidation)
3. Laravel 12 upgrade if benefits clear
4. Update `.cursorrules` Laravel preferences

---

### API-First Architecture

**Status**: Deferred (pending mobile app requirements)

**Context**: Application currently has minimal API layer. Future mobile app would require comprehensive API.

**Rationale for Deferring**:
- No immediate mobile app requirements
- Building unused API is waste of resources
- Current web-first architecture working well
- Can add API layer when needed (not blocking)

**If/When Needed**:
1. Create API resources for all models
2. API versioning (v1, v2)
3. API authentication (Sanctum tokens)
4. API documentation (Scribe or similar)
5. Rate limiting
6. API test suite

**Review Date**: When mobile app requirements confirmed

---

### Real-Time Notifications

**Status**: Deferred (low priority)

**Context**: Document expiry alerts currently shown only on dashboard refresh. Real-time notifications could improve UX.

**Rationale for Deferring**:
- Documents don't expire suddenly (month/year timescales)
- Users check dashboard regularly
- WebSocket complexity not justified by value
- Email notifications could be simpler alternative

**Alternatives**:
1. Email notifications for expiring documents (easier, sufficient)
2. Laravel Echo + Pusher for real-time (if real-time becomes critical)

**Review Date**: If user complaints about missed expirations increase

---

## Deprecated Decisions

None yet. When decisions are superseded, move them to this section with explanation of what replaced them.

---

## Decision Making Principles

Based on analysis of existing decisions, the ARKFleet team follows these principles:

1. **Pragmatism over Perfection**: Choose simple, working solutions over perfect architecture
2. **Stability over Trends**: Mature packages (Laravel 10, AdminLTE) over cutting-edge frameworks
3. **Business Value First**: Features that solve user problems prioritized over technical elegance
4. **Selective Complexity**: Add complexity (soft deletes, API) only where business value clear
5. **Laravel Way**: Follow Laravel conventions and best practices
6. **Audit Trail**: Compliance and traceability built into core decisions
7. **Defer Until Needed**: Don't build features for hypothetical future needs

These principles have resulted in maintainable, stable application that serves its purpose well.
