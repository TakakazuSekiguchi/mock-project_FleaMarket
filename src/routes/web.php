<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemDetailController;
use App\Http\Controllers\ItemPutUpController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
// use App\Http\Controllers\MailSendController;

//商品一覧画面（トップ画面）
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/search', [ItemController::class, 'search'])->name('search');

//商品一覧画面（トップ画面）_マイリスト
Route::get('/?tab=mylist', [ItemController::class, 'mylist'])->name('items.mylist');

//商品出品画面
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/sell', [ItemPutUpController::class, 'create']);
    Route::post('/sell', [ItemPutUpController::class, 'store'])->name('items.store');
});

//プロフィール編集画面（設定画面）
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage/profile', [UserController::class, 'edit']);
    Route::patch('/mypage/profile', [UserController::class, 'update'])->name('profile.update');
});

//プロフィール画面
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
});

//商品詳細画面
Route::get('/item/{item}', [ItemDetailController::class, 'show'])->name('items.show');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/item/{item}/like', [ItemDetailController::class, 'toggleLike'])->name('items.like');
    Route::post('/item/{item}/comments', [ItemDetailController::class, 'store'])->name('comments.store');
});

//商品購入画面
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/purchase/{item}', [OrderController::class, 'show'])->name('purchase.show');
    Route::post('/purchase/{item}/order', [OrderController::class, 'store'])->name('purchase.store');
});

//送付先住所変更画面
Route::middleware(['auth', 'verified'])->group(function () {
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

//メール送信テスト
// Route::get('/mail', [MailSendController::class, 'index']);


