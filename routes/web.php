<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasterRuangController;
use App\Http\Middleware\CekHakAkses;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

$jalankanPhpNative = function (string $file) {
    if (!isset($_SESSION)) {
        $_SESSION = [];
    }
    $_SESSION['auth_user'] = session('auth_user');

    chdir(base_path());
    ob_start();
    require base_path($file);
    $content = ob_get_clean();

    foreach (headers_list() as $header) {
        if (stripos($header, 'Location:') === 0) {
            $target = trim(substr($header, 9));
            header_remove('Location');
            return redirect($target);
        }
    }

    return response($content);
};

Route::middleware([CekHakAkses::class . ':login'])->group(function () use ($jalankanPhpNative) {
    Route::get('/', [MasterRuangController::class, 'index'])->name('home');
    Route::get('/ruang', [MasterRuangController::class, 'index'])->name('ruang.index');
    Route::get('/menu', [MasterRuangController::class, 'dashboard'])->name('ruang.dashboard');
    Route::get('/ruang-dan-fasilitas', [MasterRuangController::class, 'dashboard']);

    Route::get('/masterruang', [MasterRuangController::class, 'index']);
    Route::get('/masterruang.php', [MasterRuangController::class, 'index']);

    Route::match(['get', 'post'], '/nomorgedung.php', fn () => $jalankanPhpNative('nomorgedung.php'))
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
    Route::match(['get', 'post'], '/nomorgedung', fn () => $jalankanPhpNative('nomorgedung.php'))
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);

    Route::match(['get', 'post'], '/fasilitas.php', fn () => $jalankanPhpNative('fasilitas.php'))
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
    Route::match(['get', 'post'], '/fasilitas', fn () => $jalankanPhpNative('fasilitas.php'))
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
});

Route::middleware([CekHakAkses::class . ':admin'])->group(function () {
    Route::get('/ruang/create', [MasterRuangController::class, 'create'])->name('ruang.create');
    Route::post('/ruang', [MasterRuangController::class, 'store'])->name('ruang.store');
    Route::get('/ruang/{id}/edit', [MasterRuangController::class, 'edit'])->name('ruang.edit');
    Route::put('/ruang/{id}', [MasterRuangController::class, 'update'])->name('ruang.update');
    Route::post('/ruang/{id}/update', [MasterRuangController::class, 'update'])->name('ruang.update.post');
    Route::delete('/ruang/{id}', [MasterRuangController::class, 'destroy'])->name('ruang.destroy');
    Route::post('/ruang/{id}/delete', [MasterRuangController::class, 'destroy'])->name('ruang.destroy.post');
    Route::get('/ruang/{id}/delete', [MasterRuangController::class, 'destroy']);

    Route::post('/masterruang.php', [MasterRuangController::class, 'store']);
    Route::get('/tambahruang', [MasterRuangController::class, 'create']);
    Route::get('/tambahruang.php', [MasterRuangController::class, 'create']);
    Route::post('/tambahruang.php', [MasterRuangController::class, 'store']);
});
