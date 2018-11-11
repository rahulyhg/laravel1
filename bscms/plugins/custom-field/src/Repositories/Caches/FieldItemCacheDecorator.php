<?php

namespace Bytesoft\CustomField\Repositories\Caches;

use Bytesoft\CustomField\Repositories\Interfaces\FieldItemInterface;
use Bytesoft\Support\Repositories\Caches\CacheAbstractDecorator;
use Bytesoft\Support\Services\Cache\CacheInterface;
use Illuminate\Support\Collection;

class FieldItemCacheDecorator extends CacheAbstractDecorator implements FieldItemInterface
{

    /**
     * @var FieldItemInterface
     */
    protected $repository;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * FieldItemCacheDecorator constructor.
     * @param FieldItemInterface $repository
     * @param CacheInterface $cache
     * @author Bytesoft
     */
    public function __construct(FieldItemInterface $repository, CacheInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    /**
     * @param int|array $id
     * @return bool
     */
    public function deleteFieldItem($id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * @param $groupId
     * @param null $parentId
     * @return Collection
     */
    public function getGroupItems($groupId, $parentId = null)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null $id
     * @param array $data
     * @return int|null
     */
    public function updateWithUniqueSlug($id, array $data)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
