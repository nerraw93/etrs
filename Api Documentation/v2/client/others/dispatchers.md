# Dispatchers

#### (**Client Only**)

Used to collect dispatchers

**URL** : `/api/client/dispatchers`

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
    "success":true,
    "message":"",
    "dispatchers": [
        {
            "id":2,
            "code":"1",
            "name":"in",
            "created_at":"2019-05-22 00:20:33",
            "updated_at":"2019-05-22 00:34:47"
        },
        {
            "id":3,
            "code":"2",
            "name":"TEST",
            "created_at":"2019-05-22 00:20:33",
            "updated_at":"2019-05-22 00:20:33"
        },
    ]
}
```
