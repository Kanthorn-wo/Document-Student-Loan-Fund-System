<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBranchController;
use App\Http\Controllers\Admin\AdminExportController;
use App\Http\Controllers\Admin\AdminFacultyController;
use App\Http\Controllers\Admin\AdminFileDocument;
use App\Http\Controllers\Admin\AdminIndexController;
use App\Http\Controllers\Admin\AdminManageUserController;
use App\Http\Controllers\Admin\AdminPrefixController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminSetDateController;
use App\Http\Controllers\Admin\CheckDocumentController;
use App\Http\Controllers\Staff\StaffAuthController;
use App\Http\Controllers\Staff\StaffCheckDocumentController;
use App\Http\Controllers\Staff\StaffDashboradController;
use App\Http\Controllers\Staff\StaffProfileController;
use App\Http\Controllers\User\UserAuthControllerer;
use App\Http\Controllers\User\UserHistoryController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\UserRegisterController;
use App\Http\Controllers\User\UserSendDocumentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('index')->name('index.page');
// });
Route::get('/testsso', function () {
    return view('sso');
});
Route::get('/test-sso', [UserAuthControllerer::class, 'index'])->name('show.dd');
Route::get('/', [UserAuthControllerer::class, 'login'])->name('user.login');

Route::get('/clear', [UserAuthControllerer::class, 'clear'])->name('clear.session');

Route::get('/select', function () {return view('dashboard');})->name('select');
Route::post('/login', [UserAuthControllerer::class, 'handleLogin'])->name('user.handleLogin');
Route::get('/logout', [UserAuthControllerer::class, 'logout'])->name('user.logout');

