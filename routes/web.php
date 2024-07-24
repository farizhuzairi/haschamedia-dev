<?php

use Illuminate\Support\Facades\Route;
use HaschaDev\Services\Page\Routerable;

/**
 * PUBLIC
 * -----------------------------------
 * IndexController@index: index
 * 
 */
Route::prefix('')->group(function () {

    /**
     * Index Page
     * 
     */
    Route::get(
        '/',
        [\HaschaDev\Http\Controllers\IndexController::class, 'index']
    )->name(Routerable::INDEX->value);

});

/**
 * AUTHENTICATION
 * -----------------------------------
 * AuthController@_: login, register
 * 
 */
Route::prefix('')->middleware([
    'guest'
])->group(function () {

    /**
     * Auth - Login Page
     * 
     */
    Route::get(
        '/login',
        [\HaschaDev\Http\Controllers\AuthController::class, 'login']
    )->name(Routerable::LOGIN->value);

    /**
     * Auth - Registration Page
     * 
     */
    Route::get(
        '/register',
        [\HaschaDev\Http\Controllers\AuthController::class, 'register']
    )->name(Routerable::REGISTER->value);

});
Route::post(
    '/logout',
    [\HaschaDev\Http\Controllers\LogoutController::class, 'index']
)->name(Routerable::LOGOUT->value);

/**
 * ADMINISTRATOR
 * -----------------------------------
 * DashboardController@index: dashboard
 * 
 */
Route::prefix('/dashboard')->middleware([
    'auth'
])->group(function () {

    /**
     * Default Index
     * 
     */
    Route::get(
        '/',
        [\HaschaDev\Http\Controllers\DashboardController::class, 'index']
    )->name(Routerable::DASHBOARD->value);

});

/**
 * PRODUCT APP
 * -----------------------------------
 * ProductController@
 * 
 */
Route::prefix('/product')->middleware([
    'auth'
])->group(function () {

    /**
     * Product Index
     * 
     */
    Route::get(
        '/',
        [\HaschaDev\Http\Controllers\Product\ProductController::class, 'index']
    )->name(Routerable::PRODUCT->value);

    /**
     * Craete Product
     * 
     */
    Route::get(
        '/create/{key}',
        [\HaschaDev\Http\Controllers\Product\ProductController::class, 'create']
    )->name(Routerable::PRODUCT_CREATE->value);

    /**
     * Manage Product
     * 
     */
    Route::get(
        '/manage/{productId}',
        [\HaschaDev\Http\Controllers\Product\ProductController::class, 'manage']
    )->name(Routerable::PRODUCT_MANAGE->value)->whereNumber('productId');

});

/**
 * FEATURE MODEL
 * -----------------------------------
 * FeatureModelController@
 * 
 */
Route::prefix('/product/{productId}/feature-model')->middleware([
    'auth'
])->group(function () {

    /**
     * Feature Model Page
     * 
     */
    Route::get(
        '/',
        [\HaschaDev\Http\Controllers\Product\FeatureModelController::class, 'index']
    )->name(Routerable::MODEL->value)->whereNumber('productId');

    /**
     * Manage Feature Model
     * 
     */
    Route::get(
        '/manage/{featureModelId}',
        [\HaschaDev\Http\Controllers\Product\FeatureModelController::class, 'manage']
    )->name(Routerable::MODEL_MANAGE->value)->whereNumber('productId')->whereNumber('featureModelId');

});

/**
 * FEATURE
 * -----------------------------------
 * FeatureController@
 * 
 */
Route::prefix('/product/{productId}/feature')->middleware([
    'auth'
])->group(function () {

    /**
     * Feature Page
     * 
     */
    Route::get(
        '/',
        [\HaschaDev\Http\Controllers\Product\FeatureController::class, 'index']
    )->name(Routerable::FEATURE->value)->whereNumber('productId');

    /**
     * Create New Feature
     * 
     */
    Route::get(
        '/create/{key}',
        [\HaschaDev\Http\Controllers\Product\FeatureController::class, 'create']
    )->name(Routerable::FEATURE_CREATE->value)->whereNumber('productId');

    /**
     * Manage Feature
     * 
     */
    Route::get(
        '/manage/{featureId}',
        [\HaschaDev\Http\Controllers\Product\FeatureController::class, 'manage']
    )->name(Routerable::FEATURE_MANAGE->value)->whereNumber('productId')->whereNumber('featureId');

});

/**
 * FEATURE RULE (RULES)
 * -----------------------------------
 * FeatureRuleController@
 * 
 */
