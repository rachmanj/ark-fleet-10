<?php

use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManufactureController;
use App\Http\Controllers\MovingController;
use App\Http\Controllers\MovingDetailController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PlantGroupController;
use App\Http\Controllers\PlantTypeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportActiveStatusController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportSummaryIpaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitmodelController;
use App\Http\Controllers\UnitnoHistoryController;
use App\Http\Controllers\UnitstatusController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard.index');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // USERS
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('data', [UserController::class, 'data'])->name('data');
        Route::put('activate/{id}', [UserController::class, 'activate'])->name('activate');
        Route::put('deactivate/{id}', [UserController::class, 'deactivate'])->name('deactivate');
        Route::put('roles-update/{id}', [UserController::class, 'roles_user_update'])->name('roles_user_update');
    });

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    // PERMISSIONS
    Route::get('permissions/data', [PermissionController::class, 'data'])->name('permissions.data');
    Route::resource('permissions', PermissionController::class);

    // DASHBOARD
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/test', [DashboardController::class, 'test'])->name('test');
    });

    // EQUIPMENTS
    Route::prefix('equipments')->name('equipments.')->group(function () {
        Route::get('/data', [EquipmentController::class, 'index_data'])->name('index.data');
        Route::get('/{equipment}/movings/data', [EquipmentController::class, 'equipment_movings_data'])->name('movings.data');
        Route::get('/{equipment}/changes/data', [EquipmentController::class, 'equipment_changes_data'])->name('changes.data');
        Route::get('/{equipment}/legals/data', [EquipmentController::class, 'equipment_legals_data'])->name('legals.data');
        Route::get('/{equipment}/acquisitions/data', [EquipmentController::class, 'equipment_acquisitions_data'])->name('acquisitions.data');
        Route::get('/{equipment}/insurance/data', [EquipmentController::class, 'equipment_insurance_data'])->name('insurance.data');
        Route::get('/{equipment}/others/data', [EquipmentController::class, 'equipment_others_data'])->name('others.data');
        Route::get('/{equipment}/edit_detail', [EquipmentController::class, 'edit_detail'])->name('edit_detail');
        Route::put('/{equipment}/update_detail', [EquipmentController::class, 'update_detail'])->name('update_detail');
        Route::get('/export_excel', [EquipmentController::class, 'equipment_export_excel'])->name('export_excel');
        Route::post('/update_rfu', [EquipmentController::class, 'update_rfu'])->name('update_rfu');
        Route::post('/update_bd', [EquipmentController::class, 'update_bd'])->name('update_bd');
        // PHOTOS
        Route::get('/{equipment_id}/photos', [EquipmentController::class, 'photos_index'])->name('photos.index');
        Route::post('/{equipment_id}/photos', [EquipmentController::class, 'photos_store'])->name('photos.store');
        Route::delete('/photos/{photo_id}', [EquipmentController::class, 'photos_destroy'])->name('photos.destroy');
    });
    Route::resource('equipments', EquipmentController::class);

    // MOVINGS
    Route::prefix('movings')->name('movings.')->group(function () {
        Route::get('/data', [MovingController::class, 'index_data'])->name('index.data');
        Route::get('/{moving}/print_pdf', [MovingController::class, 'print_pdf'])->name('print_pdf');
        Route::get('/{moving}/print2_pdf', [MovingController::class, 'print2_pdf'])->name('print2_pdf');
        Route::get('/{moving}/before_select', [MovingController::class, 'edit_before_select_equipment'])->name('before_select_equipment');
        Route::put('/{moving}/before_select', [MovingController::class, 'update_before_select_equipment'])->name('update_before_select_equipment');
    });
    Route::resource('movings', MovingController::class);

    // Custom route for equipment details
    Route::get('/moving/{moving}/equipment', [MovingController::class, 'get_equipment_details']);

    Route::prefix('moving_details')->name('moving_details.')->group(function () {
        Route::get('/incart/data', [MovingDetailController::class, 'unit_incart_data'])->name('unit_incart.data');
        Route::get('/{from_project_id}/data', [MovingDetailController::class, 'available_unit_data'])->name('available_unit.data');
        Route::get('/{moving_id}/create', [MovingDetailController::class, 'create'])->name('create');
        Route::post('/', [MovingDetailController::class, 'store'])->name('store');
        Route::patch('/{equipment_id}/add_tocart', [MovingDetailController::class, 'add_tocart'])->name('add_tocart');
        Route::patch('/{equipment_id}/remove_fromcart', [MovingDetailController::class, 'remove_fromcart'])->name('remove_fromcart');
    });

    // UNIT NUMBER HISTORIES
    Route::get('unitnohistories/data', [UnitnoHistoryController::class, 'index_data'])->name('unitno_histories.index.data');
    Route::resource('unitnohistories', UnitnoHistoryController::class);

    // DOCUMENTS
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/data', [DocumentController::class, 'index_data'])->name('index.data');
        Route::get('/{id}/extends', [DocumentController::class, 'extends_edit'])->name('extends_edit');
        Route::put('/{id}/extends', [DocumentController::class, 'extends_update'])->name('extends_update');
    });
    Route::resource('documents', DocumentController::class);

    // ASSET CATEGORIES
    Route::get('asset_categories/data', [AssetCategoryController::class, 'index_data'])->name('asset_categories.index.data');
    Route::resource('asset_categories', AssetCategoryController::class);

    // DOCUMENT TYPES
    Route::get('doctypes/data', [DocumentTypeController::class, 'index_data'])->name('doctypes.index.data');
    Route::resource('doctypes', DocumentTypeController::class);

    // MANUFACTURES
    Route::get('manufactures/data', [ManufactureController::class, 'data'])->name('manufactures.data');
    Route::resource('manufactures', ManufactureController::class);

    // PROJECTS
    Route::get('projects/data', [ProjectController::class, 'data'])->name('projects.data');
    Route::resource('projects', ProjectController::class);

    // PLANT TYPES
    Route::get('planttypes/data', [PlantTypeController::class, 'data'])->name('planttypes.data');
    Route::resource('planttypes', PlantTypeController::class);

    // PLANT GROUPS
    Route::get('plant_groups/data', [PlantGroupController::class, 'data'])->name('plant_groups.data');
    Route::resource('plant_groups', PlantGroupController::class);

    // SUPPLIERS
    Route::get('suppliers/data', [SupplierController::class, 'data'])->name('suppliers.data');
    Route::resource('suppliers', SupplierController::class);

    // UNIT MODELS
    Route::get('unitmodels/data', [UnitmodelController::class, 'data'])->name('unitmodels.data');
    Route::resource('unitmodels', UnitmodelController::class);

    // UNIT STATUS
    Route::get('unitstatuses/data', [UnitstatusController::class, 'data'])->name('unitstatuses.data');
    Route::resource('unitstatuses', UnitstatusController::class);

    //REPORTS
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/with_overdue/data', [ReportController::class, 'document_with_overdue_data'])->name('document_with_overdue_data');
        Route::get('/with_overdue/data', [ReportController::class, 'document_with_overdue_data'])->name('document_with_overdue_data');
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/with_overdue', [ReportController::class, 'document_with_overdue'])->name('document_with_overdue');
        Route::get('/report1', [ReportController::class, 'report1_create'])->name('report1_create');
        Route::post('/report1', [ReportController::class, 'report1_display'])->name('report1_display');
        Route::get('/report1/data', [ReportController::class, 'report1_data'])->name('report1_data');
        //summary IPA
        Route::get('/summary_ipa', [ReportSummaryIpaController::class, 'index'])->name('summary_ipa.index');
        Route::post('/summary_ipa', [ReportSummaryIpaController::class, 'display'])->name('summary_ipa.display');
        Route::post('/summary_ipa/export', [ReportSummaryIpaController::class, 'export'])->name('summary_ipa.export');
        //active status
        Route::get('/active_status', [ReportActiveStatusController::class, 'index'])->name('active_status.index');
        Route::get('/active_status/data', [ReportActiveStatusController::class, 'data'])->name('active_status.data');
        Route::get('/active_status/export', [ReportActiveStatusController::class, 'export'])->name('active_status.export');
    });
});

Route::get('/model_detail', [UnitmodelController::class, 'get_model_detail'])->name('get_model_detail');
Route::get('/get_plant_groups', [PlantGroupController::class, 'get_plant_group_by_plant_type_id'])->name('get_plant_groups');
