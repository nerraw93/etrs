# Client services list

#### (**Client Only**)

Used to collect client services

**URL** : `/api/client/services`

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
    "success":true,
    "message":"",
    "services": [
        {
            "id":1,
            "code":"b",
            "name":"orchestrate value-added portals",
            "default_cost":5448,
            "created_at":"2019-05-18 01:38:18",
            "updated_at":"2019-05-18 01:38:18",
            "tests_count": 1,
        },
        {
            "id":2,
            "code":"c",
            "name":"whiteboard innovative systems",
            "default_cost":2005,
            "created_at":"2019-05-18 01:38:18",
            "updated_at":"2019-05-18 01:38:18",
            "tests_count": 1,
        },
    ]
}
```
