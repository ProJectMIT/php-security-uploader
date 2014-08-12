<?php
namespace PHPSecurityUploader\Lib\StreamIO;

use PHPSecurityUploader\Lib;
use PHPSecurityUploader\Exception;

class FileIO extends AbstractStreamIO
{
    public function __construct($fileobject)
    {
        // if $fileobject of parameter is not resource, throw exception!!
        if (is_resource($fileobject) === false)
            throw new InvalidException('The parameter is not file resource.');

        parent::__constract($fileobject);
    }

    public function __destruct()
    {
        parent::__destract();
    }

    protected function _close()
    {
        fclose($this->_analysis);
    }

    public function read($length, $offset = 0, $whence = SEEK_CUR)
    {
        // move to file pointer
        if ($offset !== 0) fseek($this->_analysis, $offset, $whence);

        // if file pointer is end of file?
        if (feof($this->_analysis) === true)
            throw new IOException('The position of this file pointer is end-of-file.');

        // read to data of file
        $buffer = '';
        if (($buffer = fread($this->_analysis, $length) !== false)
            return $buffer;
    }

    public function write($buffer, $offset = 0, $whence = SEEK_CUR)
    {
        // null buffer
        if ($buffer === null) return false;

        // move to file pointer
        if ($offset !== 0) fseek($this->_analysis, $offset, $whence);

        // write to data of buffer
        $writelength = 0;
        if ($writelength = fwrite($this->_analysis, $buffer) === false)
            throw new IOException($writelength . ' bytes from ' . strlen($buffer) . ' bytes was written to successful.');

        return $writelength;
    }
}
?>
