<?php

namespace Hype\MailchimpBundle\Mailchimp;

use Hype\MailchimpBundle\Mailchimp\RestClient;

class MailChimp extends RestClient {

    protected $apiKey;
    protected $listId;
    protected $dataCenter;
    protected $container;
    protected $config;

    public function __construct($apiKey, $listId, $ssl = true) {

        $this->apiKey = $apiKey;
        $this->listId = $listId;
        $this->config = array();
        $this->config['api_key'] = $this->apiKey;
        $this->config['list_id'] = $this->listId;
        $this->config['default_list'] = $this->listId;
        $this->config['ssl'] = true;
        $this->config['timeout'] = 20;

        $key = preg_split("/-/", $this->apiKey);

        if ($ssl) {
            $this->dataCenter = 'https://' . $key[1] . '.api.mailchimp.com/';
        } else {
            $this->dataCenter = 'http://' . $key[1] . '.api.mailchimp.com/';
        }

        if (!function_exists('curl_init')) {
            throw new \Exception('This bundle needs the cURL PHP extension.');
        }
        //parent::__construct($$this->config, $this->listId, $this->dataCenter);
    }

    /**
     * Get Mailchimp api key
     *
     * @return string
     */
    public function getAPIkey() {
        return $this->apiKey;
    }

    /**
     * Set mailing list id
     *
     * @param string $listId mailing list id
     */
    public function setListID($listId) {
        $this->listId = $listId;
    }

    /**
     * get mailing list id
     *
     * @return string $listId
     */
    public function getListID() {
        return $this->listId;
    }

    /**
     * 
     * @return string
     */
    public function getDatacenter() {
        return $this->dataCenter;
    }

    /**
     * 
     * @return \Hype\MailchimpBundle\Mailchimp\Methods\MCList
     */
    public function getList() {
        return new Methods\MCList($this->config, $this->listId, $this->dataCenter);
    }

    /**
     * 
     * @return \Hype\MailchimpBundle\Mailchimp\Methods\MCCampaign
     */
    public function getCampaign() {
        return new Methods\MCCampaign($this->config, $this->listId, $this->dataCenter);
    }

    /**
     * 
     * @return \Hype\MailchimpBundle\Mailchimp\Methods\MCExport
     */
    public function getExport() {
        return new Methods\MCExport($this->config, $this->listId, $this->dataCenter);
    }

    /**
     * 
     * @return \Hype\MailchimpBundle\Mailchimp\MailChimpMethods\CustomMCTemplate
     */
    public function getTemplate() {
        return new Methods\MCTemplate($this->config, $this->listId, $this->dataCenter);
    }

}
