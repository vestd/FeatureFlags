<?php

namespace Vestd\FeatureFlags;

class FeatureCollection
{

    private $featureFlags = [];

    /**
     * @param string $featureLabel
     *
     * @return Feature
     * @throws InvalidOptionException
     */
    public function get($featureLabel)
    {
        if (!isset($this->featureFlags[$featureLabel])) {
            throw new InvalidOptionException("Feature flag not found. " . $featureLabel);
        }

        return $this->featureFlags[$featureLabel];
    }

    /**
     * Set an individual feature and its status
     *
     * @param string     $featureLabel
     * @param bool|array $status
     */
    public function setFeatureStatus($featureLabel, $status)
    {
        if (isset($this->featureFlags[$featureLabel])) {
            $feature = $this->get($featureLabel);
        } else {
            $feature = new Feature($featureLabel);
        }
        if (is_array($status)) {
            $feature->setStatus($status);
        } else {
            $feature->setBooleanStatus($status);
        }
        $this->featureFlags[$featureLabel] = $feature;
    }

    /**
     * This receives an array of features and either a boolean status or a more complex matrix of valid users/groups
     *
     * @param array $features
     */
    public function setFeatures(array $features)
    {
        foreach ($features as $feature => $status) {
            $this->setFeatureStatus($feature, $status);
        }
    }
}