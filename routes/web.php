<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataAnakController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\DataDiagnosisController;
use App\Http\Controllers\JadwalPosyanduController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CategoryMakananController;
use App\Http\Controllers\MenuMakananController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\CategoryArticleController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryGaleriController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\DistribusiBantuanController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\Ortu\DataBalitaController;
use App\Http\Controllers\RekapBulananController;
use App\Http\Controllers\RekapStuntingController;






Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/menu/{slug}', [HomeController::class, 'show'])->name('menu.show');
Route::get('/articld/{slug}', [HomeController::class, 'showberita'])->name('article.show');


// Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-proses', [AuthController::class, 'login_proses'])->name('login-proses');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Register
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register-proses', [AuthController::class, 'register_proses'])->name('register-proses');

// Lupa Password
Route::get('/forgot-password', [AuthController::class, 'forgot_password'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgot_password_act'])->name('forgot-password-act');

// Validasi Token Reset Password
Route::get('/reset-password/{token}', [AuthController::class, 'validasi_forgot_password'])->name('reset-password');
Route::post('/reset-password', [AuthController::class, 'validasi_forgot_password_act'])->name('reset-password-act');


Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin.'], function() {

Route::resource('users', UsersController::class)->names([
    'index' => 'UsersIndex',
    'create' => 'UsersCreate',
    'store' => 'UsersStore',
    'show' => 'UsersShow',  
    'edit' => 'UsersEdit',
    'update' => 'UsersUpdate',
    'destroy' => 'UsersDelete',
]);
    // Rute untuk dasboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //data balita
    Route::resource('databalita', DataAnakController::class)->names([
        'index' => 'DataAnakIndex',
        'create' => 'DataAnakCreate',
        'store' => 'DataAnakStore',
        'show' => 'DataAnakShow',  
        'edit' => 'DataAnakEdit',
        'update' => 'DataAnakUpdate',
        'destroy' => 'DataAnakDelete',
    ]);

    //diagnosis stunting
    Route::resource('rekomendasi', RekomendasiController::class)->names([
        'index' => 'RekomendasiIndex',
        'create' => 'RekomendasiCreate',
        'store' => 'RekomendasiStore',
        'show' => 'RekomendasiShow',  
        'edit' => 'RekomendasiEdit',
        'update' => 'RekomendasiUpdate',
        'destroy' => 'RekomendasisDelete',
        
    ]);

    //data diagnosis 
    Route::resource('datadiagnosis', DataDiagnosisController::class)->names([
        'index' => 'DataDiagnosisIndex',
        'create' => 'DataDiagnosisCreate',
        'store' => 'DataDiagnosisStore',
        'show' => 'DataDiagnosisShow',  
        'edit' => 'DataDiagnosisEdit',
        'update' => 'DataDiagnosisUpdate',
        'destroy' => 'DataDiagnosisDelete',
    ]);
    
      // rekap bulanan
      Route::post('/bidan/diagnosis/acc/{id}', [DataDiagnosisController::class, 'accDiagnosis'])->name('DataDiagnosisAcc');
      Route::get('/bidan/rekap-bulanan', [RekapBulananController::class, 'index'])->name('rekapBulananIndex');
      //rekap stunting
      Route::get('/rekap', [RekapStuntingController::class, 'index'])->name('RekapStuntingIndex');   
      Route::get('/rekap/{id}/edit', [RekapStuntingController::class, 'edit'])->name('RekapStuntingEdit');
      Route::put('/rekap-stunting/{id}', [RekapStuntingController::class, 'update'])->name('RekapStuntingUpdate');


    Route::get('/rekap-pertumbuhananak', [DataDiagnosisController::class, 'pertumbuhananak'])->name('pertumbuhananak');



    // fontee
    Route::post('/kirim-wa-fonnte/{diagnosisId}', [DataDiagnosisController::class, 'kirimPesanWA'])->name('diagnosis.kirimWA');




    Route::resource('distribusi_bantuan', DistribusiBantuanController::class)->names([
        'index' => 'DistribusiBantuanIndex',
        // 'create' => 'DistribusiBantuanCreate',
        'store' => 'DistribusiBantuanStore',
         'show' => 'DistribusiBantuanShow',  
        'edit' => 'DistribusiBantuanEdit',
        'update' => 'DistribusiBantuanUpdate',
        'destroy' => 'DistribusiBantuanDelete',
    ]);

    // Route::get('distribusi_bantuan/{diagnosis_id}', [DistribusiBantuanController::class, 'showw'])->name('DistribusiBantuanShow');
    Route::get('distribusi_bantuan/create/{id}', [DistribusiBantuanController::class, 'create'])->name('DistribusiBantuanCreate');


    // landing page
        // Rute untuk header
        Route::get('/header', [HeaderController::class, 'index'])->name('header');
        Route::put('/header/{id}', [HeaderController::class, 'update'])->name('headerupdate');

        // Rute untuk jadwal posyandu
        Route::get('/jadwalposyandu', [JadwalPosyanduController::class, 'index'])->name('jadwalposyandu');
        Route::get('/jadwalposyandu/{id}/edit', [JadwalPosyanduController::class, 'edit'])->name('jadwalposyanduedit');
        Route::put('/jadwalposyandu/{id}', [JadwalPosyanduController::class, 'update'])->name('jadwalposyanduupdate');

         // Rute about
         Route::get('/about', [AboutController::class, 'index'])->name('about');
         Route::put('/about/{id}', [AboutController::class, 'update'])->name('aboutupdate');

         

            Route::resource('categorymakanan', CategoryMakananController::class)->names([
                'indexs' => 'CategoryMakananIndex',
                'create' => 'CategoryMakananCreate',
                'store' => 'CategoryMakananStore', // Gunakan 'store' untuk menyimpan kategori
                'show' => 'CategoryMakananShow',
                'edit' => 'CategoryMakananEdit',
                'update' => 'CategoryMakananUpdate',
                'destroy' => 'CategoryMakananDelete',
            ]);
            
            Route::resource('menumakanan', MenuMakananController::class)->names([
                'index' => 'CategoriMakananIndex',
                'create' => 'MenuMakananCreate',
                'store' => 'MenuMakananStore', // Gunakan 'store' untuk menyimpan menu
                'show' => 'MenuMakananShow',
                'edit' => 'MenuMakananEdit',
                'update' => 'MenuMakananUpdate',
                'destroy' => 'MenuMakananDelete',
            ]);

            //contact
            Route::get('/contact', [ContactController::class, 'index'])->name('contact');
            Route::put('/contact/{id}', [ContactController::class, 'update'])->name('contactupdate');
          
            //sosmed
            Route::resource('sosmed', SocialMediaController::class)->names([
                'index' => 'SosmedIndex',
                'create' => 'SosmedCreate',
                'store' => 'SosmedStore',
                'edit' => 'SosmedEdit',
                'update' => 'SosmedUpdate',
                'destroy' => 'SosmedDelete',
            ]);


            //kategori artikel
            Route::resource('categoryarticle', CategoryArticleController::class)->names([
                'index' => 'CategoryArticleIndex',
                'create' => 'CategoryArticleCreate',
                'store' => 'CategoryArticleStore',
                'show' => 'CategoryArticleShow',
                'edit' => 'CategoryArticleEdit',
                'update' => 'CategoryArticleUpdate',
                'destroy' => 'CategoryArticleDelete',
            ]);

            Route::resource('article', ArticleController::class)->names([
                'index' => 'ArticleIndex',
                'create' => 'ArticleCreate',
                'store' => 'ArticleStore',
                'show' => 'ArticleShow',
                'edit' => 'ArticleEdit',
                'update' => 'ArticleUpdate',
                // 'destroy' => 'ArticleDelete',
            ]);
            Route::delete('/admin/article/{id}', [ArticleController::class, 'destroy'])->name('ArticleDelete');


            //kategori galeri
         Route::resource('categorygaleri', CategoryGaleriController::class)->names([
            'index' => 'CategoryGaleriIndex',
            'create' => 'CategoryGaleriCreate',
            'store' => 'CategoryGaleriStore',
            'show' => 'CategoryGaleri.show', 
            'edit' => 'CategoryGaleriEdit',
            'update' => 'CategoryGaleriUpdate',
            'destroy' => 'CategoryGaleriDelete',
            ]); 

            Route::resource('galeri', GaleriController::class)->names([
                'index' => 'GaleriIndex',
                'create' => 'GaleriCreate',
                'store' => 'GaleriStore',
                'show' => 'GaleriShow',
                'edit' => 'GaleriEdit',
                'update' => 'GaleriUpdate',
                'destroy' => 'GaleriDelete',
            ]);
            

});



