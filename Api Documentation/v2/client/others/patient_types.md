# Client patient types

#### (**Client Only**)

Used to collect client patient types

**URL** : `/api/client/patient-types`

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
    "success":true,
    "message":"",
    "patient-types": [
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
