<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\manageuserController;
use App\Http\Controllers\manageadminController;
use App\Http\Controllers\mainadminController;
use App\Http\Controllers\rencanakegiatanController;
use App\Http\Controllers\jeniskegiatanController;
use App\Http\Controllers\surveiyorController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\PelaksanaanController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', function () {
    return view(
        'utama',
        ["title" => "Selamat Datang"]
    );
});

//Auth
Route::get('/login', [loginController::class, 'loginfrontend']);
Route::post('/postlogin', [loginController::class, 'postlogin']);

Route::get('example', 'ExampleController@getExample');
Route::post('example', 'ExampleController@postExample');

Route::get('/reload-captcha', [loginController::class, 'reloadCaptcha']);
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
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// Route::get('forget-password', [ForgotPasswordController::class, 'ForgetPassword'])->name('ForgetPasswordGet');
// Route::post('forget-password', [ForgotPasswordController::class, 'ForgetPasswordStore'])->name('ForgetPasswordPost');
// Route::get('reset-password/{token}', [ForgotPasswordController::class, 'ResetPassword'])->name('ResetPasswordGet');
// Route::post('reset-password', [ForgotPasswordController::class, 'ResetPasswordStore'])->name('ResetPasswordPost');

Route::get('/register', [RegisterController::class, 'register']);
Route::post('/register', [RegisterController::class, 'buat'])->name('register-user');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('pelaksanaan', PelaksanaanController::class);
    Route::post('pelaksanaan/export', [PelaksanaanController::class, 'export']);
    Route::post('pelaksanaan/{id}/removeFile', [PelaksanaanController::class, 'removeFile'])->name('pelaksanaan.removefile');
    Route::post('pelaksanaan/{id}/addFile', [PelaksanaanController::class, 'addFile'])->name('pelaksanaan.addfile');

    Route::resource('jeniskegiatan', jeniskegiatanController::class);

    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::group(['middleware' => ['auth', 'hakakses:mainadmin']], function () {
    //Main Admin
    Route::get('/homemainadmin', [mainadminController::class, 'homemainadminfrontend']);
    Route::get('/datamastermainadmin', [mainadminController::class, 'datamasterfrontend']);
    Route::get('/datamastermainadmin/export', [mainadminController::class, 'datamasterexport']);
    Route::get('/pelaksanaanmainadmin', [mainadminController::class, 'pelaksanaanfrontend']);
    Route::get('/rencanakegiatanmainadmin', [mainadminController::class, 'rencanakegiatanfrontend'])->name('mainadmin.rencanakegiatan');
    Route::post('/rencanakegiatanmainadmin/create', [mainadminController::class, 'create']);
    Route::post('/rencanakegiatanmainadmin/delete', [mainadminController::class, 'delete'])->name('mainadmin.rencanakegiatan.delete');
    Route::get('/rencanakegiatanmainadmin/{id}', [mainadminController::class, 'detail'])->name('mainadmin.rencanakegiatan.detail');
    Route::post('/rencanakegiatanmainadmin/update', [mainadminController::class, 'update'])->name('mainadmin.rencanakegiatan.update');
    Route::post('/rencanakegiatanmainadmin/{id}/files/add', [mainadminController::class, 'addFile'])->name('mainadmin.rencanakegiatan.addfile');
    Route::post('/rencanakegiatanmainadmin/{id}/files/remove', [mainadminController::class, 'removeFile'])->name('mainadmin.rencanakegiatan.removefile');
    Route::get('/profilmainadmin', [mainadminController::class, 'profilfrontend']);
    Route::get('/editprofilmainadmin', [mainadminController::class, 'editprofilfrontend']);
    Route::get('/ubahpasswordmainadmin', [mainadminController::class, 'ubahpasswordfrontend'])->name('mainadmin.changepassword');
    Route::post('/ubahpasswordmainadmin', [mainadminController::class, 'changePassword'])->name('mainadmin.changepassword.submit');
    //managausermainadmin
    // Route::resource('/datauser', manageuserController::class);
    Route::get('mainadmin/users', [manageuserController::class, 'index'])->name('manage-user');
    Route::post('mainadmin/users/import', [manageuserController::class, 'import'])->name('import-user');
    Route::get('mainadmin/users/export', [manageuserController::class, 'export'])->name('export-user');
    Route::post('mainadmin/users/store', [manageuserController::class, 'store'])->name('store-user'); #insert
    Route::patch('mainadmin/users/update/{id}', [mainadminController::class, 'updateuser'])->name('update-user');
    Route::delete('mainadmin/users/delete/{id}', [mainadminController::class, 'destroyuser'])->name('delete-user');
    //manageadminmainadmin
    Route::resource('/dataadmin', manageadminController::class);
    Route::get('/manageadminmainadmin', [manageadminController::class, 'index'])->name('manage-admin');
    Route::get('/tambahdataadmin', [manageadminController::class, 'show']); #insert
    Route::post('/admintambah', [mainadminController::class, 'store']);
    Route::patch('dataadmin/update/{id}', [mainadminController::class, 'updateadmin'])->name('update-admin');
    Route::delete('dataadmin/delete/{id}', [mainadminController::class, 'destroyadmin'])->name('delete-admin');
});

