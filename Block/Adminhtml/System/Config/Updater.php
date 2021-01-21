<?php

namespace WiserBrand\RealThanks\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use WiserBrand\RealThanks\Model\SyncLogManagement;

class Updater extends Field
{
    /**
     * @var SyncLogManagement
     */
    protected $syncLogManagement;

    /**
     * @param Context $context
     * @param SyncLogManagement $syncLogManagement
     * @param array $data
     */
    public function __construct(
        Context $context,
        SyncLogManagement $syncLogManagement,
        array $data = []
    ) {
        $this->syncLogManagement = $syncLogManagement;
        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        return $this->toHtml();
    }

    /**
     * Get backend URL to load realthanks config data
     *
     * @return string
     */
    public function getDataUpdaterUrl()
    {
        return $this->getUrl('realthanks/config/update');
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('WiserBrand_RealThanks::system/config/sync_log_update.phtml');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSyncLogDate()
    {
        if ($syncLog = $this->syncLogManagement->getLatestSync()) {
            return $syncLog->getCreatedAt();
        }

        return null;
    }

    /**
     * @return bool
     */
    public function IsSuccessful()
    {
        if ($syncLog = $this->syncLogManagement->getLatestSync()) {
            return $syncLog->IsSuccessful();
        }

        return false;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->syncLogManagement->getLatestSync()->getMessage();
    }

    /**
     * @return float
     */
    public function getCurrentBalance()
    {
        return $this->syncLogManagement->getBalance();
    }
}
