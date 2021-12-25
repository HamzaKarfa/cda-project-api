<?php
namespace App\Tests\Api\Products;

use App\Entity\SubCategory;
use App\Tests\Api\Class\Abstract\AbstractRequestTest;
class ProductsTest extends AbstractRequestTest
{
    public function testGetProductCollection(): void
    {
     
        $response = $this->httpClientRequest('products', 'GET');
        $this->assertResponseIsSuccessful();
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertResponseHeaderSame('content-type', 'application/json; charset=utf-8');
        // Asserts that the returned JSON is a superset of this one
     
    }

    public function testGetOneProduct():void
    {
        $response = $this->httpClientRequest('products/170', 'GET');
        $this->assertResponseIsSuccessful();
        $this->assertEquals($response->getStatusCode(), 200);
    }

}
