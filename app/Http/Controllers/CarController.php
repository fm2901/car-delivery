<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Photo;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\View\View;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::all();
        return view('cars.list', ['cars' => $cars]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        $photos = $car->photos()->get();
        //$photos = Photo::where('car_id', $car->vincode);
        dd($photos);


       // return view('cars.edit', ['car' => $car]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        //
    }

    public function importForm()
    {
        return view('cars.import');
    }

    public function import()
    {
        $car = new Car();
        $car->importExcel($_FILES['import']['tmp_name']);

        return redirect(route('cars.index'));
    }

    public function addPhoto(Request $request)
    {
        Photo::addPhoto($request);
        return redirect(route('cars.index'));
    }


    public function getCars(Request $request)
    {
        $length = $request->query->getInt("length");
        if ($request->ajax()) {
            $records = Car::getCarsForDT($request);
            return Datatables::of($records["data"])
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action','photo'])
                ->setFilteredRecords($records["recordsFiltered"])
                ->setTotalRecords($records["recordsTotal"])
                ->make(true);
        }
    }
}