Route::group(['prefix' => 'ortu', 'middleware' => ['auth'], 'as' => 'ortu.'], function() {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('databalita', DataBalitaController::class)->names([
        'index' => 'DataAnakIndex',
        'create' => 'DataAnakCreate',
        'store' => 'DataAnakStore',
        'show' => 'DataAnakShow',  
        'edit' => 'DataAnakEdit',
        'update' => 'DataAnakUpdate',
        'destroy' => 'DataAnakDelete',
    ]);

    Route::get('/rekap-pertumbuhananak', [DataDiagnosisController::class, 'pertumbuhananak'])->name('pertumbuhananak');


});


Route::group(['prefix' => 'bidan', 'middleware' => ['auth'], 'as' => 'bidan.'], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UsersController::class)->names([
        'index' => 'UsersIndex',
        'create' => 'UsersCreate',
        'store' => 'UsersStore',
        'show' => 'Users.show',
        'edit' => 'UsersEdit',
        'update' => 'UsersUpdate',
        'destroy' => 'UsersDelete',
    ]);

    //data balita
    Route::resource('databalita', DataAnakController::class)->names([
        'index' => 'DataAnakIndex',
        'create' => 'DataAnakCreate',
        'store' => 'DataAnakStore',
        'show' => 'DataAnakShow',  
        'edit' => 'DataAnakEdit',
        'update' => 'DataAnakUpdate',
        'destroy' => 'DataAnakDelete',
    ]);

    //data diagnosis 
    Route::resource('datadiagnosis', DataDiagnosisController::class)->names([
        'index' => 'DataDiagnosisIndex',
        'create' => 'DataDiagnosisCreate',
        'store' => 'DataDiagnosisStore',
        'show' => 'DataDiagnosisShow',  
        'edit' => 'DataDiagnosisEdit',
        'update' => 'DataDiagnosisUpdate',
        'destroy' => 'DataDiagnosisDelete',
    ]);
    // rekap bulanan
    Route::post('/bidan/diagnosis/acc/{id}', [DataDiagnosisController::class, 'accDiagnosis'])->name('DataDiagnosisAcc');
    Route::get('/bidan/rekap-bulanan', [RekapBulananController::class, 'index'])->name('rekapBulananIndex');
    Route::get('/bidan/rekap/{id}', [RekapBulananController::class, 'show'])->name('rekap.show');
    Route::get('/rekap-bulanan/print/{tanggal}', [RekapBulananController::class, 'print'])->name('rekap.print');

    //rekap stunting
    Route::get('/bidan/rekap', [RekapStuntingController::class, 'index'])->name('RekapStuntingIndex');   
    Route::get('/bidan/rekap/{id}/edit', [RekapStuntingController::class, 'edit'])->name('RekapStuntingEdit');
    Route::put('/rekap-stunting/{id}', [RekapStuntingController::class, 'update'])->name('RekapStuntingUpdate');
    Route::get('/rekap-stunting/cetak-bulan', [RekapStuntingController::class, 'cetakBulan'])->name('RekapStuntingCetakBulan');
    Route::get('/rekap-stunting/cetak-tahun', [RekapStuntingController::class, 'cetakTahun'])->name('RekapStuntingCetakTahun');



    


});



Route::group(['prefix' => 'kader', 'middleware' => ['auth'], 'as' => 'kader.'], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //data balita
    Route::resource('databalita', DataAnakController::class)->names([
        'index' => 'DataAnakIndex',
        'create' => 'DataAnakCreate',
        'store' => 'DataAnakStore',
        'show' => 'DataAnakShow',  
        'edit' => 'DataAnakEdit',
        'update' => 'DataAnakUpdate',
        'destroy' => 'DataAnakDelete',
    ]);
});







