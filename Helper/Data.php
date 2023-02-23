<?php

namespace COZYVISION\Smsalert\Helper;

use \Magento\Framework\App\ObjectManager as ObjectManager;
use \Magento\Framework\Event\Observer as Observer;
use \Magento\Store\Model\ScopeInterface as ScopeInterface;
use \Magento\Framework\App\Helper\AbstractHelper as AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * This will used by smsalert sms admins to confirm which e-commerce platform is sending sms
     * @var string
     */
    private $platform         = 'Magento';
    /**
     * The version of e-commerce platform
     * @var string
     */
    private $platformVersion  = '2.0';
    /**
     * Return type of api method
     * @var string
     */
    private $format           = 'json';
    /**
     * To be used by the API
     * @var string
     */
    private $host             = 'aHR0cHM6Ly93d3cuc21zYWxlcnQuY28uaW4v';

    /**
     * Getting Basic Configuration
     * These functions are used to get the api username and password
     */

    /**
     * Getting SmsalertSMS API Username
     * @return string
     */
    public function getSmsalertUsername()
    {
        return $this->getConfig('cozyvision_smsalert_configuration/basic_configuration/smsalert_username');
    }

    /**
     * Getting SmsalertSMS API Password
     * @return string
     */
    public function getSmsalertPassword()
    {
        return $this->getConfig('cozyvision_smsalert_configuration/basic_configuration/smsalert_password');
    }

    /**
     * Checking Admin SMS is enabled or not
     * @return string
     */
    public function isAdminSmsIsEnabled()
    {
        return $this->getConfig('cozyvision_smsalert_admins/admin_configuration/smsalert_admin_enabled');
    }

    /**
     * Getting Admin Mobile Number
     * @return string
     */
    public function getAdminSenderId()
    {
        return $this->getConfig('cozyvision_smsalert_admins/admin_configuration/smsalert_admin_mobile');
    }

    /**
     * Getting admin message for new order
     * @return string
     */
    public function getAdminSmsOnNewOrder()
    {
        return $this->getConfig('cozyvision_smsalert_admins/admin_configuration/smsalert_new_order_admin_message');
    }

    /**
     * Getting Admin message for order Hold
     * @return string
     */
    public function getAdminSmsForOrderHold()
    {
        return $this->getConfig('cozyvision_smsalert_admins/admin_configuration/smsalert_hold_admin_message');
    }
	
	/**
     * Getting Admin message for order Hold
     * @return string
     */
    public function getAdminSmsForOrderShipped()
    {
        return $this->getConfig('cozyvision_smsalert_admins/admin_configuration/smsalert_shipped_admin_message');
    }

    /**
     * Getting Admin message for order unhold
     * @return string
     */
    public function getAdminSmsForOrderUnHold()
    {
        return $this->getConfig('cozyvision_smsalert_admins/admin_configuration/smsalert_unhold_admin_message');
    }

    /**
     * Getting Admin message for order cancelled
     * @return string
     */
    public function getAdminSmsForOrderCancelled()
    {
        return $this->getConfig('cozyvision_smsalert_admins/admin_configuration/smsalert_cancelled_admin_message');
    }

    /**
     * Getting Admin message for Invoiced
     * @return string
     */
    public function getAdminSmsForInvoiced()
    {
        return $this->getConfig('cozyvision_smsalert_admins/admin_configuration/smsalert_invoiced_admin_message');
    }
	
	/**
     * Getting Admin message for Credit Memo
     * @return string
     */
    public function getAdminSmsForCreditmemo()
    {
        return $this->getConfig('cozyvision_smsalert_admins/admin_configuration/smsalert_creditmemo_admin_message');
    }


    /**
     * Getting Admin message for Sign up
     * @return string
     */
    public function getAdminSmsForRegister()
    {
        return $this->getConfig('cozyvision_smsalert_admins/admin_configuration/smsalert_register_admin_message');
    }

    /**
     * Getting Customer Configuration
     * These functions are used to get the customer information when new order is placed
     */

    /**
     * Checking Customer SMS is enabled or not
     * @return string
     */
    public function isCustomerSmsIsEnabledOnOrder()
    {
        return $this->getConfig('cozyvision_smsalert_orders/new_order/smsalert_new_order_enabled');
    }

    /**
     * Getting Customer Sender ID
     * @return string
     */
    public function getCustomerId()
    {
        return $this->getConfig('cozyvision_smsalert_configuration/basic_configuration/smsalert_new_order_sender_id');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerSmsOnOrder()
    {
        return $this->getConfig('cozyvision_smsalert_orders/new_order/smsalert_new_order_message');
    }

    /**
     * Getting Customer Configuration
     * These functions are used to get the customer information when order is on hold
     */

    /**
     * Checking Customer SMS is enabled or not
     * @return string
     */
    public function isCustomerSmsIsEnabledOnHold()
    {
        return $this->getConfig('cozyvision_smsalert_orders/hold_order/smsalert_hold_order_enabled');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerSmsOnHold()
    {
        return $this->getConfig('cozyvision_smsalert_orders/hold_order/smsalert_hold_order_message');
    }
	
	/**
     * Checking Customer SMS is enabled or not on shipped
     * @return string
     */
    public function isCustomerSmsIsEnabledOnShipped()
    {
        return $this->getConfig('cozyvision_smsalert_orders/shipped_order/smsalert_shipped_order_enabled');
    }
	
	/**
     * Getting Customer Message on shipped
     * @return string
     */
    public function getCustomerSmsOnShipped()
    {
        return $this->getConfig('cozyvision_smsalert_orders/shipped_order/smsalert_shipped_order_message');
    }

    /**
     * Getting Customer Configuration
     * These functions are used to get the customer information when order is on un hold
     */

    /**
     * Checking Customer SMS is enabled or not
     * @return string
     */
    public function isCustomerSmsIsEnabledOnUnHold()
    {
        return $this->getConfig('cozyvision_smsalert_orders/unhold_order/smsalert_unhold_order_enabled');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerSmsOnUnHold()
    {
        return $this->getConfig('cozyvision_smsalert_orders/unhold_order/smsalert_unhold_order_message');
    }

    /**
     * Getting Customer Configuration
     * These functions are used to get the customer information when order is Cancelled
     */

    /**
     * Checking Customer SMS is enabled or not
     * @return string
     */
    public function isCustomerSmsIsEnabledOnCancelled()
    {
        return $this->getConfig('cozyvision_smsalert_orders/cancelled_order/smsalert_cancelled_order_enabled');
    }

    

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerSmsOnCancelled()
    {
        return $this->getConfig('cozyvision_smsalert_orders/cancelled_order/smsalert_cancelled_order_message');
    }

    /**
     * Getting Customer Configuration
     * These functions are used to get the customer information when invoice is created
     */

    /**
     * Checking Customer SMS is enabled or not
     * @return string
     */
    public function isCustomerSmsIsEnabledOnInvoiced()
    {
        return $this->getConfig('cozyvision_smsalert_orders/invoiced_order/smsalert_invoiced_order_enabled');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerSmsOnInvoiced()
    {
        return $this->getConfig('cozyvision_smsalert_orders/invoiced_order/smsalert_invoiced_order_message');
    }
	
	/**
     * Checking Customer SMS is enabled or not
     * @return string
     */
    public function isCustomerSmsIsEnabledOnCreditmemo()
    {
        return $this->getConfig('cozyvision_smsalert_orders/credit_memo/smsalert_credit_memo_enabled');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerSmsOnCreditmemo()
    {
        return $this->getConfig('cozyvision_smsalert_orders/credit_memo/smsalert_credit_memo_message');
    }
	
	/**
     * Checking Customer SMS is enabled or not
     * @return string
     */
    public function isCustomerSmsIsEnabledOnRegister()
    {
        return $this->getConfig('cozyvision_smsalert_orders/customer_register/smsalert_customer_register_enabled');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerSmsOnRegister()
    {
        return $this->getConfig('cozyvision_smsalert_orders/customer_register/smsalert_customer_register_message');
    }

    /**
     * The Basics:
     * These functions are used to do the basic functionality
     */

    /**
     * Send Configuration path to this function and get the module admin Config data
     * @param @var $configPath
     * @return string
     */
    public function getConfig($configPath)
    {
        return $this->scopeConfig->getValue($configPath, ScopeInterface::SCOPE_STORE);
    }
	
	 /**
     * Curl Function to get the result from SmsalertSMS API
     * @param @var $url
     * @return string
     */
    public function curl($url)
    {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_ENCODING, "");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // required for https urls
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);				
		$content = curl_exec($ch);
		if (curl_errno($ch)) {
			$this->getResponse()->setBody('Request Error:' . curl_error($ch));
		}
	
		curl_close($ch);
		return $content;
		
        //return file_get_contents($url);
    }

    /**
     * Verification of API Account
     * @param @var $username
     * @param @var $password
     * @return bool
     */
    public function verifyApi($username, $password)
    {
        $host       = base64_decode($this->host);
        $path       = base64_decode("YXBpL2NyZWRpdHN0YXR1cy5qc29u");
        $data       = '?user='.urlencode($username).'&pwd='.urlencode($password);
        $url        = $host.$path.$data;
        $verified   = $this->curl($url);
        $verified   = json_decode($verified, true);
        if (array_key_exists('status', $verified) && ($verified['status'] == 'success')) {
            return true;
        }
        return false;
    }

    /**
     * Sending SMS
     * @param @var $username
     * @param @var $password
     * @param @var $senderID
     * @param @var $destination
     * @param @var $message
     * @return void
     */
    public function sendSms($username, $password, $senderID, $destination, $message)
    {
        $host      = base64_decode($this->host);
        $path       = base64_decode('YXBpL3B1c2guanNvbj8=');
        $data       = 'user='.urlencode($username).
                      '&pwd='.urlencode($password).
                      '&mobileno='.urlencode($this->formatNumber($destination)).
                      '&sender='.urlencode($senderID).
                      '&text='.urlencode($message);
        $url        = $host.$path.$data;
        $this->curl($url);
    }
	
	/**
     * Getting Credits
     * @param @var $username
     * @param @var $password
     * @return bool|string
     */
    public function getCredit($username, $password)
    {
        $host       = base64_decode($this->host);
        $path       = base64_decode("YXBpL2NyZWRpdHN0YXR1cy5qc29u");
        $data       = '?user='.urlencode($username).'&pwd='.urlencode($password);
        $url        = $host.$path.$data;
        $verified   = $this->curl($url);
        $verified   = json_decode($verified);
        if (array_key_exists('status', $verified) && ($verified['status'] == 'success')) {
            return number_format($verified['description']['routes'][0]['credits'], 2);
        }
        return false;
    }

    /**
     * Insert Admin Config Values in the message using order data
     * @param @var $message
     * @param @var $data
     * @return string
     */
    public function manipulateSMS($message, $data)
    {
        $keywords   = [
            '{orderId}',
			'{storeName}',
            '{firstname}',
            '{middlename}',
            '{lastname}',
            '{totalPrice}',
            '{countryCode}',
            '{protectCode}',
            '{customerDob}',
            '{customerEmail}',
            '{gender}',
            '{trackingId}',
            '{carrierName}',
        ];
        $message = str_replace($keywords, $data, $message);
        return $message;
    }

    /**
     * The Fetchers
     * These functions are used to fetch the details using observer
     */

    /**
     * Getting Products
     * @param Observer $observer
     * @return string
     */
    public function getProduct(Observer $observer)
    {
        $productId          = $observer->getProduct()->getId();
        $objectManager      = ObjectManager::getInstance();
        $product            = $objectManager->get('Magento\Catalog\Model\Product')->load($productId);
        return $product;
    }

    /**
     * Getting Order Details
     * @param Observer $observer
     * @return string
     */
    public function getOrder(Observer $observer)
    {
        $order              = $observer->getOrder();
        $orderId            = $order->getIncrementId();
        $objectManager      = ObjectManager::getInstance();
        $order              = $objectManager->get('Magento\Sales\Model\Order');
        $orderInformation   = $order->loadByIncrementId($orderId);
        return $orderInformation;
    }
	
	/**
     * Getting country for sms
     * @return integer
     */
    public function getCountryCode()
    {
        return $this->getConfig('cozyvision_smsalert_configuration/basic_configuration/smsalert_country');
    }
	
	/**
     * Check Countyr Code added if not
     * @param @var $number
     * @return number
     */
    public function formatNumber($number)
    {
		$country_code = $this->getCountryCode();
		$number = preg_replace('/\D/', '', $number);
		$number = ltrim($number, '0');
		return $country_code.$number;		
    }	
}
