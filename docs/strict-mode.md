# Strict mode

By default, DTOs silently ignore unexpected or missing fields from the API response. Strict mode opts into validation that throws exceptions when the API response doesn't match the expected shape.

## Enabling strict mode

Pass `strict: true` when constructing the client:

```php
use Philicevic\FaceitPhp\Faceit;

$faceit = new Faceit(token: $_ENV['FACEIT_API_TOKEN'], strict: true);
```

Once enabled, strict mode applies globally to all DTO hydration for the lifetime of that `Faceit` instance.

## What it validates

When strict mode is on, the `ValidatesFields` trait checks every DTO as it is hydrated from the API response:

- **Missing required fields** — throws `MissingFieldException` if a field declared in the schema is absent from the response.
- **Type mismatches** — throws `TypeMismatchException` if a field's value doesn't match its expected type.
- **Unknown fields** — throws `UnknownFieldException` if the response contains keys not declared in the DTO schema.

All exceptions extend `ValidationException`, which in turn extends `FaceitException`.

## Exception classes

| Exception | When thrown |
|---|---|
| `Philicevic\FaceitPhp\Exceptions\MissingFieldException` | A required field is absent |
| `Philicevic\FaceitPhp\Exceptions\TypeMismatchException` | A field's value is the wrong type |
| `Philicevic\FaceitPhp\Exceptions\UnknownFieldException` | The response contains an undeclared field |
| `Philicevic\FaceitPhp\Exceptions\ValidationException` | Base class for all of the above |

## When to use it

Strict mode is useful for:

- **Development and CI** — catch API changes or schema drift early.
- **Test suites** — verify that fixtures match the full DTO schema.

It is not recommended for production if you want to be resilient to additive API changes (new fields being added to responses).

## Example

```php
use Philicevic\FaceitPhp\Exceptions\ValidationException;
use Philicevic\FaceitPhp\Faceit;

$faceit = new Faceit(token: $_ENV['FACEIT_API_TOKEN'], strict: true);

try {
    $player = $faceit->player()->get('ffe3566c-9574-4f1b-8012-bf4d42aeb898');
} catch (ValidationException $e) {
    echo $e->getMessage();
    print_r($e->violations);
}
```

## Strict mode in tests

The `faceitMock()` helper accepts a `$strict` flag:

```php
$faceit = faceitMock(strict: true);
```
