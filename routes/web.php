<?php

use App\Http\Controllers\InitiativeController;
use App\Http\Controllers\CostumerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/* Route::get('/', function () {
    return view('auth.login');
});
Auth::routes(['register' => false, 'reset' => false]); */

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// Registration Routes...

Route::get('file_p/{folder}/{file}', function ($folder, $file) {
    $folder = explode('-', $folder);
    $url = "";
    foreach ($folder as $str) {
        if ($str === end($folder)) {
            $url .= $str;
        } else {
            $url .= $str . '/';
        }
    }
    return Storage::disk('fileserver')->get("$url/$file");
})->name('files_p.get');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/homePremium', 'HomeController@indexPremium')->name('home.premium');
    // Chatbot
    Route::match(['get', 'post'], '/botman', 'BotManController@handle');
    Route::get('/homeTest', function () {
        return view('homeTest');
    });
    // Rutas de menus
    Route::name('admin.')->prefix('admin')->group(function () {
        Route::get('menus/createWithAuto', 'Admin\MenuController@createWithAutomatizacion')->name('menus.createWithAuto');
        Route::post('menus/createWithAuto', 'Admin\MenuController@storeWithAutomatizacion')->name('menus.createWithAutoPOST');
        Route::post('menus/createWithSubMenus/{idPadre}', 'Admin\MenuController@createWithSubMenus')->name('menus.createWithSubMenusPOST');
        Route::put('menus/createWithSubMenus', 'Admin\MenuController@storeWithSubMenus')->name('menus.createWithSubMenusPUT');
        Route::post('menus/especializar', 'Admin\MenuController@especializarMenu')->name('menu.especializar');
        Route::resource('menus', 'Admin\MenuController');
    });
    // Rutas de Roles
    Route::resource('roles', 'RolController');
    // Rutas de Permisos
    Route::get('permissions/assign', 'PermissionController@assign')->name('permissions.assign');
    Route::post('permissions/assign', 'PermissionController@assignStore')->name('permissions.assignStore');
    Route::resource('permissions', 'PermissionController');
    Route::get('permissions/{permission}/revoke', 'PermissionController@revoke')->name('permissions.revoke');
    // Rutas usuarios
    Route::resource('users', 'CrudController');
    //Rutas para OS Groups
    Route::resource('osGroups', 'OsGroupController')->except('show');
    //Rutas para Inventarios
    Route::resource('inventories', 'InventoryController')->only('index', 'create');
    //Rutas para Templates
    Route::resource('awxTemplates', 'AwxTemplateController')->only('index', 'create', 'show');
    //Rutas para Login Logs
    Route::get('loginLogs', 'LoginLogController@index')->name('loginLogs.index');
    Route::post('loginLogs', 'LoginLogController@showLogs')->name('loginLogs.showLogs');
    //Rutas para Sync Logs
    Route::get('syncLogs', 'SyncLogController@index')->name('syncLogs.index');
    Route::post('syncLogs', 'SyncLogController@showLogs')->name('syncLogs.showLogs');
    //Rutas para Site Logs
    Route::resource('siteLogs', 'SiteLogController')->only('index');
    //Manejo de archivos
    //Route::get('file', 'HomeController@files')->name('files.index');
    Route::get('file/{folder}/{file}', function ($folder, $file) {
        $folder = explode('-', $folder);
        $url = "";
        foreach ($folder as $str) {
            if ($str === end($folder)) {
                $url .= $str;
            } else {
                $url .= $str . '/';
            }
        }
        return Storage::disk('fileserver')->get("$url/$file");
    })->name('files.get');
    //Dev Task

    Route::post('global/{automatizacion}', 'VistasReutilizablesController@peticionAuxilar')->name('global.get');
    Route::get('premium/{cliente}/{automatizacion}', 'VistasReutilizablesController@index')->name('premium.index');
    Route::post('premium/{cliente}/{automatizacion}', 'VistasReutilizablesController@store')->name('premium.store');

    Route::resource('dev/devTasks', 'DevTaskController')->except('show');
    Route::resource('dev/devStates', 'DevStateController')->except('show');
    Route::resource('vcenters', 'VcenterController')->except('show');
    Route::get('dev/devRequests/admin', 'DevRequestController@indexAdmin')->name('devRequests.indexAdmin');
    Route::resource('dev/devRequests', 'DevRequestController')->except('edit', 'destroy');
    Route::get('dev/devRequests/{devRequest}/devRequestFields', 'DevRequestFieldController@index')->name('devRequestFields.index');
    Route::post('dev/devRequests/{devRequest}/devRequestFields', 'DevRequestFieldController@store')->name('devRequestFields.store');
    Route::get('dev/devRequests/{devRequest}/devRequestFields/{devRequestField}', 'DevRequestFieldController@remove')->name('devRequestFields.remove');
    Route::get('dev/devRequests/{devRequest}/assign', 'DevRequestController@assign')->name('devRequests.assign');
    Route::post('dev/devRequests/{devRequest}/assign', 'DevRequestController@assignStore')->name('devRequests.assignStore');
    Route::get('dev/devRequests/{devRequest}/change', 'DevRequestController@change')->name('devRequests.change');
    Route::post('dev/devRequests/{devRequest}/change', 'DevRequestController@changeStore')->name('devRequests.changeStore');
    Route::get('dev/devRequests/create/{regImprovement}', 'DevRequestController@createWithImprovement')->name('devRequests.createWithImprovement');
    //Documentación
    Route::get('documentations/', 'DocumentationController@index')->name('documentations.index');
    Route::get('documentations/{documentation}', 'DocumentationController@show')->name('documentations.show');
    Route::get('documentations/{regImprovement}/create', 'DocumentationController@create')->name('documentations.create');
    Route::post('documentations/{regImprovement}/create', 'DocumentationController@store')->name('documentations.store');
    Route::get('documentations/{documentation}/edit', 'DocumentationController@edit')->name('documentations.edit');
    Route::put('documentations/{documentation}/edit', 'DocumentationController@update')->name('documentations.update');
    Route::get('documentations/{documentation}/approval', 'DocumentationController@approval')->name('documentations.approval');
    Route::get('documentations/{documentation}/upload', 'DocumentationController@uploadForm')->name('documentations.uploadForm');
    Route::post('documentations/{documentation}/upload', 'DocumentationController@upload')->name('documentations.upload');
    Route::get('/docs/tech/{file}', function ($file) {
        return Storage::response("docs/tech/$file");
    })->name('documentations.file'); // Ruta para ver el manual técnico de la automatización
    Route::get('/docs/user/{file}', function ($file) {
        return Storage::response("docs/user/$file");
    })->name('documentations.userFile'); // Ruta para ver el manual de usuario de la automatización
    Route::resource('RegConsumedServices', 'RegConsumedServiceController')->except('show');
    // Registro de mejoras / improvements
    Route::get('improvements/temp', 'RegImprovementController@temp')->name('improvements.temp');
    Route::resource('improvements', 'RegImprovementController');
    Route::get('improvements/{improvement}/approval', 'RegImprovementController@approval')->name('improvements.approval');
    Route::get('improvements/{improvement}/test/approval', 'RegImprovementController@testApproval')->name('improvements.testApproval');
    Route::get('improvements/{improvement}/deny', 'RegImprovementController@deny')->name('improvements.deny');
    //Route::get('improvements/{improvement}/showProgress', 'RegImprovementController@showProgress')->name('improvements.showProgress');
    Route::get('improvements/{improvement}/progress', 'RegImprovementController@progressEdit')->name('improvements.progressEdit');
    Route::get('improvements/{improvement}/progress/{service}', 'RegImprovementController@progressService')->name('improvements.progressService');
    Route::post('improvements/{improvement}/progress', 'RegImprovementController@progressUpdate')->name('improvements.progressUpdate');
    Route::get('improvements/{improvement}/history', 'RegImprovementController@history')->name('improvements.history');
    Route::get('improvements/getLayers/{id}', 'RegImprovementController@getLayers')->name('improvements.getLayers');
    Route::resource('RegServiceSegments', 'RegServiceSegmentController')->except('show');
    Route::resource('RegServiceLayers', 'RegServiceLayerController')->except('show');
    Route::resource('RegQuarters', 'RegQuarterController')->except('show');
    Route::resource('RegCustomerLevels', 'RegCustomerLevelController')->except('show');
    # Registro de mejoras basico
    Route::resource('regImprovementMin', 'RegImprovementMinController');
    Route::get('regImprovementMin/getLayers/{id}', 'RegImprovementMinController@getLayers')->name('RegImprovementMin.getLayers');
    //Windows Empresas y negocios
    Route::get('windows/getHosts/{inventario}/{grupo}/{method}', 'WindowsController@getHostsByGroup')->name('windows.getHosts');
    Route::get('windows/create', 'WindowsController@create')->name('windows.create');
    Route::post('windows/create', 'WindowsController@store')->name('windows.store');
    Route::get('windows/edit', 'WindowsController@edit')->name('windows.edit');
    Route::post('windows/edit', 'WindowsController@update')->name('windows.update');
    Route::get('windows/change', 'WindowsController@change')->name('windows.change');
    Route::post('windows/change', 'WindowsController@changeStore')->name('windows.changeStore');
    Route::get('windows/sevenSteps', 'WindowsController@sevenSteps')->name('windows.sevenSteps');
    Route::post('windows/sevenSteps', 'WindowsController@sevenStepsStore')->name('windows.sevenStepsStore');
    Route::get('windows/delete', 'WindowsController@delete')->name('windows.delete');
    Route::post('windows/delete', 'WindowsController@deleteStore')->name('windows.deleteStore');
    Route::get('windows/freeMemory', 'WindowsController@freeMemory')->name('windows.freeMemory');
    Route::post('windows/freeMemory', 'WindowsController@freeMemoryStore')->name('windows.freeMemoryStore');
    Route::get('windows/disable', 'WindowsController@disable')->name('windows.disable');
    Route::post('windows/disable', 'WindowsController@disableStore')->name('windows.disableStore');
    Route::get('windows/extParches', 'WindowsController@extParches')->name('windows.extParches');
    Route::post('windows/extParches', 'WindowsController@extParchesStore')->name('windows.extParchesStore');
    Route::get('windows/inventario', 'WindowsController@inventario')->name('windows.inventario');
    Route::post('windows/inventario', 'WindowsController@inventarioStore')->name('windows.inventarioStore');
    Route::get('windows/checkPaso', 'WindowsController@checkPaso')->name('windows.checkPaso');
    Route::post('windows/checkPaso', 'WindowsController@checkPasoStore')->name('windows.checkPasoStore');
    Route::get('windows/rutasEstaticas', 'WindowsController@rutasEstaticas')->name('windows.rutasEstaticas');
    Route::post('windows/rutasEstaticas', 'WindowsController@rutasEstaticasStore')->name('windows.rutasEstaticasStore');
    Route::get('windows/updateSO', 'WindowsController@updateSO')->name('windows.updateSO');
    Route::post('windows/updateSO', 'WindowsController@updateSOStore')->name('windows.updateSOStore');
    Route::get('windows/checkSO', 'WindowsController@checkSO')->name('windows.checkSO');
    Route::post('windows/checkSO', 'WindowsController@checkSOStore')->name('windows.checkSOStore');
    Route::get('windows/extUptime', 'WindowsController@extUptime')->name('windows.extUptime');
    Route::post('windows/extUptime', 'WindowsController@extUptimeStore')->name('windows.extUptimeStore');
    Route::get('windows/checkAD', 'WindowsController@checkAD')->name('windows.checkAD');
    Route::post('windows/checkAD', 'WindowsController@checkADStore')->name('windows.checkADStore');
    Route::get('windows/preVentana', 'WindowsController@preVentana')->name('windows.preVentana');
    Route::post('windows/preVentana', 'WindowsController@preVentanaStore')->name('windows.preVentanaStore');
    Route::get('windows/postVentana', 'WindowsController@postVentana')->name('windows.postVentana');
    Route::post('windows/postVentana', 'WindowsController@postVentanaStore')->name('windows.postVentanaStore');
    Route::get('windows/serviceManagement', 'WindowsController@serviceManagement')->name('windows.serviceManagement');
    Route::post('windows/serviceManagement', 'WindowsController@serviceManagementStore')->name('windows.serviceManagementStore');
    Route::get('windows/checkCluster', 'WindowsController@checkCluster')->name('windows.checkCluster');
    Route::post('windows/checkCluster', 'WindowsController@checkClusterStore')->name('windows.checkClusterStore');
    Route::get('windows/manageWCompensar', 'WindowsController@manageWCompensar')->name('windows.manageWCompensar');
    Route::post('windows/manageWCompensar', 'WindowsController@manageWCompensarStore')->name('windows.manageWCompensarStore');
    Route::get('windows/manageWConsultas', 'WindowsController@manageWConsultas')->name('windows.manageWConsultas');
    Route::post('windows/manageWConsultas', 'WindowsController@manageWConsultasStore')->name('windows.manageWConsultasStore');
    Route::get('windows/diskCheck', 'WindowsController@diskCheck')->name('windows.diskCheck');
    Route::post('windows/diskCheck', 'WindowsController@diskCheckStore')->name('windows.diskCheckStore');
    Route::get('windows/checkCPUProcess', 'WindowsController@checkCPUProcess')->name('windows.checkCPUProcess');
    Route::post('windows/checkCPUProcess', 'WindowsController@checkCPUProcessStore')->name('windows.checkCPUProcessStore');
    Route::get('windows/debuggingDisks', 'WindowsController@debuggingDisks')->name('windows.debuggingDisks');
    Route::post('windows/debuggingDisks', 'WindowsController@debuggingDisksStore')->name('windows.debuggingDisksStore');
    //nuevo conectividad
    Route::get('windows/connectivity', 'WindowsController@testConectividad')->name('windows.connectivity');
    Route::post('windows/connectivity', 'WindowsController@testConectividadStore')->name('windows.connectivityStore');

    // GETSERVICES

    Route::get('windows/serviceManagementV2', 'WindowsController@serviceManagementV2')->name('windows.servicesManagementV2');
    Route::post('windows/serviceManagementV2', 'WindowsController@serviceManagementStoreV2')->name('windows.serviceManagementV2');
    Route::post('windows/getServicesByHost', 'WindowsController@getServicesByHost')->name('windows.getServicesByHost');
    //activarEnviarLogs
    Route::get('windows/activacionEnvioLogs', 'WindowsController@activacionEnvioLogs')->name('windows.activacionEnvioLogs');
    Route::post('windows/activacionEnvioLogs', 'WindowsController@activacionEnvioLogsStore')->name('windows.activacionEnvioLogsStore');
    Route::post('windows/getListLogNameByHost', 'WindowsController@getListLogNameByHost')->name('windows.getListLogNameByHost');

    // PRUEBAS
    Route::get('pass/windows/getHosts/{inventario}/{grupo}/{method}', 'Pass\WindowsController@getHostsByGroup')->name('pass.windows.getHosts');
    Route::get('pass/windows/services', 'Pass\WindowsController@servicesMejoras')->name('pass.windows.servicesMejoras');
    Route::post('pass/windows/getServicesByHost', 'Pass\WindowsController@getServicesByHost')->name('pass.windows.getServicesByHost');
    Route::post('pass/windows/services', 'Pass\WindowsController@storeServicesMejoras')->name('pass.windows.servicesMejorasStore');

    //Windows Personas y hogares
    Route::get('windowsPH/getHosts/{inventario}/{grupo}/{method}', 'WindowsPHController@getHostsByGroup')->name('windowsPH.getHosts');
    Route::get('windowsPH/restartPoolCom', 'WindowsPHController@restartPoolCom')->name('windowsPH.restartPoolCom');
    Route::post('windowsPH/restartPoolCom', 'WindowsPHController@restartPoolComStore')->name('windowsPH.restartPoolComStore');
    Route::get('windowsPH/restartIISCom', 'WindowsPHController@restartIISCom')->name('windowsPH.restartIISCom');
    Route::post('windowsPH/restartIISCom', 'WindowsPHController@restartIISComStore')->name('windowsPH.restartIISComStore');
    Route::get('windowsPH/restartServicesCom', 'WindowsPHController@restartServicesCom')->name('windowsPH.restartServicesCom');
    Route::post('windowsPH/restartServicesCom', 'WindowsPHController@restartServicesComStore')->name('windowsPH.restartServicesComStore');
    Route::get('windowsPH/updateAtUserAD', 'WindowsPHController@updateAtUserAD')->name('windowsPH.updateAtUserAD');
    Route::post('windowsPH/updateAtUserAD', 'WindowsPHController@updateAtUserADStore')->name('windowsPH.updateAtUserADStore');
    Route::get('windowsPH/reportSWP', 'WindowsPHController@reportSWP')->name('windowsPH.reportSWP');
    Route::post('windowsPH/reportSWP', 'WindowsPHController@reportSWPStore')->name('windowsPH.reportSWPStore');
    Route::get('windowsPH/sharedFolderPer', 'WindowsPHController@sharedFolderPer')->name('windowsPH.sharedFolderPer');
    Route::post('windowsPH/sharedFolderPer', 'WindowsPHController@sharedFolderPerStore')->name('windowsPH.sharedFolderPerStore');
    Route::get('windowsPH/getSharedFolders/{domain}', 'WindowsPHController@getSharedFolders')->name('windowsPH.getSharedFolders');
    Route::resource('windowsPH/winShareFolder', 'WinShareFolderController');
    Route::get('windowsPH/queryKb', 'WindowsPHController@queryKb')->name('windowsPH.queryKb');
    Route::post('windowsPH/queryKb', 'WindowsPHController@queryKbStore')->name('windowsPH.queryKbStore');
    Route::get('windowsPH/checkSO', 'WindowsPHController@checkSO')->name('windowsPH.checkSO');
    Route::post('windowsPH/checkSO', 'WindowsPHController@checkSOStore')->name('windowsPH.checkSOStore');
    Route::get('windowsPH/getCheckSO', 'WindowsPHController@getCheckSO')->name('windowsPH.getCheckSO');
    Route::get('windowsPH/getCheckSOShow/{folder}/{file}', 'WindowsPHController@getCheckSOShow')->name('windowsPH.getCheckSOShow');
    Route::get('windowsPH/getCheckSO/{folder}/{file}', function ($folder, $file) {
        return Storage::disk('fileserver')->response("WINDOWSIT/Win_PH_016/$folder/$file");
    })->name('windowsPH.getCheckSOFile');
    Route::get('windowsPH/localUsersReport', 'WindowsPHController@localUsersReport')->name('windowsPH.localUsersReport');
    Route::post('windowsPH/localUsersReport', 'WindowsPHController@localUsersReportStore')->name('windowsPH.localUsersReportStore');
    Route::get('windowsPH/connectivity', 'WindowsPHController@testConectividadPH')->name('windowsPH.connectivityPH');
    Route::post('windowsPH/connectivity', 'WindowsPHController@testConectividadPHStore')->name('windowsPH.connectivityPHStore');


    // GETSERVICES
    Route::get('windowsPH/serviceManagementV2', 'WindowsPHController@serviceManagementV2')->name('windowsPH.servicesManagementV2');
    Route::post('windowsPH/serviceManagementV2', 'WindowsPHController@serviceManagementStoreV2')->name('windowsPH.serviceManagementV2');
    Route::post('windowsPH/getServicesByHost', 'WindowsPHController@getServicesByHost')->name('windowsPH.getServicesByHost');



    //Unix Empresas y negocios
    Route::get('unix/create', 'UnixController@create')->name('unix.create');
    Route::post('unix/create', 'UnixController@store')->name('unix.store');
    Route::get('unix/createAdm', 'UnixController@createAdm')->name('unix.createAdm');
    Route::post('unix/createAdm', 'UnixController@createAdmStore')->name('unix.createAdmStore');
    Route::get('unix/getHosts/{inventario}/{grupo}/{method}', 'UnixController@getHostsByGroup')->name('unix.getHosts');
    Route::get('unix/sevenSteps', 'UnixController@sevenSteps')->name('unix.sevenSteps');
    Route::post('unix/sevenSteps', 'UnixController@sevenStepsStore')->name('unix.sevenStepsStore');
    Route::get('unix/sevenStepsFreeMemory', 'UnixController@sevenStepsFreeMemory')->name('unix.sevenStepsFreeMemory');
    Route::post('unix/sevenStepsFreeMemory', 'UnixController@sevenStepsFreeMemoryStore')->name('unix.sevenStepsFreeMemoryStore');
    Route::get('unix/change', 'UnixController@change')->name('unix.change');
    Route::post('unix/change', 'UnixController@changeStore')->name('unix.changeStore');
    Route::get('unix/resetUserByAD', 'UnixController@resetUserByAD')->name('unix.resetUserByAD');
    Route::post('unix/resetUserByAD', 'UnixController@resetUserByADStore')->name('unix.resetUserByADStore');
    Route::get('unix/delete', 'UnixController@delete')->name('unix.delete');
    Route::post('unix/delete', 'UnixController@deleteStore')->name('unix.deleteStore');
    Route::get('unix/disable', 'UnixController@disable')->name('unix.disable');
    Route::post('unix/disable', 'UnixController@disableStore')->name('unix.disableStore');
    Route::get('unix/freeMemory', 'UnixController@freeMemory')->name('unix.freeMemory');
    Route::post('unix/freeMemory', 'UnixController@freeMemoryStore')->name('unix.freeMemoryStore');
    Route::get('unix/inventario', 'UnixController@inventario')->name('unix.inventario');
    Route::post('unix/inventario', 'UnixController@inventarioStore')->name('unix.inventarioStore');
    Route::get('unix/checkPaso', 'UnixController@checkPaso')->name('unix.checkPaso');
    Route::post('unix/checkPaso', 'UnixController@checkPasoStore')->name('unix.checkPasoStore');
    Route::get('unix/rutasEstaticas', 'UnixController@rutasEstaticas')->name('unix.rutasEstaticas');
    Route::post('unix/rutasEstaticas', 'UnixController@rutasEstaticasStore')->name('unix.rutasEstaticasStore');
    Route::get('unix/pasoPrevio', 'UnixController@pasoPrevio')->name('unix.pasoPrevio');
    Route::post('unix/pasoPrevio', 'UnixController@pasoPrevioStore')->name('unix.pasoPrevioStore');
    Route::get('unix/pasoPosterior', 'UnixController@pasoPosterior')->name('unix.pasoPosterior');
    Route::post('unix/pasoPosterior', 'UnixController@pasoPosteriorStore')->name('unix.pasoPosteriorStore');
    Route::get('unix/uptime', 'UnixController@uptime')->name('unix.uptime');
    Route::post('unix/uptime', 'UnixController@uptimeStore')->name('unix.uptimeStore');
    Route::get('unix/logrotate', 'UnixController@logrotate')->name('unix.logrotate');
    Route::post('unix/logrotate', 'UnixController@logrotateStore')->name('unix.logrotateStore');
    Route::get('unix/snapSList', 'UnixController@snapSList')->name('unix.snapSList');
    Route::post('unix/snapSList', 'UnixController@snapSListStore')->name('unix.snapSListStore');
    Route::get('unix/snapSolaris', 'UnixController@snapSolaris')->name('unix.snapSolaris');
    Route::post('unix/snapSolaris', 'UnixController@snapSolarisStore')->name('unix.snapSolarisStore');
    Route::get('unix/portListen', 'UnixController@portListen')->name('unix.portListen');
    Route::post('unix/portListen', 'UnixController@portListenStore')->name('unix.portListenStore');
    Route::get('unix/diskManagement', 'UnixController@diskManagement')->name('unix.diskManagement');
    Route::post('unix/diskManagement', 'UnixController@diskManagementStore')->name('unix.diskManagementStore');
    Route::get('unix/folderPermission', 'UnixController@folderPermission')->name('unix.folderPermission');
    Route::post('unix/folderPermission', 'UnixController@folderPermissionStore')->name('unix.folderPermissionStore');
    Route::get('unix/simpana', 'UnixController@simpana')->name('unix.simpana');
    Route::post('unix/simpana', 'UnixController@simpanaStore')->name('unix.simpanaStore');
    Route::get('unix/restartServices', 'UnixController@restartServices')->name('unix.restartServices');
    Route::post('unix/restartServices', 'UnixController@restartServicesStore')->name('unix.restartServicesStore');
    Route::get('unix/cleanFileSystem', 'UnixController@cleanFileSystem')->name('unix.cleanFileSystem');
    Route::post('unix/cleanFileSystem', 'UnixController@cleanFileSystemStore')->name('unix.cleanFileSystemStore');
    Route::get('unix/configLvm', 'UnixController@configLvm')->name('unix.configLvm');
    Route::post('unix/configLvm', 'UnixController@configLvmStore')->name('unix.configLvmStore');
    //nuevo conectividad
    Route::get('unix/connectivity', 'UnixController@testConectividadUnix')->name('unix.connectivityUnix');
    Route::post('unix/connectivity', 'UnixController@testConectividadUnixStore')->name('unix.connectivityUnixStore');
    //activarEnviarLogs
    Route::get('unix/activacionEnvioLogs', 'UnixController@activacionEnvioLogs')->name('unix.activacionEnvioLogs');
    Route::post('unix/activacionEnvioLogs', 'UnixController@activacionEnvioLogsStore')->name('unix.activacionEnvioLogsStore');
    Route::post('unix/getListLogNameByHost', 'UnixController@getListLogNameByHost')->name('unix.getListLogNameByHost');

    //Unix Personas y hogares
    Route::get('unixPH/create', 'UnixPHController@create')->name('unixPH.create');
    Route::post('unixPH/create', 'UnixPHController@store')->name('unixPH.store');
    Route::get('unixPH/getHosts/{inventario}/{grupo}/{method}', 'UnixPHController@getHostsByGroup')->name('unixPH.getHosts');
    Route::get('unixPH/change', 'UnixPHController@change')->name('unixPH.change');
    Route::post('unixPH/change', 'UnixPHController@changeStore')->name('unixPH.changeStore');
    Route::get('unixPH/delete', 'UnixPHController@delete')->name('unixPH.delete');
    Route::post('unixPH/delete', 'UnixPHController@deleteStore')->name('unixPH.deleteStore');
    Route::get('unixPH/unlock', 'UnixPHController@unlock')->name('unixPH.unlock');
    Route::post('unixPH/unlock', 'UnixPHController@unlockStore')->name('unixPH.unlockStore');
    Route::get('unixPH/dnsclaro', 'UnixPHController@dnsclaro')->name('unixPH.dnsclaro');
    Route::post('unixPH/dnsclaro', 'UnixPHController@dnsclaroStore')->name('unixPH.dnsclaroStore');
    Route::get('unixPH/uptimeRelease', 'UnixPHController@uptimeRelease')->name('unixPH.uptimeRelease');
    Route::get('unixPH/uptime', 'UnixPHController@uptime')->name('unixPH.uptime');
    Route::get('unixPH/checkPlatforms', 'UnixPHController@checkPlatforms')->name('unixPH.checkPlatforms');
    Route::get('unixPH/checkPasoUnix', 'UnixPHController@checkPasoUnix')->name('unixPH.checkPasoUnix');
    Route::post('unixPH/checkPasoUnix', 'UnixPHController@checkPasoUnixStore')->name('unixPH.checkPasoUnixStore');
    Route::get('unixPH/sevenStepsPH', 'UnixPHController@checkSOUnix')->name('unixPH.sevenStepsPH');
    Route::post('unixPH/sevenStepsPH', 'UnixPHController@checkSOUnixStore')->name('unixPH.sevenStepsPHStore');
    Route::get('unixPH/prevalidation', 'UnixPHController@prevalidation')->name('unixPH.prevalidation');
    Route::post('unixPH/prevalidation', 'UnixPHController@prevalidationStore')->name('unixPH.prevalidationStore');
    Route::get('unixPH/restart', 'UnixPHController@restart')->name('unixPH.restart');
    Route::post('unixPH/restart', 'UnixPHController@restartStore')->name('unixPH.restartStore');
    Route::get('unixPH/validation', 'UnixPHController@validation')->name('unixPH.validation');
    Route::post('unixPH/validation', 'UnixPHController@validationStore')->name('unixPH.validationStore');
    Route::get('unixPH/uploadDb', 'UnixPHController@uploadDb')->name('unixPH.uploadDb');
    Route::post('unixPH/uploadDb', 'UnixPHController@uploadDbStore')->name('unixPH.uploadDbStore');
    Route::get('unixPH/validationNFSVenecia', 'UnixPHController@validationNFSVenecia')->name('unixPH.validationNFSVenecia');
    Route::post('unixPH/validationNFSVenecia', 'UnixPHController@validationNFSVeneciaStore')->name('unixPH.validationNFSVeneciaStore');
    Route::get('unixPH/connectivity', 'UnixPHController@testConectividadUnixPH')->name('unixPH.connectivityUnixPH');
    Route::post('unixPH/connectivity', 'UnixPHController@testConectividadUnixPHStore')->name('unixPH.connectivityUnixPHStore');
    Route::get('unixPH/UpBashYaml', 'UnixPHController@UpBashYaml')->name('unixPH.UpBashYaml');
    Route::post('unixPH/UpBashYaml', 'UnixPHController@UpBashYamlStore')->name('unixPH.UpBashYamlStore');
    Route::get('unixPH/UpBashYamlLinux', 'UnixPHController@UpBashYamlLinux')->name('unixPH.UpBashYamlLinux');
    Route::post('unixPH/UpBashYamlLinux', 'UnixPHController@UpBashYamlLinuxStore')->name('unixPH.UpBashYamlLinuxStore');
    Route::get('unixPH/UpBashYamlSUN', 'UnixPHController@UpBashYamlSUN')->name('unixPH.UpBashYamlSUN');
    Route::post('unixPH/UpBashYamlSUN', 'UnixPHController@UpBashYamlSUNStore')->name('unixPH.UpBashYamlSUNStore');
    Route::get('unixPH/UpBashYamlAIX', 'UnixPHController@UpBashYamlAIX')->name('unixPH.UpBashYamlAIX');
    Route::post('unixPH/UpBashYamlAIX', 'UnixPHController@UpBashYamlAIXStore')->name('unixPH.UpBashYamlAIXStore');

    //Virtualización
    Route::get('virtualizations/diagnostic', 'VirtualizationController@diagnostic')->name('virtualization.diagnostic');
    Route::get('virtualizations/consumption', 'VirtualizationController@consumption')->name('virtualization.consumption');
    Route::get('virtualizations/loadData', 'VirtualizationController@loadData')->name('virtualization.loadData');
    Route::get('virtualizations/runDiagnostic/{id}/{vcenter}', 'VirtualizationController@runDiag')->name('virtualization.runDiag');
    Route::get('virtualizations/runConsumption/{id}/{vcenter}', 'VirtualizationController@runCon')->name('virtualization.runCon');
    Route::get('virtualizations/reports', 'VirtualizationController@reportIndex')->name('virtualization.reportIndex');
    Route::get('virtualizations/snapshots/create', 'VirtualizationController@snapshot')->name('virtualization.snapshot');
    Route::post('virtualizations/snapshots/create', 'VirtualizationController@snapshotStore')->name('virtualization.snapshotStore');
    Route::get('virtualizations/snapshots/delete', 'VirtualizationController@snapDelete')->name('virtualization.snapDelete');
    Route::post('virtualizations/snapshots/delete', 'VirtualizationController@snapDeleteStore')->name('virtualization.snapDeleteStore');
    Route::get('virtualizations/snapshots/revert', 'VirtualizationController@snapRevert')->name('virtualization.snapRevert');
    Route::post('virtualizations/snapshots/revert', 'VirtualizationController@snapRevertStore')->name('virtualization.snapRevertStore');
    Route::get('virtualizations/operationStep', 'VirtualizationController@operationStep')->name('virtualization.operationStep');
    Route::post('virtualizations/operationStep', 'VirtualizationController@operationStepStore')->name('virtualization.operationStepStore');
    Route::get('virtualizations/inventory', 'VirtualizationController@inventory')->name('virtualization.inventory');
    Route::get('virtualizations/tagMV', 'VirtualizationController@tagMV')->name('virtualization.tagMV');
    Route::post('virtualizations/tagMV', 'VirtualizationController@tagMVStore')->name('virtualization.tagMVStore');
    Route::get('virtualizations/snapshots/schedule', 'VirtualizationController@snapshotSchedule')->name('virtualization.snapshotSchedule');
    Route::post('virtualizations/snapshots/schedule', 'VirtualizationController@snapshotScheduleStore')->name('virtualization.snapshotScheduleStore');
    Route::get('virtualizations/cVMCustomer', 'VirtualizationController@cVMCustomer')->name('virtualization.cVMCustomer');
    Route::post('virtualizations/cVMCustomer', 'VirtualizationController@cVMCustomerStore')->name('virtualization.cVMCustomerStore');
    Route::get('virtualizations/updateVMWT', 'VirtualizationController@updateVMWT')->name('virtualization.updateVMWT');
    Route::post('virtualizations/updateVMWT', 'VirtualizationController@updateVMWTStore')->name('virtualization.updateVMWTStore');
    Route::get('virtualizations/configVM', 'VirtualizationController@configVM')->name('virtualization.configVM');
    Route::get('virtualizations/VMHostReport', 'VirtualizationController@VMHostReport')->name('virtualization.VMHostReport');
    Route::get('virtualizations/VMHBAReport', 'VirtualizationController@VMHBAReport')->name('virtualization.VMHBAReport');
    Route::get('virtualizations/VMNICReport', 'VirtualizationController@VMNICReport')->name('virtualization.VMNICReport');
    Route::get('virtualizations/VMHostReport/{vmHost}', 'VirtualizationController@VMHostShow')->name('virtualization.VMHostShow');
    Route::get('virtualizations/commandExe', 'VirtualizationController@commandExe')->name('virtualization.commandExe');
    Route::post('virtualizations/commandExe', 'VirtualizationController@commandExeStore')->name('virtualization.commandExeStore');
    Route::get('virtualizations/checkHost', 'VirtualizationController@checkHost')->name('virtualization.checkHost');
    Route::post('virtualizations/checkHost', 'VirtualizationController@checkHostStore')->name('virtualization.checkHostStore');
    Route::get('virtualizations/clusterCapacityReport', 'VirtualizationController@clusterCapacityReport')->name('virtualization.clusterCapacityReport');
    Route::post('virtualizations/clusterCapacityReport', 'VirtualizationController@clusterCapacityReportRs')->name('virtualization.clusterCapacityReportRs');
    Route::get('virtualizations/checkVMRepairSearch', 'VirtualizationController@checkVMRepairSearch')->name('virtualization.checkVMRepairSearch');
    Route::get('virtualizations/checkVMRepair/{name}/{id_asgard}', 'VirtualizationController@checkVMRepair')->name('virtualization.checkVMRepair');
    Route::post('virtualizations/checkVMRepairStore', 'VirtualizationController@checkVMRepairStore')->name('virtualization.checkVMRepairStore');
    //Aumento Vcpu, Ram
    Route::get('virtualizations/resourcesUpgrade', 'VirtualizationController@resourcesUpgrade')->name('virtualization.resourcesUpgrade');
    Route::post('virtualizations/resourcesUpgrade', 'VirtualizationController@resourcesUpgradeStore')->name('virtualization.resourcesUpgradeStore');
    Route::get('virtualizations/resourcessnap/create', 'VirtualizationController@resourcessnap')->name('virtualization.resourcessnap');
    //Pruebas virtualizacion script local
    Route::get('virtualizations/diagTest', 'VirtualizationController@diagTest')->name('virtualization.diagTest');
    Route::post('virtualizations/diagTest', 'VirtualizationController@diagTestStore')->name('virtualization.diagTestStore');
    //Cambio de Vlan
    Route::get('virtualizations/vlanUpdate', 'VirtualizationController@vlanUpdate')->name('virtualization.vlanUpdate');
    Route::post('virtualizations/vlanUpdate', 'VirtualizationController@vlanUpdateStore')->name('virtualization.vlanUpdateStore');
    Route::post('virtualizations/vlanTable', 'VirtualizationController@vlanTablePost')->name('virtualization.vlanTablePost');
    Route::get('virtualizations/resourcesVlan/create', 'VirtualizationController@resourcesVlan')->name('virtualization.resourcesVlan');
    //Aumento de Disk
    Route::get('virtualizations/resourcesDisk', 'VirtualizationController@resourcesDisk')->name('virtualization.resourcesDisk');
    Route::post('virtualizations/resourcesDiskStore', 'VirtualizationController@resourcesDiskStore')->name('virtualization.resourcesDiskStore');
    Route::post('virtualizations/resourcesDisk', 'VirtualizationController@DiskTablePost')->name('virtualization.DiskTablePost');
    //Adicion de Disco duro
    Route::get('virtualizations/addHardDisk', 'VirtualizationController@addHardDisk')->name('virtualization.addHardDisk');
    Route::post('virtualizations/addHardDiskStore', 'VirtualizationController@addHardDiskStore')->name('virtualization.addHardDiskStore');
    Route::post('virtualizations/addHardDisk', 'VirtualizationController@DiskTablePost')->name('virtualization.DiskTablePost');
    //Check paso a operacion Cluster
    Route::get('virtualizations/checkHostImple', 'VirtualizationController@checkHostImple')->name('virtualization.checkHostImple');
    Route::post('virtualizations/checkHostImple', 'VirtualizationController@checkHostImpleStore')->name('virtualization.checkHostImpleStore');

    //Convergencia
    Route::get('convergence/citrixProfile', 'ConvergenceController@citrixProfile')->name('convergence.citrixProfile');
    Route::post('convergence/citrixProfile', 'ConvergenceController@citrixProfileStore')->name('convergence.citrixProfileStore');
    Route::get('convergence/hnasReport', 'ConvergenceController@hnasReport')->name('convergence.hnasReport');
    Route::post('convergence/hnasReport', 'ConvergenceController@hnasReportStore')->name('convergence.hnasReportStore');
    //Logs
    Route::resource('executionLogs', 'ExecutionLogController');
    Route::get('executionLogs/getJobStatus/{job}/{executionLog}', 'ExecutionLogController@getJobStatus')->name('ExecutionLog.getJobStatus');
    Route::get('executionLogs/getJobResult/{job}/', 'ExecutionLogController@getJobResult')->name('ExecutionLog.getJobResult');
    Route::get('executionLogs/getJobResult/{job}/{server}', 'ExecutionLogController@getJobResult')->name('ExecutionLog.getJobResultServer');
    Route::get('executionLogs/showRs/{executionLog}', 'ExecutionLogController@showRs')->name('ExecutionLog.showRs');

    //Backups
    Route::get('backup/getHosts/{inventario}/{grupo}/{method}', 'BackupController@getHostsByGroup')->name('backup.getHosts');
    Route::get('backup/checkPWindows', 'BackupController@checkPWindows')->name('backup.checkPWindows');
    Route::post('backup/checkPWindows', 'BackupController@runCheckWindows')->name('backup.runCheckWindows');
    Route::get('backup/checkPUnix', 'BackupController@checkPUnix')->name('backup.checkPUnix');
    Route::post('backup/checkPUnix', 'BackupController@runCheckUnix')->name('backup.runCheckUnix');
    Route::get('backup/vadp', 'BackupController@vadp')->name('backup.vadp');
    Route::post('backup/vadp', 'BackupController@vadpStore')->name('backup.vadpStore');
    Route::get('backup/pingCS02', 'BackupController@pingCS02')->name('backup.pingCS02');
    Route::post('backup/pingCS02', 'BackupController@pingCS02Store')->name('backup.pingCS02Store');
    Route::get('backup/backupTask', 'BackupController@backupTask')->name('backup.backupTask');
    Route::post('backup/backupTask', 'BackupController@backupTaskStore')->name('backup.backupTaskStore');
    Route::get('backup/backupTask/{file}', function ($file) {
        return Storage::response("BKP_DATA/$file");
    })->where([
        'file' => '(.*?)\.(xlsx)$'
    ])->name('backup.backupTaskFile');
    Route::get('backup/scheduleMovil', 'BackupController@scheduleMovil')->name('backup.scheduleMovil');
    Route::post('backup/scheduleMovil', 'BackupController@scheduleMovilStore')->name('backup.scheduleMovilStore');
    Route::get('backup/failedMaster', 'BackupController@failedMaster')->name('backup.failedMaster');
    Route::post('backup/failedMaster', 'BackupController@failedMasterStore')->name('backup.failedMasterStore');
    Route::get('backup/failedMaster/{file}', function ($file) {
        return Storage::response("BKP_DATA/$file");
    })->where([
        'file' => '(.*?)\.(xlsx)$'
    ])->name('backup.failedMasterFile');
    Route::get('backup/jobs', 'BackupController@jobs')->name('backup.jobs');
    Route::post('backup/jobs', 'BackupController@jobStore')->name('backup.jobStore');
    Route::get('backup/jobsRs', 'BackupController@jobStore')->name('backup.jobsRs');
    Route::get('backup/jobsRsFile', 'BackupController@jobStore')->name('backup.jobsRsFile');
    Route::get('backup/jobsRsFile/{file}', function ($file) {
        return Storage::download("results/$file");
    })->where([
        'file' => '(.*?)\.(csv)$'
    ])->name('backup.jobsRsFile');
    Route::get('backup/apiJobs', 'BackupController@apiJobs')->name('backup.apiJobs');

    // backup Doc1 por demanda con modificación de rutas
    Route::get('backup/backupDoc1ModificationOfRoutes', 'BackupController@backupDoc1ModificationOfRoutes')->name('backup.backupDoc1ModificationOfRoutes');
    Route::post('backup/backupDoc1ModificationOfRoutes', 'BackupController@backupDoc1ModificationOfRoutesStore')->name('backup.backupDoc1ModificationOfRoutesStore');

    // politicas de backup - obtiene listado de clientes.
    Route::get('backup/poliBackupClientes', 'BackupController@poliBackupClientes')->name('backup.poliBackupClientes');
    Route::post('backup/poliBackupClientes', 'BackupController@poliBackupClientesStore')->name('backup.poliBackupClientesStore');
    Route::get('backup/pandasBackup', 'BackupController@pandasBackup')->name('backup.pandasBackup');
    //AMT
    Route::get('amt/getHosts/{inventario}/{grupo}/{method}', 'AmtController@getHostsByGroup')->name('amt.getHosts');
    Route::get('amt/soa', 'AmtController@soa')->name('amt.soa');
    Route::post('amt/soa', 'AmtController@soaStore')->name('amt.soaStore');
    Route::get('amt/fuse', 'AmtController@fuse')->name('amt.fuse');
    Route::post('amt/fuse', 'AmtController@fuseStore')->name('amt.fuseStore');
    Route::get('amt/backupFormas', 'AmtController@backupFormas')->name('amt.backupFormas');
    Route::post('amt/backupFormas', 'AmtController@backupFormasStore')->name('amt.backupFormasStore');
    Route::get('amt/movimientoFormas', 'AmtController@movimientoFormas')->name('amt.movimientoFormas');
    Route::post('amt/movimientoFormas', 'AmtController@movimientoFormasStore')->name('amt.movimientoFormasStore');
    Route::get('amt/appTomcatUnix', 'AmtController@appTomcatUnix')->name('amt.appTomcatUnix');
    Route::post('amt/appTomcatUnix', 'AmtController@appTomcatUnixStore')->name('amt.appTomcatUnixStore');
    Route::get('amt/appTomcatWindows', 'AmtController@appTomcatWindows')->name('amt.appTomcatWindows');
    Route::post('amt/appTomcatWindows', 'AmtController@appTomcatWindowsStore')->name('amt.appTomcatWindowsStore');
    Route::get('amt/checkSanidad', 'AmtController@checkSanidad')->name('amt.checkSanidad');
    Route::post('amt/checkSanidad', 'AmtController@checkSanidadStore')->name('amt.checkSanidadStore');
    Route::get('amt/parcheWeblogic', 'AmtController@parcheWeblogic')->name('amt.parcheWeblogic');
    Route::post('amt/parcheWeblogic', 'AmtController@parcheWeblogicStore')->name('amt.parcheWeblogicStore');
    Route::get('amt/webReports', 'AmtController@webReports')->name('amt.webReports');
    Route::post('amt/webReports', 'AmtController@webReportsStore')->name('amt.webReportsStore');
    Route::get('amt/checkPasoTomcat', 'AmtController@checkPasoTomcat')->name('amt.checkPasoTomcat');
    Route::post('amt/checkPasoTomcat', 'AmtController@checkPasoTomcatStore')->name('amt.checkPasoTomcatStore');
    Route::get('amt/healthCheck', 'AmtController@healthCheck')->name('amt.healthCheck');
    Route::post('amt/healthCheck', 'AmtController@healthCheckStore')->name('amt.healthCheckStore');
    Route::get('amt/connectDB', 'AmtController@connectDB')->name('amt.connectDB');
    Route::post('amt/connectDB', 'AmtController@connectDBStore')->name('amt.connectDBStore');
    Route::get('amt/checkPOWebLogic', 'AmtController@checkPOWebLogic')->name('amt.checkPOWebLogic');
    Route::post('amt/checkPOWebLogic', 'AmtController@checkPOWebLogicStore')->name('amt.checkPOWebLogicStore');
    Route::get('amt/appTomcatUnixPCCAAS', 'AmtController@appTomcatUnixPCCAAS')->name('amt.appTomcatUnixPCCAAS');
    Route::post('amt/appTomcatUnixPCCAAS', 'AmtController@appTomcatUnixPCCAASStore')->name('amt.appTomcatUnixPCCAASStore');
    //AMT P&H
    Route::get('amtPH/getHosts/{inventario}/{grupo}/{method}', 'AmtController@getHostsByGroup')->name('amt.getHosts');
    Route::get('amtPH/reinicioDatosComp', 'AmtPHController@reinicioDatosComp')->name('amtPH.reinicioDatosComp');
    Route::post('amtPH/reinicioDatosComp', 'AmtPHController@reinicioDatosCompStore')->name('amtPH.reinicioDatosCompStore');
    Route::get('amtPH/reinicioEscalonado', 'AmtPHController@reinicioEscalonado')->name('amtPH.reinicioEscalonado');
    Route::post('amtPH/reinicioEscalonado', 'AmtPHController@reinicioEscalonadoStore')->name('amtPH.reinicioEscalonadoStore');
    Route::get('amtPH/bajadaDominio', 'AmtPHController@bajadaDominio')->name('amtPH.bajadaDominio');
    Route::post('amtPH/bajadaDominio', 'AmtPHController@bajadaDominioStore')->name('amtPH.bajadaDominioStore');
    Route::get('amtPH/subidaDominio', 'AmtPHController@subidaDominio')->name('amtPH.subidaDominio');
    Route::post('amtPH/subidaDominio', 'AmtPHController@subidaDominioStore')->name('amtPH.subidaDominioStore');
    Route::get('amtPH/estDataSource', 'AmtPHController@estDataSource')->name('amtPH.estDataSource');
    Route::post('amtPH/estDataSource', 'AmtPHController@estDataSourceStore')->name('amtPH.estDataSourceStore');
    Route::get('amtPH/reinicioDomTrafico', 'AmtPHController@reinicioDomTrafico')->name('amtPH.reinicioDomTrafico');
    Route::post('amtPH/reinicioDomTrafico', 'AmtPHController@reinicioDomTraficoStore')->name('amtPH.reinicioDomTraficoStore');
    Route::get('amtPH/reinicioClusterEAP', 'AmtPHController@reinicioClusterEAP')->name('amtPH.reinicioClusterEAP');
    Route::post('amtPH/reinicioClusterEAP', 'AmtPHController@reinicioClusterEAPStore')->name('amtPH.reinicioClusterEAPStore');
    Route::get('amtPH/ESBAlarm', 'AmtPHController@ESBAlarm')->name('amtPH.ESBAlarm');
    Route::post('amtPH/ESBAlarm', 'AmtPHController@ESBAlarmStore')->name('amtPH.ESBAlarmStore');
    Route::get('amtPH/jobPurge', 'AmtPHController@jobPurge')->name('amtPH.jobPurge');
    Route::post('amtPH/jobPurge', 'AmtPHController@jobPurgeStore')->name('amtPH.jobPurgeStore');
    Route::get('amtPH/ITELRestart', 'AmtPHController@ITELRestart')->name('amtPH.ITELRestart');
    Route::post('amtPH/ITELRestart', 'AmtPHController@ITELRestartStore')->name('amtPH.ITELRestartStore');
    Route::get('amtPH/ITELState', 'AmtPHController@ITELState')->name('amtPH.ITELState');
    Route::post('amtPH/ITELState', 'AmtPHController@ITELStateStore')->name('amtPH.ITELStateStore');
    Route::get('amtPH/ITELOsbTriara', 'AmtPHController@ITELOsbTriara')->name('amtPH.ITELOsbTriara');
    Route::post('amtPH/ITELOsbTriara', 'AmtPHController@ITELOsbTriaraStore')->name('amtPH.ITELOsbTriaraStore');
    Route::get('amtPH/stateEAP', 'AmtPHController@stateEAP')->name('amtPH.stateEAP');
    Route::post('amtPH/stateEAP', 'AmtPHController@stateEAPStore')->name('amtPH.stateEAPStore');
    Route::get('amtPH/errorEAP', 'AmtPHController@errorEAP')->name('amtPH.errorEAP');
    Route::post('amtPH/errorEAP', 'AmtPHController@errorEAPStore')->name('amtPH.errorEAPStore');
    Route::get('amtPH/ITELVeneciaDown', 'AmtPHController@ITELVeneciaDown')->name('amtPH.ITELVeneciaDown');
    Route::post('amtPH/ITELVeneciaDown', 'AmtPHController@ITELVeneciaDownStore')->name('amtPH.ITELVeneciaDownStore');
    Route::get('amtPH/ITELVeneciaUp', 'AmtPHController@ITELVeneciaUp')->name('amtPH.ITELVeneciaUp');
    Route::post('amtPH/ITELVeneciaUp', 'AmtPHController@ITELVeneciaUpStore')->name('amtPH.ITELVeneciaUpStore');
    Route::get('amtPH/diagEapBSCS', 'AmtPHController@diagEapBSCS')->name('amtPH.diagEapBSCS');
    Route::post('amtPH/diagEapBSCS', 'AmtPHController@diagEapBSCSStore')->name('amtPH.diagEapBSCSStore');
    Route::get('amtPH/ITELTriaraDown', 'AmtPHController@ITELTriaraDown')->name('amtPH.ITELTriaraDown');
    Route::post('amtPH/ITELTriaraDown', 'AmtPHController@ITELTriaraDownStore')->name('amtPH.ITELTriaraDownStore');
    Route::get('amtPH/ITELTriaraUp', 'AmtPHController@ITELTriaraUp')->name('amtPH.ITELTriaraUp');
    Route::post('amtPH/ITELTriaraUp', 'AmtPHController@ITELTriaraUpStore')->name('amtPH.ITELTriaraUpStore');
    Route::get('amtPH/downSoaTriara', 'AmtPHController@downSoaTriara')->name('amtPH.downSoaTriara');
    Route::post('amtPH/downSoaTriara', 'AmtPHController@downSoaTriaraStore')->name('amtPH.downSoaTriaraStore');
    Route::get('amtPH/ITELTriaraSoaUp', 'AmtPHController@ITELTriaraSoaUp')->name('amtPH.ITELTriaraSoaUp');
    Route::post('amtPH/ITELTriaraSoaUp', 'AmtPHController@ITELTriaraSoaUpStore')->name('amtPH.ITELTriaraSoaUpStore');
    Route::get('amtPH/ITELVeneciaSoaDown', 'AmtPHController@ITELVeneciaSoaDown')->name('amtPH.ITELVeneciaSoaDown');
    Route::post('amtPH/ITELVeneciaSoaDown', 'AmtPHController@ITELVeneciaSoaDownStore')->name('amtPH.ITELVeneciaSoaDownStore');
    Route::get('amtPH/ITELVeneciaSoaUp', 'AmtPHController@ITELVeneciaSoaUp')->name('amtPH.ITELVeneciaSoaUp');
    Route::post('amtPH/ITELVeneciaSoaUp', 'AmtPHController@ITELVeneciaSoaUpStore')->name('amtPH.ITELVeneciaSoaUpStore');
    Route::get('amtPH/ITELTriaraAprovDown', 'AmtPHController@ITELTriaraAprovDown')->name('amtPH.ITELTriaraAprovDown');
    Route::post('amtPH/ITELTriaraAprovDown', 'AmtPHController@ITELTriaraAprovDownStore')->name('amtPH.ITELTriaraAprovDownStore');
    Route::get('amtPH/ITELTriaraAprovUp', 'AmtPHController@ITELTriaraAprovUp')->name('amtPH.ITELTriaraAprovUp');
    Route::post('amtPH/ITELTriaraAprovUp', 'AmtPHController@ITELTriaraAprovUpStore')->name('amtPH.ITELTriaraAprovUpStore');
    Route::get('amtPH/downCloudVenecia', 'AmtPHController@downCloudVenecia')->name('amtPH.downCloudVenecia');
    Route::post('amtPH/downCloudVenecia', 'AmtPHController@downCloudVeneciaStore')->name('amtPH.downCloudVeneciaStore');
    Route::get('amtPH/upCloudVenecia', 'AmtPHController@upCloudVenecia')->name('amtPH.upCloudVenecia');
    Route::post('amtPH/upCloudVenecia', 'AmtPHController@upCloudVeneciaStore')->name('amtPH.upCloudVeneciaStore');
    Route::get('amtPH/downCloudTriara', 'AmtPHController@downCloudTriara')->name('amtPH.downCloudTriara');
    Route::post('amtPH/downCloudTriara', 'AmtPHController@downCloudTriaraStore')->name('amtPH.downCloudTriaraStore');
    Route::get('amtPH/upCloudTriara', 'AmtPHController@upCloudTriara')->name('amtPH.upCloudTriara');
    Route::post('amtPH/upCloudTriara', 'AmtPHController@upCloudTriaraStore')->name('amtPH.upCloudTriaraStore');
    Route::get('amtPH/ReinicioOperinspEsb', 'AmtPHController@ReinicioOperinspEsb')->name('amtPH.ReinicioOperinspEsb');
    Route::post('amtPH/ReinicioOperinspEsb', 'AmtPHController@ReinicioOperinspEsbStore')->name('amtPH.ReinicioOperinspEsbStore');
    Route::get('amtPH/InspEocecmBajar', 'AmtPHController@InspEocecmBajar')->name('amtPH.InspEocecmBajar');
    Route::post('amtPH/InspEocecmBajar', 'AmtPHController@InspEocecmBajarStore')->name('amtPH.InspEocecmBajarStore');
    Route::get('amtPH/InspEocecmSubir', 'AmtPHController@InspEocecmSubir')->name('amtPH.InspEocecmSubir');
    Route::post('amtPH/InspEocecmSubir', 'AmtPHController@InspEocecmSubirStore')->name('amtPH.InspEocecmSubirStore');

    //AMT P&H IT
    Route::get('amtPHIT/getHosts/{inventario}/{grupo}/{method}', 'AmtController@getHostsByGroup')->name('amt.getHosts');
    Route::get('amtPHIT/depLogsGlasfish', 'AmtPHITController@depLogsGlasfish')->name('amtPHIT.depLogsGlasfish');
    Route::post('amtPHIT/depLogsGlasfish', 'AmtPHITController@depLogsGlasfishStore')->name('amtPHIT.depLogsGlasfishStore');
    Route::get('amtPHIT/despliegueVentas', 'AmtPHITController@despliegueVentas')->name('amtPHIT.despliegueVentas');
    Route::post('amtPHIT/despliegueVentas', 'AmtPHITController@despliegueVentasStore')->name('amtPHIT.despliegueVentasStore');
    Route::get('amtPHIT/desplieguePCML', 'AmtPHITController@desplieguePCML')->name('amtPHIT.desplieguePCML');
    Route::post('amtPHIT/desplieguePCML', 'AmtPHITController@desplieguePCMLStore')->name('amtPHIT.desplieguePCMLStore');
    Route::get('amtPHIT/reinicioAgendamiento', 'AmtPHITController@reinicioAgendamiento')->name('amtPHIT.reinicioAgendamiento');
    Route::post('amtPHIT/reinicioAgendamiento', 'AmtPHITController@reinicioAgendamientoStore')->name('amtPHIT.reinicioAgendamientoStore');
    Route::get('amtPHIT/papAgendamiento', 'AmtPHITController@papAgendamiento')->name('amtPHIT.papAgendamiento');
    Route::post('amtPHIT/papAgendamiento', 'AmtPHITController@papAgendamientoStore')->name('amtPHIT.papAgendamientoStore');
    Route::get('amtPHIT/despliegueMC', 'AmtPHITController@despliegueMC')->name('amtPHIT.despliegueMC');
    Route::post('amtPHIT/despliegueMC', 'AmtPHITController@despliegueMCStore')->name('amtPHIT.despliegueMCStore');
    Route::get('amtPHIT/depFileSystem', 'AmtPHITController@depFileSystem')->name('amtPHIT.depFileSystem');
    Route::post('amtPHIT/depFileSystem', 'AmtPHITController@depFileSystemStore')->name('amtPHIT.depFileSystemStore');
    Route::get('amtPHIT/depFileWebService', 'AmtPHITController@depFileWebService')->name('amtPHIT.depFileWebService');
    Route::post('amtPHIT/depFileWebService', 'AmtPHITController@depFileWebServiceStore')->name('amtPHIT.depFileWebServiceStore');
    Route::get('amtPHIT/desplieguePostVenta', 'AmtPHITController@desplieguePostVenta')->name('amtPHIT.desplieguePostVenta');
    Route::post('amtPHIT/desplieguePostVenta', 'AmtPHITController@desplieguePostVentaStore')->name('amtPHIT.desplieguePostVentaStore');
    Route::get('amtPHIT/reinicioWebService', 'AmtPHITController@reinicioWebService')->name('amtPHIT.reinicioWebService');
    Route::post('amtPHIT/reinicioWebService', 'AmtPHITController@reinicioWebServiceStore')->name('amtPHIT.reinicioWebServiceStore');
    Route::get('amtPHIT/ventaTecnica', 'AmtPHITController@ventaTecnica')->name('amtPHIT.ventaTecnica');
    Route::post('amtPHIT/ventaTecnica', 'AmtPHITController@ventaTecnicaStore')->name('amtPHIT.ventaTecnicaStore');
    Route::get('amtPHIT/reinicioVisor', 'AmtPHITController@reinicioVisor')->name('amtPHIT.reinicioVisor');
    Route::post('amtPHIT/reinicioVisor', 'AmtPHITController@reinicioVisorStore')->name('amtPHIT.reinicioVisorStore');
    Route::get('amtPHIT/despCallCenter', 'AmtPHITController@despCallCenter')->name('amtPHIT.despCallCenter');
    Route::post('amtPHIT/despCallCenter', 'AmtPHITController@despCallCenterStore')->name('amtPHIT.despCallCenterStore');
    Route::get('amtPHIT/woService', 'AmtPHITController@woService')->name('amtPHIT.woService');
    Route::post('amtPHIT/woService', 'AmtPHITController@woServiceStore')->name('amtPHIT.woServiceStore');
    Route::get('amtPHIT/diagnosticMC', 'AmtPHITController@diagnosticMC')->name('amtPHIT.diagnosticMC');
    Route::post('amtPHIT/diagnosticMC', 'AmtPHITController@diagnosticMCStore')->name('amtPHIT.diagnosticMCStore');

    //Balanceadores
    Route::get('balancers/getHosts/{inventario}/{grupo}/{method}', 'BalancerController@getHostsByGroup')->name('balancers.getHosts');
    Route::get('balancers/nodoF5', 'BalancerController@nodoF5')->name('balancers.nodoF5');
    Route::post('balancers/nodoF5', 'BalancerController@nodoF5Store')->name('balancers.nodoF5Store');
    Route::get('balancers/nodoNS', 'BalancerController@nodoNS')->name('balancers.nodoNS');
    Route::post('balancers/nodoNS', 'BalancerController@nodoNSStore')->name('balancers.nodoNSStore');
    Route::get('balancers/snatF5', 'BalancerController@snatF5')->name('balancers.snatF5');
    Route::post('balancers/snatF5', 'BalancerController@snatF5Store')->name('balancers.snatF5Store');
    Route::get('balancers/adminPuertosF5', 'BalancerController@adminPuertosF5')->name('balancers.adminPuertosF5');
    Route::post('balancers/adminPuertosF5', 'BalancerController@adminPuertosF5Store')->name('balancers.adminPuertosF5Store');
    Route::get('balancers/addVSF5', 'BalancerController@addVSF5')->name('balancers.addVSF5');
    Route::post('balancers/addVSF5', 'BalancerController@addVSF5Store')->name('balancers.addVSF5Store');
    Route::get('balancers/servicioNS', 'BalancerController@servicioNS')->name('balancers.servicioNS');
    Route::post('balancers/servicioNS', 'BalancerController@servicioNSStore')->name('balancers.servicioNSStore');
    Route::get('balancers/grupoServicioNS', 'BalancerController@grupoServicioNS')->name('balancers.grupoServicioNS');
    Route::post('balancers/grupoServicioNS', 'BalancerController@grupoServicioNSStore')->name('balancers.grupoServicioNSStore');
    Route::get('balancers/addVSNS', 'BalancerController@addVSNS')->name('balancers.addVSNS');
    Route::post('balancers/addVSNS', 'BalancerController@addVSNSStore')->name('balancers.addVSNSStore');
    Route::get('balancers/uptimeF5', 'BalancerController@uptimeF5')->name('balancers.uptimeF5');
    Route::post('balancers/uptimeF5', 'BalancerController@uptimeF5Store')->name('balancers.uptimeF5Store');
    Route::get('balancers/getBalancers/{ip}', 'BalancerController@getBalancers')->name('balancers.getBalancers');
    Route::get('balancers/getPools/{ip}', 'BalancerController@getPools')->name('balancers.getPools');
    Route::get('balancers/getBalancerState/{ip}', 'BalancerController@getBalancerState')->name('balancers.getBalancerState');
    Route::get('balancers/perfilSSLF5', 'BalancerController@perfilSSLF5')->name('balancers.perfilSSLF5');
    Route::post('balancers/perfilSSLF5', 'BalancerController@perfilSSLF5Store')->name('balancers.perfilSSLF5Store');
    Route::get('balancers/requestF5', 'BalancerController@requestF5')->name('balancers.requestF5');
    Route::post('balancers/requestF5', 'BalancerController@requestF5Store')->name('balancers.requestF5Store');
    Route::get('balancers/requestNS', 'BalancerController@requestNS')->name('balancers.requestNS');
    Route::post('balancers/requestNS', 'BalancerController@requestNSStore')->name('balancers.requestNSStore');
    Route::get('balancers/sslCertNS', 'BalancerController@sslCertNS')->name('balancers.sslCertNS');
    Route::post('balancers/sslCertNS', 'BalancerController@sslCertNSStore')->name('balancers.sslCertNSStore');
    Route::get('balancers/healthCheckNS', 'BalancerController@healthCheckNS')->name('balancers.healthCheckNS');
    Route::post('balancers/healthCheckNS', 'BalancerController@healthCheckNSStore')->name('balancers.healthCheckNSStore');
    Route::get('balancers/healthCheckF5', 'BalancerController@healthCheckF5')->name('balancers.healthCheckF5');
    Route::post('balancers/healthCheckF5', 'BalancerController@healthCheckF5Store')->name('balancers.healthCheckF5Store');
    Route::get('balancers/nodosGTMF5', 'BalancerController@nodosGTMF5')->name('balancers.nodosGTMF5');
    Route::post('balancers/nodosGTMF5', 'BalancerController@nodosGTMF5Store')->name('balancers.nodosGTMF5Store');
    Route::get('balancers/addServiceMemberNS', 'BalancerController@addServiceMemberNS')->name('balancers.addServiceMemberNS');
    Route::post('balancers/addServiceMemberNS', 'BalancerController@addServiceMemberNSStore')->name('balancers.addServiceMemberNSStore');
    Route::get('balancers/addServerNS', 'BalancerController@addServerNS')->name('balancers.addServerNS');
    Route::post('balancers/addServerNS', 'BalancerController@addServerNSStore')->name('balancers.addServerNSStore');
    Route::get('balancers/reportMemberLB', 'BalancerController@reportMemberLB')->name('balancers.reportMemberLB');
    Route::post('balancers/reportMemberLB', 'BalancerController@reportMemberLBStore')->name('balancers.reportMemberLBStore');
    Route::get('balancers/reportInventoryLB', 'BalancerController@reportInventoryLB')->name('balancers.reportInventoryLB');
    Route::post('balancers/reportInventoryLB', 'BalancerController@reportInventoryLBStore')->name('balancers.reportInventoryLBStore');
    Route::get('balancers/visorMobile', 'BalancerController@visorMobile')->name('balancers.visorMobile');
    Route::post('balancers/visorMobile', 'BalancerController@visorMobileStore')->name('balancers.visorMobileStore');
    Route::get('balancers/visorUnique', 'BalancerController@visorUnique')->name('balancers.visorUnique');
    Route::post('balancers/visorUnique', 'BalancerController@visorUniqueStore')->name('balancers.visorUniqueStore');
    Route::get('balancers/addSnipNS', 'BalancerController@addSnipNS')->name('balancers.addSnipNS');
    Route::post('balancers/addSnipNS', 'BalancerController@addSnipNSStore')->name('balancers.addSnipNSStore');
    Route::get('balancers/addVlanSelfipF5', 'BalancerController@addVlanSelfipF5')->name('balancers.addVlanSelfipF5');
    Route::post('balancers/addVlanSelfipF5', 'BalancerController@addVlanSelfipF5Store')->name('balancers.addVlanSelfipF5Store');
    Route::get('balancers/stateTennis', 'BalancerController@stateTennis')->name('balancers.stateTennis');
    Route::post('balancers/stateTennis', 'BalancerController@stateTennisStore')->name('balancers.stateTennisStore');
    // USE VIEW 135
    Route::get('balancers/addVlanCitrix', 'BalancerController@addVlanCitrix')->name('balancers.addVlanCitrix');
    Route::post('balancers/addVlanCitrix', 'BalancerController@addVlanCitrixStore')->name('balancers.addVlanCitrixStore');
    //servFiduoccNS
    Route::get('balancers/servFiduoccNS', 'BalancerController@servFiduoccNS')->name('balancers.servFiduoccNS');
    Route::post('balancers/servFiduoccNS', 'BalancerController@servFiduoccNsStore')->name('balancers.servFiduoccNsStore');
    //servFiduBogota
    Route::get('balancers/servFiduBogota', 'BalancerController@servFiduBogota')->name('balancers.servFiduBogota');
    Route::post('balancers/servFiduBogota', 'BalancerController@servFiduBogotaStore')->name('balancers.servFiduBogotaStore');
    //servServPostalesNac
    Route::get('balancers/servServPostalesNac', 'BalancerController@servServPostalesNac')->name('balancers.servServPostalesNac');
    Route::post('balancers/servServPostalesNac', 'BalancerController@servServPostalesNacStore')->name('balancers.servServPostalesNacStore');
    //SerCristalNs
    Route::get('balancers/SerCristalNs', 'BalancerController@SerCristalNs')->name('balancers.SerCristalNs');
    Route::post('balancers/SerCristalNs', 'BalancerController@SerCristalNsStore')->name('balancers.SerCristalNsStore');
    //ServEditorialTiempo
    Route::get('balancers/ServEditorialTiempo', 'BalancerController@ServEditorialTiempo')->name('balancers.SerCristalNs');
    Route::post('balancers/ServEditorialTiempo', 'BalancerController@ServEditorialTiempoStore')->name('balancers.ServEditorialTiempoStore');
    //ServConsorcio
    Route::get('balancers/ServConsorcio', 'BalancerController@ServConsorcio')->name('balancers.ServConsorcio');
    Route::post('balancers/ServConsorcio', 'BalancerController@ServConsorcioStore')->name('balancers.ServConsorcioStore');

    // ruta test
    Route::get('balancers/testbranch', 'BalancerController@testbranch')->name('balancers.testbranch');

    //Implementación Interna
    Route::get('implementations/getHosts/{inventario}/{grupo}/{method}', 'ImplementationController@getHostsByGroup')->name('implementations.getHosts');
    Route::get('implementations/normalizacionW', 'ImplementationController@normalizacionW')->name('implementations.normalizacionW');
    Route::post('implementations/normalizacionW', 'ImplementationController@normalizacionWStore')->name('implementations.normalizacionWStore');
    Route::get('implementations/hardeningW', 'ImplementationController@hardeningW')->name('implementations.hardeningW');
    Route::post('implementations/hardeningW', 'ImplementationController@hardeningWStore')->name('implementations.hardeningWStore');
    Route::get('implementations/licenciamientoW', 'ImplementationController@licenciamientoW')->name('implementations.licenciamientoW');
    Route::post('implementations/licenciamientoW', 'ImplementationController@licenciamientoWStore')->name('implementations.licenciamientoWStore');
    Route::get('implementations/tetrationW', 'ImplementationController@tetrationW')->name('implementations.tetrationW');
    Route::post('implementations/tetrationW', 'ImplementationController@tetrationWStore')->name('implementations.tetrationWStore');
    Route::get('implementations/checkPasoW', 'ImplementationController@checkPasoW')->name('implementations.checkPasoW');
    Route::post('implementations/checkPasoW', 'ImplementationController@checkPasoWStore')->name('implementations.checkPasoWStore');
    Route::get('implementations/antivirusW', 'ImplementationController@antivirusW')->name('implementations.antivirusW');
    Route::post('implementations/antivirusW', 'ImplementationController@antivirusWStore')->name('implementations.antivirusWStore');
    Route::get('implementations/checkPasoWin', 'ImplementationController@checkPasoWin')->name('implementations.checkPasoWin');
    Route::post('implementations/checkPasoWin', 'ImplementationController@checkPasoWinStore')->name('implementations.checkPasoWinStore');
    Route::get('implementations/checkPasoUnix', 'ImplementationController@checkPasoUnix')->name('implementations.checkPasoUnix');
    Route::post('implementations/checkPasoUnix', 'ImplementationController@checkPasoUnixStore')->name('implementations.checkPasoUnixStore');
    Route::get('implementations/hardeningUnix', 'ImplementationController@hardeningUnix')->name('implementations.hardeningUnix');
    Route::post('implementations/hardeningUnix', 'ImplementationController@hardeningUnixStore')->name('implementations.hardeningUnixStore');
    // Seguridad Administrada
    Route::get('managedSecurity/getHosts/{inventario}/{grupo}/{method}', 'ManagedSecurityController@getHostsByGroup')->name('managedSecurity.getHosts');
    Route::get('managedSecurity/instAVDSUnix', 'ManagedSecurityController@instAVDSUnix')->name('managedSecurity.instAVDSUnix');
    Route::post('managedSecurity/instAVDSUnix', 'ManagedSecurityController@instAVDSUnixStore')->name('managedSecurity.instAVDSUnixStore');
    Route::get('managedSecurity/instAVDSWin', 'ManagedSecurityController@instAVDSWin')->name('managedSecurity.instAVDSWin');
    Route::post('managedSecurity/instAVDSWin', 'ManagedSecurityController@instAVDSWinStore')->name('managedSecurity.instAVDSWinStore');
    Route::get('managedSecurity/blacklistNotVdom', 'ManagedSecurityController@blacklistNotVdom')->name('managedSecurity.blacklistNotVdom');
    Route::post('managedSecurity/blacklistNotVdom', 'ManagedSecurityController@blacklistNotVdomStore')->name('managedSecurity.blacklistNotVdomStore');
    Route::get('managedSecurity/blacklistNotVdom/{file}', function ($file) {
        return Storage::response("SECURITY/$file");
    })->name('managedSecurity.blacklistNotVdomFile');
    Route::get('managedSecurity/blacklistVdom', 'ManagedSecurityController@blacklistVdom')->name('managedSecurity.blacklistVdom');
    Route::post('managedSecurity/blacklistVdom', 'ManagedSecurityController@blacklistVdomStore')->name('managedSecurity.blacklistVdomStore');
    Route::get('managedSecurity/blacklistVdom/{file}', function ($file) {
        return Storage::response("SECURITY/$file");
    })->name('managedSecurity.blacklistVdomFile');
    //Reportes
    Route::get('reports/getLayers/{id}', 'ReportController@getLayers')->name('reports.getLayers');
    Route::get('reports/getVcenter/{id}', 'ReportController@getVcenter')->name('reports.getVcenter');
    Route::get('reports/getDatacenter/{id}', 'ReportController@getDatacenter')->name('reports.getDatacenter');
    Route::get('reports/getCluster/{id}', 'ReportController@getCluster')->name('reports.getCluster');
    Route::get('reports/getdatastore/{id}', 'ReportController@getdatastore')->name('reports.getdatastore');
    Route::get('reports/getvmhost/{id}', 'ReportController@getvmhost')->name('reports.getvmhost');
    Route::get('reports/getvm/{id}', 'ReportController@getvm')->name('reports.getvm');
    Route::get('reports/automation', 'ReportController@automation')->name('reports.automation');
    Route::get('reports/rdr', 'ReportController@rdr')->name('reports.rdr');
    Route::get('reports/rdrReport', 'ReportController@getRdrReport')->name('reports.rdrReport');
    Route::get('reports/taskLogs', 'ReportController@taskLogs')->name('reports.tasklogs');
    Route::get('reports/taskLogsReport', 'ReportController@getTaskLogsReport')->name('reports.taskLogsReport');
    //Reportes Virtualizacion
    Route::get('reports/virtualization', 'ReportController@getReportsVirtualization')->name('reports/virtualization');
    Route::get('reports/reportVirtualization', 'ReportController@getRepFilterVirtualization')->name('reports/reportVirtualization');
    Route::get('reports/getGenerateReportVirt', 'ReportController@getGenerateReportVirt')->name('reports.getGenerateReportVirt');
    Route::get('reports/getRepGralVirtualization', 'ReportController@getRepGralVirtualization')->name('reports.getGenerateReporGral');
    //Trabajos programados
    Route::resource('jobSchedules', 'JobScheduleController')->only('show');
    //Herramientas Externas
    Route::resource('externalToolLogs', 'ExternalToolLogController')->only('index', 'show');
    //Redes Transversal
    Route::get('networking/getHosts/{inventario}/{grupo}/{method}', 'NetworkingController@getHostsByGroup')->name('networking.getHosts');
    Route::get('networking/valUptime', 'NetworkingController@valUptime')->name('networking.valUptime');
    Route::post('networking/valUptime', 'NetworkingController@valUptimeStore')->name('networking.valUptimeStore');
    Route::get('networking/checkInventario', 'NetworkingController@checkInventario')->name('networking.checkInventario');
    Route::post('networking/checkInventario', 'NetworkingController@checkInventarioStore')->name('networking.checkInventarioStore');
    Route::get('networking/macSearchPC', 'NetworkingController@macSearchPC')->name('networking.macSearchPC');
    Route::post('networking/macSearchPC', 'NetworkingController@macSearchPCStore')->name('networking.macSearchPCStore');
    Route::get('networking/tShootCAV', 'NetworkingController@tShootCAV')->name('networking.tShootCAV');
    Route::post('networking/tShootCAV', 'NetworkingController@tShootCAVStore')->name('networking.tShootCAVStore');
    //Redes Pymes
    Route::get('networkingPymes/getHosts/{inventario}/{grupo}/{method}', 'NetworkingPymesController@getHostsByGroup')->name('networkingPymes.getHosts');
    Route::get('networkingPymes/restartGaoke', 'NetworkingPymesController@restartGaoke')->name('networkingPymes.restartGaoke');
    Route::post('networkingPymes/restartGaoke', 'NetworkingPymesController@restartGaokeStore')->name('networkingPymes.restartGaokeStore');
    Route::get('networkingPymes/updateGaoke', 'NetworkingPymesController@updateGaoke')->name('networkingPymes.updateGaoke');
    Route::post('networkingPymes/updateGaoke', 'NetworkingPymesController@updateGaokeStore')->name('networkingPymes.updateGaokeStore');


    // SAN Transversal
    Route::get('san/queries/portState', 'SanController@portState')->name('san.portState');
    Route::post('san/queries/portState', 'SanController@portStateStore')->name('san.portStateStore');
    Route::get('san/queries/WWNSearch', 'SanController@WWNSearch')->name('san.WWNSearch');
    Route::post('san/queries/WWNSearch', 'SanController@WWNSearchStore')->name('san.WWNSearchStore');
    Route::get('san/queries/ZoneSearch', 'SanController@ZoneSearch')->name('san.ZoneSearch');
    Route::post('san/queries/ZoneSearch', 'SanController@ZoneSearchStore')->name('san.ZoneSearchStore');
    Route::get('san/queries/wwnNaa', 'SanController@wwnNaa')->name('san.wwnNaa');
    Route::post('san/queries/wwnNaa', 'SanController@wwnNaaStore')->name('san.wwnNaaStore');
    Route::resource('san/inventories/sanSwitch', 'SanSwitchController');
    Route::resource('san/inventories/sanStorage', 'SanStorageController');
    Route::resource('san/inventories/sanServer', 'SanServerController');
    Route::resource('san/inventories/sanNas', 'SanNasController');
    Route::get('san/inventories/sanPorts/list', 'SanPortController@list')->name('sanPorts.list');
    Route::get('san/inventories/sanPorts/report', 'SanPortController@report')->name('sanPorts.report');
    Route::get('san/inventories/sanPorts/list/getPorts', 'SanPortController@getPorts')->name('sanPorts.getPorts');
    Route::resource('san/inventories/sanPorts', 'SanPortController')->except(['create', 'store']);
    Route::resource('san/inventories/sanLink', 'SanLinkController')->except('show');
    Route::resource('san/inventories/sanLun', 'SanLunController')->only('index');
    Route::get('san/admin/fabric', 'SanController@fabricCommand')->name('san.fabricCommand');
    Route::post('san/admin/fabric', 'SanController@fabricCommandStore')->name('san.fabricCommandStore');
    Route::get('san/admin/sanExtend', 'SanController@sanExtend')->name('san.sanExtend');
    Route::get('san/admin/portsReport', 'SanPortsReportController@index')->name('san.portsReport');
    Route::post('san/admin/portsReport', 'SanPortsReportController@store')->name('san.portsReportStore');
    Route::get('san/admin/portsReportShow', 'SanPortsReportController@show')->name('san.portsReportShow');
    Route::get('san/admin/configPortReport', 'SanPortsReportController@edit')->name('san.configPortReport');
    Route::post('san/admin/configPortReport', 'SanPortsReportController@update')->name('san.configPortReportStore');

    // Telefonia
    Route::get('telephony/logUserAvaya', 'TelephonyController@logUserAvaya')->name('telephony.logUserAvaya');
    //////SOM
    Route::get('som/reportesom', 'SomController@reportesom')->name('som.reportesom');
    /////Analytics
    Route::get('analytics/central', 'CentralController@commvault')->name('analytics.central');

    /////Cloud
    Route::get('cloud/serviceRestart', 'CloudController@serviceRestart')->name('cloud.serviceRestart');
    Route::post('cloud/serviceRestart', 'CloudController@serviceRestartStore')->name('cloud.serviceRestartStore');
    Route::get('cloud/accountAdd', 'CloudApiAccountController@accountAdd')->name('cloud.accountAdd');
    Route::post('cloud/accountAdd', 'CloudApiAccountController@accountAddStore')->name('cloud.accountAddStore');

    //Operadores
    Route::get('operators/opeReport', 'OperatorController@opeReport')->name('operators.opeReport');
    Route::post('operators/opeReport', 'OperatorController@opeReportStore')->name('operators.opeReportStore');
    Route::get('operators/opeReport/{file}', function ($file) {
        return Storage::response("IRE_DATA/$file");
    })->name('operators.opeReportFile');

    // Soporte transversal PH
    Route::get('supportPH/linux/getHosts/{inventario}/{grupo}/{method}', 'SupportPHController@getHostsByGroup')->name('supportPHUnix.getHosts');
    Route::get('supportPH/windows/getHosts/{inventario}/{grupo}/{method}', 'SupportPHController@getHostsByGroup')->name('supportPHWindows.getHosts');
    Route::get('supportPH/linux/checkUnixPH', 'SupportPHController@checkSOUnix')->name('supportPH.checkUnixPH');
    Route::post('supportPH/linux/checkUnixPH', 'SupportPHController@checkSOUnixStore')->name('supportPH.checkUnixPHStore');
    Route::get('supportPH/windows/checkWindowsPH', 'SupportPHController@checkSOWindows')->name('supportPH.checkWindowsPH');
    Route::post('supportPH/windows/checkWindowsPH', 'SupportPHController@checkSOWindowsStore')->name('supportPH.checkWindowsPHStore');
    Route::get('supportPH/windows/checkAD', 'SupportPHController@checkAD')->name('supportPH.checkAD');
    Route::post('supportPH/windows/checkAD', 'SupportPHController@checkADStore')->name('supportPH.checkADStore');
    Route::get('supportPH/windows/serviceManagementV2', 'SupportPHController@serviceManagementV2')->name('supportPH.servicesManagementV2');
    Route::post('supportPH/windows/serviceManagementV2', 'SupportPHController@serviceManagementStoreV2')->name('supportPH.serviceManagementV2');
    Route::post('supportPH/windows/getServicesByHost', 'SupportPHController@getServicesByHost')->name('supportPH.getServicesByHost');

    // Soporte transversal EN
    Route::get('supportEN/windows/getHosts/{inventario}/{grupo}/{method}', 'SupportENController@getHostsByGroup')->name('supportENWindows.getHosts');
    Route::get('supportEN/windows/checkAD', 'SupportENController@checkAD')->name('supportEN.checkAD');
    Route::post('supportEN/windows/checkAD', 'SupportENController@checkADStore')->name('supportEN.checkADStore');
    Route::get('supportEN/windows/checkCPUProcess', 'SupportENController@checkCPUProcess')->name('supportEN.checkCPUProcess');
    Route::post('supportEN/windows/checkCPUProcess', 'SupportENController@checkCPUProcessStore')->name('supportEN.checkCPUProcessStore');
    Route::get('supportEN/windows/checkSO', 'SupportENController@checkSO')->name('supportEN.checkSO');
    Route::post('supportEN/windows/checkSO', 'SupportENController@checkSOStore')->name('supportEN.checkSOStore');
    Route::get('supportEN/windows/preVentana', 'SupportENController@preVentana')->name('supportEN.preVentana');
    Route::post('supportEN/windows/preVentana', 'SupportENController@preVentanaStore')->name('supportEN.preVentanaStore');
    Route::get('supportEN/windows/postVentana', 'SupportENController@postVentana')->name('supportEN.postVentana');
    Route::post('supportEN/windows/postVentana', 'SupportENController@postVentanaStore')->name('supportEN.postVentanaStore');
    Route::get('supportEN/windows/freeMemory', 'SupportENController@freeMemory')->name('supportEN.freeMemory');
    Route::post('supportEN/windows/freeMemory', 'SupportENController@freeMemoryStore')->name('supportEN.freeMemoryStore');
    Route::get('supportEN/windows/debuggingDisks', 'SupportENController@debuggingDisks')->name('supportEN.debuggingDisks');
    Route::post('supportEN/windows/debuggingDisks', 'SupportENController@debuggingDisksStore')->name('supportEN.debuggingDisksStore');
    Route::get('supportEN/windows/sevenSteps', 'SupportENController@sevenSteps')->name('supportEN.sevenSteps');
    Route::post('supportEN/windows/sevenSteps', 'SupportENController@sevenStepsStore')->name('supportEN.sevenStepsStore');
    Route::get('supportEN/windows/createUser', 'SupportENController@createUser')->name('supportEN.createUser');
    Route::post('supportEN/windows/createUser', 'SupportENController@createUserStore')->name('supportEN.createUserStore');
    Route::get('supportEN/windows/changeUser', 'SupportENController@changePassUser')->name('supportEN.changePassUser');
    Route::post('supportEN/windows/changeUser', 'SupportENController@changePassUserStore')->name('supportEN.changePassUserStore');
    Route::get('supportEN/windows/disableUser', 'SupportENController@disableUser')->name('supportEN.disableUser');
    Route::post('supportEN/windows/disableUser', 'SupportENController@disableUserStore')->name('supportEN.disableUserStore');
    Route::get('supportEN/windows/deleteUser', 'SupportENController@deleteUser')->name('supportEN.deleteUser');
    Route::post('supportEN/windows/deleteUser', 'SupportENController@deleteUserStore')->name('supportEN.deleteUserStore');
    Route::get('supportEN/windows/editUser', 'SupportENController@editUser')->name('supportEN.editUser');
    Route::post('supportEN/windows/editUser', 'SupportENController@editUserStore')->name('supportEN.editUserStore');
    Route::get('supportEN/windows/extParches', 'SupportENController@extParches')->name('supportEN.extParches');
    Route::post('supportEN/windows/extParches', 'SupportENController@extParchesStore')->name('supportEN.extParchesStore');
    Route::get('supportEN/windows/extUptime', 'SupportENController@extUptime')->name('supportEN.extUptime');
    Route::post('supportEN/windows/extUptime', 'SupportENController@extUptimeStore')->name('supportEN.extUptimeStore');
    Route::get('supportEN/windows/inventario', 'SupportENController@inventario')->name('supportEN.inventario');
    Route::post('supportEN/windows/inventario', 'SupportENController@inventarioStore')->name('supportEN.inventarioStore');
    Route::get('supportEN/windows/rutasEstaticas', 'SupportENController@rutasEstaticas')->name('supportEN.rutasEstaticas');
    Route::post('supportEN/windows/rutasEstaticas', 'SupportENController@rutasEstaticasStore')->name('supportEN.rutasEstaticasStore');


    Route::get('supportEN/windows/serviceManagementV2', 'SupportENController@serviceManagementV2')->name('supportEN.servicesManagementV2');
    Route::post('supportEN/windows/serviceManagementV2', 'SupportENController@serviceManagementStoreV2')->name('supportEN.serviceManagementV2');
    Route::post('supportEN/windows/getServicesByHost', 'SupportENController@getServicesByHost')->name('supportEN.getServicesByHost');


    // SOPORTE EN UNIX

    // conectividad
    Route::get('supportEN/unix/rutasEstaticas', 'SupportENController@unixRutasEstaticas')->name('supportEN.unix.rutasEstaticas');
    Route::post('supportEN/unix/rutasEstaticas', 'SupportENController@unixRutasEstaticasStore')->name('supportEN.unix.rutasEstaticasStore');
    Route::get('supportEN/unix/connectivity', 'SupportENController@testConectividadUnix')->name('supportEN.unix.connectivityUnix');
    Route::post('supportEN/unix/connectivity', 'SupportENController@testConectividadUnixStore')->name('supportEN.unix.connectivityUnixStore');
    Route::get('supportEN/unix/portListen', 'SupportENController@unixPortListen')->name('supportEN.unix.portListen');
    Route::post('supportEN/unix/portListen', 'SupportENController@unixPortListenStore')->name('supportEN.unix.portListenStore');

    // gestion so
    Route::get('supportEN/unix/folderPermission', 'SupportENController@unixFolderPermission')->name('supportEN.unix.folderPermission');
    Route::post('supportEN/unix/folderPermission', 'SupportENController@unixFolderPermissionStore')->name('supportEN.unix.folderPermissionStore');

    Route::get('supportEN/unix/cleanFileSystem', 'SupportENController@unixCleanFileSystem')->name('supportEN.unix.cleanFileSystem');
    Route::post('supportEN/unix/cleanFileSystem', 'SupportENController@unixCleanFileSystemStore')->name('supportEN.unix.cleanFileSystemStore');

    Route::get('supportEN/unix/freeMemory', 'SupportENController@unixFreeMemory')->name('supportEN.unix.freeMemory');
    Route::post('supportEN/unix/freeMemory', 'SupportENController@unixFreeMemoryStore')->name('supportEN.unix.freeMemoryStore');

    Route::get('supportEN/unix/restartServices', 'SupportENController@unixRestartServices')->name('supportEN.unix.restartServices');
    Route::post('supportEN/unix/restartServices', 'SupportENController@unixRestartServicesStore')->name('supportEN.unix.restartServicesStore');

    Route::get('supportEN/unix/uptime', 'SupportENController@unixUptime')->name('supportEN.unix.uptime');
    Route::post('supportEN/unix/uptime', 'SupportENController@unixUptimeStore')->name('supportEN.unix.uptimeStore');

    Route::get('supportEN/unix/inventario', 'SupportENController@unixInventario')->name('supportEN.unix.inventario');
    Route::post('supportEN/unix/inventario', 'SupportENController@unixInventarioStore')->name('supportEN.unix.inventarioStore');


    // gestion usuarios
    Route::get('supportEN/unix/create', 'SupportENController@unixCreate')->name('supportEN.unix.create');
    Route::post('supportEN/unix/create', 'SupportENController@unixCreateStore')->name('supportEN.unix.createStore');



    Route::get('supportEN/unix/delete', 'SupportENController@unixDelete')->name('supportEN.unix.delete');
    Route::post('supportEN/unix/delete', 'SupportENController@unixDeleteStore')->name('supportEN.unix.deleteStore');


    Route::get('supportEN/unix/disable', 'SupportENController@unixDisable')->name('supportEN.unix.disable');
    Route::post('supportEN/unix/disable', 'SupportENController@unixDisableStore')->name('supportEN.unix.disableStore');

    Route::get('supportEN/unix/change', 'SupportENController@unixChange')->name('supportEN.unix.change');
    Route::post('supportEN/unix/change', 'SupportENController@unixChangeStore')->name('supportEN.unix.changeStore');





    // Recursos tecnologicos componentes
    Route::resource('infrastructure/server/components/propietarios', 'PropietariosController')->except(['show']);
    Route::resource('infrastructure/server/components/responsables', 'ResponsablesController')->except(['show']);
    Route::resource('infrastructure/server/components/sistemaOperativo', 'SistemaOperativosController')->except(['show']);
    Route::resource('infrastructure/server/components/tiposCliente', 'TiposClientesController')->except(['show']);
    Route::resource('infrastructure/server/components/clientes', 'ClientesController')->except(['show']);
    Route::resource('infrastructure/server/components/dataCenter', 'DataCentersController')->except(['show']);
    Route::resource('infrastructure/server/components/tiposHardware', 'TiposHardwareController')->except(['show']); //Problema modelo
    Route::resource('infrastructure/server/components/tiposServicio', 'TiposServiciosController')->except(['show']);
    Route::resource('infrastructure/server/components/tiposRack', 'TiposRacksController')->except(['show']);
    Route::resource('infrastructure/server/components/controladoras', 'ControladorasController')->except(['show']);
    Route::resource('infrastructure/server/components/raids', 'RaidsController')->except(['show']);
    Route::resource('infrastructure/server/components/tipoMemorias', 'TipoMemoriasController')->except(['show']);
    Route::resource('infrastructure/server/components/cpuMarcas', 'CpuMarcasController')->except(['show']);
    Route::resource('infrastructure/server/components/cpuModelos', 'CpuModelosController')->except(['show']);
    Route::resource('infrastructure/server/components/discoMarcas', 'DiscoMarcasController')->except(['show']);
    Route::resource('infrastructure/server/components/nicReferencias', 'NicReferenciasController')->except(['show']);
    Route::resource('infrastructure/server/components/serverEstados', 'ServerEstadosController')->except(['show']);

    // Recursos tecnologicos Servidores
    Route::resource('infrastructure/server/server/marcas', 'ServerMarcasController')->parameters(['marcas' => 'serverMarca'])->except(['show']);
    Route::resource('infrastructure/server/server/modelos', 'ServerModelosController')->parameters(['modelos' => 'serverModelo'])->except(['show']);
    Route::get('infrastructure/server/server/updateLogs', 'UpdateLogsController@index')->name('updateLogs.index');
    Route::get('infrastructure/server/server/updateLogs/{updateLog}', 'UpdateLogsController@show')->name('updateLogs.show');
    Route::get('infrastructure/server/server/updatePacks/search', 'UpdatePacksController@search')->name('updatePacks.search');
    Route::post('infrastructure/server/server/updatePacks/search', 'UpdatePacksController@result')->name('updatePacks.result');
    Route::get('infrastructure/server/server/updatePacks/sync/{server}', 'UpdateLogsController@create')->name('updateLogs.create');
    Route::post('infrastructure/server/server/updatePacks/sync', 'UpdateLogsController@store')->name('updateLogs.store');
    Route::resource('infrastructure/server/server/updatePacks', 'UpdatePacksController');
    Route::get('infrastructure/server/server/servers/search', 'ServersController@search')->name('servers.search');
    Route::post('infrastructure/server/server/servers/search', 'ServersController@result')->name('servers.result');
    Route::resource('infrastructure/server/server/servers', 'ServersController')->except(['edit']);
    Route::get('infrastructure/server/server/servers/{server}/edit/{form}', 'ServersController@edit')->name('servers.edit');
    Route::resource('infrastructure/server/server/servers/{server}/hardware/cpus', 'CpusController')->parameters(['cpus' => 'cpu'])->except(['show']);
    Route::get('infrastructure/server/server/servers/{server}/logs', 'UpdateLogsController@logsByServer')->name('updateLogs.byServer');
    Route::get('infrastructure/server/server/servers/{server}/logs/{updateLog}', 'UpdateLogsController@view')->name('updateLogs.view');
    Route::resource('infrastructure/server/server/servers/{server}/hardware/discos', 'DiscosController')->except(['show']);
    Route::resource('infrastructure/server/server/servers/{server}/hardware/hbas', 'HbasController')->except(['show']);
    Route::resource('infrastructure/server/server/servers/{server}/hardware/memorias', 'MemoriasController')->except(['show']);
    Route::resource('infrastructure/server/server/servers/{server}/hardware/nics', 'NicsController')->except(['show']);
    Route::get('infrastructure/server/server/servers/getModelos/{id}', 'ServerModelosController@getModelos')->name('modelos.getModelos');
    Route::get('infrastructure/server/credentials', 'CredentialChangeController@credentialChange')->name('credentials.credentialChange');
    Route::post('infrastructure/server/credentials', 'CredentialChangeController@credentialChangeStore')->name('credentials.credentialChangeStore');

    //Entrega de turnos
    Route::get('turns', 'TurnManagementController@turnManage')->name('turns.turnManage');
    Route::post('turns', 'TurnManagementController@turnManageStore')->name('turns.turnManageStore');

    //Recursos UCMDB
    Route::get('ucmdb/topology', 'UCMDBController@topology')->name('ucmdb.topology');
    //Recursos Recusos Tecnologicos
    Route::get('recursosTecnologicos/cargueInsumo', 'recursosTecnologicosController@showCargueInsumo')->name('recursosTecnologicos.cargueInsumo');

    //Gestion - Clientes Novedades Backupo
    Route::get('clientesNovedadesBku/clientes', 'ClientesNovedadesBuController@index')->name('novedadesBackup.index');
    Route::get('clientesNovedadesBku/cliente', 'ClientesNovedadesBuController@create')->name('novedadesBackup.create');
    Route::post('clientesNovedadesBku/cliente', 'ClientesNovedadesBuController@store')->name('novedadesBackup.store');
    Route::delete('clientesNovedadesBku/cliente/{id}', 'ClientesNovedadesBuController@destroy')->name('novedadesBackup.destroy');
    Route::get('clientesNovedadesBku/cliente/{id}/edit', 'ClientesNovedadesBuController@edit')->name('novedadesBackup.edit');
    Route::patch('clientesNovedadesBku/cliente/{id}', 'ClientesNovedadesBuController@update')->name('novedadesBackup.update');

    //Notificación Novedades

    Route::get('novedadesBackup/novedadesCliente', 'NotificarNovedadesController@indexNovedadesCliente')->name('novedadesBackup.indexNovedadesCliente');
    Route::post('novedadesBackup/novedadesCliente', 'NotificarNovedadesController@busquedaNovedadesPorCliente')->name('novedadesBackup.busquedaNovedadesPorCliente');
    Route::post('novedadesBackup/notificarNovedades', 'NotificarNovedadesController@notificarNovedades')->name('novedadesBackup.notificarNovedades');
    Route::post('novedadesBackup/notificarNovedadesAjax', 'NotificarNovedadesController@notificarNovedadesAjax')->name('novedadesBackup.notificarNovedadesAjax');

    //Incidentes
    Route::get('incidentes/declarar', 'IncidentesController@declararIncidente')->name('incidentes.declarar');
    Route::get('incidentes/declarar-info', 'IncidentesController@declararIncidenteIFO')->name('incidentes.declararINFO');
    Route::post('incidentes/declarar', 'IncidentesController@declararIncidenteEndpoint')->name('incidentes.declararStore');
    //SOM
    Route::get('som/checkmaquinavirtual', 'SomController@checkmaquinavirtual');


    //initiative - INICIATIVAS DE AUTOMATIZACIONES
    Route::resource('initiative', 'InitiativeController')->except('show');
    Route::get('initiative/index', 'InitiativeController@index')->name('initiative.index');
    Route::post('initiative/create', 'InitiativeController@store')->name('initiative.create');
    Route::get('initiative/edit/{id}', 'InitiativeController@edit')->name('initiative.edit');
    Route::get('initiative/show/{id}', 'InitiativeController@show')->name('initiative.show');
    Route::delete('/initiative/{id}', 'InitiativeController@destroy')->name('initiative.destroy');
    Route::get('/initiative/file/{attachments}', 'InitiativeController@file')->name('initiative.file');
    Route::post('guardar-improvement', 'ImprovementController@store')->name('guardar_improvement');
    Route::get('/initiative/getLayers/{id}', 'InitiativeController@getLayers')->name('initiative.getLayers');



    //VCostumer clientes
    Route::resource('customer', 'CustomerController')->except('show');
    Route::get('customer/index', 'CustomerController@index')->name('customer.index');
    Route::post('customer/create', 'CustomerController@store')->name('customer.create');
    Route::get('/customer/{customerID}/edit', 'CustomerController@edit')->name('customer.edit');
    Route::get('customer/show/{customerID}', 'CustomerController@show')->name('customer.show');
    Route::delete('/customer/{id}', 'CustomerController@destroy')->name('customer.destroy');
<<<<<<< HEAD
=======
    Route::post('/checkNit', 'CustomerController@checkNit')->name('checkNit');
>>>>>>> 155db5f0776830a8012ab71729e2cd8acaf9c1cc
    Route::post('customer/guardarInformacion/{customerID}', 'CustomerController@guardarInformacion')->name('customer.guardarInformacion');



    //link boton add 
    //Route::get('virtualizations/runDiagnostic/{id}/{vcenter}', 'VirtualizationController@runDiag')->name('virtualization.runDiag');
});