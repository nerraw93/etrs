<?php

namespace App\Imports;

use App\Models\ClientService;
use App\Models\ClientSourceService;
use App\Models\Service;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientServicesImport implements OnEachRow, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $service = Service::where('code', $row['code'])->first();

        if ($service) {
            $id = preg_match('/client\/(.*)\/services/', request()->path(), $matches);
            $check = ClientSourceService::where([
                'source_id' => $row['source'],
                'service_id' => $service->id, 
                'user_id' => get_user_id($matches[1])
            ])->count();

            if ($check == 0) {
                ClientSourceService::create([
                    'source_id' => $row['source'],
                    'service_id'     => $service->id,
                    'user_id'    => get_user_id($matches[1]),
                    'price' => $row['defaultcost'],
                ]);
            }
        }
    }
}
