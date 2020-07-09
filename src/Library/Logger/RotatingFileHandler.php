<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TheFairLib\Library\Logger;

use Monolog\Logger;
use Monolog\Utils;

/**
 * Stores logs to files that are rotated every day and a limited number of files are kept.
 *
 * This rotation is only intended to be used as a workaround. Using logrotate to
 * handle the rotation is strongly encouraged when you can use it.
 *
 * @author Christophe Coevoet <stof@notk.org>
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class RotatingFileHandler extends \Monolog\Handler\RotatingFileHandler
{

    protected $maxFiles = 30;

    /**
     * @param string $filename
     * @param int $maxFiles The maximal amount of files to keep (0 means unlimited)
     * @param int $level The minimum logging level at which this handler will be triggered
     * @param bool $bubble Whether the messages that are handled can bubble up the stack or not
     * @param int|null $filePermission Optional file permissions (default (0644) are only for owner read/write)
     * @param bool $useLocking Try to lock log file before doing any writes
     */
    public function __construct($filename, $maxFiles = 0, $level = Logger::DEBUG, $bubble = true, $filePermission = null, $useLocking = false)
    {
        $this->filename = Utils::canonicalizePath($filename);
        $this->maxFiles = (int)$maxFiles;
        $this->nextRotation = new \DateTime('tomorrow');
        $this->filenameFormat = '{date}/{filename}';
        $this->dateFormat = 'Y-m-d';

        parent::__construct($filename, $maxFiles, $level, $bubble, $filePermission, $useLocking);
    }

    protected function getTimedFilename()
    {
        rd_debug([$logFiles = glob($this->getGlobPattern()), $this->maxFiles]);
        $fileInfo = pathinfo($this->filename);
        $timedFilename = str_replace(
            ['{filename}', '{date}'],
            [$fileInfo['filename'], date($this->dateFormat)],
            $fileInfo['dirname'] . '/{date}/{filename}'
        );

        if (!empty($fileInfo['extension'])) {
            $timedFilename .= '.' . $fileInfo['extension'];
        }

        return $timedFilename;
    }

    protected function getGlobPattern()
    {
        $fileInfo = pathinfo($this->filename);
        $glob = str_replace(
            ['{filename}', '{date}'],
            [$fileInfo['filename'], '[0-9][0-9][0-9][0-9]*'],
            $fileInfo['dirname'] . '/{date}/{filename}'
        );
        if (!empty($fileInfo['extension'])) {
            $glob .= '.' . $fileInfo['extension'];
        }

        return $glob;
    }
}