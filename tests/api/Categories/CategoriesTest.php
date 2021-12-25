<?php
namespace App\Tests\Api\Categories;

use App\Tests\Api\Class\Abstract\AbstractRequestTest;
class CategoriesTest extends AbstractRequestTest
{
    public function testGetCategoriesCollection(): void
    {
     
        $response = $this->httpClientRequest('categories', 'GET');
        
        $this->assertResponseIsSuccessful();
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertResponseHeaderSame('content-type', 'application/json; charset=utf-8');
        // Asserts that the returned JSON is a superset of this one
        
    }
  
    public function testGetOneCategory():void
    {
        $response = $this->httpClientRequest('categories/13', 'GET');
        $this->assertResponseIsSuccessful();
        $this->assertEquals($response->getStatusCode(), 200);
    }

}
