<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'name', 'car_id'];

    static function addPhoto(Request $request) {
        $carID = $request->input('car_id');
        $files = $request->file('carPhoto');
        foreach($files as $file) {
            $fileName = $file->getClientOriginalName();
            $fileContent = file_get_contents($file->getRealPath());
            $filePath = time()."_".$fileName;
            Storage::put($filePath, $fileContent);
            $photo = new Photo([
                'path'   => $filePath,
                'name'   => $fileName,
                'car_id' => $carID
            ]);
            $photo->save();
        }
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
