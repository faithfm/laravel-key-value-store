<?php

namespace FaithFM\KeyValueStore;

use Illuminate\Database\Eloquent\Builder;
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
     * Get all pairs from storage as key value pair.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->modelQuery()->pluck('val', 'name');
    }

    /**
     * Get a pair from storage by key.
     *
     * @param  string  $key
     * @param  null  $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $model = $this->getModel()->firstWhere('name', $key);
        return $model->val ?? $default;
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
        return !is_null($this->get($key, null));
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

        return $deleted;
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
