<?php

use Illuminate\Support\Facades\Route;
use Nette\Utils\Strings;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    $country = 'Venezuela';
    $stadzentrum = 'Caracas';
    return view('about', ['country' => $country], ['stadzentrum' => $stadzentrum]);
});

// Route::get('/user/{id?}', function (int $id) {
    
//     $person = [
//         'name' => 'John Doe',
//         'age' => 30,
//         'occupation' => 'Developer'
//     ];
//     //dump($person); // Debugging output to inspect the array
//     // dd($person); // Terminate and display the array contents
//      return "el id del usuario es:'  $id";


// });

// Route ::get('{lang}/product/{id}', function (string $lang, Strings $id) {
    

// })->where(['lang' => ('[a-z]{2}'), 'id' => '\d{4, }']);


// Route::get('/sum/{a}/{b}', function (int $a, int $b) {
//     $sum = $a + $b;
//     //dd($sum);
//     return "The sum of $a and $b is: $sum";
// });


