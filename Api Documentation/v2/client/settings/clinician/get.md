# Client Clinician list

#### (**Client Only**)

Used to collect client clinicians

**URL** : `/api/client/settings/clinician`

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
    "success":true,
    "message":"",
    "patients":{
        "current_page":1,
        "data":[
            {
                "id": 10,
                "user_id": 64,
                "name": "Scarlett Mitchell IV",
                "created_at": "2019-06-15 03:08:09",
                "updated_at": "2019-06-15 03:08:09",
            },
            {
                "id": 10,
                "user_id": 64,
                "name": "Scarlett Mitchell IV",
                "created_at": "2019-06-15 03:08:09",
                "updated_at": "2019-06-15 03:08:09",
            },
        ],
        "first_page_url": "http://localhost/api/client/settings/clinician?page=1",
        "from": 1,
        "last_page": 4,
        "last_page_url": "http://localhost/api/client/settings/clinician?page=4",
        "next_page_url": "http://localhost/api/client/settings/clinician?page=2",
        "path": "http://localhost/api/client/settings/clinician",
        "per_page": 10,
        "prev_page_url": null,
        "to": 10,
        "total": 36
    }
}
```
> Result is in `pagination` format. See [Pagination format](../../helper/pagination.md)
