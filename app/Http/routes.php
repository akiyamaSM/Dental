<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['guest'], 'namespace' => 'Patients', 'prefix' => 'admin'], function(){
    Route::group(['namespace' => 'Operations'], function(){
        // GET the list of Operations on the patient
        Route::get('patient/{patient}/operation', ['uses' => 'ManageController@index', 'as' => 'patient.operation.index'] );
        // GET the CreatePage of a new Operation
        Route::get('patient/{patient}/operation/create', ['uses' => 'ManageController@create', 'as' => 'patient.operation.create'] );
        //handle the Operation Request
        Route::post('patient/{patient}/operation/create', ['uses' => 'ManageController@store', 'as' => 'patient.operation.store'] );
        //Get the list of Sessions in a Current Operation
        Route::get('patient/{patient}/operation/{operation}', ['uses' => 'ManageController@show', 'as' => 'patient.operation.show'] );
        //Get the list of Sessions in a Terminated Operation
        Route::get('patient/{patient}/operation/{id}/history', ['uses' => 'ManageController@history', 'as' => 'patient.operation.history'] );
        // Terminate an Operation
        Route::delete('patient/operation/{operation}/terminate', ['uses' => 'ManageController@terminate', 'as' => 'patient.operation.terminate'] );
       //Post Form to create new Session
       Route::post('patient/operation/{operation}/session/create', ['uses' => 'ManageController@storeSession', 'as' => 'patient.operation.store.session'] );
       //Post Form to create new Session
       Route::post('patient/operation/{id}/payment/create', ['uses' => 'ManageController@makePayment', 'as' => 'patient.operation.make.payment'] );
    });

    Route::group(['namespace' => 'Payments'], function(){
        // GET the list of Payments on the patient
        Route::get('patient/{patient}/payment', ['uses' => 'ManageController@index', 'as' => 'patient.payment.index'] );
    });

    Route::group(['namespace' => 'Appointments'], function(){
        Route::get('/test', 'ManageController@test');
        // GET the list of all the appointments
        Route::get('appointments', ['uses' => 'ManageController@all', 'as' => 'appointments.all' ]);
        // GET the list of all the appointments of a SPECIFIC patient
        Route::get('patient/{patient}/appointments', ['uses' => 'ManageController@index', 'as' => 'appointments.patient.all'] );
        // GET the list of the current appointments of a SPECIFIC patient
        Route::get('patient/{patient}/appointments/current', ['uses' => 'ManageController@current', 'as' => 'appointments.patient.current'] );

        //API HANDLERS
        Route::post('appointments', ['uses' => 'ManageController@store', 'as' => 'appointment.all.store']);
        // Route to cancel the Appointment
        Route::patch('appointments/{appointment}/cancel', ['uses' => 'ManageController@cancel', 'as' => 'appointment.patient.cancel'] );
        // Route to Activate the Appointment
        Route::patch('appointments/{appointment}/activate', ['uses' => 'ManageController@activate', 'as' => 'appointment.patient.activate'] );
        // Route to Validate the Appointment
        Route::patch('appointments/{appointment}/confirm', ['uses' => 'ManageController@confirm', 'as' => 'appointment.patient.confirm'] );
        // Route to delete a specific Appointment
        Route::delete('appointments/{appointment}', ['uses' => 'ManageController@destroy', 'as' => 'appointment.patient.destroy'] );
        // Route to edit a specific Appointment
        Route::patch('appointments/{appointment}/update', ['uses' => 'ManageController@update', 'as' => 'appointment.patient.update'] );
    });
    // Get history Page of SoftDeleted Patients
    Route::get('patient/history', ['uses' => 'ManageController@history', 'as' => 'admin.patient.history']);
    // Delete a Patient permanently
    Route::delete('patient/{id}/forcedestroy', ['uses' => 'ManageController@forceDestroy', 'as' => 'admin.patient.forceDestroy'] );
    // Restore a Patient
    Route::get('patient/{id}/revive', ['uses' => 'ManageController@revive', 'as' => 'admin.patient.revive'] );
    // CRUD on the Patient
    Route::resource('patient', 'ManageController');
});
Route::group(['middleware' => 'web'], function () {
    Route::auth();
});


Route::group(['middleware' => ['guest'], 'namespace' => 'illnesses', 'prefix' => 'admin'], function(){
    //GET The List of Illnesses
    Route::get('maladies', ['uses' => 'PagesController@index', 'as' => 'maladies.index']);
});

// API to handle Illnesses operations
Route::group(['middleware' => ['guest'], 'namespace' => 'illnesses', 'prefix' => 'api'], function(){
    Route::get('Illness', ['uses' => 'ManageController@index', 'as' => 'illness.index']);
    Route::post('Illness', ['uses' => 'ManageController@store', 'as' => 'illness.store']);
    Route::patch('Illness/{id}', ['uses' => 'ManageController@update', 'as' => 'illness.update'] );
});

Route::group(['middleware' => ['guest'], 'namespace' => 'Pharmacy', 'prefix' => 'admin/pharmacy'], function(){
    // To show the list of Units
    Route::get('units', [ 'uses' => 'UnitController@index', 'as' => 'pharmacy.units.index']);
    // To add new Unit
    Route::post('units', ['uses' => 'UnitController@store', 'as' => 'pharmacy.units.store']);
    // Route to edit a specific Unit
    Route::patch('units/{unit}/update', ['uses' => 'UnitController@update', 'as' => 'pharmacy.units.update'] );
    // Route to delete a specific Unit
    Route::delete('units/{unit}', ['uses' => 'UnitController@destroy', 'as' => 'pharmacy.units.destroy'] );

    // To show the list of Medicines
    Route::get('medicines', [ 'uses' => 'MedicineController@index', 'as' => 'pharmacy.medicines.index']);
    // To add new Medicine
    Route::post('medicines', ['uses' => 'MedicineController@store', 'as' => 'pharmacy.medicines.store']);
    Route::get('test', function(){
       $medicine = \App\Medicine::with('unit')->find(19);
        dd($medicine->unit->name);
    });
});