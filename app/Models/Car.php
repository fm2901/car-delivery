<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['lot','saledate','container','name','vincode','warehouse','owner'];
    protected $primaryKey = 'vincode';
    public $incrementing = false;
    protected $keyType = 'string';

    function importExcel($path) {
        $spreadsheet = IOFactory::load($path);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        foreach($sheetData as $k=>$d) {
            if ($k == 1) {
                continue;
            }
            $saleDate = Carbon::parse($d['B'])->format('Y-m-d');
            $car = Car::where('vincode', $d['E'])->first();
            if($car === null) {
                $car = new Car([
                    'lot'       => $d['A'],
                    'saledate'  => $saleDate,
                    'container' => $d['C'],
                    'name'      => $d['D'],
                    'vincode'   => $d['E'],
                    'warehouse' => $d['F'],
                    'owner'     => $d['G']
                ]);
                $car->save();
            } else {
                $car->lot        = $d['A'];
                $car->saledate   = $saleDate;
                $car->container  = $d['C'];
                $car->name       = $d['D'];
                $car->warehouse  = $d['F'];
                $car->owner      = $d['G'];
                $car->update();
            }
        }
    }

    public static function getCarsForDT($request) {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[1]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Car::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Car::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        $limit = $totalRecords - $start;

        // Fetch records
        $records = Car::orderBy($columnName,$columnSortOrder)
            //->with('photos', 'photos.car')
            ->where('cars.name', 'like', '%' .$searchValue . '%')
            ->select('cars.*')
            ->skip($start)
            ->take($limit)
            ->get();

        foreach ($records as $k=>$v) {
            $photos = DB::table("photos")->
            where("car_id", "2T1BU4EE5BC561313")->get();
            $records[$k]["photo"] .= '';
            foreach ($photos as $photo) {
                $records[$k]["photo"] .= '<img width="50%" src="public/cars/' . $photo->path . '" alt="' . $photo->name . '">';
            }
        }

        return [
            "draw" => intval(request('draw')),
            "recordsTotal"    => intval($totalRecords),
            "recordsFiltered" => intval($totalRecordswithFilter),
            "start" => $start,
            "limit" => $limit,
            "data" => $records
        ];
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'car_id');
    }

}