Route::group(['middleware' => ['auth', 'hakakses:admin']], function () {
    //Admin
    Route::get('/homeadmin', [adminController::class, 'homeadminfrontend']);
    Route::get('/datamasteradmin', [adminController::class, 'datamasterfrontend']);
    Route::get('/datamasteradmin/export', [adminController::class, 'datamasterexport']);
    Route::get('/pelaksanaanadmin', [adminController::class, 'pelaksanaanfrontend']);

    Route::get('/rencanakegiatanadmin', [adminController::class, 'rencanakegiatanfrontend'])->name('admin.rencanakegiatan');
    Route::post('/rencanakegiatanadmin/create', [adminController::class, 'rencanakegiatancreate'])->name('admin.rencanakegiatan.create');
    Route::post('/rencanakegiatanadmin/delete', [adminController::class, 'rencanakegiatandelete'])->name('admin.rencanakegiatan.delete');
    Route::get('/rencanakegiatanadmin/{id}', [adminController::class, 'rencanakegiatandetail'])->name('admin.rencanakegiatan.detail');
    Route::post('/rencanakegiatanadmin/update', [adminController::class, 'rencanakegiatanupdate'])->name('admin.rencanakegiatan.update');
    Route::post('/rencanakegiatanadmin/{id}/files/add', [adminController::class, 'rencanakegiatanaddFile'])->name('admin.rencanakegiatan.addfile');
    Route::post('/rencanakegiatanadmin/{id}/files/remove', [adminController::class, 'rencanakegiatanremoveFile'])->name('admin.rencanakegiatan.removefile');

    Route::get('admin/users', [manageuserController::class, 'index2'])->name('manage-user-admin');
    Route::post('admin/users/import', [manageuserController::class, 'import'])->name('import-user-admin');
    Route::get('admin/users/export', [manageuserController::class, 'export'])->name('export-user-admin');
    // Route::get('/manageuseradmin', [adminController::class, 'manageuserfrontend']);
    Route::get('/profiladmin', [adminController::class, 'profilfrontend']);
    Route::get('/editprofiladmin', [adminController::class, 'editprofilfrontend']);
    Route::get('/ubahpasswordadmin', [adminController::class, 'ubahpasswordfrontend'])->name('admin.changepassword');
    Route::post('/ubahpasswordadmin', [adminController::class, 'changePassword'])->name('admin.changepassword.submit');
});

Route::group(['middleware' => ['auth', 'hakakses:user']], function () {
    //User
    Route::get('/home', [userController::class, 'homeuserfrontend']);
    Route::get('/datamasteruser', [userController::class, 'datamasterfrontend']);
    Route::get('/datamasteruser/export', [userController::class, 'datamasterexport']);
    Route::get('/pelaksanaanuser', [userController::class, 'pelaksanaanfrontend']);
    Route::get('/rencanakegiatanuser', [userController::class, 'rencanakegiatanfrontend']);
    Route::post('/rencanakegiatanuser/create', [userController::class, 'rencanakegiatancreate']);
    Route::get('/profiluser', [userController::class, 'profilfrontend']);
    Route::get('/editprofiluser', [userController::class, 'editprofilfrontend']);
    Route::get('/ubahpassworduser', [userController::class, 'ubahpasswordfrontend'])->name('user.changepassword');
    Route::post('/ubahpassworduser', [userController::class, 'changePassword'])->name('user.changepassword.submit');
});

