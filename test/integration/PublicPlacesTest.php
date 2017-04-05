<?php
namespace RodinAPI\Test\Integration;

class PublicPlacesTest extends BaseTest
{

    protected $suffix = 'public/';

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_should_return200_when_calledWithExistingPlace()
    {

        $response = $this->http->request('GET', 'places/1111-2222-3333-4444');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_should_havePlaceObjectInBody_when_calledWithExistingPlace()
    {
        $response = $this->http->request('GET', 'places/1111-2222-3333-4444');

        $body = json_decode($response->getBody(),true);
        $this->assertArrayHasKey('place_id', $body);
        $this->assertArrayHasKey('url_id', $body);
    }

}