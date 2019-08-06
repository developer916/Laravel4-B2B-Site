<?php namespace User;

use Illuminate\Routing\Controllers\Controller;

use View, Input, Redirect, Session, Validator, DB, Mail, File, Request, Response, Lang, URL, Cart;
use Product as ProductModel, ProductPicture as ProductPictureModel, GetCurrency as GetCurrencyModel, Category as CategoryModel,
    SubCategory as SubCategoryModel, UserCategory as UserCategoryModel, Currency as CurrencyModel, CompanyProfile as CompanyProfileModel,
    Business as BusinessModel, ProductFocus as ProductFocusModel, Employees as EmployeesModel, FactorySize as FactorySizeModel,
    ProductQuickDetail as ProductQuickDetailModel, ProductAdditionalCategory as ProductAdditionalCategoryModel,
    Country as CountryModel, ProductAdditionalImage as ProductAdditionalImageModel, ProductShipping as ProductShippingModel,
    Fee as FeeModel, EscrowMessageTemplate as EscrowMessageTemplateModel, ShoppingCart as ShoppingCartModel, Members as MembersModel,
    ShoppingCartProduct as ShoppingCartProductModel, ShoppingCartDescription as ShoppingCartDescriptionModel, ShoppingCartConditionPrivacy as ShoppingCartConditionPrivacyModel;

class CartController extends \BaseController
{
    public function addCart()
    {
        $productID = Input::get('product_id');
        $product = ProductModel::find($productID);
        $productImage = ProductPictureModel::whereRaw('product_id =?', array($productID))->get();

    }

    public function showProduct($id, $id2 = false)
    {
        $productID = $id - 100000;
        $param['pageNo'] = 145;


        $param['mainProductPicture'] = ProductPictureModel::WhereRaw('product_id=?', array($productID))->get();
        if ($id2 == false) {
            $param['productPicture'] = ProductPictureModel::WhereRaw('product_id=?', array($productID))->get();
            $param['main'] = 0;
            $param['id'] = 0;
        } else {
            $param['main'] = 1;
            $param['id'] = $id2;
            $param['productAdditionalCategory'] = ProductAdditionalCategoryModel::find($id2);
            $param['productPicture'] = ProductAdditionalImageModel::whereRaw('product_id =? and product_additional_category_id= ?', array($productID, $id2))->get();
        }


        $param['category'] = CategoryModel::whereRaw(true)->orderBy('categoryname', 'asc')->get();
        $listID = $id - 100000;
        $product = ProductModel::find($listID);

        $productPrice1 = 0;
        $productPrice2 = 0;
        $productPrice3 = 0;

        if (count($product) > 0) {
            $nowDate = date('Y-m-d');
            if ($product->change_date == "") {
                $differenceDate = "2";
            } else {
                $previousDate = $product->change_date;
                $date1 = date_create($previousDate);
                $date2 = date_create($nowDate);
                $diff = date_diff($date1, $date2);

                $differenceDate = $diff->format("%a");
            }
            if ($differenceDate >= 1) {
                if ($product->productCurrencyPrice1->currency_name != "USD") {
                    $currencyName = strtoupper($product->productCurrencyPrice1->currency_name);
                    $productPrice1 = GetCurrencyModel::getCurrencyFunction($currencyName, $product->product_price1);
                } else {
                    $productPrice1 = $product->product_price1;
                }

                if ($product->productCurrencyPrice2->currency_name != "USD") {
                    $currencyName = strtoupper($product->productCurrencyPrice2->currency_name);
                    $productPrice2 = GetCurrencyModel::getCurrencyFunction($currencyName, $product->product_price2);
                } else {
                    $productPrice2 = $product->product_price2;
                }
                if ($product->productCurrencyPrice3->currency_name != "USD") {
                    $currencyName = strtoupper($product->productCurrencyPrice3->currency_name);
                    $productPrice3 = GetCurrencyModel::getCurrencyFunction($currencyName, $product->product_price3);
                } else {
                    $productPrice3 = $product->product_price3;
                }
                $product->price_usd1 = round($productPrice1, 2);
                $product->price_usd2 = round($productPrice2, 2);
                $product->price_usd3 = round($productPrice3, 2);
                $product->change_date = $nowDate;
                $product->save();
            }
        }

        $productShipping = ProductShippingModel::whereRaw('product_id =?', array($listID))->first();
        if (count($productShipping) > 0) {
            $productShippingPrice1 = "";
            $productShippingPrice2 = "";
            $productShippingPrice3 = "";
            $nowDate = date('Y-m-d');
            if ($productShipping->change_date == "") {
                $differenceDate = "2";
            } else {
                $previousDate = $productShipping->change_date;
                $date1 = date_create($previousDate);
                $date2 = date_create($nowDate);
                $diff = date_diff($date1, $date2);
                $differenceDate = $diff->format("%a");
            }
            if ($differenceDate >= 1) {
                if ($productShipping->shipping_type1 == 1) {
                    $currencyName = strtoupper($productShipping->flatRate1->currency_name);
                    $productShippingPrice1 = GetCurrencyModel::getCurrencyFunction($currencyName, $productShipping->flat_rate1);
                }
                if ($productShipping->shipping_type2 == 1) {
                    $currencyName = strtoupper($productShipping->flatRate2->currency_name);
                    $productShippingPrice2 = GetCurrencyModel::getCurrencyFunction($currencyName, $productShipping->flat_rate2);
                }
                if ($productShipping->shipping_type3 == 1) {
                    $currencyName = strtoupper($productShipping->flatRate3->currency_name);
                    $productShippingPrice3 = GetCurrencyModel::getCurrencyFunction($currencyName, $productShipping->flat_rate3);
                }
                $productShipping->price_usd1 = round($productShippingPrice1, 2);
                $productShipping->price_usd2 = round($productShippingPrice2, 2);
                $productShipping->price_usd3 = round($productShippingPrice3, 2);
                $productShipping->change_date = $nowDate;
                $productShipping->save();
            }
        }
        $param['helps'] = ProductModel::find($listID);
        $param['product'] = ProductModel::find($listID);
        $userID = $param['helps']->user_id;
        $param['companyProfile'] = CompanyProfileModel::whereRaw('user_id = ?', array($userID))->get();
        $param['business_type'] = BusinessModel::find($param['companyProfile'][0]->busineestype);
        $param['productfocus'] = ProductFocusModel::find($param['companyProfile'][0]->mainforcus);
        $param['employees'] = EmployeesModel::find($param['companyProfile'][0]->employees);
        $param['factorysize'] = FactorySizeModel::find($param['companyProfile'][0]->factorysize);
        $param['quickDetails'] = ProductQuickDetailModel::whereRaw('product_id= ?', array($listID))->get();
//        $param['productShipping'] =  ProductShippingModel::whereRaw('product_id =?', array($listID))->first();
        $param['productAdditionalCategorySize'] = ProductAdditionalCategoryModel::whereRaw('product_id = ? and role= ?', array($listID, 0))->get();
        $param['productAdditionalCategoryColor'] = ProductAdditionalCategoryModel::whereRaw('product_id = ? and role= ?', array($listID, 1))->get();
        return View::make('user.sellerbuyer.showProduct')->with($param);
    }

