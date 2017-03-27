<?php
namespace App;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use App\User;
use App\Payment;
use App\AuthorizeNetResponse;

class AuthorizeNet {

    public function __construct()
    {
        $this->merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $this->merchantAuthentication->setName( config('payment.loginID') );
        $this->merchantAuthentication->setTransactionKey( config('payment.transKey') );
        $this->prefix = env('AUTHORIZE_NET_PREFIX', 'll');
        $this->refId = $this->prefix.'-'.time();
    }

    public function charge($customerProfileId,$customerPaymentProfileId,$amount,$paymentId,$items)
    {
        $invoiceNum = $this->prefix.'-'.$paymentId;

        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($invoiceNum);

        $profileToCharge = new AnetAPI\CustomerProfilePaymentType();
        $profileToCharge->setCustomerProfileId($customerProfileId);
        $paymentProfile  = new AnetAPI\PaymentProfileType();
        $paymentProfile->setPaymentProfileId($customerPaymentProfileId);
        $profileToCharge->setPaymentProfile($paymentProfile);

        foreach($items as $item) {
            $lineItem = new AnetAPI\LineItemType();
            $lineItem->setItemId($item['id']);
            $lineItem->setName($item['name']);
            $lineItem->setDescription($item['description']);
            $lineItem->setQuantity($item['qty']);
            $lineItem->setUnitPrice($item['price']);
            $lineItem->setTaxable(0); // 1 Yes 0 for no
            $lineItem_Array[] = $lineItem;
        }

        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType('authCaptureTransaction');
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setProfile($profileToCharge);
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setLineItems($lineItem_Array);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($this->refId);
        $request->setTransactionRequest($transactionRequestType);

        $controller = new AnetController\CreateTransactionController($request);
        $response   = $controller->executeWithApiResponse(constant('\net\authorize\api\constants\ANetEnvironment::'.config('payment.environment')) );
        if(is_null($response)) {
            return config('define.valid.false');
        }

        $res = new AuthorizeNetResponse($response, $response->getTransactionResponse());
        \Log::info('Function cahrge');
        \Log::info((array)$res);

        return $res;

    }

    public function saveProfileTo($cardNum,$cardExpiry,$cardCode,$userId,$email)
    {
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNum);
        $creditCard->setExpirationDate($cardExpiry);
        $creditCard->setCardCode($cardCode);
        $paymentCreditCard = new AnetAPI\PaymentType();
        $paymentCreditCard->setCreditCard($creditCard);

        $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $paymentProfile->setCustomerType('individual');
        $paymentProfile->setPayment($paymentCreditCard);
        $paymentProfiles[] = $paymentProfile;

        $customerProfile = new AnetAPI\CustomerProfileType();
        $customerProfile->setMerchantCustomerId($this->prefix.'-'.$userId);
        $customerProfile->setEmail($email);
        $customerProfile->setPaymentProfiles($paymentProfiles);

        $request = new AnetAPI\CreateCustomerProfileRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($this->refId);
        $request->setProfile($customerProfile);

        $controller = new AnetController\CreateCustomerProfileController($request);
        $response = $controller->executeWithApiResponse(constant('\net\authorize\api\constants\ANetEnvironment::'.config('payment.environment')) );

        if(is_null($response)) {
            return config('define.valid.false');
        }

        $res = new AuthorizeNetResponse($response);
        \Log::info('Function saveProfileTo');
        \Log::info((array)$res);

        if ( $res->isError() == config('define.valid.false') ) {
            $paymentProfileAN = $response->getCustomerPaymentProfileIdList();
            $res->customer_profile_id = $response->getCustomerProfileId();
            $res->customer_payment_profile_id = $paymentProfileAN[0];
        }

