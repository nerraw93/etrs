# Client service list

#### (**Admin Only**)

Used to collect Client that are bind on the service.

**URL** : `/api/admin/services/client/:id`

**Params**
1. `id` = Service id

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
    "success":true,
    "message":"",
    "clients":{
        "current_page": 1,
        "data": [
            {
                "id": 6,
                "user_id": 4,
                "service_id": 6,
                "price": 4217,
                "created_at": "2019-07-06 11:40:32",
                "updated_at": "2019-07-06 11:40:32",
                "user": {
                    "id": 4,
                    "dispatcher_id": null,
                    "code": "e",
                    "global_prefix": "",
                    "role": 0,
                    "username": "christop82",
                    "email": "antonia06@gmail.com",
                    "api_token": null,
                    "first_name": "Clemens",
                    "last_name": "Schmitt",
                    "contact_number": "(223) 216-2751 x19360",
                    "business_name": "Grimes Inc",
                    "business_address": """
                    8158 Koch Bridge Suite 703\n
                    Brianville, TN 82417-7062
                    """,
                    "is_active": 1,
                    "payment_mode": 0,
                    "created_at": "2019-07-06 11:40:17",
                    "updated_at": "2019-07-06 11:40:17",
                    "full_name": "Clemens Schmitt",
                }
            }
        ],
        "first_page_url": "http://dev.erts-hpo.com/api/admin/services/client/6?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://dev.erts-hpo.com/api/admin/services/client/6?page=1",
        "next_page_url": null,
        "path": "http://dev.erts-hpo.com/api/admin/services/client/6",
        "per_page": 10,
        "prev_page_url": null,
        "to": 1,
        "total": 1,
    }
}
```