    public function selectAddCart()
    {
        $productID = Input::get('productID');
        $reallyProduct = $productID - 100000;
        $product = ProductModel::find($reallyProduct);
        if ($product->user_id == Session::get('user_id')) {
            return Response::json(['result' => 'failed', 'message' =>Lang::get('missing.You_can_not_buy_this_product_Because_this_product_has_been_posted_by_you')]);
        } else {
            $qty = Input::get('qty');
            $size = Input::get('size');
            $unit = Input::get('unit');
            $imageUrl = Input::get('image_url');
            $subID = Input::get('main_id');
            if ($imageUrl != "") {
                $urls = explode("?", $imageUrl);
                $image = $urls[0];
            } else {
                $image = "";
            }
            $color = "";
            if ($subID != 0) {
                $productAdditionalCategory = ProductAdditionalCategoryModel::find($subID);
                $color = $productAdditionalCategory->values;
            } else {
                $productAdditionalCategoryList = ProductAdditionalCategoryModel::whereRaw('product_id =? and role = ?', array($reallyProduct, 1))->get();
                if (count($productAdditionalCategoryList) > 0) {
                    foreach ($productAdditionalCategoryList as $key_category => $value_category) {
                        if ($key_category == count($productAdditionalCategoryList) - 1) {
                            $color .= $value_category->values;
                        } else {
                            $color .= $value_category->values . "/";
                        }
                    }
                }
            }
            $productShipping = ProductShippingModel::whereRaw('product_id =?', array($reallyProduct))->first();
            $product = ProductModel::find($reallyProduct);
            $price = 0;
            $shippingMethod = "";
            $shippingPrice = "";
            $shippingPrice_unit = "";
            $price_unit = "";
            if ($qty < 100) {
                $price = $product->price_usd1;
                if (count($productShipping) > 0) {
                    if ($productShipping->shipping_type1 == 1) {
                        $shippingMethod = "Shipping";
                        $shippingPrice = $productShipping->price_usd1;
                    } else if ($productShipping->shipping_type1 == 2) {
                        $shippingMethod = "Free Shipping";
                    } else {
                        $shippingMethod = "Cargo Shipping";
                    }
                }

            } else if ($qty >= 100 && $qty < 500) {
                $price = $product->price_usd2;
                if (count($productShipping) > 0) {

                    if ($productShipping->shipping_type2 == 1) {
                        $shippingMethod = "Shipping";
                        $shippingPrice = $productShipping->price_usd2;
                    } else if ($productShipping->shipping_type2 == 2) {
                        $shippingMethod = "Free Shipping";
                    } else {
                        $shippingMethod = "Cargo Shipping";
                    }
                }
            } else if ($qty >= 500) {
                $price = $product->price_usd3;
                if (count($productShipping) > 0) {
                    if ($productShipping->shipping_type3 == 1) {
                        $shippingMethod = "Shipping";
                        $shippingPrice = $productShipping->price_usd3;
                    } else if ($productShipping->shipping_type3 == 2) {
                        $shippingMethod = "Free Shipping";
                    } else {
                        $shippingMethod = "Cargo Shipping";
                    }

                }
            }
            $randomValue = $this->invoicenumber(10);
            Cart::add(array('id' => $productID, 'name' => $product->product_name, 'qty' => $qty, 'price' => $price, 'options' => array('size' => $size, 'indexID' => $randomValue, 'url' => $image, 'price_unit' => $price_unit,
                'unit' => $unit, 'subID' => $subID, 'shipping_method' => $shippingMethod, 'shipping_price' => $shippingPrice, 'shipping_price_unit' => $shippingPrice_unit, 'color' => $color)));
            return Response::json(['result' => 'success', 'url' => URL::route('user.addCart.index')]);
        }

    }

