# Search services

#### (**Admin Only**)

Used to search services using name.

**URL** : `/api/admin/system/source/search/{$key}`

**Params**
1. **key** = search key

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
    "success":true,
    "message":"",
    "sources":{
        "current_page":1,
        "data": [
            {
                "id": 1,
                "code": "b",
                "name": "Wehner Group",
                "created_at": "2019-09-04 06:29:57",
                "updated_at": "2019-09-10 08:14:13"
            },
            {
                "id": 4,
                "code": "e",
                "name": "Schulist-Gutkowski",
                "created_at": "2019-09-04 06:29:57",
                "updated_at": "2019-09-04 06:29:57"
            }
        ],
        "first_page_url": "http://localhost:8000/api/admin/system/source/search/w?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:8000/api/admin/system/source/search/w?page=1",
        "next_page_url": null,
        "path": "http://localhost:8000/api/admin/system/source/search/w",
        "per_page": 10,
        "prev_page_url": null,
        "to": 2,
        "total": 2
    }
}
```

> Result is in `pagination` format. See [Pagination format](../../helper/pagination.md)
