<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutBuilderController;
use App\Http\Controllers\GlobalPaymentConfigController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\EnhancedDashboardController;
use App\Http\Controllers\Admin\EnhancedAdminController;

/*
|--------------------------------------------------------------------------
| Enhanced Features Routes
|--------------------------------------------------------------------------
|
| Rotas para as novas funcionalidades implementadas:
| - Checkout Builder
| - Sistema de Taxas e Comissões
| - Split Payments e Payouts
| - Sistema de Reembolsos
| - Dashboard Aprimorado
|
*/

// ====== ROTAS DE USUÁRIO (USER) ======

Route::group(['prefix' => 'user', 'middleware' => 'auth:user'], function () {

    // Dashboard Aprimorado
    Route::group(['prefix' => 'enhanced-dashboard'], function () {
        Route::get('/', [EnhancedDashboardController::class, 'index'])->name('user.enhanced-dashboard');
        Route::get('/financial', [EnhancedDashboardController::class, 'financial'])->name('user.enhanced-dashboard.financial');
        Route::get('/analytics', [EnhancedDashboardController::class, 'analytics'])->name('user.enhanced-dashboard.analytics');
        Route::get('/reports', [EnhancedDashboardController::class, 'reports'])->name('user.enhanced-dashboard.reports');
        Route::get('/gateways', [EnhancedDashboardController::class, 'gateways'])->name('user.enhanced-dashboard.gateways');
        Route::get('/notifications', [EnhancedDashboardController::class, 'notifications'])->name('user.enhanced-dashboard.notifications');

        // APIs para dados em tempo real
        Route::get('/api/balance', [EnhancedDashboardController::class, 'apiBalance'])->name('user.api.balance');
        Route::get('/api/transactions', [EnhancedDashboardController::class, 'apiRecentTransactions'])->name('user.api.transactions');
        Route::get('/api/chart-data', [EnhancedDashboardController::class, 'apiChartData'])->name('user.api.chart-data');
        Route::get('/api/metrics', [EnhancedDashboardController::class, 'apiPerformanceMetrics'])->name('user.api.metrics');
    });

    // Checkout Builder
    Route::group(['prefix' => 'checkout-builder'], function () {
        // Rota de teste
        Route::get('/test', function() {
            return response()->json([
                'status' => 'success',
                'message' => 'Checkout Builder está funcionando! ✓',
                'timestamp' => now()->toDateTimeString(),
                'environment' => app()->environment()
            ]);
        })->name('user.checkout-builder.test');

        Route::get('/', [CheckoutBuilderController::class, 'index'])->name('user.checkout-builder.index');
        Route::get('/create', [CheckoutBuilderController::class, 'create'])->name('user.checkout-builder.create');
        Route::post('/', [CheckoutBuilderController::class, 'store'])->name('user.checkout-builder.store');
        Route::get('/{id}', [CheckoutBuilderController::class, 'show'])->name('user.checkout-builder.show');
        Route::get('/{id}/edit', [CheckoutBuilderController::class, 'edit'])->name('user.checkout-builder.edit');
        Route::put('/{id}', [CheckoutBuilderController::class, 'update'])->name('user.checkout-builder.update');
        Route::delete('/{id}', [CheckoutBuilderController::class, 'destroy'])->name('user.checkout-builder.destroy');
        Route::post('/{id}/activate', [CheckoutBuilderController::class, 'activate'])->name('user.checkout-builder.activate');
        Route::post('/{id}/deactivate', [CheckoutBuilderController::class, 'deactivate'])->name('user.checkout-builder.deactivate');
        Route::post('/{id}/duplicate', [CheckoutBuilderController::class, 'duplicate'])->name('user.checkout-builder.duplicate');
        Route::get('/{id}/analytics', [CheckoutBuilderController::class, 'analytics'])->name('user.checkout-builder.analytics');
        Route::get('/{id}/export', [CheckoutBuilderController::class, 'exportData'])->name('user.checkout-builder.export');
    });

    // Configuração Global de Pagamentos
    Route::group(['prefix' => 'payment-config'], function () {
        Route::get('/', [GlobalPaymentConfigController::class, 'index'])->name('user.payment-config.index');
        Route::post('/payment-methods', [GlobalPaymentConfigController::class, 'updatePaymentMethods'])->name('user.payment-config.payment-methods');
        Route::post('/fees', [GlobalPaymentConfigController::class, 'updateFees'])->name('user.payment-config.fees');
        Route::post('/installment-fees', [GlobalPaymentConfigController::class, 'updateInstallmentFees'])->name('user.payment-config.installment-fees');
        Route::post('/preview', [GlobalPaymentConfigController::class, 'getPaymentPreview'])->name('user.payment-config.preview');
        Route::post('/reset', [GlobalPaymentConfigController::class, 'resetToDefaults'])->name('user.payment-config.reset');
        Route::get('/export', [GlobalPaymentConfigController::class, 'exportConfig'])->name('user.payment-config.export');
        Route::post('/import', [GlobalPaymentConfigController::class, 'importConfig'])->name('user.payment-config.import');
    });

    // Payouts (Saques)
    Route::group(['prefix' => 'payouts'], function () {
        Route::get('/', [PayoutController::class, 'index'])->name('user.payouts.index');
        Route::get('/create', [PayoutController::class, 'create'])->name('user.payouts.create');
        Route::post('/', [PayoutController::class, 'store'])->name('user.payouts.store');
        Route::get('/{id}', [PayoutController::class, 'show'])->name('user.payouts.show');
        Route::post('/{id}/cancel', [PayoutController::class, 'cancel'])->name('user.payouts.cancel');
        Route::post('/{id}/retry', [PayoutController::class, 'retry'])->name('user.payouts.retry');
        Route::get('/history/export', [PayoutController::class, 'export'])->name('user.payouts.export');
        Route::get('/history/detailed', [PayoutController::class, 'history'])->name('user.payouts.history');

        // APIs
        Route::get('/api/balance', [PayoutController::class, 'getAvailableBalance'])->name('user.payouts.api.balance');
        Route::post('/api/calculate-fee', [PayoutController::class, 'calculateFee'])->name('user.payouts.api.calculate-fee');
    });

    // Reembolsos
    Route::group(['prefix' => 'refunds'], function () {
        Route::get('/', [RefundController::class, 'index'])->name('user.refunds.index');
        Route::get('/create', [RefundController::class, 'create'])->name('user.refunds.create');
        Route::post('/', [RefundController::class, 'store'])->name('user.refunds.store');
        Route::get('/{id}', [RefundController::class, 'show'])->name('user.refunds.show');
        Route::post('/{id}/cancel', [RefundController::class, 'cancel'])->name('user.refunds.cancel');
        Route::get('/history/export', [RefundController::class, 'export'])->name('user.refunds.export');
        Route::get('/history/detailed', [RefundController::class, 'history'])->name('user.refunds.history');

        // APIs
        Route::post('/api/check-eligibility', [RefundController::class, 'checkEligibility'])->name('user.refunds.api.eligibility');
        Route::post('/api/calculate-fee', [RefundController::class, 'calculateFee'])->name('user.refunds.api.calculate-fee');
    });
});