    public function showIndex()
    {
        $param['pageNo'] = 145;
        $param['contents'] = Cart::content();
        $fees = FeeModel::all();
        if (count($fees) > 0) {
            $param['escrow_fee'] = $fees[0]->fee;
        } else {
            $param['escrow_fee'] = 15;
        }
        $param['country'] = CountryModel::whereRaw(true)->orderBy('country_name', 'asc')->get();
        $param['electronic'] = EscrowMessageTemplateModel::whereRaw('type=?', array('electronic'))->get();
        $param['countries'] = CountryModel::whereRaw(true)->orderBy('country_name', 'asc')->get();
        $param['descriptions'] = ShoppingCartDescriptionModel::all();
        return View::make('user.sellerbuyer.addCart')->with($param);
    }

    public function changeCart()
    {
        $id = Input::get('id');
        $productID = Input::get('productID');
        $reallyID = $productID - 100000;
        $qty = Input::get('qty');
        $rowId = Input::get('row');

        $product = ProductModel::find($reallyID);
        $shippingPrice = "";
        $shippingMethod = "";
        $shippingPrice_unit = "";
        $subTotalShipping = 0;
        if ($qty < $product->min_order) {
            $row = Cart::get($rowId);
            $subTotal = round($row->qty * round($row->price, 2), 2);
            $subTotalPrice = $subTotal;
            if ($row->options->shipping_price != "") {
                $subTotalShipping = round(round($row->options->shipping_price, 2) * $row->qty, 2);
            }
            $reallyTotal = "$" . number_format(round($subTotalPrice + $subTotalShipping, 2), 2) . " " . "USD";
            $subPrice = "&nbsp;$" . number_format($row->price, 2) . "USD<br>";
            if ($row->options->shipping_price != "") {
                $subPrice .= "+$" . number_format($row->options->shipping_price, 2) . "USD";
            }
            $text = Lang::get('user.add_cart_product_error') . " " . $product->min_order . $product->minOrderUnit->unitname;
            $data = array('result' => 'failed', 'qty' => $row->qty, 'product_id' => $id,
                'list' => $text, 'reallyTotal' => $reallyTotal, 'subPrice' => $subPrice,
                'indexID' => $row->options->indexID);
        } else {
            $productShipping = ProductShippingModel::whereRaw('product_id =?', array($reallyID))->first();
            $shippingPrice = "";
            $shippingMethod = "";
            $shippingPrice_unit = "";
            $price_unit = "";
            $subTotalShipping = 0;
            if ($qty < 100) {
                $price_list = $product->price_usd1;
                if (count($productShipping) > 0) {
                    if ($productShipping->shipping_type1 == 1) {
                        $shippingMethod = "Shipping";
                        $shippingPrice = $productShipping->price_usd1;
                    } else if ($productShipping->shipping_type1 == 2) {
                        $shippingMethod = "Free Shipping";
                    } else {
                        $shippingMethod = "Cargo Shipping";
                    }
                }

            } else if ($qty < 500) {
                $price_list = $product->price_usd2;
                if (count($productShipping) > 0) {
                    if ($productShipping->shipping_type2 == 1) {
                        $shippingMethod = "Shipping";
                        $shippingPrice = $productShipping->price_usd2;
                    } else if ($productShipping->shipping_type2 == 2) {
                        $shippingMethod = "Free Shipping";
                    } else {
                        $shippingMethod = "Cargo Shipping";
                    }
                }
            } else {
                $price_list = $product->price_usd3;
                if (count($productShipping) > 0) {
                    if ($productShipping->shipping_type3 == 1) {
                        $shippingMethod = "Shipping";
                        $shippingPrice = $productShipping->price_usd3;
                    } else if ($productShipping->shipping_type3 == 2) {
                        $shippingMethod = "Free Shipping";
                    } else {
                        $shippingMethod = "Cargo Shipping";
                    }
                }
            }
            $shippingText = "";
            $shippingText = $shippingMethod;
            if ($shippingPrice != "") {
                $shippingText .= "  $" . $shippingPrice . "USD";
            }
            if ($shippingMethod == "Cargo Shipping") {
                $shippingText .= '<a href="javascript:void(0)" onclick="onShowCargo()"><i class="fa   fa-question-circle font-red"></i> </a>';
            }

            $subPrice = "&nbsp; $" . number_format($price_list, 2) . ".USD<br>";
            if ($shippingPrice != "") {
                $subPrice .= "+$" . number_format($shippingPrice, 2) . "USD";
            }
            Cart::update($rowId, array('qty' => $qty, 'price' => $price_list, 'options' => array('price_unit' => $price_unit, 'shipping_method' => $shippingMethod, 'shipping_price' => $shippingPrice, 'shipping_price_unit' => $shippingPrice_unit)));
            Cart::content();
            $row = Cart::get($rowId);
            $subTotal = $row->qty * round($row->price, 2);
            $subTotalPrice = round($row->subtotal, 2);

            if ($row->options->shipping_price != "") {
                $subTotalShipping = round(round($row->options->shipping_price, 2) * $row->qty, 2);
            }

            $reallyTotal = "$" . number_format(round($subTotalPrice + $subTotalShipping, 2), 2) . " " . "USD";
            $contents = Cart::content();
            $total_value = 0;
            foreach ($contents as $key_content => $value_content) {
                $price = round($value_content->price, 2);
                $subTotal = round($price * $value_content->qty, 2);
                $total_value = $total_value + $subTotal;
                if ($value_content->options->shipping_price != "") {
                    $subTotalShipping = round(round($value_content->options->shipping_price, 2) * $value_content->qty, 2);
                    $total_value = $total_value + $subTotalShipping;
                }
            }
            $fees = FeeModel::all();
            if (count($fees) > 0) {
                $escrow_fee = $fees[0]->fee;
            } else {
                $escrow_fee = 15;
            }
            $escrowFee = round(($escrow_fee / 100) * $total_value, 2);
            $reallyTotalValue = "$" . number_format(round($total_value, 2) + $escrowFee, 2) . " USD";
            $reallySubTotalValue = "$" . number_format(round($total_value, 2), 2) . " USD";
            if ((round($total_value, 2) + $escrowFee) > 500) {
                $indexCheck = 1;
            } else {
                $indexCheck = 0;
            }
            $data = array('result' => 'success', 'list' => $reallyTotal, 'id' => $rowId, 'total' => $reallyTotalValue,
                'subPrice' => $subPrice, 'product_id' => $id, 'escrowFee' => "$" . $escrowFee . " USD", 'indexID' => $row->options->indexID,
                'shippingMethod' => $shippingMethod, 'shippingText' => $shippingText, 'reallySubTotalValue' => $reallySubTotalValue,
                'inputEscrowFee' => $escrowFee, 'inputReallySubTotalValue' => number_format(round($total_value, 2), 2), 'indexCheck' => $indexCheck,
                'inputReallyTotalValue' => number_format(round($total_value, 2) + $escrowFee, 2));
        }
        return Response::json($data);
    }

