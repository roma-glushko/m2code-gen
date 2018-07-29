<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Component\Magento\Config;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMText;
use DOMXPath;

/**
 * Class XmlConfigMerger
 */
class XmlConfigMerger
{
    /**
     * Prefix which will be used for root namespace
     */
    const ROOT_NAMESPACE_PREFIX = 'x';

    /**
     * Default namespace for xml elements
     *
     * @var string
     */
    protected $rootNamespace;

    /**
     * @var NodeMergingConfig
     */
    protected $nodeMergingConfig;

    /**
     * @var null 
     */
    protected $typeAttributeName = 'xsi:type';

    /**
     * @param NodeMergingConfig $nodeMergingConfig
     */
    public function __construct(
        NodeMergingConfig $nodeMergingConfig
    ) {
        $this->nodeMergingConfig = $nodeMergingConfig;
    }

    /**
     * @param string $originalXmlSnippet
     * @param string $additionalXmlSnippet
     *
     * @return string
     */
    public function merge(string $originalXmlSnippet, string $additionalXmlSnippet)
    {
        $originalDom = $this->createDom($originalXmlSnippet);
        $additionalDom = $this->createDom($additionalXmlSnippet);

        $this->mergeNode($originalDom, $additionalDom->documentElement, '');

        return $originalDom->saveXML();
    }

    /**
     * @param string $xmlSnippet
     *
     * @return DOMDocument
     */
    protected function createDom($xmlSnippet)
    {
        $dom = new DOMDocument();

        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        // check result @todo
        $dom->loadXML($xmlSnippet);

        return $dom;
    }

    /**
     * Recursive merging of the \DOMElement into the original document
     *
     * Algorithm:
     * 1. Find the same node in original document
     * 2. Extend and override original document node attributes and scalar value if found
     * 3. Append new node if original document doesn't have the same node
     *
     * @param DOMElement $node
     * @param string $parentPath path to parent node
     *
     * @return void
     */
    protected function mergeNode(DOMDocument $baseDom, DOMElement $node, $parentPath)
    {
        $path = $this->getNodePathByParent($node, $parentPath);
        $matchedNode = $this->getMatchedNode($baseDom, $path);

        /* Update matched node attributes and value */
        if (!$matchedNode) {
            /* Add node as is to the document under the same parent element */
            $parentMatchedNode = $this->getMatchedNode($baseDom, $parentPath);
            $newNode = $baseDom->importNode($node, true);
            $parentMatchedNode->appendChild($newNode);

            return;
        }

        //different node type
        if ($this->typeAttributeName &&
            $node->hasAttribute($this->typeAttributeName) &&
            $matchedNode->hasAttribute($this->typeAttributeName) &&
            $node->getAttribute($this->typeAttributeName) !== $matchedNode->getAttribute($this->typeAttributeName)
        ) {
            var_dump('replace nodes');
            $parentMatchedNode = $this->getMatchedNode($baseDom, $parentPath);
            $newNode = $baseDom->importNode($node, true);
            $parentMatchedNode->replaceChild($newNode, $matchedNode);

            return;
        }

        $this->mergeAttributes($matchedNode, $node);

        if (!$node->hasChildNodes()) {
            return;
        }

        /* override node value */
        if ($this->isTextNode($node)) {

            /* skip the case when the matched node has children, otherwise they get overridden */
            if (!$matchedNode->hasChildNodes() || $this->isTextNode($matchedNode)) {
                $matchedNode->nodeValue = $node->childNodes->item(0)->nodeValue;
            }

        } else {
            /* recursive merge for all child nodes */
            foreach ($node->childNodes as $childNode) {
                if ($childNode instanceof DOMElement) {
                    $this->mergeNode($baseDom, $childNode, $path);
                }
            }
        }
    }

    /**
     * Check if the node content is text
     *
     * @param DOMElement $node
     * @return bool
     */
    protected function isTextNode($node)
    {
        return $node->childNodes->length == 1 && $node->childNodes->item(0) instanceof DOMText;
    }

    /**
     * Merges attributes of the merge node to the base node
     *
     * @param DOMElement $baseNode
     * @param DOMNode $mergeNode
     * @return void
     */
    protected function mergeAttributes($baseNode, $mergeNode)
    {
        foreach ($mergeNode->attributes as $attribute) {
            $baseNode->setAttribute($this->getAttributeName($attribute), $attribute->value);
        }
    }

    /**
     * Identify node path based on parent path and node attributes
     *
     * @param DOMElement $node
     * @param string $parentPath
     *
     * @return string
     */
    protected function getNodePathByParent(DOMElement $node, $parentPath)
    {
        $prefix = $this->rootNamespace === null ? '' : self::ROOT_NAMESPACE_PREFIX . ':';
        $path = $parentPath . '/' . $prefix . $node->tagName;

        $idAttribute = $this->nodeMergingConfig->getIdAttribute($path);

        if (is_array($idAttribute)) {
            $constraints = [];
            foreach ($idAttribute as $attribute) {
                $value = $node->getAttribute($attribute);
                $constraints[] = "@{$attribute}='{$value}'";
            }
            $path .= '[' . implode(' and ', $constraints) . ']';
        } elseif ($idAttribute && ($value = $node->getAttribute($idAttribute))) {
            $path .= "[@{$idAttribute}='{$value}']";
        }

        return $path;
    }

    /**
     * Getter for node by path
     *
     * @param DOMDocument $baseDom
     * @param string $nodePath
     *
     * @return DOMElement|null
     */
    protected function getMatchedNode($baseDom, $nodePath)
    {
        $xPath = new DOMXPath($baseDom);

        if ($this->rootNamespace) {
            $xPath->registerNamespace(self::ROOT_NAMESPACE_PREFIX, $this->rootNamespace);
        }

        $matchedNodes = $xPath->query($nodePath);
        $node = null;

        if ($matchedNodes->length > 1) {

            // todo: throw error

        } elseif ($matchedNodes->length == 1) {
            $node = $matchedNodes->item(0);
        }

        return $node;
    }

    /**
     * Returns the attribute name with prefix, if there is one
     *
     * @param \DOMAttr $attribute
     * @return string
     */
    private function getAttributeName($attribute)
    {
        if ($attribute->prefix !== null && !empty($attribute->prefix)) {
            $attributeName = $attribute->prefix . ':' . $attribute->name;
        } else {
            $attributeName = $attribute->name;
        }

        return $attributeName;
    }
    
    /**
     * @return mixed
     */
    public function getNodeMergingConfig()
    {
        return $this->nodeMergingConfig;
    }

    /**
     * @param mixed $nodeMergingConfig
     */
    public function setNodeMergingConfig($nodeMergingConfig): void
    {
        $this->nodeMergingConfig = $nodeMergingConfig;
    }
}