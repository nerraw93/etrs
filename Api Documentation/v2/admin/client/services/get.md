# Client service list

#### (**Admin Only**)

Used to collect client services

**URL** : `/api/admin/client/{id}/services`

**Params**
1. **id** = user/client id

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
    "success":true,
    "message":"",
    "services":{
        "current_page":1,
        "data":
        [
            {
            "id":346,
            "user_id":28,
            "service_id":2,
            "price":110,
            "created_at":"2019-08-03 01:02:08",
            "updated_at":"2019-08-03 01:02:08",
            "service":{
                "id":2,
                "code":"ABORHR",
                "name":"BT Card Replacement",
                "default_cost":0,
                "created_at":"2019-08-03 01:00:18",
                "updated_at":"2019-08-03 01:00:18"}
            },
            {
                "id":347,
                "user_id":28,
                "service_id":3,
                "price":165,
                "created_at":"2019-08-03 01:02:08",
                "updated_at":"2019-08-03 01:02:08",
                "service":{
                    "id":3,
                    "code":"BUN",
                    "name":"BUN (KINETIC)",
                    "default_cost":0,
                    "created_at":"2019-08-03 01:00:18",
                    "updated_at":"2019-08-03 01:00:18"}
                },
            {
                "id":348,
                "user_id":28,
                "service_id":4,
                "price":550,
                "created_at":"2019-08-03 01:02:08",
                "updated_at":"2019-08-03 01:02:08",
                "service":{
                    "id":4,
                    "code":"CYTO7",
                    "name":"CYTOLOGY (1-4 Slides)",
                    "default_cost":0,
                    "created_at":"2019-08-03 01:00:18",
                    "updated_at":"2019-08-03 01:00:18"}
                },
            {
                "id":349,
                "user_id":28,
                "service_id":5,
                "price":198,
                "created_at":"2019-08-03 01:02:08",
                "updated_at":"2019-08-03 01:02:08",
                "service":
                {
                    "id":5,
                    "code":"CBC",
                    "name":"Complete Blood Count.",
                    "default_cost":0,
                    "created_at":"2019-08-03 01:00:18",
                    "updated_at":"2019-08-03 01:00:18"
                }
            },
        ],
        "first_page_url":"http:\/\/dev.erts-hpo.com\/api\/admin\/client\/28\/services?page=1",
        "from":1,
        "last_page":153,
        "last_page_url":"http:\/\/dev.erts-hpo.com\/api\/admin\/client\/28\/services?page=153",
        "next_page_url":"http:\/\/dev.erts-hpo.com\/api\/admin\/client\/28\/services?page=2",
        "path":"http:\/\/dev.erts-hpo.com\/api\/admin\/client\/28\/services",
        "per_page":10,
        "prev_page_url":null,
        "to":10,
        "total":1524
    }
}
```
