<?php
namespace App\Tests\Api\SubCategories;

use App\Entity\SubCategory;
use App\Tests\Api\Class\Abstract\AbstractRequestTest;
class SubCategoriesTest extends AbstractRequestTest
{
    public function testGetSubCategoriesCollection(): void
    {
     
        $response = $this->httpClientRequest('sub_categories', 'GET');
        
        $this->assertResponseIsSuccessful();
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertResponseHeaderSame('content-type', 'application/json; charset=utf-8');
        // Asserts that the returned JSON is a superset of this one
       
    }

    public function testGetOneSubCategory():void
    {
        $response = $this->httpClientRequest('sub_categories/42', 'GET');
        $this->assertResponseIsSuccessful();
        $this->assertEquals($response->getStatusCode(), 200);
     
    }

}
