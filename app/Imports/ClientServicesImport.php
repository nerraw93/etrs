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
    protected $source;

    public function __construct($source)
    {
        $this->source = $source;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $id = preg_match('/client\/(.*)\/services/', request()->path(), $matches);

        $service = Service::where('code', $row['code'])->first();

        if ($service) {
            $this->save($service, $row, $matches);
        }
        /*else {
            dd($row['code']);
            $service = Service::create([
                'code' => $row['code'],
                'name' => $row['name'],
                'default_cost' => $row['defaultcost'],
            ]);

            $this->save($service, $row, $matches);
        }*/
    }

    public function save($service, $row, $matches)
    {
        $path = explode("/", $matches[1]);

        $check = ClientSourceService::where([
            'source_id' => $this->source,
            'service_id' => $service->id, 
            'user_id' => get_user_id($path[0])
        ])->count();

        if ($check == 0) {
            ClientSourceService::create([
                'source_id' => $this->source,
                'service_id'     => $service->id,
                'user_id'    => get_user_id($path[0]),
                'price' => $row['defaultcost'],
            ]);
        }
    }
}
