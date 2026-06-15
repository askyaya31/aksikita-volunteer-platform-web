<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Public\EventController as PublicEventController;
use App\Http\Controllers\Api\Public\CategoryController as PublicCategoryController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\Admin\OrganizationController as AdminOrgController;
use App\Http\Controllers\Api\Admin\EventReviewController;
use App\Http\Controllers\Api\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Api\Admin\StatisticsController as StatisticsController;
use App\Http\Controllers\Api\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Api\Organization\ProfileController as OrgProfileController;
use App\Http\Controllers\Api\Organization\EventController as OrgEventController;
use App\Http\Controllers\Api\Organization\RegistrationController as OrgRegistrationController;
use App\Http\Controllers\Api\Organization\NotificationController as OrgNotificationController;
use App\Http\Controllers\Api\Volunteer\ProfileController as VolProfileController;
use App\Http\Controllers\Api\Volunteer\EventController as VolEventController;
use App\Http\Controllers\Api\Volunteer\RegistrationController as VolRegistrationController;
use App\Http\Controllers\Api\Volunteer\NotificationController as VolNotificationController;
use App\Http\Controllers\Api\Volunteer\SavedEventController;
use App\Http\Controllers\Api\Volunteer\LikedEventController;
use App\Http\Controllers\Api\Auth\GoogleAuthController;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register/volunteer',    [AuthController::class, 'registerVolunteer']);
        Route::post('register/organization', [AuthController::class, 'registerOrganization']);
        Route::post('login',                 [AuthController::class, 'login']);
        Route::post('google',                [GoogleAuthController::class, 'login']);
    });
    Route::get('events',                   [PublicEventController::class, 'index']);
    Route::get('events/{slug}',            [PublicEventController::class, 'show']);
    Route::get('categories',               [PublicCategoryController::class, 'index']);
    Route::get('categories/{slug}/events', [PublicCategoryController::class, 'events']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('auth/me',     [AuthController::class, 'me']);
        Route::post('reports',    [AdminReportController::class, 'store']);
        Route::prefix('admin')->middleware('role:admin')->group(function () {
            Route::get('dashboard',                        [StatisticsController::class, 'index']);
            Route::get('statistics',                       [StatisticsController::class, 'detailed']);
            Route::get('users',                            [AdminUserController::class, 'index']);
            Route::get('users/{id}',                       [AdminUserController::class, 'show']);
            Route::put('users/{id}/toggle-active',         [AdminUserController::class, 'toggleActive']);
            Route::delete('users/{id}',                    [AdminUserController::class, 'destroy']);
            Route::get('organizations',                    [AdminOrgController::class, 'index']);
            Route::get('organizations/{id}',               [AdminOrgController::class, 'show']);
            Route::put('organizations/{id}/verify',        [AdminOrgController::class, 'verify']);
            Route::get('events',                           [EventReviewController::class, 'index']);
            Route::get('events/{id}',                      [EventReviewController::class, 'show']);
            Route::put('events/{id}/review',               [EventReviewController::class, 'review']);
            Route::get('reports',                          [AdminReportController::class, 'index']);
            Route::get('reports/{id}',                     [AdminReportController::class, 'show']);
            Route::put('reports/{id}/resolve',             [AdminReportController::class, 'resolve']);
            Route::get('notifications',                    [AdminNotificationController::class, 'index']);
            Route::get('notifications/unread-count',       [AdminNotificationController::class, 'unreadCount']);
            Route::put('notifications/{id}/read',          [AdminNotificationController::class, 'markRead']);
            Route::put('notifications/mark-all-read',      [AdminNotificationController::class, 'markAllRead']);
        });

        Route::prefix('organization')->middleware('role:organization')->group(function () {
            Route::get('profile',  [OrgProfileController::class, 'show']);
            Route::put('profile',  [OrgProfileController::class, 'update']);
            Route::get('notifications',               [OrgNotificationController::class, 'index']);
            Route::get('notifications/unread-count',  [OrgNotificationController::class, 'unreadCount']);
            Route::put('notifications/{id}/read',     [OrgNotificationController::class, 'markRead']);
            Route::put('notifications/mark-all-read', [OrgNotificationController::class, 'markAllRead']);

            Route::middleware('organization.verified')->group(function () {
                Route::get('events',              [OrgEventController::class, 'index']);
                Route::post('events',             [OrgEventController::class, 'store']);
                Route::get('events/{id}',         [OrgEventController::class, 'show']);
                Route::put('events/{id}',         [OrgEventController::class, 'update']);
                Route::delete('events/{id}',      [OrgEventController::class, 'destroy']);
                Route::put('events/{id}/submit',  [OrgEventController::class, 'submit']);
                Route::put('events/{id}/complete',[OrgEventController::class, 'complete']);
                Route::put('events/{id}/cancel',  [OrgEventController::class, 'cancel']);
                Route::get('events/{id}/registrations',  [OrgRegistrationController::class, 'index']);
                Route::get('registrations/{id}',         [OrgRegistrationController::class, 'show']);
                Route::put('registrations/{id}/confirm', [OrgRegistrationController::class, 'confirm']);
                Route::put('registrations/{id}/reject',  [OrgRegistrationController::class, 'reject']);
                Route::put('registrations/{id}/attend',  [OrgRegistrationController::class, 'attend']);
            });
        });

        Route::prefix('volunteer')->middleware('role:volunteer')->group(function () {
            Route::get('profile', [VolProfileController::class, 'show']);
            Route::put('profile', [VolProfileController::class, 'update']);
            Route::get('events',        [VolEventController::class, 'index']);
            Route::get('events/{slug}', [VolEventController::class, 'show']);
            Route::post('events/{id}/register', [VolRegistrationController::class, 'store']);
            Route::delete('events/{id}/cancel', [VolRegistrationController::class, 'cancel']);
            Route::get('registrations',         [VolRegistrationController::class, 'index']);
            Route::get('registrations/{id}',    [VolRegistrationController::class, 'show']);
            Route::get('notifications',               [VolNotificationController::class, 'index']);
            Route::get('notifications/unread-count',  [VolNotificationController::class, 'unreadCount']);
            Route::put('notifications/mark-all-read', [VolNotificationController::class, 'markAllRead']);
            Route::put('notifications/{id}/read',     [VolNotificationController::class, 'markRead']);
            Route::get('saved-events',          [SavedEventController::class, 'index']);
            Route::post('events/{id}/save',     [SavedEventController::class, 'toggle']);
            Route::delete('saved-events/{id}',  [SavedEventController::class, 'destroy']);
            Route::get('liked-events',          [LikedEventController::class, 'index']);
            Route::post('events/{id}/like',     [LikedEventController::class, 'toggle']);
        });
    });
});