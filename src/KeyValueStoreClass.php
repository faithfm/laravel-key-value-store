<?php

namespace FaithFM\KeyValueStore;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class KeyValueStoreClass
{
    /**
     * Group name.
     *
     * @var string
     */
    protected $kvGroupName = 'default';

    /**
     * Cache key.
     *
     * @var string
     */
    protected $kvCacheKey = 'my_key';

    /**
     * Get all pairs from storage as key value pair.
     *
     * @param  bool  $fresh  ignore cached
     * @return Collection
     */
    public function all($fresh = false)
    {
        if ($fresh) {
            return $this->modelQuery()->pluck('val', 'name');
        }

        return Cache::rememberForever($this->getKvCacheKey(), function () {
            return $this->modelQuery()->pluck('val', 'name');
        });
    }

    /**
     * Get a pair from storage by key.
     *
     * @param  string  $key
     * @param  null  $default
     * @param  bool  $fresh
     * @return mixed
     */
    public function get($key, $default = null, $fresh = false)
    {
        return $this->all($fresh)->get($key, $default);
    }

    /**
     * Save a pair in storage.
     *
     * @param $key string|array
     * @param $val string|mixed
     * @return mixed
     */
    public function set($key, $val = null)
    {
        // if its an array, batch save pairs
        if (is_array($key)) {
            foreach ($key as $name => $value) {
                $this->set($name, $value);
            }

            return true;
        }

        $pair = $this->getModel()->firstOrNew([
            'name' => $key,
            'group' => $this->kvGroupName,
        ]);

        $pair->val = json_encode($val);
        $pair->group = $this->kvGroupName;
        $pair->save();

        $this->flushCache();

        return $val;
    }

    /**
     * Check if pair with key exists.
     *
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return $this->all()->has($key);
    }

    /**
     * Remove a pair from storage.
     *
     * @param $key
     * @return mixed
     */
    public function remove($key)
    {
        $deleted = $this->getModel()->where('name', $key)->delete();

        $this->flushCache();

        return $deleted;
    }

    /**
     * Flush cache.
     *
     * @return bool
     */
    public function flushCache()
    {
        return Cache::forget($this->getKvCacheKey());
    }

    /**
     * Get cache key.
     *
     * @return string
     */
    protected function getKvCacheKey()
    {
        return $this->kvCacheKey.'.'.$this->kvGroupName;
    }

    /**
     * Get eloquent model.
     *
     * @return Builder
     */
    protected function getModel()
    {
        return app('\FaithFM\KeyValueStore\KeyValueStoreModel');
    }

    /**
     * Get the model query builder.
     *
     * @return Builder
     */
    protected function modelQuery()
    {
        return $this->getModel()->group($this->kvGroupName);
    }

    /**
     * Set the group name for pairs.
     *
     * @param  string  $groupName
     * @return $this
     */
    public function group($groupName)
    {
        $this->kvGroupName = $groupName;

        return $this;
    }
}
