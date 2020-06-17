<?php

namespace Tests\Traits;

/**
 * Response structure
 *
 * @author goper
 */
trait ReponseStructure {

    public function userResponseStructure()
    {
        return [
            "id",
            "globalPrefix",
            "code",
            "type",
            "paymentMode",
            "emailAddress",
            "firstName",
            "lastName",
            "username",
            "businessName",
            "businessAddress",
            "contactNumber",
            "active",
            "createdAt",
            "updatedAt"
        ];
    }

    public function patientResponseStructure() {
        return [
            "id",
            "code",
            "globalCustomId",
            "clientCustomId",
            "emailAddress",
            "firstName",
            "middleName",
            "lastName",
            "gender",
            "age",
            "birthDateAsTimestamp",
            "birthDate",
            "passportNumber",
            "citizen",
            "bloodType",
            "mothersMaidenName",
            "address",
            "city",
            "seniorCitizenId",
            "telNumber",
            "faxNumber",
            "mobileNumber",
            "occupation",
            "hmoCard",
            "hmoCardNo",
            "lastVisitAt",
            "archivedAt",
            "createdAt",
            "updatedAt",
            "client" => $this->userResponseStructure(),
        ];
    }

    public function batchResponseStructure()
    {
        return [
            "id",
            "code",
            "source",
            "clinician",
            "dispatchMode",
            "patientType",
            "paymentMode",
            "status",
            "tag",
            "slides",
            "blood",
            "forms",
            "specimen",
            "encodedBy",
            "createdAt",
            "updatedAt",
            "createdBy",
            "transactionsCount",
            "labTestsCount",
            "reportId",
            "transactions",
        ];
    }

    public function batchOrderResponseStructure()
    {
        return [
            "id",
            "idPrefix",
            "patient",
            "clinicalInformation",
            "specialInstructions",
            "orNumber",
            "client",
            "status",
            "isUrgent",
            "tests",
            "createdAt",
        ];
    }

    public function ipWhiteListResponseStructure($noUser = true)
    {
        if ($noUser) {
            return [
                "id",
                "user",
                "address",
            ];
        } else {
            return [
                "id",
                "user" => $this->userResponseStructure(),
                "address",
            ];
        }
    }

    public function errorResponseStructure()
    {
        return [
            "code",
            "message"
        ];
    }

}
