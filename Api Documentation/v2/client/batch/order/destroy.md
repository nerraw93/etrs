# Batch order delete

#### (**Client Only**)

Delete client batch order

**URL** : `/api/client/batch/order/{id}/destroy`

**Params**
1. **id** = batch order id

**Method** : `POST`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Post Data**

```json
{
}
```

**Content examples**

```json
{
    "success":true,
    "message":"Batch order has been deleted."
}
```
