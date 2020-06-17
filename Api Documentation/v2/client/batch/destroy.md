# Batch delete

#### (**Client Only**)

Delete client batch

**URL** : `/api/client/batch/:id/destroy`

**Params**
1. **id** = batch id

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
    "message":"Processor has been deleted."
}
```
