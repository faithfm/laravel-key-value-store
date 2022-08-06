<?php

namespace FaithFM\KeyValueStore;

use Illuminate\Database\Eloquent\Model;

class KeyValueStoreModel extends Model
{
    protected $guarded = ['updated_at', 'id'];

    protected $table = 'key_value_store';

    public function scopeGroup($query, $groupName)
    {
        return $query->whereGroup($groupName);
    }
}
