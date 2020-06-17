# Service - create/update

#### (**Admin Only**)

Create or update a custom default cost for a service by source.

**URL** : `/api/v1/service/prices`

**Method** : `POST`

**Post Data**

1. `serviceCode` = **Required** Code of the service.
2. `sourceCode`	= **Required** Code of the source.
3. `defaultCost` = **Required** New cost for the service.


**Auth required** : YES

### Success Response

**Code** : `200 OK`

**Response examples**

```json
{
	"data": {
		"serviceCode": "ipsam voluptates ad",
		"sourceCode": "synergize killer e-business",
		"defaultCost": 6373
	}
}
```
