<?php
namespace RodinAPI\Test\Integration;

class DebugTest extends BaseTest
{

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_should_return200_when_called()
    {
        $response = $this->http->request('GET', 'public/debug/');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_should_haveCorrectBody_when_200OK()
    {
        $response = $this->http->request('GET', 'public/debug/');

        $body = json_decode($response->getBody(),true);
        $this->assertArrayHasKey('event_params', $body);
    }

}