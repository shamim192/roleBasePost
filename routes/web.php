<?php

use App\Http\Controllers\HomeController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[HomeController::class,'index']);

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $posts = Post::where('user_id', auth()->id())->get();
        $postsForReview = Post::where('status', 'pending_review')->get();
        return view('dashboard',compact('posts','postsForReview'));
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post routes
    Route::resource('posts', PostController::class);
    Route::post('posts/{post}/submit-for-review', [PostController::class,'submitForReview'])->name('posts.submitForReview');    
    Route::match(['get', 'post'], 'posts/{post}/review', [PostController::class,'review'])->name('posts.review');
    Route::post('posts/{post}/approve',[PostController::class,'approve'])->name('posts.approve');
    Route::post('posts/{post}/reject', [PostController::class,'reject'])->name('posts.reject');
});

require __DIR__.'/auth.php';