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
use App\Http\Controllers\MailSendController;

//商品一覧画面（トップ画面）
Route::get('/', [ItemController::class, 'index'])->name('index');
Route::get('/search', [ItemController::class, 'search'])->name('search');

//商品一覧画面（トップ画面）_マイリスト
Route::get('/?tab=mylist', [ItemController::class, 'index']);

//商品出品画面
Route::get('/sell', [ItemPutUpController::class, 'index']);
Route::post('/sell', [ItemPutUpController::class, 'store'])->name('items.store');

// Route::middleware('auth')->group(function () {
//     Route::post('/sell', [ItemPutUpController::class, 'store'])->name('items.store');
// });

//プロフィール画面・プロフィール編集画面（設定画面）
Route::get('/mypage', [UserController::class, 'index']);
Route::get('/mypage/profile', [UserController::class, 'edit']);

//商品詳細画面
Route::get('/item/{item_id}', [ItemDetailController::class, 'index']);

//商品購入画面・送付先住所変更画面
Route::get('/purchase/{item_id}', [OrderController::class, 'index']);
Route::get('/purchase/address/{item_id}', [OrderController::class, 'edit']);

//---------------------認証関連---------------------
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

// Route::get('/mypage/profile', function () {
//     return view('myProfile');
// })->middleware('verified');

//メール未認証の場合の遷移を防止（URL直打ちでアクセスできないように）
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/?tab=mylist', function () {
        return view('index');
    });
    Route::get('/sell', function () {
        return view('item_putUp');
    });
    Route::get('/mypage/profile', function () {
        return view('myProfile');
    });
    Route::get('/mypage', function () {
        return view('mypage');
    });
    Route::get('/mypage?page=buy', function () {
        return view('mypage');
    });
    Route::get('/mypage?page=sell', function () {
        return view('mypage');
    });
    Route::get('/purchase/{item_id}', function () {
        return view('order');
    });
    Route::get('/purchase/address/{item_id}', function () {
        return view('address');
    });
});

//メール未認証のユーザーに「/email/verify」へ誘導
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Route::middleware('auth')->group(function(){
//     Route::get('/?tab=mylist', [AuthController::class, 'index']);
// });

//メール送信テスト
Route::get('/mail', [MailSendController::class, 'index']);

//メール認証テスト
// Route::get('/test', function () {
//     return Auth::user()->hasVerifiedEmail() ? 'verified' : 'not verified';
// })->middleware('auth');

