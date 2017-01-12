<?php

class DbException extends EccExc {
    
    public function __construct($message, $code=0) {
        $this->logger_name='db_logger';
        $this->logfile = FRONT_ROOT. Edfx_Enum::FILE_ERRORLOG_DB;
        parent::__construct($message, $code);
    }
}