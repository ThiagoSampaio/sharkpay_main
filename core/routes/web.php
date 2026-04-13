<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\faController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\Localization;
use App\Http\Controllers\User\ForgotPasswordController;
use App\Http\Controllers\User\ResetPasswordController;
use App\Http\Controllers\PixController;
use App\Http\Controllers\BancoBrasilController;
use App\Http\Controllers\BancoOriginalController;
use App\Http\Controllers\TreealvController;
use App\Http\Controllers\CieloController;
use App\Http\Controllers\AccountComplianceController;
use App\Http\Controllers\Admin\UserComplianceController;
use App\Http\Controllers\Admin\FinancialManagementController;
use App\Http\Controllers\Admin\AccountFlowController;
use App\Http\Controllers\Payment\InvoicePaymentController;
use App\Http\Controllers\Payment\FundPaymentController;
use App\Http\Controllers\Payment\SingleChargePaymentController;
use App\Http\Controllers\Payment\DonationPaymentController;
use App\Http\Controllers\Payment\StorePaymentController;
use App\Http\Controllers\Payment\ProductPaymentController;

use App\Http\Controllers\Reports\User\DonationsReportController;
use App\Http\Controllers\Reports\User\FundsReportController;
use App\Http\Controllers\Reports\User\InvoicesReportController;
use App\Http\Controllers\Reports\User\LinksReportController;
use App\Http\Controllers\Reports\User\OrdersReportController;
use App\Http\Controllers\Reports\User\ProductsReportController;
use App\Http\Controllers\Reports\User\ComissionsReportController;

use App\Http\Controllers\ExportReportController;
use App\Http\Controllers\Webhooks\FitbankWebhooksController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('asset/{path}', function (string $path) {
    $assetRoot = realpath(base_path('../asset'));

    if ($assetRoot === false) {
        abort(404);
    }

    $requestedPath = $assetRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $path);
    $requestedFile = realpath($requestedPath);

    if ($requestedFile === false) {
        $requestedDirectory = dirname($requestedPath);
        $requestedFilename = basename($requestedPath);
        $realDirectory = realpath($requestedDirectory);

        if (
            $realDirectory !== false
            && str_starts_with($realDirectory . DIRECTORY_SEPARATOR, $assetRoot . DIRECTORY_SEPARATOR)
            && preg_match('/^(logo|section[1-7])_\d+\.(png|jpg|jpeg|gif|webp)$/i', $requestedFilename, $matches)
        ) {
            $fallbackCandidates = glob($realDirectory . DIRECTORY_SEPARATOR . $matches[1] . '_*.*') ?: [];

            usort($fallbackCandidates, function ($left, $right) {
                return filemtime($right) <=> filemtime($left);
            });

            foreach ($fallbackCandidates as $candidate) {
                $resolvedCandidate = realpath($candidate);

                if ($resolvedCandidate !== false && is_file($resolvedCandidate)) {
                    $requestedFile = $resolvedCandidate;
                    break;
                }
            }
        }
    }

    if ($requestedFile === false || !str_starts_with($requestedFile, $assetRoot . DIRECTORY_SEPARATOR) || !is_file($requestedFile)) {
        abort(404);
    }

    $extension = strtolower(pathinfo($requestedFile, PATHINFO_EXTENSION));
    $contentTypes = [
        'js' => 'application/javascript',
        'css' => 'text/css; charset=UTF-8',
        'svg' => 'image/svg+xml',
        'json' => 'application/json',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'otf' => 'font/otf',
        'eot' => 'application/vnd.ms-fontobject',
    ];

    return response()->file($requestedFile, [
        'Content-Type' => $contentTypes[$extension] ?? (mime_content_type($requestedFile) ?: 'application/octet-stream'),
    ]);
})->where('path', '.*');

