# Batch Order list

#### (**Client Only**)

Used to collect client batch orders

**URL** : `/api/client/batch/order/{id}`

**Params**
1. `id` = batch id (identifier)

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
    "success":true,
    "message":"",
    "orders": [
        {
            "id":4,
            "client_id":31,
            "batch_id":658001,
            "patient_id":25,
            "id_prefix":"191562857692",
            "or_number":null,
            "clinical_information":"",
            "special_instructions":"",
            "status":0,
            "is_urgent":0,
            "deleted_at":null,
            "created_at":"2019-07-11 23:08:12",
            "updated_at":"2019-07-11 23:08:12",
            "services": [
                {
                    "batch_order_id":: 1,
                    "service_id":: 1,
                },
                {
                    "batch_order_id":: 2,
                    "service_id":: 2,
                },
            ]
        },
        {
            "id":8,
            "client_id":31,
            "batch_id":658001,
            "patient_id":23,
            "id_prefix":"191562858199",
            "or_number":null,
            "clinical_information":"NOT be an old Crab took the cauldron of soup off the fire, stirring a large pigeon had flown into her head. Still she went to the Caterpillar, just as well say this), 'to go on with the dream of.",
            "special_instructions":"The Cat seemed to be Number One,' said Alice. 'Well, then,' the Gryphon whispered in a soothing tone: 'don't be angry about it. And yet you incessantly stand on your shoes and stockings for you now.",
            "status":0,
            "is_urgent":0,
            "deleted_at":null,
            "created_at":"2019-07-11 23:16:39",
            "updated_at":"2019-07-11 23:16:39",
            "services": [
                {
                    "batch_order_id":: 1,
                    "service_id":: 1,
                },
                {
                    "batch_order_id":: 2,
                    "service_id":: 2,
                },
            ]
        },
        {
            "id":9,
            "client_id":31,
            "batch_id":658001,
            "patient_id":25,
            "id_prefix":"191562858237",
            "or_number":null,
            "clinical_information":"Hatter added as an explanation; 'I've none of YOUR business, Two!' said Seven. 'Yes, it IS his business!' said Five, 'and I'll tell him--it was for bringing the cook had disappeared. 'Never mind!'.",
            "special_instructions":"Dodo solemnly, rising to its feet, ran round the rosetree; for, you see, as well go in ringlets at all; however, she waited patiently. 'Once,' said the King. Here one of the jury asked. 'That I.",
            "status":0,
            "is_urgent":0,
            "deleted_at":null,
            "created_at":"2019-07-11 23:17:16",
            "updated_at":"2019-07-11 23:17:16",
            "services": [
                {
                    "batch_order_id":: 1,
                    "service_id":: 1,
                },
                {
                    "batch_order_id":: 2,
                    "service_id":: 2,
                },
            ]
        }
    ]
}
```
