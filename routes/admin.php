<?php
Route::get('/login', 'Admin\AuthController@login')->name('login');
Route::get('/Logout', 'Admin\AuthController@Logout');
Route::post('/CheckLogin', 'Admin\AuthController@checkLogin');

Route::middleware('authAdmin:admin')->group(function () {
    Route::get('/', 'Admin\DashboardController@index');
    Route::get('/Dashboard', 'Admin\DashboardController@index');

    Route::post('/AdminUser/Lists', 'Admin\AdminUserController@lists');
    Route::resource('AdminUser', 'Admin\AdminUserController');
    Route::post('/AdminUser/ChangeStatus/{id}', 'Admin\AdminUserController@ChangeStatus');
    Route::post('/AdminUser/SetPremission/{id}', 'Admin\AdminUserController@SetPremission');
    Route::post('/AdminUser/ResetPassword/{id}', 'Admin\AdminUserController@ResetPassword');

    Route::post('/AdminUserGroup/Lists', 'Admin\AdminUserGroupController@lists');
    Route::resource('AdminUserGroup', 'Admin\AdminUserGroupController');
    Route::post('/AdminUserGroup/SetPremission/{id}', 'Admin\AdminUserGroupController@SetPremission');
    
    Route::post('/NamePrefix/Lists', 'Admin\NamePrefixController@lists');
    Route::resource('NamePrefix', 'Admin\NamePrefixController');
    Route::post('/NamePrefix/ChangeStatus/{id}', 'Admin\NamePrefixController@ChangeStatus');

    Route::post('/Gender/Lists', 'Admin\GenderController@lists');
    Route::resource('Gender', 'Admin\GenderController');
    Route::post('/Gender/ChangeStatus/{id}', 'Admin\GenderController@ChangeStatus');

    Route::get('GetProvinceByGeography/{geo_id}','Admin\DashboardController@GetProvinceByGeography');
    Route::get('GetAmphurByProvince/{provinces_id}','Admin\DashboardController@GetAmphurByProvince');
    Route::get('GetDistrictByAmphur/{amphur_id}','Admin\DashboardController@GetDistrictByAmphur');
    Route::get('GetZipcodeByDistrict/{districts_code}','Admin\DashboardController@GetZipcodeByDistrict');

    Route::post('/Geography/Lists', 'Admin\GeographyController@lists');
    Route::resource('Geography', 'Admin\GeographyController');
    Route::post('/Geography/ChangeStatus/{id}', 'Admin\GeographyController@ChangeStatus');
    Route::get('Geography/getProvinces_table/{id}', 'Admin\GeographyController@getProvinces_table');
    Route::get('Geography/getAmphures_table/{id}', 'Admin\GeographyController@getAmphures_table');
    Route::get('Geography/getDistricts_table/{id}', 'Admin\GeographyController@getDistricts_table');

    Route::post('/Provinces/Lists', 'Admin\ProvincesController@lists');
    Route::resource('Provinces', 'Admin\ProvincesController');
    Route::post('/Provinces/ChangeStatus/{id}', 'Admin\ProvincesController@ChangeStatus');
    Route::get('Provinces/getAmphures_table/{id}', 'Admin\ProvincesController@getAmphures_table');
    Route::get('Provinces/getDistricts_table/{id}', 'Admin\ProvincesController@getDistricts_table');

    Route::post('/Amphures/Lists', 'Admin\AmphuresController@lists');
    Route::resource('Amphures', 'Admin\AmphuresController');
    Route::post('/Amphures/ChangeStatus/{id}', 'Admin\AmphuresController@ChangeStatus');
    Route::get('Amphures/getDistricts_table/{id}', 'Admin\AmphuresController@getDistricts_table');

    Route::post('/Districts/Lists', 'Admin\DistrictsController@lists');
    Route::resource('Districts', 'Admin\DistrictsController');
    Route::post('/Districts/ChangeStatus/{id}', 'Admin\DistrictsController@ChangeStatus');

    Route::post('/Language/Lists', 'Admin\LanguageController@lists');
    Route::resource('Language', 'Admin\LanguageController');
    Route::post('/Language/ChangeStatus/{id}', 'Admin\LanguageController@ChangeStatus');

    Route::post('/AboutUsCategory/Lists', 'Admin\AboutUsCategoryController@lists');
    Route::resource('AboutUsCategory', 'Admin\AboutUsCategoryController');
    Route::post('/AboutUsCategory/ChangeStatus/{id}', 'Admin\AboutUsCategoryController@ChangeStatus');
    Route::post('/AboutUsCategory/Delete/{id}', 'Admin\AboutUsCategoryController@Delete');
    
    Route::post('/AboutUs/Lists', 'Admin\AboutUsController@lists');
    Route::get('/AboutUs/GetAboutUs', 'Admin\AboutUsController@GetAboutUs');
    Route::resource('AboutUs', 'Admin\AboutUsController');
    Route::post('/AboutUs/ChangeStatus/{id}', 'Admin\AboutUsController@ChangeStatus');
    Route::post('/AboutUs/Delete/{id}', 'Admin\AboutUsController@Delete');

    Route::post('/Setting/Lists', 'Admin\SettingController@lists');
    Route::get('/Setting/GetSetting', 'Admin\SettingController@GetSetting');
    Route::resource('Setting', 'Admin\SettingController');

    Route::post('/Event/Lists', 'Admin\EventController@lists');
    Route::resource('Event', 'Admin\EventController');
    Route::post('/Event/ChangeStatus/{id}', 'Admin\EventController@ChangeStatus');

    Route::post('UploadImage/{folder}','Admin\UploadFileController@UploadImage');
    Route::post('UploadFile/{folder}','Admin\UploadFileController@UploadFile');
    Route::post('UploadFile/DeleteUploadFile/{folder}','Admin\UploadFileController@DeleteUploadFile');
    Route::post('UploadFile/DeleteUploadFileEdit/{folder}','Admin\UploadFileController@DeleteUploadFileEdit');
    // Route::get('UploadFile/fetch', 'UploadFileController@fetch')->name('UploadFile.fetch');

    Route::post('/EventCategory/Lists', 'Admin\EventCategoryController@lists');
    Route::resource('EventCategory', 'Admin\EventCategoryController');
    Route::post('/EventCategory/ChangeStatus/{id}', 'Admin\EventCategoryController@ChangeStatus');

    Route::post('/EventCategoryDetail/Lists', 'Admin\EventCategoryDetailController@lists');
    Route::resource('EventCategoryDetail', 'Admin\EventCategoryDetailController');
    Route::post('/EventCategoryDetail/ChangeStatus/{id}', 'Admin\EventCategoryDetailController@ChangeStatus');

    Route::post('/EventDetail/Lists', 'Admin\EventDetailController@lists');
    Route::resource('EventDetail', 'Admin\EventDetailController');
    Route::post('/EventDetail/ChangeStatus/{id}', 'Admin\EventDetailController@ChangeStatus');

    Route::post('/EventGallery/Lists', 'Admin\EventGalleryController@lists');
    Route::resource('EventGallery', 'Admin\EventGalleryController');
    Route::post('/EventGallery/ChangeStatus/{id}', 'Admin\EventGalleryController@ChangeStatus');

    Route::post('/EventTag/Lists', 'Admin\EventTagController@lists');
    Route::resource('EventTag', 'Admin\EventTagController');
    Route::post('/EventTag/ChangeStatus/{id}', 'Admin\EventTagController@ChangeStatus');

    Route::post('/News/Lists', 'Admin\NewsController@lists');
    Route::resource('News', 'Admin\NewsController');
    Route::post('/News/ChangeStatus/{id}', 'Admin\NewsController@ChangeStatus');

    Route::post('/NewsCategory/Lists', 'Admin\NewsCategoryController@lists');
    Route::resource('NewsCategory', 'Admin\NewsCategoryController');
    Route::post('/NewsCategory/ChangeStatus/{id}', 'Admin\NewsCategoryController@ChangeStatus');

    Route::post('/NewsGallery/Lists', 'Admin\NewsGalleryController@lists');
    Route::resource('NewsGallery', 'Admin\NewsGalleryController');
    Route::post('/NewsGallery/ChangeStatus/{id}', 'Admin\NewsGalleryController@ChangeStatus');
    Route::post('/NewsGallery/Delete/{id}', 'Admin\NewsGalleryController@Delete');

    Route::post('/NewsTag/Lists', 'Admin\NewsTagController@lists');
    Route::resource('NewsTag', 'Admin\NewsTagController');
    Route::post('/NewsTag/ChangeStatus/{id}', 'Admin\NewsTagController@ChangeStatus');

    Route::post('/Knowledge/Lists', 'Admin\KnowledgeController@lists');
    Route::resource('Knowledge', 'Admin\KnowledgeController');
    Route::post('/Knowledge/ChangeStatus/{id}', 'Admin\KnowledgeCategoryController@ChangeStatus');

    Route::post('/KnowledgeCategory/Lists', 'Admin\KnowledgeCategoryController@lists');
    Route::resource('KnowledgeCategory', 'Admin\KnowledgeCategoryController');
    Route::post('/KnowledgeCategory/ChangeStatus/{id}', 'Admin\KnowledgeCategoryController@ChangeStatus');

    Route::post('/Module/Lists', 'Admin\ModuleController@lists');
    Route::resource('Module', 'Admin\ModuleController');
    Route::post('/Module/ChangeStatus/{id}', 'Admin\ModuleController@ChangeStatus');
    Route::post('/Module/Install/{id}', 'Admin\ModuleController@Install');

    Route::post('/MenuSetting/Lists', 'Admin\MenuSettingController@lists');
    Route::resource('MenuSetting', 'Admin\MenuSettingController');
    Route::post('/MenuSetting/ChangeStatus/{id}', 'Admin\MenuSettingController@ChangeStatus');
    Route::post('/MenuSetting/Delete/{id}', 'Admin\MenuSettingController@Delete');

    Route::post('/Social/Lists', 'Admin\SocialController@lists');
    Route::get('/Social/GetSocial', 'Admin\SocialController@GetSocial');
    Route::resource('Social', 'Admin\SocialController');
    Route::post('/Social/Delete/{id}', 'Admin\SocialController@Delete');

    Route::post('/Logo/Lists', 'Admin\LogoController@lists');
    Route::get('/Logo/GetLogo', 'Admin\LogoController@GetLogo');
    Route::resource('Logo', 'Admin\LogoController');

    Route::post('/Banner/Lists', 'Admin\BannerController@lists');
    Route::resource('Banner', 'Admin\BannerController');
    Route::post('/Banner/ChangeStatus/{id}', 'Admin\BannerCategoryController@ChangeStatus');

    Route::post('/BannerConfig/Lists', 'Admin\BannerConfigController@lists');
    Route::get('/BannerConfig/GetBannerConfig', 'Admin\BannerConfigController@GetBannerConfig');
    Route::resource('BannerConfig', 'Admin\BannerConfigController');

    Route::post('/ContactUs/Lists', 'Admin\ContactUsController@lists');
    Route::resource('ContactUs', 'Admin\ContactUsController');
    Route::post('/ContactUs/ChangeStatus/{id}', 'Admin\ContactUsController@ChangeStatus');
    Route::post('/ContactUs/Delete/{id}', 'Admin\ContactUsController@Delete');

    Route::post('/ContactInfo/Lists', 'Admin\ContactInfoController@lists');
    Route::get('/ContactInfo/GetContactInfo', 'Admin\ContactInfoController@GetContactInfo');
    Route::resource('ContactInfo', 'Admin\ContactInfoController');

    Route::post('/Question/Lists', 'Admin\QuestionController@lists');
    Route::resource('Question', 'Admin\QuestionController');
    Route::post('/Question/ChangeStatus/{id}', 'Admin\QuestionCategoryController@ChangeStatus');

    Route::post('/QuestionCategory/Lists', 'Admin\QuestionCategoryController@lists');
    Route::resource('QuestionCategory', 'Admin\QuestionCategoryController');
    Route::post('/QuestionCategory/ChangeStatus/{id}', 'Admin\QuestionCategoryCategoryController@ChangeStatus');

    Route::get('/test', function () {
        return view('test');
    });
});

?>
