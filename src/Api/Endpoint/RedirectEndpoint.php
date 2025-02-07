<?php

namespace CodeCloud\Bundle\ShopifyBundle\Api\Endpoint;

use CodeCloud\Bundle\ShopifyBundle\Api\Request\DeleteParams;
use CodeCloud\Bundle\ShopifyBundle\Api\Request\GetJson;
use CodeCloud\Bundle\ShopifyBundle\Api\Request\PostJson;
use CodeCloud\Bundle\ShopifyBundle\Api\Request\PutJson;
use CodeCloud\Bundle\ShopifyBundle\Api\GenericResource;

class RedirectEndpoint extends AbstractEndpoint
{
    /**
     * @param array $query
     *
     * @return array|\CodeCloud\Bundle\ShopifyBundle\Api\GenericResource[]
     */
    public function findAll(array $query = [])
    {
        $request = new GetJson('/admin/redirects.json', $query);
        $response = $this->sendPaged($request, 'redirects');

        return $this->createCollection($response);
    }

    /**
     * @param array $query
     *
     * @return int
     */
    public function countAll(array $query = [])
    {
        $request = new GetJson('/admin/redirects/count.json', $query);
        $response = $this->send($request);

        return $response->get('count');
    }

    /**
     * @param int   $redirectId
     * @param array $fields
     *
     * @return GenericResource
     */
    public function findOne($redirectId, array $fields = [])
    {
        $params = $fields ? ['fields' => implode(',', $fields)] : [];
        $request = new GetJson('/admin/redirects/'.$redirectId.'.json', $params);
        $response = $this->send($request);

        return $this->createEntity($response->get('redirect'));
    }

    /**
     * @param GenericResource $redirect
     *
     * @return GenericResource
     */
    public function create(GenericResource $redirect)
    {
        $request = new PostJson('/admin/redirects.json', ['redirect' => $redirect->toArray()]);
        $response = $this->send($request);

        return $this->createEntity($response->get('redirect'));
    }

    /**
     * @param int             $redirectId
     * @param GenericResource $redirect
     *
     * @return GenericResource
     */
    public function update($redirectId, GenericResource $redirect)
    {
        $request = new PutJson('/admin/redirects/'.$redirectId.'.json', ['redirect' => $redirect->toArray()]);
        $response = $this->send($request);

        return $this->createEntity($response->get('redirect'));
    }

    /**
     * @param int $redirectId
     */
    public function delete($redirectId)
    {
        $request = new DeleteParams('/admin/redirects/'.$redirectId.'.json');
        $this->send($request);
    }
}
