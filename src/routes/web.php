<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminMediaController;
use App\Http\Controllers\AdminQuestionController;
use App\Http\Controllers\AdminQuizController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/website', [WebsiteController::class, 'index'])->name('website.index');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->whereNumber('quiz')->name('quizzes.show');
Route::get('/media', [PostController::class, 'index'])->name('media.index');
Route::get('/media/admin/login', [AdminMediaController::class, 'create'])->name('media.admin.login');
Route::post('/media/admin/login', [AdminMediaController::class, 'store'])->name('media.admin.store');
Route::get('/media/admin', [AdminMediaController::class, 'index'])->middleware('media.admin')->name('media.admin.index');
Route::get('/media/admin/users', [AdminMediaController::class, 'users'])->middleware('media.admin')->name('media.admin.users');
Route::delete('/media/admin/users/{user}', [AdminMediaController::class, 'destroyUser'])->middleware('media.admin')->whereNumber('user')->name('media.admin.users.destroy');
Route::get('/media/{post}', [PostController::class, 'show'])->whereNumber('post')->name('media.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/quizzes', [AdminQuizController::class, 'index'])->name('admin.quizzes.index');
    Route::get('/admin/quizzes/create', [AdminQuizController::class, 'create'])->name('admin.quizzes.create');
    Route::post('/admin/quizzes', [AdminQuizController::class, 'store'])->name('admin.quizzes.store');
    Route::delete('/admin/quizzes/{quiz}', [AdminQuizController::class, 'destroy'])->whereNumber('quiz')->name('admin.quizzes.destroy');
    Route::get('/admin/quizzes/{quiz}/questions', [AdminQuizController::class, 'questions'])->whereNumber('quiz')->name('admin.quizzes.questions');
    Route::get('/admin/quizzes/{quiz}/edit', [AdminQuizController::class, 'edit'])->whereNumber('quiz')->name('admin.quizzes.edit');
    Route::put('/admin/quizzes/{quiz}', [AdminQuizController::class, 'update'])->whereNumber('quiz')->name('admin.quizzes.update');
    Route::get('/admin/questions', [AdminQuestionController::class, 'index'])->name('admin.questions.index');
    Route::get('/admin/questions/create', [AdminQuestionController::class, 'create'])->name('admin.questions.create');
    Route::post('/admin/questions', [AdminQuestionController::class, 'store'])->name('admin.questions.store');
    Route::get('/admin/questions/{question}/edit', [AdminQuestionController::class, 'edit'])->whereNumber('question')->name('admin.questions.edit');
    Route::put('/admin/questions/{question}', [AdminQuestionController::class, 'update'])->whereNumber('question')->name('admin.questions.update');
    Route::delete('/admin/questions/{question}', [AdminQuestionController::class, 'destroy'])->whereNumber('question')->name('admin.questions.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/media/create', [PostController::class, 'create'])->name('media.create');
    Route::post('/media/draft', [PostController::class, 'draft'])->name('media.draft');
    Route::post('/media', [PostController::class, 'store'])->name('media.store');
    Route::get('/media/{post}/edit', [PostController::class, 'edit'])->whereNumber('post')->name('media.edit');
    Route::put('/media/{post}', [PostController::class, 'update'])->whereNumber('post')->name('media.update');
    Route::delete('/media/{post}', [PostController::class, 'destroy'])->whereNumber('post')->name('media.destroy');
    Route::post('/media/{post}/comments', [CommentController::class, 'store'])->whereNumber('post')->name('media.comments.store');
    Route::get('/media/comments/{comment}/edit', [CommentController::class, 'edit'])->whereNumber('comment')->name('media.comments.edit');
    Route::put('/media/comments/{comment}', [CommentController::class, 'update'])->whereNumber('comment')->name('media.comments.update');
    Route::delete('/media/comments/{comment}', [CommentController::class, 'destroy'])->whereNumber('comment')->name('media.comments.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
