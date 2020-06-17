# IP address White List - delete

#### (**Admin Only**)

This endpoint will save an IP address to the system’s IP whitelist records. This means that the usage of the whole API will be limited to only those IP addresses

**URL** : `/api/v1/white-list/ips/{whiteListId}`

**Method** : `DELETE`

**URL Params**

1. `whiteListId` = White list ip id.

**Auth required** : YES

### Success Response

**Code** : `200 OK`

**Response examples**

```json
{
  data: null
}
```