Route::prefix('/product/{productId}/feature-rule')->middleware([
    'auth'
])->group(function () {

    /**
     * Feature Rule Page
     * 
     */
    Route::get(
        '/',
        [\HaschaDev\Http\Controllers\Product\FeatureRuleController::class, 'index']
    )->name(Routerable::RULE->value)->whereNumber('productId');

    /**
     * Create New Feature Rule
     * 
     */
    Route::get(
        '/create/{key}',
        [\HaschaDev\Http\Controllers\Product\FeatureRuleController::class, 'create']
    )->name(Routerable::RULE_CREATE->value)->whereNumber('productId');

    /**
     * Manage Feature Rule
     * 
     */
    Route::get(
        '/manage/{ruleId}',
        [\HaschaDev\Http\Controllers\Product\FeatureRuleController::class, 'manage']
    )->name(Routerable::RULE_MANAGE->value)->whereNumber('productId')->whereNumber('ruleId');

});

/**
 * SERVICE
 * -----------------------------------
 * ServiceController@
 * 
 */
Route::prefix('/product/{productId}/service')->middleware([
    'auth'
])->group(function () {

    /**
     * Create New Service
     * 
     */
    Route::get(
        '/create/{key}',
        [\HaschaDev\Http\Controllers\Product\ServiceController::class, 'create']
    )->name(Routerable::SERVICE_CREATE->value)->whereNumber('productId');

    /**
     * Manage Service
     * 
     */
    Route::get(
        '/manage/{serviceId}',
        [\HaschaDev\Http\Controllers\Product\ServiceController::class, 'manage']
    )->name(Routerable::SERVICE_MANAGE->value)->whereNumber('productId')->whereNumber('serviceId');

});

/**
 * PAGE SERVICE
 * -----------------------------------
 * PageServiceController@
 * 
 */
Route::prefix('/product/{productId}/service/page-service/{serviceId}')->middleware([
    'auth'
])->group(function () {

    /**
     * Create New Page Service
     * 
     */
    Route::get(
        '/create/{key}',
        [\HaschaDev\Http\Controllers\Product\PageServiceController::class, 'create']
    )->name(Routerable::SERVICE_PAGE_CREATE->value)->whereNumber('productId')->whereNumber('serviceId');

    /**
     * Manage Page Service
     * 
     */
    Route::get(
        '/manage/{pageServiceId}',
        [\HaschaDev\Http\Controllers\Product\PageServiceController::class, 'manage']
    )->name(Routerable::SERVICE_PAGE_MANAGE->value)->whereNumber('productId')->whereNumber('serviceId')->whereNumber('pageServiceId');

});

/**
 * PAGE FEATURE
 * -----------------------------------
 * PageFeatureController@
 * 
 */
Route::prefix('/product/{productId}/service/page-feature/{pageServiceId}')->middleware([
    'auth'
])->group(function () {

    /**
     * Create New Page Feature
     * 
     */
    Route::get(
        '/create/{key}',
        [\HaschaDev\Http\Controllers\Product\PageFeatureController::class, 'create']
    )->name(Routerable::SERVICE_PAGE_FEATURE_CREATE->value)->whereNumber('productId')->whereNumber('pageServiceId');

    /**
     * Manage Page Feature
     * 
     */
    Route::get(
        '/manage/{pageFeatureId}',
        [\HaschaDev\Http\Controllers\Product\PageFeatureController::class, 'manage']
    )->name(Routerable::SERVICE_PAGE_FEATURE_MANAGE->value)->whereNumber('productId')->whereNumber('pageServiceId')->whereNumber('pageFeatureId');

});

/**
 * PACKAGE
 * -----------------------------------
 * PackageController@
 * 
 */
Route::prefix('/product/{productId}/service-package')->middleware([
    'auth'
])->group(function () {

    /**
     * Service Package Page
     * 
     */
    Route::get(
        '/',
        [\HaschaDev\Http\Controllers\Product\PackageController::class, 'index']
    )->name(Routerable::PACKAGE->value)->whereNumber('productId');

    /**
     * Create New Service Package
     * 
     */
    Route::get(
        '/create/{serviceId}',
        [\HaschaDev\Http\Controllers\Product\PackageController::class, 'create']
    )->name(Routerable::PACKAGE_CREATE->value)->whereNumber('productId')->whereNumber('serviceId');

    /**
     * Manage Service Package
     * 
     */
    Route::get(
        '/manage/{packageId}',
        [\HaschaDev\Http\Controllers\Product\PackageController::class, 'manage']
    )->name(Routerable::PACKAGE_MANAGE->value)->whereNumber('productId')->whereNumber('packageId');

});

/**
 * HUB INTEGRATION
 * -----------------------------------
 * IntegrationController@
 * 
 */
Route::prefix('/integration')->middleware([
    'auth'
])->group(function () {

    /**
     * Product Index
     * 
     */
    Route::get(
        '/',
        [\HaschaDev\Http\Controllers\Integration\IntegrationController::class, 'index']
    )->name(Routerable::INTEGRATION->value);

});