    public function removeCart()
    {
        $id = Input::get('id');
        $rowId = Input::get('row');
        Cart::remove($rowId);
        $total_value = 0;
        $contents = Cart::content();
        foreach ($contents as $key_content => $value_content) {
            $subTotal = round(($value_content->qty * round($value_content->price, 2)), 2);
            $total_value = $total_value + $subTotal;

            if ($value_content->options->shipping_price != "") {
                $subTotalShipping = round(round($value_content->options->shipping_price, 2) * $value_content->qty, 2);
                $total_value = $total_value + $subTotalShipping;
            }
        }
        $reallySubTotalValue = "$" . number_format(round($total_value, 2), 2) . " USD";
        $fees = FeeModel::all();
        if (count($fees) > 0) {
            $escrow_fee = $fees[0]->fee;
        } else {
            $escrow_fee = 15;
        }
        $escrowFee = round(($escrow_fee / 100) * $total_value, 2);
        $reallyTotalValue = "$" . number_format(round($total_value, 2) + $escrowFee, 2) . " USD";
        if ((round($total_value, 2) + $escrowFee) > 500) {
            $indexCheck = 1;
        } else {
            $indexCheck = 0;
        }
        $data = array('result' => 'success', 'list' => Lang::get('user.product_remove_successfully'),
            'id' => $id, 'total' => $reallyTotalValue, 'escrowFee' => "$" . number_format($escrowFee, 2) . " USD",
            'subTotal' => $reallySubTotalValue, 'indexID' => $id, 'inputEscrowFee' => number_format($escrowFee, 2),
            'inputReallySubTotalValue' => number_format(round($total_value, 2), 2), 'indexCheck' => $indexCheck,
            'inputReallyTotalValue' => number_format(round($total_value, 2) + $escrowFee, 2));
        return Response::json($data);
    }

