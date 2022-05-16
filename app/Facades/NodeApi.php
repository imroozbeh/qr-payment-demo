<?php

namespace App\Facades;

/**
 * @class \App\Facades\NodeApi
 *
 * @method static eth_accounts()
 * @method static eth_blockNumber()
 * @method static eth_call($object, $quantity)
 * @method static eth_chainId()
 * @method static eth_coinbase()
 * @method static eth_estimateGas($object)
 * @method static eth_gasPrice()
 * @method static eth_getBalance($data, $quantity)
 * @method static eth_getBlockByHash($data, $boolean)
 * @method static eth_getBlockByNumber($quantity, $boolean)
 * @method static eth_getBlockTransactionCountByHash($data)
 * @method static eth_getBlockTransactionCountByNumber($quantity)
 * @method static eth_getCode($data, $quantity)
 * @method static eth_getFilterChanges($data)
 * @method static eth_getFilterLogs($data)
 * @method static eth_getLogs($object)
 * @method static eth_getMinerDataByBlockHash($object)
 * @method static eth_getMinerDataByBlockNumber($quantity)
 * @method static eth_getProof($data, $array, $quantity)
 * @method static eth_getStorageAt($data, $quantity, $tag)
 * @method static eth_getTransactionByBlockHashAndIndex($data, $quantity)
 * @method static eth_getTransactionByBlockNumberAndIndex($tag, $quantity)
 * @method static eth_getTransactionByHash($data)
 * @method static eth_getTransactionCount($data, $quantity)
 * @method static eth_getTransactionReceipt($data)
 * @method static eth_getUncleByBlockHashAndIndex($data, $quantity)
 * @method static eth_getUncleByBlockNumberAndIndex($tag, $quantity)
 * @method static eth_getUncleCountByBlockHash($data)
 * @method static eth_getUncleCountByBlockNumber($tag)
 * @method static eth_getWork()
 * @method static eth_hashrate()
 * @method static eth_mining()
 * @method static eth_newBlockFilter()
 * @method static eth_newFilter($object)
 * @method static eth_newPendingTransactionFilter()
 * @method static eth_protocolVersion()
 * @method static eth_sendRawTransaction($data)
 * @method static eth_submitHashrate($data, $data)
 * @method static eth_submitWork($data, $data, $data)
 * @method static eth_syncing()
 * @method static eth_uninstallFilter($data)
 * @method static net_enode()
 * @method static net_listening()
 * @method static net_peerCount()
 * @method static net_services()
 * @method static net_version()
 * @method static trace_block($quantity)
 * @method static trace_replayBlockTransactions($quantity ,$array)
 * @method static trace_transaction($data)
 * @method static txpool_besuPendingTransactions($numResults, $fields)
 * @method static txpool_besuStatistics()
 * @method static txpool_besuTransactions()
 * @method static web3_clientVersion()
 * @method static web3_sha3($data)
 * @method static rpc_modules()
 *
 * @see \App\Services\NodeApiService
 */

class NodeApi extends BaseFacade
{
    //
}
