<?php
use App\Http\Controllers\ProjectStartTimeController;

/*
|--------------------------------------------------------------------------
| Open Routes
|--------------------------------------------------------------------------
|
| Here is where you can register open (publicly accessible) routes for wedo internal API.
|
*/

Route::post('login', 'AuthController@login'); // Login user
Route::post('register', 'AuthController@register'); // Register user
Route::get('refresh', 'AuthController@refresh'); // Refresh user's expired JWT token

Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/', function () {
    return 'wedo.lu open api';
});

// Search routes
Route::post('search/company', 'CompanyController@searchCompany'); // Search for a company
Route::post('search/joboffer', 'JobOfferController@searchJoboffer'); // Search for a joboffer
Route::post('search/blog', 'PostController@searchBlog'); // Search for a joboffer

// Project routes
Route::get('project', 'ProjectController@index'); // List projects
Route::post('project/published/user', 'ProjectController@getPublishedProjectsByAuthor'); // List projects by author
Route::get('project/published', 'ProjectController@getPublishedProjects'); // List published projects
Route::get('project/{projectId}/contacted/{userId}', 'ProjectController@getUserContactedProject'); // get user contacted project
Route::post('project', 'ProjectController@store'); // Create a new project

Route::post('project/notifications', 'ProjectController@getOrSetUserProjectNotifications');

Route::get('project/starttime', 'ProjectStartTimeController@getAllStartTimes');
Route::get('project/starttime/key/{key}', 'ProjectStartTimeController@getStartTimeByKey');
Route::post('project/starttime/text', 'ProjectStartTimeController@getStartTimeKeyByText');

Route::put('project/contact/{projectId}/{userId}', 'ProjectController@increaseOffersCounter'); // Create a new project
Route::get('project/slug/{slug}', 'ProjectController@showProjectBySlug'); // List projects
Route::get('project/category/{category_id}', 'ProjectController@showProjectsByCategoryId'); // List projects by cat id

Route::get('project/{project_id}/categories', 'ProjectController@getProjectCats'); // Get project's subcategory or subcategories
Route::get('project/{project_id}/subcategories', 'ProjectController@getProjectSubcats'); // Get project's subcategory or subcategories

Route::post('projects/categories', 'ProjectController@showProjectsByCategoriesIds'); // List projects by cats ids
Route::post('projects/published/categories', 'ProjectController@showPublishedProjectsByCategoriesIds'); // List projects by cats ids

Route::post('projects/published/user/categories', 'ProjectController@showPublishedProjectsByCategoriesIdsByAuthor'); // List projects by cats ids and author

Route::post('projects/subcategories', 'ProjectController@showProjectsBySubCategoriesIds'); // List projects by subcats ids
Route::get('project/categories', 'ProjectCategoryController@showAll'); // List all project categories
Route::get('project/categories/{category_id}', 'ProjectCategoryController@showOne'); // List single project category
Route::get('project/categories/slug/{category_slug}', 'ProjectCategoryController@showOneBySlug'); // List single project category
Route::get('project/subcategories', 'ProjectSubCategoryController@showAll'); // List project subcategories
Route::get('project/subcategories/{sub_category_id}', 'ProjectSubCategoryController@showOne'); // List single project subcategory
Route::get('project/subcategories/category/{category_id}', 'ProjectSubCategoryController@showSubcatsByCat'); // List project subcategories by category
Route::get('project/subcategories/id/{sub_category_id}', 'ProjectSubCategoryController@showOne'); // List single project subcategory
Route::get('project/subcategories/slug/{sub_category_slug}', 'ProjectSubCategoryController@showOneBySlug'); // List single project subcategory
Route::get('project/subcategories/{cat_slug}/{subcat_slug}', 'ProjectSubCategoryController@showOneBySlugs'); // List single project subcategory
Route::get('project/submitted/{sub_category_id}', 'ProjectSubCategoryController@showSubcatsByCatExceptOneSubcat'); // List project subcategories by category except one subcat

// Company routes
Route::get('company', 'CompanyController@index'); // List companies
Route::get('company/id/{id}', 'CompanyController@companyById'); // single company by id
Route::get('company/name/id/{id}', 'CompanyController@companyNameById'); // List companies
Route::get('company/slug/{slug}', 'CompanyController@companyBySlug'); // single company by slug
Route::get('company/user/{id}', 'CompanyController@companiesByUserId'); // List companies by user id
Route::get('company/category/id/{id}', 'CompanyController@companiesByCatId'); // List companies by category id
Route::get('company/category/slug/{slug}', 'CompanyController@companiesByCatSlug'); // List companies by category slug
Route::get('company/service/slug/{slug}', 'CompanyController@companiesByServiceSlug'); // List companies by service slug
Route::get('category/tree', 'CategoryController@showAllTreeWithCount'); // List categories
Route::get('category/list', 'CategoryController@showAllList'); // List categories
Route::get('category/root', 'CategoryController@showRoots'); // List root categories
Route::get('category/{id}', 'CategoryController@showOne'); // single category

