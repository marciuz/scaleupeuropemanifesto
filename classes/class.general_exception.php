<?php

class General_Exception extends EccExc {
    
    public function __construct($message, $code=0, $additional_details=array()) {
        $this->logger_name='ecc_logger';
        $this->logfile = FRONT_ROOT. Edfx_Enum::FILE_ERRORLOG_RUNTIME;
        $this->additional_details=$additional_details;
        parent::__construct($message, $code);
    }

}