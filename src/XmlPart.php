<?php

namespace Tabula17\Satelles\Xml;

use DOMElement;
use Exception;
use SimpleXMLElement;
use Tabula17\Satelles\Xml\Exception\InvalidXmlException;
use const PHP_VERSION_ID;

/**
 * A class for managing and manipulating XML elements, extending the functionality of SimpleXMLElement.
 */
class XmlPart extends SimpleXMLElement
{
    private ?DOMElement $domCache = null;

    /**
     * @param string $xmlFile
     * @throws Exception
     */
    public function __construct(string $xmlFile)
    {
        if (PHP_VERSION_ID < 80000) {
            libxml_disable_entity_loader(true);
        }
        parent::__construct($xmlFile, LIBXML_NOCDATA | LIBXML_NOENT | LIBXML_NONET);
        if (libxml_get_last_error() !== false) {
            throw new InvalidXmlException("XML mal formado o inseguro");
        }
    }

    public function __destruct()
    {
        $this->domCache = null;
    }


    private function asDomNode(): DOMElement
    {
        if ($this->domCache === null) {
            $this->domCache = dom_import_simplexml($this);
        }
        return $this->domCache;
    }

    /**
     * Replaces the current SimpleXMLElement with the provided SimpleXMLElement.
     *
     * @param SimpleXMLElement $element The new XML element to replace the current element with.
     * @return void
     */
    public function replace(SimpleXMLElement $element): void
    {
        $dom = $this->asDomNode();
        $import = $dom->ownerDocument->importNode(
            $element instanceof self ? $element->asDomNode() : dom_import_simplexml($element),
            true);
        $dom->parentNode->replaceChild($import, $dom);
        $this->domCache = null;
    }

    /**
     * Replaces the current XML element with the provided text content.
     *
     * @param string $text The text content to replace the current XML element with.
     * @return void
     */
    public function replaceWithText(string $text): void
    {
        /*$dom = dom_import_simplexml($this);
        $parent = $dom->parentNode;
        $parent->removeChild($dom);
        $parent->nodeValue = $text;*/
        $dom = $this->asDomNode();
        $textNode = $dom->ownerDocument->createTextNode($text);
        $dom->parentNode->replaceChild($textNode, $dom);
        $this->domCache = null;
    }

    /**
     * Deletes the current XML element from its parent.
     *
     * @return void
     */
    public function delete(): void
    {
        $dom = $this->asDomNode();
        $dom->parentNode->removeChild($dom);
        $this->domCache = null;
    }

    /**
     * @return string|null
     */
    public function getNodePath(): ?string
    {
        return $this->asDomNode()->getNodePath();
    }

    /**
     * Creates a duplicate of the current XML element and inserts it before the original element.
     *
     * @return XmlPart The duplicated XML element.
     */
    public function duplicate(bool $before = true): XmlPart
    {
        /*      $dom = dom_import_simplexml($this);
              $clone = $dom->ownerDocument->importNode(dom_import_simplexml($this)->cloneNode(true), true);
              //$dom->parentNode->appendChild($clone);
              $dom->parentNode->insertBefore($clone, $dom);
              $path = $clone->getNodePath();
              return $this->xpath($path)[0];
      */

        $dom = $this->asDomNode();
        $clone = $dom->cloneNode(true);

        $inserted = $before
            ? $dom->parentNode->insertBefore($clone, $dom)
            : $dom->parentNode->insertBefore($clone, $dom->nextSibling);

        /**
         * @var XmlPart $out
         */
        $out =  simplexml_import_dom($inserted, get_class($this));
        $this->domCache = null;
        return $out;
    }

    /**
     * Sets an attribute on the current XML element with the specified name and value.
     *
     * @param string $name The name of the attribute to set.
     * @param string $value The value to assign to the attribute.
     * @return void
     */
    public function setAttribute(string $name, string $value): void
    {
        $dom = dom_import_simplexml($this);
        $dom->setAttribute($name, $value);

    }

    public function setAttributes(array $attributes): void
    {
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }
    }

    public function hasAttribute(string $name): bool
    {
        return $this->asDomNode()->hasAttribute($name);
    }

    /**
     * @param string $name
     * @return void
     */
    public function removeAttribute(string $name): void
    {
        if ($this->hasAttribute($name)) {
            $dom = $this->asDomNode();
            $dom->removeAttribute($name);
        }
    }
}