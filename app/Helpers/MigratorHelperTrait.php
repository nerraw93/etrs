<?php

namespace App\Helpers;

use DB;
use Str;
use App\Models\User;

/**
 * Trait helper to be used on migrator
 * Mostly accesor from old database data and query on new data
 *
 * @author goper
 */
trait MigratorHelperTrait {

    /**
     * Get id from old database to new one
     *
     * @param  string $table     [description]
     * @param  string $value     [description]
     * @param  string $attribute [description]
     * @return string            [description]
     */
    private function getDataFromOldToNew($table, $value, $attribute, $column = 'id')
    {
        $oldData = (array) $this->connection->table($table)->where($column, $value)->first();
        if(!$oldData) {
            return null;
        }
        $newData = DB::table($table)->where($attribute, $oldData[$attribute])->first();
        return $newData;
    }

    /**
     * Get batch orders from this batch
     *
     * @param  integer $id
     * @return object
     */
    public function getBatchOrders($id)
    {
        $orders = $this->connection->table('batch_lab_transactions')->where('batchid', $id)->get();
        return $orders;
    }

    /**
     * Get batch order data
     *
     * @param  integer $id
     * @return object
     */
    public function getBatchOrderData($transaction_id)
    {
        $data = $this->connection->table('lab_transactions')->where('id', $transaction_id)->first();
        return $data;
    }

    /**
     * Get patient type
     *
     * @param  string $name
     * @return object
     */
    public function getPatientTypes($name)
    {
        return \App\Models\PatientType::where('name', $name)->first();
    }

    /**
     * Get dispatcher ID based on mode given
     *
     * @param  string $mode
     * @return ingeteger
     */
    private function getDispatherId($mode)
    {
        $mode = strtoupper($mode);
        return \App\Models\Dispatcher::where('name', $mode)->first()->id;
    }

    /**
     * Get userId from new database
     * Get user data from old database - using their userId
     *
     * @param  string $email
     * @return string
     */
    private function getUser($old_user_id)
    {
        $oldUserEmail = $this->connection->table('users')->where('id', $old_user_id)->first()->emailAddress;
        $newDbUser = User::where('email', $oldUserEmail)->first();
        return $newDbUser;
    }

    /**
     * Get all data from table given - on old database
     *
     * @param  string $table
     * @return void
     */
    private function getDataFromTable($table, $orderBy = '')
    {
        $data = $this->connection->table($table);
        if ($orderBy != '') {
            $data = $data->orderBy($orderBy, 'DESC');
        }
        
        $data = $data->get();
        $count = $data->count();
        $this->comment("Start seeding `$table` table............... $count rows.");
        return $data;
    }

    /**
     * Get patient data
     *
     * @param  integer $id
     * @return void
     */
    public function getPatient($id)
    {
        $oldUserEmail = $this->connection->table('client_patients')->where('id', $id)->first()->emailAddress;
        $newDbUser = \App\Models\Patient::where('email', $oldUserEmail)->first();
        return $newDbUser;
    }
}
