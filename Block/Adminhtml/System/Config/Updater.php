<?php

namespace RealThanks\GiftProvider\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use RealThanks\GiftProvider\Helper\PriceFormatter;
use RealThanks\GiftProvider\Model\SyncLogManagement;

class Updater extends Field
{
    /**
     * @var SyncLogManagement
     */
    private $syncLogManagement;

    /**
     * @var PriceFormatter
     */
    private $formatter;

    /**
     * @param Context $context
     * @param SyncLogManagement $syncLogManagement
     * @param array $data
     */
    public function __construct(
        Context $context,
        SyncLogManagement $syncLogManagement,
        PriceFormatter $formatter,
        array $data = []
    ) {
        $this->syncLogManagement = $syncLogManagement;
        $this->formatter = $formatter;
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
     * Get backend URL to load RealThanks config data
     *
     * @return string
     */
    public function getDataUpdaterUrl(): string
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
            $this->setTemplate('RealThanks_GiftProvider::system/config/sync_log_update.phtml');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLatestSyncLogDate(): ?string
    {
        if ($syncLog = $this->syncLogManagement->getLatestSync()) {
            return $syncLog->getCreatedAt();
        }

        return null;
    }

    private function loadData()
    {
        if ($syncLog = $this->syncLogManagement->getLatestErrorSync()) {
            $this->setLogErrorDate($syncLog->getCreatedAt());
            $this->setLogErrorType($syncLog->getType());
            $this->setLogStatus(false);
            $this->setLogErrorMessage($syncLog->getMessage());
        } else {
            $this->setLogStatus(true);
        }
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        if ($this->getLogStatus() === null) {
            $this->loadData();
        }

        return $this->getLogStatus();
    }

    /**
     * @return string
     */
    public function getCurrentBalance(): string
    {
        return $this->formatter->format($this->syncLogManagement->getBalance());
    }
}
