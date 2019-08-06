<?php
Route::pattern('id', '[0-9]+');
Route::pattern('id2', '[0-9]+');
Route::pattern('id3', '[0-9]+');
Route::pattern('slug', '[a-zA-Z0-9-]+');
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Route::get('/', function()
//{
//	return View::make('user.layout');
//});

Route::get('/',                         ['as' => 'user.home',                   'uses' => 'User\HomeController@index']);
Route::get('language-chooser/{slug}',   ['as' => 'user.lang',                   'uses' => 'User\LanguageController@chooser']);
Route::get('video/{id}',                ['as' => 'user.video',                  'uses' => 'User\HomeController@video']);
Route::get('inspection',                ['as' => 'user.inspection',             'uses' => 'User\HomeController@inspection']);
Route::get('rfq-list/{id}',             ['as' => 'user.rfq',                    'uses' => 'User\BuyerController@rfq']);
Route::get('sampleInvoice/{id}',        ['as' => 'user.invoice',                'uses' => 'User\SellerBuyerController@invoice']);
Route::get('invoice/{id}',              ['as' => 'user.acceptInvoice',          'uses' => 'User\SellerBuyerController@acceptInvoice']);
Route::get('cartInvoice/{id}',          ['as' => 'user.addCart.cartInvoice',     'uses' => 'User\CartController@cartInvoice']);
Route::get('verify-email/{slug}',       ['as' => 'user.verifyEmail',            'uses' => 'User\HomeController@verifyEmail']);
Route::any('add-cart',                  ['as' => 'user.addCart',                'uses' => 'User\CartController@selectAddCart']);
Route::get('show-product/{id}/{id2?}',  ['as' => 'user.showProduct',            'uses' => 'User\CartController@showProduct']);
Route::get('addCart',                   ['as' => 'user.addCart.index',          'uses' => 'User\CartController@showIndex']);
Route::post('changeCart',               ['as' => 'user.addCart.changeCart',     'uses' => 'User\CartController@changeCart']);
Route::post('removeCart',               ['as' => 'user.addCart.removeCart',     'uses' => 'User\CartController@removeCart']);
Route::any('saveCart',                  ['as' => 'user.addCart.saveCart',       'uses' => 'User\CartController@saveCart']);
Route::get('payment/{id}',              ['as' => 'user.addCart.payment',        'uses' => 'User\CartController@payment']);
Route::post('credit',                   ['as' => 'user.addCart.credit',         'uses' => 'User\CartController@credit']);
Route::post('getUserStatus',            ['as' => 'user.addCart.getUserStatus',  'uses' => 'User\CartController@getUserStatus']);
Route::post('userLogin',                ['as' => 'user.addCart.userLogin',      'uses' => 'User\CartController@userLogin']);
Route::post('userSignUp',               ['as' => 'user.addCart.userSignUp',     'uses' => 'User\CartController@userSignUp']);
Route::post('cart/privacyConditions',   ['as' => 'user.buyer.cart.privacyConditions','uses' => 'User\CartController@cartPrivacyConditions']);
Route::get('terms-condition',           ['as' => 'user.terms',                  'uses' => 'User\HomeController@terms']);


Route::group(['prefix' => 'escrow'], function () {
    Route::get('/',                                         ['as' => 'user.escrow.index',                           'uses' => 'User\EscrowHomeController@index']);
    Route::get('login',                                     ['as' => 'user.escrow.login',                           'uses' => 'User\EscrowHomeController@login']);
    Route::get('forgot',                                    ['as' => 'user.escrow.forgot',                          'uses' => 'User\EscrowHomeController@forgot']);
    Route::any('forgotSend',                                ['as' => 'user.escrow.forgotSend',                      'uses' => 'User\EscrowHomeController@forgotSend']);
    Route::get('register',                                  ['as' => 'user.escrow.register',                        'uses' => 'User\EscrowHomeController@register']);
    Route::post('registerStore',                            ['as' => 'user.escrow.registerStore',                   'uses' => 'User\EscrowHomeController@registerStore']);
    Route::post('doLogin',                                  ['as' => 'user.escrow.doLogin',                         'uses' => 'User\EscrowHomeController@doLogin']);
    Route::get('doLogout',                                  ['as' => 'user.escrow.doLogout',                        'uses' => 'User\EscrowHomeController@doLogout']);
    Route::post('getPrice',                                 ['as' => 'user.escrow.getPrice',                        'uses' => 'User\EscrowHomeController@getPrice']);
    Route::post('transaction',                              ['as' => 'user.escrow.transaction',                     'uses' => 'User\EscrowHomeController@transaction']);
    Route::get('escrow/{slug}/{id?}/{id2?}',                ['as' => 'user.escrow.escrow',                          'uses' => 'User\EscrowHomeController@escrow']);
    Route::post('samplePayNow',                             ['as' => 'user.escrow.samplePayNow',                    'uses' => 'User\EscrowHomeController@samplePayNow']);
    Route::post('wirePayNow',                               ['as' => 'user.escrow.wirePayNow',                      'uses' => 'User\EscrowHomeController@wirePayNow']);
    Route::post('dispute',                                  ['as' => 'user.escrow.disputeDiv',                      'uses' => 'User\EscrowHomeController@disputeDiv']);
    Route::post('cancel',                                   ['as' => 'user.escrow.cancel',                          'uses' => 'User\EscrowHomeController@cancel']);
    Route::post('approved',                                 ['as' => 'user.escrow.approved',                        'uses' => 'User\EscrowHomeController@approved']);
    Route::get('wire_transfer_information/{id}/{id1}',      ['as' => 'user.escrow.wirePrintButton',                 'uses' => 'User\EscrowHomeController@wirePrintButton']);
    Route::get('wire_payment_instruction',                  ['as' => 'user.escrow.wirePrintButtonInstruction',      'uses' => 'User\EscrowHomeController@wirePrintButtonInstruction']);
    Route::get('shoppingCart',                              ['as' => 'user.escrow.shoppingCart',                    'uses' => 'User\EscrowHomeController@shoppingCart']);
    Route::post('cartRelease',                              ['as' => 'user.escrow.shoppingCartRelease',             'uses' => 'User\EscrowHomeController@shoppingCartRelease']);
    Route::post('cartDisputePost',                          ['as' => 'user.escrow.shoppingCartDisputePost',         'uses' => 'User\EscrowHomeController@shoppingCartDisputePost']);
    Route::get('shoppingCartDispute/{id}',                  ['as' => 'user.escrow.shoppingCartDispute',             'uses' => 'User\EscrowHomeController@shoppingCartDispute']);
    Route::post('sendCartContent',                          ['as' => 'user.escrow.shoppingCartDisputeSendContent',  'uses' => 'User\EscrowHomeController@shoppingCartDisputeSendContent']);
    Route::post('disputeAgreement',                         ['as' => 'user.escrow.shoppingCartDisputeAgreement',    'uses' => 'User\EscrowHomeController@shoppingCartDisputeAgreement']);


});
Route::group(['prefix' => 'seller'], function () {
    Route::get('dashboard',                             ['as' => 'user.seller.dashboard',           'uses' => 'User\SellerGroupController@index']);
    Route::get('store/{id}',                            ['as' => 'user.seller.store',               'uses' => 'User\SellerController@store']);
    Route::get('storeCategory/{id}/{id1}',              ['as' => 'user.seller.storeCategory',       'uses' => 'User\SellerController@storeCategory']);
    Route::get('storeSubCategory/{id}/{id1}',           ['as' => 'user.seller.storeSubCategory',    'uses' => 'User\SellerController@storeSubCategory']);
    Route::any('company_change_picture',                ['as' => 'user.seller.companyChangePicture','uses' => 'User\SellerController@companyChangePicture']);
    Route::post('company_change_pictures',              ['as' => 'user.seller.companyChangePictures','uses' => 'User\SellerController@companyChangePictures']);
    Route::post('getCategory',                          ['as' => 'user.seller.getCategory',         'uses' => 'User\SellerController@getCategory']);
    Route::post('category/imageUpload',                 ['as' => 'user.seller.categoryImageUpload', 'uses' => 'User\SellerController@categoryImageUpload']);
    Route::post('subCategory/imageUpload',              ['as' => 'user.seller.subCategoryImageUpload', 'uses' => 'User\SellerController@subCategoryImageUpload']);
    Route::post('category/change',                      ['as' => 'user.seller.categoryChange',      'uses' => 'User\SellerController@categoryChange']);
    Route::post('subCategory/change',                   ['as' => 'user.seller.subCategoryChange',   'uses' => 'User\SellerController@subCategoryChange']);
    Route::get('category/{id}',                         ['as' => 'user.seller.category',            'uses' => 'User\SellerController@category']);
    Route::get('profile/{id}',                          ['as' => 'user.seller.profile',             'uses' => 'User\SellerController@profile']);
    Route::get('rfq',                                   ['as' => 'user.seller.rfq',                 'uses' => 'User\SellerController@rfq']);
    Route::get('rfq/search',                            ['as' => 'user.seller.rfqSearch',           'uses' => 'User\SellerController@rfqSearch']);
    Route::post('send',                                 ['as' => 'user.seller.send',                'uses' => 'User\SellerController@send']);
    Route::get('category/sub/{id}/{id2}',               ['as' => 'user.seller.sub',                 'uses' => 'User\SellerController@sub']);
    Route::get('email/{slug}',                          ['as' => 'user.seller.email',               'uses' => 'User\SellerGroupController@email']);
    Route::get('newList/{id}/{slug}',                   ['as' => 'user.seller.newList',             'uses' => 'User\SellerGroupController@newList']);
    Route::get('emailList/{id}/{slug}',                 ['as' => 'user.seller.getEmailContent',      'uses' => 'User\SellerGroupController@getEmailContent']);
    Route::get('deleteEmail/{id}/{slug}',               ['as' => 'user.seller.deleteEmail',          'uses' => 'User\SellerGroupController@deleteEmail']);
    Route::post('storeEmail',                           ['as' => 'user.seller.storeEmail',           'uses' => 'User\SellerGroupController@storeEmail']);
    Route::get('favorite',                              ['as' => 'user.seller.favorite',             'uses' => 'User\SellerGroupController@favorite']);
    Route::get('login-rfq',                             ['as' => 'user.seller.loginRfq',             'uses' => 'User\SellerGroupController@loginRfq']);
    Route::get('quote-now/{id}',                        ['as' => 'user.seller.quoteNow',             'uses' => 'User\SellerGroupController@quoteNow']);
    Route::get('edit-quote-now/{id}',                   ['as' => 'user.seller.editQuoteNow',         'uses' => 'User\SellerGroupController@editQuoteNow']);
    Route::any('rfq/specificationPicutre',              ['as' => 'user.seller.specificationPicutre', 'uses' => 'User\SellerGroupController@specificationPicutre']);
    Route::post('quote/store',                          ['as' => 'user.seller.quoteStore',           'uses' => 'User\SellerGroupController@quoteStore']);
    Route::get('login-search',                          ['as' => 'user.seller.loginSearch',          'uses' => 'User\SellerGroupController@loginSearch']);
    Route::get('emailShow/{id}/{id2}',                  ['as' => 'user.seller.rfqEmail',             'uses' => 'User\SellerGroupController@rfqEmail']);
    Route::get('get-price/{id}',                        ['as' => 'user.seller.getPrice',             'uses' => 'User\SellerGroupController@getPrice']);
    Route::post('postGetPrice',                         ['as' => 'user.seller.postGetPrice',         'uses' => 'User\SellerGroupController@postGetPrice']);
    Route::get('get-label/{id}',                        ['as' => 'user.seller.getLabel',             'uses' => 'User\SellerGroupController@getLabel']);
    Route::post('postGetLabel',                         ['as' => 'user.seller.postGetLabel',         'uses' => 'User\SellerGroupController@postGetLabel']);
    Route::post('postCartGetLabel',                         ['as' => 'user.seller.postCartGetLabel',         'uses' => 'User\SellerGroupController@postCartGetLabel']);
    Route::post('rfqStoreEmail',                        ['as' => 'user.seller.rfqStoreEmail',        'uses' => 'User\SellerGroupController@rfqStoreEmail']);
    Route::post('rfqStoreEmailPost',                    ['as' => 'user.seller.rfqStoreEmailPost',    'uses' => 'User\SellerGroupController@rfqStoreEmailPost']);
    Route::get('product/create/{id}',                   ['as' => 'user.seller.productCreate',        'uses' => 'User\SellerGroupController@productCreate']);
    Route::get('my-store',                              ['as' => 'user.seller.products',             'uses' => 'User\SellerGroupController@products']);
    Route::post('product/getSubcategory',               ['as' => 'user.seller.getSubcategory',       'uses' => 'User\SellerGroupController@getSubcategory']);
    Route::post('product/specificationPicture',         ['as' => 'user.seller.specificationPicture', 'uses' => 'User\SellerGroupController@specificationPicture']);
    Route::post('product/store',                        ['as' => 'user.seller.productStore',         'uses' => 'User\SellerGroupController@productStore']);
    Route::get('product/addImage/{id}',                 ['as' => 'user.seller.addImage',             'uses' => 'User\SellerGroupController@addImage']);
    Route::get('product/editImage/{id}',                ['as' => 'user.seller.editImage',            'uses' => 'User\SellerGroupController@editImage']);
    Route::post('product/image/store',                  ['as' => 'user.seller.productImageStore',    'uses' => 'User\SellerGroupController@productImageStore']);
    Route::get('product/edit/{id}',                     ['as' => 'user.seller.productEdit',          'uses' => 'User\SellerGroupController@productEdit']);
    Route::get('product/delete/{id}',                   ['as' => 'user.seller.productDelete',        'uses' => 'User\SellerGroupController@productDelete']);
    Route::get('product/view/{id}',                     ['as' => 'user.seller.productView',          'uses' => 'User\SellerGroupController@productView']);
    Route::post('sub/sample',                           ['as' => 'user.seller.sub.sample',           'uses' => 'User\SellerGroupController@subSample']);
    Route::post('sub/escrow',                           ['as' => 'user.seller.sub.escrow',           'uses' => 'User\SellerGroupController@subEscrow']);
    Route::post('sub/orders',                           ['as' => 'user.seller.sub.orders',           'uses' => 'User\SellerGroupController@subOrders']);
    Route::post('sub/inspection',                       ['as' => 'user.seller.sub.inspection',       'uses' => 'User\SellerGroupController@subInspection']);
    Route::post('sub/shipping',                         ['as' => 'user.seller.sub.shipping',         'uses' => 'User\SellerGroupController@subShipping']);
    Route::post('sub/mail',                             ['as' => 'user.seller.sub.mail',             'uses' => 'User\SellerGroupController@subMail']);
    Route::post('sub/documents',                        ['as' => 'user.seller.sub.documents',        'uses' => 'User\SellerGroupController@subDocuments']);
    Route::post('get/productlist',                      ['as' => 'user.seller.get.productlist',      'uses' => 'User\SellerController@getProductList']);
    Route::any('store/contact/{id}',                    ['as' => 'user.seller.store.contact',        'uses' => 'User\SellerController@storeContact']);
    Route::get('cart',                                  ['as' => 'user.seller.cart',                 'uses' => 'User\SellerGroupController@cart']);
    Route::post('cart/buyer',                           ['as' => 'user.seller.cart.buyer',           'uses' => 'User\SellerGroupController@cartBuyer']);
    Route::post('cart/mail',                            ['as' => 'user.seller.cart.mail',            'uses' => 'User\SellerGroupController@cartMail']);
    Route::post('cart/postMail',                        ['as' => 'user.seller.cart.postMail',        'uses' => 'User\SellerGroupController@cartMailPost']);
    Route::post('cart/orders',                          ['as' => 'user.seller.cart.orders',          'uses' => 'User\SellerBuyerController@cartOrders']);
    Route::post('cart/escrow',                          ['as' => 'user.seller.cart.escrow',          'uses' => 'User\SellerBuyerController@cartEscrow']);
    Route::get('cart/shipping/{id}',                    ['as' => 'user.seller.cart.shipping',        'uses' => 'User\SellerGroupController@cartShipping']);
    Route::post('cart/sendSellerConfirm',               ['as' => 'user.seller.cart.sendSellerConfirm','uses' => 'User\SellerGroupController@sendSellerConfirm']);
    Route::post('cart/get_status',                      ['as' => 'user.seller.cart.getStatus',       'uses' => 'User\SellerBuyerController@getStatus']);
    Route::post('cart/document',                        ['as' => 'user.seller.cart.document',         'uses' => 'User\SellerGroupController@cartDocument']);
    Route::get('cart/email/{id}',                       ['as' => 'user.seller.cart.email',            'uses' => 'User\SellerGroupController@cartEmail']);

});
Route::group(['prefix' => 'buyer'], function () {
    Route::get('dashboard',                         ['as' => 'user.buyer.dashboard',            'uses' => 'User\SellerBuyerController@dashboardIndex']);
    Route::get('email/{slug}',                      ['as' => 'user.buyer.email',                'uses' => 'User\BuyerGroupController@email']);
    Route::get('getEmail',                          ['as' => 'user.buyer.getEmail',             'uses' => 'User\BuyerGroupController@getEmail']);
    Route::get('emailList/{id}/{slug}',             ['as' => 'user.buyer.getEmailContent',      'uses' => 'User\BuyerGroupController@getEmailContent']);
    Route::get('newList/{id}/{slug}',               ['as' => 'user.buyer.newList',              'uses' => 'User\BuyerGroupController@newList']);
    Route::post('storeEmail',                       ['as' => 'user.buyer.storeEmail',           'uses' => 'User\BuyerGroupController@storeEmail']);
    Route::get('deleteEmail/{id}/{slug}',           ['as' => 'user.buyer.deleteEmail',          'uses' => 'User\BuyerGroupController@deleteEmail']);
    Route::get('favorite',                          ['as' => 'user.buyer.favorite',             'uses' => 'User\BuyerGroupController@favorite']);
    Route::get('rfq',                               ['as' => 'user.buyer.rfq',                  'uses' => 'User\BuyerGroupController@rfq']);
    Route::get('rfq/create',                        ['as' => 'user.buyer.rfqCreate',            'uses' => 'User\BuyerGroupController@rfqCreate']);
    Route::any('rfq/specificationPicutre',          ['as' => 'user.buyer.specificationPicutre', 'uses' => 'User\BuyerGroupController@specificationPicutre']);
    Route::any('rfq/file',                          ['as' => 'user.buyer.file',                 'uses' => 'User\BuyerGroupController@file']);
    Route::post('rfq/store',                        ['as' => 'user.buyer.store',                'uses' => 'User\BuyerGroupController@store']);
    Route::post('rfq/restore',                      ['as' => 'user.buyer.restore',              'uses' => 'User\BuyerGroupController@restore']);
    Route::get('rfq/delete/{id}',                  ['as' => 'user.buyer.rfqDelete',            'uses' => 'User\BuyerGroupController@rfqDelete']);
    Route::get('rfq/view/{id}',                     ['as' => 'user.buyer.rfqView',              'uses' => 'User\BuyerGroupController@rfqView']);
    Route::get('rfq/edit/{id}',                     ['as' => 'user.buyer.rfqEdit',              'uses' => 'User\BuyerGroupController@rfqEdit']);
    Route::any('getQuotes',                         ['as' => 'user.buyer.getQuotes',            'uses' => 'User\BuyerGroupController@getQuotes']);
    Route::any('getEmails',                         ['as' => 'user.buyer.getEmails',            'uses' => 'User\BuyerGroupController@getEmails']);
    Route::get('quoteShow/{id}',                    ['as' => 'user.buyer.quoteShow',            'uses' => 'User\BuyerGroupController@quoteShow']);
    Route::get('emailShow/{id}/{id2}',              ['as' => 'user.buyer.emailShow',            'uses' => 'User\BuyerGroupController@emailShow']);
    Route::post('decline',                          ['as' => 'user.buyer.decline',              'uses' => 'User\BuyerGroupController@decline']);
    Route::post('rfqStoreEmail',                    ['as' => 'user.buyer.rfqStoreEmail',        'uses' => 'User\BuyerGroupController@rfqStoreEmail']);
    Route::post('rfqStoreEmailPost',                ['as' => 'user.buyer.rfqStoreEmailPost',    'uses' => 'User\BuyerGroupController@rfqStoreEmailPost']);
    Route::post('rfqStoreEmail1',                   ['as' => 'user.buyer.rfqStoreEmail1',       'uses' => 'User\BuyerGroupController@rfqStoreEmail1']);
    Route::post('sampleStore',                      ['as' => 'user.buyer.sampleStore',          'uses' => 'User\BuyerGroupController@sampleStore']);
    Route::post('samplePayNow',                     ['as' => 'user.buyer.samplePayNow',         'uses' => 'User\BuyerGroupController@samplePayNow']);
    Route::post('rfq/accept',                       ['as' => 'user.buyer.rfqAccept',            'uses' => 'User\BuyerGroupController@rfqAccept']);
    Route::post('rfq/getBuyerLocation',             ['as' => 'user.buyer.getBuyerLocation',     'uses' => 'User\BuyerGroupController@getBuyerLocation']);
    Route::post('sub/sample',                        ['as' => 'user.buyer.sub.sample',           'uses' => 'User\BuyerGroupController@subSample']);
    Route::post('sub/escrow',                        ['as' => 'user.buyer.sub.escrow',           'uses' => 'User\BuyerGroupController@subEscrow']);
    Route::post('sub/orders',                        ['as' => 'user.buyer.sub.orders',           'uses' => 'User\BuyerGroupController@subOrders']);
    Route::post('sub/inspection',                    ['as' => 'user.buyer.sub.inspection',       'uses' => 'User\BuyerGroupController@subInspection']);
    Route::post('sub/shipping',                      ['as' => 'user.buyer.sub.shipping',         'uses' => 'User\BuyerGroupController@subShipping']);
    Route::post('sub/mail',                          ['as' => 'user.buyer.sub.mail',             'uses' => 'User\BuyerGroupController@subMail']);
    Route::post('sub/documents',                     ['as' => 'user.buyer.sub.documents',        'uses' => 'User\BuyerGroupController@subDocuments']);
    Route::get('cart',                               ['as' => 'user.buyer.cart',                 'uses' => 'User\SellerBuyerController@cart']);
    Route::post('cart/seller',                        ['as' => 'user.buyer.cart.seller',           'uses' => 'User\SellerBuyerController@cartSeller']);
    Route::post('cart/mail',                         ['as' => 'user.buyer.cart.mail',            'uses' => 'User\SellerBuyerController@cartMail']);
    Route::post('cart/postMail',                     ['as' => 'user.buyer.cart.postMail',        'uses' => 'User\SellerBuyerController@cartMailPost']);
    Route::post('cart/orders',                       ['as' => 'user.buyer.cart.orders',          'uses' => 'User\SellerBuyerController@cartOrders']);
    Route::post('cart/escrow',                       ['as' => 'user.buyer.cart.escrow',          'uses' => 'User\SellerBuyerController@cartEscrow']);
    Route::post('cart/get_status',                   ['as' => 'user.buyer.cart.getStatus',       'uses' => 'User\SellerBuyerController@getStatus']);
    Route::post('cart/get_confirm',                  ['as' => 'user.buyer.cart.getConfirm',      'uses' => 'User\SellerBuyerController@getConfirm']);
    Route::post('cart/document',                     ['as' => 'user.buyer.cart.document',      'uses' => 'User\SellerBuyerController@cartDocument']);
    Route::get('cart/email/{id}',                       ['as' => 'user.buyer.cart.email',            'uses' => 'User\SellerBuyerController@cartEmail']);


});
Route::group(['prefix' => 'member'], function () {
    Route::get('/',                     ['as' => 'user.member',                      'uses' => 'User\MemberController@index']);
    Route::get('password',              ['as' => 'user.member.password',             'uses' => 'User\MemberController@password']);
    Route::get('company',               ['as' => 'user.member.company',              'uses' => 'User\MemberController@company']);
    Route::get('video',                 ['as' => 'user.member.video',                'uses' => 'User\MemberController@video']);
    Route::get('product',               ['as' => 'user.member.product',              'uses' => 'User\MemberController@product']);
    Route::post('productDelete',        ['as' => 'user.member.productDelete',        'uses' => 'User\MemberController@productDelete']);
    Route::post('productUpload',        ['as' => 'user.member.productUpload',        'uses' => 'User\MemberController@productUpload']);
    Route::post('pictureStore',         ['as' => 'user.member.pictureStore',         'uses' => 'User\MemberController@pictureStore']);
    Route::post('videoStore',           ['as' => 'user.member.videoStore',           'uses' => 'User\MemberController@videoStore']);
    Route::post('companyStore',         ['as' => 'user.member.companyStore',         'uses' => 'User\MemberController@companyStore']);
    Route::post('passwordStore',        ['as' => 'user.member.passwordStore',         'uses' => 'User\MemberController@passwordStore']);
    Route::post('personal',             ['as' => 'user.member.personal',              'uses' => 'User\MemberController@personal']);
    Route::post('confirm',              ['as' => 'user.member.confirm',               'uses' => 'User\MemberController@confirm']);

});


Route::group(['prefix' => 'contact'], function () {
    Route::get('user/{id}',             ['as' => 'user.contact',               'uses' => 'User\ContactController@index']);
    Route::get('/',                     ['as' => 'user.contact.contact',       'uses' => 'User\ContactController@contact']);
    Route::post('contactSend',          ['as' => 'user.contact.contactSend',   'uses' => 'User\ContactController@contactSend']);
    Route::post('userMessage',          ['as' => 'user.contact.userMessage',   'uses' => 'User\ContactController@userMessage']);
});

Route::group(['prefix' => 'category'], function () {
    Route::get('/',                     ['as' => 'user.category',              'uses' => 'User\CategoryController@index']);
    Route::get('sub/{id}',              ['as' => 'user.category.sub',          'uses' => 'User\CategoryController@sub']);
    Route::get('product/{id}/{id2?}',   ['as' => 'user.category.product',      'uses' => 'User\CategoryController@product']);
    Route::get('search',                ['as' => 'user.category.search',       'uses' => 'User\CategoryController@search']);
});
Route::group(['prefix' => 'help'], function () {
    Route::get('/',                 ['as' => 'user.help',               'uses' => 'User\HelpController@index']);
    Route::post('getTitle',         ['as' => 'user.help.getTitle',      'uses' => 'User\HelpController@getTitle']);
    Route::get('search',            ['as' => 'user.help.search',        'uses' => 'User\HelpController@search']);
    Route::get('faq_list/{id}',     ['as' => 'user.help.faq_list',      'uses' => 'User\HelpController@faq_list']);
    Route::get('faq_item/{id}',     ['as' => 'user.help.faq_item',      'uses' => 'User\HelpController@faq_item']);
});

Route::group(['prefix' => 'user'], function () {
    Route::get('login',        ['as' => 'user.auth.login',          'uses' => 'User\AuthController@login']);
    Route::get('register',     ['as' => 'user.auth.register',       'uses' => 'User\AuthController@register']);
    Route::post('store',       ['as' => 'user.auth.store',          'uses' => 'User\AuthController@store']);
    Route::any('companystore', ['as' => 'user.auth.companystore',   'uses' => 'User\AuthController@companystore']);
    Route::get('company/{id}', ['as' => 'user.auth.company',        'uses' => 'User\AuthController@company']);
    Route::post('doLogin',     ['as' => 'user.auth.doLogin',        'uses' => 'User\AuthController@doLogin']);
    Route::get('forgot',       ['as' => 'user.auth.forgot',         'uses' => 'User\AuthController@forgot']);
    Route::any('forgotSend',   ['as' => 'user.auth.forgotSend',     'uses' => 'User\AuthController@forgotSend']);
    Route::any('doLogout',    ['as' => 'user.auth.doLogout',        'uses' => 'User\AuthController@doLogout']);
});
Route::group(['prefix' => 'admin'], function () {

    Route::get('/',              ['as' => 'admin.auth',                         'uses' => 'Admin\AuthController@index']);
    Route::get('login',          ['as' => 'admin.auth.login',                   'uses' => 'Admin\AuthController@login']);
    Route::post('doLogin',       ['as' => 'admin.auth.doLogin',                 'uses' => 'Admin\AuthController@doLogin']);
    Route::get('logout',         ['as' => 'admin.auth.logout',                  'uses' => 'Admin\AuthController@logout']);
    Route::any('capcha',         ['as' => 'admin.auth.capcha',                  'uses' => 'Admin\AuthController@capcha']);
    Route::get('dashboard',      ['as' => 'admin.dashboard',                    'uses' => 'Admin\DashboardController@index']);
    Route::get('profile',        ['as' => 'admin.profile',                      'uses' => 'Admin\ProfileController@index']);
    Route::post('profilestore',  ['as' => 'admin.profilestore',                 'uses' => 'Admin\ProfileController@store']);
    Route::any('searchResult',   ['as' => 'admin.dashboard.searchResult',       'uses' => 'Admin\DashboardController@searchResult']);
    Route::get('dump',          ['as' => 'admin.dashboard.dump',               'uses' => 'Admin\DashboardController@dump']);

    Route::group(['prefix' => 'freight'], function () {
        Route::get('/',           ['as' => 'admin.freight',         'uses' => 'Admin\FreightCodeController@index']);
        Route::get('create',      ['as' => 'admin.freight.create',  'uses' => 'Admin\FreightCodeController@create']);
        Route::post('store',      ['as' => 'admin.freight.store',   'uses' => 'Admin\FreightCodeController@store']);
        Route::get('edit/{id}',   ['as' => 'admin.freight.edit',    'uses' => 'Admin\FreightCodeController@edit']);
        Route::get('delete/{id}', ['as' => 'admin.freight.delete',   'uses' => 'Admin\FreightCodeController@delete']);
    });
    Route::group(['prefix' => 'country'], function () {
        Route::get('/',           ['as' => 'admin.country',         'uses' => 'Admin\CountryController@index']);
        Route::get('create',      ['as' => 'admin.country.create',  'uses' => 'Admin\CountryController@create']);
        Route::post('store',      ['as' => 'admin.country.store',   'uses' => 'Admin\CountryController@store']);
        Route::get('edit/{id}',   ['as' => 'admin.country.edit',    'uses' => 'Admin\CountryController@edit']);
        Route::get('delete/{id}', ['as' => 'admin.country.delete',   'uses' => 'Admin\CountryController@delete']);
    });
    Route::group(['prefix' => 'terms-conditions'], function () {
        Route::get('/',           ['as' => 'admin.terms_conditions',         'uses' => 'Admin\TermsController@index']);
        Route::get('create',      ['as' => 'admin.terms_conditions.create',  'uses' => 'Admin\TermsController@create']);
        Route::post('store',      ['as' => 'admin.terms_conditions.store',   'uses' => 'Admin\TermsController@store']);
        Route::get('edit/{id}',   ['as' => 'admin.terms_conditions.edit',    'uses' => 'Admin\TermsController@edit']);
        Route::get('delete/{id}', ['as' => 'admin.terms_conditions.delete',  'uses' => 'Admin\TermsController@delete']);
    });



    Route::group(['prefix' => 'quick_details'], function () {
        Route::get('/',                         ['as' => 'admin.quick',                 'uses' => 'Admin\QuickController@index']);
        Route::get('create',                    ['as' => 'admin.quick.create',          'uses' => 'Admin\QuickController@create']);
        Route::post('store',                    ['as' => 'admin.quick.store',           'uses' => 'Admin\QuickController@store']);
        Route::get('edit/{id}',                 ['as' => 'admin.quick.edit',            'uses' => 'Admin\QuickController@edit']);
        Route::get('delete/{id}',               ['as' => 'admin.quick.delete',          'uses' => 'Admin\QuickController@delete']);
        Route::post('categoryStore',            ['as' => 'admin.quick.categoryStore',   'uses' => 'Admin\QuickController@categoryStore']);
        Route::get('CategoryDelete/{id}',       ['as' => 'admin.quick.CategoryDelete',  'uses' => 'Admin\QuickController@CategoryDelete']);
        Route::post('categoryEdit',             ['as' => 'admin.quick.categoryEdit',   'uses' => 'Admin\QuickController@categoryEdit']);


    });
    Route::group(['prefix' => 'fee'], function () {
        Route::get('/',           ['as' => 'admin.fee',         'uses' => 'Admin\FeeController@index']);
        Route::get('create',      ['as' => 'admin.fee.create',  'uses' => 'Admin\FeeController@create']);
        Route::post('store',      ['as' => 'admin.fee.store',   'uses' => 'Admin\FeeController@store']);
        Route::get('edit/{id}',   ['as' => 'admin.fee.edit',    'uses' => 'Admin\FeeController@edit']);
        Route::get('delete/{id}', ['as' => 'admin.fee.delete',   'uses' => 'Admin\FeeController@delete']);
    });

    Route::group(['prefix' => 'email'], function () {
        Route::get('/',           ['as' => 'admin.email',         'uses' => 'Admin\EmailController@index']);
        Route::get('create',      ['as' => 'admin.email.create',  'uses' => 'Admin\EmailController@create']);
        Route::post('store',      ['as' => 'admin.email.store',   'uses' => 'Admin\EmailController@store']);
        Route::get('edit/{id}',   ['as' => 'admin.email.edit',    'uses' => 'Admin\EmailController@edit']);
        Route::get('delete/{id}', ['as' => 'admin.email.delete',   'uses' => 'Admin\EmailController@delete']);
    });
    Route::group(['prefix' => 'unit'], function () {
        Route::get('/',           ['as' => 'admin.unit',         'uses' => 'Admin\UnitController@index']);
        Route::get('create',      ['as' => 'admin.unit.create',  'uses' => 'Admin\UnitController@create']);
        Route::post('store',      ['as' => 'admin.unit.store',   'uses' => 'Admin\UnitController@store']);
        Route::get('edit/{id}',   ['as' => 'admin.unit.edit',    'uses' => 'Admin\UnitController@edit']);
        Route::get('delete/{id}', ['as' => 'admin.unit.delete',   'uses' => 'Admin\UnitController@delete']);
    });

    Route::group(['prefix' => 'factorysize'], function () {
        Route::get('/',           ['as' => 'admin.factorysize',         'uses' => 'Admin\FactorySizeController@index']);
        Route::get('create',      ['as' => 'admin.factorysize.create',  'uses' => 'Admin\FactorySizeController@create']);
        Route::post('store',      ['as' => 'admin.factorysize.store',   'uses' => 'Admin\FactorySizeController@store']);
        Route::get('edit/{id}',   ['as' => 'admin.factorysize.edit',    'uses' => 'Admin\FactorySizeController@edit']);
        Route::get('delete/{id}', ['as' => 'admin.factorysize.delete',   'uses' => 'Admin\FactorySizeController@delete']);
    });
    Route::group(['prefix' => 'business'], function () {
        Route::get('/',           ['as' => 'admin.business',         'uses' => 'Admin\BusinessController@index']);
        Route::get('create',      ['as' => 'admin.business.create',  'uses' => 'Admin\BusinessController@create']);
        Route::post('store',      ['as' => 'admin.business.store',   'uses' => 'Admin\BusinessController@store']);
        Route::get('edit/{id}',   ['as' => 'admin.business.edit',    'uses' => 'Admin\BusinessController@edit']);
        Route::get('delete/{id}', ['as' => 'admin.business.delete',   'uses' => 'Admin\BusinessController@delete']);
    });
    Route::group(['prefix' => 'product'], function () {
        Route::get('/',           ['as' => 'admin.product',         'uses' => 'Admin\ProductController@index']);
        Route::get('create',      ['as' => 'admin.product.create',  'uses' => 'Admin\ProductController@create']);
        Route::post('store',      ['as' => 'admin.product.store',   'uses' => 'Admin\ProductController@store']);
        Route::get('edit/{id}',   ['as' => 'admin.product.edit',    'uses' => 'Admin\ProductController@edit']);
        Route::get('delete/{id}', ['as' => 'admin.product.delete',   'uses' => 'Admin\ProductController@delete']);
    });
    Route::group(['prefix' => 'currency'], function () {
        Route::get('/',           ['as' => 'admin.currency',         'uses' => 'Admin\CurrencyController@index']);
        Route::get('create',      ['as' => 'admin.currency.create',  'uses' => 'Admin\CurrencyController@create']);
        Route::post('store',      ['as' => 'admin.currency.store',   'uses' => 'Admin\CurrencyController@store']);
        Route::get('edit/{id}',   ['as' => 'admin.currency.edit',    'uses' => 'Admin\CurrencyController@edit']);
        Route::get('delete/{id}', ['as' => 'admin.currency.delete',   'uses' => 'Admin\CurrencyController@delete']);
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('/',           ['as' => 'admin.category',         'uses' => 'Admin\CategoryController@index']);
        Route::get('create',      ['as' => 'admin.category.create',  'uses' => 'Admin\CategoryController@create']);
        Route::post('store',      ['as' => 'admin.category.store',   'uses' => 'Admin\CategoryController@store']);
        Route::get('edit/{id}',   ['as' => 'admin.category.edit',    'uses' => 'Admin\CategoryController@edit']);
        Route::get('delete/{id}', ['as' => 'admin.category.delete',   'uses' => 'Admin\CategoryController@delete']);
    });
    Route::group(['prefix' => 'subcategory'], function () {
        Route::get('/',           ['as' => 'admin.subcategory',         'uses' => 'Admin\SubCategoryController@index']);
        Route::get('create',      ['as' => 'admin.subcategory.create',  'uses' => 'Admin\SubCategoryController@create']);
        Route::post('store',      ['as' => 'admin.subcategory.store',   'uses' => 'Admin\SubCategoryController@store']);
        Route::get('edit/{id}',   ['as' => 'admin.subcategory.edit',    'uses' => 'Admin\SubCategoryController@edit']);
        Route::get('delete/{id}', ['as' => 'admin.subcategory.delete',   'uses' => 'Admin\SubCategoryController@delete']);
    });
    Route::group(['prefix' => 'members'], function () {
        Route::get('/',                  ['as' => 'admin.members',                      'uses' => 'Admin\MembersController@index']);
        Route::get('create',             ['as' => 'admin.members.create',               'uses' => 'Admin\MembersController@create']);
        Route::post('store',             ['as' => 'admin.members.store',                'uses' => 'Admin\MembersController@store']);
        Route::get('edit/{id}',          ['as' => 'admin.members.edit',                 'uses' => 'Admin\MembersController@edit']);
        Route::get('delete/{id}',        ['as' => 'admin.members.delete',               'uses' => 'Admin\MembersController@delete']);
        Route::get('view/{id}',          ['as' => 'admin.members.view',                 'uses' => 'Admin\MembersController@view']);
        Route::get('company/{id}',       ['as' => 'admin.members.company',              'uses' => 'Admin\MembersController@company']);
        Route::post('companystore',      ['as' => 'admin.members.companystore',         'uses' => 'Admin\MembersController@companystore']);
        Route::post('status',            ['as' => 'admin.members.status',               'uses' => 'Admin\MembersController@status']);
        Route::post('suspend',           ['as' => 'admin.members.suspend',              'uses' => 'Admin\MembersController@suspend']);
        Route::get('editcompany/{id}',   ['as' => 'admin.members.editcompany',          'uses' => 'Admin\MembersController@editcompany']);
        Route::get('sellerconfirm',      ['as' => 'admin.members.sellerconfirm',        'uses' => 'Admin\MembersController@sellerconfirm']);
        Route::get('confirmSeller/{id}', ['as' => 'admin.members.confirmSeller',        'uses' => 'Admin\MembersController@confirmSeller']);
        Route::any('viewSeller',         ['as' => 'admin.members.viewSeller',            'uses' => 'Admin\MembersController@viewSeller']);
        Route::post('confirmSellerAjax', ['as' => 'admin.members.confirmSellerAjax',    'uses' => 'Admin\MembersController@confirmSellerAjax']);
        Route::get('manageSeller',       ['as' => 'admin.members.manageSeller',         'uses' => 'Admin\MembersController@manageSeller']);
        Route::get('messageManagement',  ['as' => 'admin.members.messageManagement',    'uses' => 'Admin\MembersController@messageManagement']);

        Route::get('messageManagement/view/{id}',  ['as' => 'admin.members.messageManagementView',    'uses' => 'Admin\MembersController@messageManagementView']);
        Route::get('messageManagement/delete/{id}',  ['as' => 'admin.members.messageManagementDelete',    'uses' => 'Admin\MembersController@messageManagementDelete']);

        Route::get('messageManagement/rfq_view/{id}',  ['as' => 'admin.members.messageManagementRFQView',    'uses' => 'Admin\MembersController@messageManagementRFQView']);
        Route::get('messageManagement/rfq_delete/{id}',  ['as' => 'admin.members.messageManagementRFQDelete',    'uses' => 'Admin\MembersController@messageManagementRFQDelete']);


        Route::post('sendMessage',       ['as' => 'admin.members.sendMessage',          'uses' => 'Admin\MembersController@sendMessage']);
        Route::post('reject/{id}',       ['as' => 'admin.members.reject',               'uses' => 'Admin\MembersController@reject']);
    });

    Route::group(['prefix' => 'sampleRFQ'], function () {
        Route::get('/',                 ['as' => 'admin.samplerfq',         'uses' => 'Admin\SampleRFQController@index']);
        Route::get('approve/{id}',      ['as' => 'admin.samplerfq.approve',  'uses' => 'Admin\SampleRFQController@approve']);
        Route::post('message',          ['as' => 'admin.samplerfq.message',    'uses' => 'Admin\SampleRFQController@message']);
    });

    Route::group(['prefix' => 'listing'], function () {
        Route::group(['prefix' => 'rfq'], function () {
            Route::get('/',           ['as' => 'admin.rfq',         'uses' => 'Admin\RfqController@index']);
            Route::get('create',      ['as' => 'admin.rfq.create',  'uses' => 'Admin\RfqController@create']);
            Route::post('store',      ['as' => 'admin.rfq.store',   'uses' => 'Admin\RfqController@store']);
            Route::post('restore',    ['as' => 'admin.rfq.restore',   'uses' => 'Admin\RfqController@restore']);
            Route::get('edit/{id}',   ['as' => 'admin.rfq.edit',    'uses' => 'Admin\RfqController@edit']);
            Route::get('view/{id}',   ['as' => 'admin.rfq.view',    'uses' => 'Admin\RfqController@view']);
            Route::get('delete/{id}', ['as' => 'admin.rfq.delete',   'uses' => 'Admin\RfqController@delete']);
            Route::any('specificationPicutre',['as' => 'admin.rfq.specificationPicutre',   'uses' => 'Admin\RfqController@specificationPicutre']);
            Route::any('file',          ['as' => 'admin.rfq.file',   'uses' => 'Admin\RfqController@file']);

        });
        Route::group(['prefix' => 'post'], function () {
            Route::get('/',                         ['as' => 'admin.post',                  'uses' => 'Admin\PostController@index']);
            Route::get('create',                    ['as' => 'admin.post.create',           'uses' => 'Admin\PostController@create']);
            Route::post('store',                    ['as' => 'admin.post.store',            'uses' => 'Admin\PostController@store']);
            Route::post('getSubcategory',           ['as' => 'admin.post.getSubcategory',   'uses' => 'Admin\PostController@getSubcategory']);
            Route::get('edit/{id}',                 ['as' => 'admin.post.edit',             'uses' => 'Admin\PostController@edit']);
            Route::get('view/{id}/{id2?}',          ['as' => 'admin.post.view',             'uses' => 'Admin\PostController@view']);
            Route::get('delete/{id}',               ['as' => 'admin.post.delete',           'uses' => 'Admin\PostController@delete']);
            Route::get('add/{id}',                  ['as' => 'admin.post.add',              'uses' => 'Admin\PostController@add']);
            Route::get('editImage/{id}',            ['as' => 'admin.post.editImage',        'uses' => 'Admin\PostController@editImage']);
            Route::any('specificationPicutre',      ['as' => 'admin.post.specificationPicutre',   'uses' => 'Admin\PostController@specificationPicutre']);
            Route::post('imageStore',               ['as' => 'admin.post.imageStore',            'uses' => 'Admin\PostController@imageStore']);

        });
    });
    Route::group(['prefix' => 'help'], function () {
        Route::group(['prefix' => 'category'], function () {
            Route::get('/',           ['as' => 'admin.helpCategory',         'uses' => 'Admin\HelpCategoryController@index']);
            Route::get('create',      ['as' => 'admin.helpCategory.create',  'uses' => 'Admin\HelpCategoryController@create']);
            Route::post('store',      ['as' => 'admin.helpCategory.store',   'uses' => 'Admin\HelpCategoryController@store']);
            Route::get('edit/{id}',   ['as' => 'admin.helpCategory.edit',    'uses' => 'Admin\HelpCategoryController@edit']);
            Route::get('delete/{id}', ['as' => 'admin.helpCategory.delete',  'uses' => 'Admin\HelpCategoryController@delete']);
        });
        Route::group(['prefix' => 'subcategory'], function () {
            Route::get('/',           ['as' => 'admin.helpSubCategory',         'uses' => 'Admin\HelpSubCategoryController@index']);
            Route::get('create',      ['as' => 'admin.helpSubCategory.create',  'uses' => 'Admin\HelpSubCategoryController@create']);
            Route::post('store',      ['as' => 'admin.helpSubCategory.store',   'uses' => 'Admin\HelpSubCategoryController@store']);
            Route::get('edit/{id}',   ['as' => 'admin.helpSubCategory.edit',    'uses' => 'Admin\HelpSubCategoryController@edit']);
            Route::get('delete/{id}', ['as' => 'admin.helpSubCategory.delete',  'uses' => 'Admin\HelpSubCategoryController@delete']);
        });
        Route::group(['prefix' => 'creating'], function () {
            Route::get('/',                          ['as' => 'admin.helpCreating',                  'uses' => 'Admin\HelpController@index']);
            Route::get('create',                     ['as' => 'admin.helpCreating.create',           'uses' => 'Admin\HelpController@create']);
            Route::post('store',                     ['as' => 'admin.helpCreating.store',            'uses' => 'Admin\HelpController@store']);
            Route::get('edit/{id}',                  ['as' => 'admin.helpCreating.edit',             'uses' => 'Admin\HelpController@edit']);
            Route::get('delete/{id}',                ['as' => 'admin.helpCreating.delete',           'uses' => 'Admin\HelpController@delete']);
            Route::post('getSubCategory',            ['as' => 'admin.helpCreating.getSubCategory',   'uses' => 'Admin\HelpController@getSubCategory']);
        });
    });
    Route::group(['prefix' => 'escrow'], function () {
        Route::get('/',                             ['as' => 'admin.escrow',                            'uses' => 'Admin\EscrowController@index']);
        Route::get('commission',                    ['as' => 'admin.escrow.commission',                 'uses' => 'Admin\EscrowController@commission']);
        Route::get('commission/edit/{id}',          ['as' => 'admin.escrow.commission.edit',            'uses' => 'Admin\EscrowController@commissionEdit']);
        Route::post('commission/store',             ['as' => 'admin.escrow.commission.store',           'uses' => 'Admin\EscrowController@commissionStore']);
        Route::get('users',                         ['as' => 'admin.escrow.users',                      'uses' => 'Admin\EscrowController@users']);
        Route::get('users/create',                  ['as' => 'admin.escrow.users.create',               'uses' => 'Admin\EscrowController@usersCreate']);
        Route::get('users/edit/{id}',               ['as' => 'admin.escrow.users.edit',                 'uses' => 'Admin\EscrowController@usersEdit']);
        Route::post('users/store',                  ['as' => 'admin.escrow.users.store',                'uses' => 'Admin\EscrowController@usersStore']);
        Route::get('users/delete/{id}',             ['as' => 'admin.escrow.users.delete',               'uses' => 'Admin\EscrowController@usersDelete']);
        Route::get('pages',                         ['as' => 'admin.escrow.pages',                       'uses' => 'Admin\EscrowController@pages']);
        Route::get('pages/create',                  ['as' => 'admin.escrow.pages.create',               'uses' => 'Admin\EscrowController@pagesCreate']);
        Route::get('pages/edit/{id}',               ['as' => 'admin.escrow.pages.edit',                 'uses' => 'Admin\EscrowController@pagesEdit']);
        Route::post('pages/store',                  ['as' => 'admin.escrow.pages.store',                'uses' => 'Admin\EscrowController@pagesStore']);
        Route::get('payments',                      ['as' => 'admin.escrow.payments',                   'uses' => 'Admin\EscrowController@payments']);
        Route::post('payments/confirm',             ['as' => 'admin.escrow.paymentsConfirm',            'uses' => 'Admin\EscrowController@paymentsConfirm']);
        Route::get('payments/dispute/{id}',         ['as' => 'admin.escrow.dispute',                    'uses' => 'Admin\EscrowController@dispute']);
        Route::post('payments/disputeSolve',        ['as' => 'admin.escrow.disputeSolve',               'uses' => 'Admin\EscrowController@disputeSolve']);
        Route::post('paymentEscrow/Edit',           ['as' => 'admin.escrow.paymentEscrowEdit',          'uses' => 'Admin\EscrowController@paymentEscrowEdit']);
        Route::post('getPaymentEscrowEdit',         ['as' => 'admin.escrow.getPaymentEscrowEdit',       'uses' => 'Admin\EscrowController@getPaymentEscrowEdit']);
        Route::post('getUserEmailAddress',          ['as' => 'admin.escrow.getUserEmailAddress',        'uses' => 'Admin\EscrowController@getUserEmailAddress']);
        Route::post('sendUserEmailAddress',         ['as' => 'admin.escrow.sendUserEmailAddress',       'uses' => 'Admin\EscrowController@sendUserEmailAddress']);
        Route::post('sendDisputeEmail',             ['as' => 'admin.escrow.sendDisputeEmail',           'uses' => 'Admin\EscrowController@sendDisputeEmail']);

        Route::group(['prefix' => 'electronic'], function () {
            Route::get('/',                          ['as' => 'admin.escrow.electronic',                          'uses' => 'Admin\ElectronicController@index']);
            Route::post('store',                     ['as' => 'admin.escrow.electronic.store',                    'uses' => 'Admin\ElectronicController@store']);
        });
        Route::group(['prefix' => 'email'], function () {
            Route::get('/',                          ['as' => 'admin.escrow.email',                               'uses' => 'Admin\ElectronicController@emailIndex']);
            Route::get('create',                     ['as' => 'admin.escrow.email.create',                        'uses' => 'Admin\ElectronicController@emailCreate']);
            Route::post('store',                     ['as' => 'admin.escrow.email.store',                         'uses' => 'Admin\ElectronicController@emailStore']);
            Route::get('edit/{id}',                  ['as' => 'admin.escrow.email.edit',                          'uses' => 'Admin\ElectronicController@emailEdit']);
            Route::get('delete/{id}',                ['as' => 'admin.escrow.email.delete',                        'uses' => 'Admin\ElectronicController@emailDelete']);
        });

        Route::group(['prefix' =>'home'],function(){
            Route::get('/',                          ['as' => 'admin.home.bargain',                               'uses' => 'Admin\DashboardController@bargain']);
            Route::get('create',                     ['as' => 'admin.home.bargain.create',                        'uses' => 'Admin\DashboardController@bargainCreate']);
            Route::get('store/{id}',                 ['as' => 'admin.home.bargain.store',                         'uses' => 'Admin\DashboardController@bargainStore']);
            Route::get('delete/{id}',                  ['as' => 'admin.home.bargain.delete',                      'uses' => 'Admin\DashboardController@bargainDelete']);
        });
        Route::group(['prefix' =>'shoppingCart'],function(){
            Route::group(['prefix' =>'faq'],function(){
                Route::get('/',                          ['as' => 'admin.shoppingCart.description',                               'uses' => 'Admin\ShoppingCartDescriptionController@index']);
                Route::get('create',                     ['as' => 'admin.shoppingCart.description.create',                        'uses' => 'Admin\ShoppingCartDescriptionController@create']);
                Route::post('store',                     ['as' => 'admin.shoppingCart.description.store',                         'uses' => 'Admin\ShoppingCartDescriptionController@store']);
                Route::get('edit/{id}',                  ['as' => 'admin.shoppingCart.description.edit',                          'uses' => 'Admin\ShoppingCartDescriptionController@edit']);
                Route::get('delete/{id}',                ['as' => 'admin.shoppingCart.description.delete',                        'uses' => 'Admin\ShoppingCartDescriptionController@delete']);
            });
            Route::group(['prefix' =>'conditions'],function(){
                Route::get('/',                          ['as' => 'admin.shoppingCart.conditions',                               'uses' => 'Admin\ShoppingCartConditionsController@index']);
                Route::get('create',                     ['as' => 'admin.shoppingCart.conditions.create',                        'uses' => 'Admin\ShoppingCartConditionsController@create']);
                Route::post('store',                     ['as' => 'admin.shoppingCart.conditions.store',                         'uses' => 'Admin\ShoppingCartConditionsController@store']);
                Route::get('edit/{id}',                  ['as' => 'admin.shoppingCart.conditions.edit',                          'uses' => 'Admin\ShoppingCartConditionsController@edit']);
                Route::get('delete/{id}',                ['as' => 'admin.shoppingCart.conditions.delete',                        'uses' => 'Admin\ShoppingCartConditionsController@delete']);
            });
            Route::group(['prefix' =>'privacy'],function(){
                Route::get('/',                          ['as' => 'admin.shoppingCart.privacy',                               'uses' => 'Admin\ShoppingCartPrivacyController@index']);
                Route::get('create',                     ['as' => 'admin.shoppingCart.privacy.create',                        'uses' => 'Admin\ShoppingCartPrivacyController@create']);
                Route::post('store',                     ['as' => 'admin.shoppingCart.privacy.store',                         'uses' => 'Admin\ShoppingCartPrivacyController@store']);
                Route::get('edit/{id}',                  ['as' => 'admin.shoppingCart.privacy.edit',                          'uses' => 'Admin\ShoppingCartPrivacyController@edit']);
                Route::get('delete/{id}',                ['as' => 'admin.shoppingCart.privacy.delete',                        'uses' => 'Admin\ShoppingCartPrivacyController@delete']);
            });
            Route::group(['prefix' =>'payment'], function(){
                Route::get('/{id?}',                     ['as' => 'admin.shoppingCart.payment',                                     'uses' => 'Admin\ShoppingCartPaymentController@index']);
                Route::get('delete/{id}',                ['as' => 'admin.shoppingCart.payment.delete',                              'uses' => 'Admin\ShoppingCartPaymentController@delete']);
                Route::get('show/{id}',                  ['as' => 'admin.shoppingCart.payment.show',                                'uses' => 'Admin\ShoppingCartPaymentController@show']);
                Route::get('confirm/{id}',               ['as' => 'admin.shoppingCart.payment.confirm',                             'uses' => 'Admin\ShoppingCartPaymentController@confirm']);
            });
        });

    });
});