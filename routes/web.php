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
    use App\Http\Controllers\Platform\OrderController;
    use App\Http\Controllers\User\AddressController;
    use App\Http\Controllers\User\PhotoController;
    use App\Http\Controllers\Platform\CategoryController;
    use App\Http\Controllers\Platform\ReviewController;

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

    Auth::routes(['verify' => true]);

    Route::get('/', [HomePageController::class, 'index'])->name('homepage');

    Route::middleware(['auth', 'verified'])->group(function () {

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

        Route::controller(CartController::class)->group(function () {

            Route::post('/cart/add', 'addToCart')->name('cart.addToCart');
            Route::get('cart', 'showCart')->name('cart.show');
            Route::post('/cart/remove', 'removeExperienceFromCart')->name('cart.remove');
        });

        Route::controller(StripeController::class)->group(function () {

            Route::post('/checkout', 'checkout')->name('checkout');
            Route::get('/cancel', 'cancel')->name('checkout.cancel');
        });

        Route::get('/success', [StripeController::class, 'success'])->name('checkout.success');

        Route::controller(OrderController::class)->group(function () {

            Route::get('/orders', 'index')->name('orders.index');
            Route::get('/orders/{order}', 'show')->name('orders.show');
            Route::get('/orders/ordersPDF/download/{order}', 'downloadPDF')->name('pdf.download');
        });

        Route::controller(DayController::class)->group(function () {

            Route::get('/days/{experience}/{day}/edit', 'edit')->name('days.edit');
            Route::post('/days/{experience}/{day}', 'update')->name('days.update');
            Route::delete('/days/{day}', 'destroy')->name('days.destroy');
            Route::get('/days/{experience}', 'index')->name('days.index');
        });

        Route::controller(ExperienceController::class)->group(function () {
            Route::get('/experience/createExperience', 'createExperience')->name('experience.createExperience');
            Route::post('/experience/store', 'store')->name('experience.storeExperience');
            Route::post('/experience/update/{experience}', 'updateExperience')->name('experience.updateExperience');
            Route::post('/experience/storePhoto', 'storeExpPhoto')->name('experience.storePhoto');
            Route::get('/experience/edit/{experience}', 'edit')->name('experience.edit');
            Route::post('/experience/destroy/{experience}', 'destroy')->name('experience.destroy');
            Route::post('/experience/{experience}/show-availability', 'checkAvailability')->name('experience.checkAvailability');
            Route::get('/experience/{experience}/show-availability', 'showAvailability')->name('experience.showAvailability');
        });

        Route::post('experience/storeDay', [DayController::class, 'storeDay'])->name('experience.storeDay');

    
        Route::get('/experience/review/create/{order_experience}/{experience}',[ReviewController::class,'create'])->name('review.create');
        Route::post('/experience/review/store', [ReviewController::class,'store'])->name('review.store');

    });

    Route::middleware('isAdmin')->group(function () {

        Route::controller(UserController::class)->group(function () {
            Route::get('/users', 'index')->name('users.index');
            Route::get('/users/create', 'create')->name('users.create');
            Route::post('/users/store', 'store')->name('users.store');
            Route::get('/users/show/{user}', 'show')->name('users.show');
            Route::get('/users/edit/{user}', 'edit')->name('users.edit');
            Route::post('/users/update/{user}', 'update')->name('users.update');
            Route::post('/users/destroy/{user}', 'destroy')->name('users.destroy');
            Route::put('/users/change-usertype/{user}', 'changeUserType')->name('users.changeUsertype');
        });

        Route::controller(CategoryController::class)->group(function () {
            Route::get('/categories', 'index')->name('category.index');
            Route::get('/categories/show/{category}', 'show')->name('category.show');
            Route::get('/categories/create', 'create')->name('category.create');
            Route::get('/categories/edit/{category}', 'edit')->name('category.edit');
            Route::post('/categories/store', 'store')->name('category.store');
            Route::post('/categories/update/{category}', 'update')->name('category.update');
            Route::post('/categories/destroy/{category}', 'destroy')->name('category.destroy');
        });
        Route::controller(PhotoController::class)->group(function () {
            Route::get('/photos', 'index')->name('photo.index');
            Route::get('/photos/create', 'create')->name('photo.create');
            Route::post('/photos/store', 'storePhoto')->name('photo.store');
            Route::get('/photos/show/{photo}', 'show')->name('photo.show');
            Route::get('/photos/edit/{photo}', 'edit')->name('photo.edit');
            Route::post('/photos/update/{photo}', 'update')->name('photo.update');
            Route::post('/photos/destroy/{photo}', 'destroy')->name('photo.destroy');
        });

        Route::controller(AddressController::class)->group(function () {
            Route::get('/addresses', 'index')->name('address.index');
            Route::get('/addresses/create', 'create')->name('address.create');
            Route::post('/addresses/store', 'store')->name('address.store');
            Route::get('/addresses/show/{address}', 'show')->name('address.show');
            Route::get('/addresses/edit/{address}', 'edit')->name('address.edit');
            Route::post('/addresses/update/{address}', 'update')->name('address.update');
            Route::post('/addresses/destroy/{address}', 'destroy')->name('address.destroy');
        });

        Route::controller(ExperienceController::class)->group(function () {
            Route::get('/experience', 'index')->name('experience.index');
            Route::get('/experience/create', 'create')->name('experience.create');
        });
    });


    Route::post('/webhook', [StripeController::class, 'webhook'])->name('checkout.webhook');


    Route::controller(ExperienceController::class)->group(function () {
        Route::get('/experience/{experience}', 'show')->name('experience.show');
    });
