<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TrackVisitor;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\CustomerLoginController;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\FrontLandingPageController;
use App\Http\Controllers\Frontend\SitemapController;
use App\Http\Controllers\Frontend\WhatsappConfirmationController;
use App\Http\Controllers\Frontend\RazorpayController;
use App\Http\Controllers\Frontend\ProductReviewController;

use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Backend\ForgotPasswordController;
use App\Http\Controllers\Backend\CacheController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\PermissionsController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\LabelController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubcategoryController;
use App\Http\Controllers\Backend\AttributeController;
use App\Http\Controllers\Backend\ProductsController;
use App\Http\Controllers\Backend\InventoryController;
use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\ItemController;
use App\Http\Controllers\Backend\CustomerControllerBackend;
use App\Http\Controllers\Backend\OrderControllerBackend;
use App\Http\Controllers\Backend\DatabaseController;
use App\Http\Controllers\Backend\GroupController;
use App\Http\Controllers\Backend\BlogCategoryController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\PrimaryCategoryController;
use App\Http\Controllers\Backend\WhatsAppController;
use App\Http\Controllers\Backend\WhatsAppGroupController;
use App\Http\Controllers\Backend\WhatsappConversationController;
use App\Http\Controllers\Backend\SocialMediaTrackController;
use App\Http\Controllers\Backend\LandingPageController;
use App\Http\Controllers\Backend\StorageController;
use App\Http\Controllers\Backend\ProductReviewBackendController;
use App\Http\Controllers\Backend\VideoController;
use App\Http\Controllers\Backend\EnquiryController;

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



