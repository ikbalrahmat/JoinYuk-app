<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

// --- Import Controllers ---
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\PresenceDetailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RisalahController;
use App\Http\Controllers\UndanganController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\RapatController;
use App\Http\Controllers\AgendaRapatController;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyQuestionController;
use App\Http\Controllers\SurveyResponseController;
use App\Http\Controllers\KonsumsiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rute Absen Publik
Route::get('absen/{slug}', [AbsenController::class, 'index'])->name('absen.index');
Route::post('absen/save/{id}', [AbsenController::class, 'save'])->name('absen.save');

// Download QR Code (publik)
Route::get('/presence/{slug}/download-qrcode', function ($slug) {
    $url = route('absen.index', $slug);
    $image = QrCode::format('png')->size(300)->generate($url);
    return Response::make($image, 200, [
        'Content-Type' => 'image/png',
        'Content-Disposition' => 'attachment; filename="qrcode.png"'
    ]);
})->name('presence.qrcode.download');

// Route publik untuk isi survey
Route::get('survey/{survey}/isi', [SurveyResponseController::class, 'publicCreate'])->name('survey.public.create');
Route::post('survey/{survey}/isi', [SurveyResponseController::class, 'publicStore'])->name('survey.public.store');


// Rute yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // TAMBAHKAN RUTE PROFIL DI SINI
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::put('password', [PasswordController::class, 'update'])->name('profile.password.update');
    // User Management
    // Route::resource('user', UserController::class);
    Route::resource('users', UserController::class);

    // Undangan
    // Rute untuk ambil data JSON oleh DataTables
    Route::get('/undangan/data', [UndanganController::class, 'getData'])->name('undangan.data');

    // Rute Resource untuk CRUD
    Route::resource('undangan', UndanganController::class);

    // Rute untuk preview dan export PDF
    Route::get('/undangan/{undangan}/preview', [UndanganController::class, 'preview'])->name('undangan.preview');
    Route::get('/undangan/{undangan}/export-pdf', [UndanganController::class, 'exportPdf'])->name('undangan.exportPdf');

    // Presence
    Route::resource('presence', PresenceController::class);

    // Presence Detail
    Route::delete('presence-detail/{id}', [PresenceDetailController::class, 'destroy'])->name('presence-detail.destroy');
    Route::get('presence-detail/export-pdf/{id}', [PresenceDetailController::class, 'exportPdf'])->name('presence-detail.export-pdf');

    // Upload & Delete Bukti Kegiatan
    Route::post('/presence/upload-bukti/{id}', [PresenceController::class, 'uploadBukti'])->name('presence.upload.bukti');
    Route::delete('/presence/delete-bukti/{id}', [PresenceController::class, 'deleteBukti'])->name('presence.delete.bukti');

    // Agenda
    Route::prefix('agenda')->name('agenda.')->controller(AgendaRapatController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{rapat}', 'show')->name('show');
        Route::get('/{rapat}/edit', 'edit')->name('edit');
        Route::put('/{rapat}', 'update')->name('update');
        Route::delete('/{rapat}', 'destroy')->name('destroy');
        Route::get('/{rapat}/export-pdf', 'exportPdf')->name('export-pdf');

        Route::get('/{rapat}/items/create', 'agendaCreate')->name('items.create');
        Route::post('/{rapat}/items', 'agendaStore')->name('items.store');
        Route::get('/{rapat}/items/{agenda}/edit', 'agendaEdit')->name('items.edit');
        Route::put('/{rapat}/items/{agenda}', 'agendaUpdate')->name('items.update');
        Route::delete('/{rapat}/items/{agenda}', 'agendaDestroy')->name('items.destroy');
    });

    // Rapat
    Route::get('/rapat', [RapatController::class, 'index'])->name('rapat.index');
    Route::get('/rapat/zoom', [RapatController::class, 'zoom'])->name('rapat.zoom');
    Route::get('/rapat/gmeet', [RapatController::class, 'gmeet'])->name('rapat.gmeet');

    // Materi
    Route::resource('materi', MateriController::class);
    Route::get('/materi/{materi}/download', [MateriController::class, 'download'])->name('materi.download');

    // Kuis
    Route::get('/kuis', [KuisController::class, 'index'])->name('kuis.index');

    // Survey
    // Route::get('/survey', [SurveyController::class, 'index'])->name('survey.index');
        // Survey
    Route::resource('survey', SurveyController::class);

    // Survey Questions
    Route::prefix('survey')->name('survey.')->group(function () {
        // Pertanyaan per survey
        Route::get('{survey}/questions', [SurveyQuestionController::class, 'index'])->name('questions.index');
        Route::post('{survey}/questions', [SurveyQuestionController::class, 'store'])->name('questions.store');
        Route::delete('survey/questions/{question}', [SurveyQuestionController::class, 'destroy'])->name('questions.destroy');


        // Respon / jawaban survey
        Route::get('{survey}/responses/create', [SurveyResponseController::class, 'create'])->name('responses.create');
        Route::post('{survey}/responses', [SurveyResponseController::class, 'store'])->name('responses.store');
    });


    // Risalah
    Route::get('/risalah', [RisalahController::class, 'index'])->name('risalah.index');
    Route::get('/risalah/create', [RisalahController::class, 'create'])->name('risalah.create');
    Route::post('/risalah', [RisalahController::class, 'store'])->name('risalah.store');
    Route::get('/risalah/{id}/edit', [RisalahController::class, 'edit'])->name('risalah.edit'); // ✅ Edit
    Route::put('/risalah/{id}', [RisalahController::class, 'update'])->name('risalah.update'); // ✅ Update
    Route::delete('/risalah/{id}', [RisalahController::class, 'destroy'])->name('risalah.destroy'); // ✅ Delete
    Route::get('/risalah/{id}/preview', [RisalahController::class, 'preview'])->name('risalah.preview'); // ✅ Preview modal
    Route::get('/risalah/{id}/export', [RisalahController::class, 'export'])->name('risalah.export');




    // Anggaran
    Route::resource('anggaran', AnggaranController::class);
    Route::post('/anggaran/topup/{anggaran}', [AnggaranController::class, 'topup'])->name('anggaran.topup');

    // Konsumsi
    Route::resource('konsumsi', KonsumsiController::class);
    Route::get('/konsumsi/export-pdf/{konsumsi}', [KonsumsiController::class, 'exportPdf'])->name('konsumsi.export.pdf');
});

Auth::routes([
    'register' => false,
    'reset' => true,
]);

Route::get('/run-fix', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('migrate', ['--force' => true]);
    return 'All clear + migrate success!';
});
