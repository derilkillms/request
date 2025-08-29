# Request

## Instalation
```
composer require derilkillms/request
```

### Information

**Request methods : ([wikipedia](https://en.wikipedia.org/wiki/HTTP#Request_methods))**
HTTP defines methods (sometimes referred to as verbs, but nowhere in the specification does it mention verb) to indicate the desired action to be performed on the identified resource. What this resource represents, whether pre-existing data or data that is generated dynamically, depends on the implementation of the server. Often, the resource corresponds to a file or the output of an executable residing on the server. The HTTP/1.0 specification[49] defined the GET, HEAD, and POST methods as well as listing the PUT, DELETE, LINK and UNLINK methods under additional methods. However, the HTTP/1.1 specification[50] formally defined and added five new methods: PUT, DELETE, CONNECT, OPTIONS, and TRACE. Any client can use any method and the server can be configured to support any combination of methods. If a method is unknown to an intermediate, it will be treated as an unsafe and non-idempotent method. There is no limit to the number of methods that can be defined, which allows for future methods to be specified without breaking existing infrastructure. For example, WebDAV defined seven new methods and RFC 5789 specified the PATCH method..

....

**This Repository Based : PHP**
```php
require __DIR__ . '/vendor/autoload.php';

use Derilkillms\Http\Request;

session_start();
$request = new Request();

// Cek method
echo $request->method(); // ex: POST

// GET
$id = $request->get('id');

// POST
$username = $request->post('username');

// PUT
$payload = $request->put();

// PATCH
$title = $request->patch('title');

// DELETE
$itemId = $request->delete('id');

// SESSION
$request->setSession('user_id', 42);
echo $request->session('user_id');

// Ambil semua data sesuai method aktif
$data = $request->all();

```