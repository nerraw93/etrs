# Batch Create

#### (**Client Only**)

Store client batch

**URL** : `/api/client/batch/order/store`

**Method** : `POST`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Post Data**

```json
{
    "batch_id": "$request->batch_id", **Required
    "services": "[99, 90]", **Required - services id - get client services using this api `/api/client/services`
    "patient_id": "$request->patient_id", **Required
    "id_prefix": "$request->id_prefix",
    "or_number": "$request->or_number",
    "clinical_information": "$request->clinical_information",
    "special_instructions": "$request->special_instructions",
    "is_urgent": 0, **Required - `0` = minor , `1` = urgent
}
```

> All fields that are **NOT** required are optional.

**Content examples**

```json
{
    "success":true,
    "message":"Batch order has been created.",
    "order": {
        "id": 41,
        "client_id": 28,
        "code": "bh",
        "global_custom_id": "OL411560265182",
        "hpo_patient_id": "OL411560265182",
        "client_custom_id": null,
        "email": "zita.goyette@hotmail.com",
        "first_name": "Cornelius",
        "middle_name": null,
        "last_name": "Halvorson",
        "mothers_maiden_name": null,
        "gender": "female",
        "birth_date": "2005-05-26 00:00:00",
        "passport_number": "3720162815355",
        "citizen": "Pilipino",
        "blood_type": "O",
        "address": "5118 Malinda Track Suite 794 Schustershire, CA 39002-8100",
        "city": "Faheymouth",
        "senior_citizen_id": "9433196320101",
        "telephone_number": "866.259.1801",
        "fax_number": null,
        "mobile_number": null,
        "occupation": "Loading Machine Operator",
        "hmo_card": null,
        "hmo_card_no": null,
        "last_visit_at": null,
        "deleted_at": null,
        "created_at": "2019-06-11 22:59:42",
        "updated_at": "2019-06-11 22:59:42",
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
}
```