Route::get('admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'handleLogin'])->name('admin.handleLogin');
Route::get('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::get('staff/login', [StaffAuthController::class, 'login'])->name('staff.login');
Route::post('staff/login', [StaffAuthController::class, 'handleLogin'])->name('staff.handleLogin');
Route::get('staff/logout', [StaffAuthController::class, 'logout'])->name('staff.logout');

Route::get('/register', [UserRegisterController::class, 'index'])->name('register');
Route::post('/get-branch', [UserRegisterController::class, 'getBranch'])->name('get.branch');
Route::post('/register/insert', [UserRegisterController::class, 'store'])->name('register.insert');

Route::middleware('auth:webadmins')->prefix('/admin')->group(function () {
    Route::get('/export/{id}', [AdminExportController::class, 'exportToExcel'])->name('admin.export');
    Route::get('/dashboard', [AdminIndexController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');

    Route::get('/filedocument', [AdminFileDocument::class, 'index'])->name('admin.filledoc.index');
    Route::post('/filedocument', [AdminFileDocument::class, 'store'])->name('admin.filledoc.add');
    Route::post('/filedocument/{id}', [AdminFileDocument::class, 'update'])->name('admin.filledoc.update');
    Route::get('/filedocument/delete/{id}', [AdminFileDocument::class, 'delete'])->name('admin.filledoc.delete');

    Route::get('/filedocument/list', [AdminFileDocument::class, 'fileList'])->name('admin.filledoc');
    Route::get('/filedocument/list/{id}', [AdminFileDocument::class, 'fileList'])->name('admin.filledoc.list');
    Route::get('/filedocument/list/delete/{id}', [AdminFileDocument::class, 'deletelist'])->name('admin.filledoc.list.delete');
    Route::post('/filedocument/list/update/{id}', [AdminFileDocument::class, 'updateDocAdmin'])->name('admin.filledoc.list.update');

    Route::get('/prefix', [AdminPrefixController::class, 'index'])->name('admin.prefix.index');
    Route::post('/prefix', [AdminPrefixController::class, 'store'])->name('admin.prefix.add');
    Route::post('/prefix/{id}', [AdminPrefixController::class, 'update'])->name('admin.prefix.update');
    Route::get('/prefix/delete/{id}', [AdminPrefixController::class, 'delete'])->name('admin.prefix.delete');

    Route::get('/faculty', [AdminFacultyController::class, 'index'])->name('admin.faculty.index');
    Route::post('/faculty', [AdminFacultyController::class, 'store'])->name('admin.faculty.add');
    Route::post('/faculty/{id}', [AdminFacultyController::class, 'update'])->name('admin.faculty.update');
    Route::get('/faculty/delete/{id}', [AdminFacultyController::class, 'delete'])->name('admin.faculty.delete');

    Route::get('/branch', [AdminBranchController::class, 'index'])->name('admin.branch.index');
    Route::post('/branch', [AdminBranchController::class, 'store'])->name('admin.branch.add');
    Route::post('/branch/{id}', [AdminBranchController::class, 'update'])->name('admin.branch.update');
    Route::get('/branch/delete/{id}', [AdminBranchController::class, 'delete'])->name('admin.branch.delete');

    Route::get('/checkdocument/all', [CheckDocumentController::class, 'index'])->name('admin.check.index');
    Route::get('/checkdocument/approve/{id}', [CheckDocumentController::class, 'approve'])->name('admin.check.approve');
    Route::post('/checkdocument/disapproval/{id}', [CheckDocumentController::class, 'disapproval'])->name('admin.check.disapproval');
    Route::post('/checkdocument/backedit/{id}', [CheckDocumentController::class, 'backedit'])->name('admin.check.backedit');
    // Route::get('/checkdocument/search', [CheckDocumentController::class, 'searchList'])->name('admin.search.list');

    Route::get('/checkdocument/list', [CheckDocumentController::class, 'list'])->name('admin.check.approve.list');

    Route::get('/setdate', [AdminSetDateController::class, 'index'])->name('admin.setdate.index');
    Route::post('/setdate', [AdminSetDateController::class, 'checkDate'])->name('admin.setdate.check');
    Route::get('/setdate/{id}', [AdminSetDateController::class, 'active'])->name('admin.setdate.active');
    Route::post('/setdate/update/{id}', [AdminSetDateController::class, 'update'])->name('admin.setdate.update');
    Route::get('/setdate/delete/{id}', [AdminSetDateController::class, 'delete'])->name('admin.setdate.delete');

    Route::get('/manage', [AdminManageUserController::class, 'index'])->name('admin.manage.user.index');
    Route::post('/manage/staff/add', [AdminManageUserController::class, 'addStaff'])->name('admin.addstaff.index');
    Route::post('/manage/staff/update/{id}', [AdminManageUserController::class, 'updateStaff'])->name('admin.updatestaff.index');
    Route::get('/manage/staff/delete/{id}', [AdminManageUserController::class, 'deleteStaff'])->name('admin.deletestaff.index');

    Route::get('/manage/user/list', [AdminManageUserController::class, 'userList'])->name('admin.manage.user.list');
    Route::get('/manage/user/search', [AdminManageUserController::class, 'searchUser'])->name('admin.manage.user.search');
    Route::post('/manage/user/update/{id}', [AdminManageUserController::class, 'updateUser'])->name('admin.updateuser.index');
    Route::get('/manage/user/delete/{id}', [AdminManageUserController::class, 'deleteUser'])->name('admin.deleteuser.index');
    Route::get('/manage/user/mysend/{id}', [AdminManageUserController::class, 'mySend'])->name('admin.mysend');

    Route::post('/fetch-branch', [AdminManageUserController::class, 'fetchBranch'])->name('fetch.branch');

});

Route::middleware('auth:web')->prefix('/user')->group(function () {
// Route::prefix('/user')->group(function () {
    Route::get('/history', [UserHistoryController::class, 'index'])->name('user.senddocument.history');
    Route::post('/history/update/{id}', [UserHistoryController::class, 'updateDocUser'])->name('user.update.back');

    Route::get('/profile', [UserProfileController::class, 'index'])->name('profileUser');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profileUser.update');
    Route::post('/profile-branch', [UserProfileController::class, 'getBranch'])->name('profileUser.branch');
    Route::get('/senddocument', [UserSendDocumentController::class, 'index'])->name('user.senddocument.index');
    Route::get('/senddocument/add/{id}', [UserSendDocumentController::class, 'add'])->name('user.senddocument.add');
    Route::post('/senddocument/add/{id}', [UserSendDocumentController::class, 'store'])->name('user.senddocument.send');
    

});

Route::middleware('auth:webstaffs')->prefix('/staff')->group(function () {

    Route::get('/dashboard', [StaffDashboradController::class, 'index'])->name('staff.dashboard');

    // Route::get('/check', [StaffCheckDocumentController::class, 'index'])->name('staff.check.index');
    Route::get('/check/list', [StaffCheckDocumentController::class, 'index'])->name('staff.check.list');
    Route::get('/check/list/all', [StaffCheckDocumentController::class, 'all'])->name('staff.check.all');
    Route::get('/check/list/approve/{id}', [CheckDocumentController::class, 'approve'])->name('staff.check.approve');
    Route::post('/check/list/disapproval/{id}', [CheckDocumentController::class, 'disapproval'])->name('staff.check.disapproval');

    Route::get('/profile', [StaffProfileController::class, 'index'])->name('staff.profile.index');
    Route::post('/profile/update/{id}', [StaffProfileController::class, 'update'])->name('staff.update');

});