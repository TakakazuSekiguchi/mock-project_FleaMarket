<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemDetailController;
use App\Http\Controllers\ItemPutUpController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AddressController;

//ログイン前：
// 商品一覧画面（トップ画面）
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/search', [ItemController::class, 'search'])->name('items.search');

// 商品詳細画面
Route::get('/item/{item}', [ItemDetailController::class, 'show'])->name('items.show');

//ログイン後：
Route::middleware(['auth', 'verified'])->group(function () {
    //商品一覧画面（トップ画面）_マイリスト
    Route::get('/?tab=mylist', [ItemController::class, 'mylist'])->name('items.mylist');

    //商品出品画面
    Route::get('/sell', [ItemPutUpController::class, 'create']);
    Route::post('/sell', [ItemPutUpController::class, 'store'])->name('items.store');

    //プロフィール編集画面（設定画面）
    Route::get('/mypage/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/mypage/profile', [UserController::class, 'update'])->name('profile.update');

    //プロフィール画面
    Route::get('/mypage', [UserController::class, 'index'])->name('mypage.index');
    Route::get('/mypage?page=buy', [UserController::class, 'buy'])->name('mypage.buy');
    Route::get('/mypage?page=sell', [UserController::class, 'sell'])->name('mypage.sell');

    //商品詳細画面
    Route::post('/item/{item}/like', [ItemDetailController::class, 'toggleLike'])->name('items.like');
    Route::post('/item/{item}/comments', [ItemDetailController::class, 'store'])->name('comments.store');

    //商品購入画面
    Route::get('/purchase/{item}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::post('/purchase/{item}', [PurchaseController::class, 'checkout'])->name('purchase.checkout');
    Route::get('/purchase/cancel', [PurchaseController::class, 'cancel'])->name('purchase.cancel');

    //送付先住所変更画面
    Route::get('/purchase/address/{item}', [AddressController::class, 'edit'])->name('address.edit');
    Route::patch('/purchase/address/update', [AddressController::class, 'update'])->name('address.update');
});

/*---------------------認証関連---------------------*/
Route::get('/verify-email', [AuthController::class, 'show']);

// 認証メールのリンククリック処理
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/mypage/profile');
})->middleware(['auth', 'signed'])->name('verification.verify');

// 認証メール再送
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '確認メールを再送しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//メール未認証のユーザーに「/email/verify」へ誘導
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
/*---------------------------------------------------*/

