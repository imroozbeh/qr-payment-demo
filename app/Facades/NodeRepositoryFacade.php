<?php

namespace App\Facades;

use Milyoonex\Facades\BaseFacade;

/**
 * @class \App\Facades\NodeRepositoryFacade
 *
 * @method static module($module = null)
 * @method static getRecord($model, $query, $selection = [], $relations = [])
 * @method static getRecords($model, $query = [], $selection = [], $relations = [])
 * @method static getPaginate($model, $query = [], $selection = [], $relations = [],$paginate=0)
 * @method static storeRecord($model, $data)
 * @method static storeRelationRecord($relation, $data)
 * @method static forceStoreRelationRecord($relation, $data)
 * @method static updateRecord(\Illuminate\Database\Eloquent\Model $object, $data)
 * @method static forceStoreRecord($model, $data)
 * @method static forceUpdateRecord(\Illuminate\Database\Eloquent\Model $object, $data)
 * @method static deleteRecord(\Illuminate\Database\Eloquent\Model $object)
 * @method static deleteRecords($model, $data)
 * @method static forceDeleteRecord(\Illuminate\Database\Eloquent\Model $object)
 * @method static forceDeleteRecords($model, $data)
 * @method static restoreRecord(\Illuminate\Database\Eloquent\Model $object)
 * @method static restoreRecords($model, $data)
 * @method static getCurrency($network, $contract)
 * @method static increaseWalletBalance($wallet, $network)
 *
 * @see \App\Repositories\NodeRepository
 */

class NodeRepositoryFacade extends BaseFacade
{
    //
}
