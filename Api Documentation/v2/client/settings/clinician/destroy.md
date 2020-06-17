# Destory client clinician

#### (**Client Only**)

Delete client patient

**URL** : `/api/client/settings/clinician/:id/destroy`

**Params**
1. **id** = Clinician Id

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
    "message":"Clinician has been deleted."
}
```