    function invoicenumber($len)
    {
        $strpattern = "1234567890";
        $result = "";
        for ($i = 0; $i < $len; $i++) {
            $rand = rand(0, strlen($strpattern) - 1);
            $result = $result . $strpattern[$rand];
        }
        return $result;
    }


    public function saveCart()
    {
        $rules = [
            'input_totalPrice' => 'required | min:0.1',
            'type' => 'required'
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $shoppingCart = new ShoppingCartModel;
            $shoppingCart->type = Input::get('type');
            $shoppingCart->total = Input::get('input_totalPrice');
            $shoppingCart->escrowFee = Input::get('input_escrowPrice');
            $shoppingCart->subTotal = Input::get('input_subTotalValue');
            $shoppingCart->billing_firstname = Input::get('billing_firstname');
            $shoppingCart->billing_lastname = Input::get('billing_lastname');
            $shoppingCart->billing_email = Input::get('billing_email');
            $shoppingCart->billing_phone = Input::get('billing_phone');
            $shoppingCart->billing_address1 = Input::get('billing_address1');
            $shoppingCart->billing_address2 = Input::get('billing_address2');
            $shoppingCart->billing_city = Input::get('billing_city');
            $shoppingCart->billing_state = Input::get('billing_state');
            $shoppingCart->billing_zip = Input::get('billing_zip');
            $shoppingCart->billing_country = Input::get('billing_country');

            $shoppingCart->shipping_firstname = Input::get('shipping_firstname');
            $shoppingCart->shipping_lastname = Input::get('shipping_lastname');
            $shoppingCart->shipping_email = Input::get('shipping_email');
            $shoppingCart->shipping_phone = Input::get('shipping_phone');
            $shoppingCart->shipping_address1 = Input::get('shipping_address1');
            $shoppingCart->shipping_address2 = Input::get('shipping_address2');
            $shoppingCart->shipping_city = Input::get('shipping_city');
            $shoppingCart->shipping_state = Input::get('shipping_state');
            $shoppingCart->shipping_zip = Input::get('shipping_zip');
            $shoppingCart->shipping_country = Input::get('shipping_country');
            $shoppingCart->status = 1;
            $shoppingCart->buyer_id = Session::get('user_id');
            $shoppingCart->invoice_number = $this->shoppinginvoicenumber(15);
            $shoppingCart->save();
            $contents = Cart::content();
            $emails = [];
            foreach ($contents as $key_content => $value_content) {
                $product = ProductModel::find(($value_content->id) - 100000);
                $ShoppingCartProductModel = new ShoppingCartProductModel;
                $ShoppingCartProductModel->cart_id = $shoppingCart->id;
                $ShoppingCartProductModel->product_id = ($value_content->id) - 100000;
                $ShoppingCartProductModel->unit = $value_content->options->unit;
                $ShoppingCartProductModel->qty = $value_content->qty;
                $ShoppingCartProductModel->size = $value_content->options->size;
                $ShoppingCartProductModel->color = $value_content->options->color;
                $ShoppingCartProductModel->image_url = $value_content->options->url;
                $ShoppingCartProductModel->product_price = $value_content->price;
                $ShoppingCartProductModel->shipping_price = $value_content->options->shipping_price;
                $ShoppingCartProductModel->shipping_method = $value_content->options->shipping_method;

                $subTotal = $value_content->qty * round($value_content->price, 2);
                $subTotalShipping = 0;
                if ($value_content->options->shipping_price != "") {
                    $subTotalShipping = $value_content->qty * round($value_content->options->shipping_price, 2);
                }
                $ShoppingCartProductModel->sub_total = ($subTotal + $subTotalShipping);
                $ShoppingCartProductModel->seller_id = $product->user_id;
                $ShoppingCartProductModel->buyer_id = Session::get('user_id');
                $ShoppingCartProductModel->status = 1;
                $ShoppingCartProductModel->save();
            }
            $billingEmail = Input::get('billing_email');
            $shippingEmail = Input::get('shipping_email');
            $buyer = MembersModel::find(Session::get('user_id'));
            $buyerEmails = [];
            $buyerEmails[0] = $buyer->email;
            if ($buyer->email != $billingEmail) {
                $countBuyerEmail = count($buyerEmails);
                $buyerEmails[$countBuyerEmail] = $billingEmail;
            }
            if ($buyer->email != $shippingEmail && $shippingEmail != $billingEmail) {
                $countBuyerEmail = count($buyerEmails);
                $buyerEmails[$countBuyerEmail] = $shippingEmail;
            }
            $contents = Cart::content();
            $title = "Order Confirmation";
            $escrowFee =FeeModel::all();
            $escrowFeeRate = (($escrowFee[0]->fee)/100);
            $shippingCountryID = Input::get('shipping_country');
            $country = CountryModel::find($shippingCountryID);
            $data = array(
                'contents' => $contents,
                'title' => "Order Confirmation",
                'customer_name' => $buyer->firstname . " " . $buyer->lastname,
                'description' => "Thank you for shopping with us. We’ll send a confirmation when your items ship.",
                'escrowFeeRate' =>$escrowFeeRate,
                'shipping_address' =>Input::get('shipping_address1'),
                'shipping_zip' =>Input::get('shipping_zip'),
                'shipping_city' =>Input::get('shipping_city'),
                'shipping_state' =>Input::get('shipping_state'),
                'shipping_country' =>$country->country_name,

            );
            Mail::send('emails.shoppingCart.buyerOrderConfirm', $data, function ($message) use ($buyerEmails, $title) {
                $message->from('noreply@purchasetree.com', $title);
                $message->to($buyerEmails, $title)->subject($title);
            });


            foreach ($contents as $key_content => $value_content) {
                $product = ProductModel::find(($value_content->id) - 100000);
                $sellerID = $product->user_id;
                $seller = MembersModel::find($sellerID);
                $title = "Buyer has been bought this product by ".$buyer->firstname." ". $buyer->lastname;
                if($value_content->options->subID != ""){
                    $url = URL::route('user.showProduct', array($value_content->id, $value_content->options->subID));
                }else{
                    $url = URL::route('user.showProduct', array($value_content->id));
                }
                $sellerEmail = $seller->email;
                $data = array(
                    'content' =>$value_content,
                    'sellerName' =>$seller->firstname." ".$seller->lastname,
                    'url' => $url,
                    'productName' =>$product->product_name,
                    'title' =>$title,
                    'sellerDashboard' =>URL::route('user.seller.dashboard'),
                );
                Mail::send('emails.shoppingCart.sellerOrderConfirm', $data, function ($message) use ($sellerEmail, $title) {
                    $message->from('noreply@purchasetree.com', $title);
                    $message->to($sellerEmail, $title)->subject($title);
                });
            }

            Cart::destroy();
            return Redirect::route('user.addCart.payment', 100000 * 1 + $shoppingCart->id);
        }
    }

