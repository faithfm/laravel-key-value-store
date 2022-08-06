<?php

namespace FaithFM\KeyValueStore;

class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'FaithFM\KeyValueStore\KeyValueStoreClass';
    }
}