Route::group(['prefix' => 'account'], function() {
	Route::get('/login', [CustomerLoginController::class, 'showCustomerLoginForm'])->name('logincustomer');
	Route::post('/customer-request-otp', [CustomerLoginController::class, 'requestOtp'])->name('customer.request.otp');
	Route::post('/customer-verify-otp', [CustomerLoginController::class, 'verifyOtp'])->name('customer.verify.otp');
	Route::post('/customer-resend-otp', [CustomerLoginController::class, 'resendOtp'])->name('customer.resend.otp');
	Route::post('/customer-update-details', [CustomerLoginController::class, 'customerUpdateDetails'])->name('customer.update.details');
	Route::get('/login/google', [CustomerLoginController::class, 'redirectToGoogle'])->name('google.login');
	Route::get('/login/google/callback', [CustomerLoginController::class, 'handleGoogleCallback']);
    Route::get('/google/complete-profile', [CustomerLoginController::class, 'googleRedirectAfterForm'])->name('google.complete-profile');
    Route::post('/google/complete-profile', [CustomerLoginController::class, 'storeGoogleProfile'])->name('google.store-profile');
});
Route::group(['middleware' => ['auth.customer']], function() {
    Route::get('/user-notifications', [CustomerLoginController::class, 'getNotifications']);
    Route::post('/notifications/{id}/read', [CustomerLoginController::class, 'markAsRead']);
});
Route::post('shipping-info', [FrontendController::class, 'checkServiceability'])->name('shipping-info');
Route::get('pay-modal-form', [OrderController::class, 'payModalForm'])->name('pay-modal-form');
Route::post('pay-modal-form/submit', [OrderController::class, 'payModalFormSubmit'])->name('pay-modal-form.submit');
Route::middleware([TrackVisitor::class])->group(function () {
    Route::get('/', [FrontendController::class, 'home'])->name('home');
    Route::get('flash-sale', [FrontendController::class, 'flashSale'])->name('flash.sale');
    Route::get('kitchen-catalog/{category}/{attribute}/{value}', [FrontendController::class, 'showProductCatalog'])->name('kitchen.catalog');
    Route::get('categories/{categorySlug}', [FrontendController::class, 'showCategoryProduct'])->name('categories')->withoutMiddleware('auth');
    Route::get('/product-catalog/filter', [FrontendController::class, 'filterProducts'])->name('product.filter');
    Route::get('products/{slug}/{attributesvalue}', [FrontendController::class, 'showProductDetails'])->name('product');
    Route::get('/search/suggestions', [SearchController::class, 'searchSuggestions'])->name('search.suggestions');
    Route::get('search', [SearchController::class, 'searchListProduct'])->name('search');

    Route::get('quick/view', [FrontendController::class, 'QuickViewModal'])->name('quick.view');
    /**Blog route */
    Route::get('blogs/list/{slug}', [FrontendController::class, 'blogList'])->name('blog.list');
    Route::get('blogs/{slug}', [FrontendController::class, 'blogDetails'])->name('blog.details');
    Route::get('contact-us', [FrontendController::class, 'contactUs'])->name('contact-us');
    Route::post('contact-us/submit', [FrontendController::class, 'contactUsSubmit'])->name('contact-us.submit');
    Route::get('about-us', [FrontendController::class, 'aboutUs'])->name('about-us');
    Route::post('product-enquiry-modal-form', [FrontendController::class, 'productEnquiryModalForm'])->name('product-enquiry-modal-form');
    Route::post('product-enquiry-modal-form-submit', [FrontendController::class, 'productEnquiryModalFormSubmit'])->name('product-enquiry-modal-form.submit');
    Route::get('lp', [FrontLandingPageController::class, 'landingPage'])->name('lp');
    Route::get('privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('terms-of-use', [FrontendController::class, 'termsOfUse'])->name('terms-of-use');

    Route::post('add-to-cart', [CustomerController::class, 'addToCart'])->name('add.to.cart');
    Route::match(['get', 'post'], 'cart', [CustomerController::class, 'cartList'])->name('cart');
    Route::post('/cart/remove', [CustomerController::class, 'removeFromCart'])->name('cart.remove');
    /**cart drawer route */
    Route::get('/cart/change', [CustomerController::class, 'changeQuantityCartDrawer'])->name('cart.changeQuantity');
    Route::get('checkout', [CustomerController::class, 'checkOut'])->name('checkout');
    Route::post('/ajax/check-shiprocket', [CustomerController::class, 'checkServiceability'])
    ->name('ajax.check-shiprocket');
    Route::post('checkout/submit', [OrderController::class, 'checkOutFormSubmit'])->name('checkout.submit');
    Route::post('/razorpay/callback', [OrderController::class, 'handleRazorpayCallback'])->name('razorpay.callback');
    Route::post('/payment-failed', [OrderController::class, 'handlePaymentFailed'])->name('payment.failed');
    Route::get('order/success', [OrderController::class, 'showOrderSuccess'])->name('order.success');
    
    Route::group(['middleware' => ['auth.customer']], function() {
        //Route::get('/user-notifications', [CustomerLoginController::class, 'getNotifications']);
        //Route::post('/notifications/{id}/read', [CustomerLoginController::class, 'markAsRead']);
        Route::get('myaccount', [CustomerController::class, 'myaccount'])->name('myaccount');
        Route::Post('customer-logout', [CustomerLoginController::class, 'CustomerLogout'])->name('customer.logout');
        Route::post('upload-profile', [CustomerController::class, 'uploadProfileImg'])->name('upload.profile');
        
        /**WISHLIST ROUTE PENDING */
        Route::post('/wishlist/add', [CustomerController::class, 'addToWishlist'])->name('wishlist.add');        
        Route::post('add/address', [CustomerController::class, 'addAddressForm'])->name('add.address');
        Route::post('add/address/submit', [CustomerController::class, 'addAddressFormSubmit'])->name('add.address.submit');
        Route::post('edit/address/{id}', [CustomerController::class, 'editAddressForm'])->name('edit.address');
        Route::put('update/address/{id}', [CustomerController::class, 'editAddressFormSubmit'])->name('update.address');
        /** */
        // Razorpay Routes
        Route::post('/razorpay/magic/order', [RazorpayController::class, 'createMagicOrder'])
        ->name('razorpay.magic.order.create');
        Route::post('/razorpay/magic/callback', [RazorpayController::class, 'handleMagicCallback'])
            ->name('razorpay.magic.callback');
        // Route::get('/order-success', [OrderController::class, 'success'])->name('order.success');
        // Route::get('/order-failed', [OrderController::class, 'failed'])->name('order.failed');
        /** */
        Route::group(['prefix' => 'account'], function() {
            Route::get('address', [CustomerController::class, 'showCustomerAddress'])->name('address');
            Route::get('customer-profile', [CustomerController::class, 'customerProfile'])->name('customer-profile');
            Route::get('order', [OrderController::class, 'showCustomerOrder'])->name('order');
            Route::get('order/{order_id}', [OrderController::class, 'showCustomerOrderDetails'])->name('order.details');
            Route::get('wishlist', [OrderController::class, 'showCustomerWishlist'])->name('wishlist');
            Route::post('/wishlist/remove', [OrderController::class, 'removeFromWishlist'])->name('wishlist.remove');
            Route::post('/address/store', [CustomerController::class, 'CustomerAddressStore'])->name('address.store');
            Route::get('/address/{id}/edit', [CustomerController::class, 'CustomerAddressEdit'])->name('address.edit');
            Route::post('/address/{id}/update', [CustomerController::class, 'CustomerAddressUpdate'])->name('address.update');
            Route::delete('/address/{customer_id}/{address_id}', [CustomerController::class, 'CustomerAddressRemove'])->name('address.remove');
            Route::get('order-param', [OrderController::class, 'orderParameter'])->name('order-param');
            Route::get('pick-up-store', [OrderController::class, 'pickUpStore'])->name('pick-up-store');
        });
    });
});
Route::post('/submit-product-review', [ProductReviewController::class, 'store'])->name('product.review.store');
Route::get('request-product-enquiry-form', [FrontendController::class, 'requestProductEnquiryForm'])->name('request.product.enquiry.form');
Route::post('request-product-enquiry-submit', [FrontendController::class, 'requestProductSubmit'])->name('request.product.enquiry.submit');
Route::get('/confirmwa/yes/{value}', [WhatsappConfirmationController::class, 'confirmWhatsappYes'])->name('confirmwa.yes');
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::post('/update-counter', [FrontendController::class, 'updateCounter'])->name('update.counter');
Route::get('/wp-otp-form', [FrontendController::class, 'WhatAppClickShowOtpForm'])->name('wp.otp.form');
Route::post('/wp-verify-otp', [FrontendController::class, 'WhatappVerifyOtp'])->name('wp.verify.otp');

Route::post('click-tracker', [FrontendController::class, 'clickTracker'])->name('click.tracker');




/**backend rout */
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm']);
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('forget/password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password');
    Route::post('forget.password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.submit');

    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

//Route::group(['middleware' => ['auth']], function() {
Route::group(['middleware' => ['admin']], function () {
    Route::group(['prefix' => 'users'], function() {
        Route::get('/', [UsersController::class, 'index'])->name('users');
        Route::get('/create', [UsersController::class, 'create'])->name('users.create');
        Route::post('/create', [UsersController::class, 'store'])->name('users.store');
        Route::get('/{user}/show', [UsersController::class, 'show'])->name('users.show');
        Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
        Route::patch('/{user}/update', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/{user}/delete', [UsersController::class, 'destroy'])->name('users.destroy');
        // Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);
        Route::get('/profile', [UsersController::class, 'UserProfile'])->name('profile');
        Route::get('/profile/{id}/edit', [UsersController::class, 'UserProfileEditForm'])->name('profile.edit');
        Route::post('/profile/{id}/update', [UsersController::class, 'UserProfileEditFormSubmit'])->name('profile.update');
    });
    
    Route::get('/clear-cache', [CacheController::class, 'clearCache'])->name('clear-cache');
    Route::get('database-management', [DatabaseController::class, 'showTables'])->name('show.tables');
    Route::post('truncate-tables', [DatabaseController::class, 'truncateTables'])->name('truncate.tables');
    Route::get('backup-database', [DatabaseController::class, 'backupDatabase'])->name('backup.database');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/filtered-data', [DashboardController::class, 'getFilteredProductData'])
    ->name('dashboard.filtered-data');
    Route::get('get-visitor-stats', [DashboardController::class, 'getVisitorStats'])->name('get-visitor-stats');
    Route::get('get-visitor-list', [DashboardController::class, 'getVisitorList'])->name('get-visitor-list');
     Route::get('click-details', [DashboardController::class, 'getClickDetails'])->name('get-click-details');

    Route::get('brand', [BrandController::class, 'index'])->name('brand');
    Route::post('brand/create', [BrandController::class, 'create'])->name('brand.create');
    Route::post('/brand', [BrandController::class, 'store'])->name('brand.store');
    Route::post('/update-status/{brand}', [BrandController::class, 'updateStatus'])->name('updateStatus');
    Route::post('brand/edit', [BrandController::class, 'edit'])->name('brand.edit');
    Route::post('brand/update/{brand}', [BrandController::class, 'updateBrand'])->name('brand.update');
    Route::delete('brand/delete/{brand}', [BrandController::class, 'deleteBrand'])->name('brand.delete');
    /**label */
    Route::get('label', [LabelController::class, 'index'])->name('label');
    Route::post('label/create', [LabelController::class, 'create'])->name('label.create');
    Route::post('/label', [LabelController::class, 'store'])->name('label.store');
    Route::post('label/edit/{label}', [LabelController::class, 'edit'])->name('label.edit');
    Route::post('label/update/{label}', [LabelController::class, 'updateLabel'])->name('label.update');
    Route::delete('label/delete/{label}', [LabelController::class, 'deleteLabel'])->name('label.delete');
    Route::get('label-product/{labelId}', [LabelController::class, 'labelProduct'])->name('label-product');
    Route::post('label-product-form-submit/{labelId}', [LabelController::class, 'labelProductFormSubmit'])->name('label-product-form.submit');
    /**category route */
    Route::get('category', [CategoryController::class, 'index'])->name('category');
    Route::post('category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::post('category/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('category/update/{category}', [CategoryController::class, 'updateCategory'])->name('category.update');
    Route::delete('category/delete/{category}', [CategoryController::class, 'deletaCategory'])->name('category.delete');
    Route::get('category/{id}', [CategoryController::class, 'show'])->name('category.show');
    Route::post('mapped-category-attributes-front/submit', [CategoryController::class, 'saveMappedCategoryAttributes'])->name('mappedCategoryAttributesFront.submit');

    /**subcategory */
    Route::get('subcategory', [SubcategoryController::class, 'index'])->name('subcategory');
    Route::post('subcategory/create', [SubcategoryController::class, 'create'])->name('subcategory.create');
    Route::post('/subcategory', [SubcategoryController::class, 'store'])->name('subcategory.store');
    Route::post('subcategory/edit/{subcategory}', [SubcategoryController::class, 'edit'])->name('subcategory.edit');
    Route::post('subcategory/update/{subcategory}', [SubcategoryController::class, 'updateSubcategory'])->name('subcategory.update');
    /**subcategory */
    /**Attributes */
    Route::get('attributes', [AttributeController::class, 'index'])->name('attributes');
    Route::post('attributes/create', [AttributeController::class, 'create'])->name('attributes.create');
    Route::post('/attributes', [AttributeController::class, 'store'])->name('attributes.store');
    Route::post('attributes/edit/{attributes}', [AttributeController::class, 'edit'])->name('attributes.edit');
    Route::post('attributes/update/{attributes}', [AttributeController::class, 'updateAttributes'])->name('attributes.update');

    Route::get('attributes-option/{attributes}', [AttributeController::class, 'attributesOption'])->name('attributes-option');
    Route::post('merge-attributes-value', [AttributeController::class, 'mergeAttributesValue'])->name('merge-attributes-value');
    Route::post('merge-attributes-value/submit', [AttributeController::class, 'mergeAttributesValueFormSubmit'])->name('merge-attributes-value.submit');

    Route::post('attributes-value-upload-img', [AttributeController::class, 'showForm'])->name('attributes-value-upload-img');
    Route::post('attributes-value-upload-img/submit', [AttributeController::class, 'showFormSubmit'])->name('attributes-value-upload-img.submit');

    Route::post('/attributes-value', [AttributeController::class, 'attributesValueStore'])->name('attributes-value.store');
    Route::get('attributesvalue-list', [AttributeController::class, 'attributesValueList'])->name('attributesvalue-list');
    /**attributes value wise update gst and hsn code */
    Route::get('update-hsn-gst-with-attributes-value/{attributes_id}/{category_id}', [AttributeController::class, 'updateHsnGstWithAttributesValue'])->name('update-hsn-gst-with-attributes-value');
    Route::post('/update-hsn-gst-attributes-value', [AttributeController::class, 'updateHsnGstAttributesValueFormSubmit'])->name('update-hsn-gst-attributes-value');
    Route::post('get-hsn-and-gst', [AttributeController::class, 'getHsnAndGst'])->name('get-hsn-and-gst');
    
    /**attributes value wise update gst and hsn code */
    

    Route::post('/attributes-value/edit/{attributesValue}', [AttributeController::class, 'attributesValueEdit'])->name('attributes-value.edit');
    Route::post('attributes-value/update/{attributesValue}', [AttributeController::class, 'updateAttributesValue'])->name('attributes-value.update');
    Route::delete('attributes-value/delete/{attributesValue}', [AttributeController::class, 'deletaAttributesValue'])->name('attributes-value.delete');

    Route::post('/attribute-values/sort', [AttributeController::class, 'sort'])->name('attribute-values.sort');

    Route::get('product-catalog-attributes-value/{value}', [AttributeController::class, 'productCatalogWithAttributesValue'])->name('product-catalog-attributes-value');
    /**Attributes */
    /**Product route */
    Route::resource('product', ProductsController::class);
    
    Route::post('/products/bulk-delete', [ProductsController::class, 'bulkDelete'])->name('product.bulkDelete');
    Route::post('/products/modal-image-form', [ProductsController::class, 'imageUploadModalForm'])->name('products.modal-image-form');
    Route::post('/products/modal-image-form/submit', [ProductsController::class, 'imageUploadModalFormSubmit'])->name('products.modal-image-form.submit');
    //Route::post('products/add-new-att-value', [ProductsController::class, 'addNewAttributesValueForm'])->name('products.add-new-att-value');
    //Route::post('products/add-new-att-value/submit', [ProductsController::class, 'addNewAttributesValueFormSubmit'])->name('products.add-new-att-value.submit');
    Route::post('/get-filtered-attributes', [ProductsController::class, 'getFilteredAttributes'])->name('getFilteredAttributes');
    Route::post('/add-more-attributes-row', [ProductsController::class, 'addMoreAttributesRow'])->name('addMoreAttributesRow');
    Route::get('product/image/delete/{id}', [ProductsController::class, 'deleteImage'])->name('product.image.delete');
    Route::get('/export-product', [ProductsController::class, 'exportProduct'])->name('export.product');
    Route::get('product/excel/import', [ProductsController::class, 'importExcelProduct'])->name('product.excel.import');
    Route::post('/product/excel/store', [ProductsController::class, 'ExcelStore'])->name('product.excel.store');
    Route::post('/product-image/sort', [ProductsController::class, 'sort'])->name('product-image.sort');
    Route::get('/product-update-gst', [ProductsController::class, 'updateProductListWithGST'])->name('product-update-gst');
    Route::get('/product-update-gst/filter', [ProductsController::class, 'filterProductListWithHsnGst'])->name('product-update-gst.filter');
    Route::get('product-multiple-update', [ProductsController::class, 'productMultipleUpdatePage'])->name('product-multiple-update');
    Route::post('product-update-all', [ProductsController::class, 'productMultipleUpdatePageSubmit'])->name('product-update-all');
    
    //Route::POST('/product-update-gst/create', [ProductsController::class, 'updateHSNCodeGstForm'])->name('product-update-gst.create');
    Route::POST('/product-update-gst/store', [ProductsController::class, 'updateHSNCodeGstFormSubmit'])->name('product-update-gst.store');
    /**Product route */
    /**inventory route */
    Route::get('/manage-inventory', [InventoryController::class, 'index'])->name('manage-inventory.index');
    Route::post('/manage-inventory/create', [InventoryController::class, 'create'])->name('manage-inventory.create');
    Route::post('/manage-inventory/store', [InventoryController::class, 'store'])->name('manage-inventory.store');
    Route::post('/manage-inventory/update/{id}', [InventoryController::class, 'update'])->name('manage-inventory.update');
    Route::delete('/manage-inventory/delete/{id}', [InventoryController::class, 'destroy'])->name('manage-inventory.delete');
    Route::get('export-inventory', [InventoryController::class, 'exportInventory'])->name('export.inventory');
    Route::get('import-inventory', [InventoryController::class, 'importInventory'])->name('import.inventory');
    Route::post('inventory-import-form', [InventoryController::class, 'inventoryImportForm'])->name('inventory.import.form');
    /**inventory route */
    /*Vendor Route */
    Route::get('/manage-vendor', [VendorController::class, 'index'])->name('manage-vendor.index');
    Route::get('/manage-vendor.create', [VendorController::class, 'create'])->name('manage-vendor.create');
    Route::post('/manage-vendor/store', [VendorController::class, 'store'])->name('manage-vendor.store');
    Route::post('/manage-vendor/update/{id}', [VendorController::class, 'update'])->name('manage-vendor.update');
    Route::delete('/manage-vendor/delete/{id}', [VendorController::class, 'destroy'])->name('manage-vendor.delete');
    /*Vendor Route */
    /*Item Route or purchase route*/
    Route::get('/manage-item', [ItemController::class, 'index'])->name('manage-item.index');
    Route::get('/manage-item/create', [ItemController::class, 'create'])->name('manage-item.create');
    Route::post('/manage-item/store', [ItemController::class, 'store'])->name('manage-item.store');
    Route::delete('manage-item/delete-multiple', [ItemController::class, 'deleteMultiplePurchaseItem'])->name('manage-item.delete-multiple');
    Route::get('create-new-product/modal', [ItemController::class, 'createNewProductModal'])->name('create-new-product.modal');
    Route::post('append-product-modal-form-content', [ItemController::class, 'appendProductModalFormContent'])->name('append-product-modal-form-content');
    /*Item Route or purchase route */
    /*AUTOCOMPLETE  ROUTE*/
    Route::get('/autocomplete/vendors', [VendorController::class, 'autocomplete'])->name('autocomplete.vendors');
    Route::get('/autocomplete/products', [ProductsController::class, 'autocompleteProducts'])->name('autocomplete.products');
    /*AUTOCOMPLETE ROUTE*/
    /**Customer route */
    Route::get('manage-customer', [CustomerControllerBackend::class, 'index'])->name('manage-customer');
    Route::post('manage-customer/add', [CustomerControllerBackend::class, 'addNewCustomerModalForm'])->name('manage-customer.add');
    Route::post('manage-customer/add/submit', [CustomerControllerBackend::class, 'addNewCustomerModalFormSubmit'])->name('manage-customer.add.submit');
    Route::get('manage-customer/edit/{id}', [CustomerControllerBackend::class, 'editCustomerForm'])->name('manage-customer.edit');
    Route::post('manage-customer/update/{id}', [CustomerControllerBackend::class, 'editCustomerFormSubmit'])->name('manage-customer.update');
    Route::get('customer-details/{id}', [CustomerControllerBackend::class, 'showCustomerDetails'])->name('customer-details');
    Route::get('customer-wishlist/{id}', [CustomerControllerBackend::class, 'showCustomerWishlist'])->name('customer-wishlist');
    
    Route::get('customer-orders/{id}', [CustomerControllerBackend::class, 'showCustomerOrdersList'])->name('customer-orders');
    Route::delete('manage-customer/delete/{id}', [CustomerControllerBackend::class, 'customerDelete'])->name('manage-customer.delete');
    Route::get('/customer/import', [CustomerControllerBackend::class, 'importForm'])->name('customer.importForm');
    Route::post('/customer/import', [CustomerControllerBackend::class, 'importFormSubmit'])->name('customer.import');
    Route::post('update-customer-group', [CustomerControllerBackend::class, 'updateCustomerGroup'])->name('update-customer-group');
    Route::get('manage-group', [GroupController::class, 'groupList'])->name('manage-group');
    Route::get('add-new-group', [GroupController::class, 'addNewGrupModal'])->name('add-new-group');
    Route::Post('add-new-group/submit', [GroupController::class, 'addNewGrupModalSubmit'])->name('add-new-group.submit');
    Route::get('edit-group/{id}', [GroupController::class, 'editGroupModal'])->name('edit-group');
    Route::post('update-group/{id}', [GroupController::class, 'update'])->name('update-group.submit');
    Route::delete('group/{id}', [GroupController::class, 'groupDelete'])->name('group.delete');
    Route::get('manage-group-category', [GroupController::class, 'groupCategoryList'])->name('manage-group-category');

    Route::post('add-new-group-category', [GroupController::class, 'addNewGrupCategoryModal'])->name('add-new-group-category');
    Route::Post('add-new-group-category/submit', [GroupController::class, 'addNewGrupCategoryModalSubmit'])->name('add-new-group-category.submit');
    Route::get('edit-group-category/{id}', [GroupController::class, 'editGroupCategoryModal'])->name('edit-group-category');
    Route::post('update-group-category/{id}', [GroupController::class, 'editGroupCategoryModalSubmit'])->name('update-group-category.submit');
    Route::delete('group-category/{id}', [GroupController::class, 'groupCategoryDelete'])->name('group-category.delete');
    /**Customer route */
    /**Order Route */
    Route::get('order-list', [OrderControllerBackend::class, 'showAllOrderList'])->name('order-list');
    Route::get('order-details/{id}', [OrderControllerBackend::class, 'showOrderDetails'])->name('order-details');
    Route::delete('order-list/destroy/{id}', [OrderControllerBackend::class, 'orderDelete'])->name('order-list.destroy');
    Route::post('update-order-status/{orderId}', [OrderControllerBackend::class, 'updateOrderStatus'])->name('update-order-status');
    Route::get('download-invoice/{orderId}', [OrderControllerBackend::class, 'downloadInvoice'])->name('download-invoice');
    /**Order Route */
    /**Blog Route */
    Route::resource('manage-blog-category', BlogCategoryController::class);
    Route::resource('manage-blog', BlogController::class);
    Route::delete('remove-blog-paragraphs/{id}', [BlogController::class, 'removeBlogParagraphs'])->name('remove-blog-paragraphs');
    /**Blog Route */
    /**Banner route */
    Route::resource('manage-banner', BannerController::class);
    Route::resource('manage-primary-category', PrimaryCategoryController::class);
    Route::post('manage-primary-category/{id}/status', [PrimaryCategoryController::class, 'updateStatus'])->name('manage-primary-category.status');
    Route::resource('manage-video', VideoController::class);
    /**Banner route */
    Route::resource('manage-whatsapp', WhatsAppController::class);
    Route::get('/autocomplete/products-whatsapp', [WhatsAppController::class, 'autocompleteProductsWhatsapp'])->name('autocomplete.products-whatsapp');
    Route::get('whatsapp-conversations/autocomplete', [WhatsAppController::class, 'autocomplete']);
    Route::get('image-file-rename', [WhatsAppController::class, 'imageFileRename'])->name('image-file-rename');
    Route::resource('manage-group-whatsapp', WhatsAppGroupController::class);
    Route::resource('manage-landing-page', LandingPageController::class);
    Route::get('social-media-track-list', [SocialMediaTrackController::class, 'socialMediaTrackList'])->name('social-media-track-list');
    Route::resource('manage-whatsapp-conversation', WhatsappConversationController::class);
    Route::post('whatsapp-conversation-send/{id}', [WhatsappConversationController::class, 'sendAgainMsgModal'])->name('whatsapp-conversation.send');
    Route::post('whatsapp-conversation-sendmessage/{id}', [WhatsappConversationController::class, 'sendAgainMsgModalSubmit'])->name('whatsapp-conversation.sendmessage');
    Route::get('manage-storage', [StorageController::class, 'index'])->name('manage-storage');
    Route::get('manage-storage/create', [StorageController::class, 'create'])->name('manage-storage.create');
    Route::post('manage-storage/comment/submit/{id}', [StorageController::class, 'storageCommentSubmit'])->name('manage-storage.comment.submit');
    Route::post('manage-storage/submit', [StorageController::class, 'store'])->name('manage-storage.submit');
    Route::delete('manage-storage/{id}',  [StorageController::class, 'destroy'])->name('manage-storage.delete');
    Route::post('mapped-image-to-product/submit', [StorageController::class, 'mappedImageToProductSubmit'])->name('mapped-image-to-product.submit');
    Route::get('/manage-enquiry/request-product-list', [EnquiryController::class, 'requestProductList'])->name('manage-enquiry.request.product.list');
    Route::delete('/manage-enquiry/request-product-list/{id}', [EnquiryController::class, 'requestProductListDestroy'])->name('manage-enquiry.request.product.destroy');

    Route::get('manage-rating', [ProductReviewBackendController::class, 'index'])->name('manage-rating');
    Route::post('manage-rating/{id}/status', [ProductReviewBackendController::class, 'updateStatus'])->name('manage-rating.status');

    Route::get('manage-rating/{id}', [ProductReviewBackendController::class, 'show'])->name('manage-rating.show');
    Route::get('manage-rating/{id}/edit', [ProductReviewBackendController::class, 'edit'])->name('manage-rating.edit');
    Route::put('manage-rating/{id}', [ProductReviewBackendController::class, 'update'])->name('manage-rating.update');
    Route::delete('manage-rating/{id}', [ProductReviewBackendController::class, 'destroy'])->name('manage-rating.destroy');
    Route::get('/review-files/{file}', [ProductReviewBackendController::class, 'destroyFile'])
    ->name('review.files.destroy');

    Route::prefix('shiprocket')->group(function () {
        Route::post('/create-order/{id}', [OrderControllerBackend::class, 'createShipRocketOrder'])->name('shiprocket.create.order');
        Route::post('/generate-awb/{id}', [OrderControllerBackend::class, 'generateShipRocketAWB'])->name('shiprocket.generate.awb');
        Route::post('/pickup/{id}', [OrderControllerBackend::class, 'pickup'])->name('shiprocket.pickup');
        Route::post('/update-order/{id}', [OrderControllerBackend::class, 'updateShipRocketOrder'])->name('shiprocket.update.order');
        Route::post('/cancel-order/{id}', [OrderControllerBackend::class, 'cancelShipRocketOrder'])->name('shiprocket.cancel.order');
        Route::post('/update-address/{id}', [OrderControllerBackend::class, 'updateShipRocketOrderAddress'])->name('shiprocket.update.address');
       
    });	
});