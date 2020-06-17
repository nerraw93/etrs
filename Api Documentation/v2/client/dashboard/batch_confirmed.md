# Batch order confirmed list

#### (**Client Only**)

Used to collect BatchOrders that user owns list that are in `CONFIRMED` status.

**URL** : `/api/client/dashboard/batches/confirmed`

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
    "success":true,
    "message":"",
    "batch_orders":{
        "current_page":1,
        "data":[
            {
                "id":65800658006,
                "code":"bivhvvp2",
                "source_id":2,
                "clinician_id":11,
                "client_id":31,
                "patient_type_id":2,
                "dispatcher_id":4,
                "payment_mode":0,
                "status":0,
                "slides":99,
                "blood":null,
                "forms":null,
                "specimen":null,
                "created_at":"2019-07-17 21:58:00",
                "updated_at":"2019-07-17 21:58:00",
                "services_count":0,
                "dispatcher":{
                    "id":4,
                    "code":"et",
                    "name":"quos",
                    "created_at":"2019-07-17 21:57:24",
                    "updated_at":"2019-07-17 21:57:24"
                },
                "source":{
                    "id":2,
                    "code":"c",
                    "name":"Little Group",
                    "created_at":"2019-07-12 01:06:58",
                    "updated_at":"2019-07-12 01:06:58"
                },
                "clinician":{
                    "id":11,
                    "user_id":31,
                    "name":"Newton Gleichner",
                    "created_at":"2019-07-12 01:07:03",
                    "updated_at":"2019-07-17 21:57:31"
                },
                "patient_type":{
                    "id":2,
                    "code":"com",
                    "name":"pouros",
                    "created_at":"2019-07-17 21:57:24",
                    "updated_at":"2019-07-17 21:57:25"
                },
                "client":{
                    "id":31,
                    "dispatcher_id":null,
                    "code":"7",
                    "global_prefix":"",
                    "role":0,
                    "username":"olin04",
                    "email":"perfect_client@gmail.com",
                    "api_token":null,
                    "first_name":"Miles",
                    "last_name":"Wilderman",
                    "contact_number":"1-465-692-6730",
                    "business_name":"Ferry, Konopelski and Welch",
                    "business_address":"6763 Brekke Flat Suite 105\nNorth Sabrina, VA 88099",
                    "is_active":1,
                    "payment_mode":0,
                    "created_at":"2019-07-12 01:06:51",
                    "updated_at":"2019-07-12 01:06:51",
                    "full_name":"Miles Wilderman"
                },
                "orders":[
                    {
                        "id":221,
                        "client_id":31,
                        "batch_id":65800658010,
                        "patient_id":18,
                        "id_prefix":"191563374232",
                        "or_number":null,
                        "clinical_information":"And I declare it's too bad, that it had come back and finish your story!' Alice called out in a tone of great curiosity. 'It's a Cheshire cat,' said the King say in a moment. 'Let's go on for some.",
                        "special_instructions":"White Rabbit cried out, 'Silence in the pool rippling to the dance. So they got thrown out to sea as you might like to be treated with respect. 'Cheshire Puss,' she began, in a louder tone. 'ARE you.",
                        "status":0,
                        "is_urgent":0,
                        "deleted_at":null,
                        "created_at":"2019-07-17 22:37:12",
                        "updated_at":"2019-07-17 22:37:12",
                        "services":[
                            {
                                "id":449,
                                "batch_order_id":221,
                                "service_id":16,
                                "created_at":"2019-07-17 22:37:12",
                                "updated_at":"2019-07-17 22:37:12",
                                "service":{
                                    "id":18,
                                    "user_id":31,
                                    "service_id":16,
                                    "price":2370,
                                    "created_at":"2019-07-12 01:15:14",
                                    "updated_at":"2019-07-12 01:15:14"
                                }
                            },
                            {
                                "id":450,
                                "batch_order_id":221,
                                "service_id":17,
                                "created_at":"2019-07-17 22:37:12",
                                "updated_at":"2019-07-17 22:37:12",
                                "service":{
                                    "id":20,
                                    "user_id":31,
                                    "service_id":17,
                                    "price":9845,
                                    "created_at":"2019-07-12 01:15:14",
                                    "updated_at":"2019-07-12 01:15:14"
                                }
                            }
                        ]
                    }
                ]
            },
            {
                "id":65800658006,
                "code":"bivhvvp2",
                "source_id":2,
                "clinician_id":11,
                "client_id":31,
                "patient_type_id":2,
                "dispatcher_id":4,
                "payment_mode":0,
                "status":0,
                "slides":99,
                "blood":null,
                "forms":null,
                "specimen":null,
                "created_at":"2019-07-17 21:58:00",
                "updated_at":"2019-07-17 21:58:00",
                "services_count":0,
                "dispatcher":{
                    "id":4,
                    "code":"et",
                    "name":"quos",
                    "created_at":"2019-07-17 21:57:24",
                    "updated_at":"2019-07-17 21:57:24"
                },
                "source":{
                    "id":2,
                    "code":"c",
                    "name":"Little Group",
                    "created_at":"2019-07-12 01:06:58",
                    "updated_at":"2019-07-12 01:06:58"
                },
                "clinician":{
                    "id":11,
                    "user_id":31,
                    "name":"Newton Gleichner",
                    "created_at":"2019-07-12 01:07:03",
                    "updated_at":"2019-07-17 21:57:31"
                },
                "patient_type":{
                    "id":2,
                    "code":"com",
                    "name":"pouros",
                    "created_at":"2019-07-17 21:57:24",
                    "updated_at":"2019-07-17 21:57:25"
                },
                "client":{
                    "id":31,
                    "dispatcher_id":null,
                    "code":"7",
                    "global_prefix":"",
                    "role":0,
                    "username":"olin04",
                    "email":"perfect_client@gmail.com",
                    "api_token":null,
                    "first_name":"Miles",
                    "last_name":"Wilderman",
                    "contact_number":"1-465-692-6730",
                    "business_name":"Ferry, Konopelski and Welch",
                    "business_address":"6763 Brekke Flat Suite 105\nNorth Sabrina, VA 88099",
                    "is_active":1,
                    "payment_mode":0,
                    "created_at":"2019-07-12 01:06:51",
                    "updated_at":"2019-07-12 01:06:51",
                    "full_name":"Miles Wilderman"
                },
                "orders":[
                    {
                        "id":221,
                        "client_id":31,
                        "batch_id":65800658010,
                        "patient_id":18,
                        "id_prefix":"191563374232",
                        "or_number":null,
                        "clinical_information":"And I declare it's too bad, that it had come back and finish your story!' Alice called out in a tone of great curiosity. 'It's a Cheshire cat,' said the King say in a moment. 'Let's go on for some.",
                        "special_instructions":"White Rabbit cried out, 'Silence in the pool rippling to the dance. So they got thrown out to sea as you might like to be treated with respect. 'Cheshire Puss,' she began, in a louder tone. 'ARE you.",
                        "status":0,
                        "is_urgent":0,
                        "deleted_at":null,
                        "created_at":"2019-07-17 22:37:12",
                        "updated_at":"2019-07-17 22:37:12",
                        "services":[
                            {
                                "id":449,
                                "batch_order_id":221,
                                "service_id":16,
                                "created_at":"2019-07-17 22:37:12",
                                "updated_at":"2019-07-17 22:37:12",
                                "service":{
                                    "id":18,
                                    "user_id":31,
                                    "service_id":16,
                                    "price":2370,
                                    "created_at":"2019-07-12 01:15:14",
                                    "updated_at":"2019-07-12 01:15:14"
                                }
                            },
                            {
                                "id":450,
                                "batch_order_id":221,
                                "service_id":17,
                                "created_at":"2019-07-17 22:37:12",
                                "updated_at":"2019-07-17 22:37:12",
                                "service":{
                                    "id":20,
                                    "user_id":31,
                                    "service_id":17,
                                    "price":9845,
                                    "created_at":"2019-07-12 01:15:14",
                                    "updated_at":"2019-07-12 01:15:14"
                                }
                            }
                        ]
                    }
                ]
            },
        ],
        "first_page_url": "http://dev.erts-hpo.com/api/admin/dashboard/batches/draft?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://dev.erts-hpo.com/api/admin/dashboard/batches/draft?page=1",
        "next_page_url": null,
        "path": "http://dev.erts-hpo.com/api/admin/dashboard/batches/draft",
        "per_page": 10,
        "prev_page_url": null,
        "to": 3,
        "total": 8,
    }
}
```

```
> **NOTE!**
> On each batch values on frontend *per row on table*.
> * **No. of tests** = `services_count` to access each row `batch.services_count`
> * **No. of patients** = `orders_count` to access each row `batch.orders_count`
> * **Total Cost** = on each `batch` get all `orders`, loop on all `orders`  get `order` `services`, on `services` you can get a `services` which have the `price` total on each batch and put on cost. SO basically on the script, the code would be like this (this can be put on the `commit` after `dispatcing`).
```js
// Loop on all batches (row)
for (let batch in batches) {
    let total_cost = 0;
    let orders = batch.orders;
    for (let order in orders) {
        // Loop to services
        let services = order.services;
        for (let service in services) {
            // Go to client service price
            total_cost += service.service.price;
        }
    }
}
```
