<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Model\Validation;

use Magento\Framework\DataObject;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Validator\EmailAddress;
use RealThanks\GiftProvider\Model\RtGiftRepository;

class GiftSendFormValidator extends DataObject
{
    const REQUIRED_FIELDS = [
        'subject',
        'message',
        'email'
    ];

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var RtGiftRepository
     */
    private $giftRepo;

    public function __construct(RtGiftRepository $giftRepo, array $data = [])
    {
        $this->giftRepo = $giftRepo;
        parent::__construct($data);
    }

    public function validate() : bool
    {
        return $this->validateRequiredFields() &&
        $this->validateEmailField();
    }

    public function getErrors() : string
    {
        if ($this->errors) {
            return implode(",\n", $this->errors);
        }

        return '';
    }

    private function validateRequiredFields() : bool
    {
        $valid = true;
        foreach (self::REQUIRED_FIELDS as $fieldName) {
            if (!$this->getData($fieldName)) {
                array_push($this->errors, __('Field "%1" is required, please fill it', $fieldName));
                $valid = false;
            }
        }

        return $valid;
    }

    private function validateEmailField() : bool
    {
        $valid = true;
        $validator = new EmailAddress();

        if ($this->getData('email')
                && !$validator->isValid(trim($this->getData('email')))) {
            array_push($this->errors, __('Email - "%1" is not valid', $this->getData('email')));
            $valid = false;
        }

        return $valid;
    }

    public function validateGiftIdField()
    {
        try {
            if ($giftId = $this->getData('gift_id')) {
                return $this->giftRepo->getById((int)$giftId);
            } else {
                return'Empty gift_id field! Please check the form';
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