// ====== ROTAS PÚBLICAS ======

// Preview do Checkout Builder
Route::get('/checkout-builder/{slug}', [CheckoutBuilderController::class, 'preview'])->name('checkout-builder.preview');

// ====== ROTAS ADMINISTRATIVAS ======

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {

    // Dashboard Administrativo Aprimorado
    Route::group(['prefix' => 'enhanced'], function () {
        Route::get('/dashboard', [EnhancedAdminController::class, 'dashboard'])->name('admin.enhanced.dashboard');
        Route::get('/financial', [EnhancedAdminController::class, 'financial'])->name('admin.enhanced.financial');
        Route::get('/users', [EnhancedAdminController::class, 'userManagement'])->name('admin.enhanced.users');
        Route::get('/risk', [EnhancedAdminController::class, 'riskControl'])->name('admin.enhanced.risk');
        Route::get('/settings', [EnhancedAdminController::class, 'globalSettings'])->name('admin.enhanced.settings');
        Route::get('/reports', [EnhancedAdminController::class, 'executiveReports'])->name('admin.enhanced.reports');
        Route::get('/liquidation', [EnhancedAdminController::class, 'liquidationControl'])->name('admin.enhanced.liquidation');

        // APIs Administrativas
        Route::get('/api/overview', [EnhancedAdminController::class, 'apiOverview'])->name('admin.api.overview');
        Route::get('/api/transaction-stats', [EnhancedAdminController::class, 'apiTransactionStats'])->name('admin.api.transaction-stats');
        Route::get('/api/user-stats', [EnhancedAdminController::class, 'apiUserStats'])->name('admin.api.user-stats');
        Route::get('/api/financial-metrics', [EnhancedAdminController::class, 'apiFinancialMetrics'])->name('admin.api.financial-metrics');
        Route::get('/api/system-health', [EnhancedAdminController::class, 'apiSystemHealth'])->name('admin.api.system-health');
        Route::get('/api/alerts', [EnhancedAdminController::class, 'apiAlerts'])->name('admin.api.alerts');

        // Ações Administrativas
        Route::post('/users/{id}/approve', [EnhancedAdminController::class, 'approveUser'])->name('admin.users.approve');
        Route::post('/users/{id}/suspend', [EnhancedAdminController::class, 'suspendUser'])->name('admin.users.suspend');
        Route::post('/users/{id}/adjust-fees', [EnhancedAdminController::class, 'adjustUserFees'])->name('admin.users.adjust-fees');
    });

    // Gestão de Checkout Builders (Admin)
    Route::group(['prefix' => 'checkout-builders'], function () {
        Route::get('/', [CheckoutBuilderController::class, 'adminIndex'])->name('admin.checkout-builders.index');
        Route::get('/{id}', [CheckoutBuilderController::class, 'adminShow'])->name('admin.checkout-builders.show');
        Route::post('/{id}/approve', [CheckoutBuilderController::class, 'adminApprove'])->name('admin.checkout-builders.approve');
        Route::post('/{id}/reject', [CheckoutBuilderController::class, 'adminReject'])->name('admin.checkout-builders.reject');
        Route::delete('/{id}', [CheckoutBuilderController::class, 'adminDestroy'])->name('admin.checkout-builders.destroy');
    });

    // Gestão de Payouts (Admin)
    Route::group(['prefix' => 'payouts'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\PayoutController::class, 'index'])->name('admin.payouts.index');
        Route::get('/pending', [\App\Http\Controllers\Admin\PayoutController::class, 'pending'])->name('admin.payouts.pending');
        Route::post('/approve-batch', [\App\Http\Controllers\Admin\PayoutController::class, 'approveBatch'])->name('admin.payouts.approve-batch');
        Route::post('/{id}/approve', [\App\Http\Controllers\Admin\PayoutController::class, 'approve'])->name('admin.payouts.approve');
        Route::post('/{id}/reject', [\App\Http\Controllers\Admin\PayoutController::class, 'reject'])->name('admin.payouts.reject');
        Route::get('/{id}', [\App\Http\Controllers\Admin\PayoutController::class, 'show'])->name('admin.payouts.show');
    });

    // Gestão de Reembolsos (Admin)
    Route::group(['prefix' => 'refunds'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\RefundController::class, 'index'])->name('admin.refunds.index');
        Route::get('/pending', [\App\Http\Controllers\Admin\RefundController::class, 'pending'])->name('admin.refunds.pending');
        Route::post('/{id}/approve', [\App\Http\Controllers\Admin\RefundController::class, 'approve'])->name('admin.refunds.approve');
        Route::post('/{id}/reject', [\App\Http\Controllers\Admin\RefundController::class, 'reject'])->name('admin.refunds.reject');
        Route::get('/{id}', [\App\Http\Controllers\Admin\RefundController::class, 'show'])->name('admin.refunds.show');
    });

    // Configurações Globais de Taxas
    Route::group(['prefix' => 'fee-structures'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\FeeStructureController::class, 'index'])->name('admin.fee-structures.index');
        Route::get('/create', [\App\Http\Controllers\Admin\FeeStructureController::class, 'create'])->name('admin.fee-structures.create');
        Route::post('/', [\App\Http\Controllers\Admin\FeeStructureController::class, 'store'])->name('admin.fee-structures.store');
        Route::get('/{id}/edit', [\App\Http\Controllers\Admin\FeeStructureController::class, 'edit'])->name('admin.fee-structures.edit');
        Route::put('/{id}', [\App\Http\Controllers\Admin\FeeStructureController::class, 'update'])->name('admin.fee-structures.update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\FeeStructureController::class, 'destroy'])->name('admin.fee-structures.destroy');
    });
});