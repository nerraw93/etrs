# Batch update

#### (**Client Only**)

Update client batch

**URL** : `/api/client/batch/:id/update`

**Params**
1. **id** = batch id

**Method** : `POST`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Post Data**

```json
{
    "source_id": "asd", * Required
    "dispatcher_id": "asd", * Required
    "patient_type_id": "asd", * Required
    "payment_mode": "asd", * Required
    "clinician_id": "asd",
    "client_id": "asd",
    "status": "asd",
    "slides": "asd",
    "blood": "asd",
    "forms": "asd",
    "specimen": "asd",
    "is_confirmed": "0" * Required ***NOTE! If set to 1 batch is in "confirmed" ELSE to 0 batch is draft mode
}
```

> All fields that are **NOT** required are optional.

**Content examples**

```json
{
    "success":true,
    "message":"New patient has been updated.",
    "patient": {
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
    },
}
```
