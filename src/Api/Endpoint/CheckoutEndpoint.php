<?php

namespace CodeCloud\Bundle\ShopifyBundle\Api\Endpoint;

use CodeCloud\Bundle\ShopifyBundle\Api\Request\GetJson;

class CheckoutEndpoint extends AbstractEndpoint
{
    /**
     * @param array $query
     *
     * @return array|GenericEntity[]
     */
    public function findAll(array $query = [])
    {
        $request = new GetJson('/admin/checkouts.json', $query);
        $response = $this->sendPaged($request, 'checkouts');

        return $this->createCollection($response);
    }

    /**
     * @param array $query
     *
     * @return int
     */
    public function countAll(array $query = [])
    {
        $request = new GetJson('/admin/checkouts/count.json', $query);
        $response = $this->send($request);

        return $response->get('count');
    }
}
