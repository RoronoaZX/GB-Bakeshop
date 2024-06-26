<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BranchesProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RawMaterialsController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Models\BranchesProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('auth/login', [LoginController::class, 'login']);
Route::post('auth/logout', [LoginController::class, 'logout']);
Route::get('/logout_session', [LoginController::class, 'logout_session']);
Route::middleware('auth:sanctum')->get('/user_auth', function (Request $request) {
    return $request->user();
});
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return response()->json(['message' => 'Logged in successfully'], 200);
    }

    return response()->json(['message' => 'Invalid credentials'], 401);
});


Route::apiResource('branches', BranchController::class);
Route::apiResource('warehouses', WarehouseController::class);
Route::apiResource('raw_materials', RawMaterialsController::class);
Route::apiResource('products', ProductController::class);
Route::get('bread-products', [ProductController::class, 'fetchBreadProducts']);
// Route::get('raw-materials/search', [RawMaterialsController::class, 'search']);
Route::get('ingredients', [RawMaterialsController::class, 'fetchRawMaterialsIngredients']);
Route::apiResource('recipes', RecipeController::class);
Route::put('update-target/{id}', [RecipeController::class, 'updateTarget']);
Route::put('update-name/{id}', [RecipeController::class, 'updateName']);
Route::post('search', [RawMaterialsController::class, 'searchRawMaterials']);
Route::post('search-warehouse', [WarehouseController::class, 'searchWarehouse']);
Route::post('search-products', [ProductController::class, 'searchProducts']);
Route::post('search-recipe', [RecipeController::class, 'searchRecipe']);
Route::post('register', [RegisteredUserController::class, 'register']);
Route::apiResource('user', UserController::class);
Route::post('search-user', [UserController::class, 'searchUser']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::post('search-branches-by-id', [BranchesProductController::class, 'searchBranchId']);
Route::apiResource('branch-products', BranchesProductController::class);
Route::put('update-branch-product/{id}', [BranchesProductController::class, 'updatePrice']);
Route::get('branches/{branchId}/products', [BranchesProductController::class, 'getProducts']);