// Country routes
Route::get('country', 'CountryController@index'); // List countries

// JobOffer routes
Route::get('joboffer', 'JobOfferController@index'); // List joboffers
Route::post('joboffer/filter', 'JobOfferController@jobOffersByMultiOptions'); // List joboffers by multi options
Route::get('joboffer/id/{id}', 'JobOfferController@jobOfferById'); // single joboffer by id
Route::get('joboffer/slug/{slug}', 'JobOfferController@jobOfferBySlug'); // single joboffer by slug
Route::get('joboffer/user/{id}', 'JobOfferController@jobOffersByUserId'); // List joboffers by user id
Route::get('joboffer/company/{id}', 'JobOfferController@jobOffersByCompanyId'); // List joboffers by company id

// Event routes
Route::get('event', 'EventController@index'); // List events
Route::get('event/id/{id}', 'EventController@eventById'); // single event by id
Route::get('event/slug/{slug}', 'EventController@eventBySlug'); // single event by slug
Route::get('event/user/{id}', 'EventController@eventsByUserId'); // List events by user id
Route::get('event/company/{id}', 'EventController@eventsByCompanyId'); // List events by company id

// Promotion routes
Route::get('promotion', 'PromotionController@index'); // List promotions
Route::get('promotion/id/{id}', 'PromotionController@promotionById'); // single promotion by id
Route::get('promotion/slug/{slug}', 'PromotionController@promotionBySlug'); // single promotion by slug
Route::get('promotion/user/{id}', 'PromotionController@promotionsByUserId'); // List promotions by user id
Route::get('promotion/company/{id}', 'PromotionController@promotionsByCompanyId'); // List promotions by company id

// BlogTag routes
Route::get('tag', 'TagController@index'); // List tags
Route::get('tag/{id}', 'TagController@tagById'); // single tag by id

// Post routes
Route::get('post', 'PostController@index'); // List posts
Route::post('post/filter', 'PostController@postsByMultiOptions'); // List posts by multi options
Route::get('post/important', 'PostController@postsByImportance'); // List posts by importance
Route::get('post/id/{id}', 'PostController@postById'); // single post by id
Route::get('post/tag/id/{id}', 'PostController@postsByTagId'); // list posts by tag id
Route::get('post/tag/slug/{slug}', 'PostController@postsByTagSlug'); // list posts by tag slug
Route::get('post/slug/{slug}', 'PostController@postBySlug'); // list posts by tag id

// ProductType routes
Route::get('product/type', 'ProductTypeController@index'); // List product types
Route::get('product/type/{id}', 'ProductTypeController@show'); // Single product type

// PaymentMethod routes
Route::get('payment-method/', 'PaymentMethodController@index'); // List payment methods
Route::get('payment-method/{id}', 'PaymentMethodController@show'); // Single payment method

// Product routes
Route::get('product/', 'ProductController@index'); // List products
Route::get('product/{id}', 'ProductController@show'); // Single product
Route::get('product/slug/{slug}', 'ProductController@getBySlug'); // Single product by slug

// Order routes
Route::get('order/', 'OrderController@index'); // List orders
Route::get('order/{id}', 'OrderController@show'); // Single order

// Region routes
Route::get('region/', 'RegionController@index'); // List regions
Route::get('region/{id}', 'RegionController@regionById'); // Single region by region id

// Listing routes
Route::get('listing/service/{slug}', 'ListingController@listingsByServiceSlug'); // listings by service slug
Route::get('listing/{slug}', 'ListingController@listingBySlug'); // Single listing by slug
Route::get('listing/status/{slug}', 'ListingController@getListingStatusBySlug');

// Page routes
Route::get('page/{name}', 'PageController@pageByName'); // Single page by name

// Language routes
Route::get('language/', 'LanguageController@index');
Route::get('language/id/{id}', 'LanguageController@getLanguageById');
Route::get('language/key/{key}', 'LanguageController@getLanguageByKey');
Route::get('language/code/{key}', 'LanguageController@getLanguageByCode');
Route::get('language/code/{code}', 'LanguageController@getLanguageByCode');
Route::get('language/name/{name}', 'LanguageController@getLanguageByName');

// service routes
Route::get('service/', 'ServiceController@services');

// Timezone routes
Route::get('timezone/', 'TimezoneController@timezones');

// Image upload routes
Route::post('image/', 'ImageController@imageUpload');
Route::post('file/', 'ImageController@fileUpload');
Route::post('file/project', 'ImageController@projectFilesUpload');
