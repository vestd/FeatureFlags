<?php

use Mockery as m;

class FeatureTest extends TestCase
{

    /** @test */
    public function a_boolean_feature_is_true()
    {
        $feature = new \Vestd\FeatureFlags\Feature("bool_true");
        $feature->setBooleanStatus(true);

        $this->assertTrue($feature->isEnabled());
    }

    /** @test */
    public function a_boolean_feature_is_false()
    {
        $feature = new \Vestd\FeatureFlags\Feature("bool_false");
        $feature->setBooleanStatus(false);

        $this->assertFalse($feature->isEnabled());
    }

    /** @test */
    public function a_feature_request_returns_simple_response()
    {
        $feature = new \Vestd\FeatureFlags\Feature("bool_false");
        $feature->setBooleanStatus(true);

        $this->assertTrue($feature->isEnabledForUser(123));
    }

    /**
     * @test
     * @expectedException        Vestd\FeatureFlags\InvalidOptionException
     */
    public function complex_feature_throws_exception_on_simple_status()
    {
        $feature = new \Vestd\FeatureFlags\Feature("complex_false");
        $feature->setStatus(['users' => [123]]);

        $feature->isEnabled();
    }

    /** @test */
    public function complex_selection_is_correct()
    {
        $feature = new \Vestd\FeatureFlags\Feature("complex_true_false");
        $feature->setStatus(['users' => [123, 456]]);

        $this->assertTrue($feature->isEnabledForUser(123));
        $this->assertTrue($feature->isEnabledForUser(456));
        $this->assertFalse($feature->isEnabledForUser(789));
    }

}