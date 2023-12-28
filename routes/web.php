    <?php

    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\User\ProfileController;
    use App\Http\Controllers\User\UserController;
    use App\Http\Controllers\Platform\ExperienceController;
    use App\Http\Controllers\Platform\DayController;
    use App\Http\Controllers\HomePageController;
    use App\Http\Controllers\Platform\CartController;
    use App\Http\Controllers\Platform\StripeController;
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

    Auth::routes();

    Route::get('/', [HomePageController::class, 'index'])->name('homepage');

    Route::middleware('auth')->group(function () {

        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile/{user}', 'show')->name('profile.show');
            Route::get('/profile/{user}/edit', 'edit')->name('profile.edit');
            Route::put('/profile/updateProfile', 'updateUser')->name('profile.updateUser');
            Route::post('/profile/storePhoto', 'storePhoto')->name('profile.storePhoto');
            Route::post('/profile/updatePhoto', 'updatePhoto')->name('profile.updatePhoto');
            Route::post('/profile/storeAddress', 'storeAddress')->name('profile.storeAddress');
            Route::post('/profile/updateAddress', 'updateAddress')->name('profile.updateAddress');
        });


        Route::controller(UserController::class)->group(function () {
            Route::post('/becomeLocal', 'becomeLocal')->name('becomeLocal');
        });

        Route::controller(ExperienceController::class)->group(function () {
            Route::get('/experience/create', 'createExperience')->name('experience.createExperience');
            Route::post('/experience/store', 'store')->name('experience.storeExperience');
            Route::put('/experience/update', 'update')->name('experience.updateExperience');
            Route::post('/experience/storePhoto', 'storeExpPhoto')->name('experience.storePhoto');
            Route::post('/experience/{experience}/show-availability', 'checkAvailability')->name('experience.checkAvailability');
            Route::get('/experience/{experience}/show-availability', 'showAvailability')->name('experience.showAvailability');
            
        });

        Route::post('experience/storeDay', [DayController::class, 'storeDay'])->name('experience.storeDay');

        Route::controller(CartController::class)->group(function () {

            Route::post('/cart/add', 'addToCart')->name('cart.addToCart');
            Route::get('cart', 'showCart')->name('cart.show');
            Route::post('/cart/remove','removeExperienceFromCart')->name('cart.remove');

        });

        Route::controller(StripeController::class)->group(function (){

            Route::post('/checkout', 'checkout')->name('checkout');
            Route::get('/cancel', 'cancel')->name('checkout.cancel');
            
        });

        Route::get('/success', [StripeController::class, 'success'])->name('checkout.success');

    });




    Route::controller(ExperienceController::class)->group(function () {
        Route::get('/experience/{experience}', 'show')->name('experience.show');
    });
