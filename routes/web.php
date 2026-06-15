<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\GoogleAuthController;
use App\Http\Controllers\Web\Volunteer\DashboardController as VolDashboard;
use App\Http\Controllers\Web\Volunteer\EventController as VolEvent;
use App\Http\Controllers\Web\Volunteer\RegistrationController as VolRegistration;
use App\Http\Controllers\Web\Volunteer\NotificationController as VolNotification;
use App\Http\Controllers\Web\Volunteer\ProfileController as VolProfile;
use App\Http\Controllers\Web\Organizer\DashboardController as OrgDashboard;
use App\Http\Controllers\Web\Organizer\EventController as OrgEvent;
use App\Http\Controllers\Web\Organizer\ProfileController as OrgProfile;
use App\Http\Controllers\Web\Organizer\NotificationController as OrgNotification;
use App\Http\Controllers\Web\Organizer\VolunteerController as OrgVolunteer;
use App\Http\Controllers\Web\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Web\Admin\UserController as AdminUser;
use App\Http\Controllers\Web\Admin\EventController as AdminEvent;
use App\Http\Controllers\Web\Admin\NotificationController as AdminNotification;
use App\Http\Controllers\Web\Admin\ReportController as AdminReport;
use App\Http\Controllers\Web\Admin\StatisticsController as AdminStatistics;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/events/{slug}', [VolEvent::class, 'showPublic'])->name('events.show');

Route::middleware('guest')->group(function () {
    Route::get('/login',               [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',              [AuthController::class, 'login'])->name('login.post');

    Route::get('/register/volunteer',  [AuthController::class, 'showRegisterVolunteer'])->name('register.volunteer');
    Route::post('/register/volunteer', [AuthController::class, 'registerVolunteer'])->name('register.volunteer.post');

    Route::get('/register/organizer',  [AuthController::class, 'showRegisterOrganizer'])->name('register.organizer');
    Route::post('/register/organizer', [AuthController::class, 'registerOrganizer'])->name('register.organizer.post');

    Route::get('/auth/google',          [GoogleAuthController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});

Route::get('/auth/google/role',  [GoogleAuthController::class, 'showRoleSelection'])->name('auth.google.role');
Route::post('/auth/google/role', [GoogleAuthController::class, 'selectRole'])->name('auth.google.role.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('web.auth');

Route::prefix('admin')->name('admin.')->middleware(['web.auth', 'web.role:admin'])->group(function () {

    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/users',                             [AdminUser::class, 'index'])->name('users');
    Route::post('/users/organizations/{id}/verify',  [AdminUser::class, 'verifyOrganization'])->name('users.verify-organization');
    Route::get('/users/organizations/{userId}',       [AdminUser::class, 'showOrganization'])->name('organizations.show');
    Route::get('/users/volunteers/{userId}',          [AdminUser::class, 'showVolunteer'])->name('volunteers.show');
    Route::patch('/users/{id}/toggle-active',         [AdminUser::class, 'toggleActive'])->name('users.toggle-active');

    Route::get('/events',              [AdminEvent::class, 'index'])->name('events');
    Route::get('/events/{id}',         [AdminEvent::class, 'show'])->name('events.show');
    Route::post('/events/{id}/review', [AdminEvent::class, 'review'])->name('events.review');

    Route::get('/notifications',                    [AdminNotification::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read',         [AdminNotification::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all',          [AdminNotification::class, 'markAllRead'])->name('notifications.readAll');

    Route::get('/reports',                  [AdminReport::class, 'index'])->name('reports');
    Route::get('/reports/{id}',             [AdminReport::class, 'show'])->name('reports.show');
    Route::patch('/reports/{id}/status',    [AdminReport::class, 'updateStatus'])->name('reports.update');

    Route::get('/statistics', [AdminStatistics::class, 'index'])->name('statistics');

});

Route::prefix('volunteer')->name('volunteer.')->middleware(['web.auth', 'web.role:volunteer'])->group(function () {
    Route::get('/dashboard',                [VolDashboard::class, 'index'])->name('dashboard');
    Route::get('/events',                   [VolEvent::class, 'index'])->name('events');
    Route::get('/events/{slug}',            [VolEvent::class, 'show'])->name('events.show');
    Route::get('/registrations',            [VolRegistration::class, 'index'])->name('registrations');
    Route::post('/events/{id}/register',    [VolRegistration::class, 'store'])->name('register');
    Route::post('/events/{id}/cancel',      [VolRegistration::class, 'cancel'])->name('cancel');
    Route::get('/history',                  [VolRegistration::class, 'history'])->name('history');
    Route::get('/saved', [\App\Http\Controllers\Web\Volunteer\SavedEventController::class, 'index'])->name('saved');
    Route::get('/notifications',                [VolNotification::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read',     [VolNotification::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all',      [VolNotification::class, 'markAllRead'])->name('notifications.readAll');
    Route::get('/profile',   [VolProfile::class, 'show'])->name('profile');
    Route::post('/profile',  [VolProfile::class, 'update'])->name('profile.update');

});

Route::prefix('organizer')->name('organizer.')->middleware(['web.auth', 'web.role:organization'])->group(function () {
    Route::get('/dashboard', [OrgDashboard::class, 'index'])->name('dashboard');
    Route::get('/events',                [OrgEvent::class, 'index'])->name('events');
    Route::get('/events/create',         [OrgEvent::class, 'create'])->name('events.create');
    Route::post('/events',               [OrgEvent::class, 'store'])->name('events.store');
    Route::get('/events/{id}',           [OrgEvent::class, 'show'])->name('events.show');
    Route::get('/events/{id}/edit',      [OrgEvent::class, 'edit'])->name('events.edit');
    Route::post('/events/{id}/update',   [OrgEvent::class, 'update'])->name('events.update');
    Route::post('/events/{id}/delete',   [OrgEvent::class, 'destroy'])->name('events.destroy');
    Route::post('/events/{id}/submit',   [OrgEvent::class, 'submit'])->name('events.submit');
    Route::post('/events/{id}/complete', [OrgEvent::class, 'complete'])->name('events.complete');
    Route::post('/registrations/{id}/confirm', [OrgEvent::class, 'confirm'])->name('confirm');
    Route::post('/registrations/{id}/reject',  [OrgEvent::class, 'reject'])->name('reject');
    Route::post('/registrations/{id}/attend',  [OrgEvent::class, 'attend'])->name('attend');
    Route::get('/volunteers/{registrationId}', [OrgVolunteer::class, 'show'])->name('volunteers.show');
    Route::get('/profile',        [OrgProfile::class, 'show'])->name('profile');
    Route::post('/profile',       [OrgProfile::class, 'update'])->name('profile.update');
    Route::get('/notifications',  [OrgNotification::class, 'index'])->name('notifications');
});