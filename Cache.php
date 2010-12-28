<?php

/**
 * ������
 *
 * @author     leaboy.w <leaboy.w@gmail.com>
 * @copyright  Copyright (c) 2010 (http://wiki.nocn.net)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

define('DIR_SEP', DIRECTORY_SEPARATOR);

require_once('Cache_Abstract.php');
require_once('File.php');
require_once('Memcached.php');

# consistent hashing
require_once('Hash.php');


class CacheException extends Exception {}

final class Cache
{

    /**
     * ���洦����
     *
     * @var Cache_Abstract
     */
    private $_storage = null;

    /**
     * @return Cache
     */
    static public function initCache($cacheClass = 'HQ_Cache_File')
    {
        return new self($cacheClass);
    }

    private function __construct($cacheClass) {
        $this->_storage = new $cacheClass();
    }

    /**
     * @return hash
     */
    public public function setNode(array $node)
    {
        $hash = new Flexihash();
        $hash->addTargets($node);

        $this->_storage->_hash = $hash;
    }

    /**
     * ���û������ò�����Ϣ
     *
     * @param  array  $options
     */
    public function setOption(array $options)
    {
        $this->_storage->setOption($options);
    }

    /**
     * д�뻺��
     *
     * @param string $key
     * @param mixed $value
     */
    public function write($key, $value) {
        $this->_storage->write($key, $value);
    }

    /**
     * ��ȡ����
     *
     * @param  string   $key
     * @return mixed|false
     */
    public function read($key)
    {
        return $this->_storage->read($key);
    }

    /**
     * ɾ������
     *
     * @param  string   $key
     * @return boolean
     */
    public function _delete($key)
    {
        return $this->_storage->_delete($key);
    }

    /**
     * ��ջ���
     *
     * @return boolean
     */
    public function _empty()
    {
        return $this->_storage->_empty();
    }

}