    public function payment($id)
    {
        $param['pageNo'] = 145;
        $listID = $id - 100000;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['electronic'] = EscrowMessageTemplateModel::whereRaw('type=?', array('electronic'))->get();
        $param['shoppingCart'] = ShoppingCartModel::find($listID);
        return View::make('user.sellerbuyer.payment')->with($param);
    }

    public function credit()
    {
        $rules = [
            'card_no' => 'required',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'total' => 'required',
            'address' => 'required',
            'zipCode' => 'required',
            'email' => 'required|email',
            'cvv2' => 'required',
            'shoppingCart' => 'required|integer'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        } else {

            $id = Input::get('shoppingCart');

            $reallyID = $id;
            $shoppingCart = ShoppingCartModel::find($reallyID);
            $totalPrice = $shoppingCart->total;

            $listData = array();
            $listData['Total'] = $totalPrice;
            $listData['ePNAccount'] = escrow_payment_account;
            $listData['CardNo'] = Input::get('card_no');
            $listData['ExpMonth'] = Input::get('exp_month');
            $listData['ExpYear'] = Input::get('exp_year');
            $listData['Address'] = Input::get('address');
            $listData['Zip'] = Input::get('zipCode');
            $listData['EMail'] = Input::get('email');
            $listData['CVV2Type'] = "1";
            $listData['CVV2'] = Input::get('cvv2');
            $listData['RestrictKey'] = escrow_RestrictKey;
            $listData['HTML'] = "No";
            $listData['TranType'] = "Sale";


            $inputsString = http_build_query($listData);

            $url = "https://www.eprocessingnetwork.com/cgi-bin/tdbe/transact.pl";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_URL, str_replace(' ', '%20', $url));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, str_replace(' ', '%20', $inputsString));
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            $server_output = curl_exec($ch);
            curl_close($ch);

