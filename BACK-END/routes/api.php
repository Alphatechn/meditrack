<?php

use App\Http\Controllers\AuthC;
use App\Http\Controllers\Autocomplete;
use App\Http\Controllers\CaisseC;
use App\Http\Controllers\PrescrireC;
use App\Http\Controllers\PatientC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeUserC;
use App\Http\Controllers\PersonnelC;
use App\Http\Controllers\ServiceC;
use App\Http\Controllers\TransfertC;
use App\Http\Controllers\CategorieC;
use App\Http\Controllers\MedicamentC;
use App\Http\Controllers\ExamenC;
use App\Http\Controllers\ConsultationC;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Rendez_vousC;
use App\Http\Controllers\ResultpC;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\SoinC;
use App\Http\Controllers\ElementC;

// ****** RDV ********* //
//cote personnel//

Route::get('/rdven/pat/{idpat}', [Rendez_vousC::class, 'index']);
Route::get('/rdven/pers/{idpers}', [Rendez_vousC::class, 'index']);
Route::get('/rdvenall/pers/{idpers}', [Rendez_vousC::class, 'showall']);
Route::get('/rdvuni/pers/{idrdv}', [Rendez_vousC::class, 'show']);
Route::post('/rdvupd/pers/{idrdv}', [Rendez_vousC::class, 'update']);
Route::post('/rdvupd/pat/{idrdv}', [Rendez_vousC::class, 'updatep']);
Route::post('/rdvstore', [Rendez_vousC::class, 'store']);
Route::get('/medecin/{idpat}', [ConsultationC::class, 'showmed']);
Route::get('/sms', [SMSController::class, 'send']);


// ****** ETATS ********* //
Route::get('/pdf/generate/{iduser}/{idpat}', [PdfController::class, 'generatePdf']);
Route::get('/recu/{numre}', [PdfController::class, 'recu']);


// ***** CONSULTATION *****/
Route::get('/prescrire/{id}', [PrescrireC::class, 'index']);


// ***** CAISSE *****/
Route::post( '/caisse', [CaisseC::class, 'store']);
Route::post('/caisse/update/{id}', [CaisseC::class, 'update']);
Route::get( '/caisse/show/{id}', [CaisseC::class, 'create']);
Route::get( '/caisse/showall/{id}', [CaisseC::class, 'index']);
Route::get('/caisse/showun/{id}', [CaisseC::class, 'showc']);

// ***** CONSULTATION *****/
Route::post('/consutation', [ConsultationC::class, 'store']);
Route::post('/consutation/update', [ConsultationC::class, 'update']);
Route::post('/consutation/prescrire', [ConsultationC::class, 'prescrire']);
Route::get('/consutation/user/{id}', [ConsultationC::class, 'index']);
Route::get('/consutation/labo/user/{id}', [ConsultationC::class, 'indexlabo']);
Route::get('/consutation/show/{id}', [ConsultationC::class, 'show']);
Route::post('/consutation/create', [ConsultationC::class, 'create']);

// ***** EXAMINATION *****/
Route::post('/examination', [ResultpC::class, 'store']);
Route::post('/examination/update', [ResultpC::class, 'update']);
Route::get('/examination/user/{id}', [ResultpC::class, 'index']);
Route::get('/examination/show/{id}', [ResultpC::class, 'show']);
// ***** SOIN *****/
Route::post('/soin', [SoinC::class, 'store']);

// ***** TRANSFERT *****/
//users//
Route::post('/transfert', [TransfertC::class, 'store']);

Route::post('/transfert/{id}', [TransfertC::class, 'update']);
Route::get('/transfert/count/{id}', [TransfertC::class, 'edit']);
Route::get('/transfert/{id}', [TransfertC::class, 'show']);
Route::get('/transfert/search/{id}/{search}', [TransfertC::class, 'search']);
Route::delete('/transfert/{id}', [TransfertC::class, 'destroy']);
Route::get('/transfert', [TransfertC::class, 'index']);
Route::get('/transfertc', [TransfertC::class, 'showP']);


//AUTOCOMPLETE//
Route::get('/autocomp', [Autocomplete::class, 'getData']);
Route::get('/autocomp/exam', [Autocomplete::class, 'getDataExam']);
Route::get('/autocomp/med', [Autocomplete::class, 'getDataMed']);



