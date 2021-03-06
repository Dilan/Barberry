<?php

class Direction_Factory {

    /**
     * @var string
     */
    private $directionClassName;

    /**
     * @var string
     */
    private $directionDescription;

    /**
     * @var bool
     */
    private $sameContentTypes;

    public function __construct($sourceBinary, ContentType $destinationContentType) {
        $sourceContentType = ContentType::byString($sourceBinary);

        $this->directionClassName =
                    ucfirst($sourceContentType->standartExtention())
                    . 'To'
                    . ucfirst($destinationContentType->standartExtention())
                    . 'Direction';

        $this->directionDescription = $sourceContentType . ' to '. $destinationContentType;
        $this->sameContentTypes = ($sourceContentType == $destinationContentType);
    }

    /**
     * @param null|string $commandPart
     * @return Plugin_Interface_Converter
     * @throws Plugin_NotAvailableException
     */
    public function direction($commandPart = null) {
        if ($this->sameContentTypes && is_null($commandPart)) {
            return new Plugin_Null;
        }
        if(class_exists($this->directionClassName, true)) {
            return new $this->directionClassName($commandPart);
        }
        throw new Plugin_NotAvailableException($this->directionDescription);
    }
}
