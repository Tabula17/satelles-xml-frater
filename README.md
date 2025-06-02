# XVII: 🛰️ satelles-xml-frater
![PHP Version](https://img.shields.io/badge/PHP-8.4%2B-blue)
![License](https://img.shields.io/github/license/Tabula17/satelles-xml-frater)
![Last commit](https://img.shields.io/github/last-commit/Tabula17/satelles-xml-frater)

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

MIT License

## Soporte

Para reportar problemas o solicitar nuevas características:
1. Revisa los issues existentes
2. Abre un nuevo issue con los detalles del problema o sugerencia

###### 🌌 Ad astra per codicem