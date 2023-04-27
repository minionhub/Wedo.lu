<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register protected API routes for internal wedo API.
|
*/
Route::middleware('auth:protected')->group(function () {

    Route::get('pro', function() {
        return 'wedo.lu protected api (test route)';
    });

    // Authentication routes
    Route::get('user', 'AuthController@user'); // Get user info
    Route::post('logout', 'AuthController@logout'); // Logs user out from application
    Route::put('password', 'AuthController@changePassword'); // Changes user's password

    // User routes
    Route::get('users', 'UserController@getAllUsers'); // get all users
    Route::get('user/products/main', 'UserController@getUserMainSubscriptions'); // get user's main subscription
    Route::get('user/products/highest', 'UserController@getUserHighestSubscription'); // get user's highest main subscription
    Route::get('user/companies/{user_id}', 'UserController@getCompaniesIdsByUserId'); // Get companies managed by user
    Route::put('user/{user_id}', 'UserController@updateUser');
    Route::put('user/{user_id}/block/content', 'UserController@blockAllUsersContent');
    Route::put('user/{user_id}/unblock/content', 'UserController@unblockAllUsersContent');

    // Company routes
    Route::post('company-categories', 'CompanyCategoryController@store'); // List categories
    Route::put('company-categories', 'CompanyCategoryController@store'); // Update category
    Route::delete('company-categories/{id}', 'CompanyCategoryController@destroy'); // Delete category
    Route::post('company-subcategories', 'CompanySubCategoryController@store'); // List subcategories
    Route::put('company-subcategories', 'CompanySubCategoryController@store'); // Update subcategory
    Route::delete('company-subcategories/{id}', 'CompanySubCategoryController@destroy'); // Delete subcategory
    Route::post('company', 'CompanyController@store'); // Add new company
    Route::put('company/{id}', 'CompanyController@update'); // Update company
    Route::delete('company/{id}', 'CompanyController@destroy'); // Delete company

    // Project routes
    Route::post('project/search', 'ProjectController@searchAmongAllProjects');
    Route::post('project/search/own', 'ProjectController@searchAmongOwnProjects');
    Route::post('project/search/title', 'ProjectController@searchForProjectsAmongTitleOnly');

    Route::post('project/search/published', 'ProjectController@searchAmongAllPublishedProjects');
    Route::post('project/search/published/own', 'ProjectController@searchAmongOwnPublishedProjects');

    Route::delete('project/{project_id}', 'ProjectController@archiveProject'); // archive a project that belongs to a currently logged in user
    Route::post('project/categories', 'ProjectCategoryController@store'); // Create a new project category
    Route::put('project/categories', 'ProjectCategoryController@store'); // Update project category
    Route::delete('project/categories/{id}', 'ProjectCategoryController@destroy'); // Delete project category
    Route::post('project/subcategories', 'ProjectSubCategoryController@store'); // Create new project subcategory
    Route::put('project/subcategories', 'ProjectSubCategoryController@store'); // Update project subcategory
    Route::delete('project/subcategories/{id}', 'ProjectSubCategoryController@destroy'); // Delete project subcategory

    // JobOffer routes\
    Route::post('joboffer', 'JobOfferController@store'); // Add new joboffer
    Route::put('joboffer/{id}', 'JobOfferController@update'); // Update joboffer
    Route::delete('joboffer/{id}', 'JobOfferController@destroy'); // Delete joboffer

    // Event routes\
    Route::post('event', 'EventController@store'); // Add new event
    Route::put('event/{id}', 'EventController@update'); // Update event
    Route::delete('event/{id}', 'EventController@destroy'); // Delete event

    // Promotion routes
    Route::post('promotion', 'PromotionController@store'); // Add new promotion
    Route::put('promotion/{id}', 'PromotionController@update'); // Update promotion
    Route::delete('promotion/{id}', 'PromotionController@destroy'); // Delete promotion

    // Tag routes
    Route::post('tag', 'TagController@store'); // Add new tags
    Route::put('tag/{id}', 'TagController@update'); // Update tags
    Route::delete('tag/{id}', 'TagController@destroy'); // Delete tags

    // Post routes
    Route::post('post', 'PostController@store'); // Add new post
    Route::put('post/{id}', 'PostController@update'); // Update post
    Route::delete('post/{id}', 'PostController@destroy'); // Delete post

    // User Address routes
    Route::post('address', 'AddressController@store'); // Create a new user address
    Route::put('address', 'AddressController@store'); // Update user address
    Route::put('address/default/{id}', 'AddressController@setDefaultAddress'); // Update default address
    Route::get('address', 'AddressController@showAll'); // Get all user addresses info
    Route::get('address/company/{id}', 'AddressController@addressesByCompanyId'); // Get company address info
    Route::get('address/user', 'AddressController@addressesByUser'); // Get user address info
    Route::get('address/{id}', 'AddressController@showOne'); // Get user address info
    Route::delete('address/{id}', 'AddressController@destroy'); // Delete user address

    // ProductType routes
    Route::post('product/type', 'ProductTypeController@store'); // Create new product type
    Route::put('product/type/{id}', 'ProductTypeController@update'); // Update product type
    Route::delete('product/type/{id}', 'ProductTypeController@destroy'); // Delete product type

    // PaymentMethod routes
    Route::post('payment-method', 'PaymentMethodController@store'); // Create new payment method
    Route::put('payment-method/{id}', 'PaymentMethodController@update'); // Update payment method
    Route::delete('payment-method/{id}', 'PaymentMethodController@destroy'); // Delete payment method

    // Product routes
    Route::post('product', 'ProductController@store'); // Create new product
    Route::put('product/{id}', 'ProductController@update'); // Update product
    Route::delete('product/{id}', 'ProductController@destroy'); // Delete product

    // Order routes
    Route::post('order', 'OrderController@store'); // Create new order
    Route::put('order/{id}', 'OrderController@update'); // Update order
    Route::delete('order/{id}', 'OrderController@destroy'); // Delete order

    // Listing routes
    Route::get('listing/user', 'ListingController@listingsByUser'); // Listings by user id
    Route::put('listing/status/{slug}', 'ListingController@setListingStatusBySlug');

    // Claim routes
    Route::post('claim', 'ClaimController@store'); // Create new claim

});
