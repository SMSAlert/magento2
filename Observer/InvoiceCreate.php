<?php
namespace COZYVISION\Smsalert\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Event\Observer       as Observer;
use \Magento\Framework\View\Element\Context as Context;
use \COZYVISION\Smsalert\Helper\Data        as Helper;

/**
* Customer login observer
*/
class InvoiceCreate implements ObserverInterface
{
    /**
     * Message manager
     *
     * @var \Magento\Framework\Message\ManagerInterface
     */
    const AJAX_PARAM_NAME = 'infscroll';
    /**
     *
     */
    const AJAX_HANDLE_NAME = 'infscroll_ajax_request';

    /**
     * Https request
     *
     * @var \Zend\Http\Request
     */
    private $request;

    /**
     * Layout Interface
     * @var \Magento\Framework\View\LayoutInterface
     */
    private $layout;

    /**
     * Cache
     * @var $_cache
     */
    private $cache;

    /**
     * Helper for SmsalertSMS Module
     * @var \COZYVISION\Smsalert\Helper\Data
     */
    private $helper;

    /**
     * Message Manager
     * @var $messageManager
     */
    private $messageManager;

    /**
     * Destination
     * @var $destination
     */
    private $destination;

    /**
     * Message
     * @var $message
     */
    private $message;

    /**
     * Whether Enabled or not
     * @var $enabled
     */
    private $enabled;

    /**
     * Username
     * @var $username
     */
    private $username;

    /**
     * Password
     * @var $password
     */
    private $password;

    /**
     * Sender ID
     * @var $senderId
     */
    private $senderId;

    /**
     * Constructor
     * @param Context $context
     * @param Helper $helper _helper
     */
    public function __construct(
        Context $context,
        Helper $helper
    ) {
        $this->_helper  = $helper;
        $this->_request = $context->getRequest();
        $this->_layout  = $context->getLayout();
    }

    /**
     * The execute class
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /**
         * Getting Module Configuration from admin panel
         */

        //Getting Customer Notification value
        $this->enabled  = $this->_helper->isCustomerSmsIsEnabledOnInvoiced();

        //Getting Sender ID
        $this->senderId = $this->_helper->getCustomerId();

        //Getting Message
        $this->message  = $this->_helper->getCustomerSmsOnInvoiced();
		
        //Getting Username
        $this->username = $this->_helper->getSmsalertUsername();

        //Getting Password
        $this->password = $this->_helper->getSmsalertPassword();

        //Checking if sms is enable or not
        if ($this->enabled == 1) {
            /**
             * Verification of API Account
             */
            //Verification of API
            $verificationResult = $this->_helper->verifyApi($this->username, $this->password);
            if ($verificationResult == true) {
                //Getting Order Details
                $order = $observer->getEvent()->getInvoice()->getOrder();
				$invoice_id=$observer->getEvent()->getInvoice()->getIncrementId();
				$orderData = [
                    'orderId'       => $order->getIncrementId(),
					'storeName'     => $order->getStore()->getGroup()->getName(),
					'firstname'     => $order->getBillingAddress()->getFirstName(),
					'middlename'   =>  $order->getBillingAddress()->getMiddleName(),
					'lastname'      => $order->getBillingAddress()->getLastName(),
                    'totalPrice'    => number_format($observer->getEvent()->getInvoice()->getBaseGrandTotal(), 2),
                    'countryCode'   => $order->getOrderCurrencyCode(),
                    'protectCode'   => $order->getProtectCode(),
                    'customerDob'   => $order->getCustomerDob(),
                    'customerEmail' => $order->getCustomerEmail(),
                    'gender'        => ($order->getCustomerGender() ? 'Female' : 'Male'),
                ];
			
                //Getting Telephone Number
                $this->destination = $order->getBillingAddress()->getTelephone();

                //Manipulating SMS
                $this->message = $this->_helper->manipulateSMS($this->message, $orderData);
                $this->message = str_replace('{invoiceNumber}', $invoice_id, $this->message); 
                //Sending SMS
                $this->_helper->sendSms(
                    $this->username,
                    $this->password,
                    $this->senderId,
                    $this->destination,
                    $this->message
                );

                //Sending SMS to Admin
                if ($this->_helper->isAdminSmsIsEnabled() == 1) {
                    $this->destination = $this->_helper->getAdminSenderId();
                    $this->message = $this->_helper->getAdminSmsForInvoiced();
                    $this->message = $this->_helper->manipulateSMS($this->message, $orderData);
					$this->message = str_replace('{invoiceNumber}', $invoice_id, $this->message);
                    $this->_helper->sendSms(
                        $this->username,
                        $this->password,
                        $this->senderId,
                        $this->destination,
                        $this->message
                    );
                }
            }
        }
    }
	
	private function getInvoiceObject()
    {
        return $this->_registry->registry('current_invoice');
    }
}
