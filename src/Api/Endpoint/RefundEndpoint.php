<?php

namespace CodeCloud\Bundle\ShopifyBundle\Api\Endpoint;

use CodeCloud\Bundle\ShopifyBundle\Api\Request\GetJson;

class RefundEndpoint extends AbstractEndpoint
{
    /**
     * @param int   $orderId
     * @param int   $refundId
     * @param array $fields
     *
     * @return GenericEntity
     */
    public function findOne($orderId, $refundId, array $fields = [])
    {
        $params = $fields ? ['fields' => implode(',', $fields)] : [];
        $request = new GetJson('/admin/orders/'.$orderId.'/refunds/'.$refundId.'.json', $params);
        $response = $this->send($request);

        return $this->createEntity($response->get('refund'));
    }
}