            if ($server_output[1] != "Y") {
                if ($server_output[1] == "U") {
                    $result = Lang::get('alert.Unable_to_perform_the_transaction');
                    $status = "failed";
                    $alert['msg'] = $result;
                    $alert['type'] = "danger";
                } else {
                    $result = Lang::get('alert.Declined');
                    $status = "failed";
                    $alert['msg'] = $result;
                    $alert['type'] = "danger";
                }
            } else {
                $list = explode(",", $server_output);
                $listFirst = explode('"', $list[0]);
                $listFirst = explode(" ", $listFirst[1]);
                $listSecond = explode('"', $list[1]);
                $avsResponse = $listSecond[1];
                $listFifth = explode('"', $list[2]);
                $cvvResponse = $listFifth[1];
                $listThird = explode('"', $list[3]);
                $listFourth = explode('"', $list[4]);
                $InvoiceNumber = $listThird[1];
                $tracsactionID = $listFourth[1];
                $result = "Approved. Your invoice number is " . $InvoiceNumber;
                $status = "success";
                $shoppingCart->approved_invoice_number = $InvoiceNumber;
                $shoppingCart->paid = 1;
                $shoppingCart->save();
                $alert['msg'] = Lang::get('alert.Your_payment_has_been_send_successfully');
                $alert['type'] = "success";
                $email = $shoppingCart->billing_email;
                $title = "Paid successfully";
                $sendMessage = Lang::get('alert.You_has_been_paid_successfully_When_admin_confirm_about_your_payment_it_will_be_in_the_escrow');
                $data = array(
                    'escrow_register_url' => URL::route('user.escrow.register'),
                    'escrow_login_url' => URL::route('user.escrow.login'),
                    'sendMessage' => $sendMessage,
                    'title' => $title
                );

                Mail::send('emails.shoppingCart.creditPaid', $data, function ($message) use ($email, $title) {
                    $message->from('noreply@purchasetree.com', $title);
                    $message->to($email, $title)->subject($title);
                });
            }

