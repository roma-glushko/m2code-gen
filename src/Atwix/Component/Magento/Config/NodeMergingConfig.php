<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Atwix\System\Magento\Config;

/**
 * Configuration of identifier attributes to be taken into account during merging
 */
class NodeMergingConfig
{
    /**
     * @var NodePathMatcher
     */
    private $nodePathMatcher;

    /**
     * Format: array('/node/path' => '<node_id_attribute>', ...)
     *
     * @var array
     * @todo make it possible to configure this array
     */
    private $idAttributes = [
        '/config/preference' => 'for',
        '/config/(type|virtualType)' => 'name',
        '/config/(type|virtualType)/plugin' => 'name',
        '/config/(type|virtualType)/arguments/argument' => 'name',
        '/config/(type|virtualType)/arguments/argument(/item)+' => 'name',
    ];

    /**
     * @param NodePathMatcher $nodePathMatcher
     * @param array $idAttributes
     */
    public function __construct(NodePathMatcher $nodePathMatcher, array $idAttributes = [])
    {
        $this->nodePathMatcher = $nodePathMatcher;
        $this->idAttributes = array_merge($this->idAttributes, $idAttributes);
    }

    /**
     * Retrieve name of an identifier attribute for a node
     *
     * @param string $nodeXpath
     *
     * @return string|null
     */
    public function getIdAttribute($nodeXpath)
    {
        foreach ($this->idAttributes as $pathPattern => $idAttribute) {
            if ($this->nodePathMatcher->match($pathPattern, $nodeXpath)) {
                return $idAttribute;
            }
        }

        return null;
    }
}
