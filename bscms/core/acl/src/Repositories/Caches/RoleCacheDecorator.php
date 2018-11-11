<?php

namespace Bytesoft\ACL\Repositories\Caches;

use Bytesoft\ACL\Repositories\Interfaces\RoleInterface;
use Bytesoft\Support\Repositories\Caches\CacheAbstractDecorator;
use Bytesoft\Support\Services\Cache\CacheInterface;

class RoleCacheDecorator extends CacheAbstractDecorator implements RoleInterface
{
    /**
     * @var RoleInterface
     */
    protected $repository;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * RoleCacheDecorator constructor.
     * @param RoleInterface $repository
     * @param CacheInterface $cache
     * @author Bytesoft
     */
    public function __construct(RoleInterface $repository, CacheInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    /**
     * @param $name
     * @param $id
     * @return mixed
     * @author Bytesoft
     */
    public function createSlug($name, $id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
