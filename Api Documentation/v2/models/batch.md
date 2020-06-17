# Batch

Batch model.

**Column**

* `id` = **integer** | **auto increment**
* `source_id` = **integer(20)**
* `clinician_id` = **integer(20)**
* `patient_type_id` = **integer(20)**
* `client_id` = **integer(20)**
* `dispatcher_id` = **integer(20)**
* `code` = **string(255)**
* `payment_mode` = **tinyinteger(1)**
* `status` = **tinyinteger(1)**
* `slides` = **integer**
* `blood` = **integer**
* `forms` = **integer**
* `specimen` = **integer**
* `updated_at` = **timestamp**
* `created_at` = **timestamp**

**Column variables**

* `status` = values:
   * `0` = **Draft** Status
   * `1` = **Confirmed** Status  
   * `2` = **Accomplished** Status


* `payment_mode` = values:
    * `0` = **CASH**
    * `1` = **CHARGE**
