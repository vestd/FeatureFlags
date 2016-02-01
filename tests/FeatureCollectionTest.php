<?php

use Mockery as m;

class FeatureCollectionTest extends TestCase
{

    /**
     * @test
     * @expectedException        Vestd\FeatureFlags\InvalidOptionException
     */
    public function unset_flag_throws_exception()
    {
        $collection = new \Vestd\FeatureFlags\FeatureCollection();
        $collection->get('unknown_flag');
    }

    /** @test */
    public function a_collection_can_be_created()
    {
        $features = [
            'flag_a' => false,
            'flag_b' => true,
            'flag_c' => [
                'users'  => [123, 456],
                'groups' => ['beta', 'admin']
            ]
        ];

        $collection = new \Vestd\FeatureFlags\FeatureCollection();
        $collection->setFeatures($features);

        $this->assertInstanceOf(\Vestd\FeatureFlags\Feature::class, $collection->get('flag_a'));
        $this->assertInstanceOf(\Vestd\FeatureFlags\Feature::class, $collection->get('flag_b'));
        $this->assertInstanceOf(\Vestd\FeatureFlags\Feature::class, $collection->get('flag_c'));

        $this->assertFalse($collection->get('flag_a')->isEnabled());
        $this->assertTrue($collection->get('flag_b')->isEnabled());
        $this->assertTrue($collection->get('flag_c')->isEnabledForGroup('admin'));
        $this->assertFalse($collection->get('flag_c')->isEnabledForGroup('guest'));
    }


}