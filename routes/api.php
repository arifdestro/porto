<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/import-transfer', function (\Illuminate\Http\Request $request) {
    $tables = $request->json()->all();
    foreach ($tables as $tableName => $rows) {
        \Illuminate\Support\Facades\DB::table($tableName)->delete();
        if (!empty($rows)) {
            foreach (array_chunk($rows, 100) as $chunk) {
                \Illuminate\Support\Facades\DB::table($tableName)->insert($chunk);
            }
        }
    }
    return 'Success';
});
