<?php
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\BackupController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\ExpenseTypeController;
use App\Http\Controllers\Api\FoodCategoryController;
use App\Http\Controllers\Api\FoodItemController;
use App\Http\Controllers\Api\ImportExportController;
use App\Http\Controllers\Api\IngredientController;
use App\Http\Controllers\Api\InvoicePrintController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\Locale\LocaleController;
use App\Http\Controllers\Api\Media\MediaController;
use App\Http\Controllers\Api\ModifierController;
use App\Http\Controllers\Api\PaymentMethodController;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\ServiceTableController;
use App\Http\Controllers\Api\SettingAxillaryController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::get('system-config', [ApiController::class, 'protection'])->name('system.config');

Route::group(["prefix" => config('app.version', 'codehas'), 'middleware' => 'ajax'], function () {
    Route::group(["prefix" => "files"], function () {
        Route::get("/{file}", [MediaController::class, 'show'])->name('files.show');
        Route::post('save', [MediaController::class, 'store'])->name('files.store');
        Route::get("download/{uuid}", [MediaController::class, 'download'])->name('files.download');
        Route::post('attachments', [MediaController::class, 'uploadAttachment'])->name('file.upload-attachment');
    });

    Route::group(["prefix" => "auth", "namespace " => "Auth"], function () {
        Route::post('login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::post('register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('recover', [AuthController::class, 'recover'])->name('auth.recover');
        Route::post('reset', [AuthController::class, 'reset'])->name('auth.reset');
        Route::get("user", [AuthController::class, 'user'])->name('auth.user');
        Route::post('check', [AuthController::class, 'check'])->name('auth.check');
    });

    Route::group(["prefix" => "lang", "namespace " => "Language"], function () {
        Route::get('/', [LocaleController::class, 'languageList'])->name('language.list');
        Route::get('/{lang}', [LocaleController::class, 'get'])->name('language.get');
        Route::post('/set-language', [LocaleController::class, 'set'])->name('set-locale');
    });

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::group(['prefix' => 'pos'], function () {
            Route::get('sale/{sale}', [InvoicePrintController::class, 'sale'])->name('print-sale');
            Route::get('categories', [PosController::class, 'categories'])->name('pos.categories');
            Route::get('payment-methods', [PosController::class, 'paymentMethods'])->name('pos.payment-methods');
            Route::get('avl-service-tables', [PosController::class, 'serviceTables'])->name('pos.service-tables');
            Route::get('products', [PosController::class, 'products'])->name('pos.products');
            Route::get('modifiers', [PosController::class, 'modifiers'])->name('pos.modifiers');
            Route::get('kitchen-orders', [PosController::class, 'kitchenOrders'])->name('pos.kitchen-orders');
            Route::post('order-progress/{sale}', [PosController::class, 'orderProgressUpdate'])->name('pos.order-progress');
            Route::get('customers', [PosController::class, 'customers'])->name('pos.customers');
            Route::post('checkout/{sale}', [PosController::class, 'checkout'])->name('pos.checkout');
            Route::post('submited-sale', [PosController::class, 'submitedOrder'])->name('pos.submited-order');
            Route::get('get-submitted-orders', [PosController::class, 'submiitedOrders'])->name('pos.submited-orders');
        });
        Route::group(["prefix" => "account"], function () {
            Route::post('update', [AccountController::class, 'update'])->name('account.update');
            Route::post('password', [AccountController::class, 'password'])->name('account.password');
        });
        Route::group(["prefix" => "admin"], function () {
            Route::get('dashboard-states', [DashboardController::class, 'states'])->name('dashboard-states');
            Route::get('dashboard-ghraphical', [DashboardController::class, 'annualGraph'])->name('dashboard-ag');

            Route::get("backups", [BackupController::class, 'index'])->name('backup.index');
            Route::post('backups', [BackupController::class, 'generate'])->name('backup.generate');
            Route::patch('backups/{file}/restore', [BackupController::class, 'restore'])->name('backup.restore');
            Route::post('backups/{file}/remove', [BackupController::class, 'destroy'])->name("backup.destroy");
            Route::get('users/user/roles', [UserController::class, 'userRoles'])->name('users.user-roles');
            Route::get('roles/permissions', [UserRoleController::class, 'permissions'])->name('user-roles.permissions');
            Route::post('languages/sync', [LanguageController::class, 'sync'])->name('language.sync');

            Route::group(["prefix" => "settings"], function () {
                Route::get('user-roles', [SettingController::class, 'userRoles'])->name('settings.user-roles');
                Route::get('languages', [SettingController::class, 'languages'])->name('settings.languages');
                Route::get('general', [SettingController::class, 'getGeneral'])->name('settings.get.general');
                Route::post('general', [SettingController::class, 'setGeneral'])->name('settings.set.general');
                Route::get('appearance', [SettingController::class, 'getAppearance'])->name('settings.get.appearance');
                Route::post('appearance', [SettingController::class, 'setAppearance'])->name('settings.set.appearance');
                Route::get('localization', [SettingController::class, 'getLocalization'])->name('settings.get.localization');
                Route::post('localization', [SettingController::class, 'setLocalization'])->name('settings.set.localization');
                Route::post('setting-optimize', [SettingController::class, 'optimize'])->name('settings.optimize');
                Route::get('authentication', [SettingAxillaryController::class, 'getAuthentication'])->name('settings.get.authentication');
                Route::post('authentication', [SettingAxillaryController::class, 'setAuthentication'])->name('settings.set.authentication');
                Route::get('outgoing/mail', [SettingAxillaryController::class, 'getOutgoingMail'])->name('settings.get.outgoing.mail');
                Route::post('outgoing/mail', [SettingAxillaryController::class, 'setOutgoingMail'])->name('settings.set.outgoing.mail');
                Route::get('captcha', [SettingAxillaryController::class, 'getCaptcha'])->name('settings.get.captcha');
                Route::post('captcha', [SettingAxillaryController::class, 'setCaptcha'])->name('settings.set.captcha');
                Route::get('tax', [SettingAxillaryController::class, 'getTax'])->name('settings.get.tax');
                Route::post('tax', [SettingAxillaryController::class, 'setTax'])->name('settings.set.tax');
                Route::get('currency', [SettingAxillaryController::class, 'getCurrency'])->name('settings.get.currency');
                Route::post('currency', [SettingAxillaryController::class, 'setCurrency'])->name('settings.set.currency');
            });
            Route::get('food-ingredients', [IngredientController::class, 'getList'])->name('food.ingredients');
            Route::get('food-categories-list', [FoodCategoryController::class, 'categories'])->name('food.categories');
            Route::get('sale.filters', [SaleController::class, 'filters'])->name('sale.filters');
            Route::get('sale-report', [ReportController::class, 'generate'])->name('sale.report');

            Route::post('exports', [ImportExportController::class, 'export'])->name('exports');
            Route::post('imports', [ImportExportController::class, 'imports'])->name('imports');

            Route::delete('modifiers-rows-destroy', [ModifierController::class, 'destroyBatch'])->name('modifiers.rows.destroy');
            Route::delete('food-category-rows-destroy', [FoodCategoryController::class, 'destroyBatch'])->name('food-category.rows.destroy');
            Route::delete('food-items-rows-destroy', [FoodItemController::class, 'destroyBatch'])->name('products.rows.destroy');
            Route::delete('ingredients-rows-destroy', [IngredientController::class, 'destroyBatch'])->name('ingredients.rows.destroy');
            Route::delete('expense-rows-destroy', [ExpenseController::class, 'destroyBatch'])->name('expenses.rows.destroy');
            Route::get('expense-types.list', [ExpenseTypeController::class, 'expenseTypes'])->name('expense-types.list');

            Route::post('report-tax', [ReportController::class, 'tax'])->name('tax.report');
            Route::post('report-expense', [ReportController::class, 'expense'])->name('expense.report');
            Route::get('stock-alerts', [ReportController::class, 'stockAlerts'])->name('stock.alerts');

            Route::apiResource('expenses', ExpenseController::class);
            Route::apiResource('expense-types', ExpenseTypeController::class);
            Route::apiResource('payment-methods', PaymentMethodController::class);
            Route::apiResource('modifiers', ModifierController::class);
            Route::apiResource('sales', SaleController::class);
            Route::apiResource('food-items', FoodItemController::class);
            Route::apiResource('ingredients', IngredientController::class);
            Route::apiResource('food-categories', FoodCategoryController::class);
            Route::apiResource('customers', CustomerController::class);
            Route::apiResource('service-tables', ServiceTableController::class);
            Route::apiResource("users", UserController::class);
            Route::apiResource("user-roles", UserRoleController::class);
            Route::apiResource("languages", LanguageController::class);
        });
    });
});