        return $res;
    }

    public function getProfile($customerProfileId, $customerPaymentProfileId)
    {
        $request = new AnetAPI\GetCustomerPaymentProfileRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($this->refId);
        $request->setCustomerProfileId($customerProfileId);
        $request->setCustomerPaymentProfileId($customerPaymentProfileId);

        $controller = new AnetController\GetCustomerPaymentProfileController($request);
        $response = $controller->executeWithApiResponse(constant('\net\authorize\api\constants\ANetEnvironment::'.config('payment.environment')) );
        
        if(is_null($response)) {
            return config('define.valid.false');
        }

        $res = new AuthorizeNetResponse($response);
        \Log::info('Function getProfile');
        \Log::info((array)$res);

        if ($res->isError() ==  config('define.valid.false')) {
            $res->cardNum = $response->getPaymentProfile()->getPayment()->getCreditCard()->getCardNumber();
        }

        return $res;
    }

    public function refund($cardNum,$amount,$refTransId,$paymentId,$items)
    {
        $invoiceNum = $this->prefix.'-'.$paymentId;

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNum);
        $creditCard->setExpirationDate("XXXX");
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        foreach($items as $item) {
            $lineItem = new AnetAPI\LineItemType();
            $lineItem->setItemId($item['id']);
            $lineItem->setName($item['name']);
            $lineItem->setDescription($item['description']);
            $lineItem->setQuantity($item['qty']);
            $lineItem->setUnitPrice($item['price']);
            $lineItem->setTaxable(0); // 1 Yes 0 for no
            $lineItem_Array[] = $lineItem;
        }

        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($invoiceNum);
        //create a transaction
        $transactionRequest = new AnetAPI\TransactionRequestType();
        $transactionRequest->setTransactionType( "refundTransaction"); 
        $transactionRequest->setAmount($amount);
        $transactionRequest->setPayment($paymentOne);
        $transactionRequest->setOrder($order);
        $transactionRequest->setRefTransId($refTransId);
        $transactionRequest->setLineItems($lineItem_Array);
     
        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($this->refId);
        $request->setTransactionRequest( $transactionRequest);
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse(constant('\net\authorize\api\constants\ANetEnvironment::'.config('payment.environment')) );
        
        if(is_null($response)) {
            return config('define.valid.false');
        }

        $res = new AuthorizeNetResponse($response, $response->getTransactionResponse());
        \Log::info('Function refund');
        \Log::info((array)$res);

        return $res;
    }

    public function createCustomerPaymentProfile($existingcustomerprofileid, $cardNum,$cardExpiry,$cardCode)
    {
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNum);
        $creditCard->setExpirationDate($cardExpiry);
        $creditCard->setCardCode($cardCode);
        $paymentCreditCard = new AnetAPI\PaymentType();
        $paymentCreditCard->setCreditCard($creditCard);

        $paymentprofile = new AnetAPI\CustomerPaymentProfileType();
        $paymentprofile->setCustomerType('individual');
        $paymentprofile->setPayment($paymentCreditCard);

        $paymentprofiles[] = $paymentprofile;

        $paymentprofilerequest = new AnetAPI\CreateCustomerPaymentProfileRequest();
        $paymentprofilerequest->setMerchantAuthentication($this->merchantAuthentication);
        $paymentprofilerequest->setCustomerProfileId( $existingcustomerprofileid );
        $paymentprofilerequest->setPaymentProfile( $paymentprofile );
        $controller = new AnetController\CreateCustomerPaymentProfileController($paymentprofilerequest);
        $response = $controller->executeWithApiResponse( constant('\net\authorize\api\constants\ANetEnvironment::'.config('payment.environment')));

        if (is_null($response)) {
            return config('define.valid.false');
        }

        $res = new AuthorizeNetResponse($response);
        \Log::info('Function createCustomerPaymentProfile');
        \Log::info((array)$res);

        if ( $res->isError() ==  config('define.valid.false')) {
            $res->customer_payment_profile_id = $response->getCustomerPaymentProfileId();
        }

        return $res;
    }

    public function getCustomerProfile($cardNum,$cardExpiry,$cardCode,$userId,$email,$customerProfileId)
    {
        $card_no_input = 'XXXX'.substr($cardNum,-4);

        $request = new AnetAPI\GetCustomerProfileRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setCustomerProfileId($customerProfileId);
        $controller = new AnetController\GetCustomerProfileController($request);
        $response = $controller->executeWithApiResponse( constant('\net\authorize\api\constants\ANetEnvironment::'.config('payment.environment')));

        if (is_null($response)) {
            return config('define.valid.false');
        }

        $res = new AuthorizeNetResponse($response);
        \Log::info('Function getCustomerProfile');
        \Log::info((array)$res);

        if ( $res->isError() ==  config('define.valid.false')){
            $profileSelected = $response->getProfile();
            $paymentProfiles = $profileSelected->getPaymentProfiles();

            $update_profile = $this->updateCustomerProfile($customerProfileId,$userId,$email);
            if( $update_profile->isError() != config('define.valid.false') ) {
                return $update_profile;
            }

            $cardNumbers = array();
            $paymentIds  = array();
            if($paymentProfiles != null) {
                foreach($paymentProfiles as $profile) {
                    $card_no = $profile->getPayment()->getCreditCard()->getCardNumber();
                    $payment_id = $profile->getCustomerPaymentProfileId();
                    array_push($cardNumbers,$card_no);
                    $paymentIds[$card_no] = $payment_id; 
                }

                if(!in_array($card_no_input,$cardNumbers)) {
                    $new_payment_profile = $this->createCustomerPaymentProfile($customerProfileId,$cardNum,$cardExpiry,$cardCode);
                    if( $new_payment_profile->isError() != config('define.valid.false')) {
                        return $new_payment_profile;
                    }
                    $res->customer_profile_id         = $customerProfileId;
                    $res->customer_payment_profile_id = $new_payment_profile->customer_payment_profile_id;
                } else {
                    $update_payment_profile = $this->updateCustomerPaymentProfile($cardNum,$cardExpiry,$cardCode,$customerProfileId,$paymentIds[$card_no_input]);
                    if( $update_payment_profile->isError() != config('define.valid.false') ) {
                        return $update_payment_profile;
                    }
                    $res->customer_profile_id           = $customerProfileId;
                    $res->customer_payment_profile_id   = $paymentIds[$card_no_input];
                }
            } else {
                $new_payment_profile = $this->createCustomerPaymentProfile($customerProfileId,$cardNum,$cardExpiry,$cardCode);
                if( $new_payment_profile->isError() != config('define.valid.false') ) {
                    return $new_payment_profile;
                }
                $res->customer_profile_id         = $customerProfileId;
                $res->customer_payment_profile_id = $new_payment_profile->customer_payment_profile_id;
            }
        }

        return $res;
    }

    public function updateCustomerPaymentProfile($cardNum,$cardExpiry,$cardCode,$customerProfileId,$customerPaymentProfileId)
    {
        $request = new AnetAPI\UpdateCustomerPaymentProfileRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setCustomerProfileId($customerProfileId);
        $controller = new AnetController\GetCustomerProfileController($request);

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNum);
        $creditCard->setExpirationDate($cardExpiry);
        $creditCard->setCardCode($cardCode);
        $paymentCreditCard = new AnetAPI\PaymentType();
        $paymentCreditCard->setCreditCard($creditCard);

        $paymentprofile = new AnetAPI\CustomerPaymentProfileExType();
        $paymentprofile->setCustomerPaymentProfileId($customerPaymentProfileId);
        $paymentprofile->setPayment($paymentCreditCard);

        $request->setPaymentProfile( $paymentprofile );
        $controller = new AnetController\UpdateCustomerPaymentProfileController($request);
        $response = $controller->executeWithApiResponse( constant('\net\authorize\api\constants\ANetEnvironment::'.config('payment.environment')));

        if (is_null($response)) {
            return config('define.valid.false');
        }

        $res = new AuthorizeNetResponse($response);
        \Log::info('Function updateCustomerPaymentProfile');
        \Log::info((array)$res);

        return $res;
    }

    public function updateCustomerProfile($customerProfileId,$userId,$email)
    {
        $updatecustomerprofile = new AnetAPI\CustomerProfileExType();
        $updatecustomerprofile->setCustomerProfileId($customerProfileId);
        $updatecustomerprofile->setMerchantCustomerId($this->prefix.'-'.$userId);
        $updatecustomerprofile->setEmail($email);

        $request = new AnetAPI\UpdateCustomerProfileRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($this->refId);
        $request->setProfile($updatecustomerprofile);

        $controller = new AnetController\UpdateCustomerProfileController($request);
        $response = $controller->executeWithApiResponse(constant('\net\authorize\api\constants\ANetEnvironment::'.config('payment.environment')) );

        if (is_null($response)) {
            return config('define.valid.false');
        }

        $res = new AuthorizeNetResponse($response);
        \Log::info('Function updateCustomerProfile');
        \Log::info((array)$res);

        return $res;
    }

}
