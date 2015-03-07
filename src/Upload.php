<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Hopeter1018\Helper;

/**
 * Description of Upload
 *
 * @author peter.ho
 */
class Upload
{

    private $fieldName = null;
    private $file = null;
    private $ext = null;
    public function __construct($fieldName)
    {
        $this->fieldName = $fieldName;
        $this->file = (isset($_FILES[$fieldName])) ? $_FILES[$fieldName] : null;
    }

    public function isUploaded()
    {
        return is_uploaded_file($this->getTmp());
    }

    public function getTmp()
    {
        return $this->file['tmp_name'];
    }

    public function getName()
    {
        return $this->file['name'];
    }

    /**
     * 
     * @param string $maxSizeStr
     * @param string $minSizeStr
     * @return boolean
     */
    public function isSize($maxSizeStr, $minSizeStr = null)
    {
        if ($maxSizeStr === null) {
            return filesize($this->getTmp()) < FileHelper::toSize($maxSizeStr);
        } else {
            return filesize($this->getTmp()) < FileHelper::toSize($maxSizeStr) 
                AND filesize($this->getTmp()) > FileHelper::toSize($minSizeStr);
        }
    }

    /**
     * Get File Extension
     * @return string
     */
    public function getExt()
    {
        if ($this->ext === null) {
            $this->ext = pathinfo($this->getName(), PATHINFO_EXTENSION);
        }
        return $this->ext;
    }

    /**
     * Compare file extension
     * * lowercase ONLY
     * @param type $allowedExtensions
     */
    public function isExt($allowedExtensions)
    {
        if (! is_array($allowedExtensions)) {
            $allowedExtensions[] = $allowedExtensions;
        }
        return in_array(
            strtolower($this->getExt()),
            $allowedExtensions
        );
    }

    /**
     * 
     * @param type $dest
     */
    public function saveTo($dest)
    {
        if (! is_dir($dir = dirname($dest))) {
            mkdir($dir, 0777, true);
        }
        $moveSuccess = move_uploaded_file($this->getTmp(), $dest);
        if ($moveSuccess) {
            touch($dest);
            return chmod($dest, 0777);
        }
        return false;
    }

}
