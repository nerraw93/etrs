# Batch listing, filtering and search

#### (**Admin Only**)

Used to get list of batch, search batch using id or **filter** batch status.

**URL** : `/api/admin/batch`

**Query Params**
1. `search` = batch search key id. **Sample `/api/admin/batch?search=199`**
2. `status` = `0` = draft, `1` = confirmed, `2` = accomplised. **Sample `/api/admin/batch?search=199&status=1`**
> If status param is not provided all type of status will be shown.

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
    "success":true,
    "message":"",
    "batches":{
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "code": "b",
                "source_id": 1,
                "clinician_id": 11,
                "client_id": 31,
                "patient_type_id": 1,
                "dispatcher_id": 3,
                "payment_mode": 0,
                "status": 1,
                "slides": 99,
                "blood": null,
                "forms": null,
                "specimen": null,
                "created_at": "2019-07-04 17:24:20",
                "updated_at": "2019-07-04 17:24:20",
                "dispatcher": {
                    "id": 3,
                    "code": "2",
                    "name": "TEST",
                    "created_at": "2019-07-04 17:17:59",
                    "updated_at": "2019-07-04 17:17:59",
                }
                "source": {
                    "id": 1,
                    "code": "b",
                    "name": "Leannon, Davis and Ledner",
                    "created_at": "2019-07-04 17:17:57",
                    "updated_at": "2019-07-04 17:17:57",
                }
                "clinician": {
                    "id": 11,
                    "user_id": 31,
                    "name": "Immanuel",
                    "created_at": "2019-07-04 17:18:02",
                    "updated_at": "2019-07-04 17:18:02",
                }
                "patient_type": {
                    "id": 1,
                    "code": "pLG5y",
                    "name": "Emery",
                    "created_at": "2019-07-04 17:18:02",
                    "updated_at": "2019-07-04 17:18:02",
                }
                "client": {
                    "id": 31,
                    "dispatcher_id": null,
                    "code": "7",
                    "global_prefix": "",
                    "role": 0,
                    "username": "rylan.baumbach",
                    "email": "perfect_client@gmail.com",
                    "api_token": null,
                    "first_name": "Branson",
                    "last_name": "Kessler",
                    "contact_number": "764-897-2730",
                    "business_name": "Russel, Schultz and Spencer",
                    "business_address": """,
                    337 Nichole Crescent Apt. 951\n
                    South Orionmouth, WA 31810-8832
                    """,
                    "is_active": 1,
                    "payment_mode": 0,
                    "created_at": "2019-07-04 17:17:51",
                    "updated_at": "2019-07-04 17:17:51",
                    "full_name": "Branson Kessler",
                }
            },
        ],
        "first_page_url": "http://localhost/api/client/batch?page=1",
        "from": 1,
        "last_page": 2,
        "last_page_url": "http://localhost/api/client/batch?page=2",
        "next_page_url": "http://localhost/api/client/batch?page=2",
        "path": "http://localhost/api/client/batch",
        "per_page": 10,
        "prev_page_url": null,
        "to": 10,
        "total": 16,
    }
}
```

> Result is in `pagination` format. See [Pagination format](../../helper/pagination.md)