            return Redirect::back()->with('alert', $alert);
        }
    }

    public function getUserStatus()
    {
        $index = Session::get('user_id');
        if ($index == "") {
            $index = 0;
        }
        $data = array();
        $data['index'] = $index;
        return Response::json($data);
    }

    public function userLogin()
    {
        $rules = ['username' => 'required',
            'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
            //'g-recaptcha-response' => 'required|captcha',
        ];

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(['result' => 'failed', 'error' => $validator->getMessageBag()->toArray()]);
        } else {
            $username = Input::get('username');
            $password = Input::get('password');
            $list = MembersModel::whereRaw('username = ? and userpassword = md5(?) and status = ? and email_status = ?', array($username, $password, '1', '1'))->get();
            if (count($list) > 0) {
                Session::set('user_id', $list[0]->id);
                Session::set('user_type', $list[0]->usertype);
                $message = Lang::get('cart.login_success');
                return Response::json(['result' => 'success', 'loginCheck' => 1, 'message' => $message]);
            } else {
                $message = Lang::get('cart.login_failed');
                return Response::json(['result' => 'success', 'loginCheck' => 0, 'message' => $message]);
            }
        }
    }

    public function userSignUp()
    {
        $rules = [
            'username' => 'required |unique:member',
            'userpassword' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
            'firstname' => 'required ',
            'lastname' => 'required',
            'email' => 'required |email|unique:member',
            'address' => 'required ',
            'city' => 'required ',
            'country' => 'required ',
            'zipcode' => 'required ',
            'phone_number' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(['result' => 'failed', 'error' => $validator->getMessageBag()->toArray()]);
        } else {
            $member = new MembersModel;
            $member_id = "";
            $password = Input::get('userpassword');
            $usertype = 2;
            $member->username = Input::get('username');
            $member->userpassword = md5($password);
            $member->firstname = Input::get('firstname');
            $member->lastname = Input::get('lastname');
            $member->email = Input::get('email');
            $member->street = Input::get('address');
            $member->city = Input::get('city');
            $member->state = Input::get('state');
            $member->country_id = Input::get('country');
            $member->zipcode = Input::get('zipcode');
            $member->phonenumber = Input::get('phone_number');
            $member->workingnumber = Input::get('working_number');
            $member->companyname = Input::get('company_name');
            $member->usertype = $usertype;
            $member->suspend = 0;
            $member->sellrequest = 0;
            $member->sellconfirm = 0;
            $member->previostype = 0;
            $member->changeDate = '';
            if ($usertype == "2") {
                $member->status = 1;
            }
            $member->save();
            if ($usertype == "2") {
                $userID = $member->id;
                $companyProfile = CompanyProfileModel::whereRaw('user_id =?', array($userID))->get();
                if (count($companyProfile) == 0) {
                    $company = new CompanyProfileModel;
                    $company->user_id = $userID;
                    $company->save();
                }
            }
            $memberToken = MembersModel::find($userID);
            $email = $memberToken->email;
            $name = ucfirst($memberToken->firstname) . " " . ucfirst($memberToken->lastname);
            $url = URL::route('user.verifyEmail', ($userID + 100000 * 1));
            $data = array(
                'name' => $name,
                'url' => $url,
            );
            Mail::send('emails.verifyEmail', $data, function ($message) use ($email) {
                $message->from('noreply@purchasetree.com', Lang::get('alert.Please_verify_your_email_address'));
                $message->to($email,  Lang::get('alert.Send_Message'))->subject( Lang::get('alert.Please_verify_your_email_address'));
            });


            return Response::json(['result' => 'success', 'message' => Lang::get('cart.check_email_message')]);
        }

    }

    function shoppinginvoicenumber($len)
    {
        $strpattern = "ABCDEFGHJKLMNPQRSTUVWXYZ1234567890";
        $result = "";
        for ($i = 0; $i < $len; $i++) {
            $rand = rand(0, strlen($strpattern) - 1);
            $result = $result . $strpattern[$rand];
        }
        return $result;
    }

    public function cartPrivacyConditions()
    {
        $flag = Input::get('flag');
        $results = ShoppingCartConditionPrivacyModel::whereRaw('flag =?', array($flag))->get();
        $list = "";
        $list .= '<div class="row">';
        foreach ($results as $key => $result) {
            $list .= '<div class="col-md-12 margin-bottom-30">';
            $list .= '<p>';
            $list .= nl2br($result->description);
            $list .= '</p>';
            $list .= '</div>';
        }
        $list .= '</div>';
        if ($flag == "privacy") {
            $title = "Privacy of purchasetree";
        } else {
            $title = "Conditions of purchasetree";
        }

        $data = array('result' => 'success', 'content' => $list, 'title' => $title);
        return Response::json($data);
    }


    public function cartInvoice($product_id){
        $really_product_id = $product_id - 100000;
        if ($alert = Session::get('alert')) {
            $param['alert'] = $alert;
        }
        $param['pageNo'] = 12;
        $param['shoppingCartProduct'] = ShoppingCartProductModel::find($really_product_id);
        $seller =$param['shoppingCartProduct']->seller;
        $buyer = $param['shoppingCartProduct']->buyer;
        $sellerCountry  = CountryModel::find($seller->country_id);
        $buyerCountry = CountryModel::find($buyer->country_id);
        $param['seller'] = $seller;
        $param['buyer'] = $buyer;
        $param['sellerCountry'] = $sellerCountry;
        $param['buyerCountry'] = $buyerCountry;
        $param['fee'] = FeeModel::whereRaw(true)->first();
        return View::make('user.sellerbuyer.shoppingCartInvoice')->with($param);
    }
}
