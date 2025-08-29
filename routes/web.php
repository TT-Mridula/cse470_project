<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PublicProjectController;
use App\Http\Controllers\PublicSkillController;
use App\Http\Controllers\PublicContactController;
use App\Http\Controllers\PublicBlogController;

use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\SkillCategoryController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\PostCategoryController as AdminPostCategoryController;

use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

//
use App\Http\Controllers\Auth\OtpUiController;

Route::get('/register/otp',  [OtpUiController::class, 'show'])->name('register.otp.form');
Route::post('/register/otp', [OtpUiController::class, 'verify'])->name('register.otp.verify');
Route::post('/register/otp/resend', [OtpUiController::class, 'resend'])->name('register.otp.resend');
//
use App\Http\Controllers\User\ResumeController as MeResumeController;

Route::middleware('auth')->prefix('me')->name('me.')->group(function () {
    Route::get('/resume', [MeResumeController::class, 'show'])->name('resume.show');
    Route::get('/resume/edit', [MeResumeController::class, 'edit'])->name('resume.edit');
    Route::put('/resume', [MeResumeController::class, 'update'])->name('resume.update');
});
/*
|--------------------------------------------------------------------------
| Post login redirect
|--------------------------------------------------------------------------
*/
Route::get('/redirect', function () {
    $user = Auth::user();

    if (! $user) {
        return redirect()->route('login');
    }

    return $user->is_admin
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home');
})->middleware('auth')->name('postlogin.redirect');

/*
|--------------------------------------------------------------------------
| Optional user dashboard
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->get('/dashboard', [UserDashboardController::class, 'index'])
    ->name('user.dashboard');

/*
|--------------------------------------------------------------------------
| Public site
|--------------------------------------------------------------------------
*/
Route::get('/', [PagesController::class, 'index'])->name('home');

Route::get('/projects', [PublicProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [PublicProjectController::class, 'show'])->name('projects.show');

Route::get('/skills', [PublicSkillController::class, 'index'])->name('skills.index');

Route::post('/contact', [PublicContactController::class, 'store'])->name('contact.store');

Route::get('/blog', [PublicBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [PublicBlogController::class, 'show'])->name('blog.show');

/*
|--------------------------------------------------------------------------
| Auth scaffolding
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| Admin area
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/profile',  [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile',  [AdminProfileController::class, 'update'])->name('profile.update');

        // Dashboard
        Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');

        // Static pages in admin
        Route::get('/about',   [PagesController::class, 'about'])->name('about');
        Route::get('/contact', [PagesController::class, 'contact'])->name('contact');

        // Main settings
        Route::get('/main', [\App\Http\Controllers\MainPagesController::class, 'index'])->name('main');
        Route::put('/main', [\App\Http\Controllers\MainPagesController::class, 'update'])->name('main.update');

        // Services CRUD
        Route::get('/services', [PagesController::class, 'services'])->name('services');
        Route::get('/services/create', [\App\Http\Controllers\ServicePagesController::class, 'create'])->name('services.create');
        Route::post('/services', [\App\Http\Controllers\ServicePagesController::class, 'store'])->name('services.store');
        Route::get('/services/list', [\App\Http\Controllers\ServicePagesController::class, 'list'])->name('services.list');
        Route::get('/services/edit/{id}', [\App\Http\Controllers\ServicePagesController::class, 'edit'])->name('services.edit');
        Route::put('/services/update/{id}', [\App\Http\Controllers\ServicePagesController::class, 'update'])->name('services.update');
        Route::delete('/services/destroy/{id}', [\App\Http\Controllers\ServicePagesController::class, 'destroy'])->name('services.destroy');

        // Portfolios CRUD
        Route::get('/portfolios/create', [\App\Http\Controllers\PortfolioPagesController::class, 'create'])->name('portfolios.create');
        Route::post('/portfolios', [\App\Http\Controllers\PortfolioPagesController::class, 'store'])->name('portfolios.store');
        Route::get('/portfolios/list', [\App\Http\Controllers\PortfolioPagesController::class, 'list'])->name('portfolios.list');
        Route::get('/portfolios/edit/{id}', [\App\Http\Controllers\PortfolioPagesController::class, 'edit'])->name('portfolios.edit');
        Route::put('/portfolios/update/{id}', [\App\Http\Controllers\PortfolioPagesController::class, 'update'])->name('portfolios.update');
        Route::delete('/portfolios/destroy/{id}', [\App\Http\Controllers\PortfolioPagesController::class, 'destroy'])->name('portfolios.destroy');

        // Skills CRUD
        Route::get('/skills',                [SkillController::class, 'index'])->name('skills.index');
        Route::get('/skills/create',         [SkillController::class, 'create'])->name('skills.create');
        Route::post('/skills',               [SkillController::class, 'store'])->name('skills.store');
        Route::get('/skills/{skill}/edit',   [SkillController::class, 'edit'])->name('skills.edit');
        Route::put('/skills/{skill}',        [SkillController::class, 'update'])->name('skills.update');
        Route::delete('/skills/{skill}',     [SkillController::class, 'destroy'])->name('skills.destroy');

        // Skill categories CRUD
        Route::get('/skill-categories',                        [SkillCategoryController::class, 'index'])->name('skill_categories.index');
        Route::get('/skill-categories/create',                 [SkillCategoryController::class, 'create'])->name('skill_categories.create');
        Route::post('/skill-categories',                       [SkillCategoryController::class, 'store'])->name('skill_categories.store');
        Route::get('/skill-categories/{skill_category}/edit',  [SkillCategoryController::class, 'edit'])->name('skill_categories.edit');
        Route::put('/skill-categories/{skill_category}',       [SkillCategoryController::class, 'update'])->name('skill_categories.update');
        Route::delete('/skill-categories/{skill_category}',    [SkillCategoryController::class, 'destroy'])->name('skill_categories.destroy');

        // Messages inbox
        Route::get('/messages',                    [ContactMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{message}',          [ContactMessageController::class, 'show'])->name('messages.show');
        Route::delete('/messages/{message}',       [ContactMessageController::class, 'destroy'])->name('messages.destroy');
        Route::post('/messages/{message}/read',    [ContactMessageController::class, 'markRead'])->name('messages.read');
        Route::post('/messages/{message}/unread',  [ContactMessageController::class, 'markUnread'])->name('messages.unread');

        // Projects
        Route::resource('projects', AdminProjectController::class)->except(['show']);

        // Blog posts
        Route::get('/blog',             [AdminPostController::class, 'index'])->name('blog.index');
        Route::get('/blog/create',      [AdminPostController::class, 'create'])->name('blog.create');
        Route::post('/blog',            [AdminPostController::class, 'store'])->name('blog.store');
        Route::get('/blog/{post}/edit', [AdminPostController::class, 'edit'])->name('blog.edit');
        Route::put('/blog/{post}',      [AdminPostController::class, 'update'])->name('blog.update');
        Route::delete('/blog/{post}',   [AdminPostController::class, 'destroy'])->name('blog.destroy');

        // Blog categories
        Route::get('/blog-categories',                [AdminPostCategoryController::class, 'index'])->name('blog.categories');
        Route::post('/blog-categories',               [AdminPostCategoryController::class, 'store'])->name('blog.categories.store');
        Route::delete('/blog-categories/{category}',  [AdminPostCategoryController::class, 'destroy'])->name('blog.categories.destroy');
    });
