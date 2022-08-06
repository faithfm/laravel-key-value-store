<?php

if (! function_exists('key_value_store')) {

    /**
     * Get app pair stored in db.
     *
     * @param $key
     * @param  null  $default
     * @return mixed
     */
    function key_value_store($key = null, $default = null)
    {
        $kvsInstance = app()->make('FaithFM\KeyValueStore\KeyValueStoreClass');

        if (is_null($key)) {
            return $kvsInstance;
        }

        if (is_array($key)) {
            return $kvsInstance->set($key);
        }

        return $kvsInstance->get($key, value($default));
    }
}