Route::post('/categorie', [CategorieC::class, 'store']);
Route::post('/categorie/{id}', [CategorieC::class, 'update']);
Route::get('/categorie', [CategorieC::class, 'index']);
Route::get('/categorie/{id}', [CategorieC::class, 'show']);
Route::delete('/categorie/{id}', [CategorieC::class, 'destroy']);

//*** MEDICAMENT */

Route::post('/medicament', [MedicamentC::class, 'store']);
Route::post('/medicament/{id}', [MedicamentC::class, 'update']);
Route::delete('/medicament/{id}', [MedicamentC::class, 'destroy']);
Route::get('/medicament', [MedicamentC::class, 'index']);
Route::get('/medicament/{id}', [MedicamentC::class, 'show']);

//**** Routes publiques de examen*/
Route::get('/examen', [ExamenC::class, 'index']);
Route::get('/examen/search/{libelle}', [ExamenC::class, 'search']);
Route::get('/examen/searchid/{id}', [ExamenC::class, 'show']);
Route::post('/examen', [ExamenC::class, 'store']);
Route::post('/examen/{id}', [ExamenC::class, 'update']);
Route::delete('/examen/{id}', [ExamenC::class, 'destroy']);

//**** Routes publiques de Element*/
Route::get('/element', [ElementC::class, 'index']);
Route::get('/element/search/{libelle}', [ElementC::class, 'search']);
Route::get('/element/searchid/{id}', [ElementC::class, 'show']);
Route::post('/element', [ElementC::class, 'store']);
Route::post('/element/{id}', [ElementC::class, 'update']);
Route::delete('/element/{id}', [ElementC::class, 'destroy']);

//**** Routes publiques */
Route::post('/login', [AuthC::class, 'login']);
Route::post('/forgotpass', [AuthC::class, 'PostForgotPassword']);
Route::get('/infouser/{id}', [AuthC::class, 'user']);
Route::post('/updateuser/{id}', [AuthC::class, 'updateuser']);
Route::post('/updatepass/{id}', [AuthC::class, 'renewpass']);
Route::get('reset/{token}', [AuthC::class, 'reset']);
Route::post('reset', [AuthC::class, 'PostReset']);


// *********  Routes privees ****/
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthC::class, 'logout']);
    // **** TYPE USER***/
    Route::get('/typeuser', [TypeUserC::class, 'index']);
    Route::get('/typeuser/all', [TypeUserC::class, 'showall']);
    Route::get('/typeuser/search/{libelle}', [TypeUserC::class, 'search']);
    Route::get('/typeuser/searchid/{id}', [TypeUserC::class, 'show']);
    Route::post('/typeuser', [TypeUserC::class, 'store']);
    Route::post('/typeuser/{id}', [TypeUserC::class, 'update']);
    Route::delete('/typeuser/{id}', [TypeUserC::class, 'destroy']);

    // *** PERSONNEL ***/
    Route::get('/personnel', [PersonnelC::class, 'index']);
    Route::get('/personnel/search/{libelle}', [PersonnelC::class, 'search']);
    Route::get('/personnel/searchid/{id}', [PersonnelC::class, 'show']);
    Route::post('/personnel', [PersonnelC::class, 'store']);
    Route::post('/personnel/{id}', [PersonnelC::class, 'update']);
    Route::delete('/personnel/{id}', [PersonnelC::class, 'destroy']);

    //*** PATIENT */
    Route::get('/patient/ante/{id}', [PatientC::class, 'ante']);
    Route::get('/patient', [PatientC::class, 'index']);
    Route::get('/patient/search/{libelle}', [PatientC::class, 'search']);
    Route::get('/patient/searchid/{id}', [PatientC::class, 'show']);
    Route::post('/patient', [PatientC::class, 'store']);
    Route::post('/patient/{id}', [PatientC::class, 'update']);
    Route::delete('/patient/{id}', [PatientC::class, 'destroy']);


    //****** SERVICE */
    Route::get('/service', [ServiceC::class, 'index']);
    Route::get('/service/search/{libelle}', [ServiceC::class, 'search']);
    Route::get('/service/searchid/{id}', [ServiceC::class, 'show']);
    Route::post('/service', [ServiceC::class, 'store']);
    Route::post('/service/{id}', [ServiceC::class, 'update']);
    Route::delete('/service/{id}', [ServiceC::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
