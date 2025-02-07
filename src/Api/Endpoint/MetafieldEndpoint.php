<?php

namespace CodeCloud\Bundle\ShopifyBundle\Api\Endpoint;

use CodeCloud\Bundle\ShopifyBundle\Api\Request\DeleteParams;
use CodeCloud\Bundle\ShopifyBundle\Api\Request\GetJson;
use CodeCloud\Bundle\ShopifyBundle\Api\Request\PostJson;
use CodeCloud\Bundle\ShopifyBundle\Api\Request\PutJson;
use CodeCloud\Bundle\ShopifyBundle\Api\GenericResource;

class MetafieldEndpoint extends AbstractEndpoint
{
    /**
     * @param array $query
     *
     * @return array|\CodeCloud\Bundle\ShopifyBundle\Api\GenericResource[]
     */
    public function findStoreMetafields(array $query = [])
    {
        $request = new GetJson('/admin/metafields.json', $query);
        $response = $this->sendPaged($request, 'metafields');

        return $this->createCollection($response);
    }

    /**
     * @param int   $productId
     * @param array $query
     *
     * @return array|\CodeCloud\Bundle\ShopifyBundle\Api\GenericResource[]
     */
    public function findProductMetafields($productId, array $query = [])
    {
        $request = new GetJson('/admin/products/'.$productId.'/metafields.json', $query);
        $response = $this->sendPaged($request, 'metafields');

        return $this->createCollection($response);
    }

    /**
     * @param int $productImageId
     *
     * @return array|\CodeCloud\Bundle\ShopifyBundle\Api\GenericResource[]
     */
    public function findProductImageMetafields($productImageId)
    {
        $params = [
            'metafield[owner_id]' => $productImageId,
            'metafield[owner_resource]' => 'product_image',
        ];

        $request = new GetJson('/admin/metafields.json', $params);
        $response = $this->sendPaged($request, 'metafields');

        return $this->createCollection($response);
    }

    /**
     * @param int $metafieldId
     *
     * @return \CodeCloud\Bundle\ShopifyBundle\Api\GenericResource
     */
    public function findOneStoreMetafield($metafieldId)
    {
        $request = new GetJson('/admin/metafields/'.$metafieldId.'.json');
        $response = $this->send($request);

        return $this->createEntity($response->get('metafield'));
    }

    /**
     * @param int $metafieldId
     * @param int $productId
     *
     * @return GenericResource
     */
    public function findOneProductMetafield($metafieldId, $productId)
    {
        $request = new GetJson('/admin/products/'.$productId.'/metafields/'.$metafieldId.'.json');
        $response = $this->send($request);

        return $this->createEntity($response->get('metafield'));
    }

    /**
     * @return int
     */
    public function countStoreMetafields()
    {
        $request = new GetJson('/admin/metafields/count.json');
        $response = $this->send($request);

        return $response->get('count');
    }

    /**
     * @param int $productId
     *
     * @return int
     */
    public function countByProduct($productId)
    {
        $request = new GetJson('/admin/products/'.$productId.'/metafields/count.json');
        $response = $this->send($request);

        return $response->get('count');
    }

    /**
     * @param GenericResource $metafield
     *
     * @return \CodeCloud\Bundle\ShopifyBundle\Api\GenericResource
     */
    public function createStoreMetafield(GenericResource $metafield)
    {
        $request = new PostJson('/admin/metafields.json', ['metafield' => $metafield->toArray()]);
        $response = $this->send($request);

        return $this->createEntity($response->get('metafield'));
    }

    /**
     * @param int                                                 $metafieldId
     * @param \CodeCloud\Bundle\ShopifyBundle\Api\GenericResource $metafield
     *
     * @return \CodeCloud\Bundle\ShopifyBundle\Api\GenericResource
     */
    public function updateStoreMetafield($metafieldId, GenericResource $metafield)
    {
        $request = new PutJson('/admin/metafields/'.$metafieldId.'.json', ['metafield' => $metafield->toArray()]);
        $response = $this->send($request);

        return $this->createEntity($response->get('metafield'));
    }