Route::get('__debug/home-fragment', function () {
    $response = app(\App\Http\Controllers\FrontendController::class)->index();
    $html = $response->render();
    $anchor = 'Todos os direitos reservados';
    $anchorPos = strpos($html, $anchor);
    $start = $anchorPos === false ? 0 : max(0, $anchorPos - 200);
    $length = 2500;
    $fragment = substr($html, $start, $length);

    return response()->json([
        'anchor_found' => $anchorPos !== false,
        'fragment_is_valid_utf8' => mb_check_encoding($fragment, 'UTF-8'),
        'fragment_base64' => base64_encode($fragment),
        'fragment_preview' => $fragment,
    ], 200, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
});

Route::get('__debug/included-files', function () {
    $files = array_values(array_filter(get_included_files(), function ($file) {
        return str_starts_with($file, base_path())
            && !str_contains($file, DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR)
            && !str_contains($file, DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR);
    }));

    sort($files);

    return response()->json([
        'files' => $files,
    ], 200, [], JSON_UNESCAPED_SLASHES);
});

Route::get('__debug/output-buffer', function () {
    $buffers = [];

    while (ob_get_level() > 0) {
        $buffers[] = ob_get_contents();
        ob_end_clean();
    }

    return response()->json([
        'buffer_count' => count($buffers),
        'buffers' => array_map(function ($buffer) {
            return [
                'length' => strlen($buffer),
                'valid_utf8' => mb_check_encoding($buffer, 'UTF-8'),
                'base64' => base64_encode(substr($buffer, 0, 4000)),
            ];
        }, $buffers),
    ], 200, [], JSON_UNESCAPED_SLASHES);
});


Route::get('report/invalid/invoices', [ExportReportController::class, 'index']);
Route::post('treeal/callbacks', [TreealvController::class, 'index'])->name("treealv.callback");
Route::post('bancobrasil/callbacks', [BancoBrasilController::class, 'index']);
Route::post('bancooriginal/callbacks', [BancoOriginalController::class, 'index']);
Route::post('cielo/callbacks', [CieloController::class, 'index']);
Route::post('fitbank/callbacks', [FitbankWebhooksController::class, 'index']);


Route::get('cron/originalhub/auth', [BancoOriginalController::class, 'auth']);
Route::post('cron/originalhub/token', [BancoOriginalController::class, 'token']);

// Payment Routes
Route::post('invoice/proccess/payment', [InvoicePaymentController::class, 'processInvoice'])->name('invoice.proccess.payment');
Route::post('invoice/verify/payment', [InvoicePaymentController::class, 'verifyInvoice'])->name('invoice.verify.payment');


//Fund account IPN
Route::get('lang/{locale}', [LocalizationController::class, 'index']);
Route::get('ipncoinpaybtc', [PaymentController::class, 'ipnCoinPayBtc'])->name('ipn.coinPay.btc');
Route::get('ipncoinpayeth', [PaymentController::class, 'ipnCoinPayEth'])->name('ipn.coinPay.eth');
Route::get('ipnflutter', [PaymentController::class, 'flutterIPN'])->name('ipn.flutter');
Route::get('ipnpaystack', [PaymentController::class, 'paystackIPN'])->name('ipn.paystack');
Route::get('ipnpaypal', [PaymentController::class, 'ipnpaypal'])->name('ipn.paypal');
Route::get('ipnvirtual', [PaymentController::class, 'ipnVirtual'])->name('ipn.virtual');
Route::get('ipnboompay', [PaymentController::class, 'ipnboompay'])->name('ipn.boompay');
Route::get('cart', [UserController::class, 'cart'])->name('cart');
Route::get('cart/recover/{id}', [UserController::class, 'recoverCart'])->name('cart.recover');
Route::get('delete-cart/{id}', [UserController::class, 'deletecart'])->name('delete.cart');
Route::post('ext_transfer', [UserController::class, 'submitpay'])->name('submit.pay');
Route::post('update-cart', [UserController::class, 'updatecart'])->name('update.cart');
Route::get('single-charge/{id}', [UserController::class, 'scviewlink'])->name('scview.link');
Route::post('link/proccess/payment', [SingleChargePaymentController::class, 'processLink'])->name('link.proccess.payment');
Route::post('link/verify/payment', [SingleChargePaymentController::class, 'verifyLink'])->name('link.verify.payment');
Route::get('card-single-charge/{id}', [UserController::class, 'cardscviewlink'])->name('card.scview.link');
Route::get('account-single-charge/{id}', [UserController::class, 'accountscviewlink'])->name('account.scview.link');
Route::get('pix-single-charge/{id}', [UserController::class, 'pixscviewlink'])->name('pix.scview.link');
Route::get('boleto-single-charge/{id}', [UserController::class, 'boletoscviewlink'])->name('boleto.scview.link');
Route::get('stripe-single-charge/{id}', [UserController::class, 'stripescviewlink'])->name('stripe.scview.link');
Route::get('store/{id}', [UserController::class, 'storelink'])->name('store.link');
Route::get('product/{store}/{product}', [UserController::class, 'productlink'])->name('sproduct.link');
Route::post('donation/proccess/payment', [DonationPaymentController::class, 'processDonation'])->name('donation.proccess.payment');
Route::post('donation/verify/payment', [DonationPaymentController::class, 'verifyDonation'])->name('donation.verify.payment');
Route::get('donation/{id}', [UserController::class, 'dpviewlink'])->name('dpview.link');
Route::get('card-donation-charge/{id}', [UserController::class, 'carddpviewlink'])->name('card.dpview.link');
Route::get('account-donation-charge/{id}', [UserController::class, 'accountdpviewlink'])->name('account.dpview.link');
Route::get('boleto-donation-charge/{id}', [UserController::class, 'boletodpviewlink'])->name('boleto.dpview.link');
Route::get('pix-donation-charge/{id}', [UserController::class, 'pixdpviewlink'])->name('pix.dpview.link');
Route::get('stripe-donation-charge/{id}', [UserController::class, 'stripedpviewlink'])->name('stripe.dpview.link');
Route::post('pay-single', [UserController::class, 'Sendsingle'])->name('send.single');
Route::post('pay-donation', [UserController::class, 'Senddonation'])->name('send.donation');
Route::get('subscription/{id}', [UserController::class, 'subviewlink'])->name('subview.link');
Route::post('plan_charge', [UserController::class, 'submitplancharge'])->name('submit.plancharge');
Route::post('xplan_charge', [UserController::class, 'xsubmitplancharge'])->name('xsubmit.plancharge');
Route::get('invoice/{id}', [UserController::class, 'Viewinvoice'])->name('view.invoice');
Route::get('stripe-invoice/{id}/{ref_id}', [UserController::class, 'stripeViewinvoice'])->name('stripe.view.invoice');
Route::get('card-invoice/{id}', [UserController::class, 'cardViewinvoice'])->name('card.view.invoice');
Route::get('account-invoice/{id}', [UserController::class, 'accountViewinvoice'])->name('account.view.invoice');
Route::get('pix-invoice/{id}', [UserController::class, 'pixViewinvoice'])->name('pix.view.invoice');
Route::get('boleto-invoice/{id}', [UserController::class, 'boletoViewinvoice'])->name('boleto.view.invoice');
Route::post('pay-invoice', [UserController::class, 'Processinvoice'])->name('process.invoice');
Route::get('xpay/{id}/{xx}', [UserController::class, 'transferprocess'])->name('transfer.process');
Route::get('stripe_xpay/{id}/{xx}', [UserController::class, 'stripetransferprocess'])->name('stripe.transfer.process');
Route::post('submit_merchant', [UserController::class, 'Paymerchant'])->name('pay.merchant');
Route::get('buy-product/{id}', [UserController::class, 'buyproduct'])->name('product.link');
Route::get('checkout/{id}', [UserController::class, 'checkout'])->name('checkout');
Route::post('product/proccess/payment', [ProductPaymentController::class, 'processProduct'])->name('product.proccess.payment');
Route::post('product/verify/payment', [ProductPaymentController::class, 'verifyProduct'])->name('product.verify.payment');
Route::get('ask/{id}', [UserController::class, 'ask'])->name('user.ask');
Route::get('prod-card/{id}', [UserController::class, 'cardpay'])->name('user.cardpay');
Route::get('prod-account/{id}', [UserController::class, 'accountpay'])->name('user.accountpay'); 
Route::get('prod-pix/{id}', [UserController::class, 'pixpay'])->name('user.pixpay');
Route::get('prod-boleto/{id}', [UserController::class, 'boletopay'])->name('user.boletopay'); 
Route::get('sask/{id}', [UserController::class, 'sask'])->name('user.sask');
Route::post('checkout/proccess/payment', [StorePaymentController::class, 'proccessOrder'])->name('checkout.proccess.payment');
Route::post('checkout/verify/payment', [StorePaymentController::class, 'verifyOrder'])->name('checkout.verify.payment');
Route::get('scard/{id}', [UserController::class, 'scardpay'])->name('user.scardpay');
Route::get('spix/{id}', [UserController::class, 'spixpay'])->name('user.spixpay');
Route::get('sboleto/{id}', [UserController::class, 'sboletopay'])->name('user.sboletopay');
Route::get('saccount/{id}', [UserController::class, 'saccountpay'])->name('user.saccountpay');
Route::post('buyproduct', [UserController::class, 'acquireproduct'])->name('pay.product');
Route::post('checkoutproduct', [UserController::class, 'checkproduct'])->name('check.product');
Route::get('stripe-checkoutproduct/{id}', [UserController::class, 'stripecheckproduct'])->name('stripe.check.product');
Route::get('stripe-buyproduct/{id}', [UserController::class, 'stripeacquireproduct'])->name('stripe.pay.product');
Route::get('error', [UserController::class, 'transfererror'])->name('transfererror');
Route::post('use-virtual', [UserController::class, 'useVirtual'])->name('use.virtual');
Route::get('verify-payment', [UserController::class, 'Verifypayment']);
Route::get('contact', [UserController::class, 'contact'])->name('contact');
Route::get('faq', [UserController::class, 'faq'])->name('faq');

Route::post('creditcard/installment/table', [PaymentController::class, 'genInstallmentsTable'])->name('creditcard.calc.installments');
  
// Front end routes
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('faq', [FrontendController::class, 'faq'])->name('faq');
Route::get('about', [FrontendController::class, 'about'])->name('about');
Route::get('blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('terms', [FrontendController::class, 'terms'])->name('terms');
Route::get('privacy', [FrontendController::class, 'privacy'])->name('privacy');
Route::get('page/{id}', [FrontendController::class, 'page']);
Route::get('single/{id}/{slug}', [FrontendController::class, 'article']);
Route::get('cat/{id}/{slug}', [FrontendController::class, 'category']);
Route::get('contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('contact', [FrontendController::class, 'contactSubmit'])->name('contact-submit');
Route::post('about', [FrontendController::class, 'subscribe'])->name('subscribe');

// User routes
Auth::routes();

Route::post('login', [LoginController::class, 'submitlogin'])->name('submitlogin');
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('2fa', [faController::class, 'submitfa'])->name('submitfa');
Route::get('2fa', [faController::class, 'faverify'])->name('2fa');
Route::post('register', [RegisterController::class, 'submitregister'])->name('submitregister');
Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::get('/forget', [UserController::class, 'forget'])->name('forget');
Route::get('/r_pass', [UserController::class, 'r_pass'])->name('r_pass');
Route::group(['prefix' => 'user', ], function () {
    Route::get('blocked', [UserController::class, 'blocked'])->name('user.blocked');
    Route::get('authorization', [UserController::class, 'authCheck'])->name('user.authorization');   
    Route::post('verification', [UserController::class, 'sendVcode'])->name('user.send-vcode');
    Route::post('smsVerify', [UserController::class, 'smsVerify'])->name('user.sms-verify');
    Route::get('verify-email', [UserController::class, 'sendEmailVcode'])->name('user.send-emailVcode');
    Route::post('postEmailVerify', [UserController::class, 'postEmailVerify'])->name('user.email-verify'); 
        Route::group(['middleware'=>'auth:user'], function() {
            Route::get('no-kyc', [AccountComplianceController::class, 'complianceType'])->name('user.no-kyc');
            Route::get('no-country', [UserController::class, 'no_country'])->name('update.support.country');
            Route::post('compliance', [UserController::class, 'submitcompliance'])->name('submit.compliance');
            
            
            Route::get('account-compliance', [AccountComplianceController::class, 'complianceType'])->name('user.account-compliance');
            Route::get('personal-compliance', [AccountComplianceController::class, 'personalCompliance'])->name('user.personal-compliance');
            Route::get('personal-documents', [AccountComplianceController::class, 'personalDocuments'])->name('user.personal-documents');
            Route::post('personal-compliance', [AccountComplianceController::class, 'personalComplianceSave'])->name('submit.personal-compliance');
            Route::post('personal-compliance-selfie', [AccountComplianceController::class, 'personalSelfieFiles'])->name('submit.personal-compliance-selfie');
            Route::post('personal-compliance-proof', [AccountComplianceController::class, 'personalProofOfResidenceFiles'])->name('submit.personal-compliance-proof');
            Route::post('personal-compliance-document', [AccountComplianceController::class, 'personalDocumentFiles'])->name('submit.personal-compliance-document');
            
            Route::get('business-compliance', [AccountComplianceController::class, 'businessCompliance'])->name('user.business-compliance');
            Route::get('business-documents', [AccountComplianceController::class, 'businessDocuments'])->name('user.business-documents');
            Route::post('business-compliance', [AccountComplianceController::class, 'businessComplianceSave'])->name('submit.business-compliance');
            Route::get('business-documents', [AccountComplianceController::class, 'businessDocuments'])->name('user.business-documents');
            Route::post('business-compliance-proof', [AccountComplianceController::class, 'businessProofOfResidenceFiles'])->name('submit.business-compliance-proof');
            Route::post('business-compliance-registry', [AccountComplianceController::class, 'businessRegistryFiles'])->name('submit.business-compliance-registry');
            
            Route::get('original-compliance', [AccountComplianceController::class, 'originalHubCompliance'])->name('user.original-hub-compliance');
            Route::post('original-compliance-save', [AccountComplianceController::class, 'originalHubComplianceSave'])->name('user.original-hub-save');
            Route::get('original-compliance-token', [AccountComplianceController::class, 'originalHubComplianceToken'])->name('user.original-hub-token');
            Route::post('original-compliance-validate', [AccountComplianceController::class, 'originalHubComplianceValidate'])->name('user.original-hub-validate');
            
            Route::get('donations/report', [DonationsReportController::class, 'index'])->name('user.reports.donations');
            Route::post('donations/report', [DonationsReportController::class, 'index'])->name('user.submit.reports.donations');
            Route::get('funds/report', [FundsReportController::class, 'index'])->name('user.reports.funds');
            Route::post('funds/report', [FundsReportController::class, 'index'])->name('user.submit.reports.funds');
            Route::get('invoices/report', [InvoicesReportController::class, 'index'])->name('user.reports.invoices');
            Route::post('invoices/report', [InvoicesReportController::class, 'index'])->name('user.submit.reports.invoices');
            Route::get('links/report', [LinksReportController::class, 'index'])->name('user.reports.links');
            Route::post('links/report', [LinksReportController::class, 'index'])->name('user.submit.reports.links');
            Route::get('orders/report', [OrdersReportController::class, 'index'])->name('user.reports.orders');
            Route::post('orders/report', [OrdersReportController::class, 'index'])->name('user.submit.reports.orders');
            Route::get('products/report', [ProductsReportController::class, 'index'])->name('user.reports.products');
            Route::post('products/report', [ProductsReportController::class, 'index'])->name('user.submit.reports.products');
            Route::get('comissions/report', [ComissionsReportController::class, 'index'])->name('user.reports.comissions');
            Route::post('comissions/report', [ComissionsReportController::class, 'index'])->name('user.submit.reports.comissions');

            
            Route::post('country', [UserController::class, 'submitcountry'])->name('submit.country');
            Route::middleware(['Ban', 'Country', 'Blocked', 'CheckStatus', 'Tfa'])->group(function () {
                Route::middleware(['Banks'])->group(function () {
                    Route::middleware(['Kyc'])->group(function () {
                        Route::post('card', [UserController::class, 'card'])->name('card');
                        Route::post('recharge/pix', [UserController::class, 'rechargeWithPix'])->name('recharge.pix');
                        Route::post('recharge/boleto', [UserController::class, 'rechargeWithBoleto'])->name('recharge.boleto');
                        Route::get('stripe_card/{id}', [UserController::class, 'stripecard'])->name('stripe.card');
                        Route::post('flutter', [UserController::class, 'newflutter'])->name('flutter');
                        Route::post('search', [UserController::class, 'search'])->name('search');
                        Route::post('crypto', [UserController::class, 'crypto'])->name('crypto');
                        Route::post('others', [UserController::class, 'others'])->name('others');
                        Route::get('others', [UserController::class, 'dashboard'])->name('others');
                        Route::get('dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
                        Route::get('single-charge', [UserController::class, 'transactions'])->name('user.transactionssc');
                        Route::get('donation', [UserController::class, 'transactions'])->name('user.transactionsd');
                        Route::get('invoice-log', [UserController::class, 'transactions'])->name('user.invoicelog');
                        Route::get('deposit-log', [UserController::class, 'transactions'])->name('user.depositlog');
                        Route::get('bank-transfer', [UserController::class, 'transactions'])->name('user.banktransfer');
                        Route::get('transactions', [UserController::class, 'transactions'])->name('user.transactions');
                        Route::get('my-sub', [UserController::class, 'transactions'])->name('user.mysub');
                        Route::get('subaccounts', [UserController::class, 'subaccounts'])->name('user.subaccounts');
                        Route::get('chargebacks', [UserController::class, 'chargeback'])->name('user.chargeback');
                        Route::get('new-subaccounts', [UserController::class, 'newsubaccount'])->name('user.new.subaccount');
                        Route::get('charges', [UserController::class, 'charges'])->name('user.charges');
                        Route::post('withdraw-update', [UserController::class, 'withdrawupdate']);
                        Route::get('profile', [UserController::class, 'profile'])->name('user.profile');
                        Route::get('security', [UserController::class, 'profile'])->name('user.security');
                        Route::get('social', [UserController::class, 'profile'])->name('user.social');
                        Route::get('api', [UserController::class, 'profile'])->name('user.api');
                        Route::get('compliance', [UserController::class, 'profile'])->name('user.compliance');
                        Route::post('generate-api', [UserController::class, 'generateapi'])->name('generateapi');
                        Route::post('register/callback-url', [UserController::class, 'registerCallbackUrl'])->name('register.callback.url');
                        Route::post('kyc', [UserController::class, 'kyc']);
                        Route::post('account', [UserController::class, 'account']);
                        Route::post('social', [UserController::class, 'social'])->name('user.social');
                        Route::post('avatar', [UserController::class, 'avatar']);
                        Route::post('delaccount', [UserController::class, 'delaccount'])->name('delaccount');
                        Route::get('deposit-verify/{id}', [UserController::class, 'userDataUpdate'])->name('deposit.verify');
                        Route::get('flutter-deposit-verify/{id}', [UserController::class, 'userDataUpdateFlutter'])->name('flutter.deposit.verify');
                        
                        //Bitcoin
                            Route::get('btc', [UserController::class, 'btc'])->name('user.btc');
                            Route::post('sell-btc', [UserController::class, 'Sellbtc'])->name('user.sell.btc');
                            Route::post('buy-btc', [UserController::class, 'Buybtc'])->name('user.buy.btc'); 
                        //End
                        
                        //Ethereum
                            Route::get('eth', [UserController::class, 'eth'])->name('user.eth');
                            Route::post('sell_eth', [UserController::class, 'Selleth'])->name('user.sell.eth');
                            Route::post('buy_eth', [UserController::class, 'Buyeth'])->name('user.buy.eth');
                        //End

                        //Virtual Cards
                            Route::get('virtual-card', [UserController::class, 'virtualcard'])->name('user.virtualcard');
                            Route::post('create-virtual', [UserController::class, 'createVirtual'])->name('create.virtual');
                            Route::post('fund-virtual', [UserController::class, 'fundVirtual'])->name('fund.virtual');
                            Route::post('withdraw-virtual', [UserController::class, 'withdrawVirtual'])->name('withdraw.virtual');
                            Route::get('terminate-virtual/{id}', [UserController::class, 'terminateVirtual'])->name('terminate.virtual');
                            Route::get('block-virtual/{id}', [UserController::class, 'blockVirtual'])->name('block.virtual');
                            Route::get('unblock-virtual/{id}', [UserController::class, 'unblockVirtual'])->name('unblock.virtual');
                            Route::get('transactions-virtual/{id}', [UserController::class, 'transactionsVirtual'])->name('transactions.virtual');
                        //End
                        //Bill
                            Route::get('bill', [UserController::class, 'bill'])->name('user.bill');
                            Route::post('submit-bill', [UserController::class, 'submitbill'])->name('user.submit-bill');
                            Route::get('airtime', [UserController::class, 'airtime'])->name('user.airtime');
                            Route::get('data-bundle', [UserController::class, 'data_bundle'])->name('user.data.bundle');
                            Route::get('tv-cable', [UserController::class, 'tv_cable'])->name('user.tv.cable');
                            Route::get('electricity', [UserController::class, 'electricity'])->name('user.electricity');
                        //End
                        //Products
                            Route::get('product', [UserController::class, 'storefront'])->name('user.product');
                            Route::get('list', [UserController::class, 'storefront'])->name('user.list');
                            Route::get('your-list', [UserController::class, 'storefront'])->name('user.your-list');
                            Route::get('store-list/{id}', [UserController::class, 'storeorders'])->name('store.your-list');
                            Route::get('shipping', [UserController::class, 'storefront'])->name('user.shipping');
                            Route::get('storefront', [UserController::class, 'storefront'])->name('user.storefront');                      
                            Route::post('add-product', [UserController::class, 'submitproduct'])->name('submit.product');
                            Route::post('add-store', [UserController::class, 'submitstore'])->name('submit.store');
                            Route::post('add-shipping', [UserController::class, 'submitshipping'])->name('submit.shipping');
                            Route::post('add-storeproduct', [UserController::class, 'submitstoreproduct'])->name('submit.storeproduct');
                            Route::post('edit-store', [UserController::class, 'editstore'])->name('edit.store');
                            Route::post('edit-shipping', [UserController::class, 'editshipping'])->name('edit.shipping');
                            Route::post('update-shipping', [UserController::class, 'updateshipping'])->name('update.shipping');
                            Route::get('unstore/{id}', [UserController::class, 'unstore'])->name('store.unpublish');
                            Route::get('pstore/{id}', [UserController::class, 'pstore'])->name('store.publish');
                            Route::post('add-category', [UserController::class, 'submitcategory'])->name('submit.category');
                            Route::get('edit-product/{id}', [UserController::class, 'Editproduct'])->name('edit.product');
                            Route::get('store-product/{id}', [UserController::class, 'Storefrontproducts'])->name('storefront.products');
                            Route::get('orders/{id}', [UserController::class, 'orders'])->name('orders');
                            Route::post('description_update', [UserController::class, 'Descriptionupdate'])->name('product.description.submit');
                            Route::post('feature_update', [UserController::class, 'Featureupdate'])->name('product.feature.submit');
                            Route::post('add-product-image', [UserController::class, 'submitproductimage'])->name('submit.product.image');
                            Route::get('delete-product-image/{id}', [UserController::class, 'deleteproductimage'])->name('delete.product.image');
                            Route::get('delete-category/{id}', [UserController::class, 'Destroyproductcategory'])->name('delete.category');
                            Route::get('delete-product/{id}', [UserController::class, 'Destroyproduct'])->name('delete.product');
                            Route::get('delete-storefront/{id}', [UserController::class, 'Destroystorefront'])->name('delete.storefront');
                            Route::get('delete-shipping/{id}', [UserController::class, 'Destroyshipping'])->name('delete.shipping');
                            Route::get('delete-storefrontproduct/{id}', [UserController::class, 'Destroystorefrontproduct'])->name('delete.storefrontproduct');
                        //End

                        //Merchant
                            Route::get('merchant', [UserController::class, 'merchant'])->name('user.merchant');
                            Route::get('sender_log', [UserController::class, 'senderlog'])->name('user.senderlog');
                            Route::get('merchant-documentation', [UserController::class, 'merchant_documentation'])->name('user.merchant-documentation');
                            Route::post('add-merchant', [UserController::class, 'submitmerchant'])->name('submit.merchant');
                            Route::get('log-merchant/{id}', [UserController::class, 'Logmerchant'])->name('log.merchant');
                            Route::get('delete-merchant/{id}', [UserController::class, 'Destroymerchant'])->name('delete.merchant');
                            Route::get('cancel_merchant/{id}', [UserController::class, 'Cancelmerchant'])->name('cancel.merchant');
                            Route::post('editmerchant', [UserController::class, 'updatemerchant'])->name('update.merchant');
                        //End                
                        
                        //Invoice
                            Route::get('invoice', [UserController::class, 'invoice'])->name('user.invoice');
                            Route::get('preview-invoice/{id}', [UserController::class, 'previewinvoice'])->name('preview.invoice');
                            Route::get('add-invoice', [UserController::class, 'addinvoice'])->name('user.add-invoice');
                            Route::post('add-invoice', [UserController::class, 'submitinvoice'])->name('submit.invoice');
                            Route::post('add-preview', [UserController::class, 'submitpreview'])->name('submit.preview');
                            Route::get('edit-invoice/{id}', [UserController::class, 'Editinvoice'])->name('edit.invoice');
                            Route::get('delete-invoice/{id}', [UserController::class, 'Destroyinvoice'])->name('delete.invoice');
                            Route::get('submit_invoice/{id}', [UserController::class, 'Payinvoice'])->name('pay.invoice');
                            Route::get('reminder/{id}', [UserController::class, 'Reminderinvoice'])->name('reminder.invoice');
                            Route::get('paid/{id}', [UserController::class, 'Paidinvoice'])->name('paid.invoice');
                            Route::post('editinvoice', [UserController::class, 'updateinvoice'])->name('update.invoice');
                        //End

                        //Bank
                            Route::get('bank', [UserController::class, 'profile'])->name('user.bank');
                            Route::post('add-bank', [UserController::class, 'Createbank'])->name('submit.bank');
                            Route::post('edit-bank', [UserController::class, 'Updatebank'])->name('bank.edit');
                            Route::get('bank/delete/{id}', [UserController::class, 'Destroybank'])->name('bank.delete');                        
                            Route::post('add-subacct', [UserController::class, 'Createsubacct'])->name('submit.subacct');
                            Route::post('add-subacct2', [UserController::class, 'Createsubacct2'])->name('submit.subacct2');
                            Route::post('edit-subacct', [UserController::class, 'Updatesubacct'])->name('subacct.edit');
                            Route::get('subacct/delete/{id}', [UserController::class, 'Destroysubacct'])->name('subacct.delete');
                            Route::get('bank/default/{id}', [UserController::class, 'Defaultbank'])->name('bank.default');
                        //End

                        //Send money
                            Route::get('transfer', [UserController::class, 'ownbank'])->name('user.transfer');
                            Route::get('mobilemoney', [UserController::class, 'mobilemoney'])->name('user.mobilemoney');
                            Route::post('transfer', [UserController::class, 'submitownbank'])->name('submit.transfer');
                            Route::post('local_preview', [UserController::class, 'submitlocalpreview'])->name('submit.localpreview');
                            Route::get('local_preview', [UserController::class, 'localpreview'])->name('user.localpreview');
                            Route::get('send_money/{id}', [UserController::class, 'Sendpay'])->name('send.pay');
                            Route::get('decline_money/{id}', [UserController::class, 'Declinepay'])->name('decline.pay');
                            Route::get('received/{id}', [UserController::class, 'Receivedpay'])->name('received.pay');
                        //End

                        //Request money
                            Route::get('request', [UserController::class, 'request'])->name('user.request');
                            Route::post('request', [UserController::class, 'submitrequest'])->name('submit.request');
                        //End                
                        
                        //Payment link
                            Route::get('sc-links', [UserController::class, 'sclinks'])->name('user.sclinks');
                            Route::get('sc-links/{id}', [UserController::class, 'sclinkstrans'])->name('user.sclinkstrans');
                            Route::get('unsclinks/{id}', [UserController::class, 'unsclinks'])->name('sclinks.unpublish');
                            Route::get('psclinks/{id}', [UserController::class, 'psclinks'])->name('sclinks.publish'); 
                            Route::post('editsclinks', [UserController::class, 'updatesclinks'])->name('update.sclinks');
                            Route::get('dp-links', [UserController::class, 'dplinks'])->name('user.dplinks');
                            Route::get('dp-links/{id}', [UserController::class, 'dplinkstrans'])->name('user.dplinkstrans');
                            Route::get('subacct/{id}', [UserController::class, 'subaccttrans'])->name('user.subaccttrans');
                            Route::get('undplinks/{id}', [UserController::class, 'undplinks'])->name('dplinks.unpublish');
                            Route::get('pdplinks/{id}', [UserController::class, 'pdplinks'])->name('dplinks.publish');                         
                            Route::get('unsubacct/{id}', [UserController::class, 'unsubacct'])->name('subacct.unpublish');
                            Route::get('psubacct/{id}', [UserController::class, 'psubacct'])->name('subacct.publish'); 
                            Route::post('editdplinks', [UserController::class, 'updatedplinks'])->name('update.dplinks');
                            Route::post('single_charge', [UserController::class, 'submitsinglecharge'])->name('submit.singlecharge');
                            Route::post('donation_page', [UserController::class, 'submitdonationpage'])->name('submit.donationpage');
                            Route::get('delete-link/{id}', [UserController::class, 'Destroylink'])->name('delete.user.link');
                            Route::post('donation', [UserController::class, 'submitdonation'])->name('submit.donation');
                        //End

                        //Plans
                            Route::get('plan', [UserController::class, 'plans'])->name('user.plan');
                            Route::get('unplan/{id}', [UserController::class, 'unplan'])->name('sub.plan.unpublish');
                            Route::get('pplan/{id}', [UserController::class, 'pplan'])->name('sub.plan.publish');
                            Route::post('plan', [UserController::class, 'submitplan'])->name('submit.plan');
                            Route::post('updateplan', [UserController::class, 'updateplan'])->name('update.plan');
                            Route::get('plan-sub/{id}', [UserController::class, 'plansub'])->name('user.plansub');
                            Route::get('subs', [UserController::class, 'subscriptions'])->name('user.sub');
                        //End


                        Route::get('ticket', [UserController::class, 'ticket'])->name('user.ticket');
                        Route::get('open-ticket', [UserController::class, 'openticket'])->name('open.ticket');
                        Route::post('submit-ticket', [UserController::class, 'submitticket'])->name('submit-ticket');
                        Route::get('ticket/delete/{id}', [UserController::class, 'Destroyticket'])->name('ticket.delete');
                        Route::get('reply-ticket/{id}', [UserController::class, 'Replyticket'])->name('ticket.reply');
                        Route::post('reply-ticket', [UserController::class, 'submitreply']);
                        Route::get('fund', [UserController::class, 'fund'])->name('user.fund');
                        Route::post('fund/proccess/payment', [FundPaymentController::class, 'processFund'])->name('fund.proccess.payment');
                        Route::post('fund/verify/payment', [FundPaymentController::class, 'verifyFund'])->name('fund.verify.payment');
                        Route::get('preview', [UserController::class, 'depositpreview'])->name('user.preview');
                        Route::post('fund', [UserController::class, 'fundsubmit'])->name('fund.submit');
                        Route::get('bank_transfer', [UserController::class, 'bank_transfer'])->name('user.bank_transfer');
                        Route::post('bank_transfer', [UserController::class, 'bank_transfersubmit'])->name('bank_transfersubmit');
                        Route::get('withdraw', [UserController::class, 'withdraw'])->name('user.withdraw');
                        //Route::post('withdraw', [UserController::class, 'withdrawsubmit'])->name('withdraw.submit');
                        Route::post('withdraw', [UserController::class, 'sendWithdraw'])->name('user.withdraw.send');
                        Route::post('password', [UserController::class, 'submitPassword'])->name('change.password');
                        Route::get('deposit-confirm', [PaymentController::class, 'depositConfirm'])->name('deposit.confirm');
                        Route::post('2fa', [UserController::class, 'submit2fa'])->name('change.2fa');
                        Route::get('audit', [UserController::class, 'audit'])->name('user.audit');
                    });
                });
                Route::post('add_bank', [UserController::class, 'Createbank'])->name('add.bank');
                Route::get('no-bank', [UserController::class, 'nobank'])->name('user.nobank');
            });
        });
    Route::get('logout', [UserController::class, 'logout'])->name('user.logout');
});

Route::get('user-password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('user.password.request');
Route::post('user-password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('user.password.email');
Route::get('user-password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('user.password.reset');
Route::post('user-password/reset', [ResetPasswordController::class, 'reset']);
Route::get('admin', [AdminController::class, 'adminlogin'])->name('admin.loginForm');
Route::post('admin', [AdminController::class, 'submitadminlogin'])->name('admin.login');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/logout', [CheckController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [CheckController::class, 'dashboard'])->name('admin.dashboard');
    //Blog controller
    Route::post('/createcategory', [PostController::class, 'CreateCategory']);
    Route::post('/updatecategory', [PostController::class, 'UpdateCategory']);
    Route::get('/post-category', [PostController::class, 'category'])->name('admin.cat');
    Route::get('/unblog/{id}', [PostController::class, 'unblog'])->name('blog.unpublish');
    Route::get('/pblog/{id}', [PostController::class, 'pblog'])->name('blog.publish');
    Route::get('blog', [PostController::class, 'index'])->name('admin.blog');
    Route::get('blog/create', [PostController::class, 'create'])->name('blog.create');
    Route::post('blog/create', [PostController::class, 'store'])->name('blog.store');
    Route::get('blog/delete/{id}', [PostController::class, 'destroy'])->name('blog.delete');
    Route::get('category/delete/{id}', [PostController::class, 'delcategory'])->name('blog.delcategory');
    Route::get('blog/edit/{id}', [PostController::class, 'edit'])->name('blog.edit');
    Route::post('blog-update', [PostController::class, 'updatePost'])->name('blog.update');

    //Web controller
    Route::post('social-links/update', [WebController::class, 'UpdateSocial'])->name('social-links.update');
    Route::get('social-links', [WebController::class, 'sociallinks'])->name('social-links'); 

    Route::post('about-us/update', [WebController::class, 'UpdateAbout'])->name('about-us.update');
    Route::get('about-us', [WebController::class, 'aboutus'])->name('about-us'); 

    Route::post('privacy-policy/update', [WebController::class, 'UpdatePrivacy'])->name('privacy-policy.update');
    Route::get('privacy-policy', [WebController::class, 'privacypolicy'])->name('privacy-policy');

    Route::post('terms/update', [WebController::class, 'UpdateTerms'])->name('terms.update');
    Route::get('terms', [WebController::class, 'terms'])->name('admin.terms'); 

    Route::post('/createfaq', [WebController::class, 'CreateFaq']);   
    Route::post('faq/update', [WebController::class, 'UpdateFaq'])->name('faq.update');
    Route::get('faq/delete/{id}', [WebController::class, 'DestroyFaq'])->name('faq.delete');
    Route::get('faq', [WebController::class, 'faq'])->name('admin.faq');      
    
    Route::post('/createcountry', [WebController::class, 'CreateCountry']);   
    Route::post('country/update', [WebController::class, 'UpdateCountry'])->name('country.update');
    Route::get('country/delete/{id}', [WebController::class, 'DestroyCountry'])->name('country.delete');
    Route::get('country', [WebController::class, 'country'])->name('admin.country');  
    Route::get('/uncoin/{id}', [WebController::class, 'uncountry'])->name('country.unpublish');
    Route::get('/pcoin/{id}', [WebController::class, 'pcountry'])->name('country.publish');    
    
    Route::post('/createlbank', [WebController::class, 'Createlbank']);   
    Route::post('lbank/update', [WebController::class, 'Updatelbank'])->name('lbank.update');
    Route::get('lbank/delete/{id}', [WebController::class, 'Destroylbank'])->name('lbank.delete');
    Route::get('lbank', [WebController::class, 'lbank'])->name('admin.lbank');   
    
    Route::post('/createservice', [WebController::class, 'CreateService']);   
    Route::post('service/update', [WebController::class, 'UpdateService'])->name('service.update');
    Route::get('service/edit/{id}', [WebController::class, 'EditService'])->name('brand.edit');
    Route::get('service/delete/{id}', [WebController::class, 'DestroyService'])->name('service.delete');
    Route::get('service', [WebController::class, 'services'])->name('admin.service'); 
    
    Route::post('/createpage', [WebController::class, 'CreatePage']);   
    Route::post('page/update', [WebController::class, 'UpdatePage'])->name('page.update');
    Route::get('page/delete/{id}', [WebController::class, 'DestroyPage'])->name('page.delete');
    Route::get('page', [WebController::class, 'page'])->name('admin.page'); 
    Route::get('/unpage/{id}', [WebController::class, 'unpage'])->name('page.unpublish');
    Route::get('/ppage/{id}', [WebController::class, 'ppage'])->name('page.publish');    
    
    Route::post('/createreview', [WebController::class, 'CreateReview']);   
    Route::post('review/update', [WebController::class, 'UpdateReview'])->name('review.update');
    Route::get('review/edit/{id}', [WebController::class, 'EditReview'])->name('review.edit');
    Route::get('review/delete/{id}', [WebController::class, 'DestroyReview'])->name('review.delete');
    Route::get('review', [WebController::class, 'review'])->name('admin.review'); 
    Route::get('/unreview/{id}', [WebController::class, 'unreview'])->name('review.unpublish');
    Route::get('/preview/{id}', [WebController::class, 'preview'])->name('review.publish');    
    
    Route::post('/createbrand', [WebController::class, 'CreateBrand']);   
    Route::post('brand/update', [WebController::class, 'UpdateBrand'])->name('brand.update');
    Route::get('brand/edit/{id}', [WebController::class, 'EditBrand'])->name('brand.edit');
    Route::get('brand/delete/{id}', [WebController::class, 'DestroyBrand'])->name('brand.delete');
    Route::get('brand', [WebController::class, 'brand'])->name('admin.brand'); 
    Route::get('/unbrand/{id}', [WebController::class, 'unbrand'])->name('brand.unpublish');
    Route::get('/pbrand/{id}', [WebController::class, 'pbrand'])->name('brand.publish');
    
    Route::post('createbranch', [WebController::class, 'CreateBranch']);   
    Route::post('branch/update', [WebController::class, 'UpdateBranch'])->name('branch.update');
    Route::get('branch/delete/{id}', [WebController::class, 'DestroyBranch'])->name('branch.delete');
    Route::get('branch', [WebController::class, 'branch'])->name('admin.branch');

    Route::get('currency', [WebController::class, 'currency'])->name('admin.currency');
    Route::get('pcurrency/{id}', [WebController::class, 'pcurrency'])->name('change.currency'); 
    
    Route::get('logo', [WebController::class, 'logo'])->name('admin.logo');
    Route::post('light-logo', [WebController::class, 'light'])->name('light.logo');
    Route::post('dark-logo', [WebController::class, 'dark'])->name('dark.logo');
    Route::post('updatefavicon', [WebController::class, 'UpdateFavicon']);

    Route::get('home-page', [WebController::class, 'homepage'])->name('homepage');   
    Route::post('home-page/update', [WebController::class, 'Updatehomepage'])->name('homepage.update');
    Route::post('section1/update', [WebController::class, 'section1']);
    Route::post('section2/update', [WebController::class, 'section2']);
    Route::post('section3/update', [WebController::class, 'section3']);
    Route::post('section7/update', [WebController::class, 'section7']);
    Route::post('settlement', [SettingController::class, 'SettlementUpdate'])->name('admin.settlement.update'); 

    //Withdrawal controller
    Route::get('withdraw-log', [WithdrawController::class, 'log'])->name('admin.withdraw.log');
    Route::get('withdraw/delete/{id}', [WithdrawController::class, 'delete'])->name('withdraw.delete');
    Route::get('approvewithdraw/{id}', [WithdrawController::class, 'approve'])->name('withdraw.approve');
    Route::get('declinewithdraw/{id}', [WithdrawController::class, 'decline'])->name('withdraw.decline');   
    Route::post('withdrawals/list', [WithdrawController::class, 'listWithdrawals'])->name('admin.withdrawal.search');   
    
    //Deposit controller
    Route::get('bank-transfer', [DepositController::class, 'banktransfer'])->name('admin.banktransfer');
    Route::get('bank_transfer/delete/{id}', [DepositController::class, 'DestroyTransfer'])->name('banktransfer.delete');
    Route::post('bankdetails', [DepositController::class, 'bankdetails']);
    Route::get('deposit-log', [DepositController::class, 'depositlog'])->name('admin.deposit.log');
    Route::get('deposit-method', [DepositController::class, 'depositmethod'])->name('admin.deposit.method');
    Route::post('storegateway', [DepositController::class, 'store']);
    Route::get('approvebk/{id}', [DepositController::class, 'approvebk'])->name('deposit.approvebk');
    Route::get('declinebk/{id}', [DepositController::class, 'declinebk'])->name('deposit.declinebk');
    Route::get('deposit/delete/{id}', [DepositController::class, 'DestroyDeposit'])->name('deposit.delete');
    Route::get('approvedeposit/{id}', [DepositController::class, 'approve'])->name('deposit.approve');
    Route::get('declinedeposit/{id}', [DepositController::class, 'decline'])->name('deposit.decline');

    //Setting controller
    Route::get('settings', [SettingController::class, 'Settings'])->name('admin.setting');
    Route::post('settings', [SettingController::class, 'SettingsUpdate'])->name('admin.settings.update');      
    Route::post('charges', [SettingController::class, 'charges'])->name('admin.charges.update');     
    Route::post('comissions', [SettingController::class, 'comissions'])->name('admin.comissions.update');  
    Route::post('creditcard/taxes/list', [SettingController::class, 'listIntallmentFee'])->name('admin.creditcard.taxes.list'); 
    Route::post('creditcard/taxes/save', [SettingController::class, 'saveInstallmentFee'])->name('admin.creditcard.taxes.save'); 
    Route::post('creditcard/taxes/delete', [SettingController::class, 'deleteInstallmentFee'])->name('admin.creditcard.taxes.delete'); 
    Route::post('admin/gateway/pix/update', [SettingController::class, 'updatePixGateways'])->name('admin.gateway.pix.update'); 
    Route::post('admin/payment/methods/update', [SettingController::class, 'updatePaymentMethodsConfig'])->name('admin.payment.forms.update'); 
    
    
    Route::post('features', [SettingController::class, 'features'])->name('admin.features.update');      
    Route::post('crypto', [SettingController::class, 'crypto'])->name('admin.crypto.update');      
    Route::post('account', [SettingController::class, 'AccountUpdate'])->name('admin.account.update');
    Route::get('charges', [TransferController::class, 'charges'])->name('admin.charges');
    Route::get('sc-links', [TransferController::class, 'sclinks'])->name('admin.sclinks');
    Route::get('dp-links', [TransferController::class, 'dplinks'])->name('admin.dplinks');
    Route::get('delete-link/{id}', [TransferController::class, 'Destroylink'])->name('delete.link');
    Route::get('unlinks/{id}', [TransferController::class, 'unlinks'])->name('links.unpublish');
    Route::get('plinks/{id}', [TransferController::class, 'plinks'])->name('links.publish');
    Route::get('links/{id}', [TransferController::class, 'linkstrans'])->name('admin.linkstrans'); 

    //Transfer controller
    Route::get('transfer', [TransferController::class, 'Ownbank'])->name('admin.ownbank');  
    Route::get('transfer/delete/{id}', [TransferController::class, 'Destroyownbank'])->name('transfer.delete');    
    
    //Request Money controller
    Route::get('request', [TransferController::class, 'Requestmoney'])->name('admin.request');  
    Route::get('request/delete/{id}', [TransferController::class, 'Destroyrequest'])->name('request.delete');     
    
    //Invoice controller
    Route::get('invoice', [TransferController::class, 'invoice'])->name('admin.invoice');  
    Route::get('invoice/delete/{id}', [TransferController::class, 'Destroyinvoice'])->name('invoice.delete');  
    Route::post('invoice/search', [TransferController::class, 'listInvoices'])->name('invoice.search');      
    
    Route::get('product', [TransferController::class, 'product'])->name('admin.product');  
    Route::get('product/delete/{id}', [TransferController::class, 'Destroyproduct'])->name('product.delete'); 
    Route::get('unproduct/{id}', [TransferController::class, 'unproduct'])->name('product.unpublish');
    Route::get('pproduct/{id}', [TransferController::class, 'pproduct'])->name('product.publish');    
    Route::get('orders/{id}', [TransferController::class, 'orders'])->name('admin.orders');  
    
    Route::get('plan', [TransferController::class, 'plans'])->name('admin.plan');
    Route::get('plan-sub/{id}', [TransferController::class, 'plansub'])->name('admin.plansub');
    Route::get('unplan/{id}', [TransferController::class, 'unplan'])->name('plan.unpublish');
    Route::get('pplan/{id}', [TransferController::class, 'pplan'])->name('plan.publish');
    

    //User controller
    Route::get('staff', [CheckController::class, 'Staffs'])->name('admin.staffs');  
    Route::get('new-staff', [CheckController::class, 'Newstaff'])->name('new.staff');  
    Route::post('new-staff', [CheckController::class, 'Createstaff'])->name('create.staff');  
    Route::get('users', [CheckController::class, 'Users'])->name('admin.users');  
    Route::get('messages', [CheckController::class, 'Messages'])->name('admin.message');  
    Route::get('unblock-staff/{id}', [CheckController::class, 'Unblockstaff'])->name('staff.unblock');
    Route::get('block-staff/{id}', [CheckController::class, 'Blockstaff'])->name('staff.block');    
    Route::get('unblock-user/{id}', [CheckController::class, 'Unblockuser'])->name('user.unblock');
    Route::get('block-user/{id}', [CheckController::class, 'Blockuser'])->name('user.block');
    Route::get('user-taxes/{id}', [ClientController::class, 'taxes'])->name('user.taxes');
    Route::get('user-compliance/{id}', [UserComplianceController::class, 'complianceType'])->name('admin.user.compliance');
    Route::get('user-personal-compliance/{userId}', [UserComplianceController::class, 'personalCompliance'])->name('admin.user.personal-compliance');
    Route::get('user-business-compliance/{userId}', [UserComplianceController::class, 'businessCompliance'])->name('admin.user.business-compliance');
    Route::post('user-personal-reject', [UserComplianceController::class, 'rejectPersonalDocument'])->name('admin.user.compliance.reject');
    Route::post('user-personal-approve', [UserComplianceController::class, 'approvePersonalDocument'])->name('admin.user.compliance.approve');
    Route::post('user-business-reject', [UserComplianceController::class, 'rejectBusinessDocument'])->name('admin.user.business.reject');
    Route::post('user-business-approve', [UserComplianceController::class, 'approveBusinessDocument'])->name('admin.user.business.approve');
    
    Route::post('user-taxes/update', [ClientController::class, 'updateUserTaxes'])->name('user.taxes.update');
    Route::post('user-taxes/comissions', [ClientController::class, 'comissions'])->name('user.comissions.update');
    Route::post('user-taxes/creditcard/fees/list', [ClientController::class, 'listIntallmentFee'])->name('admin.user.creditcard.taxes.list');
    Route::post('user-taxes/creditcard/fees/save', [ClientController::class, 'saveInstallmentFee'])->name('admin.user.creditcard.taxes.save');
    Route::post('user-taxes/creditcard/fees/delete', [ClientController::class, 'deleteInstallmentFee'])->name('admin.user.creditcard.taxes.delete');
    Route::post('user-taxes/creditcard/fees/enable', [ClientController::class, 'enableUserCreditcardTable'])->name('admin.user.creditcard.taxes.enable');
    Route::post('user-taxes/creditcard/fees/disable', [ClientController::class, 'disableUserCreditcardTable'])->name('admin.user.creditcard.taxes.disable');
    
    Route::post('admin/user/gateway/pix/update', [ClientController::class, 'updatePixGateways'])->name('admin.user.gateway.pix.update'); 
    Route::post('admin/user/payment/methods/update', [ClientController::class, 'updatePaymentMethodsConfig'])->name('admin.user.payment.forms.update');  

    Route::get('manage-user/{id}', [CheckController::class, 'Manageuser'])->name('user.manage');
    Route::post('manage-user-search-enroller', [CheckController::class, 'SearchEnroller'])->name('user.manage.search.enroler');
    Route::post('manage-user-change-enroller', [CheckController::class, 'ChangeEnroller'])->name('user.manage.change.enroller');
    Route::post('manage-user-change-password', [CheckController::class, 'ChangePassword'])->name('user.manage.change.password');
    Route::get('manage-staff/{id}', [CheckController::class, 'Managestaff'])->name('staff.manage');
    Route::get('user/delete/{id}', [CheckController::class, 'Destroyuser'])->name('user.delete');
    Route::get('staff/delete/{id}', [CheckController::class, 'Destroystaff'])->name('staff.delete');
    Route::get('email/{email}/{name}', [CheckController::class, 'Email'])->name('admin.email');
    Route::post('email_send', [CheckController::class, 'Sendemail'])->name('user.email.send');    
    Route::get('promo', [CheckController::class, 'Promo'])->name('admin.promo');
    Route::post('promo', [CheckController::class, 'Sendpromo'])->name('user.promo.send');
    Route::get('message/delete/{id}', [CheckController::class, 'Destroymessage'])->name('message.delete');
    Route::get('ticket', [CheckController::class, 'Ticket'])->name('admin.ticket');
    Route::get('ticket/delete/{id}', [CheckController::class, 'Destroyticket'])->name('ticket.delete');
    Route::get('close-ticket/{id}', [CheckController::class, 'Closeticket'])->name('ticket.close');
    Route::get('manage-ticket/{id}', [CheckController::class, 'Manageticket'])->name('ticket.manage');
    Route::post('reply-ticket', [CheckController::class, 'Replyticket'])->name('ticket.reply');
    Route::post('profile-update', [CheckController::class, 'Profileupdate']);
    Route::post('staff-update', [CheckController::class, 'Staffupdate'])->name('staff.update');
    Route::get('approve-kyc/{id}', [CheckController::class, 'Approvekyc'])->name('admin.approve.kyc');
    Route::get('reject-kyc/{id}', [CheckController::class, 'Rejectkyc'])->name('admin.reject.kyc');
    Route::post('password', [CheckController::class, 'staffPassword'])->name('staff.password');


    //Financial controller
    Route::get('management/charges', [FinancialManagementController::class, 'feesManagement'])->name('charges.management');
    Route::post('management/charges/list', [FinancialManagementController::class, 'listFees'])->name('charges.management.list');
    Route::post('management/charges/export', [FinancialManagementController::class, 'exportReport'])->name('charges.management.export');
    Route::get('account/flow', [AccountFlowController::class, 'index'])->name('account.flow');
    Route::post('account/flow/list', [AccountFlowController::class, 'listAccounts'])->name('account.flow.list');
    Route::post('account/flow/export', [AccountFlowController::class, 'exportReport'])->name('account.flow.export');
     
    
    //Merchant controller
    Route::get('merchant-log', [MerchantController::class, 'merchantlog'])->name('merchant.log');
    Route::get('transfer-log/{id}', [MerchantController::class, 'transferlog'])->name('transfer.log');
    Route::get('merchant/delete/{id}', [MerchantController::class, 'Destroymerchant'])->name('merchant.delete');

    //Trade controller
    Route::get('trades', [TradeController::class, 'trades'])->name('admin.trades');
    Route::get('delete/{id}', [TradeController::class, 'DestroyTrade'])->name('trade.delete');
    Route::get('approvetrade/{id}', [TradeController::class, 'approveTrade'])->name('trade.approve');
    Route::get('declinetrade/{id}', [TradeController::class, 'declineTrade'])->name('trade.decline'); 

    //Vcard
    Route::get('vcard', [CheckController::class, 'vcard'])->name('admin.vcard');
    Route::get('transactions-virtual/{id}', [CheckController::class, 'transactionsvcard'])->name('transactions.vcard');

    //Bill payment
    Route::get('bpay', [CheckController::class, 'bpay'])->name('admin.bpay');
});

// Include Enhanced Features Routes
require __DIR__.'/enhanced_features.php';

// ============================================
// SELLER ROUTES (Vendedores de Infoprodutos)
// ============================================
Route::group(['prefix' => 'seller', 'middleware' => ['auth:user']], function () {
    // Dashboard Principal do Seller
    Route::get('dashboard', [App\Http\Controllers\Seller\DashboardController::class, 'index'])->name('seller.dashboard');

    // Gestão de Produtos Digitais
    Route::get('products', [App\Http\Controllers\Seller\ProductController::class, 'index'])->name('seller.products');
    Route::get('products/create', [App\Http\Controllers\Seller\ProductController::class, 'create'])->name('seller.products.create');
    Route::get('products/export', [App\Http\Controllers\Seller\ProductController::class, 'export'])->name('seller.products.export');
    Route::post('products/store', [App\Http\Controllers\Seller\ProductController::class, 'store'])->name('seller.products.store');
    Route::post('products/import', [App\Http\Controllers\Seller\ProductController::class, 'import'])->name('seller.products.import');
    Route::get('products/{id}/edit', [App\Http\Controllers\Seller\ProductController::class, 'edit'])->name('seller.products.edit');
    Route::put('products/{id}', [App\Http\Controllers\Seller\ProductController::class, 'update'])->name('seller.products.update');
    Route::delete('products/{id}', [App\Http\Controllers\Seller\ProductController::class, 'destroy'])->name('seller.products.destroy');
    Route::get('products/{id}/files', [App\Http\Controllers\Seller\ProductController::class, 'files'])->name('seller.products.files');
    Route::post('products/{id}/upload', [App\Http\Controllers\Seller\ProductController::class, 'upload'])->name('seller.products.upload');
    Route::get('products/{id}/access', [App\Http\Controllers\Seller\ProductController::class, 'access'])->name('seller.products.access');

    // Relatórios e Analytics
    Route::get('reports/sales', [App\Http\Controllers\Seller\ReportsController::class, 'sales'])->name('seller.reports.sales');
    Route::get('reports/customers', [App\Http\Controllers\Seller\ReportsController::class, 'customers'])->name('seller.reports.customers');
    Route::get('reports/products', [App\Http\Controllers\Seller\ReportsController::class, 'products'])->name('seller.reports.products');
    Route::get('analytics', [App\Http\Controllers\Seller\AnalyticsController::class, 'index'])->name('seller.analytics');
    Route::get('analytics/products', [App\Http\Controllers\Seller\AnalyticsController::class, 'products'])->name('seller.analytics.products');
    Route::get('analytics/customers', [App\Http\Controllers\Seller\AnalyticsController::class, 'customers'])->name('seller.analytics.customers');

    // Gestão Financeira
    Route::get('balance', [App\Http\Controllers\Seller\FinancialController::class, 'balance'])->name('seller.balance');
    Route::get('withdrawals', [App\Http\Controllers\Seller\FinancialController::class, 'withdrawals'])->name('seller.withdrawals');
    Route::post('withdrawals/request', [App\Http\Controllers\Seller\FinancialController::class, 'requestWithdrawal'])->name('seller.withdrawals.request');
    Route::get('invoices', [App\Http\Controllers\Seller\FinancialController::class, 'invoices'])->name('seller.invoices');
    Route::get('commissions', [App\Http\Controllers\Seller\CommissionController::class, 'index'])->name('seller.commissions');
    Route::get('commissions/settings', [App\Http\Controllers\Seller\CommissionController::class, 'settings'])->name('seller.commissions.settings');
    Route::post('commissions/{id}/update', [App\Http\Controllers\Seller\CommissionController::class, 'updateProductCommission'])->name('seller.commissions.update');

    // Marketing
    Route::get('marketing', [App\Http\Controllers\Seller\MarketingController::class, 'index'])->name('seller.marketing');
    Route::get('marketing/discounts', [App\Http\Controllers\Seller\MarketingController::class, 'discounts'])->name('seller.marketing.discounts');
    Route::post('marketing/discounts/create', [App\Http\Controllers\Seller\MarketingController::class, 'createDiscount'])->name('seller.marketing.discounts.create');
    Route::get('marketing/promo-materials', [App\Http\Controllers\Seller\MarketingController::class, 'promoMaterials'])->name('seller.marketing.promo-materials');
    Route::post('marketing/promo-materials/{productId}', [App\Http\Controllers\Seller\MarketingController::class, 'uploadPromoMaterial'])->name('seller.marketing.promo-materials.upload');

    // Configurações do Seller
    Route::get('settings', [App\Http\Controllers\Seller\SettingsController::class, 'index'])->name('seller.settings');
    Route::get('settings/profile', [App\Http\Controllers\Seller\SettingsController::class, 'profile'])->name('seller.settings.profile');
    Route::get('settings/payment-methods', [App\Http\Controllers\Seller\SettingsController::class, 'paymentMethods'])->name('seller.settings.payment-methods');
    Route::post('settings/payment-methods/add', [App\Http\Controllers\Seller\SettingsController::class, 'addPaymentMethod'])->name('seller.settings.payment-methods.add');
    Route::get('settings/notifications', [App\Http\Controllers\Seller\SettingsController::class, 'notifications'])->name('seller.settings.notifications');
    Route::post('settings/notifications', [App\Http\Controllers\Seller\SettingsController::class, 'updateNotifications'])->name('seller.settings.notifications.update');
    Route::get('settings/tax', [App\Http\Controllers\Seller\SettingsController::class, 'tax'])->name('seller.settings.tax');
    Route::post('settings/tax', [App\Http\Controllers\Seller\SettingsController::class, 'updateTax'])->name('seller.settings.tax.update');
    Route::get('settings/api', [App\Http\Controllers\Seller\SettingsController::class, 'api'])->name('seller.settings.api');
    Route::post('settings/api/generate', [App\Http\Controllers\Seller\SettingsController::class, 'generateApiKey'])->name('seller.settings.api.generate');
    Route::delete('settings/api/{id}/revoke', [App\Http\Controllers\Seller\SettingsController::class, 'revokeApiKey'])->name('seller.settings.api.revoke');
});

// ============================================
// AFFILIATE ROUTES (Sistema de Afiliados)
// ============================================
Route::group(['prefix' => 'affiliate', 'middleware' => ['auth']], function () {
    // Dashboard do Afiliado
    Route::get('dashboard', [App\Http\Controllers\Affiliate\DashboardController::class, 'index'])->name('affiliate.dashboard');
    Route::get('register', [App\Http\Controllers\Affiliate\RegisterController::class, 'showForm'])->name('affiliate.register');
    Route::post('register', [App\Http\Controllers\Affiliate\RegisterController::class, 'submit'])->name('affiliate.register.submit');

    // Marketplace de Produtos
    Route::get('marketplace', [App\Http\Controllers\Affiliate\MarketplaceController::class, 'index'])->name('affiliate.marketplace');
    Route::get('marketplace/{id}', [App\Http\Controllers\Affiliate\MarketplaceController::class, 'show'])->name('affiliate.marketplace.show');
    Route::post('marketplace/{id}/promote', [App\Http\Controllers\Affiliate\MarketplaceController::class, 'promote'])->name('affiliate.promote');
    Route::delete('marketplace/{id}/stop', [App\Http\Controllers\Affiliate\MarketplaceController::class, 'stopPromoting'])->name('affiliate.stop-promoting');

    // Produtos Promovidos
    Route::get('products', [App\Http\Controllers\Affiliate\ProductsController::class, 'index'])->name('affiliate.products');
    Route::get('my-products', [App\Http\Controllers\Affiliate\ProductsController::class, 'index'])->name('affiliate.my-products'); // Alias
    Route::get('products/{id}/analytics', [App\Http\Controllers\Affiliate\ProductsController::class, 'analytics'])->name('affiliate.products.analytics');

    // Links e Campanhas
    Route::get('links', [App\Http\Controllers\Affiliate\LinksController::class, 'index'])->name('affiliate.links');
    Route::get('links/{id}/analytics', [App\Http\Controllers\Affiliate\LinksController::class, 'analytics'])->name('affiliate.links.analytics');
    Route::get('campaigns', [App\Http\Controllers\Affiliate\CampaignsController::class, 'index'])->name('affiliate.campaigns');
    Route::post('campaigns/create', [App\Http\Controllers\Affiliate\CampaignsController::class, 'store'])->name('affiliate.campaigns.store');
    Route::get('campaigns/{id}', [App\Http\Controllers\Affiliate\CampaignsController::class, 'show'])->name('affiliate.campaigns.show');
    Route::get('tracking', [App\Http\Controllers\Affiliate\TrackingController::class, 'index'])->name('affiliate.tracking');
    Route::get('tracking/realtime', [App\Http\Controllers\Affiliate\TrackingController::class, 'realtime'])->name('affiliate.tracking.realtime');

    // Relatórios de Afiliado
    Route::get('reports/conversions', [App\Http\Controllers\Affiliate\ReportsController::class, 'conversions'])->name('affiliate.reports.conversions');
    Route::get('reports/earnings', [App\Http\Controllers\Affiliate\ReportsController::class, 'earnings'])->name('affiliate.reports.earnings');
    Route::get('reports/performance', [App\Http\Controllers\Affiliate\ReportsController::class, 'performance'])->name('affiliate.reports.performance');

    // Pagamentos de Afiliado
    Route::get('payments', [App\Http\Controllers\Affiliate\PaymentsController::class, 'index'])->name('affiliate.payments');
    Route::get('payments/withdraw', [App\Http\Controllers\Affiliate\PaymentsController::class, 'withdraw'])->name('affiliate.payments.withdraw');
    Route::post('payments/withdraw', [App\Http\Controllers\Affiliate\PaymentsController::class, 'requestWithdraw'])->name('affiliate.payments.withdraw.request');
});

// ============================================
// ADMIN ROUTES - NOVAS FUNCIONALIDADES
// ============================================
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'is_admin']], function () {
    // Gestão de Afiliados
    Route::get('affiliates', [App\Http\Controllers\Admin\AffiliatesController::class, 'index'])->name('admin.affiliates');
    Route::get('affiliates/{id}', [App\Http\Controllers\Admin\AffiliatesController::class, 'show'])->name('admin.affiliates.show');
    Route::post('affiliates/{id}/approve', [App\Http\Controllers\Admin\AffiliatesController::class, 'approve'])->name('admin.affiliates.approve');
    Route::post('affiliates/{id}/reject', [App\Http\Controllers\Admin\AffiliatesController::class, 'reject'])->name('admin.affiliates.reject');
    Route::post('affiliates/{id}/suspend', [App\Http\Controllers\Admin\AffiliatesController::class, 'suspend'])->name('admin.affiliates.suspend');
    Route::post('affiliates/{id}/reactivate', [App\Http\Controllers\Admin\AffiliatesController::class, 'reactivate'])->name('admin.affiliates.reactivate');
    Route::post('affiliates/{id}/commission-rate', [App\Http\Controllers\Admin\AffiliatesController::class, 'updateCommissionRate'])->name('admin.affiliates.commission-rate');
    Route::get('affiliates/performance', [App\Http\Controllers\Admin\AffiliatesController::class, 'performance'])->name('admin.affiliates.performance');

    // Programa de Afiliados
    Route::get('affiliate-programs', [App\Http\Controllers\Admin\AffiliateProgramsController::class, 'index'])->name('admin.affiliate-programs');
    Route::post('affiliate-programs/update', [App\Http\Controllers\Admin\AffiliateProgramsController::class, 'update'])->name('admin.affiliate-programs.update');
    Route::get('affiliate-programs/tiers', [App\Http\Controllers\Admin\AffiliateProgramsController::class, 'tiers'])->name('admin.affiliate-programs.tiers');
    Route::post('affiliate-programs/tiers/create', [App\Http\Controllers\Admin\AffiliateProgramsController::class, 'createTier'])->name('admin.affiliate-programs.tiers.create');
    Route::put('affiliate-programs/tiers/{id}', [App\Http\Controllers\Admin\AffiliateProgramsController::class, 'updateTier'])->name('admin.affiliate-programs.tiers.update');
    Route::delete('affiliate-programs/tiers/{id}', [App\Http\Controllers\Admin\AffiliateProgramsController::class, 'deleteTier'])->name('admin.affiliate-programs.tiers.delete');
    Route::get('affiliate-programs/payouts', [App\Http\Controllers\Admin\AffiliateProgramsController::class, 'payouts'])->name('admin.affiliate-programs.payouts');
    Route::post('affiliate-programs/payouts/{id}/approve', [App\Http\Controllers\Admin\AffiliateProgramsController::class, 'approvePayout'])->name('admin.affiliate-programs.payouts.approve');
    Route::post('affiliate-programs/payouts/{id}/reject', [App\Http\Controllers\Admin\AffiliateProgramsController::class, 'rejectPayout'])->name('admin.affiliate-programs.payouts.reject');

    // Gestão de Marketplace
    Route::get('marketplace', [App\Http\Controllers\Admin\MarketplaceController::class, 'index'])->name('admin.marketplace');
    Route::get('marketplace/{id}', [App\Http\Controllers\Admin\MarketplaceController::class, 'show'])->name('admin.marketplace.show');
    Route::post('marketplace/{id}/approve', [App\Http\Controllers\Admin\MarketplaceController::class, 'approve'])->name('admin.marketplace.approve');
    Route::post('marketplace/{id}/reject', [App\Http\Controllers\Admin\MarketplaceController::class, 'reject'])->name('admin.marketplace.reject');
    Route::post('marketplace/{id}/suspend', [App\Http\Controllers\Admin\MarketplaceController::class, 'suspend'])->name('admin.marketplace.suspend');
    Route::post('marketplace/{id}/reactivate', [App\Http\Controllers\Admin\MarketplaceController::class, 'reactivate'])->name('admin.marketplace.reactivate');
    Route::get('marketplace/featured', [App\Http\Controllers\Admin\MarketplaceController::class, 'featured'])->name('admin.marketplace.featured');
    Route::post('marketplace/{id}/toggle-featured', [App\Http\Controllers\Admin\MarketplaceController::class, 'toggleFeatured'])->name('admin.marketplace.toggle-featured');
    Route::post('marketplace/featured/order', [App\Http\Controllers\Admin\MarketplaceController::class, 'updateFeaturedOrder'])->name('admin.marketplace.featured.order');
    Route::get('marketplace/categories', [App\Http\Controllers\Admin\MarketplaceController::class, 'categories'])->name('admin.marketplace.categories');
    Route::post('marketplace/categories', [App\Http\Controllers\Admin\MarketplaceController::class, 'createCategory'])->name('admin.marketplace.categories.create');
    Route::put('marketplace/categories/{id}', [App\Http\Controllers\Admin\MarketplaceController::class, 'updateCategory'])->name('admin.marketplace.categories.update');
    Route::delete('marketplace/categories/{id}', [App\Http\Controllers\Admin\MarketplaceController::class, 'deleteCategory'])->name('admin.marketplace.categories.delete');

    // Integrações
    Route::get('integrations', [App\Http\Controllers\Admin\IntegrationsController::class, 'index'])->name('admin.integrations');
    Route::post('integrations/webhooks', [App\Http\Controllers\Admin\IntegrationsController::class, 'createWebhook'])->name('admin.integrations.webhooks.create');
    Route::put('integrations/webhooks/{id}', [App\Http\Controllers\Admin\IntegrationsController::class, 'updateWebhook'])->name('admin.integrations.webhooks.update');
    Route::post('integrations/webhooks/{id}/toggle', [App\Http\Controllers\Admin\IntegrationsController::class, 'toggleWebhook'])->name('admin.integrations.webhooks.toggle');
    Route::delete('integrations/webhooks/{id}', [App\Http\Controllers\Admin\IntegrationsController::class, 'deleteWebhook'])->name('admin.integrations.webhooks.delete');
    Route::post('integrations/webhooks/{id}/test', [App\Http\Controllers\Admin\IntegrationsController::class, 'testWebhook'])->name('admin.integrations.webhooks.test');
    Route::get('integrations/webhooks/{id}/logs', [App\Http\Controllers\Admin\IntegrationsController::class, 'webhookLogs'])->name('admin.integrations.webhooks.logs');
    Route::get('integrations/n8n', [App\Http\Controllers\Admin\IntegrationsController::class, 'n8n'])->name('admin.integrations.n8n');
    Route::post('integrations/n8n', [App\Http\Controllers\Admin\IntegrationsController::class, 'updateN8n'])->name('admin.integrations.n8n.update');
    Route::get('integrations/api-keys', [App\Http\Controllers\Admin\IntegrationsController::class, 'apiKeys'])->name('admin.integrations.api-keys');
    Route::post('integrations/api-keys', [App\Http\Controllers\Admin\IntegrationsController::class, 'createApiKey'])->name('admin.integrations.api-keys.create');
    Route::delete('integrations/api-keys/{id}', [App\Http\Controllers\Admin\IntegrationsController::class, 'revokeApiKey'])->name('admin.integrations.api-keys.revoke');

    // Relatórios Avançados
    Route::get('reports', [App\Http\Controllers\Admin\AdvancedReportsController::class, 'index'])->name('admin.reports');
    Route::get('reports/revenue', [App\Http\Controllers\Admin\AdvancedReportsController::class, 'revenue'])->name('admin.reports.revenue');
    Route::get('reports/products', [App\Http\Controllers\Admin\AdvancedReportsController::class, 'products'])->name('admin.reports.products');
    Route::get('reports/affiliates', [App\Http\Controllers\Admin\AdvancedReportsController::class, 'affiliates'])->name('admin.reports.affiliates');
    Route::get('reports/customers', [App\Http\Controllers\Admin\AdvancedReportsController::class, 'customers'])->name('admin.reports.customers');
    Route::get('reports/exports', [App\Http\Controllers\Admin\AdvancedReportsController::class, 'exports'])->name('admin.reports.exports');
    Route::post('reports/export/transactions', [App\Http\Controllers\Admin\AdvancedReportsController::class, 'exportTransactions'])->name('admin.reports.export.transactions');
});

// ============================================
// CUSTOMER ROUTES (Área do Cliente/Comprador)
// ============================================
Route::group(['prefix' => 'customer', 'middleware' => ['auth']], function () {
    // Compras
    Route::get('purchases', [App\Http\Controllers\Customer\PurchasesController::class, 'index'])->name('customer.purchases');
    Route::get('purchases/{id}', [App\Http\Controllers\Customer\PurchasesController::class, 'show'])->name('customer.purchases.show');
    Route::get('purchases/{id}/invoice', [App\Http\Controllers\Customer\PurchasesController::class, 'invoice'])->name('customer.purchases.invoice');
    Route::post('purchases/{id}/refund', [App\Http\Controllers\Customer\PurchasesController::class, 'requestRefund'])->name('customer.purchases.refund');

    // Downloads
    Route::get('downloads', [App\Http\Controllers\Customer\DownloadsController::class, 'index'])->name('customer.downloads');
    Route::get('downloads/{id}/files', [App\Http\Controllers\Customer\DownloadsController::class, 'files'])->name('customer.downloads.files');
    Route::get('downloads/{id}/download', [App\Http\Controllers\Customer\DownloadsController::class, 'download'])->name('customer.downloads.download');
    Route::get('downloads/history', [App\Http\Controllers\Customer\DownloadsController::class, 'history'])->name('customer.downloads.history');

    // Cursos
    Route::get('courses', [App\Http\Controllers\Customer\CoursesController::class, 'index'])->name('customer.courses');
    Route::get('courses/{id}', [App\Http\Controllers\Customer\CoursesController::class, 'show'])->name('customer.courses.show');
    Route::get('courses/{id}/lesson/{lessonId}', [App\Http\Controllers\Customer\CoursesController::class, 'lesson'])->name('customer.courses.lesson');
    Route::post('courses/{id}/lesson/{lessonId}/complete', [App\Http\Controllers\Customer\CoursesController::class, 'completeLesson'])->name('customer.courses.lesson.complete');
    Route::get('courses/{id}/certificate', [App\Http\Controllers\Customer\CoursesController::class, 'certificate'])->name('customer.courses.certificate');

    // Assinaturas
    Route::get('subscriptions', [App\Http\Controllers\Customer\SubscriptionsController::class, 'index'])->name('customer.subscriptions');
    Route::get('subscriptions/{id}', [App\Http\Controllers\Customer\SubscriptionsController::class, 'show'])->name('customer.subscriptions.show');
    Route::post('subscriptions/{id}/cancel', [App\Http\Controllers\Customer\SubscriptionsController::class, 'cancel'])->name('customer.subscriptions.cancel');
    Route::post('subscriptions/{id}/reactivate', [App\Http\Controllers\Customer\SubscriptionsController::class, 'reactivate'])->name('customer.subscriptions.reactivate');
    Route::post('subscriptions/{id}/change-plan', [App\Http\Controllers\Customer\SubscriptionsController::class, 'changePlan'])->name('customer.subscriptions.change-plan');
    Route::post('subscriptions/{id}/payment-method', [App\Http\Controllers\Customer\SubscriptionsController::class, 'updatePaymentMethod'])->name('customer.subscriptions.payment-method');

    // Suporte
    Route::get('support', [App\Http\Controllers\Customer\SupportController::class, 'index'])->name('customer.support');
    Route::get('support/tickets', [App\Http\Controllers\Customer\SupportController::class, 'index'])->name('customer.support.tickets'); // Alias
    Route::get('support/create', [App\Http\Controllers\Customer\SupportController::class, 'create'])->name('customer.support.create');
    Route::post('support', [App\Http\Controllers\Customer\SupportController::class, 'store'])->name('customer.support.store');
    Route::get('support/{id}', [App\Http\Controllers\Customer\SupportController::class, 'show'])->name('customer.support.show');
    Route::post('support/{id}/reply', [App\Http\Controllers\Customer\SupportController::class, 'reply'])->name('customer.support.reply');
    Route::post('support/{id}/close', [App\Http\Controllers\Customer\SupportController::class, 'close'])->name('customer.support.close');
    Route::post('support/{id}/reopen', [App\Http\Controllers\Customer\SupportController::class, 'reopen'])->name('customer.support.reopen');
    Route::get('support/faq', [App\Http\Controllers\Customer\SupportController::class, 'faq'])->name('customer.support.faq');
});