Route::group(['middleware' => ['auth', 'hakakses:user,admin']], function () {
    //manageuseradmin
    Route::resource('/datauseradmin', adminController::class);
    Route::get('/manageuseradmin', [adminController::class, 'index'])->name('manageuseradmin');
    Route::get('/tambahdatauseradmin', [adminController::class, 'show']); #insert
    Route::post('/usertambahadmin', [adminController::class, 'store']);
    Route::patch('datauseradmin/update/{id}', [mainadminController::class, 'updateuseradmin'])->name('updateuseradmin');
    Route::delete('datauseradmin/delete/{id}', [mainadminController::class, 'destroyuseradmin'])->name('deleteuseradmin');

    // Route::resource('/rencanakegiatan', rencanakegiatanController::class);

    Route::get('/rencanakegiatanuser', [userController::class, 'rencanakegiatanfrontend'])->name('user.rencanakegiatan');
    Route::post('/rencanakegiatanuser/create', [userController::class, 'rencanakegiatancreate'])->name('user.rencanakegiatan.create');
    Route::post('/rencanakegiatanuser/delete', [userController::class, 'rencanakegiatandelete'])->name('user.rencanakegiatan.delete');
    Route::get('/rencanakegiatanuser/{id}', [userController::class, 'rencanakegiatandetail'])->name('user.rencanakegiatan.detail');
    Route::post('/rencanakegiatanuser/update', [userController::class, 'rencanakegiatanupdate'])->name('user.rencanakegiatan.update');
    Route::post('/rencanakegiatanuser/{id}/files/add', [userController::class, 'rencanakegiatanaddFile'])->name('user.rencanakegiatan.addfile');
    Route::post('/rencanakegiatanuser/{id}/files/remove', [userController::class, 'rencanakegiatanremoveFile'])->name('user.rencanakegiatan.removefile');

    Route::get('/managerencanakegiatan', [rencanakegiatanController::class, 'index'])->name('rencanakegiatanmain');
    Route::get('/tambahrencanakegiatan', [rencanakegiatanController::class, 'show']); #insert
});

Route::group(['middleware' => ['auth', 'hakakses:user,surveiyor']], function () {
    //surveiyor
    Route::get('/homesyor', [surveiyorController::class, 'homefrontend']);
    Route::get('/datamastersyor', [surveiyorController::class, 'datamasterfrontend']);
    Route::get('/datamastersyor/export', [surveiyorController::class, 'datamasterexport']);
    Route::get('/pelaksanaansyor', [surveiyorController::class, 'pelaksanaanfrontend']);
    // Route::get('/rencanakegiatansyor', [surveiyorController::class, 'rencanakegiatanfrontend']);

    Route::get('/rencanakegiatansyor', [surveiyorController::class, 'rencanakegiatanfrontend'])->name('surveiyor.rencanakegiatan');
    Route::post('/rencanakegiatansyor/create', [surveiyorController::class, 'rencanakegiatancreate'])->name('surveiyor.rencanakegiatan.create');
    Route::post('/rencanakegiatansyor/delete', [surveiyorController::class, 'rencanakegiatandelete'])->name('surveiyor.rencanakegiatan.delete');
    Route::get('/rencanakegiatansyor/{id}', [surveiyorController::class, 'rencanakegiatandetail'])->name('surveiyor.rencanakegiatan.detail');
    Route::post('/rencanakegiatansyor/update', [surveiyorController::class, 'rencanakegiatanupdate'])->name('surveiyor.rencanakegiatan.update');
    Route::post('/rencanakegiatansyor/{id}/files/add', [surveiyorController::class, 'rencanakegiatanaddFile'])->name('surveiyor.rencanakegiatan.addfile');
    Route::post('/rencanakegiatansyor/{id}/files/remove', [surveiyorController::class, 'rencanakegiatanremoveFile'])->name('surveiyor.rencanakegiatan.removefile');

    Route::get('/profilsyor', [surveiyorController::class, 'profilfrontend']);
    Route::get('/editprofilsyor', [surveiyorController::class, 'editprofilfrontend']);
    Route::get('/ubahpasswordsyor', [surveiyorController::class, 'ubahpasswordfrontend'])->name('surveiyor.changepassword');
    Route::post('/ubahpasswordsyor', [surveiyorController::class, 'changePassword'])->name('surveiyor.changepassword.submit');
});
