# XVII: satelles-xml-frater

Una librería PHP para gestionar y manipular elementos XML de forma sencilla y segura, extendiendo la funcionalidad de `SimpleXMLElement`.

## Características

- Reemplazo y duplicado de nodos XML
- Eliminación de nodos
- Gestión de atributos (agregar, eliminar, verificar)
- Seguridad mejorada al cargar XML
- Basado en PHP y Composer

## Instalación

Requiere PHP 8.0 o superior y Composer.

```bash
composer require tabula17/satelles-xml
```

## Uso básico

```php
use Tabula17\Satelles\Xml\XmlPart;

$xml = new XmlPart('<root><item id="1">Texto</item></root>');

// Duplicar un nodo
$item = $xml->item;
$itemDuplicado = $item->duplicate();

// Reemplazar un nodo
$item->replaceWithText('Nuevo texto');

// Agregar atributo
$item->setAttribute('nuevo', 'valor');

// Eliminar nodo
$item->delete();
```

## Pruebas

Puedes ejecutar las pruebas con:

```bash
composer test
```

## Licencia

MIT