    /**
     * @param int $metafieldId
     */
    public function deleteStoreMetafield($metafieldId)
    {
        $request = new DeleteParams('/admin/metafields/'.$metafieldId.'.json');
        $this->send($request);
    }

    /**
     * @param int             $productId
     * @param GenericResource $metafield
     *
     * @return \CodeCloud\Bundle\ShopifyBundle\Api\GenericResource
     */
    public function createProductMetafield($productId, GenericResource $metafield)
    {
        $request = new PostJson('/admin/products/'.$productId.'/metafields.json', ['metafield' => $metafield->toArray()]);
        $response = $this->send($request);

        return $this->createEntity($response->get('metafield'));
    }

    /**
     * @param int                                                 $metafieldId
     * @param int                                                 $productId
     * @param \CodeCloud\Bundle\ShopifyBundle\Api\GenericResource $metafield
     *
     * @return GenericResource
     */
    public function updateProductMetafield($metafieldId, $productId, GenericResource $metafield)
    {
        $request = new PutJson('/admin/products/'.$productId.'/metafields/'.$metafieldId.'.json', ['metafield' => $metafield->toArray()]);
        $response = $this->send($request);

        return $this->createEntity($response->get('metafield'));
    }

    /**
     * @param int $metafieldId
     * @param int $productId
     */
    public function deleteProductMetafield($metafieldId, $productId)
    {
        $request = new DeleteParams('/admin/products/'.$productId.'/metafields/'.$metafieldId.'.json');
        $this->send($request);
    }

    /**
     * @param int   $orderId
     * @param array $query
     *
     * @return array|\CodeCloud\Bundle\ShopifyBundle\Api\GenericResource[]
     */
    public function findOrderMetafields($orderId, array $query = [])
    {
        $request = new GetJson(
            '/admin/orders/'.$orderId.'/metafields.json',
            $query
        );
        $response = $this->sendPaged($request, 'metafields');

        return $this->createCollection($response);
    }

    /**
     * @param int $metafieldId
     * @param int $orderId
     *
     * @return GenericResource
     */
    public function findOneOrderMetafield($metafieldId, $orderId)
    {
        $request = new GetJson(
            '/admin/orders/'.$orderId.'/metafields/'.$metafieldId.'.json'
        );
        $response = $this->send($request);

        return $this->createEntity($response->get('metafield'));
    }

    /**
     * @param int $orderId
     *
     * @return int
     */
    public function countByOrder($orderId)
    {
        $request = new GetJson(
            '/admin/orders/'.$orderId.'/metafields/count.json'
        );
        $response = $this->send($request);

        return $response->get('count');
    }

    /**
     * @param int             $orderId
     * @param GenericResource $metafield
     *
     * @return \CodeCloud\Bundle\ShopifyBundle\Api\GenericResource
     */
    public function createOrderMetafield($orderId, GenericResource $metafield)
    {
        $request = new PostJson(
            '/admin/orders/'.$orderId.'/metafields.json',
            ['metafield' => $metafield->toArray()]
        );
        $response = $this->send($request);

        return $this->createEntity($response->get('metafield'));
    }

    /**
     * @param int                                                 $metafieldId
     * @param int                                                 $orderId
     * @param \CodeCloud\Bundle\ShopifyBundle\Api\GenericResource $metafield
     *
     * @return GenericResource
     */
    public function updateOrderMetafield(
        $metafieldId,
        $orderId,
        GenericResource $metafield
    ) {
        $request = new PutJson(
            '/admin/orders/'.$orderId.'/metafields/'.$metafieldId.'.json',
            ['metafield' => $metafield->toArray()]
        );
        $response = $this->send($request);

        return $this->createEntity($response->get('metafield'));
    }

    /**
     * @param int $metafieldId
     * @param int $orderId
     */
    public function deleteOrderMetafield($metafieldId, $orderId)
    {
        $request = new DeleteParams(
            '/admin/orders/'.$orderId.'/metafields/'.$metafieldId.'.json'
        );
        $this->send($request);
    }
}
