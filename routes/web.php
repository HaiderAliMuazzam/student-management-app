<?php

use Modules\Student\Models\Student;
use Illuminate\Support\Facades\Route;
use Modules\Announcement\Models\Announcement;
use Modules\Finance\Models\Invoice;
use Modules\Grade\Models\Grade;
use Modules\Subject\Models\Subject;


/*
|--------------------------------------------------------------------------
| Language Switch
|--------------------------------------------------------------------------
|
| Switch application language globally.
| Available languages: English (en), Arabic (ar)
|
*/



Route::get('/language/{locale}', function ($locale) {

    if (in_array($locale, ['en', 'ar'])) {

        session(['locale' => $locale]);

    }

       return back();


})->name('language.switch');



Route::view('/', 'welcome')->name('home');



Route::middleware(['auth', 'verified'])->group(function () {


    /**
     * Dashboard
     */
    Route::get('dashboard', function () {

        return view('dashboard', [

            'studentCount'      => Student::count(),
            'subjectCount'      => Subject::count(),
            'gradeCount'        => Grade::count(),
            'announcementCount' => Announcement::count(),

            'outstandingAmount' => Invoice::selectRaw('SUM(amount - amount_paid) as outstanding')
                ->value('outstanding'),

        ]);

    })->name('dashboard');


});


require __DIR__ . '/settings.php';