# vakata\random\Generator
A random data generator class.

## Methods

| Name | Description |
|------|-------------|
|[bytes](#vakata\random\generatorbytes)|Generate random bytes.|
|[string](#vakata\random\generatorstring)|Generate a random string.|
|[number](#vakata\random\generatornumber)|Generate a random number from a range.|

---



### vakata\random\Generator::bytes
Generate random bytes.  


```php
public static function bytes (  
    integer $length,  
    integer $strength  
) : string    
```

|  | Type | Description |
|-----|-----|-----|
| `$length` | `integer` | amount of bytes to generate |
| `$strength` | `integer` | bitflag of which sources to use by strength (1-high, 2-medium, 4-low), default to 7 |
|  |  |  |
| `return` | `string` | the random bytes |

---


### vakata\random\Generator::string
Generate a random string.  


```php
public static function string (  
    integer $length,  
    string $characters  
) : string    
```

|  | Type | Description |
|-----|-----|-----|
| `$length` | `integer` | the string length |
| `$characters` | `string` | chars to include (for example `"ABCDEF0123456789"`) |
|  |  |  |
| `return` | `string` | the random string |

---


### vakata\random\Generator::number
Generate a random number from a range.  


```php
public static function number (  
    integer $min,  
    integer $max  
) : integer    
```

|  | Type | Description |
|-----|-----|-----|
| `$min` | `integer` | the minimum number (defaults to 0) |
| `$max` | `integer` | the maximum number (defaults to PHP_INT_MAX) |
|  |  |  |
| `return` | `integer` | the random number |

---

