<?php

namespace Vestd\FeatureFlags;

class Feature
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array|bool
     */
    private $status;

    /**
     * @var string
     */
    private $type;

    /**
     * In the supplied config array these are the types of filter groups supported
     *
     * @var array
     */
    private $validFlagStatusGroups = ['groups', 'users'];

    /**
     * A basic boolean feature flag, enabled or disabled for all
     */
    const BOOLEAN_TYPE = 'boolean';

    /**
     * A complex flag type, its status will be determined by the supplied group or user id
     */
    const MATRIX_TYPE = 'matrix';

    /**
     * Create a new feature
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function setBooleanStatus($status)
    {
        $this->type = self::BOOLEAN_TYPE;

        $this->status = (bool)$status;

        return $this;
    }

    /**
     * @param array $status
     *
     * @return $this
     */
    public function setStatus(array $status)
    {
        $this->type = self::MATRIX_TYPE;
        $this->status = [];

        foreach ($this->validFlagStatusGroups as $type) {
            if (isset($status[$type])) {
                $this->status[$type] = [];
                foreach ($status[$type] as $user) {
                    $this->status[$type][$user] = true;
                }
            }
        }

        return $this;
    }

    /**
     * @return bool
     * @throws InvalidOptionException
     */
    public function isEnabled()
    {
        if ($this->type != self::BOOLEAN_TYPE) {
            throw new InvalidOptionException("Not a boolean feature, please use isEnabledForUser or isEnabledForGroup");
        }
        return $this->status;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function isEnabledForUser($id)
    {
        return $this->isEnabledFor($id, 'users');
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function isEnabledForGroup($id)
    {
        return $this->isEnabledFor($id, 'groups');
    }

    /**
     * @param string $id
     * @param string $type
     *
     * @return bool
     * @throws InvalidOptionException
     */
    private function isEnabledFor($id, $type)
    {
        if (!in_array($type, $this->validFlagStatusGroups)) {
            throw new InvalidOptionException("Unsupported type, " . $type . " not in " . implode(',', $this->validFlagStatusGroups));
        }
        //If this is a boolean feature just return that status
        if ($this->type == self::BOOLEAN_TYPE) {
            return $this->status;
        }
        if (isset($this->status[$type][$id])) {
            return $this->status[$type][$id];
        }
        return false;
    }
}